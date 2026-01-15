<?php

declare(strict_types=1);

namespace App\Module\Asset\Services;

use App\Application\Asset\Command\UpdateAssetCommand;
use App\Application\Transaction\Command\CreateTransactionCommand;
use App\Application\Transaction\Command\UpdateTransactionStatusCommand;
use App\Application\Wallet\Command\UpdateWalletBalanceCommand;
use App\CQRS\CommandBus;
use App\CQRS\CommandBusInterface;
use App\CQRS\TransactionResultCollector;
use App\Models\Asset;
use App\Module\Asset\DTO\UpdateAssetDto;
use App\Module\Transaction\Enums\TransactionStatusEnum;
use App\Module\Transaction\Enums\TransactionTypeEnum;
use App\Shared\Exceptions\CurrencyMismatchException;
use App\Shared\Exceptions\NegativeAmountException;
use App\Shared\ValueObjects\Money;
use Illuminate\Container\Attributes\Give;
use Throwable;

final readonly class UpdateAssetWithWalletService
{
    public function __construct(
        #[Give(CommandBus::class)] private CommandBusInterface $commandBus,
    )
    {
    }

    /**
     * @throws Throwable
     * @throws NegativeAmountException
     * @throws CurrencyMismatchException
     */
    public function execute(Asset $asset, UpdateAssetDto $dto): void
    {
        $wallet = $asset->user->wallet;

        $oldPrice = $asset->price;
        $newPrice = Money::of($dto->price);

        $absoluteDifference = $newPrice->absoluteDifference($oldPrice);

        $isDebit = $newPrice->isLessThan($oldPrice);

        $transactionType = $isDebit
            ? TransactionTypeEnum::DEBIT
            : TransactionTypeEnum::CREDIT;

        $commands = [
            new UpdateAssetCommand(
                $asset->id,
                $dto->originalName,
                $dto->name,
                $dto->inventoryNumber,
                $newPrice->getAmountInDecimal(),
                $dto->quantity,
                $dto->dateRegistration
            ),
            new CreateTransactionCommand(
                $wallet->id,
                $absoluteDifference,
                $transactionType,
            ),
            new UpdateWalletBalanceCommand(
                $wallet->id,
                $absoluteDifference,
                $transactionType
            )
        ];

        $this->commandBus->dispatchInTransactionWithAfterCommitCallback(
            $commands,
            function(TransactionResultCollector $collector) {
                $transaction = $collector->get(1);
                $this->commandBus->dispatch(
                    new UpdateTransactionStatusCommand(
                        $transaction->id,
                        TransactionStatusEnum::COMPLETED
                    )
                );
            },
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Module\Asset\Orchestrators;

use App\Application\Asset\Command\CreateAssetCommand;
use App\Application\Transaction\Command\CreateTransactionCommand;
use App\Application\Transaction\Command\UpdateTransactionStatusCommand;
use App\Application\Wallet\Command\UpdateWalletBalanceCommand;
use App\CQRS\CommandBus;
use App\CQRS\CommandBusInterface;
use App\CQRS\TransactionResultCollector;
use App\Models\Asset;
use App\Models\Transaction;
use App\Module\Asset\DTO\CreateAssetDto;
use App\Module\Transaction\Enums\TransactionStatusEnum;
use App\Module\Transaction\Enums\TransactionTypeEnum;
use Illuminate\Container\Attributes\Give;
use Throwable;

final readonly class CreateAssetOrchestrator
{
    public function __construct(
        #[Give(CommandBus::class)] private CommandBusInterface $commandBus,
    )
    {
    }

    /**
     * @throws Throwable
     */
    public function execute(CreateAssetDto $dto): void
    {
        $commands = [
            new CreateAssetCommand(
                $dto->originalName,
                $dto->name,
                $dto->inventoryNumber,
                $dto->price,
                $dto->quantity,
                $dto->dateRegistration
            ),
            function(TransactionResultCollector $collector) {
                /** @var Asset $asset */
                $asset = $collector->first();
                return new CreateTransactionCommand(
                    $asset->user->wallet?->id,
                    $asset->price,
                    TransactionTypeEnum::CREDIT,
                );
            },
            function(TransactionResultCollector $collector) {
                /** @var Asset $asset */
                $asset = $collector->first();
                return new UpdateWalletBalanceCommand(
                    $asset->user->wallet->id,
                    $asset->price,
                    TransactionTypeEnum::CREDIT
                );
            }
        ];

        $this->commandBus->dispatchInTransactionWithAfterCommitCallback(
            $commands,
            function(TransactionResultCollector $collector) {
                /** @var Transaction $transaction */
                $transaction = $collector->get(1);
                $this->commandBus->dispatch(
                    new UpdateTransactionStatusCommand(
                        $transaction->id,
                        TransactionStatusEnum::COMPLETED
                    )
                );
            }
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Module\Asset\Orchestrators;

use App\Application\Asset\Command\DeleteAssetCommand;
use App\Application\Transaction\Command\CreateTransactionCommand;
use App\Application\Transaction\Command\UpdateTransactionStatusCommand;
use App\Application\Wallet\Command\UpdateWalletBalanceCommand;
use App\CQRS\CommandBus;
use App\CQRS\CommandBusInterface;
use App\CQRS\TransactionResultCollector;
use App\Models\Asset;
use App\Module\Transaction\Enums\TransactionStatusEnum;
use App\Module\Transaction\Enums\TransactionTypeEnum;
use Illuminate\Container\Attributes\Give;
use Throwable;

final readonly class DestroyAssetOrchestrator
{
    public function __construct(
        #[Give(CommandBus::class)] private CommandBusInterface $commandBus,
    )
    {
    }

    /**
     * @throws Throwable
     */
    public function execute(Asset $asset): void
    {
        $wallet = $asset->user->wallet;

        $commands = [
            new DeleteAssetCommand($asset->id),
            new CreateTransactionCommand(
                $wallet->id,
                $asset->price,
                TransactionTypeEnum::DEBIT,
            ),
            new UpdateWalletBalanceCommand(
                $wallet->id,
                $asset->price,
                TransactionTypeEnum::DEBIT
            ),
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
            }
        );
    }
}

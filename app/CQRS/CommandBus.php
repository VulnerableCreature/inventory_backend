<?php

declare(strict_types=1);

namespace App\CQRS;

use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Facades\DB;

final readonly class CommandBus implements CommandBusInterface
{
    public function __construct(
        private Dispatcher $dispatcher,
    )
    {
    }

    public function dispatch(CommandInterface $command): mixed
    {
        return $this->dispatcher->dispatch($command);
    }

    public function dispatchInTransaction(array $commands): TransactionResultCollector
    {
        return DB::transaction(function() use ($commands) {
            $collector = new TransactionResultCollector();

            foreach ($commands as $command) {
                if (is_callable($command)) {
                    $command = $command($collector);
                }
                $collector->add($this->dispatch($command));
            }

            return $collector;
        });
    }

    public function dispatchInTransactionWithAfterCommitCallback(array $commands, callable $afterCommit): TransactionResultCollector
    {
        return DB::transaction(function() use ($commands, $afterCommit) {
            $collector = new TransactionResultCollector();

            foreach ($commands as $command) {
                if (is_callable($command)) {
                    $command = $command($collector);
                }
                $collector->add($this->dispatch($command));
            }

            DB::afterCommit(fn() => $afterCommit($collector));

            return $collector;
        });
    }
}

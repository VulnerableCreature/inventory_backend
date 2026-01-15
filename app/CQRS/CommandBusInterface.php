<?php

namespace App\CQRS;

use Throwable;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): mixed;

    /**
     * Обработка пачки команд с использованием транзакции для атомарности
     *
     * @param CommandInterface[] $commands
     *
     * @return TransactionResultCollector Результаты выполнения всех команд
     * @throws Throwable
     */
    public function dispatchInTransaction(array $commands): TransactionResultCollector;

    /**
     * Обработка пачки команд с использованием транзакции для атомарности,
     * но с возможностью выполнить какое-то действие после самой транзакции
     *
     * @param CommandInterface[] $commands
     * @param callable           $afterCommit Действие после успешной транзакции
     *
     * @return TransactionResultCollector Коллектор, который собирает результаты транзакций для передачи данных
     *                                    в другие команды вызываемые по очереди
     * @throws Throwable
     */
    public function dispatchInTransactionWithAfterCommitCallback(array $commands, callable $afterCommit): TransactionResultCollector;
}

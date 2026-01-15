<?php

declare(strict_types=1);

namespace App\CQRS;

use Illuminate\Contracts\Bus\Dispatcher;

final readonly class QueryBus implements QueryBusInterface
{
    public function __construct(
        private Dispatcher $dispatcher,
    )
    {
    }

    public function ask(QueryInterface $query): mixed
    {
        return $this->dispatcher->dispatch($query);
    }
}

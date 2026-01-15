<?php

namespace App\Http\Controllers;

use App\CQRS\CommandBusInterface;
use App\CQRS\QueryBusInterface;

abstract class Controller
{
    public function __construct(
        protected readonly CommandBusInterface $commandBus,
        protected readonly QueryBusInterface   $queryBus,
    )
    {
    }
}

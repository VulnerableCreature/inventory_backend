<?php

namespace App\CQRS;

interface QueryBusInterface
{
    public function ask(QueryInterface $query): mixed;
}

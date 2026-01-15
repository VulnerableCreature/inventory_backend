<?php

declare(strict_types=1);

namespace App\CQRS;

use OutOfBoundsException;

final class TransactionResultCollector
{
    private array $results = [];

    public function add(mixed $result): self
    {
        $this->results[] = $result;
        return $this;
    }

    public function get(int $index): mixed
    {
        if (!isset($this->results[$index])) {
            throw new OutOfBoundsException("Result at index $index not found");
        }

        return $this->results[$index];
    }

    public function first(): mixed
    {
        return $this->get(0);
    }
}

<?php

declare(strict_types=1);

namespace App\Application\Asset\Query;

use App\CQRS\QueryInterface;

final readonly class GetAllAssetsQuery implements QueryInterface
{
    public function __construct(public array $filters = [])
    {
    }
}

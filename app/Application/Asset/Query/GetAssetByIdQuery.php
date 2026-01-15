<?php

declare(strict_types=1);

namespace App\Application\Asset\Query;

use App\CQRS\QueryInterface;

final readonly class GetAssetByIdQuery implements QueryInterface
{
    public function __construct(public int $id)
    {
    }
}

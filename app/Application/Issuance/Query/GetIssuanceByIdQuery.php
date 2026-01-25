<?php

declare(strict_types=1);

namespace App\Application\Issuance\Query;

use App\CQRS\QueryInterface;

final readonly class GetIssuanceByIdQuery implements QueryInterface
{
    public function __construct(public int $id)
    {
    }
}

<?php

declare(strict_types=1);

namespace App\Module\Asset;

use App\Shared\Filter;
use Illuminate\Database\Eloquent\Builder;

final readonly class AssetFilter extends Filter
{
    protected function status(Builder $query, mixed $value): void
    {
        $query->where('status', '=', $value);
    }

    protected function quantity(Builder $query, mixed $value): void
    {
        $query->where('quantity', '=', $value);
    }

    protected function inventory_number(Builder $query, mixed $value): void
    {
        $query->where('inventory_number', 'like', "%$value%");
    }
}

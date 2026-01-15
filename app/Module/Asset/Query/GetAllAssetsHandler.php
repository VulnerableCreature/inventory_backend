<?php

declare(strict_types=1);

namespace App\Module\Asset\Query;

use App\Application\Asset\Query\GetAllAssetsQuery;
use App\Models\Asset;
use App\Module\Asset\AssetFilter;
use App\Module\Asset\Enums\StatusEnum;
use Illuminate\Support\Collection;

final readonly class GetAllAssetsHandler
{
    public function handle(GetAllAssetsQuery $assetsQuery): Collection
    {
        $query = Asset::query()->with(['user.profile']);

        if (!empty($assetsQuery->filters)) {
            $filter = new AssetFilter($assetsQuery->filters);
            $filter->apply($query);
        }

        $query->orderByRaw("
            CASE
                WHEN quantity > 0 AND status = ? AND inventory_number IS NOT NULL THEN 1
                WHEN quantity > 0 AND status = ? AND inventory_number IS NULL THEN 2
                WHEN quantity < 1 AND status = ? AND inventory_number IS NOT NULL THEN 3
                WHEN quantity < 1 AND status = ? AND inventory_number IS NULL THEN 4
                WHEN status = ? THEN 5
            END ASC
        ", [
            StatusEnum::IN_STOCK->value,
            StatusEnum::IN_STOCK->value,
            StatusEnum::ENDED->value,
            StatusEnum::ENDED->value,
            StatusEnum::DISPOSAL->value,
        ]);

        return $query->orderByDesc('created_at')->get();
    }
}

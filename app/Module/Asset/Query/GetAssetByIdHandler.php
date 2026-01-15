<?php

declare(strict_types=1);

namespace App\Module\Asset\Query;

use App\Application\Asset\Query\GetAssetByIdQuery;
use App\Models\Asset;

final readonly class GetAssetByIdHandler
{
    public function handle(GetAssetByIdQuery $query): Asset
    {
        return Asset::query()->with(['user.profile'])->findOrFail($query->id);
    }
}

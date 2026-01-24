<?php

namespace App\Http\Controllers\Main\Asset;

use App\Application\Asset\Query\GetAllAssetsQuery;
use App\Application\Asset\Query\GetAssetByIdQuery;
use App\CQRS\CommandBusInterface;
use App\CQRS\QueryBusInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\AssetFilterRequest;
use App\Http\Requests\Asset\CreateAssetRequest;
use App\Http\Requests\Asset\UpdateAssetRequest;
use App\Http\Resources\Asset\AssetCollection;
use App\Http\Resources\Asset\AssetResource;
use App\Models\Asset;
use App\Module\Asset\Orchestrators\CreateAssetOrchestrator;
use App\Module\Asset\Orchestrators\DestroyAssetOrchestrator;
use App\Module\Asset\Orchestrators\UpdateAssetOrchestrator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class AssetController extends Controller
{
    public function __construct(
        CommandBusInterface                       $commandBus,
        QueryBusInterface                         $queryBus,
        private readonly CreateAssetOrchestrator  $createAssetOrchestrator,
        private readonly UpdateAssetOrchestrator  $updateAssetOrchestrator,
        private readonly DestroyAssetOrchestrator $destroyAssetOrchestrator,
    )
    {
        parent::__construct($commandBus, $queryBus);
    }

    public function index(AssetFilterRequest $request): AssetCollection
    {
        $assets = $this->queryBus->ask(new GetAllAssetsQuery($request->filters()));
        return new AssetCollection($assets);
    }

    public function show(int $id): AssetResource
    {
        $asset = $this->queryBus->ask(new GetAssetByIdQuery($id));
        return new AssetResource($asset);
    }

    /**
     * @throws Throwable
     */
    public function store(CreateAssetRequest $request): JsonResponse
    {
        $dto = $request->toDto();

        $this->createAssetOrchestrator->execute($dto);

        return response()->json([
            'message' => 'Asset created successfully'
        ], status: 201);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateAssetRequest $request, int $id): JsonResponse
    {
        $dto = $request->toDto();

        /** @var Asset $asset */
        $asset = $this->queryBus->ask(new GetAssetByIdQuery($id));

        Gate::authorize('update-asset', $asset);

        $asset = $this->updateAssetOrchestrator->execute($asset, $dto);

        return response()->json(new AssetResource($asset));
    }

    /**
     * @throws Throwable
     */
    public function destroy(int $id): JsonResponse
    {
        /** @var Asset $asset */
        $asset = $this->queryBus->ask(new GetAssetByIdQuery($id));

        Gate::authorize('delete-asset', $asset);

        $this->destroyAssetOrchestrator->execute($asset);
        return response()->json([
            'message' => 'The record was successfully deleted'
        ]);
    }
}

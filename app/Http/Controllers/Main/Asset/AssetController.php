<?php

namespace App\Http\Controllers\Main\Asset;

use App\Application\Asset\Command\CreateAssetCommand;
use App\Application\Asset\Command\DeleteAssetCommand;
use App\Application\Asset\Query\GetAllAssetsQuery;
use App\Application\Asset\Query\GetAssetByIdQuery;
use App\Application\Transaction\Command\CreateTransactionCommand;
use App\Application\Transaction\Command\UpdateTransactionStatusCommand;
use App\Application\Wallet\Command\UpdateWalletBalanceCommand;
use App\CQRS\CommandBusInterface;
use App\CQRS\QueryBusInterface;
use App\CQRS\TransactionResultCollector;
use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\AssetFilterRequest;
use App\Http\Requests\Asset\CreateAssetRequest;
use App\Http\Requests\Asset\UpdateAssetRequest;
use App\Http\Resources\Asset\AssetCollection;
use App\Http\Resources\Asset\AssetResource;
use App\Models\Asset;
use App\Models\Transaction;
use App\Module\Asset\Services\UpdateAssetWithWalletService;
use App\Module\Transaction\Enums\TransactionStatusEnum;
use App\Module\Transaction\Enums\TransactionTypeEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class AssetController extends Controller
{
    public function __construct(
        CommandBusInterface                           $commandBus,
        QueryBusInterface                             $queryBus,
        private readonly UpdateAssetWithWalletService $updateAssetWithWalletService,
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

        $commands = [
            new CreateAssetCommand(
                $dto->originalName,
                $dto->name,
                $dto->inventoryNumber,
                $dto->price,
                $dto->quantity,
                $dto->dateRegistration
            ),
            function(TransactionResultCollector $collector) {
                /** @var Asset $asset */
                $asset = $collector->first();
                return new CreateTransactionCommand(
                    $asset->user->wallet?->id,
                    $asset->price,
                    TransactionTypeEnum::CREDIT,
                );
            },
            function(TransactionResultCollector $collector) {
                /** @var Asset $asset */
                $asset = $collector->first();
                return new UpdateWalletBalanceCommand(
                    $asset->user->wallet->id,
                    $asset->price,
                    TransactionTypeEnum::CREDIT
                );
            }
        ];

        $this->commandBus->dispatchInTransactionWithAfterCommitCallback(
            $commands,
            function(TransactionResultCollector $collector) {
                /** @var Transaction $transaction */
                $transaction = $collector->get(1);
                $this->commandBus->dispatch(
                    new UpdateTransactionStatusCommand(
                        $transaction->id,
                        TransactionStatusEnum::COMPLETED
                    )
                );
            }
        );

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

        $this->updateAssetWithWalletService->execute($asset, $dto);

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

        $wallet = $asset->user->wallet;

        $commands = [
            new DeleteAssetCommand($asset->id),
            new CreateTransactionCommand(
                $wallet->id,
                $asset->price,
                TransactionTypeEnum::DEBIT,
            ),
            new UpdateWalletBalanceCommand(
                $wallet->id,
                $asset->price,
                TransactionTypeEnum::DEBIT
            ),
        ];

        $this->commandBus->dispatchInTransactionWithAfterCommitCallback(
            $commands,
            function(TransactionResultCollector $collector) {
                $transaction = $collector->get(1);
                $this->commandBus->dispatch(
                    new UpdateTransactionStatusCommand(
                        $transaction->id,
                        TransactionStatusEnum::COMPLETED
                    )
                );
            }
        );

        return response()->json([
            'message' => 'The record was successfully deleted'
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Module\Issuance\Orchestrators;

use App\Application\Asset\Command\UpdateAssetQuantityCommand;
use App\Application\Asset\Command\UpdateAssetStatusCommand;
use App\Application\Asset\Query\GetAssetByIdQuery;
use App\Application\Issuance\Command\UpdateIssuanceAssetCommand;
use App\Application\Issuance\Command\UpdateIssuanceCommentCommand;
use App\Application\Issuance\Command\UpdateIssuanceDeviceCommand;
use App\Application\Issuance\Command\UpdateIssuanceIssuableCommand;
use App\Application\Issuance\Command\UpdateIssuanceIssuedAtCommand;
use App\Application\Issuance\Command\UpdateIssuanceQuantityCommand;
use App\Application\Issuance\Command\UpdateIssuanceRoomCommand;
use App\Application\Room\Query\GetRoomByIdQuery;
use App\CQRS\CommandBus;
use App\CQRS\CommandBusInterface;
use App\CQRS\QueryBus;
use App\CQRS\QueryBusInterface;
use App\CQRS\TransactionResultCollector;
use App\Models\Asset;
use App\Models\Issuance;
use App\Models\Room;
use App\Module\Asset\Enums\OperationEnum;
use App\Module\Asset\Exceptions\InsufficientAssetStockException;
use App\Module\Issuance\DTO\UpdateIssuanceDto;
use App\Module\Issuance\Exceptions\IssuanceTargetTypeImmutableException;
use App\Module\Issuance\Exceptions\RoomNotAssignedToIssuableException;
use App\Module\Issuance\Traits\ResolvableIssuableTrait;
use Illuminate\Container\Attributes\Give;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class UpdateIssuanceOrchestrator
{
    use ResolvableIssuableTrait;

    public function __construct(
        #[Give(CommandBus::class)] private CommandBusInterface $commandBus,
        #[Give(QueryBus::class)] private QueryBusInterface     $queryBus,
    )
    {
    }

    /**
     * @throws RoomNotAssignedToIssuableException
     * @throws IssuanceTargetTypeImmutableException
     * @throws Throwable
     */
    public function execute(UpdateIssuanceDto $dto, int $id): void
    {
        DB::transaction(function() use ($dto, $id) {
            /** @var Issuance $issuance */
            $issuance = Issuance::query()->lockForUpdate()->find($id);

            if (is_null($issuance->device_id) && !is_null($dto->deviceId)) {
                throw new IssuanceTargetTypeImmutableException();
            }

            $commands = [];

            $newIssuable = null;

            if (
                $issuance->issuable_id !== $dto->issuableId ||
                $issuance->issuable_type !== $dto->issuableType
            ) {
                $newIssuable = $this->resolveIssuable($dto->issuableType, $dto->issuableId);
                $commands[] = new UpdateIssuanceIssuableCommand($issuance, $newIssuable);
            }

            $currentIssuableForCheck = $newIssuable ?? $issuance->issuable;


            /** @var Asset $newAsset */
            $newAsset = $this->queryBus->ask(new GetAssetByIdQuery($dto->assetId));

            if ($newAsset->id !== $issuance->asset_id) {
                if ($newAsset->quantity < $dto->quantity) {
                    throw new InsufficientAssetStockException($dto->quantity, $newAsset->quantity);
                }

                $oldAsset = $issuance->asset;

                $commands[] = new UpdateAssetQuantityCommand($oldAsset, $issuance->quantity, OperationEnum::CREDIT);

                $commands[] = function(TransactionResultCollector $collector) {
                    /** @var Asset $updatedOldAsset */
                    $updatedOldAsset = $collector->last();

                    return new UpdateAssetStatusCommand($updatedOldAsset);
                };

                $commands[] = new UpdateAssetQuantityCommand($newAsset, $dto->quantity, OperationEnum::DEBIT);

                $commands[] = function(TransactionResultCollector $collector) {
                    /** @var Asset $updatedNewAsset */
                    $updatedNewAsset = $collector->last();

                    return new UpdateAssetStatusCommand($updatedNewAsset);
                };

                $commands[] = new UpdateIssuanceAssetCommand($issuance, $newAsset);

                if ($issuance->quantity !== $dto->quantity) {
                    $commands[] = new UpdateIssuanceQuantityCommand($issuance, $dto->quantity);
                }
            } else if ($issuance->quantity !== $dto->quantity) {
                $difference = $dto->quantity - $issuance->quantity;

                if ($difference > 0) {
                    if ($newAsset->quantity < $difference) {
                        throw new InsufficientAssetStockException($difference, $newAsset->quantity);
                    }
                    $commands[] = new UpdateAssetQuantityCommand($newAsset, $difference, OperationEnum::DEBIT);
                } else {
                    $commands[] = new UpdateAssetQuantityCommand($newAsset, abs($difference), OperationEnum::CREDIT);
                }

                $commands[] = function(TransactionResultCollector $collector) {
                    /** @var Asset $updatedAsset */
                    $updatedAsset = $collector->last();
                    return new UpdateAssetStatusCommand($updatedAsset);
                };

                $commands[] = new UpdateIssuanceQuantityCommand($issuance, $dto->quantity);
            }

            $newRoom = null;

            if ($issuance->room_id !== $dto->roomId) {
                /** @var Room $newRoom */
                $newRoom = $this->queryBus->ask(new GetRoomByIdQuery($dto->roomId));

                $isAssigned = $currentIssuableForCheck->rooms()
                    ->where('rooms.id', $newRoom->id)
                    ->exists();

                if (!$isAssigned) {
                    throw new RoomNotAssignedToIssuableException($newRoom->id);
                }

                $commands[] = new UpdateIssuanceRoomCommand($issuance, $newRoom);
            }


            $newDevice = null;

            if ($issuance->hasDevice() && $issuance->device_id !== $dto->deviceId) {
                $newDevice = $this->queryBus->ask(new GetAssetByIdQuery($dto->deviceId));

                $commands[] = new UpdateIssuanceDeviceCommand($issuance, $newDevice);
            }


            if ($issuance->issued_at->format('Y-m-d') !== $dto->issuedAt->format('Y-m-d')) {
                $commands[] = new UpdateIssuanceIssuedAtCommand($issuance, $dto->issuedAt);
            }

            if (
                $newAsset->id !== $issuance->asset_id ||
                $issuance->room_id !== $dto->roomId ||
                $issuance->issuable_id !== $dto->issuableId ||
                $issuance->issuable_type !== $dto->issuableType
            ) {
                $commands[] = new UpdateIssuanceCommentCommand(
                    $issuance,
                    $newAsset,
                    $newRoom ?? $issuance->room,
                    $newDevice ?? $issuance->device,
                    $currentIssuableForCheck ?? $issuance->issuable
                );
            }

            $this->commandBus->dispatchInTransaction($commands);
        });
    }
}

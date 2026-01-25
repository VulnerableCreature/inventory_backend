<?php

declare(strict_types=1);

namespace App\Module\Issuance\Orchestrators;

use App\Application\Asset\Command\UpdateAssetQuantityCommand;
use App\Application\Asset\Command\UpdateAssetStatusCommand;
use App\Application\Asset\Query\GetAssetByIdQuery;
use App\Application\Issuance\Command\CreateIssuanceCommand;
use App\Application\Issuance\Command\CreateIssuanceCommentCommand;
use App\Application\Room\Query\GetRoomByIdQuery;
use App\CQRS\CommandBus;
use App\CQRS\CommandBusInterface;
use App\CQRS\QueryBus;
use App\CQRS\QueryBusInterface;
use App\CQRS\TransactionResultCollector;
use App\Models\Asset;
use App\Models\Room;
use App\Module\Asset\Enums\OperationEnum;
use App\Module\Asset\Exceptions\InsufficientAssetStockException;
use App\Module\Issuance\DTO\CreateIssuanceDto;
use App\Module\Issuance\Traits\ResolvableIssuableTrait;
use Illuminate\Container\Attributes\Give;
use Throwable;

final readonly class CreateIssuanceOrchestrator
{
    use ResolvableIssuableTrait;

    public function __construct(
        #[Give(CommandBus::class)] private CommandBusInterface $commandBus,
        #[Give(QueryBus::class)] private QueryBusInterface     $queryBus,
    )
    {
    }

    /**
     * @throws Throwable
     */
    public function execute(CreateIssuanceDto $dto): void
    {
        /** @var Asset $asset */
        $asset = $this->queryBus->ask(new GetAssetByIdQuery($dto->assetId));

        if ($asset->quantity < $dto->quantity) {
            throw new InsufficientAssetStockException($dto->quantity, $asset->quantity);
        }

        /** @var Room $room */
        $room = $this->queryBus->ask(new GetRoomByIdQuery($dto->roomId));

        /** @var Asset|null $device */
        $device = $dto->deviceId === null ? null : $this->queryBus->ask(new GetAssetByIdQuery($dto->deviceId));
        $issuable = $this->resolveIssuable($dto->issuableType, $dto->issuableId);

        $commands = [
            new UpdateAssetQuantityCommand($asset, $dto->quantity, OperationEnum::DEBIT),
            function(TransactionResultCollector $collector) {
                /** @var Asset $asset */
                $asset = $collector->first();
                return new UpdateAssetStatusCommand($asset);
            },
            function(TransactionResultCollector $collector) use ($room, $device, $issuable) {
                $asset = $collector->get(1);
                return new CreateIssuanceCommentCommand($asset, $room, $device, $issuable);
            }
        ];

        $this->commandBus->dispatchInTransactionWithAfterCommitCallback(
            $commands,
            function(TransactionResultCollector $collector) use ($room, $device, $issuable, $dto) {
                /** @var Asset $asset */
                $asset = $collector->get(1);
                $comment = $collector->get(2);
                $this->commandBus->dispatch(
                    new CreateIssuanceCommand(
                        $asset,
                        $room,
                        $device,
                        $issuable,
                        $dto->quantity,
                        $dto->issuedAt,
                        $comment
                    )
                );
            },
        );
    }
}

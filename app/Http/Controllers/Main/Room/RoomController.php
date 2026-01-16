<?php

namespace App\Http\Controllers\Main\Room;

use App\Application\Room\Command\CreateRoomCommand;
use App\Application\Room\Command\DeleteRoomCommand;
use App\Application\Room\Command\UpdateRoomCommand;
use App\Application\Room\Query\GetAllRoomQuery;
use App\Application\Room\Query\GetRoomByIdQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Room\CreateRoomRequest;
use App\Http\Requests\Room\UpdateRoomRequest;
use App\Http\Resources\Room\RoomCollection;
use App\Http\Resources\Room\RoomResource;
use App\Models\Room;
use Illuminate\Http\JsonResponse;

final class RoomController extends Controller
{
    public function index(): RoomCollection
    {
        $rooms = $this->queryBus->ask(new GetAllRoomQuery());

        return new RoomCollection($rooms);
    }

    public function show(int $id): RoomResource
    {
        $room = $this->queryBus->ask(new GetRoomByIdQuery($id));

        return new RoomResource($room);
    }

    public function store(CreateRoomRequest $request): JsonResponse
    {
        $dto = $request->toDto();

        /** @var Room $room */
        $room = $this->commandBus->dispatch(new CreateRoomCommand(
            $dto->name,
            $dto->number,
            $dto->type,
            $dto->building,
            $dto->floor,
        ));

        return response()->json([
            'message' => "Room $room->number created successfully"
        ], status: 201);
    }

    public function update(UpdateRoomRequest $request, int $id): JsonResponse
    {
        $dto = $request->toDto();

        $room = $this->commandBus->dispatch(new UpdateRoomCommand(
            $id,
            $dto->name,
            $dto->number,
            $dto->type,
            $dto->building,
            $dto->floor,
        ));

        return response()->json(new RoomResource($room));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->commandBus->dispatch(new DeleteRoomCommand($id));

        return response()->json([
            'message' => 'The record was successfully deleted'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Main\Room;

use App\Application\RoomOccupant\Command\AssignOccupantsToRoomCommand;
use App\Application\RoomOccupant\Command\RemoveOccupantsFromRoomCommand;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoomOccupant\AssignOccupantRequest;
use App\Http\Requests\RoomOccupant\RemoveOccupantRequest;
use App\Module\RoomOccupant\Exceptions\InvalidOccupantDataException;
use Illuminate\Http\JsonResponse;

final class RoomOccupantController extends Controller
{
    /**
     * @throws InvalidOccupantDataException
     */
    public function store(AssignOccupantRequest $request, int $id): JsonResponse
    {
        $dto = $request->toDto();

        $this->commandBus->dispatch(new AssignOccupantsToRoomCommand($id, $dto->occupants));

        return response()->json([
            'message' => "Occupants have been successfully added"
        ], 201);
    }

    /**
     * @throws InvalidOccupantDataException
     */
    public function destroy(RemoveOccupantRequest $request, int $id): JsonResponse
    {
        $dto = $request->toDto();

        $this->commandBus->dispatch(new RemoveOccupantsFromRoomCommand($id, $dto->occupants));

        return response()->json([
            'message' => "Occupants have been successfully removed"
        ]);
    }
}

<?php

namespace App\Http\Controllers\Main\Issuance;

use App\CQRS\CommandBusInterface;
use App\CQRS\QueryBusInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Issuance\CreateIssuanceRequest;
use App\Module\Issuance\Orchestrators\CreateIssuanceOrchestrator;
use Illuminate\Http\JsonResponse;
use Throwable;

final class IssuanceController extends Controller
{
    public function __construct(
        CommandBusInterface                         $commandBus,
        QueryBusInterface                           $queryBus,
        private readonly CreateIssuanceOrchestrator $createIssuanceOrchestrator,
    )
    {
        parent::__construct($commandBus, $queryBus);
    }

    /**
     * @throws Throwable
     */
    public function store(CreateIssuanceRequest $request): JsonResponse
    {
        $this->createIssuanceOrchestrator->execute($request->toDto());

        return response()->json([
            'message' => 'Issuance created successfully',
        ], 201);
    }
}

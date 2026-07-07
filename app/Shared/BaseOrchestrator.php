<?php

declare(strict_types=1);

namespace App\Shared;

use App\Shared\Attributes\DTO;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionNamedType;
use RuntimeException;

abstract readonly class BaseOrchestrator
{
    /**
     * @throws ReflectionException
     */
    public function __construct()
    {
        $this->enforceStrictSignature();
    }

    /**
     * @throws ReflectionException
     */
    private function enforceStrictSignature(): void
    {
        $childClass = static::class;

        if (!method_exists($this, 'execute')) {
            throw new RuntimeException("Orchestrator [$childClass] must have an 'execute' method.");
        }

        $reflection = new ReflectionMethod($this, 'execute');
        $parameters = $reflection->getParameters();

        if (empty($parameters)) {
            throw new RuntimeException("Orchestrator [$childClass::execute] must require at least one argument (the DTO).");
        }

        $firstParam = $parameters[0];
        $type = $firstParam->getType();
        $paramName = $firstParam->getName();

        if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
            throw new RuntimeException(
                "First parameter [$paramName] in [$childClass::execute] must be a valid DTO class, not a scalar type."
            );
        }

        $paramClass = $type->getName();

        $paramReflection = new ReflectionClass($paramClass);
        if (empty($paramReflection->getAttributes(DTO::class))) {
            throw new RuntimeException(
                "Class [$paramClass] used as first argument in [$childClass::execute] is NOT a valid DTO. Add #[DTO] attribute to it."
            );
        }
    }
}

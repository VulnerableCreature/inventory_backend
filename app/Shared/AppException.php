<?php

declare(strict_types=1);

namespace App\Shared;

use Exception;
use Illuminate\Http\JsonResponse;

abstract class AppException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'line' => $this->getLine(),
            'file' => $this->getFile(),
        ], $this->getCode());
    }
}

<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Override;

final class EmployeeCollection extends ResourceCollection
{
    public $collects = EmployeeResource::class;

    #[Override]
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}

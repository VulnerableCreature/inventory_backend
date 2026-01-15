<?php

declare(strict_types=1);

namespace App\Shared;

use Illuminate\Database\Eloquent\Builder;

abstract readonly class Filter
{
    protected string $table;

    public function __construct(private array $filters)
    {
    }

    public function apply(Builder $query): void
    {
        if (empty($this->filters)) {
            return;
        }

        $this->table = $query->getModel()->getTable();
        $query->where(function (Builder $query) {
            $first = true;
            foreach ($this->filters as $key => $value) {
                if (method_exists($this, $key)) {
                    if ($first) {
                        $this->applyFilter($query, $key, $value);
                        $first = false;
                    } else {
                        $query->orWhere(function (Builder $subQuery) use ($key, $value) {
                            $this->applyFilter($subQuery, $key, $value);
                        });
                    }
                }
            }
        });
    }

    protected function applyFilter(Builder $query, string $method, mixed $value): void
    {
        $this->$method($query, $value);
    }

    protected function id(Builder $query, $value): void
    {
        $query->where("$this->table.id", '=', $value);
    }

    protected function user_id(Builder $query, $value): void
    {
        $query->where("$this->table.user_id", '=', $value);
    }

    protected function created_at(Builder $query, $value): void
    {
        $query->whereDate("$this->table.created_at", '=', $value);
    }
}

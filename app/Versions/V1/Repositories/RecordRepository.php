<?php

namespace App\Versions\V1\Repositories;

use App\Models\Record;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class RecordRepository
{
    public function __construct(
        private Record $record,
    ) {
    }

    /**
     * здесь могла бы быть ваша пагинация, но я не работаю :3
     */
    public function allLoadAdditional(): Collection
    {
        return $this->record->load('additional')->all();
    }

    public function getNextId(): int
    {
        return $this->record->max('id') + 1;
    }
}

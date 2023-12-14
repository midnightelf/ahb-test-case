<?php

namespace App\Builders;

use App\Helpers\CsvHelper;
use App\Models\Record;

class RecordBuilder
{
    private Record $record;

    public function setBuilderRecord(Record $record): static
    {
        $this->record = $record;

        return $this;
    }

    public function getBuilderRecord(): Record
    {
        return $this->record;
    }

    public function setId(int $id): static
    {
        $this->record->id = $id;

        return $this;
    }

    public function setCode(string $val): static
    {
        $this->record->code = CsvHelper::trimCommas($val);

        return $this;
    }

    public function setName(string $val): static
    {
        $this->record->name = $val;

        return $this;
    }

    public function setPrice(string|float $val): static
    {
        $this->record->price = (float) $val;

        return $this;
    }

    public function setPriceSp(string|float $val): static
    {
        $this->record->price_sp = (float) CsvHelper::removeCommas($val);

        return $this;
    }

    public function setLevel1(string $val): static
    {
        $this->record->level1 = $val ?: null;

        return $this;
    }

    public function setLevel2(string $val): static
    {
        $this->record->level2 = $val ?: null;

        return $this;
    }

    public function setLevel3(string $val): static
    {
        $this->record->level3 = $val ?: null;

        return $this;
    }
}

<?php

namespace App\Builders;

use App\Helpers\CsvHelper;
use App\Models\RecordAdditional;

class RecordAdditionalBuilder
{
    private RecordAdditional $recordAdditional;

    public function setBuilderRecordAdditional(RecordAdditional $recordAdditional): static
    {
        $this->recordAdditional = $recordAdditional;

        return $this;
    }

    public function getBuilderRecordAdditional(): RecordAdditional
    {
        return $this->recordAdditional;
    }

    public function setCount(int $val): static
    {
        $this->recordAdditional->count = $val;

        return $this;
    }

    public function setProperties(string $val): static
    {
        $this->recordAdditional->properties = $val ?: null;

        return $this;
    }

    public function setCanJointPurchases(string|int $val): static
    {
        $this->recordAdditional->can_joint_purchases = (bool) $val;

        return $this;
    }

    public function setUnit(string $val): static
    {
        $this->recordAdditional->unit = CsvHelper::removeCommas($val);

        return $this;
    }

    public function setImage(string $val): static
    {
        $this->recordAdditional->image = $val ?: null;

        return $this;
    }

    public function setCanDisplayOnMain(string|int $val): static
    {
        $this->recordAdditional->can_display_on_main = (bool) $val;

        return $this;
    }

    public function setDescription(string $val): static
    {
        $val = CsvHelper::trimCommaQuotation($val) ?: null;

        $this->recordAdditional->description = $val;

        return $this;
    }
}

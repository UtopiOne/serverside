<?php

namespace MyProject\Models\Tours;

use MyProject\Models\ActiveRecordEntity;

class TourTag extends ActiveRecordEntity
{
    protected $name;
    protected $label;

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    protected static function getTableName(): string
    {
        return 'tour_tags';
    }
}

<?php

namespace MyProject\Models\Tours;

use MyProject\Models\ActiveRecordEntity;

class Tour extends ActiveRecordEntity
{
    protected $name;
    protected $description;
    protected $price;
    protected $durationDays;
    protected $tagId;
    protected $createdAt;
    protected $tagName;
    protected $tagLabel;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getDurationDays(): int
    {
        return $this->durationDays;
    }

    public function getTagId(): int
    {
        return $this->tagId;
    }

    public function getTagName(): string
    {
        return $this->tagName ?? '';
    }

    public function getTagLabel(): string
    {
        return $this->tagLabel ?? '';
    }

    public function getTag(): ?TourTag
    {
        return TourTag::getById($this->tagId);
    }

    /** @return Tour[] */
    public static function findByTagId(int $tagId): array
    {
        return static::findByColumn('tag_id', $tagId);
    }

    /** @return Tour[] grouped by tag name */
    public static function findAllWithTags(): array
    {
        $db = \MyProject\Services\Db::getInstance();
        return $db->query(
            'SELECT tours.*, tour_tags.name AS tag_name, tour_tags.label AS tag_label
             FROM tours
             JOIN tour_tags ON tours.tag_id = tour_tags.id
             ORDER BY tour_tags.id, tours.id;',
            [],
            static::class
        );
    }

    protected static function getTableName(): string
    {
        return 'tours';
    }
}

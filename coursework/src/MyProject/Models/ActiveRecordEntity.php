<?php

namespace MyProject\Models;

use MyProject\Services\Db;

abstract class ActiveRecordEntity
{
    protected $id;

    public function getId(): int
    {
        return $this->id;
    }

    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();
        $entities = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE id=:id;',
            [':id' => $id],
            static::class
        );

        return $entities ? $entities[0] : null;
    }

    public function __set(string $name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    public static function findAll(): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM `' . static::getTableName() . '`;', [], static::class);
    }

    public static function findByColumn(string $column, $value): array
    {
        $db = Db::getInstance();
        return $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE `' . $column . '` = :value;',
            [':value' => $value],
            static::class
        );
    }

    public function save(): void
    {
        $db = Db::getInstance();

        $columns = get_object_vars($this);
        unset($columns['id']);

        $setParts = [];
        $params = [':id' => $this->id];
        foreach ($columns as $camel => $val) {
            $snake = strtolower(preg_replace('/[A-Z]/', '_$0', lcfirst($camel)));
            $setParts[] = "`$snake` = :$snake";
            $params[":$snake"] = $val;
        }

        $db->query(
            'UPDATE `' . static::getTableName() . '` SET ' . implode(', ', $setParts) . ' WHERE id = :id;',
            $params,
            static::class
        );
    }

    abstract protected static function getTableName(): string;
}

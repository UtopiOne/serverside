<?php

namespace MyProject\Models\Articles;

use MyProject\Services\Db;
use MyProject\Models\Users\User;
use MyProject\Models\ActiveRecordEntity;

class Article extends ActiveRecordEntity
{
    protected $name;
    protected $text;
    protected $authorId;
    protected $createdAt;

    public function getName(): string
    {
        return $this->name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }

    public static function make(string $name, string $text, int $authorId): self
    {
        $article = new self();
        $article->setName($name);
        $article->setText($text);
        $article->setAuthorId($authorId);
        return $article;
    }

    protected static function getTableName(): string
    {
        return 'articles';
    }
}

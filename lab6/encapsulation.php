<?php
class Cat
{
    private $color;
    public $name;

    public function __construct(string $color)
    {
        $this->color = $color;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function sayHello()
    {
        echo 'Привет! Меня зовут ' . $this->name . '.' . ' Я ' . $this->color . ' кот.' . "<br>";
    }
}

$blackCat = new Cat('черный');
$blackCat->name = 'Барсик';
$blackCat->sayHello();

$whiteCat = new Cat('белый');
$whiteCat->name = 'Снежок';
$whiteCat->sayHello();

$gingerCat = new Cat('рыжий');
$gingerCat->name = 'Рыжик';
$gingerCat->sayHello();

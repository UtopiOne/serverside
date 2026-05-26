<?php

namespace lab7\Controllers;

class MainController
{
    public function main()
    {
        echo 'Главная страница';
    }

    public function sayHello(string $name)
    {
        echo 'Привет, ' . $name;
    }

    public function sayBye(string $name)
    {
        echo 'Пока, ' . $name;
    }
}
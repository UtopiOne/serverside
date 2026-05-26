<?php

namespace lab7\Controllers;

class MainController
{
    public function main()
    {
        $this->render('main');
    }

    function aboutMe()
    {
        $this->render('message', [
            'title' => 'Обо мне',
            'message' => 'Страница обо мне.'
        ]);
    }

    public function sayHello(string $name)
    {
        $this->render('message', [
            'title' => 'Привет',
            'message' => 'Привет, ' . $name . '!'
        ]);
    }

    public function sayBye(string $name)
    {
        $this->render('message', [
            'title' => 'Пока',
            'message' => 'Пока, ' . $name . '!'
        ]);
    }

    public function render(string $view, array $data = [])
    {
        extract($data, EXTR_SKIP);
        include __DIR__ . '/../Views/' . $view . '.php';
    }
}
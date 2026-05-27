<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\Models\Tours\Tour;
use MyProject\Models\Tours\TourTag;
use MyProject\View\View;

class MainController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function main()
    {
        $articles = Article::findAll();
        $tours = Tour::findAllWithTags();
        $tags = TourTag::findAll();
        $this->view->renderHtml('main/main.php', [
            'articles' => $articles,
            'tours'    => $tours,
            'tags'     => $tags,
        ]);
    }
}

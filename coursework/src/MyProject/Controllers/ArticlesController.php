<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\View\View;

class ArticlesController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function view(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article->setName(trim($_POST['name']));
            $article->setText(trim($_POST['text']));
            $article->save();

            header('Location: /articles/' . $articleId);
            exit;
        }
        $this->view->renderHtml('articles/view.php', [
            'article' => $article
        ]);
    }

    public function edit(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article->setName($_POST['name']);
            $article->setText($_POST['text']);
            $article->save();
            header('Location: /coursework/articles/' . $article->getId(), true, 302);
            exit();
        }

        $this->view->renderHtml('articles/edit.php', [
            'article' => $article
        ]);
    }
}

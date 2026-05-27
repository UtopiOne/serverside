<?php

namespace MyProject\Controllers;

use MyProject\Services\Db;
use MyProject\View\View;

class ArticlesController
{
    /** @var View */
    private $view;

    /** @var Db */
    private $db;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->db = new Db();
    }

    public function view(int $articleId)
    {
        // get article and author
        $article = $this->db->query(
            'SELECT * FROM `articles` WHERE id = :id;',
            [':id' => $articleId]
        );
        $authorNickname = $this->db->query(
            'SELECT * FROM `users` WHERE id = :id;',
            [':id' => $article[0]['author_id']]
        );

        if ($article === []) {
            $this->view->renderHtml('errors/404.php');
            return;
        }

        $this->view->renderHtml('articles/view.php', ['article' => $article[0], 'author' => $authorNickname[0]]);
    }
}

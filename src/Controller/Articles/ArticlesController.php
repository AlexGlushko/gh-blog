<?php

namespace App\Controller\Articles;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticlesController extends AbstractController
{
    public $test ='All posts';

    public function showAll()
    {
        return $this->render('articles/articles.html.twig', [
            'articles' => $this->test
        ]);
    }
}

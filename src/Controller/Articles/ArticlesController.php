<?php

namespace App\Controller\Articles;

use App\Entity\Article;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticlesController extends AbstractController
{


    public function showAll()
    {
        $articles =$this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if(!$articles){
            throw $this->createNotFoundException(
                'No articles found for id: '
            );
        }

        return $this->render('articles/articles.html.twig', [
            'articles' => $articles
        ]);
    }

    public function show($id)
    {
        $articles =$this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        if(!$articles){
            throw $this->createNotFoundException('No article found for id ' .$id);
        }

        return $this->render('articles/article.html.twig',[
            'article' => $articles
        ]);
    }
}

<?php

namespace App\Controller\Articles;

use App\Entity\Article;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ArticlesController extends AbstractController
{
    public function showAll(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Article::class)->createQueryBuilder('a')->getQuery();
        $articles = $paginator->paginate($query, $request->query->getInt('page', 1), 5);

        if (!$articles) {
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

        if (!$articles) {
            throw $this->createNotFoundException('No article found for id ' .$id);
        }

        return $this->render('articles/article.html.twig', [
            'article' => $articles
        ]);
    }
}

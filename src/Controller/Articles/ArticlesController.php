<?php

namespace App\Controller\Articles;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    public function showAll(Request $request, PaginatorInterface $paginator): Response
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
        $article =$this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        if (!$article) {
            throw $this->createNotFoundException('No article found for id ' .$id);
        }

        return $this->render('articles/article.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/comment/{id}/new", methods={"POST"}, name="commentnew"))
     *
     * @param Request $request
     * @param Article $article
     * @return Response
     */
    public function commentNew(Request $request, Article $article): Response
    {
        $comment = new Comment();
        $article->addComment($comment);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('commentnew',[
                'id'=> $article->getId()]);

        }

        return $this->render('commentForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function commentForm()
    {
        $form = $this->createForm(CommentType::class);
        return $this->render('commentForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

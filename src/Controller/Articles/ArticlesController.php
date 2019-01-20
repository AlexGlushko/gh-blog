<?php

namespace App\Controller\Articles;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ArticlesController extends Controller
{
    public function showAll(Request $request, PaginatorInterface $paginator): Response
    {
        $breadcrumbs = $this->get('white_october_breadcrumbs');
        $breadcrumbs->addRouteItem('Home', 'index');

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

        $breadcrumbs = $this->get('white_october_breadcrumbs');
        $breadcrumbs->addItem('Home', $this->get('router')->generate('index'));
        $breadcrumbs->addItem($article->getTitle());

        if (!$article) {
            throw $this->createNotFoundException('No article found for id ' .$id);
        }

        return $this->render('articles/article.html.twig', [
            'article' => $article
        ]);
    }

    public function commentNew(Request $request, Article $article): Response
    {
        $comment = new Comment();
        $article->addComment($comment);

        $form = $this->createForm(
            CommentType::class,
            $comment,
            ['action' => $this->generateUrl('comment_new', ['id' => $article->getId()])]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            $this->addFlash(
                'notice',
                'Your comment are saved'
            );

            return $this->redirectToRoute('show_article', [
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

    public function commentsShow(Article $article)
    {
        return $this->render('commentsShow.html.twig', [
            'comments' => $article->getComments()
        ]);
    }
}

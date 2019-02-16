<?php
/**
 * Created by PhpStorm.
 * User: halex
 * Date: 16.02.19
 * Time: 21:16
 */

namespace App\Controller\Api;


use App\Entity\Article;
use App\Entity\Comment;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class CommentsController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #for use pagination add GET query : ?page={num}
    public function getArticleComments(Article $article, PaginatorInterface $paginator, Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Comment::class)->findByArticleId($article);
        $comments =$paginator->paginate($data, $request->query->getInt('page', 1), 3);


        $jsonData = $this->serializer->serialize(
            ['comments' => $comments ],
            'json',
            ['groups' => ['comment']]
        );

        return new Response($jsonData, Response::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);

    }
}

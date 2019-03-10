<?php

namespace App\Controller\Api;


use App\Entity\Article;
use Knp\Component\Pager\PaginatorInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ArticlesController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer =$serializer;
    }

    /**
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     *
     * @SWG\Response(
     *     response=200,
     *     description="List of articles",
     *     @Model(type=Article::class, groups={"list"}),
     *     @SWG\Schema(
     *          type="string",
     *     )
     * )
     *
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        #for select page add GET query ?page=2

        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Article::class)->createQueryBuilder('a')->getQuery();
        $data = $paginator->paginate($query, $request->query->getInt('page', 1), 5);

        $jsonData = $this->serializer->serialize([
            'data' => $data,
            ],
            'json',['groups' => ['list'],
        ]);

        return new Response($jsonData, Response::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }


    public function showById($id)
    {
        $data = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $jsonData = $this->serializer->serialize($data,
            'json',['groups' => ['list'],
            ]);

        return new Response($jsonData, Response::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }
}

<?php


namespace App\Controller\Category;


use App\Entity\Category;


use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{
    public function show(Request $request, PaginatorInterface $paginator, Category $category)
    {
        $articles = $paginator->paginate($category->getArticles(), $request->query->getInt('page', 1),5);
        return $this->render('category/showArticlesByCategory.html.twig', [
            'category' => $articles,
        ]);
    }

    public function showAll( )
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('category.html.twig',[
           'categories' => $categories
        ]);
    }

}

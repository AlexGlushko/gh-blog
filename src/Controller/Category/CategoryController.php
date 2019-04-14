<?php

namespace App\Controller\Category;

use App\Entity\Article;
use App\Entity\Category;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function show(Request $request, PaginatorInterface $paginator, Category $category): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Article::class)->findByCategoryId($category);


        $articles = $paginator->paginate($query, $request->query->getInt('page', 1), 5);
        $identifer =  $category;

        $breadcrumbs = $this->get('white_october_breadcrumbs');
        $breadcrumbs->addRouteItem('Home', 'index');
        $breadcrumbs->addItem($category->getName());


        return $this->render('category/showArticlesByCategory.html.twig', [
           'articles' => $articles,
            'identifer' => $identifer,
        ]);
    }

    public function showAll()
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('category.html.twig', [
           'categories' => $categories
        ]);
    }
}

<?php

namespace App\Controller\Category;

use App\Entity\Article;
use App\Entity\Category;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Tests\A;

class CategoryController extends Controller
{
    public function show(Request $request, PaginatorInterface $paginator, Category $category)
    {


        $articles = $paginator->paginate($category->getArticles(), $request->query->getInt('page', 1), 5);


        $breadcrumbs = $this->get('white_october_breadcrumbs');
        $breadcrumbs->addRouteItem('Home', 'index');
        $breadcrumbs->addItem($category->getName());


        return $this->render('category/showArticlesByCategory.html.twig', [
           'category' => $articles,
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

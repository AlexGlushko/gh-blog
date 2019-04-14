<?php


namespace App\Controller\Search;


use App\Entity\Article;
use App\Form\SearchType;
use Bundles\PageLimitBundle\Service\PageLimit;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    public function searchFormRenderer(Request $request)
    {
        
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        
        return $this->render('search/searchForm.html.twig', [
            'search' => $form->createView(),
        ]);
    }
    
    public function searchResults(Request $request, PaginatorInterface $paginator, PageLimit $limit)
    {
       
        
        $query = $this->getDoctrine()
                        ->getRepository(Article::class)
                        ->findByArticleText($_GET['search']['query']);
        
        $results = $paginator->paginate($query,$request->query->getInt('page', 1), $limit->getLimit());
        
        
    
        return $this->render('search\results.html.twig', [
            'results' => $results,
        ]);
    }
}

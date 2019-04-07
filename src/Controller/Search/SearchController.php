<?php


namespace App\Controller\Search;


use App\Entity\Article;
use App\Form\SearchType;
use Bundles\PageLimitBundle\Service\PageLimit;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SearchController extends AbstractController
{
    public function searchFormRenderer(Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(SearchType::class);
   
        return $this->render('search/searchForm.html.twig', [
            'search' => $form->createView(),
            
        ]);
    }
    
    public function searchResults(Request $request, PaginatorInterface $paginator, PageLimit $limit, ValidatorInterface $validator)
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        $errors = $validator->validate($form);
        if(!$form->isValid())
        {
            
            $this->addFlash(
                'error',
                'Your query should be at least 4 characters'
            );
    
            return $this->redirectToRoute('index');
        }
        
        $query = $this->getDoctrine()->getRepository(Article::class)->findByArticleText($_GET['search']['query']);
        $results = $paginator->paginate($query,$request->query->getInt('page', 1), $limit->getLimit());
        
        return $this->render('search\results.html.twig', [
            'results' => $results,
            'errors' => $errors,
        ]);
    }
}

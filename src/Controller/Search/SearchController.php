<?php


namespace App\Controller\Search;


use App\Entity\Article;
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    public function searchAction(Request $request)
    {
        
        $form = $this->createForm(SearchType::class,null, ['action' => $this->generateUrl('search')]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
    
            //TODO не передается запрос из поля поиска, search%255Bquery%255D=lorem%26search%255Bsubmit%255D=%26search%255B_token%255D=E3spIWGdNEIhAk49UvngoSnhedwUgXXX5qCEYqQLWOA
            return $this->redirectToRoute('search_res',['query' => $request->getContent('query')]);
            
        }
    
        return $this->render('search/searchForm.html.twig', [
            'search' => $form->createView(),
        ]);
    }
    
    public function searchResults($query = 'lorem')
    {
        
        
        $results = $this->getDoctrine()
            ->getRepository(Article::class)
            ->createQueryBuilder('a')
            ->where("a.text LIKE '%$query%'")
            ->getQuery()
            ->getResult();
    
        return $this->render('search\results.html.twig', [
            //'pagination'=>$pagination,
            
            'results' => $results,
        ]);
    }
}

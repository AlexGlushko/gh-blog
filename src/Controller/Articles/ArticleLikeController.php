<?php


namespace App\Controller\Articles;


use App\Entity\Article;
use App\Entity\ArticleLike;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleLikeController extends AbstractController
{
    public function addLike(EntityManagerInterface $entityManager, Article $article)
    {
        $repository = $entityManager->getRepository(ArticleLike::class);
        if (!$repository->findByArticleAndUser($article, $this->getUser())) {
            $addlike = new ArticleLike();
            $addlike->setArticle($article);
            $addlike->setUser($this->getUser());
            $entityManager->persist($addlike);
            $entityManager->flush();
        }
        return $this->redirectToRoute('show_article', ['id' => $article->getId()]);
    }
    
}

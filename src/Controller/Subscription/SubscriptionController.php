<?php


namespace App\Controller\Subscription;


use App\Entity\Category;
use App\Entity\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends AbstractController
{
    public function subscribe(Request $request,EntityManagerInterface $entityManager,Category $category): Response
    {
        $repository = $entityManager->getRepository(Subscription::class);
        if (!$repository->findByCategoryAndUser($category, $this->getUser())) {
            $subscribe = new Subscription();
            $subscribe->setCategory($category);
            $subscribe->setUser($this->getUser());
            $entityManager->persist($subscribe);
            $entityManager->flush();
        }
        return $this->redirectToRoute('show_articles_by_category', ['id' => $category->getId()]);
    }

    public function unSubscribe(EntityManagerInterface $entityManager, Category $category)
    {
        $repository =$entityManager->getRepository(Subscription::class);
    
        if ($subscribe = $repository->findByCategoryAndUser($category, $this->getUser())) {
            $entityManager->remove($subscribe);
            $entityManager->flush();
        }
        return $this->redirectToRoute('show_articles_by_category', ['id' => $category->getId()]);
    }
    
}

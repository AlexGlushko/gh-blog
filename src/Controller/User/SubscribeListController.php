<?php


namespace App\Controller\User;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscribeListController extends AbstractController
{
    public function index(Request $request,User $user): Response
    {
        $subscriptions = $user->getSubscriptions();
        
        return $this->render('user/subscribe-list.html.twig', [
            'subscriptions' => $subscriptions,
        ]);
    }
}

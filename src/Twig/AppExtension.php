<?php


namespace App\Twig;


use App\Entity\Category;
use App\Entity\Subscription;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    public function getFunctions()
    {
        return [
            new TwigFunction('is_subscribed', [$this, 'isSubscribed'])
        ];
    }
    
    public function isSubscribed(Category $category, User $user)
    {
        return $this->em->getRepository(Subscription::class)->findByCategoryAndUser($category, $user);
    }
}

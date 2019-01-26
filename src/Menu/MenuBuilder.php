<?php

namespace App\Menu;

use App\Entity\Category;
use Knp\Menu\FactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MenuBuilder extends AbstractController
{
    private $checker;
    private $factory;
    public function __construct(FactoryInterface $factory, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->factory = $factory;
        $this->checker = $authorizationChecker;
    }
    public function mainMenu()
    {
        $menu = $this->factory->createItem('root');

        $items = $this->getDoctrine()->getRepository(Category::class)->findAll();
        foreach ($items as $item) {
            $menu->addChild($item->getName(), [
                'route' => 'show_categories_in_menu',
                'routeParameters' => ['id' => $item->getId()]
                ]);
        }

        return $menu;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: halex
 * Date: 10.03.19
 * Time: 20:04
 */

namespace Bundles\PageLimitBundle\DependencyInjection;



use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
       $treeBuilder = new TreeBuilder('page_limit');

       $rootNode = $treeBuilder->getRootNode();

       $rootNode
               ->children()
                    ->arrayNode('limit')
                        ->children()
                            ->integerNode('articles_per_page')->end()
                        ->end()
                    ->end()
                ->end()
           ;

       return $treeBuilder;

    }
}

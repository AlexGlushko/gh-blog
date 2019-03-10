<?php
/**
 * Created by PhpStorm.
 * User: halex
 * Date: 10.03.19
 * Time: 20:20
 */

namespace Bundles\PageLimitBundle\DependencyInjection;


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class PageLimitExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('limit.articles_per_page', $config['limit']['articles_per_page']);

    }
}

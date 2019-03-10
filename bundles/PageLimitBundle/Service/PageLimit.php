<?php
/**
 * Created by PhpStorm.
 * User: halex
 * Date: 10.03.19
 * Time: 20:55
 */

namespace Bundles\PageLimitBundle\Service;


class PageLimit
{
    private $limit;
    
    public function __construct(int $limit)
    {
        $this->limit = $limit;
    }
    
    public function getLimit(): int
    {
        return (int) $this->limit;
    }
}

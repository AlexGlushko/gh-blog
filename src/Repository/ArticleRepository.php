<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /*
     * @return Article[] Returns an array of Article objects
     *
     */
    /**
     * @param $category
     * @return Query
     *
     */

    public function findByCategoryId(Category $category): Query
    {
        return $this->createQueryBuilder('a')
                ->innerJoin('a.category', 'c')
                ->andWhere('c.id = :category')
                ->setParameter('category', $category)
                ->orderBy('a.id', 'DESC')
                ->setMaxResults(10)
                ->getQuery()

        ;
    }
    
    
    public function findByArticleText($value): Query
    {
        
        return $this->createQueryBuilder('a')
            ->select('a')
            ->where("a.text LIKE :query")
            ->setParameter('query', "%$value%")
            ->getQuery()
            ;
        
    }
    
}

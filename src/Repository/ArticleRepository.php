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
                ->innerJoin('a.categories', 'c')
                ->andWhere('c.id = :category')
                ->setParameter('category', $category)
                ->orderBy('a.id', 'DESC')
                ->setMaxResults(10)
                ->getQuery()

        ;
    }


    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findSixLastArticles()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults(25)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllMonth($year, $month): ?Article
    {
        return $this->createQueryBuilder('a')
            ->where('a.createdAt BETWEEN :start AND :end')
            ->setParameter('start', new \Datetime($year.'-'.$month.'-01')) // Date entre le 1er janvier de cette année
            ->setParameter('end', new \Datetime($year.'-'.$month.'-31'))   // Et le 31 décembre de cette année
            ->getQuery()
            ->getResult()
        ;
    }

    public function findCountMonth($year, $month)
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.id) as number')
            ->where('a.createdAt BETWEEN :start AND :end')
            ->setParameter('start', new \Datetime($year.'-'.$month.'-01')) // Date entre le 1er janvier de cette année
            ->setParameter('end', new \Datetime($year.'-'.$month.'-31'))   // Et le 31 décembre de cette année
            ->getQuery()
            ->getResult();
        ;
    }

               /* ->setParameter('start', new \Datetime(date('Y').'-'.$month.'-01')) // Date entre le 1er janvier de cette année*/

    public function findCountArticles()
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getOneOrNullResult();
        ;
    }

    public function findCountAll()
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getResult()
        ;
    }


    public function getfindOrderByComments($id)
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.comments', 'i')
            ->addSelect('i')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->orderBy('i.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getfindOrderByArticles()
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.user', 'i')
            ->addSelect('i')
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

}

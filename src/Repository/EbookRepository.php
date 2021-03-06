<?php

namespace App\Repository;

use App\Entity\Ebook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method null|Ebook find($id, $lockMode = null, $lockVersion = null)
 * @method null|Ebook findOneBy(array $criteria, array $orderBy = null)
 * @method Ebook[]    findAll()
 * @method Ebook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EbookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ebook::class);
    }

    // /**
    //  * @return Ebook[] Returns an array of Ebook objects
    //  */

    public function findByCategory($category)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.category = :val')
            ->setParameter('val', $category)
            
            // ->orderBy('e.id', 'ASC')
            // ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Ebook
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

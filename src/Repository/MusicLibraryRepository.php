<?php

namespace App\Repository;

use App\Entity\MusicLibrary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MusicLibrary|null find($id, $lockMode = null, $lockVersion = null)
 * @method MusicLibrary|null findOneBy(array $criteria, array $orderBy = null)
 * @method MusicLibrary[]    findAll()
 * @method MusicLibrary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusicLibraryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MusicLibrary::class);
    }

    // /**
    //  * @return MusicLibrary[] Returns an array of MusicLibrary objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MusicLibrary
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

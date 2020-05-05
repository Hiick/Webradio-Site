<?php

namespace App\Repository;

use App\Entity\ListSignals;
use App\Entity\Signalements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder as ORMQueryBuilder;

/**
 * @method ListSignals|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListSignals|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListSignals[]    findAll()
 * @method ListSignals[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListSignalsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListSignals::class);
    }

    public function findListSignal(): array
    {
        return $this->findVisibleQuery()
        ->setMaxResults(5)
        ->getQuery()
        ->getResult()
        ;
    }

    private function findVisibleQuery() :ORMQueryBuilder
    {
        return $this->createQueryBuilder("l");       
    }

    
    
}

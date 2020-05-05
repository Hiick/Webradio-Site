<?php

namespace App\Repository;

use App\Entity\Radio;
use App\Entity\RadioSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder as ORMQueryBuilder;

/**
 * @method Radio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Radio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Radio[]    findAll()
 * @method Radio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RadioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Radio::class);
    }

    public function findAllVisibleQuery(RadioSearch $search) : Query
    {
        $query = $this->findVisibleQuery();
        
        if($search->getNameRadio()) {
            $query = $query
                ->andWhere('r.nameRadio = :nameRadio')
                ->setParameter(':nameRadio', $search->getNameRadio());
        }

        return $query->setMaxResults(4)
                    ->getQuery();
    }

    /**
     * return Radio[]
     */

    public function findLastest() :array
    {
            return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();  
    }

    private function findVisibleQuery() :ORMQueryBuilder
    {
        return $this->createQueryBuilder('r');       
    }
}

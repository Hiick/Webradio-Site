<?php

namespace App\Repository;

use App\Entity\Channels;
use App\Entity\UserSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder as ORMQueryBuilder;

/**
 * @method Channels|null find($id, $lockMode = null, $lockVersion = null)
 * @method Channels|null findOneBy(array $criteria, array $orderBy = null)
 * @method Channels[]    findAll()
 * @method Channels[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChannelsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Channels::class);
    }

   
    public function findAllVisibleQuery(UserSearch $search): Query
    {
        $query = $this->findVisibleQuery();

        if($search->getUsername()){
            $query = $query
                ->andWhere('c.username = :username')
                ->setParameter(':username', $search->getUsername());
        }

        if($search->getChannels()) {
            $query = $query
                ->andWhere('c.nomChaine = :nomChaine')
                ->setParameter(':nomChaine', $search->getChannels());
        }

        return $query->setMaxResults(4)
                ->getQuery();
    }

    /**
     * @return Users[]
     */
    public function findLastest() :array
    {
        return $this->findVisibleQuery()
        ->setMaxResults(4)
        ->getQuery()
        ->getResult()
        ;
    }

    private function findVisibleQuery() :ORMQueryBuilder
    {
        return $this->createQueryBuilder('c');       
    }
}

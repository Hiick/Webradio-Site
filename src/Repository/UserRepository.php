<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder as ORMQueryBuilder;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findAllVisibleQuery(UserSearch $search): Query
    {
        $query = $this->findVisibleQuery();

        if($search->getUsername()){
            $query = $query
                ->andWhere('u.username = :username')
                ->setParameter(':username', $search->getUsername());
        }

        if($search->getChannels()) {
            $query = $query
                ->andWhere('u.channels = :channels')
                ->setParameter(':channels', $search->getChannels());
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

    public function findTheUser($username) 
    {
        return $this->findVisibleQuery()
        ->andWhere('u.username = :username')
        ->setParameter(':username', $username)
        ->getQuery()
        ->getResult();

    }

    public function findUserByMail($email, $password) 
    {
        return $this->findVisibleQuery()
        ->andWhere('u.email = :email')
        ->andWhere('u.password = :password')
        ->setParameter(':email', $email)
        ->setParameter(':password', $password)
        ->getQuery()
        ->getResult();

    }

    private function findVisibleQuery() :ORMQueryBuilder
    {
        return $this->createQueryBuilder('u');       
    }
}   

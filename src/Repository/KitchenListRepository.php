<?php

namespace App\Repository;

use App\Entity\KitchenList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class KitchenListRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, KitchenList::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('k')
            ->where('k.something = :value')->setParameter('value', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function showListsOfCurrentUser($userId) 
    {
        $qb = $this->createQueryBuilder('k')
            ->where('k.userId = :value')->setParameter('value', $userId)
            ->orderBy('k.name', 'ASC');
        return $qb;
    }
}

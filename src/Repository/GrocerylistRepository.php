<?php

namespace App\Repository;
use App\Entity\Grocerylist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class GrocerylistRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Grocerylist::class);
    }

    public function findAllGrocerylistsOfUser($userId) 
    {
        $qb = $this->createQueryBuilder('g')
            ->where('g.user = :value')->setParameter('value', $userId)
            ->orderBy('g.name', 'ASC');
        return $qb;
    }
}

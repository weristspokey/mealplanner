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

    public function findAllKitchenListsOfUser($userId) 
    {
        $qb = $this->createQueryBuilder('k')
            ->where('k.user = :value')->setParameter('value', $userId)
            ->orderBy('k.name', 'ASC');
        return $qb;
    }
}

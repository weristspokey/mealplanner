<?php

namespace App\Repository;
use App\Entity\MealplanItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class MealplanItemRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MealplanItem::class);
    }

    public function findAllMealplanItemsOfUser($userId) 
    {
        $qb = $this->createQueryBuilder('m')
            ->where('m.userId = :value')->setParameter('value', $userId);
        return $qb;
    }
}

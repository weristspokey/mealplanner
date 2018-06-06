<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RecipeRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    public function findAllRecipesOfUser($userId)
    {
        $qb = $this->createQueryBuilder('r')
            ->where('r.user = :value')->setParameter('value', $userId)
            ->orderBy('r.name', 'ASC');
        return $qb;
    }
}

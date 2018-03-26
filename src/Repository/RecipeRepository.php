<?php

namespace App\Repository;

use App\Entity\Recipe;
use App\Entity\MealplanItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RecipeRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Recipe::class);
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
    public function showRecipesOfCurrentUser($userId) 
    {
        $qb = $this->createQueryBuilder('r')
            ->where('r.userId = :value')->setParameter('value', $userId)
            ->orderBy('r.name', 'ASC');
        return $qb;
    }
    public function findAllRecipesOfCurrentUser($userId)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT recipe
                FROM App:Recipe recipe
                WHERE recipe.userId = :value'
            )->setParameter('value', $userId)
            ->getResult();
    }
}

<?php

namespace App\Repository;
use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TagRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tag::class);
    }
    // public function showListsOfCurrentUser($userId) 
    // {
    //     $qb = $this->createQueryBuilder('t')
    //         ->where('t.user = :value')->setParameter('value', $userId)
    //         ->orderBy('t.name', 'ASC');
    //     return $qb;
    // }

    // public function findAllTagsOfCurrentUser($userId)
    // {
    //     return $this->getEntityManager()
    //         ->createQuery(
    //             'SELECT tag
    //             FROM App:Tag tag
    //             WHERE tag.user = :value'
    //         )->setParameter('value', $userId)
    //         ->getResult();
    // }

    public function findAllTagsOfUser($userId) 
    {
        $qb = $this->createQueryBuilder('t')
            ->where('t.user = :value')->setParameter('value', $userId)
            ->orderBy('t.name', 'ASC');
        return $qb;
    }
}

<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Dialog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class DialogRepository extends ServiceEntityRepository
{
    public function findDialogByMemberAndParent(int $memberId): ?Dialog
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.members', 'm') // Join the members association
            ->where('m.id = :memberId') // Filter by member ID
            ->andWhere('d.parentDialog IS NULL') // Ensure parentDialog is null
            ->orderBy('d.id', 'DESC') // Sort by ID in descending order
            ->setMaxResults(1) // Get only one result
            ->setParameter('memberId', $memberId) // Set the parameter for the query
            ->getQuery()
            ->getOneOrNullResult(); // Fetch one or null if no result is found
    }
}
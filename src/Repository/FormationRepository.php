<?php

namespace App\Repository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;

class FormationRepository extends EntityRepository
{
    public function findByTypeAndDate($type, $date)
    {
        $qb = $this->createQueryBuilder('f')
            ->where('f.type = :type')
            ->andWhere('f.date > :date')
            ->setParameter('type', $type)
            ->setParameter('date', $date);

        return $qb->getQuery()->getResult();
    }
}

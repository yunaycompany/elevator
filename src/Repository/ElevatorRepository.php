<?php
namespace App\Repository;

use App\Entity\Elevator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ElevatorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Elevator::class);
    }


    /**
     * Obtener los elevadores disponibles
     * @return array
     */
    public function getFreeElevators()
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb = $qb->select('e')
                ->from(Elevator::class, 'e')
                ->where('e.status = :status')
                ->setParameter('status', Elevator::STATUS_FREE);

        return $qb->getQuery()->getResult();
    }

}
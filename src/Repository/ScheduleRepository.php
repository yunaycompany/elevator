<?php
namespace App\Repository;

use App\Entity\Schedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ScheduleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Schedule::class);
    }


    /**
     * Obtener los pedidos a realizar
     * ordenados por hora de inicio
     * @return array
     */
    public function getSchedules()
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb = $qb->select('s')
                ->from(Schedule::class, 's')
                ->addOrderBy('s.startTime','ASC');

        return $qb->getQuery()->getResult();
    }

}
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ElevatorRepository;
/**
 * Elevator
 *
 * @ORM\Table(name="elevator")
 * @ORM\Entity(repositoryClass=ElevatorRepository::class)
 */
class Elevator
{
    const STATUS_FREE = 0;
    const STATUS_BUSY = 1;


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     * Piso Actual en que se encuentra el elevador
     * @ORM\Column(name="current_floor", type="integer", nullable=false)
     */
    private $currentFloor;

    /**
     * @var int
     * Estado del elevador 0-> Disponible 1 -> Ocupado
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var int
     * Pisos recorridos
     * @ORM\Column(name="floors_traveled", type="integer", nullable=false)
     */
    private $floorsTraveled = '0';



    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * @return int
     */
    public function getCurrentFloor()
    {
        return $this->currentFloor;
    }

    /**
     * @param int $currentFloor
     */
    public function setCurrentFloor($currentFloor)
    {
        $this->currentFloor = $currentFloor;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getFloorsTraveled()
    {
        return $this->floorsTraveled;
    }

    /**
     * @param int $floorsTraveled
     */
    public function setFloorsTraveled($floorsTraveled)
    {
        $this->floorsTraveled = $floorsTraveled;
    }

}

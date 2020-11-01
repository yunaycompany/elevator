<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RequestElevator
 *
 * @ORM\Table(name="request_elevator")
 * @ORM\Entity
 */
class RequestElevator
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="Elevator")
     * @ORM\JoinColumn(name="elevator_id", referencedColumnName="id")
     */
    protected $elevator;

    /**
     * @ORM\ManyToOne(targetEntity="request", inversedBy="requestElevators" )
     * @ORM\JoinColumn(name="request_id", referencedColumnName="id")
     */
    protected $request;


    /**
     * @var int
     * Piso del elevador en el pedido
     * @ORM\Column(name="current_floor", type="integer", nullable=false)
     *
     */
    private $currentFloor;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * @return mixed
     */
    public function getElevator()
    {
        return $this->elevator;
    }

    /**
     * @param mixed $elevator
     */
    public function setElevator( $elevator)
    {
        $this->elevator = $elevator;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
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











}

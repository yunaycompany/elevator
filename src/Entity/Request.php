<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Request
 *
 * @ORM\Table(name="request")
 * @ORM\Entity
 */
class Request
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
     * @var int
     * Piso de Origen del pedido
     * @ORM\Column(name="origin_floor", type="integer", nullable=false)
     */
    private $originFloor;

    /**
     * @var int
     * Piso destino del pedido
     * @ORM\Column(name="destination_floor", type="integer", nullable=false)
     */
    private $destinationFloor;


    /**
     * Elevador usado
     * @ORM\ManyToOne(targetEntity="Elevator")
     * @ORM\JoinColumn(name="used_elevator", referencedColumnName="id")
     */
    protected $usedElevator;

    /**
     * @ORM\OneToMany(targetEntity="RequestElevator", mappedBy="request", cascade={"persist"})
     *
     */
    protected $requestElevators;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->requestElevators =new ArrayCollection();
    }


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
    public function getOriginFloor()
    {
        return $this->originFloor;
    }

    /**
     * @param int $originFloor
     */
    public function setOriginFloor($originFloor)
    {
        $this->originFloor = $originFloor;
    }

    /**
     * @return int
     */
    public function getDestinationFloor()
    {
        return $this->destinationFloor;
    }

    /**
     * @param int $destinationFloor
     */
    public function setDestinationFloor($destinationFloor)
    {
        $this->destinationFloor = $destinationFloor;
    }

    /**
     * @return mixed
     */
    public function getUsedElevator()
    {
        return $this->usedElevator;
    }

    /**
     * @param mixed $usedElevator
     */
    public function setUsedElevator($usedElevator)
    {
        $this->usedElevator = $usedElevator;
    }

    /**
     * @return ArrayCollection
     */
    public function getRequestElevators()
    {
        return $this->requestElevators;
    }











}

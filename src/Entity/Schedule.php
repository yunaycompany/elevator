<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ScheduleRepository;
/**
 * Schedule
 *
 * @ORM\Table(name="schedule")
 * @ORM\Entity(repositoryClass=ScheduleRepository::class)
 */
class Schedule
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
     *
     */
    private $originFloor;

    /**
     * @var int
     * Piso destino del pedido
     * @ORM\Column(name="destination_floor", type="integer", nullable=false)
     *
     */
    private $destinationFloor;

    /**
     * @var int
     * Intervalo de tiempo en el cual se solicita el pedido
     * @ORM\Column(name="time_interval", type="integer", nullable=false)
     */
    private $timeInterval;

    /**
     * @var \DateTime
     * Hora de inicio del pedido
     * @ORM\Column(name="start_time", type="time", nullable=false)
     *
     */
    private $startTime;

    /**
     * @var \DateTime
     * Hora Fin del pedido
     * @ORM\Column(name="end_time", type="time", nullable=false)
     *
     */
    private $endTime;

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
     * @return int
     */
    public function getTimeInterval()
    {
        return $this->timeInterval;
    }

    /**
     * @param int $timeInterval
     */
    public function setTimeInterval($timeInterval)
    {
        $this->timeInterval = $timeInterval;
    }

    /**
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param \DateTime $startTime
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param \DateTime $endTime
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }


    public function checkTime(\DateTime  $time){
        $startTime = strtotime($this->startTime);
        $endTime = strtotime($this->endTime);
        $nowTime = strtotime($time->format('H:i:s'));

        for( $i=$startTime; $i<$endTime; $i+=($this->timeInterval * 60)) {
            if($nowTime == $i){
                return true;
            }
        }
        return false;
    }



}

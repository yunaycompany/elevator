<?php

namespace App\Manager;

use App\Entity\Elevator;
use App\Entity\Request;
use App\Entity\RequestElevator;
use App\Entity\Schedule;
use App\Repository\ElevatorRepository;
use App\Repository\ScheduleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class ElevatorManager
{
    protected $scheduleRepository;
    protected $elevatorRepository;
    protected $maxFloor;
    protected $em;
    protected $logger;


    /**
     * ElevatorManager constructor.
     */
    public function __construct(LoggerInterface $logger, EntityManagerInterface $em, ScheduleRepository $scheduleRepository, ElevatorRepository $elevatorRepository, $maxFloor)
    {
        $this->em = $em;
        $this->scheduleRepository = $scheduleRepository;
        $this->elevatorRepository = $elevatorRepository;
        $this->maxFloor = $maxFloor;
        $this->logger = $logger;

    }

    /**
     * Comenzar operatoria del dia
     */
    public function start()
    {
        $time = new \DateTime();
        $time->setTime(9, 0, 0);

        $this->logger->info('Iniciando');


        //Obtener todos los pedidos a realizar
        $schedules = $this->scheduleRepository->getSchedules();

        foreach ($schedules as $schedule) {
            $this->logger->info('Schedule: ' . $schedule->getId());
            //Inicializar el timer de cada pedido
            $this->initEventTimer($schedule, $time);
        }


    }


    /**
     * Iniciar timer de cada pedido
     * Esta funcion me asegura que se inicie
     * el timer en la hora correspondiente
     * y que se ejecute cada el intervalo de tiempo
     * especifico del pedido
     * @param Schedule $schedule
     * @param \DateTime $time
     */
    private function initEventTimer(Schedule $schedule, \DateTime $time)
    {
        $year = $time->format('Y');
        $month = $time->format('m');
        $day = $time->format('d');
        $schedule->getStartTime()->setDate($year, $month, $day);
        $schedule->getEndTime()->setDate($year, $month, $day);


        $startAfter = null;
        if ($time == $schedule->getStartTime()) {
            $startAfter = 0;
        } else if ($time < $schedule->getStartTime()) {
            $startAfter = $schedule->getStartTime()->getTimestamp() - $time->getTimestamp();
        }

        $this->logger->info('Start After: ' . $startAfter);
        if ($startAfter === null) {
            return;
        }

        $w2 = new \EvTimer($startAfter, $schedule->getTimeInterval(), function ($w) use ($schedule, $time) {
            $this->logger->info('Inicio Crear Pedido');
            //Crear pedidos
            $this->createRequest($schedule);

            // Detener el timer
            $this->stopSchedule($schedule, \Ev::iteration()) and $w->stop();
        });
        \Ev::run(\Ev::RUN_NOWAIT);

    }


    /**
     * Crear objetos del pedido
     * @param Schedule $schedule
     */
    private function createRequest(Schedule $schedule)
    {
        $elevator = $this->getElevatorToUse($schedule);

        //Elevador ocupado
        $elevator->setStatus(Elevator::STATUS_BUSY);
        $this->flush($elevator);

        $this->move($elevator, $schedule);

        $this->logger->info('Elevador: ' . $elevator->getId());

        $request = new Request();
        $request->setDestinationFloor($schedule->getDestinationFloor());
        $request->setOriginFloor($schedule->getOriginFloor());
        $request->setUsedElevator($elevator);
        $this->flush($request, false);


        $this->logger->info('Pedido creado');

        //Informe de todos los elevadores en la peticion
        $elevators = $this->elevatorRepository->findAll();
        foreach ($elevators as $elev){
            $requestElevator = new RequestElevator();
            $requestElevator->setRequest($request);
            $requestElevator->setElevator($elev);
            $requestElevator->setCurrentFloor($elev->getCurrentFloor());
            $this->logger->info('Creando Informe elevador '. $elev->getId());
            $this->flush($requestElevator, false);
        }
        $elevator->setStatus(Elevator::STATUS_FREE);
        $this->logger->info('Elevador liberado');
        $this->flush($elevator);

        $this->logger->info('Objetos persistidos');
    }


    /**
     * Obtener el elevador a usar para el pedido actual
     * @param Schedule $schedule
     * @return Elevator|object
     */
    private function getElevatorToUse(Schedule $schedule)
    {
        //Buscar elevador libre en el piso del pedido Actual
        $elevator = $this->elevatorRepository->findOneBy(['status' => Elevator::STATUS_FREE,
            'currentFloor' => $schedule->getOriginFloor()]);
        if ($elevator) {
            $this->logger->info('Elevador en mismo piso');
            return $elevator;
        }
        //Buscar elevadores libres
        $freeElevators = $this->elevatorRepository->getFreeElevators();

        //Encontrar el mejor elevador a usar basado en la menor cantidad de pisos a hacer
        $bestElevator = null;
        $numOfFloors = $this->maxFloor;
        foreach ($freeElevators as $elevator) {
            /**@var Elevator $elevator * */
            $floors = abs($elevator->getCurrentFloor() - $schedule->getOriginFloor());
            if ($floors < $numOfFloors) {
                $numOfFloors = $floors;
                $bestElevator = $elevator;
            }
        }
        //Si no lo encontramos, esperar un segundo, hasta que se haya liberado alguno
        if (!$bestElevator) {
            $this->logger->info('No se encontre elevador');
            sleep(1);
            return $this->getElevatorToUse($schedule);
        }

        $this->logger->info('Encontrado elevador-> A moverlo');
        //Si se encuentra un elevador en un piso distinto al del pedido Actual
        $this->move($bestElevator, $schedule);

        return $bestElevator;
    }

    /**
     * Mover elevador hasta que este en el piso del pedido actual
     * @param Elevator $elevator
     * @param Schedule $schedule
     */
    private function move(Elevator $elevator, Schedule $schedule)
    {
        $this->logger->info('Moviendo elevador');
        $this->logger->info('Piso Pedido: '. $schedule->getDestinationFloor());
        $this->logger->info('Piso del Elevador: '. $elevator->getCurrentFloor());
        while ($elevator->getCurrentFloor() != $schedule->getDestinationFloor()) {
            if ($elevator->getCurrentFloor() > $schedule->getDestinationFloor()) {
                $this->down($elevator);
            } else if ($elevator->getCurrentFloor() < $schedule->getDestinationFloor()) {
                $this->up($elevator);
            }
        }
        $this->logger->info('Elevador en piso destino');
    }

    /**
     * Subir elevador
     * @param Elevator $elevator
     */
    private function up(Elevator $elevator)
    {
        $this->logger->info('Mover elevador arriba');

        if ($elevator->getCurrentFloor() == $this->maxFloor) {
            $elevator->setCurrentFloor($elevator->getCurrentFloor() - 1);
        } else {
            $elevator->setCurrentFloor($elevator->getCurrentFloor() + 1);
        }
        $elevator->setFloorsTraveled($elevator->getFloorsTraveled() + 1);
        sleep(1);
        $this->flush($elevator);
    }

    /**
     * Bajar elevador
     * @param Elevator $elevator
     */
    private function down(Elevator $elevator)
    {
        $this->logger->info('Mover elevador abajo');
        if ($elevator->getCurrentFloor() == 0) {
            $elevator->setCurrentFloor($elevator->getCurrentFloor() + 1);
        } else {
            $elevator->setCurrentFloor($elevator->getCurrentFloor() - 1);
        }
        $elevator->setFloorsTraveled($elevator->getFloorsTraveled() + 1);

        sleep(1);
        $this->flush($elevator);
    }

    /**
     * Persistir $entity en la BD
     * @param $entity
     * @param bool $doFlush
     */
    private function flush($entity, $doFlush = true)
    {
        $this->em->persist($entity);
        if ($doFlush) {
            $this->em->flush();
        }

    }


    /**
     * Determina si se debe detener el timer
     * @param Schedule $schedule
     * @param $iteration
     */
    private function stopSchedule(Schedule $schedule, $iteration)
    {
        //Segundos del pedido
        $secsDiff = $schedule->getEndTime()->getTimestamp() - $schedule->getStartTime()->getTimestamp();
        //Minutos del pedido
        $mins = floor($secsDiff / 60);
        //Veces a repetir el pedido
        $times = $mins / $schedule->getTimeInterval();

        //Si se hicieron todos los pedidos, parar
        if ($times >= $iteration) {
            $this->logger->info('Parar Pedido');
            return true;
        }

        $this->logger->info('Continua Pedido');
        return false;
    }


}
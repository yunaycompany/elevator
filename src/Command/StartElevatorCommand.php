<?php

namespace App\Command;

use App\Manager\ElevatorManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartElevatorCommand extends Command
{
    protected static $defaultName = 'app:start:elevator';

    protected $elevatorManager;

    public function __construct(ElevatorManager $elevatorManager)
    {
        $this->elevatorManager = $elevatorManager;
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
        ->setName('app:start:elevator')
        ->setDescription('Iniciar trabajo de elevadores');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //Iniciar funcionamiento de elevadores
        $this->elevatorManager->start();

        return Command::SUCCESS;
    }
}

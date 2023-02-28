<?php

namespace App\Command;

use App\Entity\Location;
use App\Repository\LocationsRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:fill-location',
    description: 'Add a short description for your command',
)]
class FillLocationCommand extends Command
{
    private $locationsRepository;

    public function __construct(LocationsRepository $locationsRepository)
    {
        $this->locationsRepository = $locationsRepository;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $location = new Location();
        $location->setName("Chisinau");
        $location->setShippingCost(60);
        $this->locationsRepository->save($location,true);

        return Command::SUCCESS;
    }
}

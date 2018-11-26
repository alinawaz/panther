<?php

namespace Panther\Cli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use Panther\Database\Claw;

class SeedCommand extends Command
{
    protected function configure()
    {
        $this
        ->setName('seed:one')
        ->setDescription('Run a single seeder with name.');

        $this->addArgument('name', InputArgument::REQUIRED, 'Name');
        $this->addOption('rollback', null, InputOption::VALUE_REQUIRED, 'Rollback', 'no');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        
        // Let's seed      
        $output->writeln('> Seeding ['.$name.'] ...');  
        $class = "\\App\\Database\\Seeders\\".$name;
        $seeder = new $class();
        if($input->getOption('rollback') == 'yes'){
            $output->writeln('Rolling back changes ...');  
            $seeder->rollback();  
        }
        $seeder->run();      

        $output->writeln('All done.');
    }

}
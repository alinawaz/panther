<?php

namespace Panther\Cli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use Symfony\Component\Filesystem\Filesystem;

class CreateEntityCommand extends Command
{
    protected function configure()
    {
        $this
        ->setName('make:entity')
        ->setDescription('Creates a new entity.');
        //->setHelp('This command allows you to create a user...');

        $this->addArgument('entity_name', InputArgument::REQUIRED, 'Entity name');
        $this->addOption('routing', null, InputOption::VALUE_REQUIRED, 'Routing', 'internal');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Creating entity ['.$input->getArgument('entity_name').'] ...');
        $output->writeln('Flags: '. $input->getOption('routing'));

        $fileSystem = new Filesystem();

        
    }

}
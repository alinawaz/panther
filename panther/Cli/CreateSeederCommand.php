<?php

namespace Panther\Cli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use Symfony\Component\Filesystem\Filesystem;

class CreateSeederCommand extends Command
{
    protected function configure()
    {
        $this
        ->setName('make:seeder')
        ->setDescription('Creates a new seeder for database.');

        $this->addArgument('name', InputArgument::REQUIRED, 'Name');
        $this->addArgument('table', InputArgument::REQUIRED, 'Table');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Creating seeder ['.$input->getArgument('name').'] ...');

        $fileSystem = new Filesystem();

        // Collecting information
        $name = $input->getArgument('name');
        $table = $input->getArgument('table');
        $file = 'app/database/seeders/'.$name.'.php';

        // Fetching template
        $template = file_get_contents('app/storage/templates/seeder.template');
        $template = str_replace('<class_name>', $name, $template);
        $template = str_replace('<table_name>', $table, $template);

        // Generating file
        $fileSystem->dumpFile($file, $template);

        $output->writeln('Seeder created successfully.');
    }

}
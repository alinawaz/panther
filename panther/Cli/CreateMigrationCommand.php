<?php

namespace Panther\Cli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use Symfony\Component\Filesystem\Filesystem;

class CreateMigrationCommand extends Command
{
    protected function configure()
    {
        $this
        ->setName('make:migration')
        ->setDescription('Creates a new migration for database.');

        $this->addArgument('name', InputArgument::REQUIRED, 'Name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Creating migration ['.$input->getArgument('name').'] ...');

        $fileSystem = new Filesystem();

        // Collecting information
        $name = $input->getArgument('name');
        $class = \ucfirst($name);
        $file = 'app/database/migrations/'.$class.'.php';

        // Fetching template
        $template = file_get_contents('app/storage/templates/migration.template');
        $template = str_replace('<class_name>', $class, $template);
        $template = str_replace('<table_name>', $name, $template);

        // Generating file
        $fileSystem->dumpFile($file, $template);

        $output->writeln('Migration created successfully.');
    }

}
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

        $fileSystem = new Filesystem();

        $entity = $input->getArgument('entity_name');
        $entityName = \ucfirst($entity).'Entity';
        $entity_filename = 'app/entities/'.$entityName.'.php';

        $fileSystem->dumpFile($entity_filename, '<?php');
        $fileSystem->appendToFile($entity_filename, PHP_EOL.PHP_EOL . 'namespace App\Entities;');
        $fileSystem->appendToFile($entity_filename, PHP_EOL.PHP_EOL . 'use Panther\Entity\EntityController;');
        if($input->getOption('routing') == 'internal'){
            $fileSystem->appendToFile($entity_filename, PHP_EOL . 'use Panther\Router\Router;');
            $fileSystem->appendToFile($entity_filename, PHP_EOL.PHP_EOL . 'class '.$entityName.' extends EntityController {');
            $fileSystem->appendToFile($entity_filename, PHP_EOL.PHP_EOL . '    public function routes(Router $router){	');
            $fileSystem->appendToFile($entity_filename, PHP_EOL . "        $"."router->get('/".$entity."', '".$entityName."@index');");
            $fileSystem->appendToFile($entity_filename, PHP_EOL . '    }');
            $fileSystem->appendToFile($entity_filename, PHP_EOL.PHP_EOL . '    public function index(){	');
            $fileSystem->appendToFile($entity_filename, PHP_EOL . "        return "."$"."this->toJson([ 'Hello from ".$entityName."' ]);");
            $fileSystem->appendToFile($entity_filename, PHP_EOL . '    }');
            $fileSystem->appendToFile($entity_filename, PHP_EOL.PHP_EOL . '}');
        }else{
            $fileSystem->appendToFile($entity_filename, PHP_EOL.PHP_EOL . '    public function index(){	');
            $fileSystem->appendToFile($entity_filename, PHP_EOL . "        return "."$"."this->toJson([ 'Hello from ".$entityName."' ]);");
            $fileSystem->appendToFile($entity_filename, PHP_EOL . '    }');
            $fileSystem->appendToFile($entity_filename, PHP_EOL.PHP_EOL . '}');
        }

        $output->writeln('Entity created successfully.');
        $output->writeln('NOTE: Remeber to register newly created entity in index.php');
    }

}
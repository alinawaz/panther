<?php

namespace Panther\Cli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use Panther\Database\Claw;

class MigrateCommand extends Command
{
    protected function configure()
    {
        $this
        ->setName('migrate:one')
        ->setDescription('Run a migration.');

        $this->addArgument('name', InputArgument::REQUIRED, 'Name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        // Check if migration table exists
        $db = Claw::defaultDb();
        if(!$db->table('migrations')->exists()){
            $response = $db->query('CREATE TABLE migrations (id int(11) primary key auto_increment,table_name varchar(255))');
        }

        // Check if table already migrated
        $exists = $db->table('migrations')->where('table_name', $name)->first();
        if($exists){
            $output->writeln('Table ['.$name.'] already migrated, skipped.');
            return;
        }else{
            $db->table('migrations')->insert([
                'table_name' => $name
            ]);
        }
        
        // Let's migrate      
        $output->writeln('> Migrating ['.$name.'] ...');  
        $class = "\\App\\Database\\Migrations\\".\ucfirst($name);
        $schema = NULL;
        if(getenv('DB_DEFAULT')=='MYSQL'){
            $schema = new \Panther\Database\Migrations\MysqlSchema;
        }
        $migration = new $class($schema);
        $migration->up();      

        $output->writeln('Migrated successfully.');
    }

}
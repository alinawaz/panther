<?php

namespace Panther\Cli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Panther\Database\Claw;

class MigrateAllCommand extends Command
{
    protected function configure()
    {
        $this
        ->setName('migrate:all')
        ->setDescription('Run all migrations.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Check if migration table exists
        $db = Claw::defaultDb();
        if(!$db->table('migrations')->exists()){
            $response = $db->query('CREATE TABLE migrations (id int(11) primary key auto_increment,table_name varchar(255))');
        }

        // Fehcting all migrations
        $names = array_filter(scandir('app/database/migrations'), function($item) {
            return !is_dir('app/database/migrations/' . $item);
        });

        foreach($names as $name){

            $name = explode('.', $name)[0];
            $output->writeln('> Migrating ['.$name.'] ...');  
            // Check if table already migrated
            $exists = $db->table('migrations')->where('table_name', $name)->first();
            if($exists){
                $output->writeln('Already migrated, skipped.');
            }else{
                $db->table('migrations')->insert([
                    'table_name' => $name
                ]);
            }
            
            // Let's migrate                  
            $class = "\\App\\Database\\Migrations\\".\ucfirst($name);
            $schema = NULL;
            if(getenv('DB_DEFAULT')=='MYSQL'){
                $schema = new \Panther\Database\Migrations\MysqlSchema;
            }
            $migration = new $class($schema);
            $migration->up();  
        }      

        $output->writeln('Migrated successfully.');
    }

}
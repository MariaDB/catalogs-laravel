<?php

namespace MariaDB\CatalogsLaravel\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;

class CatalogsCommand extends Command
{
    protected $signature = 'mariadb:catalogs {operation} {--name=} {--user=} {--password=}';
    protected $description = 'test command';

    public function __construct(DatabaseManager $db)
    {
        parent::__construct();

        $this->db = $db;
    }

    public function handle()
    {
        $operation = $this->argument('operation');
        
        $this->info("Executing: $operation");

        $catalogsSingeltonWrapper = $this->db->connection('mariadb_catalogs')->getCatalogsSingeltonWrapper();

        switch ($operation) {
            case 'create':
                $name = $this->option('name');
                $user = $this->option('user');
                $password = $this->option('password');
                $port = $catalogsSingeltonWrapper->create($name, $user, $password);
        
                $this->info("created with port: $port");
                break;
            case 'getPort':
                $name = $this->option('name');
                $port = $catalogsSingeltonWrapper->getPort($name);
        
                $this->info("port: $port");
                break;
            case 'list':
                $catalogs = $catalogsSingeltonWrapper->list();
                foreach ($catalogs as $catalog => $port) {
                    $this->info("catalog: $catalog port: $port");
                }
                break;
            case 'drop':
                $name = $this->option('name');
                $success = $catalogsSingeltonWrapper->drop($name);

                if ($success) {
                    $this->info("drop successful");
                }
                break;
            default:
                $this->info('Unknown operation.');
                break;
        }
    }
}

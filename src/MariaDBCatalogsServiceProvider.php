<?php

declare(strict_types=1);

namespace MariaDB\CatalogLaravel;

use Illuminate\Support\ServiceProvider;
use MariaDB\CatalogLaravel\Database\MariaDBCatalogsConnection;
use Illuminate\Database\Eloquent\Model;
use MariaDB\CatalogLaravel\Console\Commands\CatalogsCommand;
use MariaDB\CatalogLaravel\CatalogsManager;


class MariaDBCatalogsServiceProvider extends ServiceProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        'Catalogs' => CatalogsCommand::class
    ];

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        Model::setConnectionResolver($this->app['db']);

        Model::setEventDispatcher($this->app['events']);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        // Add database driver.
        $this->app->resolving('db', function ($db) {
            $db->extend('mariadb_catalogs', function ($config, $name) {
                $config['name'] = $name;

                return new MariaDBCatalogsConnection($config);
            });
        });

        $this->registerCommands($this->commands);

        $this->app->alias(CatalogsManager::class, 'catalogs');
    }

    /**
     * Register the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    protected function registerCommands(array $commands)
    {
        foreach (array_keys($commands) as $command) {
            $this->{"register{$command}Command"}();
        }

        $this->commands(array_values($commands));
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerCatalogsCommand()
    {
        $this->app->singleton(CatalogsCommand::class, function ($app) {
            return new CatalogsCommand($app['db']);
        });
    }
}
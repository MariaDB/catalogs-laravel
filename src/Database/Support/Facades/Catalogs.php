<?php

namespace MariaDB\CatalogLaravel\Database\Support\Facades;

use Illuminate\Support\Facades;

/**
 * @method int create(string $catName, string $catUser = null, string $catPassword=null, array $args=null)
 * @method int getPort(string $catName)
 * @method array show()
 * @method bool drop(string $catName)
 *
 * @see \Illuminate\Database\DatabaseManager
 */
class Catalogs extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'catalogs';
    }
}

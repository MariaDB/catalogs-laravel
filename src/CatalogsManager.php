<?php

namespace MariaDB\CatalogLaravel;

use Mariadb\CatalogsPHP\CatalogManager;
use Illuminate\Database\DatabaseManager;

/**
 * @method int create(string $catName, string $catUser = null, string $catPassword=null, array $args=null)
 * @method int getPort(string $catName)
 * @method array show()
 * @method bool drop(string $catName)
 */
class CatalogsManager
{
    protected $db;

    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    public function __call($name, $arguments) 
    {
        return $this->db->connection('mariadb_catalogs')->getCatalogsSingeltonWrapper()->$name(...$arguments);
    }

}

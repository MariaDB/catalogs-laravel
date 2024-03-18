<?php

namespace MariaDB\CatalogsLaravel\Database\Schema;

use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Connection;
use MariaDB\CatalogsLaravel\Database\CatalogsSingeltonWrapper;

/**
 * Class MariaDBCatalogsBuilder
 * 
 * @method int create(string $catName, string $catUser = null, string $catPassword=null, array $args=null)
 * @method int getPort(string $catName)
 * @method array list()
 * @method bool drop(string $catName)
 */
class MariaDBCatalogsBuilder extends Builder {

    public function createCatalogs(string $catName, string $catUser = null, string $catPassword=null, array $args=null)
    {
        return $this->connection->getCatalogsSingeltonWrapper()->create($catName, $catName, $catPassword, $args);
    }

    public function getCatalogsPort(string $catName)
    {
        return $this->connection->getCatalogsSingeltonWrapper()->getPort($catName);
    }

    public function showCatalogs()
    {
        return $this->connection->getCatalogsSingeltonWrapper()->show();
    }

    public function dropCatalogs(string $catName)
    {
        return $this->connection->getCatalogsSingeltonWrapper()->drop($catName);
    }
}

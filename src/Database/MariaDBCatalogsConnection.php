<?php

namespace MariaDB\CatalogLaravel\Database;

use Illuminate\Database\MySqlConnection;
use MariaDB\CatalogLaravel\CatalogsSingeltonWrapper;

class MariaDBCatalogsConnection extends MySqlConnection
{
    private CatalogsSingeltonWrapper $catalogsSingeltonWrapper;

    public function __construct($pdo, $database = '', $tablePrefix = '', array $config = [])
    {
                
        $this->catalogsSingeltonWrapper = CatalogsSingeltonWrapper::getInstance($pdo);

        parent::__construct($pdo, $database, $tablePrefix, $config);
    }

    public function getCatalogsSingeltonWrapper() {
        return $this->catalogsSingeltonWrapper;
    }

    /**
     * Get a schema builder instance for the connection.
     *
     * @return \Illuminate\Database\Schema\MySqlBuilder
     */
    public function getSchemaBuilder()
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }

        return new MariaDBCatalogsBuilder($this);
    }
}

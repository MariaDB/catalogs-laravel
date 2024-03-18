<?php

namespace MariaDB\CatalogLaravel;

use Mariadb\CatalogsPHP\CatalogManager;

/**
 * @method int create(string $catName, string $catUser = null, string $catPassword=null, array $args=null)
 * @method int getPort(string $catName)
 * @method array show()
 * @method bool drop(string $catName)
 */
class CatalogsSingeltonWrapper
{
    private static ?CatalogsSingeltonWrapper $instance = null;
    private static ?CatalogManager $catalogInstance = null;

    public static function getInstance($pdo): CatalogsSingeltonWrapper
    {
        if (self::$instance === null) {
            self::$instance = new CatalogsSingeltonWrapper();

            if(is_array($pdo)){
                self::$catalogInstance = new CatalogManager($pdo['host'], $pdo['port'], $pdo['username'], $pdo['password'], null);
            } else {
                self::$catalogInstance = new CatalogManager('', 0, '', '', null, $pdo);
            }
        }

        return self::$instance;
    }

    public function __call($name, $arguments) 
    {
        return self::$catalogInstance->$name(...$arguments);
    }
    
    private function __construct()
    {
    }

    /**
     * prevent the instance from being cloned (which would create a second instance of it)
     */
    private function __clone()
    {
    }

    /**
     * prevent from being unserialized (which would create a second instance of it)
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }

}

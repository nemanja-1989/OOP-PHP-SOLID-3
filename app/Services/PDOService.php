<?php 

namespace App\Services;

use App\Contracts\ServiceInterface;
use PDO;

class PDOService implements ServiceInterface{

    protected static $instance;

    private function __construct() {
        /** PRIVATE */
    }
    public static function getService()  {
        if(! isset(self::$instance))
            self::$instance = new self;
        return self::$instance;
    }

    public static function pdoConnect(): PDO {
        self::getService();
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();
        $host = $_ENV['HOST'];
        $db   = $_ENV['DB'];
        $user = $_ENV['USER'];
        $pass = $_ENV['PASS'];
        $charset = $_ENV['CHARSET'];
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        try {
            return new PDO($dsn, $user, $pass);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}
<?php 

namespace App\Services;

use App\Contracts\ServiceInterface;
use Predis\Client;

class RedisService implements ServiceInterface{

    protected static $instance;

    public static function getInstance() {
        if(! isset(self::$instance))
            self::$instance = new self;
        
            return self::$instance;
    }

    private function __construct() {
        /** PRIVATE */
    }
    /**
     * @return Client
     */
    public static function getService() :Client {
        self::getInstance();
        return new \Predis\Client;
    }
}
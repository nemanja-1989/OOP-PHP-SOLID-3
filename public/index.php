<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Classes\Router;

$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$router = new Router();

$router->get('/', function() {
    require_once dirname(__DIR__) . '/app/resources/views/students.phtml';
});

$router->get('/student', function($params) {
    require_once dirname(__DIR__) . '/app/resources/views/student.phtml';
});

$router->run();

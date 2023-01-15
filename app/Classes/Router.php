<?php 

namespace App\Classes;

class Router {

    private array $handlers;
    CONST METHOD_GET = 'GET';

    public function get(string $path, $handler) {
        $this->handle(self::METHOD_GET, $path, $handler);
    }

    private function handle(string $method, string $path, $handler) {
        $this->handlers[$method . $path] = [
            'path' => $path,
            'method' => $method,
            'handler' => $handler
        ];
    }

    public function run() {
        $requestURI = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestURI['path'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $callback = null;
        foreach($this->handlers as $handler) {
            if($requestPath === $handler['path'] && $requestMethod === $handler['method']) {
                $callback = $handler['handler'];
            }
        }

        if(is_string($callback)) {
            $explode = explode("::", $callback);
            $className = array_shift($explode);
            $handler = new $className;
            $method = array_shift($explode);
            $callback = [$handler, $method];
        }

        if(!$callback) {
            header('HTTP/1.0 404 Page not found!');
            return;
        }
        call_user_func_array($callback, [$_GET]);
    }
}
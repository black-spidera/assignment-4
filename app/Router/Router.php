<?php

namespace App\Router;

use App\Controller\HomeController;

class Router
{
    private $routes = [];

    public function addRoute($route, $handler)
    {
        $this->routes[$route] = $handler;
    }

    public function dispatch($requestUrl)
    {
        foreach ($this->routes as $route => $handler) {
            if (is_callable($handler && $route === $requestUrl)) {
                return call_user_func($handler);
            }
        }
        // header('Location:404.php');
    }

    public function registerRouter()
    {
        $this->addRoute('/', [new HomeController(), 'index']);
        $this->addRoute('/index', [new HomeController(), 'index']);
        $this->addRoute('/home', [new HomeController(), 'index']);


        $this->dispatch($_SERVER['REQUEST_URI']);
    }
}

<?php declare(strict_types=1);

namespace App;

use App\Controllers\HttpController;

class Router
{
    /**
     * Route registrar.
     *
     * @var array
     */
    private array $routes = [];

    /**
     * Register a route.
     *
     * $route is the route key and $method is either a string in the format
     * ControllerName::methodName or a Callable.
     *
     * @param string          $route
     * @param string|callable $method
     *
     * @return void
     */
    public function register(string $route, $method) : void
    {
        $this->routes[$route] = $method;
    }

    /**
     * Get the rendered content for the provided route.
     *
     * @param string $route
     *
     * @return Response
     */
    public function callRouteMethod(string $route) : Response
    {
        $method = $this->routes[$route];
        $uri = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        if (is_callable($method)) {
            $response_data = $method();
        } elseif (isset($this->routes[$route])) {
            list($controller, $method) = explode('::', $this->routes[$route]);

            $class = 'App\\Controllers\\' . $controller;

            $response_data = (new $class)->$method(new Request($uri));

        } else {
            $response_data = (new HttpController)->http404(new Request($uri));
        }

        return new Response($response_data);
    }

    /**
     * Getter for $routes.
     *
     * @return array
     */
    public function getRoutes() : array
    {
        return $this->routes;
    }

    /**
     * Setter for $routes.
     *
     * @param array $routes
     *
     * @return void
     */
    public function setRoutes(array $routes) : void
    {
        $this->routes = $routes;
    }
}
<?php

namespace DeParis\Kernel\Routing;

use DeParis\Kernel\Http\Exceptions\MethodNotAllowedException;
use DeParis\Kernel\Http\Exceptions\RouteNotFoundException;
use DeParis\Kernel\Http\Request;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    /**
     * @throws RouteNotFoundException
     * @throws MethodNotAllowedException
     */
    public function dispatch(Request $request): array
    {
        [$handler, $vars] = $this->extractRouteInfo($request);

        if (is_array($handler)) {
            [$controller, $method] = $handler;
            $handler = [new $controller, $method];
        }

        return [$handler, $vars];
    }

    /**
     * @throws RouteNotFoundException
     * @throws MethodNotAllowedException
     */
    private function extractRouteInfo(Request $request): array
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            $routes = include BASE_PATH.'/routes/web.php';

            foreach ($routes as $route){
                $collector->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch(
            $request->getRequestMethod(),
            $request->getPath()
        );

        switch ($routeInfo[0]) {
            case Dispatcher::FOUND:
                return [$routeInfo[1], $routeInfo[2]];
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = implode(' or ', $routeInfo[1]);
                $message = "HTTP-method not supported. Try to use HTTP-method $allowedMethods";
                $e = new MethodNotAllowedException($message);
                $e->setStatusCode(405);
                throw $e;
            default:
                $e = new RouteNotFoundException("Route Not Found");
                $e->setStatusCode(404);
                throw $e;
        }
    }
}
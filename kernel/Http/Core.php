<?php

namespace DeParis\Kernel\Http;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Core
{
    public function handle(Request $request): Response
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

        [$status, [$controller, $method], $vars] = $routeInfo;

        return call_user_func_array([new $controller, $method], $vars);
    }
}
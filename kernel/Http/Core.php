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

        [$status, $handler, $vars] = $routeInfo;

        return $handler($vars);
    }
}
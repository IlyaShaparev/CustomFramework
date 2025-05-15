<?php

namespace DeParis\Kernel\Http;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Core
{
    public function handle(Request $request): Response
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            $collector->get('/', function () {
                $content = '<h1>Hello, World!!!!</h1>';

                return new Response($content);
            });

            $collector->get('/cars/{name}', function(array $vars) {
                $content = "<h1>Car - {$vars['name']}</h1>";

                return new Response($content);
            });
        });

        $routeInfo = $dispatcher->dispatch(
            $request->getRequestMethod(),
            $request->getPath()
        );

        [$status, $handler, $vars] = $routeInfo;

        return $handler($vars);
    }
}
<?php

namespace DeParis\Kernel\Http;

use DeParis\Kernel\Routing\RouterInterface;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Core
{
    public function __construct(
        private RouterInterface $router
    ){
    }

    public function handle(Request $request): Response
    {
        try {
            [$routeHandler, $vars] = $this->router->dispatch($request);

            $response = call_user_func_array($routeHandler, $vars);
        } catch (\Exception $e) {
            $response = new Response($e->getMessage(), 500);
        }

        return $response;
    }
}
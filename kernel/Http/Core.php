<?php

namespace DeParis\Kernel\Http;

use DeParis\Kernel\Http\Exceptions\HttpException;
use DeParis\Kernel\Http\Exceptions\MethodNotAllowedException;
use DeParis\Kernel\Http\Exceptions\RouteNotFoundException;
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
        } catch (HttpException $e) {
            $response = new Response($e->getMessage(), $e->getStatusCode());
        } catch (\Exception $e) {
            $response = new Response($e->getMessage(), 500);
        }

        return $response;
    }
}
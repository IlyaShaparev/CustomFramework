<?php

namespace App\Controllers;

use DeParis\Kernel\Http\Response;

class CarController
{
    public function show(string $name): Response
    {
        $content = "<h1>Car - {$name}</h1>";

        return new Response($content);
    }
}
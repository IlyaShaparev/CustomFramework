<?php

namespace DeParis\Kernel\Routing;

use DeParis\Kernel\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request);
}
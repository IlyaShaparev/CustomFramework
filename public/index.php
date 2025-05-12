<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

use DeParis\Kernel\Http\Core;
use DeParis\Kernel\Http\Request;

$request = Request::createFromGlobals();

$core = new Core();
$response = $core->handle($request);

$response->send();

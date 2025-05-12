<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

use DeParis\Kernel\Http\Request;

$request = Request::createFromGlobals();
dd($request);

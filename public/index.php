<?php
define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH.'/vendor/autoload.php';

use DeParis\Kernel\Http\Core;
use DeParis\Kernel\Http\Request;

// TODO: Убрать по завершению работ
$whoops = new Whoops\Run;
$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
$whoops->register();
$request = Request::createFromGlobals();

$core = new Core();
$response = $core->handle($request);

$response->send();

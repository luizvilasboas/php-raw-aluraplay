<?php

use Olooeez\AluraPlay\Repository\VideoRepository;
use Olooeez\AluraPlay\Controller\VideoFormController;
use Olooeez\AluraPlay\Controller\VideoListController;
use Olooeez\AluraPlay\Controller\EditVideoController;
use Olooeez\AluraPlay\Controller\DeleteVideoController;
use Olooeez\AluraPlay\Controller\Error404Controller;
use Olooeez\AluraPlay\Controller\NewVideoController;

require_once(__DIR__ . "/../vendor/autoload.php");

$dbPath = __DIR__ . "/../banco.sqlite";
$pdo = new PDO("sqlite:$dbPath");
$videoRepository = new VideoRepository($pdo);


$routes = require_once __DIR__ . "/../config/routes.php";
$pathInfo = $_SERVER["PATH_INFO"] ?? "/";
$httpMethod = $_SERVER["REQUEST_METHOD"];

$key = "$httpMethod|$pathInfo";
$controller = null;

if (array_key_exists($key, $routes)) {
  $controllerClass = $routes[$key];
  $controller = new $controllerClass($videoRepository);
} else {
  $controller = new Error404Controller();
}

$controller->indexAction();

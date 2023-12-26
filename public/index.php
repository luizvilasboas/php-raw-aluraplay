<?php

use Olooeez\AluraPlay\Repository\VideoRepository;
use Olooeez\AluraPlay\Controller\VideoFormController;
use Olooeez\AluraPlay\Controller\VideoListController;
use Olooeez\AluraPlay\Controller\EditVideoController;
use Olooeez\AluraPlay\Controller\DeleteVideoController;
use Olooeez\AluraPlay\Controller\Error404Controller;
use Olooeez\AluraPlay\Controller\NewVideoController;

require_once(__DIR__ . "/../vendor/autoload.php");

$dbPath = __DIR__ . '/../banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");
$videoRepository = new VideoRepository($pdo);

if (!array_key_exists('PATH_INFO', $_SERVER) || $_SERVER['PATH_INFO'] === '/') {
    $controller = new VideoListController($videoRepository);
} elseif ($_SERVER['PATH_INFO'] === '/novo-video') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $controller = new VideoFormController($videoRepository);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new NewVideoController($videoRepository);
    }
} elseif ($_SERVER['PATH_INFO'] === '/editar-video') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $controller = new VideoFormController($videoRepository);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new EditVideoController($videoRepository);
    }
} elseif ($_SERVER['PATH_INFO'] === '/remover-video') {
    $controller = new DeleteVideoController($videoRepository);
} else {
    $controller = new Error404Controller();
}

$controller->indexAction();

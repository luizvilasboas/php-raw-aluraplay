<?php

return [
    'GET|/' => \Olooeez\AluraPlay\Controller\VideoListController::class,
    'GET|/novo-video' => \Olooeez\AluraPlay\Controller\VideoFormController::class,
    'POST|/novo-video' => \Olooeez\AluraPlay\Controller\NewVideoController::class,
    'GET|/editar-video' => \Olooeez\AluraPlay\Controller\VideoFormController::class,
    'POST|/editar-video' => \Olooeez\AluraPlay\Controller\EditVideoController::class,
    'GET|/remover-video' => \Olooeez\AluraPlay\Controller\DeleteVideoController::class,
];

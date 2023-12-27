<?php

use DI\ContainerBuilder;
use Olooeez\AluraPlay\Repository\UserRepository;
use Olooeez\AluraPlay\Repository\VideoRepository;
use Psr\Container\ContainerInterface;

$builder = new ContainerBuilder();
$builder->addDefinitions([
  PDO::class => function (): PDO {
    $dbPath = __DIR__ . "/../banco.sqlite";
    return new PDO("sqlite:$dbPath");
  },

  VideoRepository::class => function (ContainerInterface $container): VideoRepository {
    return new VideoRepository($container->get(PDO::class));
  },

  UserRepository::class => function (ContainerInterface $container): UserRepository {
    return new UserRepository($container->get(PDO::class));
  }
]);

$container = $builder->build();

return $container;

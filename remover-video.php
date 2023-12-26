<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$id = $_GET['id'];

$repository = new Olooeez\AluraPlay\Repository\VideoRepository($pdo);

if ($repository->remove(intval($id))) {
    header('Location: /?sucesso=0');
} else {
    header('Location: /index.php?sucesso=1');
}

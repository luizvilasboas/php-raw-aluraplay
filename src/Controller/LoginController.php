<?php

namespace Olooeez\AluraPlay\Controller;

use Nyholm\Psr7\Response;
use Olooeez\AluraPlay\Helper\FlashMessageTrait;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LoginController implements Controller
{
  use FlashMessageTrait;

  private \PDO $pdo;

  public function __construct()
  {
    $dbPath = __DIR__ . "/../../banco.sqlite";
    $this->pdo = new \PDO("sqlite:$dbPath");
  }

  public function indexAction(RequestInterface $request): ResponseInterface
  {
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, "password");

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(1, $email);
    $stmt->execute();

    $userData = $stmt->fetch(\PDO::FETCH_ASSOC);
    $correctPassword = password_verify($password, $userData["password"] ?? "");

    if ($correctPassword) {
      $_SESSION["logged"] = true;
      return new Response(200, [
        "Location" => "/"
      ]);
    } else {
      $this->addErrorMessage("Usuário ou senha inválidos");
      return new Response(302, [
        "Location" => "/login"
      ]);
    }
  }
}

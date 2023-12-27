<?php

namespace Olooeez\AluraPlay\Controller;

use Nyholm\Psr7\Response;
use Olooeez\AluraPlay\Helper\FlashMessageTrait;
use Olooeez\AluraPlay\Repository\UserRepository;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use PDO;
use Psr\Http\Server\RequestHandlerInterface;

class LoginController implements RequestHandlerInterface
{
  use FlashMessageTrait;

  private UserRepository $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository; 
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $requestBody = $request->getParsedBody();
    $email = filter_var($requestBody["email"], FILTER_VALIDATE_EMAIL);
    $password = $requestBody["password"];

    $user = $this->userRepository->findByEmail($email);

    $correctPassword = password_verify($password, $user->getPassword() ?? "");

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

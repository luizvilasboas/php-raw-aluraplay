<?php

namespace Olooeez\AluraPlay\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use League\Plates\Engine;

class LoginFormController implements RequestHandlerInterface
{
  private Engine $templates;

  public function __construct(Engine $templates)
  {
    $this->templates = $templates;
  }
  
  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    if (array_key_exists("logged", $_SESSION) && $_SESSION["logged"]) {
      return new Response(302, [
        "Location" => "/"
      ]);
    }

    return new Response(200, [], $this->templates->render("login-form"));
  }
}

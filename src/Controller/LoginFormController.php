<?php

namespace Olooeez\AluraPlay\Controller;

use Nyholm\Psr7\Response;
use Olooeez\AluraPlay\Helper\HtmlRendererTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginFormController implements Controller
{
  use HtmlRendererTrait;

  public function indexAction(ServerRequestInterface $request): ResponseInterface
  {
    if (array_key_exists("logged", $_SESSION) && $_SESSION["logged"]) {
      return new Response(200, [
        "Location" => "/"
      ]);
    }

    return new Response(401, [], $this->renderTemplate("login-form"));
  }
}

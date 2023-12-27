<?php

namespace Olooeez\AluraPlay\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LogoutController implements Controller
{
  public function indexAction(RequestInterface $request): ResponseInterface
  {
    session_destroy();
    return new Response(200, [
      "Location" => "/login"
    ]);
  }
}

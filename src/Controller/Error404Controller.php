<?php

namespace Olooeez\AluraPlay\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Error404Controller implements Controller
{
  public function indexAction(RequestInterface $request): ResponseInterface
  {
    return new Response(404);
  }
}

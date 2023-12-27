<?php

namespace Olooeez\AluraPlay\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface Controller
{
  public function indexAction(ServerRequestInterface $request): ResponseInterface;
}

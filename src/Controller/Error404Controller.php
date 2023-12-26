<?php

namespace Olooeez\AluraPlay\Controller;

class Error404Controller implements Controller
{
  public function indexAction(): void
  {
    http_response_code(404);
  }
}

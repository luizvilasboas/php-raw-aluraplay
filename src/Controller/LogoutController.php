<?php

namespace Olooeez\AluraPlay\Controller;

class LogoutController implements Controller
{
  public function indexAction(): void
  {
    session_destroy();
    header("Location: /login");
  }
}

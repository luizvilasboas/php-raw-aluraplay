<?php

namespace Olooeez\AluraPlay\Controller;

class LoginFormController implements Controller
{
  public function indexAction(): void
  {
    if (array_key_exists("logged", $_SESSION) && $_SESSION["logged"]) {
      header("Location: /");
      return;
    }

    require_once(__DIR__ . "/../../views/login-form.php");
  }
}

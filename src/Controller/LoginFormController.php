<?php

namespace Olooeez\AluraPlay\Controller;

class LoginFormController extends ControllerWithHtml implements Controller
{
  public function indexAction(): void
  {
    if (array_key_exists("logged", $_SESSION) && $_SESSION["logged"]) {
      header("Location: /");
      return;
    }

    echo $this->renderTemplate("login-form");
  }
}

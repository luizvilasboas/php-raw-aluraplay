<?php

namespace Olooeez\AluraPlay\Helper;

trait FlashMessageTrait
{
  private function addErrorMessage(string $message): void
  {
    $_SESSION["error_message"] = $message;
  }
}

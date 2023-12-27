<?php

namespace Olooeez\AluraPlay\Entity;

class User
{
  private readonly int $id;
  private readonly string $email;
  private readonly string $password;

  public function __construct(string $email, string $password)
  {
    $this->email = $email;
    $this->password = $password;
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function setId(int $id): void
  {
    $this->id = $id;
  }

  public function getPassword(): string
  {
    return $this->password;
  }
}

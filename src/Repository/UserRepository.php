<?php

namespace Olooeez\AluraPlay\Repository;

use Olooeez\AluraPlay\Entity\User;
use PDO;

class UserRepository
{
  private PDO $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function findByEmail(string $email): ?User
  {
    $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    
    return $this->hydrateUser($stmt->fetch(PDO::FETCH_ASSOC));
  }

  private function hydrateUser(array $userData): User
  {
    $user = new User($userData["email"], $userData["password"]);
    $user->setId($userData["id"]);

    return $user;
  }
}

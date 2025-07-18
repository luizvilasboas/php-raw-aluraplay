<?php

namespace Olooeez\AluraPlay\Repository;

use Olooeez\AluraPlay\Entity\Video;
use PDO;

class VideoRepository
{
  private PDO $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function add(Video $video): bool
  {
    $sql = "INSERT INTO videos (url, title, image_path) VALUES (?, ?, ?)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(1, $video->url);
    $stmt->bindValue(2, $video->title);
    $stmt->bindValue(3, $video->getFilePath());
    $result = $stmt->execute();

    $video->setId(intval($this->pdo->lastInsertId()));

    return $result;
  }

  public function remove(int $id): bool
  {
    $sql = "DELETE FROM videos WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(1, $id);

    return $stmt->execute();
  }

  public function update(Video $video): bool
  {
    $sql = "UPDATE videos SET url = :url, title = :title, image_path = :image_path WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":url", $video->url);
    $stmt->bindValue(":title", $video->title);
    $stmt->bindValue(":image_path", $video->getFilePath());
    $stmt->bindValue(":id", $video->id, PDO::PARAM_INT);

    return $stmt->execute();
  }

  public function all(): array
  {
    $videoList = $this->pdo->query("SELECT * FROM videos")->fetchAll(PDO::FETCH_ASSOC);

    return array_map($this->hydrateVideo(...), $videoList);
  }

  public function find(int $id): Video
  {
    $stmt = $this->pdo->prepare("SELECT * FROM videos WHERE id = ?");
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();

    return $this->hydrateVideo($stmt->fetch(PDO::FETCH_ASSOC));
  }

  private function hydrateVideo(array $videoData): Video
  {
    $video = new Video($videoData["url"], $videoData["title"]);
    $video->setId($videoData["id"]);

    if ($videoData["image_path"] !== null) {
      $video->setFilePath($videoData["image_path"]);
    }

    return $video;
  }
}

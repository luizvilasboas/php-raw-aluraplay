<?php

namespace Olooeez\AluraPlay\Controller;

use Olooeez\AluraPlay\Repository\VideoRepository;
use Olooeez\AluraPlay\Entity\Video;

class EditVideoController implements Controller
{
  private VideoRepository $videoRepository;

  public function __construct(VideoRepository $videoRepository)
  {
    $this->videoRepository = $videoRepository;
  }

  public function indexAction(): void
  {
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    if ($id === false || $id === null) {
      header("Location: /?sucesso=0");
      return;
    }

    $url = filter_input(INPUT_POST, "url", FILTER_VALIDATE_URL);
    if ($url === false) {
      header("Location: /?sucesso=0");
      return;
    }
    $titulo = filter_input(INPUT_POST, "titulo");
    if ($titulo === false) {
      header("Location: /?sucesso=0");
      return;
    }

    $video = new Video($url, $titulo);
    $video->setId($id);

    if ($_FILES["image"]["error"] === UPLOAD_ERR_OK) {
      $new_file_name = uniqid("upload_") . $_FILES["image"]["name"];
      move_uploaded_file($_FILES["image"]["tmp_name"], __DIR__ . "/../../public/img/uploads/" . $new_file_name);
      
      $video->setFilePath($new_file_name);
    }

    if (!$this->videoRepository->update($video)) {
      header("Location: /?sucesso=0");
    } else {
      header("Location: /?sucesso=1");
    }
  }
}

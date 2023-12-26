<?php

namespace Olooeez\AluraPlay\Controller;

use Olooeez\AluraPlay\Repository\VideoRepository;
use Olooeez\AluraPlay\Entity\Video;

class NewVideoController implements Controller
{
  private VideoRepository $videoRepository;

  public function __construct(VideoRepository $videoRepository)
  {
    $this->videoRepository = $videoRepository;
  }

  public function indexAction(): void
  {
    $url = filter_input(INPUT_POST, "url", FILTER_VALIDATE_URL);
    if ($url === false) {
      header("Location: /?sucesso=0");
      exit();
    }
    $titulo = filter_input(INPUT_POST, "titulo");
    if ($titulo === false) {
      header("Location: /?sucesso=0");
      exit();
    }

    $video = new Video($url, $titulo);
    if ($_FILES["image"]["error"] === UPLOAD_ERR_OK) {
      $new_file_name = uniqid("upload_") . $_FILES["image"]["name"];
      move_uploaded_file($_FILES["image"]["tmp_name"], __DIR__ . "/../../public/img/uploads/" . $new_file_name);
      
      $video->setFilePath($new_file_name);
    }

    if (!$this->videoRepository->add(new Video($url, $titulo))) {
      header("Location: /?sucesso=0");
    } else {
      header("Location: /?sucesso=1");
    }
  }
}

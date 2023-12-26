<?php

namespace Olooeez\AluraPlay\Controller;

use Olooeez\AluraPlay\Repository\VideoRepository;
use Olooeez\AluraPlay\Entity\Video;

class VideoFormController implements Controller
{
  private VideoRepository $videoRepository;

  public function __construct(VideoRepository $videoRepository)
  {
    $this->videoRepository = $videoRepository;
  }

  public function indexAction(): void
  {
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    $video = null;

    if ($id !== false && $id !== null) {
      $video = $this->videoRepository->find($id);
    }
  
    require_once(__DIR__ . "/../../views/video-form.php");
  }
}

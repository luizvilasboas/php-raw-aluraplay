<?php

namespace Olooeez\AluraPlay\Controller;

use Olooeez\AluraPlay\Repository\VideoRepository;
use PDO;

class VideoListController extends ControllerWithHtml implements Controller
{
  private VideoRepository $videoRepository;

  public function __construct(VideoRepository $videoRepository)
  {
    $this->videoRepository = $videoRepository;
  }

  public function indexAction(): void
  {
    $videoList = $this->videoRepository->all();
    echo $this->renderTemplate("video-list", ["videoList" => $videoList]);
  }
}

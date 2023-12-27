<?php

namespace Olooeez\AluraPlay\Controller;

use Nyholm\Psr7\Response;
use Olooeez\AluraPlay\Helper\HtmlRendererTrait;
use Olooeez\AluraPlay\Repository\VideoRepository;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class VideoFormController implements Controller
{
  use HtmlRendererTrait;

  private VideoRepository $videoRepository;

  public function __construct(VideoRepository $videoRepository)
  {
    $this->videoRepository = $videoRepository;
  }

  public function indexAction(RequestInterface $request): ResponseInterface
  {
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    $video = null;

    if ($id !== false && $id !== null) {
      $video = $this->videoRepository->find($id);
    }
  
    return new Response(200, [], $this->renderTemplate("video-list", ["video" => $video]));
  }
}

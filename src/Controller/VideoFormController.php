<?php

namespace Olooeez\AluraPlay\Controller;

use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Olooeez\AluraPlay\Repository\VideoRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoFormController implements RequestHandlerInterface
{
  private VideoRepository $videoRepository;
  private Engine $templates;

  public function __construct(VideoRepository $videoRepository, Engine $templates)
  {
    $this->videoRepository = $videoRepository;
    $this->templates = $templates;
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $queryParams = $request->getQueryParams();
    $id = filter_var($queryParams["id"] ?? "", FILTER_VALIDATE_INT);
    $video = null;

    if ($id !== false && $id !== null) {
      $video = $this->videoRepository->find($id);
    }
  
    return new Response(200, [], $this->templates->render("video-form", ["video" => $video]));
  }
}

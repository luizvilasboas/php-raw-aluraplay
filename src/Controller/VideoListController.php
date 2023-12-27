<?php

namespace Olooeez\AluraPlay\Controller;

use Nyholm\Psr7\Response;
use Olooeez\AluraPlay\Repository\VideoRepository;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use League\Plates\Engine;

class VideoListController implements RequestHandlerInterface
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
    $videoList = $this->videoRepository->all();
    return new Response(200, [], $this->templates->render("video-list", ["videoList" => $videoList]));
  }
}

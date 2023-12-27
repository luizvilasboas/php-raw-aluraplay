<?php

namespace Olooeez\AluraPlay\Controller;

use Nyholm\Psr7\Response;
use Olooeez\AluraPlay\Helper\HtmlRendererTrait;
use Olooeez\AluraPlay\Repository\VideoRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoFormController implements RequestHandlerInterface
{
  use HtmlRendererTrait;

  private VideoRepository $videoRepository;

  public function __construct(VideoRepository $videoRepository)
  {
    $this->videoRepository = $videoRepository;
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $queryParams = $request->getQueryParams();
    $id = filter_var($queryParams["id"], FILTER_VALIDATE_INT);
    $video = null;

    if ($id !== false && $id !== null) {
      $video = $this->videoRepository->find($id);
    }
  
    return new Response(200, [], $this->renderTemplate("video-form", ["video" => $video]));
  }
}

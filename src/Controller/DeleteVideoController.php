<?php

namespace Olooeez\AluraPlay\Controller;

use Olooeez\AluraPlay\Helper\FlashMessageTrait;
use Olooeez\AluraPlay\Repository\VideoRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;

class DeleteVideoController implements Controller
{
  use FlashMessageTrait;

  private VideoRepository $videoRepository;

  public function __construct(VideoRepository $videoRepository)
  {
    $this->videoRepository = $videoRepository;
  }

  public function indexAction(ServerRequestInterface $request): ResponseInterface
  {
    $queryParams = $request->getQueryParams();
    $id = filter_var($queryParams["id"], FILTER_VALIDATE_INT);
    if ($id === null || $id === false) {
      $this->addErrorMessage("ID de vídeo inválido.");
      return new Response(302, [
        "Location" => "/"
      ]);
    }

    if (!$this->videoRepository->remove($id)) {
      $this->addErrorMessage("Não foi possível excluir o vídeo.");
      return new Response(302, [
        "Location" => "/"
      ]);
    } else {
      return new Response(200, [
        "Location" => "/"
      ]);
    }
  }
}

<?php

namespace Olooeez\AluraPlay\Controller;

use finfo;
use Nyholm\Psr7\Response;
use Olooeez\AluraPlay\Helper\FlashMessageTrait;
use Olooeez\AluraPlay\Repository\VideoRepository;
use Olooeez\AluraPlay\Entity\Video;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EditVideoController implements RequestHandlerInterface
{
  use FlashMessageTrait;

  private VideoRepository $videoRepository;

  public function __construct(VideoRepository $videoRepository)
  {
    $this->videoRepository = $videoRepository;
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $queryParams = $request->getQueryParams();
    $id = filter_var($queryParams["id"], FILTER_VALIDATE_INT);
    if ($id === false || $id === null) {
      $this->addErrorMessage("O ID do vídeo é inválido");
      return new Response(302, [
        "Location" => "/"
      ]);
    }
    
    $requestBody = $request->getParsedBody();
    $url = filter_var($requestBody["url"], FILTER_VALIDATE_URL);
    if ($url === false) {
      $this->addErrorMessage("A URL do vídeo é inválida");
      return new Response(302, [
        "Location" => "/"
      ]);
    }

    $titulo = $requestBody["titulo"];
    if ($titulo === false) {
      $this->addErrorMessage("O título do vídeo é inválido");
      return new Response(302, [
        "Location" => "/"
      ]);
    }

    $video = new Video($url, $titulo);
    $video->setId($id);

    $files = $request->getUploadedFiles();
    $uploadedImage = $files["image"];
    if ($uploadedImage->getError() === UPLOAD_ERR_OK) {
      $finfo = new finfo(FILEINFO_MIME_TYPE);
      $tmpFile = $uploadedImage->getStream()->getMetadata("uri");
      $mimeType = $finfo->file($tmpFile);

      if ((str_starts_with($mimeType, "image/"))) {
        $safeFileName = uniqid("upload_") . "_" . pathinfo($uploadedImage->getClientFilename(), PATHINFO_BASENAME);
        $uploadedImage->moveTo(__DIR__ . "/../../public/img/uploads/" . $safeFileName);
        $video->setFilePath($safeFileName);
      }
    }

    if (!$this->videoRepository->update($video)) {
      $this->addErrorMessage("Não foi possível editar o vídeo");
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

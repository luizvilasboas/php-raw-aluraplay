<?php

namespace Olooeez\AluraPlay\Controller;

use finfo;
use Nyholm\Psr7\Response;
use Olooeez\AluraPlay\Helper\FlashMessageTrait;
use Olooeez\AluraPlay\Repository\VideoRepository;
use Olooeez\AluraPlay\Entity\Video;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NewVideoController implements RequestHandlerInterface
{
  use FlashMessageTrait;

  private VideoRepository $videoRepository;

  public function __construct(VideoRepository $videoRepository)
  {
    $this->videoRepository = $videoRepository;
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $requestBody = $request->getParsedBody();
    $url = filter_var($requestBody["url"], FILTER_VALIDATE_URL);
    if ($url === false) {
      $this->addErrorMessage("URL inválida");
      return new Response(302, [
        "Location" => "/novo-video"
      ]);
    }

    $titulo = filter_var($requestBody["titulo"]);
    if ($titulo === false) {
      $this->addErrorMessage("Título inválido");
      return new Response(302, [
        "Location" => "/novo-video"
      ]);
    }

    $video = new Video($url, $titulo);
    $files = $request->getUploadedFiles();
    $uploadedImage = $files["image"];
    if ($uploadedImage->getError() === UPLOAD_ERR_OK) {
      $finfo = new finfo(FILEINFO_MIME_TYPE);
      $tmpFile = $uploadedImage->getStream()->getMetadata("uri");
      $mimeType = $finfo->file($tmpFile);

      if (str_starts_with($mimeType, "image/")) {
        $safeFileName = uniqid("upload_") . "_" . pathinfo($uploadedImage->getClientFilename(), PATHINFO_BASENAME);
        $uploadedImage->moveTo(__DIR__ . "/../../public/img/uploads/" . $safeFileName);
        $video->setFilePath($safeFileName);
      }
    }

    if (!$this->videoRepository->add($video)) {
      $this->addErrorMessage("Falha ao adicionar vídeo");
      return new Response(302, [
        "Location" => "/novo-video"
      ]);
    }

    return new Response(200, [
      "Location" => "/"
    ]);
  }
}

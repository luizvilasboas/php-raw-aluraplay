<?php

namespace Olooeez\AluraPlay\Controller;

use Nyholm\Psr7\Response;
use Olooeez\AluraPlay\Helper\FlashMessageTrait;
use Olooeez\AluraPlay\Helper\HtmlRendererTrait;
use Olooeez\AluraPlay\Repository\VideoRepository;
use Olooeez\AluraPlay\Entity\Video;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class NewVideoController implements Controller
{
  use FlashMessageTrait;
  use HtmlRendererTrait;

  private VideoRepository $videoRepository;

  public function __construct(VideoRepository $videoRepository)
  {
    $this->videoRepository = $videoRepository;
  }

  public function indexAction(RequestInterface $request): ResponseInterface
  {
    $url = filter_input(INPUT_POST, "url", FILTER_VALIDATE_URL);
    if ($url === false) {
      $this->addErrorMessage("URL inválida");
      return new Response(302, [
        "Location" => "/novo-video"
      ]);
    }

    $titulo = filter_input(INPUT_POST, "titulo");
    if ($titulo === false) {
      $this->addErrorMessage("Título inválido");
      return new Response(302, [
        "Location" => "/novo-video"
      ]);
    }

    $video = new Video($url, $titulo);
    if ($_FILES["image"]["error"] === UPLOAD_ERR_OK) {
      $new_file_name = uniqid("upload_") . $_FILES["image"]["name"];
      move_uploaded_file($_FILES["image"]["tmp_name"], __DIR__ . "/../../public/img/uploads/" . $new_file_name);
      $video->setFilePath($new_file_name);
    }

    if (!$this->videoRepository->add(new Video($url, $titulo))) {
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

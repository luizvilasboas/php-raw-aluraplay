<?php

namespace Olooeez\AluraPlay\Controller;

use Nyholm\Psr7\Response;
use Olooeez\AluraPlay\Helper\FlashMessageTrait;
use Olooeez\AluraPlay\Repository\VideoRepository;
use Olooeez\AluraPlay\Entity\Video;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class EditVideoController implements Controller
{
  use FlashMessageTrait;

  private VideoRepository $videoRepository;

  public function __construct(VideoRepository $videoRepository)
  {
    $this->videoRepository = $videoRepository;
  }

  public function indexAction(RequestInterface $request): ResponseInterface
  {
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    if ($id === false || $id === null) {
      $this->addErrorMessage("O ID do vídeo é inválido");
      return new Response(302, [
        "Location" => "/"
      ]);
    }

    $url = filter_input(INPUT_POST, "url", FILTER_VALIDATE_URL);
    if ($url === false) {
      $this->addErrorMessage("A URL do vídeo é inválida");
      return new Response(302, [
        "Location" => "/"
      ]);
    }

    $titulo = filter_input(INPUT_POST, "titulo");
    if ($titulo === false) {
      $this->addErrorMessage("O título do vídeo é inválido");
      return new Response(302, [
        "Location" => "/"
      ]);
    }

    $video = new Video($url, $titulo);
    $video->setId($id);

    if ($_FILES["image"]["error"] === UPLOAD_ERR_OK) {
      $new_file_name = uniqid("upload_") . $_FILES["image"]["name"];
      move_uploaded_file($_FILES["image"]["tmp_name"], __DIR__ . "/../../public/img/uploads/" . $new_file_name);
      $video->setFilePath($new_file_name);
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

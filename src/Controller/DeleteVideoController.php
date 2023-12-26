<?php

namespace Olooeez\AluraPlay\Controller;

use Olooeez\AluraPlay\Repository\VideoRepository;

class DeleteVideoController implements Controller
{
    private VideoRepository $videoRepository;

    public function __construct(VideoRepository $videoRepository)
    {
      $this->videoRepository = $videoRepository;
    }

    public function indexAction(): void
    {
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        if ($id === null || $id === false) {
            header("Location: /?sucesso=0");
            return;
        }

        if (!$this->videoRepository->remove($id)) {
            header("Location: /?sucesso=0");
        } else {
            header("Location: /?sucesso=1");
        }

    }
}

<?php

namespace Nottes\Apps\Api\Controller\Folder;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Nottes\Application\Folder\FolderContent\FolderContentSearcher;
use App\Nottes\Application\Folder\FolderContent\FolderContentSearcherQuery;

class FolderGetController extends AbstractController
{
    public function __construct(
        private FolderContentSearcher $folderContentSearcher
    )
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $folderId = $request->attributes->get('id');

        try {
            $query = new FolderContentSearcherQuery($folderId);
            $folderContent = $this->folderContentSearcher->execute($query);
            return new JsonResponse($folderContent->getFolderContent());
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

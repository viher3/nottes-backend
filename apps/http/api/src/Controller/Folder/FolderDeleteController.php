<?php

namespace Nottes\Apps\Api\Controller\Folder;

use App\Nottes\Application\Folder\Delete\FolderDeleterCommand;
use Assert\Assertion;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Nottes\Application\Folder\Delete\FolderDeleter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FolderDeleteController extends AbstractController
{
    /**
     * @param FolderDeleter $folderDeleter
     */
    public function __construct(
        private FolderDeleter $folderDeleter
    )
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Assert\AssertionFailedException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $folderId = $request->attributes->get('id');

        try {
            Assertion::notEmpty($folderId, 'Error, folder ID is required.');

            $folderDeleterResponse = $this->folderDeleter->execute(
                new FolderDeleterCommand($folderId)
            );
            return new JsonResponse($folderDeleterResponse->getResponse(), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

<?php

namespace Nottes\Apps\Api\Controller\Folder;

use Assert\Assertion;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Nottes\Application\Folder\Update\FolderUpdater;
use App\Nottes\Application\Folder\Update\FolderUpdaterCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FolderPatchController extends AbstractController
{
    /**
     * @param FolderUpdater $folderUpdater
     */
    public function __construct(
        private FolderUpdater $folderUpdater
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
        $body = json_decode($request->getContent(), true);

        try {
            Assertion::notEmpty($body, 'Error, body param is required.');

            $allowedFields = ['name', 'parent', 'description'];
            $allowedBodyFields = array_intersect($allowedFields, array_keys($body));
            Assertion::notEmpty($allowedBodyFields, 'Error, invalid body params.');

            $folderUpdaterResponse = $this->folderUpdater->execute(
                new FolderUpdaterCommand($folderId, $body)
            );

            return new JsonResponse($folderUpdaterResponse->getResponse(), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

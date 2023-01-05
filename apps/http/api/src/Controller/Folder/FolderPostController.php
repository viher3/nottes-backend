<?php

namespace Nottes\Apps\Api\Controller\Folder;

use Assert\Assertion;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Nottes\Application\Folder\Creator\FolderCreator;
use App\Nottes\Application\Folder\Creator\FolderCreatorCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FolderPostController extends AbstractController
{
    private FolderCreator $folderCreator;

    public function __construct(FolderCreator $folderCreator)
    {
        $this->folderCreator = $folderCreator;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Assert\AssertionFailedException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $postData = json_decode($request->getContent(), true);

        try {
            Assertion::notEmpty($postData['name'], 'Error, folder name is required.');

            if (!isset($postData['parent'])) {
                throw new \InvalidArgumentException('Error, parent folder is required.');
            }

            $folderCreatorResponse = $this->folderCreator->execute(
                new FolderCreatorCommand(
                    $postData['name'],
                    $postData['parent'],
                    $postData['description'] ?? null
                )
            );

            return new JsonResponse($folderCreatorResponse->getResponse(), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

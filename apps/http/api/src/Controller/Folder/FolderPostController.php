<?php

namespace Nottes\Apps\Api\Controller\Folder;

use App\Nottes\Application\Folder\Creator\FolderCreatorCommand;
use Assert\Assertion;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Nottes\Application\Folder\Creator\FolderCreator;
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
     */
    public function __invoke(Request $request): JsonResponse
    {
        $postData = json_decode($request->getContent(), true);

        try {
            Assertion::notEmpty($postData['name'], 'Error, folder name is required.');
            Assertion::notEmpty($postData['parent'], 'Error, parent folder is required.');

            $this->folderCreator->execute(
                new FolderCreatorCommand(
                    $postData['name'],
                    $postData['parent'],
                    $postData['description'] ?? null
                )
            );

            return new JsonResponse([], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

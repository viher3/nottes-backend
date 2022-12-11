<?php

namespace Nottes\Apps\Api\Controller\Folder;

use App\Nottes\Application\Folder\Creator\FolderCreator;
use App\Nottes\Application\Folder\Creator\FolderCreatorRequest;
use Assert\Assertion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateFolderController extends AbstractController
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
            Assertion::notEmpty($postData['name']);

            $this->folderCreator->execute(
                new FolderCreatorRequest(
                    $postData['name'],
                    $postData['parent'] ?? null,
                    $postData['description'] ?? null
                )
            );

            return new JsonResponse([], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            return new JsonResponse([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}

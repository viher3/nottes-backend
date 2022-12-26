<?php

namespace Nottes\Apps\Api\Controller\Text;

use App\Nottes\Application\Text\Create\TextCreatorCommand;
use Assert\Assertion;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Nottes\Application\Text\Create\TextCreator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TextPostController extends AbstractController
{
    public function __construct(
        private TextCreator $folderCreator
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
        $postData = json_decode($request->getContent(), true);

        try {
            $this->paramAssertions($postData);

            $this->folderCreator->execute(
                new TextCreatorCommand(
                    $postData['name'],
                    $postData['content'],
                    $postData['format'],
                    $postData['folder'] ?? null,
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

    private function paramAssertions(mixed $postData) : void
    {
        Assertion::notEmpty($postData['name'], '"name" param is empty');
        Assertion::notEmpty($postData['content'], '"content" param is empty');

        Assertion::notEmpty($postData['format'], '"format" param is empty');
        Assertion::integer($postData['format'], '"format" is not integer type.');
    }
}

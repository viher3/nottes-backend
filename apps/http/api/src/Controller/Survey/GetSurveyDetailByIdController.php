<?php

namespace Nottes\Apps\Api\Controller\Survey;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetSurveyDetailByIdController extends AbstractController
{
    public function __invoke(string $id) : JsonResponse
    {
        return new JsonResponse([], 200);
    }
}

<?php

namespace Nottes\Apps\Api\Controller\Folder;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Nottes\Application\Folder\SearchByCriteria\SearchFolderByCriteriaSearcher;
use App\Nottes\Application\Folder\SearchByCriteria\SearchFolderByCriteriaSearcherQuery;

class FolderGetCollectionController extends AbstractController
{
    public function __construct(
        private SearchFolderByCriteriaSearcher $searchFolderByCriteriaSearcher
    )
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $filters = $request->query->get('filters', []);
        $filters = $filters ? json_decode("[$filters]", true) : [];

        try{
            $query = new SearchFolderByCriteriaSearcherQuery(
                $filters,
                $request->query->get('order_by'),
                $request->query->get('order'),
                $request->query->get('limit'),
                $request->query->get('offset')
            );

            $foldersByCriteria = $this->searchFolderByCriteriaSearcher->execute($query);
            return new JsonResponse([
                'items' => $foldersByCriteria->getFolders(),
                'page' => $request->query->get('page') ? (int) $request->query->get('page') : 1
            ]);
        }catch (\Exception $e){
            return new JsonResponse([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Modules\Products\Presentation\Controllers;

use App\Modules\Products\Application\Messenger\Queries\IndexProductsQuery;
use App\Modules\Products\Application\Messenger\QueryHandlers\IndexProductsHandler;
use App\Modules\Products\Presentation\Dtos\Request\IndexProductsRequest;
use App\Modules\Products\Presentation\Dtos\Response\PaginatedProductsResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/products', name: 'index', methods: ['GET'])]
class IndexProductsController extends AbstractController
{
    public function __invoke(
        #[MapQueryString]
        IndexProductsRequest $request,
        IndexProductsHandler $handler
    ): JsonResponse
    {
        $pagination = $handler(new IndexProductsQuery(
            sortDirection: $request->sortDirection,
            sortBy: $request->sortBy,
            page: $request->page,
            limit: $request->limit
        ));

        return new JsonResponse(PaginatedProductsResponse::fromPagination($pagination));
    }
}

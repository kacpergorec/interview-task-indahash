<?php

declare(strict_types=1);

namespace App\Modules\Products\Presentation\Controllers;

use App\Modules\Products\Application\Messenger\Queries\GetProductQuery;
use App\Modules\Products\Application\Messenger\QueryHandlers\GetProductHandler;
use App\Modules\Products\Domain\ValueObjects\ProductId;
use App\Modules\Products\Presentation\Dtos\Response\ProductDetailsResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/products/{id}', name: 'details', methods: ['GET'])]
class DetailsProductController extends AbstractController
{
    public function __invoke(string $id, GetProductHandler $handler): JsonResponse
    {
        $id = ProductId::fromString($id);

        $Dto = $handler(new GetProductQuery($id));

        return new JsonResponse(new ProductDetailsResponse(
            id: $Dto->id->toUuid()->toString(),
            name: $Dto->name,
            description: $Dto->description,
            grossPrice: $Dto->grossPrice
        ), Response::HTTP_OK);
    }
}

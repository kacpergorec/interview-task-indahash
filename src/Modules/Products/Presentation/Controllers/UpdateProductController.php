<?php

declare(strict_types=1);

namespace App\Modules\Products\Presentation\Controllers;

use App\Modules\Products\Application\Events\ProductUpdateRequestEvent;
use App\Modules\Products\Domain\ValueObjects\ProductId;
use App\Modules\Products\Presentation\Dtos\Request\UpdateProductRequest;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/products/{id}', name: 'update', methods: ['PATCH'])]
class UpdateProductController extends AbstractController
{
    public function __invoke(
        string $id,
        #[MapRequestPayload]
        UpdateProductRequest $request,
        EventDispatcherInterface $eventDispatcher
    ): JsonResponse
    {
        $eventDispatcher->dispatch(new ProductUpdateRequestEvent(
            productId: ProductId::fromString($id),
            name: $request->name,
            description: $request->description,
            grossPrice: $request->grossPrice
        ));

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}

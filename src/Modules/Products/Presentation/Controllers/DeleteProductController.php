<?php

declare(strict_types=1);

namespace App\Modules\Products\Presentation\Controllers;

use App\Modules\Products\Application\Events\ProductDeletionRequestEvent;
use App\Modules\Products\Domain\ValueObjects\ProductId;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/products/{id}', name: 'delete', methods: ['DELETE'])]
class DeleteProductController extends AbstractController
{
    public function __invoke(string $id, EventDispatcherInterface $eventDispatcher): JsonResponse
    {
        $id = ProductId::fromString($id);

        $eventDispatcher->dispatch(new ProductDeletionRequestEvent($id));

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}

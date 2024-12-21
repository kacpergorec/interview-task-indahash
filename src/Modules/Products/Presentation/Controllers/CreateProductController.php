<?php

declare(strict_types=1);

namespace App\Modules\Products\Presentation\Controllers;

use App\Modules\Products\Application\Events\ProductCreationRequestEvent;
use App\Modules\Products\Application\Factories\DtoFactory;
use App\Modules\Products\Domain\ValueObjects\ProductId;
use App\Modules\Products\Presentation\Dtos\Request\CreateProductRequest;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/products', name: 'create', methods: ['POST'])]
class CreateProductController extends AbstractController
{
    public function __invoke(
        #[MapRequestPayload]
        CreateProductRequest $request,
        EventDispatcherInterface $eventDispatcher
    ): JsonResponse
    {
        $id = ProductId::new();
        $dto = DtoFactory::createFromRequest($id, $request);

        $eventDispatcher->dispatch(new ProductCreationRequestEvent($dto));

        return new JsonResponse($dto->id, Response::HTTP_CREATED);
    }
}

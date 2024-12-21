<?php

declare(strict_types=1);

namespace App\Modules\Products\Presentation\Controllers;

use App\Modules\Products\Presentation\Dtos\Request\CreateProductRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/products', name: 'create', methods: ['POST'])]
class CreateProductController extends AbstractController
{
    public function __invoke(
        #[MapRequestPayload]
        CreateProductRequest $request
    ): JsonResponse
    {
        dd($request);

        return new JsonResponse('todo');
    }
}

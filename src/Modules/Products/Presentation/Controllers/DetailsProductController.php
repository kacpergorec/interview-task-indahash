<?php

declare(strict_types=1);

namespace App\Modules\Products\Presentation\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/products/{id}', name: 'details', methods: ['GET'])]
class DetailsProductController extends AbstractController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse('todo');
    }
}

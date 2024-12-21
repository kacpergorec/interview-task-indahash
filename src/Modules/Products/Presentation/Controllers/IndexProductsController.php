<?php

declare(strict_types=1);

namespace App\Modules\Products\Presentation\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/products', name: 'index', methods: ['GET'])]
class IndexProductsController extends AbstractController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse('todo');
    }
}

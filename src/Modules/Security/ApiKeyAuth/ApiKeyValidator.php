<?php
declare (strict_types=1);

namespace App\Modules\Security\ApiKeyAuth;


use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;

readonly class ApiKeyValidator
{
    public function __construct(
        private string $apiKey
    )
    {
    }

    public function validate(Request $request): void
    {
        if (in_array($request->getMethod(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $apiKey = $request->headers->get('X-API-KEY');

            if ($apiKey !== $this->apiKey) {
                throw new AccessDeniedException('Invalid API Key');
            }
        }
    }
}
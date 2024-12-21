<?php
declare (strict_types=1);

namespace App\Modules\Security\ApiKeyAuth;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;


#[AsEventListener]
readonly class ApiKeyAuthListener
{
    public function __construct(
        private ApiKeyValidator $apiKeyValidator
    )
    {
    }

    public function __invoke(RequestEvent $event) : void
    {
        $request = $event->getRequest();

        try {
            $this->apiKeyValidator->validate($request);
        } catch (AccessDeniedException $e) {
            $response = new JsonResponse([
                'error' => 'Unauthorized',
                'message' => 'Invalid API Key'
            ], JsonResponse::HTTP_UNAUTHORIZED);

            $event->setResponse($response);
        }
    }
}
<?php
declare (strict_types=1);

namespace App\Modules\Products\Application\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductNotFoundException extends NotFoundHttpException
{

}
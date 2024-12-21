<?php
declare (strict_types=1);

namespace App\Modules\Products\Presentation\Dtos\Request;

use App\Shared\Domain\Money;

interface ProductRequestInterface
{
    public function getName() : string;

    public function getDescription() : string;

    public function getGrossPrice() : Money;

}
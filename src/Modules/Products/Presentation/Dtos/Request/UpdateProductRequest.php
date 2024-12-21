<?php
declare (strict_types=1);

namespace App\Modules\Products\Presentation\Dtos\Request;

use App\Shared\Domain\Money;

final readonly class UpdateProductRequest implements ProductRequestInterface
{
    public function __construct(
        public ?string $name,
        public ?string $description,
        public ?Money $grossPrice
    )
    {
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function getGrossPrice() : Money
    {
        return $this->grossPrice;
    }
}

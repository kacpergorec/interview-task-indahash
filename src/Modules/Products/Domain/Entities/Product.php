<?php
declare(strict_types=1);

namespace App\Modules\Products\Domain\Entities;

use App\Modules\Products\Domain\ValueObjects\ProductId;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\Money;

final class Product extends AggregateRoot
{
    private function __construct(
        private ProductId $id,
        private string $name,
        private string $description,
        private Money $grossPrice
    ) {}

    public static function create(
        ProductId $id,
        string $name,
        string $description,
        Money $grossPrice
    ): self {
        return new self($id, $name, $description, $grossPrice);
    }


    public function toArray(): array
    {
        return [
            'id' => $this->id->toUuid()->toString(),
            'name' => $this->name,
            'description' => $this->description,
            'grossPrice' => $this->grossPrice->value,
        ];
    }
}
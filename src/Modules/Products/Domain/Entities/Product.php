<?php
declare(strict_types=1);

namespace App\Modules\Products\Domain\Entities;

use App\Modules\Products\Domain\Events\ProductCreatedEvent;
use App\Modules\Products\Domain\Exceptions\DescriptionTooShortException;
use App\Modules\Products\Domain\Exceptions\NameRequiredException;
use App\Modules\Products\Domain\ValueObjects\ProductId;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\Money;

class Product extends AggregateRoot
{
    private function __construct(
        public readonly ProductId $id,
        private string   $name,
        private string   $description,
        private Money    $grossPrice
    ) {}

    public static function create(
        ProductId $id,
        string $name,
        string $description,
        Money $grossPrice
    ): self {
        if (empty($name)) {
            throw new NameRequiredException('Name is required');
        }

        if (strlen($description) <= 10) {
            throw new DescriptionTooShortException('Description is too short');
        }

        $product = new self($id, $name, $description, $grossPrice);

        $product->raise(new ProductCreatedEvent($product->id));

        return $product;
    }

    public function getId(): ProductId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getGrossPrice(): Money
    {
        return $this->grossPrice;
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
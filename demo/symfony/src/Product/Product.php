<?php

declare(strict_types=1);

namespace App\Product;

use App\Repository\IdentifiableInterface;

class Product implements IdentifiableInterface
{
    public string $id;

    public string $name;

    public string $description;

    public int $price;

    public string $vatType;

    public int $stock;

    public function getIdentifier(): string
    {
        return $this->id;
    }
}

<?php

declare(strict_types=1);

namespace Demo\Product;

use Demo\Repository\IdentifiableInterface;
use Symfony\Component\Serializer\Attribute\Ignore;

class Product implements IdentifiableInterface
{
    public string $id;

    public string $name;

    public string $description;

    public int $price;

    public string $vatType;

    public int $stock;

    #[Ignore]
    public function getIdentifier(): string
    {
        return $this->id;
    }
}

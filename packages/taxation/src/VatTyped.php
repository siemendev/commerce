<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Taxation;

trait VatTyped
{
    private string $vatType = VatTypedItemInterface::VAT_TYPE_DEFAULT;

    public function getVatType(): string
    {
        return $this->vatType;
    }

    public function setVatType(string $vatType): static
    {
        $this->vatType = $vatType;

        return $this;
    }
}

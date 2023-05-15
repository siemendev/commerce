<?php declare(strict_types=1);

namespace Siemendev\Checkout\Taxation;

interface VatTypedItemInterface
{
    public const VAT_TYPE_DEFAULT = 'high';

    public const VAT_TYPE_LOWER = 'low';

    public const VAT_TYPE_LOWEST = 'low1';

    public function getVatType(): string;
}

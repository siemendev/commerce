<?php declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\Option\Resolver;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Delivery\Option\DeliveryOptionInterface;

interface DeliveryOptionsResolverInterface
{
    /**
     * @return array<DeliveryOptionInterface>
     */
    public function getAvailableOptions(CheckoutDataInterface $data): array;
}

<?php declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\AdditionalCost;

use Siemendev\Checkout\Products\AdditionalCost\AbstractAdditionalCost;

if (class_exists(AbstractAdditionalCost::class)) {
    class DeliveryAdditionalCost extends AbstractAdditionalCost
    {
        public function __construct(private readonly string $option, int $amountNet, int $amountGross)
        {
            parent::__construct($amountNet, $amountGross); // @phpstan-ignore-line
        }

        public function getLabel(): string
        {
            return 'Delivery cost (' . $this->option . ')';
        }
    }
}

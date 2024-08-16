<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\Option\Resolver;

use Siemendev\Checkout\Delivery\Data\DeliverableCheckoutDataInterface;
use Siemendev\Checkout\Delivery\Option\DeliveryOptionInterface;

class DeliveryOptionsResolver implements DeliveryOptionsResolverInterface
{
    /**
     * @param array<DeliveryOptionInterface> $options
     */
    public function __construct(
        private array $options = [],
    ) {}

    /**
     * @param array<DeliveryOptionInterface> $options
     */
    public function setOptions(array $options): static
    {
        $this->options = $options;

        return $this;
    }

    public function addOption(DeliveryOptionInterface $option): static
    {
        $this->options[] = $option;

        return $this;
    }

    public function getAvailableOptions(DeliverableCheckoutDataInterface $data): array
    {
        $options = [];

        foreach ($this->options as $option) {
            if ($option->isAvailable($data)) {
                $options[] = $option;
            }
        }

        return $options;
    }
}

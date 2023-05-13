<?php declare(strict_types=1);

namespace Siemendev\Checkout\Item;

trait RequiredCheckoutData
{
    /** @var array<class-string> */
    private array $requiredCheckoutDataInterfaces = [];

    public function requiredCheckoutDataInterfaces(): array
    {
        return $this->requiredCheckoutDataInterfaces;
    }

    /**
     * @param class-string $requiredInterface
     */
    public function addRequiredCheckoutDataInterface(string $requiredInterface): static
    {
        if (!in_array($requiredInterface, $this->requiredCheckoutDataInterfaces, true)) {
            $this->requiredCheckoutDataInterfaces[] = $requiredInterface;
        }

        return $this;
    }
}

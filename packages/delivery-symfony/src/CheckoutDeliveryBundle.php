<?php declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\SymfonyBridge;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CheckoutDeliveryBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CheckoutDeliveryExtension();
    }
}

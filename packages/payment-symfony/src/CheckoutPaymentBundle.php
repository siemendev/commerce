<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\SymfonyBridge;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CheckoutPaymentBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CheckoutPaymentExtension();
    }
}
<?php declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\SymfonyBridge;

use Siemendev\Checkout\SymfonyBridge\CheckoutBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CheckoutGiftCardBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CheckoutGiftCardExtension();
    }
}

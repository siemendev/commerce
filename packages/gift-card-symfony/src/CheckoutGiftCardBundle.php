<?php

declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\SymfonyBridge;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CheckoutGiftCardBundle extends Bundle
{
    public const PARAMETER_CONFIG = '.checkout_gift_card_config';

    public const SERVICE_GIFT_CARD_PAYMENT_METHOD = 'checkout.payment_methods.gift_card';

    public const TAG_GIFT_CARD_CHECKER = 'checkout.gift_card.checker';

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new CheckoutGiftCardCompilerPass());
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CheckoutGiftCardExtension();
    }
}

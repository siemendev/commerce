<?php

declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\SymfonyBridge;

use LogicException;
use Siemendev\Checkout\GiftCard\Checker\GiftCardCheckerInterface;
use Siemendev\Checkout\GiftCard\Payment\GiftCardPaymentManagerInterface;
use Siemendev\SymfonyPackageHelper\CompilerPassHelper;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CheckoutGiftCardCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $config = $container->getParameter(CheckoutGiftCardBundle::PARAMETER_CONFIG);

        if (!is_array($config) || !$config['payment_manager'] || !$container->has($config['payment_manager'])) {
            throw new LogicException('No payment manager configured for gift card payment method. Please configure the payment manager in the config as "checkout_gift_card.payment_manager = *service-id*".');
        }

        (new CompilerPassHelper($container))
            ->addChildServiceToParent(
                CheckoutGiftCardBundle::SERVICE_GIFT_CARD_PAYMENT_METHOD,
                $config['payment_manager'],
                'setPaymentManager',
                GiftCardPaymentManagerInterface::class,
            )
            ->addTaggedServicesToParent(
                CheckoutGiftCardBundle::SERVICE_GIFT_CARD_PAYMENT_METHOD,
                CheckoutGiftCardBundle::TAG_GIFT_CARD_CHECKER,
                'addChecker',
                GiftCardCheckerInterface::class,
            )
        ;
    }
}

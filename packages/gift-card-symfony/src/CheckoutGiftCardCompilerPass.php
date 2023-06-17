<?php

declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\SymfonyBridge;

use LogicException;
use Siemendev\Checkout\GiftCard\Checker\GiftCardCheckerInterface;
use Siemendev\Checkout\GiftCard\Capture\GiftCardCapturingManagerInterface;
use Siemendev\SymfonyPackageHelper\CompilerPassHelper;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CheckoutGiftCardCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $config = $container->getParameter(CheckoutGiftCardBundle::PARAMETER_CONFIG);

        if (!is_array($config) || !$config['capturing_manager'] || !$container->has($config['capturing_manager'])) {
            throw new LogicException('No capturing manager configured for gift card payment method. Please configure the capturing manager in the config as "checkout_gift_card.capturing_manager = *service-id*".');
        }

        (new CompilerPassHelper($container))
            ->addChildServiceToParent(
                CheckoutGiftCardBundle::SERVICE_GIFT_CARD_PAYMENT_METHOD,
                $config['capturing_manager'],
                'setCapturingManager',
                GiftCardCapturingManagerInterface::class,
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

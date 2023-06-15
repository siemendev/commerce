<?php declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\SymfonyBridge;

use Siemendev\Checkout\GiftCard\Checker\GiftCardCheckerInterface;
use Siemendev\Checkout\GiftCard\Repository\GiftCardRepositoryInterface;
use Siemendev\SymfonyPackageHelper\CompilerPassHelper;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CheckoutGiftCardCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $config = $container->getParameter(CheckoutGiftCardBundle::PARAMETER_CONFIG);

        (new CompilerPassHelper($container))
            ->addChildServiceToParent(
                CheckoutGiftCardBundle::SERVICE_GIFT_CARD_PAYMENT_METHOD,
                is_array($config) ? $config['repository'] ?? '' : '',
                'setRepository',
                GiftCardRepositoryInterface::class,
            )
            ->addTaggedServicesToParent(
                CheckoutGiftCardBundle::SERVICE_GIFT_CARD_PAYMENT_METHOD,
                CheckoutGiftCardBundle::TAG_GIFT_CARD_CHECKER,
                'addChecker',
                GiftCardCheckerInterface::class
            )
        ;
    }
}

<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Symfony\Bundle\DebugBundle\DebugBundle::class => ['dev' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => ['dev' => true, 'test' => true],
    Twig\Extra\TwigExtraBundle\TwigExtraBundle::class => ['all' => true],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class => ['all' => true],
    Symfony\Bundle\MakerBundle\MakerBundle::class => ['dev' => true],
    Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle::class => ['all' => true],
    Siemendev\Checkout\SymfonyBridge\CheckoutBundle::class => ['all' => true],
    Siemendev\Checkout\Products\SymfonyBridge\CheckoutProductsBundle::class => ['all' => true],
    Siemendev\Checkout\Payment\SymfonyBridge\CheckoutPaymentBundle::class => ['all' => true],
    Siemendev\Checkout\Delivery\SymfonyBridge\CheckoutDeliveryBundle::class => ['all' => true],
    Siemendev\Checkout\GiftCard\SymfonyBridge\CheckoutGiftCardBundle::class => ['all' => true],
];

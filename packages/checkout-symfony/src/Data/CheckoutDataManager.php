<?php declare(strict_types=1);

namespace Siemendev\Checkout\SymfonyBridge\Data;

use LogicException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CheckoutDataManager
{
    public const SESSION_KEY = 'checkout_data';

    private CheckoutDataCreatorInterface $checkoutDataCreator;

    public function __construct(
        private readonly RequestStack $requestStack,
    ){
    }

    public function setDataCreator(CheckoutDataCreatorInterface $checkoutDataCreator): static
    {
        $this->checkoutDataCreator = $checkoutDataCreator;

        return $this;
    }

    public function getCheckoutData(): CheckoutDataInterface
    {
        if (($data = $this->requestStack->getSession()->get(static::SESSION_KEY))
            && $data instanceof CheckoutDataInterface
        ) {
            return $data;
        }

        if (!isset($this->checkoutDataCreator)) {
            throw new LogicException('No checkout data creator set.'); // todo improve exception message
        }

        $data = $this->checkoutDataCreator->createEmptyCheckoutData();

        $this->saveCheckoutData($data);

        return $data;
    }

    public function saveCheckoutData(CheckoutDataInterface $checkoutData): void
    {
        $this->requestStack->getSession()->set(static::SESSION_KEY, $checkoutData);
    }

    public function clearCheckoutData(): void
    {
        $this->requestStack->getSession()->remove(static::SESSION_KEY);
    }
}

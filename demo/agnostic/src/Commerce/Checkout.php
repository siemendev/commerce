<?php

declare(strict_types=1);

namespace Demo\Commerce;

use Demo\Commerce\Data\CheckoutData;
use Demo\Commerce\Data\CheckoutDataImmutable;
use Siemendev\Checkout\Delivery\Option\DeliveryOptionInterface;
use Siemendev\Checkout\Delivery\Option\Resolver\DeliveryOptionsResolverInterface;
use Siemendev\Checkout\Finalize\CheckoutFinalizationExceptionWrapper;
use Siemendev\Checkout\Finalize\CheckoutFinalizerInterface;
use Siemendev\Checkout\Finalize\UnknownFinalizationStepException;
use Siemendev\Checkout\Payment\Method\PaymentAuthorizationRollbackException;
use Siemendev\Checkout\Payment\Method\PaymentCaptureRollbackException;
use Siemendev\Checkout\Payment\Method\PaymentMethodInterface;
use Siemendev\Checkout\Payment\Method\PaymentMethodsProviderInterface;
use Siemendev\Checkout\Payment\Payment\PaymentInterface;
use Siemendev\Checkout\Products\Quote\Calculation\CheckoutQuoteCalculatorInterface;
use Siemendev\Checkout\Step\Address\Address;
use Siemendev\Checkout\Step\Exception\AssignedValidationException;
use Siemendev\Checkout\Step\Machine\StepMachineInterface;
use Siemendev\Checkout\Step\StepInterface;
use Siemendev\Checkout\SymfonyBridge\Data\CheckoutDataManager;

class Checkout
{
    public function __construct(
        private readonly CheckoutDataManager $checkoutDataManager,
        private readonly CheckoutQuoteCalculatorInterface $checkoutQuoteCalculator,
        private readonly StepMachineInterface $stepMachine,
        private readonly CheckoutFinalizerInterface $checkoutFinalizer,
        private readonly DeliveryOptionsResolverInterface $optionsResolver,
        private readonly PaymentMethodsProviderInterface $paymentMethodProvider,
    ) {}

    public function save(): self
    {
        $this->checkoutDataManager->saveCheckoutData(
            $this->checkoutDataManager->getCheckoutData(),
        );

        return $this;
    }

    public function clear(): self
    {
        $this->checkoutDataManager->clearCheckoutData();

        return $this;
    }

    public function recalculate(): self
    {
        $this->checkoutQuoteCalculator->calculate(
            $this->checkoutDataManager->getCheckoutData(),
        );

        return $this;
    }

    public function addProduct(CheckoutProduct $product): self
    {
        foreach ($this->getData()->getProducts() as $existingProduct) {
            if ($existingProduct->getIdentifier() === $product->getIdentifier()) {
                $existingProduct->setQuantity($product->getQuantity() + $existingProduct->getQuantity());

                return $this;
            }
        }

        $this->getData()->addProduct($product);

        return $this;
    }

    public function switchCurrency(string $currency): self
    {
        $this->getData()->setCurrency($currency);

        return $this;
    }

    private function getData(): CheckoutData
    {
        /* @var CheckoutData $data */
        return $this->checkoutDataManager->getCheckoutData();
    }

    public function getCheckoutData(): CheckoutDataImmutable
    {
        return CheckoutDataImmutable::createFromCheckoutData($this->getData());
    }

    public function setBillingAddress(Address $address): self
    {
        $this->getData()->setBillingAddress($address);

        return $this;
    }

    public function setDeliveryAddress(Address $address): self
    {
        $this->getData()->setDeliveryAddress($address);

        return $this;
    }

    public function setAgeVerified(bool $ageVerification): self
    {
        $this->getData()->setAgeVerified($ageVerification);

        return $this;
    }

    public function addPayment(PaymentInterface $payment): self
    {
        $this->getData()->getPayments()->add($payment);

        return $this;
    }

    public function lock(): self
    {
        $this->getData()->lock();

        return $this;
    }

    public function getCurrentStep(): StepInterface
    {
        return $this->stepMachine->getCurrentStep($this->getData());
    }

    public function isStepAllowed(string $stepIdentifier): bool
    {
        return $this->stepMachine->isStepAllowed($this->getData(), $stepIdentifier);
    }

    /**
     * @return array<StepInterface>
     */
    public function getRequiredSteps(): array
    {
        return $this->stepMachine->getRequiredSteps($this->getData());
    }

    /**
     * @throws AssignedValidationException
     */
    public function validateStep(string $stepIdentifier): void
    {
        $this->stepMachine->validateStep($this->getData(), $stepIdentifier);
    }

    /**
     * @throws UnknownFinalizationStepException
     * @throws CheckoutFinalizationExceptionWrapper
     */
    public function finalize(): self
    {
        $this->checkoutFinalizer->finalize($this->getData());

        return $this;
    }

    public function isValid(): bool
    {
        return $this->stepMachine->isValid($this->getData());
    }

    /**
     * @return array<DeliveryOptionInterface>
     */
    public function getAvailableDeliveryOptions(): array
    {
        return $this->optionsResolver->getAvailableOptions($this->getData());
    }

    public function setDeliveryOption(?DeliveryOptionInterface $deliveryOption): self
    {
        $this->getData()->setDeliveryOption($deliveryOption);

        return $this;
    }

    /**
     * @return array<PaymentMethodInterface>
     */
    public function getEligiblePaymentMethods(): array
    {
        return $this->paymentMethodProvider->getEligiblePaymentMethods($this->getData());
    }

    /**
     * Removes a payment from the checkout.
     * Attention: If an exception is thrown, the payment is not removed (no rollback => no money back).
     *
     * @throws PaymentCaptureRollbackException
     * @throws PaymentAuthorizationRollbackException
     */
    public function removePayment(string $paymentIdentifier): void
    {
        $payment = $this->getData()->getPayments()->get($paymentIdentifier);
        $paymentMethod = $this->paymentMethodProvider->getPaymentMethod($payment->getPaymentMethodIdentifier());

        if ($payment->isCaptured()) {
            $paymentMethod->rollbackCapture($payment, $this->getData());
        }
        if ($payment->isAuthorized()) {
            $paymentMethod->rollbackAuthorization($payment, $this->getData());
        }

        $this->getData()->getPayments()->remove($payment);
    }
}

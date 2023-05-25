<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Data;

use Siemendev\Checkout\Products\Payment\PaymentInterface;

trait ContainsProductPayments
{
    /**
     * @var array<PaymentInterface>
     */
    public array $productPayments = [];

    /**
     * @see ProductCheckoutDataInterface::getPayments()
     */
    public function getPayments(): array
    {
        return $this->productPayments;
    }

    /**
     * @param array<PaymentInterface> $payments
     */
    public function setPayments(array $payments): static
    {
        $this->productPayments = $payments;

        return $this;
    }

    public function addPayment(PaymentInterface $payment): static
    {
        $this->productPayments[] = $payment;

        return $this;
    }

    public function removePayment(PaymentInterface $payment): static
    {
        $this->productPayments = array_filter(
            $this->productPayments,
            static fn (PaymentInterface $p) => $p !== $payment
        );

        return $this;
    }

    public function hasPayment(PaymentInterface $payment): bool
    {
        return in_array($payment, $this->productPayments, true);
    }

    public function clearPayments(): static
    {
        $this->productPayments = [];

        return $this;
    }
}

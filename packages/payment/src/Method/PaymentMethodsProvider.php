<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Method;

use LogicException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Products\Data\QuotedCheckoutDataInterface;
use Siemendev\Checkout\Products\Quote\QuoteGeneratorInterface;

class PaymentMethodsProvider implements PaymentMethodsProviderInterface
{
    /**
     * @param array<PaymentMethodInterface> $paymentMethods
     */
    public function __construct(
        private readonly QuoteGeneratorInterface $quoteGenerator,
        private array $paymentMethods = [],
    ) {
    }

    /**
     * @param array<PaymentMethodInterface> $paymentMethods
     */
    public function setPaymentMethods(array $paymentMethods): void
    {
        $this->paymentMethods = $paymentMethods;
    }

    public function addPaymentMethod(PaymentMethodInterface $paymentMethod): static
    {
        $this->paymentMethods[] = $paymentMethod;

        return $this;
    }

    public function getEligiblePaymentMethods(CheckoutDataInterface $data): array
    {
        // todo use custom data structure instead of quote so there is no direct dependency on the quote generator (maybe using a converter to map the quote to the custom data structure)
        $quote = $this->quoteGenerator->generate($data);

        // todo take existing payments (e.g. gift card) into account instead of just checking the total gross of the quote
        if ($quote->getTotalGross() <= 0) {
            return [];
        }

        if (!$data instanceof QuotedCheckoutDataInterface) {
            throw new LogicException(sprintf('%s needs to implement %s to check the eligibility of payment methods.', $data::class, QuotedCheckoutDataInterface::class));
        }

        if ($data->getQuote() === null) {
            throw new LogicException('The checkout data needs to be calculated before getting the eligible payment methods.');
        }

        return array_values(array_filter(
            $this->paymentMethods,
            static fn (PaymentMethodInterface $paymentMethod) => $paymentMethod->isEligible($data),
        ));
    }
}

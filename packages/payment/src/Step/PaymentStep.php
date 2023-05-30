<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Step;

use InvalidArgumentException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Payment\Data\PaymentCheckoutDataInterface;
use Siemendev\Checkout\Payment\Payment\PaymentInterface;
use Siemendev\Checkout\Products\Data\ProductCheckoutDataInterface;
use Siemendev\Checkout\Products\Quote\QuoteGeneratorInterface;
use Siemendev\Checkout\Step\StepInterface;

class PaymentStep implements StepInterface
{
    public function __construct(
        private QuoteGeneratorInterface $quoteGenerator,
    ) {
    }

    public function setQuoteGenerator(QuoteGeneratorInterface $quoteGenerator): static
    {
        $this->quoteGenerator = $quoteGenerator;

        return $this;
    }

    public static function stepIdentifier(): string
    {
        return 'product_payment';
    }

    public function isRequired(CheckoutDataInterface $data): bool
    {
        if (!$data instanceof PaymentCheckoutDataInterface) {
            throw new InvalidArgumentException(sprintf(
                '%s needs to implement %s for the payment step to work.',
                $data::class,
                PaymentCheckoutDataInterface::class,
            ));
        }

        // always show the payment step as soon as there are payments registered on the data
        if (count($data->getPayments()) > 0) {
            return true;
        }

        // only show the payment step if there is a total gross amount to pay
        return $this->quoteGenerator->generate($data)->getTotalGross() > 0;
    }

    public function requiresCheckoutData(): array
    {
        return [ProductCheckoutDataInterface::class];
    }

    public function validate(CheckoutDataInterface $data): void
    {
        if (!$data instanceof PaymentCheckoutDataInterface) {
            throw new InvalidArgumentException(sprintf(
                '%s needs to implement %s for the payment step to work.',
                $data::class,
                PaymentCheckoutDataInterface::class,
            ));
        }

        if (count($data->getPayments())) {
            throw new NotPaidException();
        }

        $quote = $this->quoteGenerator->generate($data);
        $paidAmount = array_sum(array_map(
            static fn (PaymentInterface $payment) => $payment->getAmount(),
            $data->getPayments()
        ));

        if ($quote->getTotalGross() - $paidAmount > 0) {
            throw new PartiallyPaidException();
        }
    }

    public static function requiresSteps(): array
    {
        return [];
    }
}

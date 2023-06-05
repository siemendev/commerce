<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Quote\Calculation;

use LogicException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Products\Data\QuotedCheckoutDataInterface;
use Siemendev\Checkout\Products\Quote\QuoteGeneratorInterface;

class CheckoutQuoteCalculator implements CheckoutQuoteCalculatorInterface
{
    public function __construct(
        private QuoteGeneratorInterface $quoteGenerator,
    ) {
    }

    public function setQuoteGenerator(QuoteGeneratorInterface $generator): void
    {
        $this->quoteGenerator = $generator;
    }

    public function calculate(CheckoutDataInterface $data): void
    {
        if (!$data instanceof QuotedCheckoutDataInterface) {
            throw new LogicException(sprintf(
                '%s needs to implement %s to be able to store the calculated quote.',
                $data::class,
                QuotedCheckoutDataInterface::class,
            ));
        }

        if ($data->isLocked()) {
            return;
        }

        $hash = $data->getHash();

        if ($hash === $data->getCalculatedHash()) {
            return;
        }

        $data
            ->setQuote(
                $this->quoteGenerator->generate($data)
            )
            ->setCalculatedHash($hash)
        ;
    }
}

<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote\Builder\Part;

use Siemendev\Checkout\Availability\AvailabilityResolverInterface;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Pricing\PriceResolverInterface;
use Siemendev\Checkout\Quote\Action\RemoveProductQuoteAction;
use Siemendev\Checkout\Quote\Product\ProductQuote;
use Siemendev\Checkout\Quote\QuoteInterface;

class ProductsQuotePartBuilder implements QuotePartBuilderInterface
{
    public function __construct(
        private readonly PriceResolverInterface $priceResolver,
        private readonly AvailabilityResolverInterface $availabilityResolver,
    ) {
    }

    public function build(QuoteInterface $quote, CheckoutDataInterface $data): void
    {
        foreach ($data->getCart()->getProducts() as $product) {
            if (!$this->availabilityResolver->isAvailable($product)) {
                $quote->addAction(
                    new RemoveProductQuoteAction($product, RemoveProductQuoteAction::REASON_UNAVAILABLE)
                );
                continue;
            }

            $price = $this->priceResolver->getProductPrice($product, $data);

            $quote
                ->addProduct(
                    (new ProductQuote())
                        ->setProduct($product)
                        ->setPrice($price)
                )
                ->setSubTotalNet($quote->getSubTotalNet() + $price->getTotalPriceNet())
                ->setSubTotalGross($quote->getSubTotalGross() + $price->getTotalPriceGross())
                ->setTotalNet($quote->getTotalNet() + $price->getTotalPriceNet())
                ->setTotalGross($quote->getTotalGross() + $price->getTotalPriceGross())
            ;
        }
    }
}

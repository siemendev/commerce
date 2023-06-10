<?php declare(strict_types=1);

namespace App\Commerce;

use App\Commerce\Step\HasAgeVerification;
use App\Commerce\Step\AgeVerifiableCheckoutDataInterface;
use Siemendev\Checkout\Data\GenericCheckoutData;
use Siemendev\Checkout\Delivery\Data\DeliverableCheckoutDataInterface;
use Siemendev\Checkout\Delivery\Data\IsDeliverable;
use Siemendev\Checkout\Payment\Data\ContainsPayments;
use Siemendev\Checkout\Payment\Data\PaymentCheckoutDataInterface;
use Siemendev\Checkout\Payment\Payment\PaymentInterface;
use Siemendev\Checkout\Products\Data\ContainsProducts;
use Siemendev\Checkout\Products\Data\ContainsQuote;
use Siemendev\Checkout\Products\Data\ProductCheckoutDataInterface;
use Siemendev\Checkout\Products\Data\QuotedCheckoutDataInterface;
use Siemendev\Checkout\Products\Product\ProductInterface;

class CheckoutData extends GenericCheckoutData implements
    DeliverableCheckoutDataInterface,
    ProductCheckoutDataInterface,
    QuotedCheckoutDataInterface,
    PaymentCheckoutDataInterface,
    AgeVerifiableCheckoutDataInterface
{
    use IsDeliverable;
    use HasAgeVerification;
    use ContainsProducts;
    use ContainsQuote;
    use ContainsPayments;

    public ?string $orderFileName = null;

    public function getHash(): string
    {
        return md5(
            $this->getCurrency()
            . $this->getBillingAddress()?->getHash()
            . $this->getDeliveryAddress()?->getHash()
            . implode('-', array_map(static fn (ProductInterface $product) => $product->getIdentifier(), $this->getProducts()))
            . implode('-', array_map(static fn (PaymentInterface $payment) => $payment->getIdentifier() . $payment->getCurrency() . $payment->getAmount(), iterator_to_array($this->getPayments())))
            . $this->isAgeVerified()
            . $this->getDeliveryOption()?->getIdentifier()
        );
    }
}

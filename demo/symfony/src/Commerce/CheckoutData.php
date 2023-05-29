<?php declare(strict_types=1);

namespace App\Commerce;

use App\Commerce\Step\HasAgeVerification;
use App\Commerce\Step\AgeVerifiableCheckoutDataInterface;
use Siemendev\Checkout\Data\GenericCheckoutData;
use Siemendev\Checkout\Delivery\Data\DeliverableCheckoutDataInterface;
use Siemendev\Checkout\Delivery\Data\IsDeliverable;
use Siemendev\Checkout\GiftCard\Data\ContainsGiftCards;
use Siemendev\Checkout\GiftCard\Data\GiftCardApplicableCheckoutDataInterface;
use Siemendev\Checkout\Payment\Data\ContainsPayments;
use Siemendev\Checkout\Payment\Data\PaymentCheckoutDataInterface;
use Siemendev\Checkout\Products\Data\ContainsProducts;
use Siemendev\Checkout\Products\Data\ProductCheckoutDataInterface;

class CheckoutData extends GenericCheckoutData implements
    DeliverableCheckoutDataInterface,
    ProductCheckoutDataInterface,
    PaymentCheckoutDataInterface,
    GiftCardApplicableCheckoutDataInterface,
    AgeVerifiableCheckoutDataInterface
{
    use IsDeliverable;
    use HasAgeVerification;
    use ContainsProducts;
    use ContainsPayments;
    use ContainsGiftCards;
}

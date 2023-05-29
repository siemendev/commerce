<?php declare(strict_types=1);

namespace App\Commerce;

use App\Commerce\Step\AgeVerifiableCheckoutData;
use App\Commerce\Step\AgeVerifiableCheckoutDataInterface;
use Siemendev\Checkout\Data\GenericCheckoutData;
use Siemendev\Checkout\GiftCard\Data\GiftCardApplicableCheckoutData;
use Siemendev\Checkout\GiftCard\Data\GiftCardApplicableCheckoutDataInterface;
use Siemendev\Checkout\Payment\Data\ContainsPayments;
use Siemendev\Checkout\Payment\Data\PaymentCheckoutDataInterface;
use Siemendev\Checkout\Products\Data\ContainsProducts;
use Siemendev\Checkout\Products\Data\ProductCheckoutDataInterface;

class CheckoutData extends GenericCheckoutData implements ProductCheckoutDataInterface, PaymentCheckoutDataInterface, AgeVerifiableCheckoutDataInterface, GiftCardApplicableCheckoutDataInterface
{
    use ContainsProducts;
    use ContainsPayments;
    use AgeVerifiableCheckoutData;
    use GiftCardApplicableCheckoutData;
}

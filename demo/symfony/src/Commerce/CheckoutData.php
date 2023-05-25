<?php declare(strict_types=1);

namespace App\Commerce;

use App\Commerce\Step\AgeVerifiableCheckoutData;
use App\Commerce\Step\AgeVerifiableCheckoutDataInterface;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Data\GenericCheckoutData;
use Siemendev\Checkout\GiftCard\Data\GiftCardApplicableCheckoutData;
use Siemendev\Checkout\GiftCard\Data\GiftCardApplicableCheckoutDataInterface;
use Siemendev\Checkout\Products\Data\ContainsProductPayments;
use Siemendev\Checkout\Products\Data\ContainsProducts;
use Siemendev\Checkout\Products\Data\ProductCheckoutDataInterface;

class CheckoutData extends GenericCheckoutData implements ProductCheckoutDataInterface, AgeVerifiableCheckoutDataInterface, GiftCardApplicableCheckoutDataInterface
{
    use ContainsProducts;
    use ContainsProductPayments;
    use AgeVerifiableCheckoutData;
    use GiftCardApplicableCheckoutData;
}

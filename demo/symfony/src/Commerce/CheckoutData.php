<?php declare(strict_types=1);

namespace App\Commerce;

use App\Commerce\Step\AgeVerifiableCheckoutData;
use App\Commerce\Step\AgeVerifiableCheckoutDataInterface;
use Siemendev\Checkout\Data\GenericCheckoutData;
use Siemendev\Checkout\GiftCard\Data\GiftCardApplicableCheckoutData;
use Siemendev\Checkout\GiftCard\Data\GiftCardApplicableCheckoutDataInterface;

class CheckoutData extends GenericCheckoutData implements AgeVerifiableCheckoutDataInterface, GiftCardApplicableCheckoutDataInterface
{
    use AgeVerifiableCheckoutData;
    use GiftCardApplicableCheckoutData;
}

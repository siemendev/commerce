<?php declare(strict_types=1);

namespace App\Commerce;

use App\Commerce\Step\AgeVerifiableCheckoutData;
use App\Commerce\Step\AgeVerifiableCheckoutDataInterface;
use Siemendev\Checkout\Data\CheckoutData as VendorCheckoutData;

class CheckoutData extends VendorCheckoutData implements AgeVerifiableCheckoutDataInterface
{
    use AgeVerifiableCheckoutData;
}

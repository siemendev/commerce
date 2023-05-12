<?php declare(strict_types=1);

namespace App\Commerce;

use App\Commerce\Step\AgeVerifiableCheckoutData;
use App\Commerce\Step\AgeVerifiableCheckoutDataInterface;
use Siemendev\Checkout\Data\GenericCheckoutData;

class CheckoutData extends GenericCheckoutData implements AgeVerifiableCheckoutDataInterface
{
    use AgeVerifiableCheckoutData;
}

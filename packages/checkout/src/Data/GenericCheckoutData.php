<?php declare(strict_types=1);

namespace Siemendev\Checkout\Data;

use Siemendev\Checkout\Step\Address\Billing\BillingAddressableCheckoutData;
use Siemendev\Checkout\Step\Address\Billing\BillingAddressableCheckoutDataInterface;

class GenericCheckoutData extends AbstractCheckoutData implements BillingAddressableCheckoutDataInterface
{
    use BillingAddressableCheckoutData;
}

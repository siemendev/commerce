<?php declare(strict_types=1);

namespace Siemendev\Checkout\Data;

use Siemendev\Checkout\Step\Address\Billing\BillingAddressableCheckoutData;
use Siemendev\Checkout\Step\Address\Billing\BillingAddressableCheckoutDataInterface;
use Siemendev\Checkout\Step\Delivery\DeliverableCheckoutData;
use Siemendev\Checkout\Step\Delivery\DeliverableCheckoutDataInterface;

class GenericCheckoutData implements CheckoutDataInterface, DeliverableCheckoutDataInterface, BillingAddressableCheckoutDataInterface
{
    use DeliverableCheckoutData;
    use BillingAddressableCheckoutData;
}

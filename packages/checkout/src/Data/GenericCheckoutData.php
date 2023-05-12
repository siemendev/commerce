<?php declare(strict_types=1);

namespace Siemendev\Checkout\Data;

use Siemendev\Checkout\Step\Address\Billing\BillingAddressableCheckoutData;
use Siemendev\Checkout\Step\Address\Billing\BillingAddressableCheckoutDataInterface;
use Siemendev\Checkout\Step\Address\Delivery\DeliveryAddressableCheckoutData;
use Siemendev\Checkout\Step\Address\Delivery\DeliveryAddressableCheckoutDataInterface;

class GenericCheckoutData extends AbstractCheckoutData implements DeliveryAddressableCheckoutDataInterface, BillingAddressableCheckoutDataInterface
{
    use DeliveryAddressableCheckoutData;
    use BillingAddressableCheckoutData;
}

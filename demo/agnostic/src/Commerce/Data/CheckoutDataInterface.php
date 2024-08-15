<?php

declare(strict_types=1);

namespace Demo\Commerce\Data;

use Demo\Commerce\Step\AgeVerifiableCheckoutDataInterface;
use Siemendev\Checkout\Delivery\Data\DeliverableCheckoutDataInterface;
use Siemendev\Checkout\Payment\Data\PaymentCheckoutDataInterface;
use Siemendev\Checkout\Products\Data\ProductCheckoutDataInterface;
use Siemendev\Checkout\Products\Data\QuotedCheckoutDataInterface;
use Siemendev\Checkout\Step\Address\Billing\BillingAddressableCheckoutDataInterface;

interface CheckoutDataInterface extends
    BillingAddressableCheckoutDataInterface,
    DeliverableCheckoutDataInterface,
    ProductCheckoutDataInterface,
    QuotedCheckoutDataInterface,
    PaymentCheckoutDataInterface,
    AgeVerifiableCheckoutDataInterface
{
}

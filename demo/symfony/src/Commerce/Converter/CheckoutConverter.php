<?php declare(strict_types=1);

namespace App\Commerce\Converter;

use App\ObjectExporter\ObjectExporter;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Finalize\CheckoutFinalizationHandlerInterface;
use Siemendev\Checkout\Finalize\CheckoutFinalizerInterface;

/**
 * Demo of a checkout persistence handler that saves the checkout data to a file.
 * The CheckoutData has a property $orderFileName that is set by this handler to provide rollback functionality.
 * The file is saved in the var/orders directory.
 */
class CheckoutConverter implements CheckoutFinalizationHandlerInterface
{
    public function __construct(
        private readonly ObjectExporter $objectExporter,
    ) {
    }

    public function step(): string
    {
        return CheckoutFinalizerInterface::FINALIZATION_STEP_CONVERSION;
    }

    public function finalize(CheckoutDataInterface $data): void
    {
        $filename = 'orders/' . date('Y-m-d_H-i-s') . '/order.xml';
        $this->objectExporter->export($data, $filename);
        $data->orderFileName = $filename;
    }

    public function rollback(CheckoutDataInterface $data): void
    {
        $this->objectExporter->remove($data->orderFileName);
    }
}

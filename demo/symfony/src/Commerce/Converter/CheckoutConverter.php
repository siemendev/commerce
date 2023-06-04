<?php declare(strict_types=1);

namespace App\Commerce\Converter;

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
    public function step(): string
    {
        return CheckoutFinalizerInterface::FINALIZATION_STEP_CONVERSION;
    }

    public function finalize(CheckoutDataInterface $data): void
    {
        $data->orderFileName = 'var/orders/' . date('Y-m-d_H-i-s') . '.json';
        file_put_contents($data->orderFileName, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function rollback(CheckoutDataInterface $data): void
    {
        if (null !== $data->orderFileName && file_exists($data->orderFileName)) {
            unlink($data->orderFileName);
        }
    }
}

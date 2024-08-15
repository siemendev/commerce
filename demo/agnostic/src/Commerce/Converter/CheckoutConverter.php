<?php

declare(strict_types=1);

namespace Demo\Commerce\Converter;

use Demo\Commerce\Data\CheckoutData;
use Demo\ObjectExporter\ObjectExporter;
use Demo\Product\ProductRepository;
use Demo\Repository\ObjectNotFoundException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Finalize\CheckoutFinalizationHandlerInterface;
use Siemendev\Checkout\Finalize\CheckoutFinalizerInterface;
use Siemendev\Checkout\Products\Product\ProductInterface;

/**
 * Demo of a checkout persistence handler that saves the checkout data to a file.
 * The CheckoutData has a property $orderFileName that is set by this handler to provide rollback functionality.
 * The file is saved in the var/orders directory.
 */
class CheckoutConverter implements CheckoutFinalizationHandlerInterface
{
    private const PATH = 'orders/%s/order.xml';

    public function __construct(
        private readonly ObjectExporter $objectExporter,
        private readonly ProductRepository $productRepository,
    ) {
    }

    public function step(): string
    {
        return CheckoutFinalizerInterface::FINALIZATION_STEP_CONVERSION;
    }

    /**
     * @param CheckoutData $data
     */
    public function finalize(CheckoutDataInterface $data): void
    {
        $this->objectExporter->export($data, sprintf(self::PATH, $data->getIdentifier()));

        foreach ($data->getProducts() as $checkoutProduct) {
            /* @var ProductInterface $checkoutProduct */
            try {
                $product = $this->productRepository->load($checkoutProduct->getIdentifier());
            } catch (ObjectNotFoundException) {
                continue;
            }
            $product->stock -= $checkoutProduct->getQuantity();
            $this->productRepository->save($product);
        }
    }

    public function rollback(CheckoutDataInterface $data): void
    {
        $this->objectExporter->remove(sprintf(self::PATH, $data->getIdentifier()));

        foreach ($data->getProducts() as $checkoutProduct) {
            /* @var ProductInterface $checkoutProduct */
            try {
                $product = $this->productRepository->load($checkoutProduct->getIdentifier());
            } catch (ObjectNotFoundException) {
                continue;
            }
            $product->stock += $checkoutProduct->getQuantity();
            $this->productRepository->save($product);
        }
    }
}

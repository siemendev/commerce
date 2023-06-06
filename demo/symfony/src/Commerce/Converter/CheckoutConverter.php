<?php declare(strict_types=1);

namespace App\Commerce\Converter;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Finalize\CheckoutFinalizationHandlerInterface;
use Siemendev\Checkout\Finalize\CheckoutFinalizerInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
        $directory = '../var/orders/';
        if (!is_dir($directory) && !mkdir(directory: $directory, recursive: true) && !is_dir($directory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $directory));
        }
        $data->orderFileName = date('Y-m-d_H-i-s') . '.xml';

        $serializer = new Serializer([new ObjectNormalizer()], [new XmlEncoder()]);

        file_put_contents(
            $directory . $data->orderFileName,
            $serializer->serialize($data, XmlEncoder::FORMAT, [
                'xml_root_node_name' => 'order',
                'xml_format_output' => true,
            ]),
        );
    }

    public function rollback(CheckoutDataInterface $data): void
    {
        if (null !== $data->orderFileName && file_exists($data->orderFileName)) {
            unlink($data->orderFileName);
        }
    }
}

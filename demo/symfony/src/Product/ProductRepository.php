<?php

declare(strict_types=1);

namespace App\Product;

use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use RuntimeException;

class ProductRepository
{
    private const PRODUCTS_DIRECTORY = __DIR__ . '/../../var/products';

    private const PRODUCT_FILE_GLOB_PATTERN = self::PRODUCTS_DIRECTORY . '/*.xml';

    private const PRODUCT_FILE_PATTERN = self::PRODUCTS_DIRECTORY . '/%s.xml';

    private Serializer $serializer;

    public function __construct()
    {
        $this->serializer = new Serializer([new ObjectNormalizer()], [new XmlEncoder()]);
    }

    /**
     * @return array<Product>
     * @throws ProductNotFoundException
     */
    public function loadAll(): array
    {
        $this->ensureProductsDirectory();

        $products = [];

        foreach ($this->loadAllIds() as $id) {
            $products[] = $this->load($id);
        }

        return $products;
    }

    /**
     * @return array<string>
     */
    public function loadAllIds(): array
    {
        $ids = [];
        foreach (glob(self::PRODUCT_FILE_GLOB_PATTERN) as $filename) {
            if (!is_file($filename)) {
                continue;
            }
            $id = pathinfo($filename, PATHINFO_FILENAME);
            if (!is_string($id) || '' === $id) {
                continue;
            }

            $ids[] = $id;
        }

        return $ids;
    }

    /**
     * @throws ProductNotFoundException
     */
    public function load(string $id): Product
    {
        $this->ensureProductsDirectory();

        $file = $this->getFilename($id);

        if (!file_exists($file)) {
            throw new ProductNotFoundException($id);
        }

        $product = $this->serializer->deserialize(file_get_contents($file), Product::class, 'xml');

        if (!$product instanceof Product) {
            throw new ProductNotFoundException($id);
        }

        return $product;
    }

    public function save(Product $product): void
    {
        $this->ensureProductsDirectory();

        file_put_contents(
            $this->getFilename($product->id),
            $this->serializer->serialize(
                $product,
                'xml',
                [
                    'xml_root_node_name' => 'product',
                    'xml_format_output' => true,
                ]
            )
        );
    }

    public function delete(string $id): void
    {
        $this->ensureProductsDirectory();

        if (!$this->exists($id)) {
            throw new RuntimeException('Product not found');
        }

        unlink($this->getFilename($id));
    }

    public function exists(string $id): bool
    {
        $this->ensureProductsDirectory();

        return file_exists($this->getFilename($id));
    }

    private function getFilename(string $id): string
    {
        return sprintf(self::PRODUCT_FILE_PATTERN, $id);
    }

    private function ensureProductsDirectory(): void
    {
        if (!is_dir(self::PRODUCTS_DIRECTORY) && !mkdir(self::PRODUCTS_DIRECTORY, 0777, true) && !is_dir(self::PRODUCTS_DIRECTORY)) {
            throw new RuntimeException(sprintf('Directory "%s" could not be created', self::PRODUCTS_DIRECTORY));
        }
    }
}

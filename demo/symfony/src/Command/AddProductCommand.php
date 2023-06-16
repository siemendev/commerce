<?php

declare(strict_types=1);

namespace App\Command;

use App\Product\Product;
use App\Product\ProductRepository;
use Siemendev\Checkout\Taxation\VatTypedItemInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use RuntimeException;

class AddProductCommand extends Command
{
    protected static $defaultName = 'commerce:products:add';

    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Add a product.')
            ->setHelp('This command allows you to add a product')
            ->addOption('id', null, InputOption::VALUE_REQUIRED, 'The id of the product')
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'The name of the product')
            ->addOption('description', null, InputOption::VALUE_REQUIRED, 'The description of the product')
            ->addOption('price', 'p', InputOption::VALUE_REQUIRED, 'The price of the product')
            ->addOption('vat', null, InputOption::VALUE_REQUIRED, 'The vat type of the product (high, low, or low1)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $product = new Product();

        $product->id = $input->getOption('id') ?: $this->generateId();
        $product->name = $input->getOption('name') ?: 'Product ' . $product->id;
        $product->description = $input->getOption('description') ?: 'Product ' . $product->id . ' description';
        $product->vatType = $input->getOption('vat') ?: VatTypedItemInterface::VAT_TYPE_DEFAULT;

        $inputPrice = $input->getOption('price');
        if (is_numeric($inputPrice)) {
            $product->price = (int) $inputPrice;
        } else {
            // looks complicated, but it's just a random price between 500 and 10000 in steps of 500 that gets
            // either 1, 2, 5 or 10 (randomly selected) subtracted to look like a more realistic price
            $product->price = rand(1, 20) * 500 - [1,2,5,10][rand(0, 3)];
        }

        $state = 'added';
        if ($this->productRepository->exists($product->id)) {
            $this->productRepository->delete($product->id);
            $state = 'updated';
        }

        $this->productRepository->save($product);

        $io->success(sprintf('Product "%s" (id: %s) %s', $product->name, $product->id, $state));

        return Command::SUCCESS;
    }

    public function generateId(): string
    {
        $try = 1;
        while ($this->isIdAlreadyInUse($id = uniqid('', true))) {
            ++$try;
            if ($try > 100) {
                throw new RuntimeException('Could not generate a unique id');
            }
        }

        return $id;
    }

    private function isIdAlreadyInUse(string $id): bool
    {
        static $ids;
        if (!isset($ids)) {
            $ids = $this->productRepository->loadAllIds();
        }

        return in_array($id, $ids, true);
    }
}

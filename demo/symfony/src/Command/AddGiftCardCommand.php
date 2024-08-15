<?php

declare(strict_types=1);

namespace App\Command;

use Demo\GiftCard\GiftCard;
use Demo\GiftCard\GiftCardRepository;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddGiftCardCommand extends Command
{
    protected static $defaultName = 'commerce:giftcards:add';

    public function __construct(
        private readonly GiftCardRepository $giftCardRepository,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Add a gift card.')
            ->setHelp('This command allows you to add a gift card')
            ->addOption('code', null, InputOption::VALUE_REQUIRED, 'The code of the gift card')
            ->addOption('balance', null, InputOption::VALUE_REQUIRED, 'The balance of the gift card')
            ->addOption('currency', null, InputOption::VALUE_REQUIRED, 'The currency of the gift card')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $giftCard = new GiftCard();

        $giftCard->code = $input->getOption('code') ?: $this->generateId();
        $giftCard->currency = $input->getOption('currency') ?: 'EUR';

        $inputBalance = $input->getOption('balance');
        if (is_numeric($inputBalance)) {
            $giftCard->balance = (int) $inputBalance;
        } else {
            // looks complicated, but it's just a random balance between 500 and 25000 in steps of 500
            $giftCard->balance = rand(1, 50) * 500;
        }

        $state = 'added';
        if ($this->giftCardRepository->exists($giftCard->code)) {
            $this->giftCardRepository->delete($giftCard->code);
            $state = 'updated';
        }

        $this->giftCardRepository->save($giftCard);

        $io->success(sprintf('Gift card with code %s %s', $giftCard->code, $state));

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
            $ids = $this->giftCardRepository->loadAllIds();
        }

        return in_array($id, $ids, true);
    }
}

<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Address;

use Siemendev\Checkout\Step\Exception\ValidationException;

interface AddressInterface
{
    /**
     * @throws ValidationException
     */
    public function validate(): void;

    public function isValid(): bool;

    public function getCountryCode(): string;

    public function getPostalCode(): string;

    public function isCompany(): bool;

    public function getHash(): string;
}

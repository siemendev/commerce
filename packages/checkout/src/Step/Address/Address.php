<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Address;

use Siemendev\Checkout\Step\Exception\ValidationException;

class Address implements AddressInterface
{
    private string $name = '';
    private string $addressLine1 = '';
    private ?string $addressLine2 = null;
    private string $city = '';
    private ?string $state = null;
    private string $postalCode = '';
    private string $countryCode = '';
    private bool $company = false;

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): static {
        $this->name = $name;

        return $this;
    }

    public function getAddressLine1(): string {
        return $this->addressLine1;
    }

    public function setAddressLine1(string $addressLine1): static {
        $this->addressLine1 = $addressLine1;

        return $this;
    }

    public function getAddressLine2(): ?string {
        return $this->addressLine2;
    }

    public function setAddressLine2(?string $addressLine2): static {
        $this->addressLine2 = $addressLine2;

        return $this;
    }

    public function getCity(): string {
        return $this->city;
    }

    public function setCity(string $city): static {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string {
        return $this->state;
    }

    public function setState(?string $state): static {
        $this->state = $state;

        return $this;
    }

    public function getPostalCode(): string {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCountryCode(): string {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): static {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function isCompany(): bool {
        return $this->company;
    }

    public function setCompany(bool $company): static {
        $this->company = $company;

        return $this;
    }

    public function validate(): void {
        if (empty($this->name)) {
            throw new ValidationException('Address line 1 is required');
        }
        if (empty($this->addressLine1)) {
            throw new ValidationException('Address line 1 is required');
        }
        if (empty($this->postalCode)) {
            throw new ValidationException('Postal code is required');
        }
        if (empty($this->city)) {
            throw new ValidationException('City is required');
        }
        if (empty($this->countryCode)) {
            throw new ValidationException('Country is required');
        }
    }

    public function isValid(): bool
    {
        try {
            $this->validate();
        } catch (ValidationException) {
            return false;
        }

        return true;
    }
}


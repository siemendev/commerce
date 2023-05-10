<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Address;

use Siemendev\Checkout\Step\Exception\ValidationException;

class Address implements AddressInterface
{
    private string $addressLine1 = '';
    private ?string $addressLine2 = null;
    private string $city = '';
    private ?string $state = null;
    private string $postalCode = '';
    private string $country = '';

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

    public function getCountry(): string {
        return $this->country;
    }

    public function setCountry(string $country): static {
        $this->country = $country;

        return $this;
    }

    public function validate(): void {
        if (empty($this->addressLine1)) {
            throw new ValidationException('Address line 1 is required');
        }
        if (empty($this->postalCode)) {
            throw new ValidationException('Postal code is required');
        }
        if (empty($this->city)) {
            throw new ValidationException('City is required');
        }
        if (empty($this->country)) {
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


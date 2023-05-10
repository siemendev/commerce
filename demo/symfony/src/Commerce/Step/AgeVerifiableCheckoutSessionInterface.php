<?php declare(strict_types=1);

namespace App\Commerce\Step;

interface AgeVerifiableCheckoutSessionInterface
{
    public function isAgeVerified(): bool;
}

<?php declare(strict_types=1);

namespace App\Commerce\Step;

interface AgeVerifiableCheckoutDataInterface
{
    public function isAgeVerified(): bool;
}

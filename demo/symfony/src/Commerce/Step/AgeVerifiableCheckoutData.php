<?php declare(strict_types=1);

namespace App\Commerce\Step;

use App\Commerce\CheckoutData;

trait AgeVerifiableCheckoutData
{
    private bool $ageVerified = false;

    public function setAgeVerified(bool $ageVerified): CheckoutData
    {
        $this->ageVerified = $ageVerified;

        return $this;
    }

    public function isAgeVerified(): bool
    {
        return $this->ageVerified;
    }
}

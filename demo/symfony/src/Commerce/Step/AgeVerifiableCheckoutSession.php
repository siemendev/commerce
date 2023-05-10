<?php declare(strict_types=1);

namespace App\Commerce\Step;

use App\Commerce\CheckoutSession;

trait AgeVerifiableCheckoutSession
{
    private bool $ageVerified = false;

    public function setAgeVerified(bool $ageVerified): CheckoutSession
    {
        $this->ageVerified = $ageVerified;

        return $this;
    }

    public function isAgeVerified(): bool
    {
        return $this->ageVerified;
    }
}

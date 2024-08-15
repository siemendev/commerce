<?php

declare(strict_types=1);

namespace Demo\Commerce\Step;

use Demo\Commerce\Data\CheckoutData;

trait HasAgeVerification
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

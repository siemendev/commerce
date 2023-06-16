<?php

declare(strict_types=1);

namespace App\Commerce\Step;

trait HasAgeVerificationImmutable
{
    private bool $ageVerified = false;

    public function isAgeVerified(): bool
    {
        return $this->ageVerified;
    }
}

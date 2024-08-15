<?php

declare(strict_types=1);

namespace Demo\Commerce\Step;

trait HasAgeVerificationImmutable
{
    private bool $ageVerified = false;

    public function isAgeVerified(): bool
    {
        return $this->ageVerified;
    }
}

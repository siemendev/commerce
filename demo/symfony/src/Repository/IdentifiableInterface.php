<?php

declare(strict_types=1);

namespace App\Repository;

interface IdentifiableInterface
{
    public function getIdentifier(): string;
}

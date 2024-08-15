<?php

declare(strict_types=1);

namespace Demo\Repository;

interface IdentifiableInterface
{
    public function getIdentifier(): string;
}

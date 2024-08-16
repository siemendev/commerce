<?php

declare(strict_types=1);

namespace Demo\Repository;

use Symfony\Component\Serializer\Attribute\Ignore;

interface IdentifiableInterface
{
    #[Ignore]
    public function getIdentifier(): string;
}

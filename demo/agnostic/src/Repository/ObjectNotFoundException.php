<?php

declare(strict_types=1);

namespace Demo\Repository;

use Exception;

class ObjectNotFoundException extends Exception
{
    public function __construct(string $class, string $id)
    {
        parent::__construct(sprintf('%s with id "%s" not found.', $class, $id));
    }
}

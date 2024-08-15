<?php

declare(strict_types=1);

namespace Demo\Commerce\Step;

use Siemendev\Checkout\Step\Exception\ValidationException;

class AgeNotVerifiedException extends ValidationException
{
    public function __construct()
    {
        parent::__construct('Age not verified');
    }
}

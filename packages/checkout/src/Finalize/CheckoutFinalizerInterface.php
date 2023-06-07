<?php declare(strict_types=1);

namespace Siemendev\Checkout\Finalize;

use Siemendev\Checkout\Data\CheckoutDataInterface;

interface CheckoutFinalizerInterface
{
    public const FINALIZATION_STEP_PAYMENT = 'payment';
    public const FINALIZATION_STEP_CONVERSION = 'conversion';
    public const FINALIZATION_STEP_NOTIFICATION = 'notification';

    public const DEFAULT_FINALIZATION_STEPS = [
        self::FINALIZATION_STEP_PAYMENT,
        self::FINALIZATION_STEP_CONVERSION,
        self::FINALIZATION_STEP_NOTIFICATION,
    ];

    /**
     * @throws CheckoutFinalizationExceptionWrapper
     * @throws UnknownFinalizationStepException when there are handlers left with an unknown finalization step.
     */
    public function finalize(CheckoutDataInterface $data): void;
}

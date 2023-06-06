<?php declare(strict_types=1);

namespace Siemendev\Checkout\Finalize;

use Siemendev\Checkout\Data\CheckoutDataInterface;

interface CheckoutFinalizationHandlerInterface
{
    /**
     * Returns the name of the finalization step in which your handler should be executed.
     * Usually one of the CheckoutFinalizerInterface::FINALIZATION_STEP_* constants, but you can also create your own!
     */
    public function step(): string;

    /**
     * Finalizes your part of the checkout process. CheckoutFinalizaterInterface will call this method for each step in
     * the configured order. If you throw an exception, the finalizer will return that exception and rollback all
     * previous finalization steps.
     * Important: ONLY use (instances of) CheckoutNotFinalizableException to indicate that the checkout process cannot
     * be finalized. Every other exception will not be caught by the finalizer and will result in a fatal error with
     * no rollback!
     *
     * @throws CheckoutNotFinalizableException
     */
    public function finalize(CheckoutDataInterface $data): void;

    /**
     * Roll back your part of the checkout process. In case another handler fails after your handler has been executed,
     * the finalizer will call this method to roll back your changes.
     */
    public function rollback(CheckoutDataInterface $data): void;
}

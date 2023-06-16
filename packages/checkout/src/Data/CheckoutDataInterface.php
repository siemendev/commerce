<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Data;

/**
 * This interface is only used to identify a class as checkout data.
 */
interface CheckoutDataInterface
{
    public function getCurrency(): string;

    /**
     * Check if the checkout data is locked
     * This is used to prevent changes to the checkout data after the quote has been calculated.
     * Use CheckoutDataInterface::lock() to lock the checkout data before authorizing any payments.
     */
    public function isLocked(): bool;

    /**
     * Lock the checkout data
     * Call this method before authorizing any payments to prevent changes to the checkout data after the quote has
     * been calculated. The quote will no longer be recalculated and prices as well as availabilities will be fixed.
     * When calling this method, make sure the quote has set previously, otherwise the quote will not be calculated.
     */
    public function lock(): static;

    public function isFinalized(): bool;

    public function finalize(): static;

    /**
     * This method is used to identify changes in the checkout data. Make sure your implementation includes all
     * properties that are used to calculate the quote, otherwise the quote will not be recalculated when these
     * properties change!
     * Heads up on just serializing your CheckoutDataInterface implementation: Take care of objects (need to be
     * serializable too) and dates (changing timestamps should probably not trigger a recalculation).
     * Rule of thumb: Choose hash properties explicitly and provide a hash function that is not too expensive to run.
     */
    public function getHash(): string;
}

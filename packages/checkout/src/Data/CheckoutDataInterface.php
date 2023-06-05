<?php declare(strict_types=1);

namespace Siemendev\Checkout\Data;

/**
 * This interface is only used to identify a class as checkout data.
 */
interface CheckoutDataInterface
{
    public function getCurrency(): string;

    public function isLocked(): bool;

    public function lock(): void;

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

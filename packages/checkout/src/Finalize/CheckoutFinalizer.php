<?php declare(strict_types=1);

namespace Siemendev\Checkout\Finalize;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Throwable;

class CheckoutFinalizer implements CheckoutFinalizerInterface
{
    /** @var string[] */
    private array $finalizationSteps;

    /** @var array<CheckoutFinalizationHandlerInterface> */
    private array $finalizationHandlers = [];

    /**
     * @param CheckoutFinalizationHandlerInterface[] $finalizationHandlers
     * @param null|string[] $finalizationSteps if null, CheckoutFinalizerInterface::DEFAULT_FINALIZATION_STEPS will be used
     */
    public function __construct(
        array $finalizationHandlers = [],
        ?array $finalizationSteps = null,
    ) {
        $this->finalizationSteps = $finalizationSteps ?? CheckoutFinalizerInterface::DEFAULT_FINALIZATION_STEPS;

        foreach ($finalizationHandlers as $finalizationHandler) {
            $this->addFinalizationHandler($finalizationHandler);
        }
    }

    public function addFinalizationHandler(CheckoutFinalizationHandlerInterface $finalizationHandler): static
    {
        $this->finalizationHandlers[] = $finalizationHandler;

        return $this;
    }

    /**
     * @param string[] $finalizationSteps
     */
    public function setFinalizationSteps(array $finalizationSteps): static
    {
        $this->finalizationSteps = $finalizationSteps;

        return $this;
    }

    /**
     * @inheritDoc
     * @throws Throwable
     */
    public function finalize(CheckoutDataInterface $data): void
    {
        $doneHandlers = [];
        $todoHandlers = $this->finalizationHandlers;
        try {
            foreach ($this->finalizationSteps as $finalizationStep) {
                foreach ($todoHandlers as $index => $finalizationHandler) {
                    if ($finalizationHandler->step() !== $finalizationStep) {
                        continue;
                    }
                    $finalizationHandler->finalize($data);
                    unset($todoHandlers[$index]);
                    $doneHandlers[] = $finalizationHandler;
                }
            }
        } catch(Throwable $exception) {
            foreach ($doneHandlers as $finalizationHandler) {
                /** @var $finalizationHandler CheckoutFinalizationHandlerInterface */
                $finalizationHandler->rollback($data);
            }
            throw $exception;
        }
        $data->finalize();

        if (count($todoHandlers) > 0) {
            throw new UnknownFinalizationStepException($todoHandlers[0], $this->finalizationSteps);
        }
    }
}

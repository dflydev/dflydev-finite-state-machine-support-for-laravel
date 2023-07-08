<?php

declare(strict_types=1);

namespace Dflydev\FiniteStateMachine\SupportForLaravel;

use Dflydev\FiniteStateMachine\FiniteStateMachine;
use Dflydev\FiniteStateMachine\FiniteStateMachineFactory;
use Throwable;

trait SingleFiniteStateMachineBehavior
{
    /**
     * @var array<string,FiniteStateMachine>
     */
    private static array $finiteStateMachines;

    abstract protected function getFiniteStateMachineDiscriminator(): string;

    private function getFiniteStateMachine(?FiniteStateMachineFactory $finiteStateMachineFactory = null): FiniteStateMachine
    {
        $key = self::class.':'.spl_object_id($this).':'.$this->getFiniteStateMachineDiscriminator();

        if (isset(self::$finiteStateMachines[$key])) {
            return self::$finiteStateMachines[$key];
        }

        $finiteStateMachineFactory = $finiteStateMachineFactory ?? app(FiniteStateMachineFactory::class);

        return self::$finiteStateMachines[$key] = $finiteStateMachineFactory->build($this);
    }

    private function assertCanTransition(string $transition): void
    {
        if ($this->canTransition($transition)) {
            return;
        }

        throw UnableToChangeState::via($transition);
    }

    private function canTransition(string $transition): bool
    {
        return $this->getFiniteStateMachine()->can($transition);
    }

    private function applyTransition(string $transition): void
    {
        try {
            $this->getFiniteStateMachine()->apply($transition);
        } catch (Throwable $throwable) {
            throw UnableToChangeState::via($transition, $throwable);
        }
    }
}

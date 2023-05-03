<?php

declare(strict_types=1);

/**
 * Copyright (c) 2023 Dragonfly Development Inc
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/dflydev/dflydev-finite-state-machine-support-for-laravel
 */

namespace Dflydev\FiniteStateMachine\SupportForLaravel;

use Dflydev\FiniteStateMachine\FiniteStateMachine;
use Dflydev\FiniteStateMachine\FiniteStateMachineFactory;
use Throwable;

trait SingleFiniteStateMachineBehavior
{
    private FiniteStateMachine $finiteStateMachine;

    private function getFiniteStateMachine(?FiniteStateMachineFactory $finiteStateMachineFactory = null): FiniteStateMachine
    {
        if (isset($this->finiteStateMachine)) {
            return $this->finiteStateMachine;
        }

        $finiteStateMachineFactory = $finiteStateMachineFactory ?? app(FiniteStateMachineFactory::class);

        return $this->finiteStateMachine = $finiteStateMachineFactory->build($this);
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

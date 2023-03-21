<?php

declare(strict_types=1);

namespace Dflydev\FiniteStateMachine\SupportForLaravel;

use Dflydev\FiniteStateMachine\Contracts\ObjectProxy;
use Dflydev\FiniteStateMachine\State\State;
use Dflydev\FiniteStateMachine\Transition\Transition;

class EloquentObjectProxy implements ObjectProxy
{
    private object $object;

    private string $property;

    public function __construct(object $object, string $property)
    {
        $this->object = $object;
        $this->property = $property;
    }

    public function object(): object
    {
        return $this->object;
    }

    public function state(): ?string
    {
        return $this->object->{$this->property};
    }

    public function apply(
        Transition $transition,
        State $fromState,
        State $toState
    ): void {
        $this->object->{$this->property} = $toState->name();
    }
}

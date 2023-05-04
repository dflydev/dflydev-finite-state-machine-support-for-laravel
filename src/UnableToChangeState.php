<?php

declare(strict_types=1);

namespace Dflydev\FiniteStateMachine\SupportForLaravel;

use RuntimeException;
use Throwable;

final class UnableToChangeState extends RuntimeException
{
    private string $transition;

    public static function via(string $transition, Throwable $previous = null): self
    {
        $instance = new self("Unable to change state via transition \"{$transition}\".", 0, $previous);
        $instance->transition = $transition;

        return $instance;
    }

    public function transition(): ?string
    {
        return $this->transition ?? null;
    }
}

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

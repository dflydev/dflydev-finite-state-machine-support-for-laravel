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

use Dflydev\FiniteStateMachine\Contracts\ObjectProxy;
use Dflydev\FiniteStateMachine\Contracts\ObjectProxyFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentObjectProxyFactory implements ObjectProxyFactory
{
    private string $defaultPropertyName;

    public function __construct(string $defaultPropertyName = 'state')
    {
        $this->defaultPropertyName = $defaultPropertyName;
    }

    public function build(object $object, array $options): ObjectProxy
    {
        return new EloquentObjectProxy($object, $options['property_path'] ?? $this->defaultPropertyName);
    }

    public function supports(object $object, array $options): bool
    {
        return $object instanceof Model;
    }
}

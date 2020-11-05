<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

declare(strict_types=1);

namespace Spiral\Router;

use Psr\Container\ContainerInterface;
use Spiral\Core\FactoryInterface;

/**
 * Manages the presets for various route groups.
 */
final class GroupRegistry implements GroupRegistryInterface
{
    /** @var ContainerInterface */
    private $factory;

    /** @var RouteGroup[] */
    private $groups = [];

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param string $name
     * @return RouteGroupInterface
     */
    public function getGroup(string $name): RouteGroupInterface
    {
        if (!isset($this->groups[$name])) {
            $this->groups[$name] = $this->factory->make(RouteGroup::class);
        }

        return $this->groups[$name];
    }

    /**
     * @return RouteGroupInterface[]|\ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->groups);
    }
}

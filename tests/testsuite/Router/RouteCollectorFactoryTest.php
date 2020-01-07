<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Test\Suite\Router;

use FastRoute\RouteCollector;
use Johncms\System\Router\RouteCollectorFactory;
use Johncms\System\Users\User;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class RouteCollectorFactoryTest extends TestCase
{
    public function testFactoryReturnsRouteCollectorInstance(): void
    {
        $container = Mockery::mock(ContainerInterface::class);
        $container
            ->allows()
            ->get(User::class)
            ->andReturn(Mockery::mock(User::class));
        $instance = (new RouteCollectorFactory())($container);
        $this->assertInstanceOf(RouteCollector::class, $instance);
    }
}

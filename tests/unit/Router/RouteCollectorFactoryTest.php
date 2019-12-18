<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Tests\Unit\Router;

use Codeception\Test\Unit;
use FastRoute\RouteCollector;
use Johncms\System\Router\RouteCollectorFactory;
use Johncms\System\Users\User;
use Zend\ServiceManager\ServiceManager;

class RouteCollectorFactoryTest extends Unit
{
    public function testFactoryReturnsRouteCollectorInstance(): void
    {
        $container = new ServiceManager();
        $container->setService(User::class, $this->prophesize(User::class)->reveal());
        $instance = (new RouteCollectorFactory())($container);
        $this->assertInstanceOf(RouteCollector::class, $instance);
    }
}

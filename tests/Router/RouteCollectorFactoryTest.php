<?php

namespace JohncmsTests\System\Router;

use FastRoute\RouteCollector;
use Johncms\System\Router\RouteCollectorFactory;
use Johncms\System\Users\User;
use PHPUnit\Framework\TestCase;
use Zend\ServiceManager\ServiceManager;

class RouteCollectorFactoryTest extends TestCase
{
    public function testFactoryReturnsRouteCollectorInstance(): void
    {
        $container = new ServiceManager();
        $container->setService(User::class, $this->prophesize(User::class)->reveal());
        $instance = (new RouteCollectorFactory())($container);
        $this->assertInstanceOf(RouteCollector::class, $instance);
    }
}

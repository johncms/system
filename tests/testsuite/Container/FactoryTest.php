<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Test\Suite\Container;

use Johncms\System\Container\Factory;
use PHPUnit\Framework\TestCase;
use Laminas\ServiceManager\ServiceManager;
use Psr\Container\ContainerInterface;

class FactoryTest extends TestCase
{
    public function testGetContainer(): void
    {
        $container = Factory::getContainer();
        $this->assertInstanceOf(ServiceManager::class, $container);
        $this->assertInstanceOf(ContainerInterface::class, $container);
    }
}

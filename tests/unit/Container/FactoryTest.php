<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Tests\Unit\Container;

use Codeception\Test\Unit;
use Johncms\System\Container\Factory;
use Zend\ServiceManager\ServiceManager;

class FactoryTest extends Unit
{
    public function testGetContainer(): void
    {
        $container = Factory::getContainer();
        $this->assertInstanceOf(ServiceManager::class, $container);
    }
}

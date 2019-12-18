<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Tests\Unit\Config;

use Codeception\Test\Unit;
use Johncms\System\Config\Config;
use Johncms\System\Config\ConfigFactory;
use Zend\ServiceManager\ServiceManager;

class ConfigFactoryTest extends Unit
{
    public function testReturnsConfigInstance(): void
    {
        /** @var ServiceManager $container */
        $container = new ServiceManager();
        $container->setService('config', ['johncms' => []]);
        $instance = (new ConfigFactory())($container);
        $this->assertInstanceOf(Config::class, $instance);
    }
}

<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace JohncmsTests\System\Config;

use Johncms\System\Config\Config;
use Johncms\System\Config\ConfigFactory;
use PHPUnit\Framework\TestCase;
use Zend\ServiceManager\ServiceManager;

class ConfigFactoryTest extends TestCase
{
    public function testFactoryReturnsConfigInstance(): void
    {
        /** @var ServiceManager $container */
        $container = new ServiceManager();
        $container->setService('config', ['johncms' => []]);
        $instance = (new ConfigFactory())($container);
        $this->assertInstanceOf(Config::class, $instance);
    }
}

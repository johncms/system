<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace JohncmsTests\System;

use Johncms\System\ConfigProvider;
use PHPUnit\Framework\TestCase;

class ConfigProviderTest extends TestCase
{
    public function testConfigProviderReturnsArray(): void
    {
        $config = (new ConfigProvider())();
        $this->assertIsArray($config);
        $this->assertArrayHasKey('dependencies', $config);
        $dependencies = $config['dependencies'];
        $this->assertArrayHasKey('factories', $dependencies);
    }
}

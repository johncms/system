<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Tests\Unit;

use Codeception\Test\Unit;
use Johncms\System\ConfigProvider;

class ConfigProviderTest extends Unit
{
    public function testReturnsArrayWithMandatoryKeys()
    {
        $config = (new ConfigProvider())();
        $this->assertIsArray($config);
        $this->assertArrayHasKey('dependencies', $config);
        $dependencies = $config['dependencies'];
        $this->assertArrayHasKey('factories', $dependencies);
    }
}

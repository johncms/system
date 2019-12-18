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
use Johncms\System\Container\Config;

class ConfigTest extends Unit
{
    public function testConfigReturnsArray(): void
    {
        $config = (new Config())();
        $this->assertIsArray($config);
    }
}

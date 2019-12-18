<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Tests\Unit\Http;

use Codeception\Test\Unit;
use Johncms\System\Http\ServerRequestFactory;
use Psr\Http\Message\ServerRequestInterface;
use Zend\ServiceManager\ServiceManager;

class ServerRequestFactoryTest extends Unit
{
    public function testFactoryReturnsServerRequestInstance(): void
    {
        $container = new ServiceManager();
        $instance = (new ServerRequestFactory())($container);
        $this->assertInstanceOf(ServerRequestInterface::class, $instance);
    }
}

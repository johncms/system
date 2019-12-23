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
use Johncms\System\Http\Request;
use Johncms\System\Http\RequestFactory;
use Psr\Http\Message\ServerRequestInterface;
use Zend\ServiceManager\ServiceManager;

class RequestFactoryTest extends Unit
{
    public function testFactoryReturnsServerRequestInstance(): void
    {
        $container = new ServiceManager();
        $instance = (new RequestFactory())($container);
        $this->assertInstanceOf(Request::class, $instance);
        $this->assertInstanceOf(ServerRequestInterface::class, $instance);
    }
}

<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Test\Suite\Http;

use Johncms\System\Http\Request;
use Johncms\System\Http\RequestFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\ServiceManager\ServiceManager;

class RequestFactoryTest extends TestCase
{
    public function testFactoryReturnsServerRequestInstance(): void
    {
        $container = new ServiceManager();
        $instance = (new RequestFactory())($container);
        $this->assertInstanceOf(Request::class, $instance);
        $this->assertInstanceOf(ServerRequestInterface::class, $instance);
    }
}

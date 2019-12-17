<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace JohncmsTests\System\Http;

use Johncms\System\Http\ServerRequestFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\ServiceManager\ServiceManager;

class ServerRequestFactoryTest extends TestCase
{
    public function testFactoryReturnsServerRequestInstance(): void
    {
        $container = new ServiceManager();
        $instance = (new ServerRequestFactory())($container);
        $this->assertInstanceOf(ServerRequestInterface::class, $instance);
    }
}

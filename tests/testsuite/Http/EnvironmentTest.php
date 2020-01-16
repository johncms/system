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

use Johncms\System\Http\Environment;
use Johncms\System\Http\Request;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class EnvironmentTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testCanCreateInstance(): Environment
    {
        $instance = (new Environment())($this->container());
        $this->assertInstanceOf(Environment::class, $instance);
        return $instance;
    }

    /**
     * @depends testCanCreateInstance
     * @param Environment $environment
     */
    public function testGetIp(Environment $environment): void
    {
        $this->assertSame(long2ip($environment->getIp()), '127.0.0.1');
    }

    /**
     * @depends testCanCreateInstance
     * @param Environment $environment
     */
    public function testGetIpViaProxy(Environment $environment): void
    {
        $this->assertSame('92.63.107.114', long2ip($environment->getIpViaProxy()));
        $environment->getIpViaProxy(); // Check that it is not re-parse
    }

    public function testGetIpViaProxyIgnorePrivateNetwork(): void
    {
        $environment = (new Environment())($this->container('127.0.0.1', '192.168.0.1'));
        $this->assertSame($environment->getIpViaProxy(), 0);
    }

    /**
     * @depends testCanCreateInstance
     * @param Environment $environment
     */
    public function testGetUserAgent(Environment $environment)
    {
        $this->assertSame('Test-Browser', $environment->getUserAgent());
        $environment->getUserAgent(); // Check that it is not re-parse
    }

    public function testUnrecognizedUserAgent(): void
    {
        $environment = (new Environment())($this->container('127.0.0.1', null, null));
        $this->assertSame($environment->getUserAgent(), 'Not Recognised');
    }

    /**
     * @depends testCanCreateInstance
     * @param Environment $environment
     */
    public function testGetIpLog(Environment $environment)
    {
        $log = $environment->getIpLog();
        $this->assertIsArray($log);
    }

    public function testGetIpLogIgnoreOldRequests()
    {
        $example = DATA_PATH . 'ip-requests-list.dat';
        $file = CACHE_PATH . 'ip-requests-list.cache';

        if (file_exists($file)) {
            unlink($file);
        }

        copy($example, $file);
        (new Environment())($this->container());
        $this->assertFileExists($file);
    }

    public function testCanCreateIpRequestsCacheFile(): void
    {
        $file = CACHE_PATH . 'ip-requests-list.cache';

        if (file_exists($file)) {
            unlink($file);
        }

        (new Environment())($this->container());
        $this->assertFileExists($file);
    }

    ////////////////////////////////////////////////////////////////////////////////
    // Auxiliary methods                                                          //
    ////////////////////////////////////////////////////////////////////////////////

    private function container(
        string $ip = '127.0.0.1',
        ?string $ipViaProxy = '92.63.107.114',
        ?string $userAgent = 'Test-Browser'
    ): ContainerInterface {
        $request = Mockery::mock(Request::class);
        $request
            ->allows()
            ->getServer('REMOTE_ADDR', 0, FILTER_VALIDATE_IP)
            ->andReturn($ip);
        $request
            ->allows()
            ->getServer('HTTP_X_FORWARDED_FOR', '', FILTER_SANITIZE_STRING)
            ->andReturn($ipViaProxy ?? '');
        $request
            ->allows()
            ->getServer('HTTP_USER_AGENT', 'Not Recognised', FILTER_SANITIZE_SPECIAL_CHARS)
            ->andReturn($userAgent ?? 'Not Recognised');

        $container = Mockery::mock(ContainerInterface::class);
        $container->allows()->has(Request::class)->andReturn(true);
        $container->allows()->get(Request::class)->andReturn($request);
        return $container;
    }
}

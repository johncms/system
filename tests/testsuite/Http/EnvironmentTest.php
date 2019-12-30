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

use GuzzleHttp\Psr7\Uri;
use Johncms\System\Http\Environment;
use Johncms\System\Http\Request;
use PHPUnit\Framework\TestCase;
use Zend\ServiceManager\ServiceManager;

class EnvironmentTest extends TestCase
{
    private $request;

    public function setUp(): void
    {
        $this->request = new Request(
            'GET',
            new Uri(''),
            [],
            null,
            '1.1',
            [
                'REMOTE_ADDR'          => '127.0.0.1',
                'HTTP_X_FORWARDED_FOR' => '92.63.107.114',
                'HTTP_USER_AGENT'      => 'Test-Browser',
            ]
        );
    }

    public function testCanCreateInstance(): Environment
    {
        $container = new ServiceManager();
        $container->setService(Request::class, $this->request);
        $instance = (new Environment())($container);
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
        $request = new Request(
            'GET',
            new Uri(''),
            [],
            null,
            '1.1',
            [
                'REMOTE_ADDR'          => '127.0.0.1',
                'HTTP_X_FORWARDED_FOR' => '192.168.0.1',
            ]
        );
        $container = new ServiceManager();
        $container->setService(Request::class, $request);
        $environment = (new Environment())($container);
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
        $request = new Request('GET', new Uri(''), [], null, '1.1', ['REMOTE_ADDR' => '127.0.0.1']);
        $container = new ServiceManager();
        $container->setService(Request::class, $request);
        $environment = (new Environment())($container);
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
        $request = new Request('GET', new Uri(''), [], null, '1.1', ['REMOTE_ADDR' => '127.0.0.1']);
        $container = new ServiceManager();
        $container->setService(Request::class, $request);
        (new Environment())($container);
        $this->assertFileExists($file);
    }

    public function testCanCreateIpRequestsCacheFile(): void
    {
        $file = CACHE_PATH . 'ip-requests-list.cache';

        if (file_exists($file)) {
            unlink($file);
        }

        $request = new Request('GET', new Uri(''), [], null, '1.1', ['REMOTE_ADDR' => '127.0.0.1']);
        $container = new ServiceManager();
        $container->setService(Request::class, $request);
        (new Environment())($container);
        $this->assertFileExists($file);
    }
}

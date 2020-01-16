<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Test\Suite\View\Extension;

use InvalidArgumentException;
use Johncms\System\View\Extension\Assets;
use Mobicms\Render\Engine;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class AssetsTest extends TestCase
{
    /** @var Assets */
    private $assets;

    protected function setUp(): void
    {
        $container = Mockery::mock(ContainerInterface::class);
        $container
            ->allows()
            ->get('config')
            ->andReturn(['johncms' => ['skindef' => 'test', 'homeurl' => 'http://localhost']]);
        $this->assets = (new Assets())($container);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testCanCreateInstance()
    {
        $this->assertInstanceOf(Assets::class, $this->assets);
    }

    public function testRegister()
    {
        $engine = new Engine();
        $this->assets->register($engine);
        $this->assertTrue($engine->doesFunctionExist('asset'));
    }

    public function testUrlReturnsLinkToAnExistingFile()
    {
        $result = $this->assets->url('test-asset.txt');
        $this->assertStringContainsString('test/assets/test-asset.txt', $result);
    }

    public function testUrlReturnsLinkToAnExistingFileWithValidTimestamp()
    {
        $result = $this->assets->url('test-asset.txt', true);
        $timestamp = filemtime(THEMES_PATH . 'test/assets/test-asset.txt');
        $this->assertStringContainsString('test/assets/test-asset.txt?v=' . $timestamp, $result);
    }

    public function testUrlThrowAnExceptionWhenFileDoesNotExist()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->assets->url('does-not-exist.txt');
    }

    public function testUrlFromPath()
    {
        $result = $this->assets->urlFromPath(THEMES_PATH . 'test', ROOT_PATH, 'http://localhost');
        $this->assertSame('http://localhost/themes/test', $result);
    }
}

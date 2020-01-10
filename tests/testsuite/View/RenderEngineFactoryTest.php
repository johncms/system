<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Test\Suite\View;

use Johncms\System\Users\User;
use Johncms\System\Legacy\Tools;
use Johncms\System\View\Extension\Assets;
use Johncms\System\View\Extension\Avatar;
use Johncms\System\View\Render;
use Johncms\System\View\RenderEngineFactory;
use Mockery;
use PHPUnit\Framework\TestCase;
use Johncms\System\i18n\Translator;
use Psr\Container\ContainerInterface;

class RenderEngineFactoryTest extends TestCase
{
    /** @var Render */
    private $render;

    public function setUp(): void
    {
        $translator = Mockery::mock(Translator::class);
        $translator
            ->allows()
            ->getLocale()
            ->andReturn('en');

        $container = Mockery::mock(ContainerInterface::class);
        $container
            ->allows()
            ->get('config')
            ->andReturn(['johncms' => ['skindef' => 'default']]);
        $container
            ->allows()
            ->get(Translator::class)
            ->andReturn($translator);
        $container
            ->allows()
            ->get(Tools::class)
            ->andReturn(Mockery::mock(Tools::class));
        $container
            ->allows()
            ->get(User::class)
            ->andReturn(Mockery::mock(User::class));
        $container
            ->allows()
            ->get(Assets::class)
            ->andReturn((new Assets())($container));
        $container
            ->allows()
            ->get(Avatar::class)
            ->andReturn((new Avatar())($container));

        $this->render = (new RenderEngineFactory())($container);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testTemplatesHasPredefinedData(): void
    {
        $data = $this->render->getData();
        $this->assertInstanceOf(ContainerInterface::class, $data['container']);
        $this->assertArrayHasKey('skindef', $data['config']);
        $this->assertSame('en', $data['locale']);
        $this->assertInstanceOf(Tools::class, $data['tools']);
        $this->assertInstanceOf(User::class, $data['user']);
    }

    public function testTemplatesHasPredefinedHelpers(): void
    {
        $this->assertTrue($this->render->doesFunctionExist('asset'));
        $this->assertTrue($this->render->doesFunctionExist('avatar'));
    }
}

<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Tests\Unit\View;

use Codeception\Test\Unit;
use Johncms\System\Config\Config;
use Johncms\System\Users\User;
use Johncms\System\Utility\Tools;
use Johncms\System\View\Extension\Assets;
use Johncms\System\View\Render;
use Johncms\System\View\RenderEngineFactory;
use Zend\I18n\Translator\Translator;
use Zend\ServiceManager\ServiceManager;

class RenderEngineFactoryTest extends Unit
{
    public function testFactoryReturnsRenderInstance(): Render
    {
        $translator = $this->prophesize(Translator::class);
        $translator->getLocale()->willReturn('en');

        $container = new ServiceManager();
        $container->setService(Config::class, new Config(['skindef' => 'default'], Config::ARRAY_AS_PROPS));
        $container->setService(Translator::class, $translator->reveal());
        $container->setService(Tools::class, $this->prophesize(Tools::class)->reveal());
        $container->setService(User::class, $this->prophesize(User::class)->reveal());
        $container->setService(Assets::class, (new Assets())($container));

        $instance = (new RenderEngineFactory())($container);
        $this->assertInstanceOf(Render::class, $instance);
        return $instance;
    }

    /**
     * @depends testFactoryReturnsRenderInstance
     * @param Render $engine
     */
    public function testTemplatesHasPredefinedData(Render $engine): void
    {
        $data = $engine->getData();
        $this->assertInstanceOf(ServiceManager::class, $data['container']);
        $this->assertInstanceOf(Config::class, $data['config']);
        $this->assertSame('en', $data['locale']);
        $this->assertInstanceOf(Tools::class, $data['tools']);
        $this->assertInstanceOf(User::class, $data['user']);
    }
}

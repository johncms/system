<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Tests\Unit\i18n;

use Codeception\Test\Unit;
use Johncms\System\i18n\TranslatorServiceFactory;
use Johncms\System\Users\User;
use Zend\I18n\Translator\LoaderPluginManager;
use Zend\I18n\Translator\Translator;
use Zend\ServiceManager\ServiceManager;

class TranslatorServiceFactoryTest extends Unit
{
    /** @var ServiceManager */
    private $container;

    public function setUp(): void
    {
        $container = new ServiceManager();
        $container->setService(
            'config',
            [
                'johncms' =>
                    [
                        'lng'      => 'en',
                        'lng_list' => ['en', 'ru', 'ge'],
                    ],
            ]
        );
        $config = serialize(['lng' => 'ru']);
        $container->setService(User::class, new User(['set_user' => $config]));
        $container->setService('TranslatorPluginManager', $this->prophesize(LoaderPluginManager::class)->reveal());
        $this->container = $container;
    }

    public function testFactoryReturnsTranslatorInstance(): void
    {
        $instance = (new TranslatorServiceFactory())($this->container);
        $this->assertInstanceOf(Translator::class, $instance);
    }
}

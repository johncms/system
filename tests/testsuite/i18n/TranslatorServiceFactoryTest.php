<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Test\Suite\i18n;

use Johncms\System\Http\Request;
use Johncms\System\i18n\TranslatorServiceFactory;
use Johncms\System\Users\User;
use PHPUnit\Framework\TestCase;
use Zend\I18n\Translator\Translator;
use Zend\ServiceManager\ServiceManager;

class TranslatorServiceFactoryTest extends TestCase
{
    public function setUp(): void
    {
        $_SESSION = [];
    }

    public function testFactoryReturnsTranslatorInstance(): void
    {
        $instance = (new TranslatorServiceFactory())($this->getContainer());
        $this->assertInstanceOf(Translator::class, $instance);
    }

    public function testDefaultLocaleIsEn(): void
    {
        /** @var Translator $instance */
        $instance = (new TranslatorServiceFactory())($this->getContainer());
        $this->assertSame('en', $instance->getLocale());
    }

    public function testCanSetLocaleViaPost(): void
    {
        /** @var Translator $instance */
        $instance = (new TranslatorServiceFactory())($this->getContainer(['post' => 'ru']));
        $this->assertSame('ru', $instance->getLocale());
    }

    public function testCanSetLocaleViaSession(): void
    {
        $_SESSION['lng'] = 'ru';

        /** @var Translator $instance */
        $instance = (new TranslatorServiceFactory())($this->getContainer());
        $this->assertSame('ru', $instance->getLocale());
    }

    public function testCanSetLocaleViaUserSettings(): void
    {
        /** @var Translator $instance */
        $instance = (new TranslatorServiceFactory())($this->getContainer(['user' => 'ge']));
        $this->assertSame('ge', $instance->getLocale());
    }

    public function testPostHasHigherPriorityThanSession(): void
    {
        $_SESSION['lng'] = 'ru';

        /** @var Translator $instance */
        $instance = (new TranslatorServiceFactory())($this->getContainer(['post' => 'ge']));
        $this->assertSame('ge', $instance->getLocale());
    }

    public function testSessionHasHigherPriorityThanUserSettings(): void
    {
        $_SESSION['lng'] = 'ge';

        /** @var Translator $instance */
        $instance = (new TranslatorServiceFactory())($this->getContainer(['user' => 'ru']));
        $this->assertSame('ge', $instance->getLocale());
    }

    ////////////////////////////////////////////////////////////////////////////////
    // Auxiliary methods                                                          //
    ////////////////////////////////////////////////////////////////////////////////

    private function getContainer($options = []): ServiceManager
    {
        $request = new Request('POST', '');

        if (isset($options['post'])) {
            $request = $request->withParsedBody(['setlng' => $options['post']]);
        }

        $container = new ServiceManager();
        $container->setService(Request::class, $request);

        $container->setService(
            'config',
            [
                'johncms' => [
                    'lng'      => 'en',
                    'lng_list' => [
                        'en' => 'English',
                        'ru' => 'Русский',
                        'ge' => 'ქართული',
                    ],
                ],
            ]
        );

        $container->setService(
            User::class,
            new User(['set_user' => isset($options['user']) ? serialize(['lng' => $options['user']]) : ''])
        );

        return $container;
    }
}

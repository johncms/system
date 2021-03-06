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
use Mockery;
use PHPUnit\Framework\TestCase;
use Johncms\System\i18n\Translator;
use Psr\Container\ContainerInterface;

class TranslatorServiceFactoryTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

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

    private function getContainer($options = []): ContainerInterface
    {
        $request = new Request('POST', '');

        if (isset($options['post'])) {
            $request = $request->withParsedBody(['setlng' => $options['post']]);
        }

        $container = Mockery::mock(ContainerInterface::class);
        $container
            ->allows()
            ->get(Request::class)
            ->andReturn($request);
        $container
            ->allows()
            ->get(User::class)
            ->andReturn(
                new User(['set_user' => isset($options['user']) ? serialize(['lng' => $options['user']]) : ''])
            );
        $container
            ->allows()
            ->get('config')
            ->andReturn(
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

        return $container;
    }
}

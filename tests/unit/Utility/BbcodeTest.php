<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Tests\Unit\Utility;

use Codeception\Test\Unit;
use Johncms\System\Users\User;
use Johncms\System\Utility\Bbcode;
use Johncms\System\View\Extension\Assets;
use Zend\ServiceManager\ServiceManager;

class BbcodeTest extends Unit
{
    private $bbcode;

    protected function setUp(): void
    {
        $container = new ServiceManager();
        $container->setService(
            'config',
            [
                'bbcode'  => [
                    'b' => [
                        'from' => '#\[b](.+?)\[/b]#is',
                        'to'   => '<b>$1</b>',
                        'data' => '$1',
                    ],
                ],
                'johncms' => [
                    'homeurl'   => 'http://localhost',
                    'skindef'   => 'default',
                    'timeshift' => 1,
                ],
            ]
        );
        $container->setService(Assets::class, (new Assets())($container));
        $container->setService(User::class, new User());
        //$container->setService(User::class, new User(['smileys' => 'a:1:{i:0;s:3:"adm";}']));
        //$container->setService(Tools::class, (new Tools())($container));
        $this->bbcode = (new Bbcode())($container);
    }

    public function testCanCreateInstance()
    {
        $this->assertInstanceOf(Bbcode::class, $this->bbcode);
    }

    public function testCanParseSimplyTag()
    {
        $string = 'Lorem ipsum [b]dolor[/b] sit amet';
        $result = $this->bbcode->tags($string);
        $this->assertSame('Lorem ipsum <b>dolor</b> sit amet', $result);
    }

    public function testCanParseTimeTags()
    {
        $string = 'Time is [time]2019-12-15 03:14:07[/time].';
        $result = $this->bbcode->tags($string);
        $this->assertSame('Time is 15.12.2019 / 04:14.', $result);
    }

    public function testParseInvalidTimeTags()
    {
        $string = 'Time is [time]invalid[/time].';
        $result = $this->bbcode->tags($string);
        $this->assertSame('Time is invalid.', $result);
    }

    public function testCanParseTimestampTags()
    {
        $string = '[timestamp]2019-12-15 03:14:07[/timestamp]';
        $result = $this->bbcode->tags($string);
        $this->assertSame('<small class="gray">Added: 15.12.2019 / 04:14</small>', $result);
    }

    public function testParseInvalidTimestampTags()
    {
        $string = '[timestamp]invalid[/timestamp]';
        $result = $this->bbcode->tags($string);
        $this->assertSame('invalid', $result);
    }

    public function testNotags()
    {
        $string = 'Lorem ipsum [b]dolor[/b] sit amet';
        $result = $this->bbcode->notags($string);
        $this->assertSame('Lorem ipsum dolor sit amet', $result);
    }

    public function testButtons()
    {
        $result = $this->bbcode->buttons('form', 'field');
        $this->assertStringContainsString('<a href="javascript:tag(\'[b]\', \'[/b]\')">', $result);
        $this->assertStringContainsString('<a href="javascript:tag(\'[i]\', \'[/i]\')">', $result);
        $this->assertStringContainsString('<a href="javascript:tag(\'[u]\', \'[/u]\')">', $result);
    }
}

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

use Johncms\System\View\Extension\Assets;
use Johncms\System\View\Extension\Avatar;
use Mobicms\Render\Engine;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class AvatarTest extends TestCase
{
    /** @var Avatar */
    private $avatar;

    protected function setUp(): void
    {
        $container = Mockery::mock(ContainerInterface::class);
        $container
            ->allows()
            ->get('config')
            ->andReturn(['johncms' => ['skindef' => 'test', 'homeurl' => 'http://localhost']]);
        $container
            ->allows()
            ->get(Assets::class)
            ->andReturn((new Assets())($container));
        $this->avatar = (new Avatar())($container);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testCanCreateInstance()
    {
        $this->assertInstanceOf(Avatar::class, $this->avatar);
    }

    public function testRegister()
    {
        $engine = new Engine();
        $this->avatar->register($engine);
        $this->assertTrue($engine->doesFunctionExist('avatar'));
    }

    public function testgetUserAvatarReturnsLinkToAnExistingAvatar()
    {
        $result = $this->avatar->getUserAvatar(1);
        $this->assertStringContainsString('users/avatar/1.png', $result);
    }

    public function testgetUserAvatarOnNonexistentAvatar()
    {
        $result = $this->avatar->getUserAvatar(3);
        $this->assertStringContainsString('assets/icons/user.svg', $result);
    }
}

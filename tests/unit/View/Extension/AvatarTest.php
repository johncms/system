<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Tests\Unit\View\Extension;

use Codeception\Test\Unit;
use Johncms\System\View\Extension\Assets;
use Johncms\System\View\Extension\Avatar;
use Mobicms\Render\Engine;
use Zend\ServiceManager\ServiceManager;

class AvatarTest extends Unit
{
    /** @var Avatar */
    private $avatar;

    protected function setUp(): void
    {
        $container = new ServiceManager();
        $container->setService('config', ['johncms' => ['skindef' => 'test', 'homeurl' => 'http://localhost']]);
        $container->setService(Assets::class, (new Assets())($container));
        $this->avatar = (new Avatar())($container);
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

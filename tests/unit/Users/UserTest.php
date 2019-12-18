<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Tests\Unit\Users;

use Codeception\Test\Unit;
use Johncms\System\Users\User;
use LogicException;

class UserTest extends Unit
{

    public function testCanCreateInstance()
    {
        $instance = new User([]);
        $this->assertInstanceOf(User::class, $instance);
    }

    public function testValidUser()
    {
        $instance = new User(['id' => 1, 'preg' => 1]);
        $this->assertTrue($instance->isValid());
    }

    public function testInvalidateUserWitnNoId()
    {
        $instance = new User(['id' => 0, 'preg' => 1]);
        $this->assertFalse($instance->isValid());
    }

    public function testInvalidateUserWitnNoPreg()
    {
        $instance = new User(['id' => 1, 'preg' => 0]);
        $this->assertFalse($instance->isValid());
    }

    public function testOffsetSet()
    {
        $this->expectException(LogicException::class);
        $instance = new User([]);
        $instance->id = 1;
    }

//    public function testGetAvatar()
//    {
//    }
}

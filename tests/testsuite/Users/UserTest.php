<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Test\Suite\Users;

use Johncms\System\Users\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testCanCreateInstance()
    {
        $instance = new User();
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
}

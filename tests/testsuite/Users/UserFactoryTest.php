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

use Johncms\System\Http\Environment;
use Johncms\System\Http\Request;
use Johncms\System\Users\User;
use Johncms\System\Users\UserFactory;
use Mockery;
use PDO;
use Psr\Container\ContainerInterface;
use Test\Support\DatabaseTestCase;

class UserFactoryTest extends DatabaseTestCase
{
    /** @var ContainerInterface */
    private $container;

    public function setUp(): void
    {
        $this->loadSqlDump(SQL_DUMPS . 'users.sql');
        $this->loadSqlDump(SQL_DUMPS . 'cms_ban_users.sql');
        $this->loadSqlDump(SQL_DUMPS . 'cms_users_iphistory.sql');

        $environment = Mockery::mock(Environment::class);
        $environment->allows()->getIp()->andReturn(0);
        $environment->allows()->getIpViaProxy()->andReturn(0);
        $environment->allows()->getUserAgent()->andReturn('Test-User-Agent');

        $this->container = Mockery::mock(ContainerInterface::class);
        $this->container->allows()->get(PDO::class)->andReturn(self::$pdo);
        $this->container->allows()->get(Environment::class)->andReturn($environment);
    }

    public function testFactoryReturnsUserInstanceWithUnauthenticatedUser(): void
    {
        $this->setFakeRequestCookieParams();
        $user = (new UserFactory())($this->container);
        $this->assertInstanceOf(User::class, $user);
        $this->assertFalse($user->isValid());
    }

    public function testValidCookieParamsWillAuthenticateUser(): void
    {
        $this->setFakeRequestCookieParams(1, 'admin');
        $user = (new UserFactory())($this->container);
        $this->assertTrue($user->isValid());
    }

    ////////////////////////////////////////////////////////////////////////////////
    // Auxiliary methods                                                          //
    ////////////////////////////////////////////////////////////////////////////////

    private function setFakeRequestCookieParams(int $id = 0, string $password = '')
    {
        $hash = $password !== '' ? md5($password) : '';
        $request = Mockery::mock(Request::class);
        $request->allows()->getCookie('cuid', 0, FILTER_SANITIZE_NUMBER_INT)->andReturn($id);
        $request->allows()->getCookie('cups', '', FILTER_SANITIZE_STRING)->andReturn($hash);
        $this->container->allows()->get(Request::class)->andReturn($request);
    }
}

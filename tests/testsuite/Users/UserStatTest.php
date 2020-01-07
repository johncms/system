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
use Johncms\System\Users\UserStat;
use Mockery;
use PDO;
use Psr\Container\ContainerInterface;
use Test\Support\DatabaseTestCase;

class UserStatTest extends DatabaseTestCase
{
    /** @var ContainerInterface */
    private $container;

    public function setUp(): void
    {
        if (! self::$pdo instanceof PDO) {
            $this->markTestSkipped('Need database to test.');
        }

        $this->loadSqlDump(SQL_DUMPS . 'users.sql');
        $this->loadSqlDump(SQL_DUMPS . 'sessions.sql');
        $this->container = Mockery::mock(ContainerInterface::class);
        $this->container
            ->allows()
            ->get(PDO::class)
            ->andReturn(self::$pdo);

        $environment = Mockery::mock(Environment::class);
        $environment
            ->allows()
            ->getIp()
            ->andReturn(ip2long('192.168.0.1'));
        $environment
            ->allows()
            ->getIpViaProxy()
            ->andReturn(ip2long('92.63.107.114'));
        $environment
            ->allows()
            ->getUserAgent()
            ->andReturn('Test-Browser');

        $this->container
            ->allows()
            ->get(Environment::class)
            ->andReturn($environment);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testCanWriteGuestStats(): void
    {
        $hash = md5(ip2long('192.168.0.1') . ip2long('92.63.107.114') . 'Test-Browser');
        $this->container
            ->allows()
            ->get(User::class)
            ->andReturn(new User());
        $_SERVER['REQUEST_URI'] = '';

        // Can create instance
        $this->assertInstanceOf(UserStat::class, new UserStat($this->container));

        // One record should appear in the session table
        $req = self::$pdo->query("SELECT * FROM `cms_sessions` WHERE `session_id` = '${hash}'");
        $this->assertEquals(1, $req->rowCount());
        $res = $req->fetch();

        // The record must contain the correct data
        $this->assertEquals($hash, $res['session_id']);
        $this->assertEquals('192.168.0.1', long2ip((int) $res['ip']));
        $this->assertEquals('92.63.107.114', long2ip((int) $res['ip_via_proxy']));
        $this->assertEquals('Test-Browser', $res['browser']);
        $this->assertEquals('/', $res['place']);

        // Can determine valid place and movings count
        $_GET['id'] = 3;
        $_GET['act'] = 'new';
        $_GET['type'] = 'section';
        $_SERVER['REQUEST_URI'] = 'forum';
        new UserStat($this->container);
        $req2 = self::$pdo->query("SELECT * FROM `cms_sessions` WHERE `session_id` = '${hash}'");
        $this->assertEquals(1, $req2->rowCount());
        $res2 = $req2->fetch();
        $this->assertEquals('/forum?act=new&type=section&id=3', $res2['place']);
        $this->assertEquals(2, $res2['movings']);
        $this->assertEquals(2, $res2['views']);

        self::$pdo->exec(
            "UPDATE `cms_sessions`
            SET `sestime` = '" . ($res2['sestime'] - 500) . "'
            WHERE `session_id` = '" . $res2['session_id'] . "'"
        );
        new UserStat($this->container);
        $req3 = self::$pdo->query("SELECT * FROM `cms_sessions` WHERE `session_id` = '${hash}'");
        $this->assertEquals(1, $req3->rowCount());
        $res3 = $req3->fetch();
        $this->assertEquals(1, $res3['movings']);
        $this->assertEquals(1, $res3['views']);
    }

    public function testCanWriteUserStats(): void
    {
        $this->container
            ->allows()
            ->get(User::class)
            ->andReturn(new User(['id' => 1, 'preg' => 1]));
        $_SERVER['REQUEST_URI'] = '';
        $_GET = [];

        // Can create instance
        $this->assertInstanceOf(UserStat::class, new UserStat($this->container));

        // The record must contain the correct data
        $req = self::$pdo->query('SELECT * FROM `users` WHERE `id` = 1');
        $this->assertEquals(1, $req->rowCount());
        $res = $req->fetch();
        $this->assertEquals('/', $res['place']);
        $this->assertEquals(1, $res['movings']);
        $this->assertTrue((int) $res['lastdate'] === time() || (int) $res['lastdate'] === (time() - 1));
    }

    public function testCanDetermineUserPlaceAndMovings(): void
    {
        $this->container
            ->allows()
            ->get(User::class)
            ->andReturn(new User(['id' => 1, 'preg' => 1, 'lastdate' => time(), 'movings' => 1]));
        $_SERVER['REQUEST_URI'] = '';
        $_GET = [];

        new UserStat($this->container);
        $req = self::$pdo->query('SELECT * FROM `users` WHERE `id` = 1');
        $res = $req->fetch();
        $this->assertEquals('/', $res['place']);
        $this->assertEquals(2, $res['movings']);

        $_SERVER['REQUEST_URI'] = 'forum';
        new UserStat($this->container);
        $req = self::$pdo->query('SELECT * FROM `users` WHERE `id` = 1');
        $res = $req->fetch();
        $this->assertEquals('/forum', $res['place']);
    }
}

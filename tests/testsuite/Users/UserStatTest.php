<?php

namespace Test\Suite\Users;

use GuzzleHttp\Psr7\Uri;
use Johncms\System\Http\Environment;
use Johncms\System\Http\Request;
use Johncms\System\Users\User;
use Johncms\System\Users\UserStat;
use PDO;
use Test\Support\DatabaseTestCase;
use Zend\ServiceManager\ServiceManager;

class UserStatTest extends DatabaseTestCase
{
    /** @var ServiceManager */
    private $container;

    public function setUp(): void
    {
        if (! self::$pdo instanceof PDO) {
            $this->markTestSkipped('Need database to test.');
        }

        $this->loadSqlDump(SQL_DUMPS . 'users.sql');
        $this->loadSqlDump(SQL_DUMPS . 'sessions.sql');
        $this->container = new ServiceManager();
        $this->container->setService(PDO::class, self::$pdo);

        $request = new Request(
            'GET',
            new Uri(''),
            [],
            null,
            '1.1',
            [
                'REMOTE_ADDR'          => '192.168.0.1',
                'HTTP_X_FORWARDED_FOR' => '92.63.107.114',
                'HTTP_USER_AGENT'      => 'Test-Browser',
            ]
        );

        $this->container->setService(Request::class, $request);
        $this->container->setService(Environment::class, (new Environment())($this->container));
        $this->container->setAllowOverride(true);
    }

    public function testCanWriteGuestStats(): void
    {
        $this->container->setService(User::class, new User());
        $_SERVER['REQUEST_URI'] = '';

        // Can create instance
        $this->assertInstanceOf(UserStat::class, new UserStat($this->container));

        // One record should appear in the session table
        $req = self::$pdo->query('SELECT * FROM `cms_sessions`');
        $this->assertEquals(1, $req->rowCount());
        $res = $req->fetch();

        // The record must contain the correct data
        $hash = md5(ip2long('192.168.0.1') . ip2long('92.63.107.114') . 'Test-Browser');
        $this->assertEquals($hash, $res['session_id']);
        $this->assertEquals('192.168.0.1', long2ip($res['ip']));
        $this->assertEquals('92.63.107.114', long2ip($res['ip_via_proxy']));
        $this->assertEquals('Test-Browser', $res['browser']);
        $this->assertEquals('/', $res['place']);

        // Can determine valid place and movings count
        $_GET['id'] = 3;
        $_GET['act'] = 'new';
        $_GET['type'] = 'section';
        $_SERVER['REQUEST_URI'] = 'forum';
        new UserStat($this->container);
        $req2 = self::$pdo->query('SELECT * FROM `cms_sessions`');
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
        $req3 = self::$pdo->query('SELECT * FROM `cms_sessions`');
        $this->assertEquals(1, $req3->rowCount());
        $res3 = $req3->fetch();
        $this->assertEquals(1, $res3['movings']);
        $this->assertEquals(1, $res3['views']);
    }

    public function testCanWriteUserStats(): void
    {
        $this->container->setService(User::class, new User(['id' => 1, 'preg' => 1]));
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
        $this->container->setService(
            User::class,
            new User(['id' => 1, 'preg' => 1, 'lastdate' => time(), 'movings' => 1])
        );
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

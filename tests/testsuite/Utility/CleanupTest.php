<?php

namespace Test\Suite\Utility;

use Johncms\System\Utility\Cleanup;
use PDO;
use Test\Support\DatabaseTestCase;

class CleanupTest extends DatabaseTestCase
{
    public function setUp(): void
    {
        if (! self::$pdo instanceof PDO) {
            $this->markTestSkipped('Need database to test.');
        }

        $this->loadSqlDump(SQL_DUMPS . 'sessions.sql');
        $this->loadSqlDump(SQL_DUMPS . 'cms_users_iphistory.sql');
    }

    public function testCanCreateInstance(): void
    {
        $instance = new Cleanup(self::$pdo);
        $this->assertInstanceOf(Cleanup::class, $instance);
    }

    public function testKeepFreshData(): void
    {
        $stmt = self::$pdo->prepare('INSERT INTO `cms_sessions` SET `session_id` = ?, `lastdate` = ?');
        $stmt->execute([md5('id'), time()]);
        $stmt = self::$pdo->prepare('INSERT INTO `cms_users_iphistory` SET `user_id` = 1, `time` = ?');
        $stmt->execute([time()]);

        new Cleanup(self::$pdo);
        $this->assertEquals(1, $this->getRowCount('cms_sessions'));
        $this->assertEquals(1, $this->getRowCount('cms_users_iphistory'));
    }

    public function testDeleteOldData(): void
    {
        $stmt = self::$pdo->prepare('INSERT INTO `cms_sessions` SET `session_id` = ?, `lastdate` = ?');
        $stmt->execute([md5('id'), (time() - 86401)]);

        new Cleanup(self::$pdo);
        $this->assertEquals(0, $this->getRowCount('cms_sessions'));
        $this->assertEquals(0, $this->getRowCount('cms_users_iphistory'));
    }
}

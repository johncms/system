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

use Johncms\System\Users\UserClean;
use Test\Support\DatabaseTestCase;

class UserCleanTest extends DatabaseTestCase
{
    public function setUp(): void
    {
        if(null === self::$pdo){
            $this->markTestSkipped('Need a database for testing');
        }
    }

    /**
     * Testing the __construct() method
     *
     * @return UserClean
     */
    public function testCanCreateInstance(): UserClean
    {
        $instance = new UserClean(self::$pdo);
        $this->assertInstanceOf(UserClean::class, $instance);
        return $instance;
    }

    /**
     * Testing the removeUser() method
     *
     * @depends testCanCreateInstance
     * @param UserClean $instance
     */
    public function testCanDeleteSpecifiedUserAndHisIpAndBanHistory(UserClean $instance): void
    {
        $this->loadSqlDump(SQL_DUMPS . 'users.sql');
        $this->loadSqlDump(SQL_DUMPS . 'cms_ban_users.sql');
        $this->loadSqlDump(SQL_DUMPS . 'cms_users_iphistory.sql');

        $this->assertEquals(1, $this->getRowCount('users'));
        $this->assertEquals(1, $this->getRowCount('cms_ban_users'));
        $this->assertEquals(1, $this->getRowCount('cms_users_iphistory'));

        $instance->removeUser(1);

        $this->assertEquals(0, $this->getRowCount('users'));
        $this->assertEquals(0, $this->getRowCount('cms_ban_users'));
        $this->assertEquals(0, $this->getRowCount('cms_users_iphistory'));
    }

    /**
     * Testing the removeAlbum() method
     *
     * @depends testCanCreateInstance
     * @param UserClean $instance
     */
    public function testCanDeleteUserAlbums(UserClean $instance): void
    {
        $this->loadSqlDump(SQL_DUMPS . 'albums.sql');
        mkdir(UPLOAD_PATH . 'users/album/1', 0777, true);
        file_put_contents(UPLOAD_PATH . 'users/album/1/123.jpg', '');

        $this->assertEquals(1, $this->getRowCount('cms_album_cat'));
        $this->assertEquals(1, $this->getRowCount('cms_album_comments'));
        $this->assertEquals(1, $this->getRowCount('cms_album_downloads'));
        $this->assertEquals(1, $this->getRowCount('cms_album_files'));
        $this->assertEquals(1, $this->getRowCount('cms_album_views'));
        $this->assertEquals(1, $this->getRowCount('cms_album_votes'));
        $this->assertDirectoryExists(UPLOAD_PATH . 'users/album/1');
        $this->assertFileExists(UPLOAD_PATH . 'users/album/1/123.jpg');

        $instance->removeAlbum(1);

        $this->assertEquals(0, $this->getRowCount('cms_album_cat'));
        $this->assertEquals(0, $this->getRowCount('cms_album_comments'));
        $this->assertEquals(0, $this->getRowCount('cms_album_downloads'));
        $this->assertEquals(0, $this->getRowCount('cms_album_files'));
        $this->assertEquals(0, $this->getRowCount('cms_album_views'));
        $this->assertEquals(0, $this->getRowCount('cms_album_votes'));
        $this->assertDirectoryNotExists(UPLOAD_PATH . 'users/album/1');
    }

    /**
     * Testing the removeMail() method
     *
     * @depends testCanCreateInstance
     * @param UserClean $instance
     */
    public function testCanDeleteUserMailAttachmentsAndContacts(UserClean $instance): void
    {
        $this->loadSqlDump(SQL_DUMPS . 'mail_and_contacts.sql');
        file_put_contents(UPLOAD_PATH . 'mail/user.txt', 'user-data');
        file_put_contents(UPLOAD_PATH . 'mail/from.txt', 'from-data');


        $this->assertEquals(2, $this->getRowCount('cms_contact'));
        $this->assertEquals(2, $this->getRowCount('cms_mail'));
        $this->assertFileExists(UPLOAD_PATH . 'mail/user.txt');
        $this->assertFileExists(UPLOAD_PATH . 'mail/from.txt');

        $instance->removeMail(1);

        $this->assertEquals(0, $this->getRowCount('cms_contact'));
        $this->assertEquals(0, $this->getRowCount('cms_mail'));
        $this->assertFileNotExists(UPLOAD_PATH . 'mail/user.txt');
        $this->assertFileNotExists(UPLOAD_PATH . 'mail/from.txt');
    }

    /**
     * Testing the removeKarma() method
     *
     * @depends testCanCreateInstance
     * @param UserClean $instance
     */
    public function testRemoveKarma(UserClean $instance): void
    {
        $this->loadSqlDump(SQL_DUMPS . 'karma_users.sql');

        $this->assertEquals(1, $this->getRowCount('karma_users'));

        $instance->removeKarma(1);

        $this->assertEquals(0, $this->getRowCount('karma_users'));
    }

    /**
     * Testing the cleanForum() method
     *
     * @depends testCanCreateInstance
     * @param UserClean $instance
     */
    public function testCleanForum(UserClean $instance): void
    {
        $this->loadSqlDump(SQL_DUMPS . 'forum.sql');

        $this->assertEquals(1, $this->getRowCount('forum_topic'));
        $this->assertEquals(1, $this->getRowCount('forum_messages'));
        $this->assertEquals(1, $this->getRowCount('cms_forum_rdm'));

        $instance->cleanForum(1);

        // Only the reading label should be deleted
        $this->assertEquals(1, $this->getRowCount('forum_topic'));
        $this->assertEquals(1, $this->getRowCount('forum_messages'));
        $this->assertEquals(0, $this->getRowCount('cms_forum_rdm'));

        // Whether the deletion flag for the topic
        $result = self::$pdo->query('SELECT * FROM `forum_topic` WHERE `user_id` = 1')->fetch();
        $this->assertEquals(1, $result['deleted']);

        // Whether the deletion flag for the message
        $result = self::$pdo->query('SELECT * FROM `forum_messages` WHERE `user_id` = 1')->fetch();
        $this->assertEquals(1, $result['deleted']);
    }

    /**
     * Testing the removeGuestbook() method
     *
     * @depends testCanCreateInstance
     * @param UserClean $instance
     */
    public function testRemoveGuestbook(UserClean $instance)
    {
        $this->loadSqlDump(SQL_DUMPS . 'cms_users_guestbook.sql');

        $this->assertEquals(1, $this->getRowCount('cms_users_guestbook'));

        $instance->removeGuestbook(1);

        $this->assertEquals(0, $this->getRowCount('cms_users_guestbook'));
    }

    /**
     * Testing the cleanComments() method
     *
     * @depends testCanCreateInstance
     * @param UserClean $instance
     */
    public function testCleanComments(UserClean $instance)
    {
        $this->loadSqlDump(SQL_DUMPS . 'albums.sql');
        $this->loadSqlDump(SQL_DUMPS . 'cms_library_comments.sql');
        $this->loadSqlDump(SQL_DUMPS . 'cms_users_guestbook.sql');
        $this->loadSqlDump(SQL_DUMPS . 'download__comments.sql');
        $this->loadSqlDump(SQL_DUMPS . 'guest.sql');

        $this->assertEquals(1, $this->getRowCount('cms_album_comments'));
        $this->assertEquals(1, $this->getRowCount('cms_library_comments'));
        $this->assertEquals(1, $this->getRowCount('cms_users_guestbook'));
        $this->assertEquals(1, $this->getRowCount('download__comments'));
        $this->assertEquals(1, $this->getRowCount('guest'));

        $instance->cleanComments(1);

        $this->assertEquals(0, $this->getRowCount('cms_album_comments'));
        $this->assertEquals(0, $this->getRowCount('cms_library_comments'));
        $this->assertEquals(0, $this->getRowCount('cms_users_guestbook'));
        $this->assertEquals(0, $this->getRowCount('download__comments'));
        $this->assertEquals(0, $this->getRowCount('guest'));
    }
}

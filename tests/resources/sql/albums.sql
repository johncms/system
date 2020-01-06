DROP TABLE IF EXISTS `cms_album_cat`;
CREATE TABLE `cms_album_cat`
(
    `id`          INT(10) UNSIGNED    NOT NULL AUTO_INCREMENT,
    `user_id`     INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `sort`        INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `name`        VARCHAR(40)         NOT NULL DEFAULT '',
    `description` TEXT                NOT NULL,
    `password`    VARCHAR(20)         NOT NULL DEFAULT '',
    `access`      TINYINT(4) UNSIGNED NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `access` (`access`)
)
    ENGINE = MyISAM
    DEFAULT CHARSET = utf8mb4;

DROP TABLE IF EXISTS `cms_album_comments`;
CREATE TABLE `cms_album_comments`
(
    `id`         INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `sub_id`     INT(10) UNSIGNED NOT NULL DEFAULT '0',
    `time`       INT(10) UNSIGNED NOT NULL DEFAULT '0',
    `user_id`    INT(10) UNSIGNED NOT NULL DEFAULT '0',
    `text`       TEXT             NOT NULL,
    `reply`      TEXT             NOT NULL,
    `attributes` TEXT             NOT NULL,
    PRIMARY KEY (`id`),
    KEY `sub_id` (`sub_id`),
    KEY `user_id` (`user_id`)
)
    ENGINE = MyISAM
    DEFAULT CHARSET = utf8mb4;

DROP TABLE IF EXISTS `cms_album_downloads`;
CREATE TABLE `cms_album_downloads`
(
    `user_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
    `file_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
    `time`    INT(10) UNSIGNED NOT NULL DEFAULT '0',
    PRIMARY KEY (`user_id`, `file_id`)
)
    ENGINE = MyISAM
    DEFAULT CHARSET = utf8mb4;

DROP TABLE IF EXISTS `cms_album_files`;
CREATE TABLE `cms_album_files`
(
    `id`              INT(10) UNSIGNED    NOT NULL AUTO_INCREMENT,
    `user_id`         INT(10) UNSIGNED    NOT NULL,
    `album_id`        INT(10) UNSIGNED    NOT NULL,
    `description`     TEXT                NOT NULL,
    `img_name`        VARCHAR(100)        NOT NULL DEFAULT '',
    `tmb_name`        VARCHAR(100)        NOT NULL DEFAULT '',
    `time`            INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `comments`        TINYINT(1)          NOT NULL DEFAULT '1',
    `comm_count`      INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `access`          TINYINT(4) UNSIGNED NOT NULL DEFAULT '0',
    `vote_plus`       INT(11)             NOT NULL DEFAULT '0',
    `vote_minus`      INT(11)             NOT NULL DEFAULT '0',
    `views`           INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `downloads`       INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `unread_comments` TINYINT(1)          NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `album_id` (`album_id`),
    KEY `access` (`access`)
)
    ENGINE = MyISAM
    DEFAULT CHARSET = utf8mb4;

DROP TABLE IF EXISTS `cms_album_views`;
CREATE TABLE `cms_album_views`
(
    `user_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
    `file_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
    `time`    INT(10) UNSIGNED NOT NULL DEFAULT '0',
    PRIMARY KEY (`user_id`, `file_id`)
)
    ENGINE = MyISAM
    DEFAULT CHARSET = utf8mb4;

DROP TABLE IF EXISTS `cms_album_votes`;
CREATE TABLE `cms_album_votes`
(
    `id`      INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
    `file_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
    `vote`    TINYINT(2)       NOT NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `file_id` (`file_id`)
)
    ENGINE = MyISAM
    DEFAULT CHARSET = utf8mb4;

INSERT INTO `cms_album_cat` (`user_id`, `description`)
VALUES (1, '');

INSERT INTO `cms_album_comments` (`sub_id`, `text`, `reply`, `attributes`)
VALUES (1, '', '', '');

INSERT INTO `cms_album_downloads` (`user_id`)
VALUES (1);

INSERT INTO `cms_album_files` (`user_id`, `album_id`, `description`)
VALUES (1, 1, '');

INSERT INTO `cms_album_views` (`user_id`)
VALUES (1);

INSERT INTO `cms_album_votes` (`user_id`, `vote`)
VALUES (1, 1);

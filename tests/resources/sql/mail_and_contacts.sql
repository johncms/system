DROP TABLE IF EXISTS `cms_contact`;
CREATE TABLE IF NOT EXISTS `cms_contact`
(
    `id`      INT(10) UNSIGNED    NOT NULL AUTO_INCREMENT,
    `user_id` INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `from_id` INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `time`    INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `type`    TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
    `friends` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
    `ban`     TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
    `man`     TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_user` (`user_id`, `from_id`),
    KEY `time` (`time`),
    KEY `ban` (`ban`)
)
    ENGINE = MyISAM
    DEFAULT CHARSET = utf8mb4;

DROP TABLE IF EXISTS `cms_mail`;
CREATE TABLE IF NOT EXISTS `cms_mail`
(
    `id`        INT(10) UNSIGNED    NOT NULL AUTO_INCREMENT,
    `user_id`   INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `from_id`   INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `text`      TEXT                NOT NULL,
    `time`      INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `read`      TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
    `sys`       TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
    `delete`    INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `file_name` VARCHAR(100)        NOT NULL DEFAULT '',
    `count`     INT(10)             NOT NULL DEFAULT '0',
    `size`      INT(10)             NOT NULL DEFAULT '0',
    `them`      VARCHAR(100)        NOT NULL DEFAULT '',
    `spam`      TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `from_id` (`from_id`),
    KEY `time` (`time`),
    KEY `read` (`read`),
    KEY `sys` (`sys`),
    KEY `delete` (`delete`)
)
    ENGINE = MyISAM
    DEFAULT CHARSET = utf8mb4;

INSERT INTO `cms_contact` (`user_id`)
VALUES (1);

INSERT INTO `cms_contact` (`from_id`)
VALUES (1);

INSERT INTO `cms_mail` (`user_id`, `text`, `file_name`)
VALUES (1, '', 'user.txt');

INSERT INTO `cms_mail` (`from_id`, `text`, `file_name`)
VALUES (1, '', 'from.txt');

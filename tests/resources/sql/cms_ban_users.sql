DROP TABLE IF EXISTS `cms_ban_users`;
CREATE TABLE `cms_ban_users`
(
    `id`         INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`    INT(11)          NOT NULL DEFAULT '0',
    `ban_time`   INT(11)          NOT NULL DEFAULT '0',
    `ban_while`  INT(11)          NOT NULL DEFAULT '0',
    `ban_type`   TINYINT(4)       NOT NULL DEFAULT '1',
    `ban_who`    VARCHAR(30)      NOT NULL DEFAULT '',
    `ban_ref`    INT(11)          NOT NULL DEFAULT '0',
    `ban_reason` TEXT             NOT NULL,
    `ban_raz`    VARCHAR(30)      NOT NULL DEFAULT '',
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `ban_time` (`ban_time`)
)
    ENGINE = MyISAM
    DEFAULT CHARSET = utf8mb4;

INSERT INTO `cms_ban_users` (`user_id`, `ban_reason`)
VALUES (1, '');

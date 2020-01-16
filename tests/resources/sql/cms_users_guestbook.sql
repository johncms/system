DROP TABLE IF EXISTS `cms_users_guestbook`;
CREATE TABLE `cms_users_guestbook`
(
    `id`         INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `sub_id`     INT(10) UNSIGNED NOT NULL,
    `time`       INT(11)          NOT NULL,
    `user_id`    INT(10) UNSIGNED NOT NULL,
    `text`       TEXT             NOT NULL,
    `reply`      TEXT             NOT NULL,
    `attributes` TEXT             NOT NULL,
    PRIMARY KEY (`id`),
    KEY `sub_id` (`sub_id`),
    KEY `user_id` (`user_id`)
)
    ENGINE = MyISAM
    DEFAULT CHARSET = utf8mb4;

INSERT INTO `cms_users_guestbook` (`sub_id`, `time`, `user_id`, `text`, `reply`, `attributes`)
VALUES (1, 0, 1, '', '', '');

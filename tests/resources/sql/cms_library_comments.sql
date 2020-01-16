DROP TABLE IF EXISTS `cms_library_comments`;
CREATE TABLE `cms_library_comments`
(
    `id`         INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `sub_id`     INT(11) UNSIGNED NOT NULL,
    `time`       INT(11)          NOT NULL,
    `user_id`    INT(11) UNSIGNED NOT NULL,
    `text`       TEXT             NOT NULL,
    `reply`      TEXT,
    `attributes` TEXT             NOT NULL,
    PRIMARY KEY (`id`),
    KEY `sub_id` (`sub_id`),
    KEY `user_id` (`user_id`)
)
    ENGINE = MyISAM
    DEFAULT CHARSET = utf8mb4;

INSERT INTO `cms_library_comments` (`sub_id`, `time`, `user_id`, `text`, `reply`, `attributes`)
VALUES (1, 0, 1, '', '', '');

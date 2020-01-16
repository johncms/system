DROP TABLE IF EXISTS `karma_users`;
CREATE TABLE `karma_users`
(
    `id`         INT(10) UNSIGNED    NOT NULL AUTO_INCREMENT,
    `user_id`    INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `name`       VARCHAR(50)         NOT NULL DEFAULT '',
    `karma_user` INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `points`     TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
    `type`       TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
    `time`       INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `text`       TEXT                NOT NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `karma_user` (`karma_user`),
    KEY `type` (`type`)
)
    ENGINE = MyISAM
    DEFAULT CHARSET = utf8mb4;

INSERT INTO `karma_users` (`karma_user`, `text`)
VALUES (1, '');

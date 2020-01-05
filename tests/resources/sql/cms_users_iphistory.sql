DROP TABLE IF EXISTS `cms_users_iphistory`;
CREATE TABLE `cms_users_iphistory`
(
    `id`           BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`      INT(10) UNSIGNED    NOT NULL,
    `ip`           BIGINT(11)          NOT NULL DEFAULT '0',
    `ip_via_proxy` BIGINT(11)          NOT NULL DEFAULT '0',
    `time`         INT(10) UNSIGNED    NOT NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `user_ip` (`ip`)
)
    ENGINE = MyISAM
    DEFAULT CHARSET = utf8mb4;

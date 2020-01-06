DROP TABLE IF EXISTS `cms_sessions`;
CREATE TABLE `cms_sessions`
(
    `session_id`   CHAR(32)             NOT NULL DEFAULT '',
    `ip`           BIGINT(11)           NOT NULL DEFAULT '0',
    `ip_via_proxy` BIGINT(11)           NOT NULL DEFAULT '0',
    `browser`      VARCHAR(255)         NOT NULL DEFAULT '',
    `lastdate`     INT(10) UNSIGNED     NOT NULL DEFAULT '0',
    `sestime`      INT(10) UNSIGNED     NOT NULL DEFAULT '0',
    `views`        INT(10) UNSIGNED     NOT NULL DEFAULT '0',
    `movings`      SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
    `place`        VARCHAR(100)         NOT NULL DEFAULT '',
    PRIMARY KEY (`session_id`),
    KEY `lastdate` (`lastdate`),
    KEY `place` (`place`(10))
)
    ENGINE = MyISAM
    DEFAULT CHARSET = utf8mb4;

INSERT INTO `cms_sessions` (`session_id`, `lastdate`)
VALUES ('foo', 0);

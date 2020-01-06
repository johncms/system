DROP TABLE IF EXISTS `guest`;
CREATE TABLE `guest`
(
    `id`         INT(10) UNSIGNED    NOT NULL AUTO_INCREMENT,
    `adm`        TINYINT(1)          NOT NULL DEFAULT '0',
    `time`       INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `user_id`    INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `name`       VARCHAR(25)         NOT NULL DEFAULT '',
    `text`       TEXT                NOT NULL,
    `ip`         BIGINT(11)          NOT NULL DEFAULT '0',
    `browser`    TINYTEXT            NOT NULL,
    `admin`      VARCHAR(25)         NOT NULL DEFAULT '',
    `otvet`      TEXT                NOT NULL,
    `otime`      INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `edit_who`   VARCHAR(25)         NOT NULL DEFAULT '',
    `edit_time`  INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `edit_count` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `time` (`time`),
    KEY `ip` (`ip`),
    KEY `adm` (`adm`)
)
    ENGINE = MyISAM
    DEFAULT CHARSET = utf8mb4;

INSERT INTO `guest` (`user_id`, `text`, `browser`, `otvet`)
VALUES (1, '', '', '');

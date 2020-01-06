DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
(
  `id`            INT(10) UNSIGNED    NOT NULL AUTO_INCREMENT,
  `name`          VARCHAR(25)         NOT NULL DEFAULT '',
  `name_lat`      VARCHAR(40)         NOT NULL DEFAULT '',
  `password`      VARCHAR(32)         NOT NULL DEFAULT '',
  `rights`        TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
  `failed_login`  TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
  `imname`        VARCHAR(100)        NOT NULL DEFAULT '',
  `sex`           VARCHAR(2)          NOT NULL DEFAULT '',
  `komm`          INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `postforum`     INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `postguest`     INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `yearofbirth`   INT(4)              NOT NULL DEFAULT '0',
  `datereg`       INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `lastdate`      INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `mail`          VARCHAR(50)         NOT NULL DEFAULT '',
  `icq`           INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `skype`         VARCHAR(50)         NOT NULL DEFAULT '',
  `jabber`        VARCHAR(50)         NOT NULL DEFAULT '',
  `www`           VARCHAR(50)         NOT NULL DEFAULT '',
  `about`         TEXT                NOT NULL,
  `live`          VARCHAR(100)        NOT NULL DEFAULT '',
  `mibile`        VARCHAR(50)         NOT NULL DEFAULT '',
  `status`        VARCHAR(100)        NOT NULL DEFAULT '',
  `ip`            BIGINT(11)          NOT NULL DEFAULT '0',
  `ip_via_proxy`  BIGINT(11)          NOT NULL DEFAULT '0',
  `browser`       TEXT                NOT NULL,
  `preg`          TINYINT(1)          NOT NULL DEFAULT '0',
  `regadm`        VARCHAR(25)         NOT NULL DEFAULT '',
  `mailvis`       TINYINT(1)          NOT NULL DEFAULT '0',
  `dayb`          INT(2)              NOT NULL DEFAULT '0',
  `monthb`        INT(2)              NOT NULL DEFAULT '0',
  `sestime`       INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `total_on_site` INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `lastpost`      INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `rest_code`     VARCHAR(32)         NOT NULL DEFAULT '',
  `rest_time`     INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `movings`       INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `place`         VARCHAR(100)        NOT NULL DEFAULT '',
  `set_user`      TEXT                NOT NULL,
  `set_forum`     TEXT                NOT NULL,
  `set_mail`      TEXT                NOT NULL,
  `karma_plus`    INT(11)             NOT NULL DEFAULT '0',
  `karma_minus`   INT(11)             NOT NULL DEFAULT '0',
  `karma_time`    INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `karma_off`     TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `comm_count`    INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `comm_old`      INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `smileys`       TEXT                NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name_lat` (`name_lat`),
  KEY `lastdate` (`lastdate`),
  KEY `place` (`place`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8mb4;

INSERT INTO `users` (`id`, `name`, `name_lat`, `password`, `rights`, `failed_login`, `imname`, `sex`, `komm`, `postforum`, `postguest`, `yearofbirth`, `datereg`, `lastdate`, `mail`, `icq`, `skype`, `jabber`, `www`, `about`, `live`, `mibile`, `status`, `ip`, `ip_via_proxy`, `browser`, `preg`, `regadm`, `mailvis`, `dayb`, `monthb`, `sestime`, `total_on_site`, `lastpost`, `rest_code`, `rest_time`, `movings`, `place`, `set_user`, `set_forum`, `set_mail`, `karma_plus`, `karma_minus`, `karma_time`, `karma_off`, `comm_count`, `comm_old`, `smileys`) VALUES
(1, 'admin', 'admin', 'c3284d0f94606de1fd2af172aba15bf3', 9, 1, '', 'm', 1, 5, 6, 1970, 1574099380, 1577742240, 'user@example.com', 0, '', '', 'http://johncms', '', '', '', '', 2130706433, 0, 'Default-User-Agent', 1, '', 0, 20, 11, 1577742029, 0, 1577364247, '', 0, 3, '/', 'a:8:{s:9:\"directUrl\";b:0;s:11:\"fieldHeight\";i:3;s:10:\"fieldWidth\";i:40;s:5:\"kmess\";i:20;s:3:\"lng\";s:2:\"ru\";s:4:\"skin\";s:7:\"default\";s:9:\"timeshift\";i:0;s:7:\"youtube\";b:1;}', '', '', 0, 0, 0, 0, 1, 1, 'a:1:{i:0;s:3:\"adm\";}');

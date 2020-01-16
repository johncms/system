DROP TABLE IF EXISTS `forum_topic`;
CREATE TABLE `forum_topic`
(
    `id`                        int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `section_id`                int(10) UNSIGNED NOT NULL,
    `name`                      varchar(255)     NOT NULL,
    `description`               mediumtext,
    `view_count`                bigint(20)   DEFAULT NULL,
    `user_id`                   bigint(20)       NOT NULL,
    `user_name`                 varchar(255) DEFAULT NULL,
    `created_at`                datetime     DEFAULT NULL,
    `post_count`                int(11)      DEFAULT NULL,
    `mod_post_count`            int(11)      DEFAULT NULL,
    `last_post_date`            int(11)      DEFAULT NULL,
    `last_post_author`          bigint(20)   DEFAULT NULL,
    `last_post_author_name`     varchar(255) DEFAULT NULL,
    `last_message_id`           bigint(20)   DEFAULT NULL,
    `mod_last_post_date`        int(11)      DEFAULT NULL,
    `mod_last_post_author`      bigint(20)   DEFAULT NULL,
    `mod_last_post_author_name` varchar(255) DEFAULT NULL,
    `mod_last_message_id`       bigint(20)   DEFAULT NULL,
    `closed`                    tinyint(1)   DEFAULT NULL,
    `closed_by`                 varchar(255) DEFAULT NULL,
    `deleted`                   tinyint(1)   DEFAULT NULL,
    `deleted_by`                varchar(255) DEFAULT NULL,
    `curators`                  mediumtext,
    `pinned`                    tinyint(1)   DEFAULT NULL,
    `has_poll`                  tinyint(1)   DEFAULT NULL,
    `old_id`                    int(11)      DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

DROP TABLE IF EXISTS `forum_messages`;
CREATE TABLE `forum_messages`
(
    `id`           int(10)    NOT NULL AUTO_INCREMENT,
    `topic_id`     bigint(20) NOT NULL,
    `text`         longtext   NOT NULL,
    `date`         int(11)      DEFAULT NULL,
    `user_id`      bigint(20) NOT NULL,
    `user_name`    varchar(255) DEFAULT NULL,
    `user_agent`   varchar(255) DEFAULT NULL,
    `ip`           bigint(20)   DEFAULT NULL,
    `ip_via_proxy` bigint(20)   DEFAULT NULL,
    `pinned`       tinyint(1)   DEFAULT NULL,
    `editor_name`  varchar(255) DEFAULT NULL,
    `edit_time`    int(11)      DEFAULT NULL,
    `edit_count`   int(11)      DEFAULT NULL,
    `deleted`      tinyint(1)   DEFAULT NULL,
    `deleted_by`   varchar(255) DEFAULT NULL,
    `old_id`       int(11)      DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

DROP TABLE IF EXISTS `cms_forum_rdm`;
CREATE TABLE `cms_forum_rdm`
(
    `topic_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
    `user_id`  INT(10) UNSIGNED NOT NULL DEFAULT '0',
    `time`     INT(10) UNSIGNED NOT NULL DEFAULT '0',
    PRIMARY KEY (`topic_id`, `user_id`),
    KEY `time` (`time`)
)
    ENGINE = MyISAM
    DEFAULT CHARSET = utf8mb4;

INSERT INTO `forum_topic` (`section_id`, `name`, `description`, `user_id`)
VALUES (2, '', '', 1);

INSERT INTO `forum_messages` (`topic_id`, `text`, `user_id`)
VALUES (2, '', 1);

INSERT INTO `cms_forum_rdm` (`topic_id`, `user_id`)
VALUES (2, 1);

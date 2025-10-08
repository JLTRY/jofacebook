SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `#__jofacebook_post` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `asset_id` INT(10) unsigned NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
    `category` INT(64) NULL DEFAULT 0,
    `description` TEXT NULL,
    `post` TEXT NULL,
    `profile` TEXT NULL,
    `params` TEXT NULL,
    `published` TINYINT(3) NULL DEFAULT 1,
    `created_by` INT unsigned NULL,
    `modified_by` INT unsigned,
    `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME,
    `checked_out` int unsigned,
    `checked_out_time` DATETIME,
    `version` INT(10) unsigned NULL DEFAULT 1,
    `hits` INT(10) unsigned NULL DEFAULT 0,
    `access` INT(10) unsigned NULL DEFAULT 0,
    `ordering` INT(11) NULL DEFAULT 0,
    PRIMARY KEY  (`id`),
    KEY `idx_category` (`category`),
    KEY `idx_access` (`access`),
    KEY `idx_checkout` (`checked_out`),
    KEY `idx_createdby` (`created_by`),
    KEY `idx_modifiedby` (`modified_by`),
    KEY `idx_state` (`published`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT IGNORE INTO `#__jofacebook_post` VALUES(1, '0', '0', 'Coucher de soleil', 'JLTRYCOACHING', '627790250371232', NULL, 1, 0, 0,
CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 0, CURRENT_TIMESTAMP, 1, 0, 0, 0);



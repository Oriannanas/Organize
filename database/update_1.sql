use organize;

ALTER TABLE `organize`.`logboek`
ADD COLUMN `rss_feed` VARCHAR(450) NULL DEFAULT NULL COMMENT '' AFTER `deletedOn`;

ALTER TABLE `organize`.`logboek`
CHANGE COLUMN `deletedOn` `deleted_on` DATETIME NULL DEFAULT NULL COMMENT '' ,
ADD COLUMN `date_from` DATETIME NOT NULL COMMENT '' AFTER `name`,
ADD COLUMN `date_to` DATETIME NOT NULL COMMENT '' AFTER `date_from`,
ADD COLUMN `interval` INT NULL COMMENT '' AFTER `date_to`,
ADD COLUMN `interval_type` ENUM('seconds', 'minutes', 'hours', 'days', 'weeks', 'months', 'years') NULL COMMENT '' AFTER `interval`;

ALTER TABLE `organize`.`logboek_entry`
CHANGE COLUMN `deletedOn` `deleted_on` DATETIME NULL DEFAULT NULL COMMENT '',
ADD COLUMN `date` DATETIME NOT NULL after `id`;

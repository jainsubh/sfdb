CREATE TABLE `sfca_schema`.`alerts` (
  `id` INT ZEROFILL NOT NULL AUTO_INCREMENT,
  `title` MEDIUMTEXT CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
  `description` LONGTEXT CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
  `links` MEDIUMTEXT CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
  `sentiment` ENUM('positive', 'negative', 'neutral') NULL DEFAULT NULL COMMENT 'Default will be null',
  `status` ENUM('0', '1', '2') NOT NULL DEFAULT '0' COMMENT '0 for active\n1 for archive\n2 for trash',
  `user_id` INT NOT NULL DEFAULT 0 COMMENT '0 for unassigned',
  `created_at` TIMESTAMP NOT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `status_UNIQUE` (`status` ASC) VISIBLE);
ALTER TABLE `trend` ADD INDEX(`volume`);
ALTER TABLE `tasks` ADD INDEX(`status`);
ALTER TABLE `tasks` ADD INDEX(`created_at`);
ALTER TABLE `institution_reports` ADD INDEX(`date_time`);
ALTER TABLE `alert_keywords` ADD INDEX(`keyword`);
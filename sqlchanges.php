ALTER TABLE users ADD slug VARCHAR(255) NULL DEFAULT NULL AFTER name;





ALTER TABLE `users` ADD `referral_code` VARCHAR(150) NULL DEFAULT NULL AFTER `is_deleted`;

ALTER TABLE `users` ADD `plan_id` BIGINT(20) NULL DEFAULT NULL AFTER `designation_id`, ADD `payout_period` INT(10) NULL DEFAULT NULL AFTER `plan_id`;

ALTER TABLE `plans` ADD `description` TEXT NULL DEFAULT NULL AFTER `name`;
ALTER TABLE `plans` ADD `term_conditions` TEXT NULL DEFAULT NULL AFTER `description`;




ALTER TABLE `banners` ADD `order_number` INT NULL DEFAULT NULL AFTER `width`;
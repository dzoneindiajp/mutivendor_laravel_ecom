ALTER TABLE users ADD slug VARCHAR(255) NULL DEFAULT NULL AFTER name;





ALTER TABLE `users` ADD `referral_code` VARCHAR(150) NULL DEFAULT NULL AFTER `is_deleted`;

ALTER TABLE `users` ADD `plan_id` BIGINT(20) NULL DEFAULT NULL AFTER `designation_id`, ADD `payout_period` INT(10) NULL DEFAULT NULL AFTER `plan_id`;

ALTER TABLE `plans` ADD `description` TEXT NULL DEFAULT NULL AFTER `name`;
ALTER TABLE `plans` ADD `term_conditions` TEXT NULL DEFAULT NULL AFTER `description`;






ALTER TABLE `products` CHANGE `bar_code` `bar_code` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `products` CHANGE `brand_id` `brand_id` BIGINT NULL DEFAULT NULL;
ALTER TABLE `product_shipping_specifications` CHANGE `height` `height` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `product_shipping_specifications` CHANGE `weight` `weight` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `product_shipping_specifications` CHANGE `width` `width` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `product_shipping_specifications` CHANGE `length` `length` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `product_shipping_specifications` CHANGE `dc` `dc` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `product_variant_combinations` CHANGE `height` `height` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `product_variant_combinations` CHANGE `weight` `weight` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `product_variant_combinations` CHANGE `width` `width` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `product_variant_combinations` CHANGE `length` `length` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `product_variant_combinations` CHANGE `dc` `dc` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `product_variant_combinations` CHANGE `bar_code` `bar_code` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
ALTER TABLE `product_variant_combinations` CHANGE `variant1_value_id` `variant1_value_id` BIGINT NULL DEFAULT NULL;

ALTER TABLE `banners` ADD `order_number` INT NULL DEFAULT NULL AFTER `width`;





ALTER TABLE `product_variant_combinations` ADD `is_main_product` SMALLINT NOT NULL DEFAULT '0' AFTER `product_number`;

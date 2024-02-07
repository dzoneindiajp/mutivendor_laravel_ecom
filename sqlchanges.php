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








2/2/2024 =>>>>>>>>

CREATE TABLE `mutivendor_laravel_ecom`.`cart` (`id` INT NOT NULL AUTO_INCREMENT , `product_id` BIGINT NOT NULL , `quantity` INT NOT NULL , `created_at` DATETIME NOT NULL , `updated_at` DATETIME NOT NULL , PRIMARY KEY (`id`), INDEX (`product_id`)) ENGINE = MyISAM;
ALTER TABLE `cart` ADD `user_id` BIGINT NOT NULL AFTER `id`;

CREATE TABLE `mutivendor_laravel_ecom`.`wishlist` (`id` INT NOT NULL AUTO_INCREMENT , `user_id` BIGINT NOT NULL , `product_id` BIGINT NOT NULL , `created_at` DATETIME NOT NULL , `updated_at` DATETIME NOT NULL , PRIMARY KEY (`id`), INDEX (`product_id`)) ENGINE = MyISAM;

CREATE TABLE `mutivendor_laravel_ecom`.`user_addresses` (`id` INT NOT NULL AUTO_INCREMENT , `user_id` BIGINT NOT NULL , `address_line_1` TEXT NOT NULL , `address_line_2` TEXT NULL DEFAULT NULL , `postal_code` VARCHAR(50) NULL DEFAULT NULL , `city` VARCHAR(50) NULL DEFAULT NULL , `state` VARCHAR(50) NULL DEFAULT NULL , `landmark` VARCHAR(50) NULL DEFAULT NULL , `created_at` DATETIME NOT NULL , `updated_at` DATETIME NOT NULL , PRIMARY KEY (`id`), INDEX (`user_id`)) ENGINE = MyISAM;

ALTER TABLE `user_addresses` ADD `is_primary` TINYINT NOT NULL DEFAULT '0' AFTER `landmark`;

ALTER TABLE `user_addresses` ADD `name` VARCHAR(50) NULL DEFAULT NULL AFTER `user_id`, ADD `email` VARCHAR(50) NULL DEFAULT NULL AFTER `name`, ADD `phone_number` VARCHAR(50) NULL DEFAULT NULL AFTER `email`, ADD `country` VARCHAR(50) NULL DEFAULT NULL AFTER `phone_number`;

ALTER TABLE `user_addresses` CHANGE `landmark` `landmark` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
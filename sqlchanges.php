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


9/2/2024 =>>>>>>>
CREATE TABLE `mutivendor_laravel_ecom`.`orders` (`id` INT NOT NULL , `order_number` VARCHAR(50) NOT NULL , `user_id` BIGINT NOT NULL , `address_id` BIGINT NOT NULL , `sub_total` FLOAT(11,2) NOT NULL , `total` FLOAT(11,2) NOT NULL , `coupon_name` VARCHAR(50) NULL DEFAULT NULL , `coupon_discount` FLOAT(11,2) NULL DEFAULT '0.00' , `delivery` FLOAT(11,2) NOT NULL DEFAULT '0.00' , `transaction_id` VARCHAR(255) NULL DEFAULT NULL , `created_at` DATETIME NOT NULL , `updated_at` DATETIME NOT NULL ) ENGINE = MyISAM;


CREATE TABLE `mutivendor_laravel_ecom`.`order_items` (`id` BIGINT NOT NULL AUTO_INCREMENT , `order_id` BIGINT NOT NULL , `product_id` BIGINT NOT NULL , `qty` SMALLINT NOT NULL , `sub_total` FLOAT(11,2) NOT NULL , `total` FLOAT(11,2) NOT NULL , `coupon_name` VARCHAR(50) NULL DEFAULT NULL , `coupon_discount` FLOAT(11,2) NOT NULL DEFAULT '0.00' , `delivery` FLOAT(11,2) NOT NULL DEFAULT '0.00' , `status` VARCHAR(50) NOT NULL COMMENT 'received,confirmed,shipped,delivered,cancelled,returned' , `created_at` DATETIME NOT NULL , `updated_at` DATETIME NOT NULL , PRIMARY KEY (`id`), INDEX (`order_id`), INDEX (`product_id`)) ENGINE = MyISAM;

ALTER TABLE `orders` CHANGE `id` `id` INT NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);
ALTER TABLE `orders` ADD INDEX(`order_number`);
ALTER TABLE `orders` ADD INDEX(`user_id`);
ALTER TABLE `orders` ADD INDEX(`address_id`);

CREATE TABLE `mutivendor_laravel_ecom`.`transactions` (`id` BIGINT NOT NULL AUTO_INCREMENT , `user_id` BIGINT NOT NULL , `reference_id` BIGINT NOT NULL , `type` VARCHAR(50) NULL COMMENT 'order,wallet' , `amount` FLOAT(11,2) NOT NULL , `gst_amount` FLOAT(11,2) NOT NULL DEFAULT '0.00' , `status` VARCHAR(50) NOT NULL COMMENT 'success,failed,refunded' , `transaction_id` VARCHAR(255) NULL DEFAULT NULL , `created_at` DATETIME NOT NULL , `updated_at` DATETIME NOT NULL , PRIMARY KEY (`id`), INDEX (`user_id`), INDEX (`reference_id`)) ENGINE = MyISAM;

CREATE TABLE `mutivendor_laravel_ecom`.`order_item_taxes` (`id` BIGINT NOT NULL AUTO_INCREMENT , `order_item_id` BIGINT NOT NULL , `category_tax_id` BIGINT NOT NULL , `tax_val` FLOAT(11,2) NOT NULL DEFAULT '0.00' , `created_at` DATETIME NOT NULL , `updated_at` DATETIME NOT NULL , PRIMARY KEY (`id`), INDEX (`order_item_id`), INDEX (`category_tax_id`)) ENGINE = MyISAM; 

ALTER TABLE `users` ADD `wallet_avl_balance` FLOAT(11,2) NOT NULL DEFAULT '0.00' AFTER `payout_period`, ADD `wallet_rsv_balance` FLOAT(11,2) NOT NULL DEFAULT '0.00' AFTER `wallet_avl_balance`;

CREATE TABLE `mutivendor_laravel_ecom`.`wallet_history` (`id` BIGINT NOT NULL AUTO_INCREMENT , `user_id` BIGINT NOT NULL , `amount` FLOAT(11,2) NOT NULL , `gst_amount` FLOAT(11,2) NOT NULL DEFAULT '0.00' , `type` VARCHAR(50) NOT NULL COMMENT 'debit,credit' , `description` TEXT NULL DEFAULT NULL , `transaction_id` VARCHAR(255) NULL DEFAULT NULL , `created_at` DATETIME NOT NULL , `updated_at` DATETIME NOT NULL , PRIMARY KEY (`id`), INDEX (`user_id`)) ENGINE = MyISAM;

ALTER TABLE `order_items` CHANGE `status` `status` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'received,confirmed,shipped,out_for_delivery,delivered,cancelled,returned';

ALTER TABLE `orders` ADD `payment_method` VARCHAR(50) NOT NULL COMMENT 'cod,paypal,phonepe,cccavenue' AFTER `delivery`;

ALTER TABLE `orders` ADD `invoice_path` VARCHAR(255) NULL DEFAULT NULL AFTER `transaction_id`;
ALTER TABLE `orders` ADD `currency_code` VARCHAR(20) NULL DEFAULT NULL AFTER `invoice_path`;

ALTER TABLE `order_item_taxes` ADD `tax_price` FLOAT(11,2) NOT NULL DEFAULT '0.00' AFTER `tax_val`;

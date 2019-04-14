ALTER TABLE `users`
ADD COLUMN `mobile` varchar(255) NULL DEFAULT '' COMMENT '手机号' AFTER `id_card`;
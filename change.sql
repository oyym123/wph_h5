ALTER TABLE `users`
ADD COLUMN `mobile` varchar(255) NULL DEFAULT '' COMMENT '手机号';

ALTER TABLE `users`
ADD COLUMN `wb_uid` varchar(255) NULL COMMENT '微博的uid MD5';

ALTER TABLE `order`
ADD COLUMN `remark` varchar(255) NULL DEFAULT '' COMMENT '备注';
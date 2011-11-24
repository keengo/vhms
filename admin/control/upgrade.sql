ALTER TABLE `nodes` CHANGE `user` `user` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `nodes` CHANGE `win` `win` TINYINT( 4 ) NULL DEFAULT '0';
ALTER TABLE `nodes` CHANGE `type` `type` INT( 11 ) NULL DEFAULT '0';
ALTER TABLE `nodes` CHANGE `user` `user` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE vhost_product ADD COLUMN `view` int( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE `users` ADD `agent_id` INT NOT NULL DEFAULT '0';


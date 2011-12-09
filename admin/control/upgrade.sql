ALTER TABLE `vhost` DROP INDEX `name` , ADD UNIQUE `name` ( `name` ) ;
alter table vhost_product add column ftp int(11) NOT NULL DEFAULT '1';
alter table vhost_product add column htaccess tinyint(4) DEFAULT '1';
alter table vhost_product add column access tinyint(4) DEFAULT '1';
alter table vhost_product add column log_file tinyint(4) DEFAULT '1';
alter table vhost_product add column max_connect int(11) NOT NULL DEFAULT '0';
alter table vhost_product add column speed_limit INTEGER DEFAULT '0';
ALTER TABLE `users` ADD `uid` TINYINT( 11 ) NOT NULL DEFAULT '0' FIRST ,
ADD INDEX ( `uid` );
ALTER TABLE `nodes` CHANGE `user` `user` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `nodes` CHANGE `win` `win` TINYINT( 4 ) NULL DEFAULT '0';
ALTER TABLE `nodes` CHANGE `type` `type` INT( 11 ) NULL DEFAULT '0';
ALTER TABLE `nodes` CHANGE `user` `user` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE vhost_product ADD COLUMN `view` int( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE `users` ADD `agent_id` INT NOT NULL DEFAULT '0';

CREATE TABLE IF NOT EXISTS `agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `agent_price` (
  `agent_id` int(11) NOT NULL,
  `product_type` tinyint(4) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`agent_id`,`product_type`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
alter table vhost_product add column cs tinyint(4) DEFAULT '0';
alter table vhost_product add column envs TEXT;
alter table vhost_product add column cdn tinyint(4) DEFAULT '0';
ALTER TABLE `nodes` ADD `nickname` VARCHAR( 255 ) NOT NULL ;


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

CREATE TABLE IF NOT EXISTS `mproduct` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) character set utf8 NOT NULL,
  `group_id` int(11) NOT NULL,
  `upid` int(11) NULL,
  `describe` text character set utf8 NULL,
  `price` int(11) NOT NULL,
  `month_flag` tinyint(4) NULL default '0',
  `pause_flag` tinyint(4) NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mproduct_group` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `describe` text NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mproduct_order` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(32) NOT NULL,
  `product_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `client_msg` text,
  `admin_msg` text,
  `admin_mem` text,
  `price` int(11)  NULL,
  `month` int(11)  NULL,
  `create_time` datetime NOT NULL,
  `expire_time` datetime NOT NULL,
  `status` tinyint(4)  NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
ALTER TABLE `vhost` ADD `flow` BIGINT NOT NULL ;
ALTER TABLE `users` ADD `flow` BIGINT NOT NULL ;
ALTER TABLE `vhost_product` ADD `flow` BIGINT NOT NULL ;
ALTER TABLE `mproduct` ADD `show_price` tinyint(4) NOT NULL default '0';
ALTER TABLE `vhost_product` ADD `show_price` tinyint(4) NOT NULL DEFAULT '0';
ALTER TABLE `setting` CHANGE `value` `value` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;
ALTER TABLE  `users` CHANGE  `flow`  `flow` BIGINT( 20 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `users` CHANGE  `uid`  `uid` INT( 11 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `vhost` CHANGE  `flow`  `flow` BIGINT( 20 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `vhost_product` CHANGE  `flow`  `flow` BIGINT( 20 ) NOT NULL DEFAULT  '0',CHANGE  `show_price`  `show_price` TINYINT( 4 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `mproduct` CHANGE  `group_id`  `group_id` INT( 11 ) NOT NULL DEFAULT  '0',
CHANGE  `upid`  `upid` INT( 11 ) NOT NULL DEFAULT  '0',
CHANGE  `price`  `price` INT( 11 ) NOT NULL DEFAULT  '0',
CHANGE  `month_flag`  `month_flag` TINYINT( 4 ) NOT NULL DEFAULT  '0',
CHANGE  `pause_flag`  `pause_flag` TINYINT( 4 ) NOT NULL DEFAULT  '0',
CHANGE  `show_price`  `show_price` TINYINT( 4 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `mproduct` CHANGE  `describe`  `describe` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `vhost` ADD `db_type` VARCHAR( 255 ) NOT NULL default 'mysql';
ALTER TABLE `vhost_product` ADD `db_type` VARCHAR( 255 ) NOT NULL default 'mysql';
ALTER TABLE `vhost_product` ADD `max_subdir` int(11) NOT NULL default '0';
ALTER TABLE `vhost_product` ADD `max_worker` int(11) NOT NULL default '0';
ALTER TABLE `vhost_product` ADD `max_queue`  int(11) NOT NULL default '0';
ALTER TABLE `vhost_product` ADD `log_handle` tinyint(4) NOT NULL default '0';




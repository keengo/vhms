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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `agent_price` (
  `agent_id` int(11) NOT NULL,
  `product_type` tinyint(4) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`agent_id`,`product_type`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

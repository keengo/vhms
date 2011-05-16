ALTER TABLE `vhost` DROP INDEX `name` , ADD UNIQUE `name` ( `name` ) ;

CREATE TABLE IF NOT EXISTS `vhost_webapp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(32) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `install_time` datetime DEFAULT NULL,
  `appid` varchar(16) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `dir` varchar(32) NOT NULL,
  `phy_dir` varchar(255) NOT NULL,
  `appname` varchar(64) DEFAULT NULL,
  `appver` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`,`appid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=65 ;
ALTER TABLE `vhost_product` ADD `domain` INT NOT NULL DEFAULT '-1',
ADD `subtemplete` VARCHAR( 255 ) NULL DEFAULT NULL ,
ADD `upid` INT NOT NULL DEFAULT '0';
CREATE TABLE IF NOT EXISTS `setting` (
  `name` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `money_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `money` int(11) NOT NULL DEFAULT '0',
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `gw` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `gwid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='³äÖµ¼ÇÂ¼' AUTO_INCREMENT=9 ;


CREATE TABLE IF NOT EXISTS `money_out` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `money` int(11) NOT NULL,
  `add_time` datetime NOT NULL,
  `mem` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

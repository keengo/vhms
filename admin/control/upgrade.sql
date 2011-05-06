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

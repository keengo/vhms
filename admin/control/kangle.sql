-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 01, 2011 at 03:28 AM
-- Server version: 5.1.53
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kangle`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE IF NOT EXISTS `admin_users` (
  `username` varchar(32) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nodes`
--

CREATE TABLE IF NOT EXISTS `nodes` (
  `name` varchar(32) NOT NULL,
  `host` varchar(64) NOT NULL,
  `port` int(11) NOT NULL,
  `user` varchar(32)  NULL,
  `passwd` varchar(32) NOT NULL,
  `db_type` enum('mysql','dblib','pgsql') DEFAULT NULL,
  `db_user` varchar(255) DEFAULT NULL,
  `db_passwd` varchar(255) DEFAULT NULL,
  `state` tinyint(4)  DEFAULT '0',
  `type` int(11) null,
  `win` tinyint(4) null,
  `dev` varchar(255) null,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` TINYINT( 11 ) NOT NULL DEFAULT '0', 
  `username` varchar(32) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `money` int(11) NOT NULL DEFAULT '0',
  `id` varchar(255) DEFAULT NULL,
  `regtime` datetime NOT NULL,
  PRIMARY KEY (`username`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `vhost`
--

CREATE TABLE IF NOT EXISTS `vhost` (
  `name` varchar(32) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `doc_root` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `gid` varchar(32) NOT NULL DEFAULT '1100',
  `templete` varchar(255) NOT NULL,
  `subtemplete` varchar(255) NOT NULL DEFAULT '',
  `create_time` datetime NOT NULL,
  `expire_time` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `node` varchar(32) NOT NULL,
  `product_id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `name` (`name`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

--
-- Table structure for table `vhost_product`
--

CREATE TABLE IF NOT EXISTS `vhost_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `describe` text,
  `templete` varchar(32) NOT NULL,
  `web_quota` bigint(11) NOT NULL,
  `db_quota` bigint(20) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL,
  `pause_flag` tinyint(4) DEFAULT '0',
  `node` varchar(32) NOT NULL,
  `try_flag` tinyint(4) DEFAULT '0',
  `month_flag` tinyint(4) DEFAULT '0',
  `subdir_flag` tinyint(4) NOT NULL DEFAULT '0',
  `subdir` varchar(255) NOT NULL DEFAULT '/',
  `subtemplete` VARCHAR( 255 ) NULL DEFAULT NULL,
  `domain` INT NOT NULL DEFAULT '-1' ,
  `upid` INT NOT NULL DEFAULT '0',
  `ftp` int(11) NOT NULL DEFAULT '1',
  `htaccess` tinyint(4) DEFAULT '1',
  `access` tinyint(4) DEFAULT '1',
  `log_file` tinyint(4) DEFAULT '1',
  `max_connect` int(11) NOT NULL DEFAULT '0',
  `speed_limit` INTEGER DEFAULT '0',
  `view` INTEGER DEFAULT '0', 
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `money_out` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `money` int(11) NOT NULL,
  `add_time` datetime NOT NULL,
  `mem` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `add_time` datetime NOT NULL,
  `status` int(11) NOT NULL default '0',
  `admin` varchar(32) default NULL,
  `reply` text,
  `reply_time` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `username` (`username`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `add_time` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

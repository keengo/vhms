-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 16, 2011 at 09:37 AM
-- Server version: 5.1.53
-- PHP Version: 5.2.16

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
  `rights` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员列表';

-- --------------------------------------------------------

--
-- Table structure for table `domain`
--

CREATE TABLE IF NOT EXISTS `domain` (
  `name` varchar(255) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `dir` varchar(255) NOT NULL DEFAULT '/',
  UNIQUE KEY `domain` (`domain`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nodes`
--

CREATE TABLE IF NOT EXISTS `nodes` (
  `name` varchar(32) NOT NULL,
  `host` varchar(64) NOT NULL,
  `port` int(11) NOT NULL,
  `user` varchar(32) NOT NULL,
  `passwd` varchar(32) NOT NULL,
  `db_user` varchar(255) DEFAULT NULL,
  `db_passwd` varchar(255) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `win` tinyint(4) NOT NULL DEFAULT '0',
  `dev` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='服务器';

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE IF NOT EXISTS `shopping_cart` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `product_type` tinyint(4) NOT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL,
  `param` varchar(255) NOT NULL,
  `mem` text NOT NULL,
  `month` int(11) NOT NULL,
  `add_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购物车' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(32) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `money` int(11) NOT NULL DEFAULT '0',
  `id` varchar(255) DEFAULT NULL,
  `regtime` datetime NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户列表';

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
  `create_time` datetime NOT NULL,
  `expire_time` datetime NOT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '0',
  `node` varchar(32) NOT NULL,
  `product_id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `name` (`name`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='虚拟主机表' AUTO_INCREMENT=10 ;

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
  `db_type` tinyint(4) NOT NULL DEFAULT '1',
  `db_quota` bigint(20) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT '0',
  `node` varchar(32) NOT NULL,
  `try_flag` tinyint(4) DEFAULT '0',
  `month_flag` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='产品列表' AUTO_INCREMENT=2 ;

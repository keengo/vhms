-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- 主机: localhost:3306
-- 生成日期: 2010 年 11 月 07 日 09:38
-- 服务器版本: 5.1.50
-- PHP 版本: 5.2.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `kpanel`
--

-- --------------------------------------------------------

--
-- 表的结构 `kp_dbs`
--

CREATE TABLE IF NOT EXISTS `kp_dbs` (
  `dbname` varchar(32) NOT NULL,
  `dbpasswd` varchar(128) NOT NULL,
  `username` varchar(32) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`dbname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `kp_ftplog`
--

CREATE TABLE IF NOT EXISTS `kp_ftplog` (
  `ftpname` varchar(32) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `kp_ftpuser`
--

CREATE TABLE IF NOT EXISTS `kp_ftpuser` (
  `ftpname` varchar(32) NOT NULL DEFAULT '',
  `ftppasswd` varchar(128) NOT NULL DEFAULT '',
  `username` varchar(32) NOT NULL,
  `uid` smallint(6) NOT NULL DEFAULT '5500',
  `gid` smallint(6) NOT NULL DEFAULT '5500',
  `homedir` varchar(255) NOT NULL DEFAULT '',
  `shell` varchar(16) NOT NULL DEFAULT '/sbin/nologin',
  `count` int(11) NOT NULL DEFAULT '0',
  `accessed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ftpname`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `kp_hosts`
--

CREATE TABLE IF NOT EXISTS `kp_hosts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  `username` varchar(16) NOT NULL,
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `kp_users`
--

CREATE TABLE IF NOT EXISTS `kp_users` (
  `username` varchar(16) NOT NULL,
  `passwd` char(32) NOT NULL,
  `homedir` varchar(255) NOT NULL,
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(11) unsigned NOT NULL DEFAULT '1100',
  `regtime` int(11) unsigned NOT NULL,
  `expiretime` int(11) unsigned NOT NULL,
  `spacetype` int(3) unsigned NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10000 ;

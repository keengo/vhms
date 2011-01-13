-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2010 年 12 月 20 日 01:33
-- 服务器版本: 5.0.77
-- PHP 版本: 5.1.6
-- 
-- 数据库: `kangle`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `admin_users`
-- 

CREATE TABLE `admin_users` (
  `username` varchar(32) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `last_login` varchar(255) NOT NULL,
  `last_ip` varchar(255) NOT NULL,
  `rights` int(11) NOT NULL,
  PRIMARY KEY  (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员列表';

-- --------------------------------------------------------

-- 
-- 表的结构 `domain`
-- 

CREATE TABLE `domain` (
  `name` varchar(255) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `dir` varchar(255) NOT NULL,
  UNIQUE KEY `domain` (`domain`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- 表的结构 `nodes`
-- 

CREATE TABLE `nodes` (
  `name` varchar(32) NOT NULL,
  `host` varchar(64) NOT NULL,
  `port` int(11) NOT NULL,
  `user` varchar(32) NOT NULL,
  `passwd` varchar(32) NOT NULL,
  `state` tinyint(4) NOT NULL,
  PRIMARY KEY  (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='服务器';

-- --------------------------------------------------------

-- 
-- 表的结构 `shopping_cart`
-- 

CREATE TABLE `shopping_cart` (
  `id` bigint(20) NOT NULL auto_increment,
  `username` varchar(32) NOT NULL,
  `product_type` tinyint(4) NOT NULL,
  `state` tinyint(4) NOT NULL default '0',
  `price` int(11) NOT NULL,
  `param` varchar(255) NOT NULL,
  `mem` text NOT NULL,
  `month` int(11) NOT NULL,
  `add_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购物车' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- 表的结构 `users`
-- 

CREATE TABLE `users` (
  `username` varchar(32) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `money` int(11) NOT NULL default '0',
  `id` varchar(255) NOT NULL,
  `regtime` datetime NOT NULL,
  PRIMARY KEY  (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户列表';

-- --------------------------------------------------------

-- 
-- 表的结构 `vhost`
-- 

CREATE TABLE `vhost` (
  `name` varchar(32) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `doc_root` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL auto_increment,
  `gid` varchar(32) NOT NULL default '1100',
  `templete` varchar(255) NOT NULL,
  `create_time` datetime NOT NULL,
  `expire_time` datetime NOT NULL,
  `state` tinyint(4) NOT NULL default '0',
  `node` varchar(32) NOT NULL,
  `product_id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  PRIMARY KEY  (`uid`),
  KEY `name` (`name`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='虚拟主机表' AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

-- 
-- 表的结构 `vhost_product`
-- 

CREATE TABLE `vhost_product` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `desc` text NOT NULL,
  `templete` varchar(32) NOT NULL,
  `web_quota` bigint(11) NOT NULL,
  `db_type` tinyint(4) NOT NULL default '1',
  `db_quota` bigint(20) NOT NULL,
  `price` int(11) NOT NULL,
  `state` tinyint(4) NOT NULL default '0',
  `node` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='产品列表' AUTO_INCREMENT=8 ;

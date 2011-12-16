-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- ����: localhost
-- �������: 2011 �� 12 �� 07 �� 20:42
-- �������汾: 5.0.77
-- PHP �汾: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- ��ݿ�: `kangle`
--

-- --------------------------------------------------------

--
-- ��Ľṹ `admin_users`
--

CREATE TABLE IF NOT EXISTS `admin_users` (
  `username` varchar(32) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `last_login` datetime default NULL,
  `last_ip` varchar(255) default NULL,
  PRIMARY KEY  (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- ��Ľṹ `agent`
--

CREATE TABLE IF NOT EXISTS `agent` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- ��Ľṹ `agent_price`
--

CREATE TABLE IF NOT EXISTS `agent_price` (
  `agent_id` int(11) NOT NULL,
  `product_type` tinyint(4) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY  (`agent_id`,`product_type`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- ��Ľṹ `flow_day`
--

CREATE TABLE IF NOT EXISTS `flow_day` (
  `name` varchar(32) NOT NULL,
  `t` char(8) NOT NULL,
  `flow` bigint(20) NOT NULL,
  PRIMARY KEY  (`name`,`t`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- ��Ľṹ `flow_hour`
--

CREATE TABLE IF NOT EXISTS `flow_hour` (
  `name` varchar(32) NOT NULL,
  `t` char(10) NOT NULL,
  `flow` bigint(20) NOT NULL,
  PRIMARY KEY  (`name`,`t`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- ��Ľṹ `flow_month`
--

CREATE TABLE IF NOT EXISTS `flow_month` (
  `name` varchar(32) NOT NULL,
  `t` char(6) NOT NULL,
  `flow` int(11) NOT NULL,
  PRIMARY KEY  (`name`,`t`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- ��Ľṹ `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `id` int(255) NOT NULL auto_increment,
  `order` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- ��Ľṹ `money_in`
--

CREATE TABLE IF NOT EXISTS `money_in` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(32) NOT NULL,
  `money` int(11) NOT NULL default '0',
  `start_time` datetime NOT NULL,
  `end_time` datetime default NULL,
  `gw` tinyint(4) NOT NULL default '0',
  `status` tinyint(4) NOT NULL default '0',
  `gwid` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- ��Ľṹ `money_out`
--

CREATE TABLE IF NOT EXISTS `money_out` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(32) NOT NULL,
  `money` int(11) NOT NULL,
  `add_time` datetime NOT NULL,
  `mem` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- ��Ľṹ `mproduct`
--

CREATE TABLE IF NOT EXISTS `mproduct` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `group_id` int(11) NOT NULL,
  `upid` int(11) NOT NULL,
  `describe` text NOT NULL,
  `price` int(11) NOT NULL,
  `month_flag` tinyint(4) NOT NULL,
  `pause_flag` tinyint(4) NOT NULL,
  `show_price` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='���Զ���Ʒ';

-- --------------------------------------------------------

--
-- ��Ľṹ `mproduct_group`
--

CREATE TABLE IF NOT EXISTS `mproduct_group` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `describe` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- ��Ľṹ `mproduct_order`
--

CREATE TABLE IF NOT EXISTS `mproduct_order` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(32) NOT NULL,
  `product_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `client_msg` text NOT NULL,
  `admin_msg` text NOT NULL,
  `admin_mem` text NOT NULL,
  `price` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `expire_time` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- ��Ľṹ `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `add_time` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- ��Ľṹ `nodes`
--

CREATE TABLE IF NOT EXISTS `nodes` (
  `name` varchar(32) NOT NULL,
  `host` varchar(64) NOT NULL,
  `port` int(11) NOT NULL,
  `user` varchar(32) default NULL,
  `passwd` varchar(32) NOT NULL,
  `db_type` enum('mysql','dblib','pgsql') default NULL,
  `db_user` varchar(255) default NULL,
  `db_passwd` varchar(255) default NULL,
  `state` tinyint(4) default '0',
  `type` int(11) default '0',
  `win` tinyint(4) default '0',
  `dev` varchar(255) default NULL,
  `nickname` varchar(255) NOT NULL,
  PRIMARY KEY  (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- ��Ľṹ `question`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- ��Ľṹ `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `name` varchar(255) NOT NULL,
  `value` text,
  PRIMARY KEY  (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- ��Ľṹ `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` tinyint(11) NOT NULL default '0',
  `username` varchar(32) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `email` varchar(255) default NULL,
  `name` varchar(255) default NULL,
  `money` int(11) NOT NULL default '0',
  `id` varchar(255) default NULL,
  `regtime` datetime NOT NULL,
  `agent_id` int(11) NOT NULL default '0',
  `flow` bigint(20) NOT NULL,
  PRIMARY KEY  (`username`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- ��Ľṹ `vhost`
--

CREATE TABLE IF NOT EXISTS `vhost` (
  `name` varchar(32) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `doc_root` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL auto_increment,
  `gid` varchar(32) NOT NULL default '1100',
  `templete` varchar(255) NOT NULL,
  `subtemplete` varchar(255) NOT NULL default '',
  `create_time` datetime NOT NULL,
  `expire_time` datetime NOT NULL,
  `status` tinyint(4) NOT NULL default '0',
  `node` varchar(32) NOT NULL,
  `product_id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `flow` bigint(20) NOT NULL,
  PRIMARY KEY  (`uid`),
  UNIQUE KEY `name` (`name`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- ��Ľṹ `vhost_product`
--

CREATE TABLE IF NOT EXISTS `vhost_product` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `describe` text,
  `templete` varchar(32) NOT NULL,
  `web_quota` bigint(11) NOT NULL,
  `db_quota` bigint(20) NOT NULL default '0',
  `price` int(11) NOT NULL,
  `pause_flag` tinyint(4) default '0',
  `node` varchar(32) NOT NULL,
  `try_flag` tinyint(4) default '0',
  `month_flag` tinyint(4) default '0',
  `subdir_flag` tinyint(4) NOT NULL default '0',
  `subdir` varchar(255) NOT NULL default '/',
  `subtemplete` varchar(255) default NULL,
  `domain` int(11) NOT NULL default '-1',
  `upid` int(11) NOT NULL default '0',
  `ftp` int(11) NOT NULL default '1',
  `htaccess` tinyint(4) default '1',
  `access` tinyint(4) default '1',
  `log_file` tinyint(4) default '1',
  `max_connect` int(11) NOT NULL default '0',
  `speed_limit` int(11) default '0',
  `view` int(11) NOT NULL default '0',
  `cs` tinyint(4) default '0',
  `envs` text,
  `cdn` tinyint(4) default '0',
  `flow` bigint(20) NOT NULL,
  `show_price` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- ��Ľṹ `vhost_webapp`
--

CREATE TABLE IF NOT EXISTS `vhost_webapp` (
  `id` int(11) NOT NULL auto_increment,
  `user` varchar(32) NOT NULL,
  `status` tinyint(4) NOT NULL default '0',
  `install_time` datetime default NULL,
  `appid` varchar(16) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `dir` varchar(32) NOT NULL,
  `phy_dir` varchar(255) NOT NULL,
  `appname` varchar(64) default NULL,
  `appver` varchar(16) default NULL,
  PRIMARY KEY  (`id`),
  KEY `user` (`user`,`appid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


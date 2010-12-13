-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2010 年 12 月 11 日 05:13
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员列表';

-- 
-- 导出表中的数据 `admin_users`
-- 

INSERT INTO `admin_users` (`username`, `passwd`, `last_login`, `last_ip`, `rights`) VALUES 
('king', '098f6bcd4621d373cade4e832627b4f6', '', '', 255),
('ff', '633de4b0c14ca52ea2432a3c8a5c4c31', '', '', 0);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- 导出表中的数据 `domain`
-- 

INSERT INTO `domain` (`name`, `domain`, `dir`) VALUES 
('', 'wwww', ''),
('', 'www', 'www'),
('', 'asdfasdf.com', 'www'),
('test', 'test.com', 'wwwjjj'),
('test', 'dddddd', 'www');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='服务器';

-- 
-- 导出表中的数据 `nodes`
-- 

INSERT INTO `nodes` (`name`, `host`, `port`, `user`, `passwd`, `state`) VALUES 
('ddd', 'localhost', 3311, 'admin', 'kangle', 0),
('adsf', 'sadf', 3311, 'asdf', 'asdf', 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `product`
-- 

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `desc` text NOT NULL,
  `templete` varchar(32) NOT NULL,
  `web_quota` bigint(11) NOT NULL,
  `db_type` tinyint(4) NOT NULL,
  `db_quota` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='产品列表';

-- 
-- 导出表中的数据 `product`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `spaces`
-- 

CREATE TABLE `spaces` (
  `name` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `doc_root` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL auto_increment,
  `gid` int(11) NOT NULL default '1100',
  `templete` varchar(255) NOT NULL,
  `create_time` datetime NOT NULL,
  `expire_time` datetime NOT NULL,
  `state` tinyint(4) NOT NULL default '0',
  `shell` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY  (`uid`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='虚拟主机表' AUTO_INCREMENT=1109 ;

-- 
-- 导出表中的数据 `spaces`
-- 

INSERT INTO `spaces` (`name`, `passwd`, `doc_root`, `uid`, `gid`, `templete`, `create_time`, `expire_time`, `state`, `shell`, `product_id`) VALUES 
('king', '098f6bcd4621d373cade4e832627b4f6', '/home/ftp/k/king', 1100, 1100, '_php', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '', 0),
('test', 'ad0234829205b9033196ba818f7a872b', '/home/ftp/t/test', 1101, 1100, '_php', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '', 0),
('test2', 'ad0234829205b9033196ba818f7a872b', '/home/ftp/t/test2', 1102, 1100, '_php', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '', 0),
('testf', '098f6bcd4621d373cade4e832627b4f6', '/home/ftp/t/testf', 1103, 1100, '_php', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '', 0),
('testfs', '098f6bcd4621d373cade4e832627b4f6', '/home/ftp/t/testfs', 1104, 1100, '_php', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '', 0),
('khj99', '098f6bcd4621d373cade4e832627b4f6', '/home/ftp/k/khj99', 1105, 1100, '_php', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '', 0),
('khj999', '098f6bcd4621d373cade4e832627b4f6', '/home/ftp/k/khj999', 1106, 1100, '_php', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '', 0),
('khj999', '098f6bcd4621d373cade4e832627b4f6', '/home/ftp/k/khj999', 1107, 1100, '_php', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '', 0),
('sss', '098f6bcd4621d373cade4e832627b4f6', '/home/ftp/s/sss', 1108, 1100, '_php', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '', 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `templetes`
-- 

CREATE TABLE `templetes` (
  `server` varchar(32) NOT NULL,
  `templete` varchar(32) NOT NULL,
  `weight` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='模板';

-- 
-- 导出表中的数据 `templetes`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `users`
-- 

CREATE TABLE `users` (
  `username` varchar(32) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `money` int(11) NOT NULL,
  `id` varchar(255) NOT NULL,
  `regtime` datetime NOT NULL,
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户列表';

-- 
-- 导出表中的数据 `users`
-- 

INSERT INTO `users` (`username`, `passwd`, `email`, `name`, `money`, `id`, `regtime`) VALUES 
('king', '098f6bcd4621d373cade4e832627b4f6', '', '', 0, '', '0000-00-00 00:00:00'),
('fff', '77963b7a931377ad4ab5ad6a9cd718aa', '', '', 0, '', '0000-00-00 00:00:00');

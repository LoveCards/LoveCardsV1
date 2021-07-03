-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2021-02-13 01:25:51
-- 服务器版本： 5.6.47-log
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `1231234`
--

-- --------------------------------------------------------

--
-- 表的结构 `card`
--

CREATE TABLE IF NOT EXISTS `card` (
  `id` int(11) NOT NULL,
  `cont` varchar(255) NOT NULL,
  `name_1` varchar(255) NOT NULL,
  `name_2` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `zan` varchar(255) NOT NULL DEFAULT '0',
  `comment` varchar(255) NOT NULL DEFAULT '0',
  `ip` varchar(255) NOT NULL,
  `time` timestamp NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `card`
--

INSERT INTO `card` (`id`, `cont`, `name_1`, `name_2`, `img`, `zan`, `comment`, `ip`, `time`) VALUES
(1, '“一个宇宙，九大行星，二百零四个国家，八百零九个岛屿，七个大洋，六十八亿人口，我竟如此幸运，可以遇见你。”\r\n', '吃纸怪', '马化腾', 'http://5b0988e595225.cdn.sohucs.com/images/20170922/eaab95242c534e11b29f9fdd407f0e3c.jpeg', '0', '0', '127.0.0.1', '2021-02-12 17:25:39');

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL,
  `cardid` varchar(255) NOT NULL DEFAULT '',
  `cont` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(255) NOT NULL DEFAULT '',
  `time` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `power` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `zan`
--

CREATE TABLE IF NOT EXISTS `zan` (
  `id` int(11) NOT NULL,
  `cardid` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `time` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zan`
--
ALTER TABLE `zan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `zan`
--
ALTER TABLE `zan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

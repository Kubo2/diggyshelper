-- Host: localhost
-- Generation Time: May 02, 2014 at 08:25 PM
-- Server version: 5.5.24-log

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:01";

--
-- Database: `skdiggyshelper`
--
-- CREATE DATABASE `skdiggyshelper` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
-- USE `skdiggyshelper`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--
-- Creation: Dec 25, 2013 at 12:18 AM
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_title` varchar(150) NOT NULL,
  `category_description` varchar(255) NOT NULL,
  `last_post_date` datetime DEFAULT NULL,
  `last_user_posted` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--
-- Creation: May 01, 2014 at 09:48 AM
-- Last update: May 01, 2014 at 09:48 AM
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) unsigned NOT NULL,
  `name` tinytext NOT NULL,
  `type` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--
-- Creation: May 01, 2014 at 12:53 PM
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) unsigned NOT NULL,
  `topic_id` int(11) unsigned NOT NULL,
  `post_creator` int(11) unsigned NOT NULL,
  `post_content` text NOT NULL,
  `post_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `topic_id` (`topic_id`),
  KEY `post_creator` (`post_creator`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--
-- Creation: May 01, 2014 at 12:41 PM
--

DROP TABLE IF EXISTS `topics`;
CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) unsigned NOT NULL,
  `topic_title` varchar(150) NOT NULL,
  `topic_creator` int(11) unsigned NOT NULL,
  `topic_last_user` int(11) unsigned NOT NULL,
  `topic_date` datetime NOT NULL,
  `topic_reply_date` datetime NOT NULL,
  `topic_views` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `topic_user` (`topic_creator`,`topic_last_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Dec 25, 2013 at 12:18 AM
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `registerdate` datetime NOT NULL,
  `username` varchar(38) NOT NULL,
  `password` varchar(40) NOT NULL,
  `access` enum('admin','moderator','member') NOT NULL DEFAULT 'member',
  `email` varchar(255) DEFAULT NULL,
  `forum_notification` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`),
  ADD CONSTRAINT `posts_ibfk_3` FOREIGN KEY (`post_creator`) REFERENCES `users` (`id`);

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_2` FOREIGN KEY (`topic_creator`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
SET FOREIGN_KEY_CHECKS=1;

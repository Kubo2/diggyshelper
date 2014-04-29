-- This is database structure of Diggy's Helper Project as-is at 29th April 2014 on skdiggyshelper@nibiru.zarea.net
-- 
-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Apr 29, 2014 at 07:26 PM
-- Server version: 5.5.35-0+wheezy1-log
-- PHP Version: 5.5.11-1~dotdeb.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:01";

--
-- Database: `skdiggyshelper`
--
CREATE DATABASE IF NOT EXISTS `skdiggyshelper` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `skdiggyshelper`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--
-- Creation: Jan 07, 2014 at 08:57 PM
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_title` varchar(150) NOT NULL,
  `category_description` varchar(255) NOT NULL,
  `last_post_date` datetime DEFAULT NULL,
  `last_user_posted` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--
-- Creation: Jan 07, 2014 at 08:57 PM
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `ext` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--
-- Creation: Jan 07, 2014 at 08:57 PM
-- Last update: Apr 26, 2014 at 07:56 PM
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `post_creator` int(11) NOT NULL,
  `post_content` text NOT NULL,
  `post_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_creator` (`post_creator`),
  FULLTEXT KEY `post_content` (`post_content`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- RELATIONS FOR TABLE `posts`:
--   `post_creator`
--       `users` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--
-- Creation: Jan 07, 2014 at 08:57 PM
-- Last update: Apr 29, 2014 at 03:59 PM
--

DROP TABLE IF EXISTS `topics`;
CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` tinyint(4) NOT NULL,
  `topic_title` varchar(150) NOT NULL,
  `topic_creator` int(11) NOT NULL,
  `topic_last_user` int(11) NOT NULL,
  `topic_date` datetime NOT NULL,
  `topic_reply_date` datetime NOT NULL,
  `topic_views` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `topic_title` (`topic_title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- RELATIONS FOR TABLE `topics`:
--   `topic_creator`
--       `users` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Mar 26, 2014 at 08:19 PM
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `registerdate` datetime NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `access` enum('admin','moderator','member') NOT NULL DEFAULT 'member',
  `email` varchar(255) DEFAULT NULL,
  `forum_notification` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- phpMyAdmin SQL Dump
-- version 4.0.10deb1ubuntu0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 30, 2021 at 06:50 PM
-- Server version: 5.5.62-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `f32ee`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE IF NOT EXISTS `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `title`) VALUES
(1, 'Sony'),
(2, 'Makers');

-- --------------------------------------------------------

--
-- Table structure for table `cate`
--

CREATE TABLE IF NOT EXISTS `cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(20) NOT NULL,
  `icon` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `cate`
--

INSERT INTO `cate` (`id`, `title`, `icon`) VALUES
(1, 'Sensors', '1.png'),
(2, 'Cables', '2.png'),
(4, 'LCD Screens', '4.png'),
(3, 'Light Emitting Diode', '3.png'),
(5, 'Motor', '5.png');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `enquiry` text NOT NULL,
  `create_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `topic`, `email`, `enquiry`, `create_at`) VALUES
(1, '', '', '', '2021-10-26 10:26:21'),
(3, 'Topic', 'ccccd@qq.com', 'Enquiry', '2021-10-26 10:27:28'),
(4, 'dddddddddddddddd', 'liu0911@outlook.com', 'sadasdasd', '2021-10-31 01:28:57'),
(5, 'dddddddddddddddd', 'f32ee@localhost', 'ASsSAAsda', '2021-10-31 01:40:42'),
(6, 'dddddddddddddddd', 'f32ee@localhost', 'sdfsfsfdsfsdfsdfsdf', '2021-10-31 01:48:06'),
(7, 'dddddddddddddddd', 'f32ee@localhost', 'adssdadqwdqdasdqwdqadw', '2021-10-31 01:50:46');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `product` text,
  `c_email` varchar(40) NOT NULL,
  `s_firstname` varchar(40) NOT NULL,
  `s_lastname` varchar(40) NOT NULL,
  `s_address` varchar(40) NOT NULL,
  `s_apartment` varchar(40) NOT NULL,
  `s_post` varchar(40) NOT NULL,
  `p_email` varchar(40) NOT NULL,
  `p_firstname` varchar(40) NOT NULL,
  `p_lastname` varchar(40) NOT NULL,
  `p_card` varchar(40) NOT NULL,
  `p_expiry` varchar(40) NOT NULL,
  `p_cvv` varchar(40) NOT NULL,
  `p_promo` varchar(40) NOT NULL,
  `status` int(1) DEFAULT '0',
  `create_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `uid`, `product`, `c_email`, `s_firstname`, `s_lastname`, `s_address`, `s_apartment`, `s_post`, `p_email`, `p_firstname`, `p_lastname`, `p_card`, `p_expiry`, `p_cvv`, `p_promo`, `status`, `create_at`) VALUES
(1, 29, '[{"id":"14","num":"1","size":"s"},{"id":"13","num":"93","size":null}]', 'ASDDAS@DS.com', 'LIU', 'GUANGYUAN', '#06-04,1 Cleantech Loop, Singapore 63714', '123123', '6371411', 'liug0019@e.ntu.edu.sg', 'LIU', 'GUANGYUAN', '1231231231', '2021-10-14', '231', '1231231', 0, '2021-10-31 00:56:16');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `band_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  `descption` text,
  `price` varchar(500) NOT NULL,
  `image` varchar(500) NOT NULL,
  `stock` int(10) unsigned NOT NULL DEFAULT '100',
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `title`, `band_id`, `category_id`, `descption`, `price`, `image`, `stock`, `create_at`, `update_at`) VALUES
(10, 'HDMI CABLE 3M', 1, 2, 'Breadboard Friendy 4-pin Push Button Switch\r\n                        Dimensions: 6 x 6mm\r\n                        Height: 5mm without pins, 8mm with pins\r\n                        Weight: Approx. 0.24g', '4.9', '["product_4 1.png","product_4 1.png","product_4 1.png"]', 100, '2021-10-24 05:14:15', '0000-00-00 00:00:00'),
(11, 'HDMI CABLE 5M', 1, 2, 'Breadboard Friendy 4-pin Push Button Switch\r\n                        Dimensions: 6 x 6mm\r\n                        Height: 5mm without pins, 8mm with pins\r\n                        Weight: Approx. 0.24g', '10', '["product_4 1.png","product_4 1-1.png","product_4 1-2.png"]', 93, '2021-10-20 11:24:24', '0000-00-00 00:00:00'),
(12, 'HDMI CABLE 8M', 1, 2, 'Breadboard Friendy 4-pin Push Button Switch\r\n                        Dimensions: 6 x 6mm\r\n                        Height: 5mm without pins, 8mm with pins\r\n                        Weight: Approx. 0.24g', '15', '["product_4 1.png","product_4 1.png","product_4 1.png"]', 100, '2021-10-23 09:26:15', '0000-00-00 00:00:00'),
(13, 'HDMI CABLE 10M', 1, 2, 'Breadboard Friendy 4-pin Push Button Switch\r\n                        Dimensions: 6 x 6mm\r\n                        Height: 5mm without pins, 8mm with pins\r\n                        Weight: Approx. 0.24g', '20', '["product_4 1.png","product_4 1.png","product_4 1.png"]', 0, '2021-10-19 17:41:38', '0000-00-00 00:00:00'),
(14, 'SG90 9G Micro Servo Motor ', 2, 5, 'Size : 22 x 11.5 x 27 mm\nOperating Speed (4.8V no load): 0.12sec/60 degrees\nStall Torque (4.8V): 17.5oz/in (1.2 kg/cm)\nOperating Voltage:3.0-7.2 Volts', '15.90', '["product_5 1-1.png","product_5 1-2.png","product_5 1-3.png"]', 99, '2021-10-26 11:24:30', '0000-00-00 00:00:00'),
(15, '5mm Infrared LED', 2, 3, ' PARAMETERS - Voltage: DC 3.0V-3.2V, Current: 20 mA, Anode: Longer Leg, Viewing Angle: 30 degree, Wavelength Range: 6000-9000K.', '1.2', '["product_6 1.png","product_6 2.png","product_6 3.png"]', 100, '2021-10-18 00:00:00', '0000-00-00 00:00:00'),
(16, '1602 LCD Display S', 3, 4, 'LCD display module with blue blacklight.\r\nWide viewing angle and high contrast.\r\nBuilt-in industry standard HD44780 equivalent LCD controller.', '3.43', '["product_7 1.png","product_7 2.png","product_7 3.png"]', 100, '2021-10-30 08:00:00', '0000-00-00 00:00:00'),
(17, 'MQ135 Air Quality Sensor', 2, 1, 'Sensitivity to Ammonia, Sulphide and Benzene steam\r\nSensitive for benzene, alcohol, smoke\r\nFast response and recovery\r\nAdjustable sensitivity', '12', '["product_8 1.png","product_8 2.png","product_8 3.png"]', 100, '2021-10-31 02:19:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(40) NOT NULL,
  `lastName` varchar(40) NOT NULL,
  `password` varchar(80) NOT NULL,
  `email` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `password`, `email`, `mobile`, `last_login`, `create_at`, `update_at`) VALUES
(29, 'LIU', 'GUANGYUAN', 'baize0911', 'ASDDAS@DS.com', NULL, NULL, '2021-10-31 00:53:38', '0000-00-00 00:00:00'),
(28, 'LIU', 'GUANGYUAN', 'asdadsad', 'adadssad@asdad', NULL, NULL, '2021-10-30 16:23:00', '0000-00-00 00:00:00'),
(25, 'LIU', 'GUANGYUAN', 'baize0911', 'liu0911@outlook.com', NULL, NULL, '2021-10-30 12:34:38', '0000-00-00 00:00:00'),
(26, '1231', '12321', '1231231', '123@2321', NULL, NULL, '2021-10-30 14:20:55', '0000-00-00 00:00:00'),
(27, 'LIU', 'GUANGYUAN', '123456', 'liug0019@e.ntu.edu.s', NULL, NULL, '2021-10-30 16:17:57', '0000-00-00 00:00:00'),
(30, 'Alvin', 'Liu', 'f32ee', 'f32ee@localhost', NULL, NULL, '2021-10-31 02:21:21', '0000-00-00 00:00:00'),
(31, '11111111111111111111111111', '1111111', 'baize0911', 'ASDDAS@DS.com', NULL, NULL, '2021-10-31 02:23:13', '0000-00-00 00:00:00'),
(32, '11111111111111111111111111', '233333', 'baize0911', 'liu0911@outlook.com', NULL, NULL, '2021-10-31 02:23:27', '0000-00-00 00:00:00'),
(33, 'LIU', 'GUANGYUAN', 'baize0911', 'ASDDAS@DS.com', NULL, NULL, '2021-10-31 02:33:38', '0000-00-00 00:00:00'),
(34, 'LIU', 'GUANGYUAN', 'baize0911', '12323132@123123.123', NULL, NULL, '2021-10-31 02:45:35', '0000-00-00 00:00:00'),
(35, 'LIU', 'GUANGYUAN', 'baize0911', 'ASDDAS@DS.com', NULL, NULL, '2021-10-31 02:46:06', '0000-00-00 00:00:00'),
(36, 'LIU', 'GUANGYUAN', '', 'liug0019@e.ntu.edu.s', NULL, NULL, '2021-10-31 02:47:38', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

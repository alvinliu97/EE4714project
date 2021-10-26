-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 02, 2020 at 02:05 PM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.11

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
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` char(41) NOT NULL,
  `role` char(4) NOT NULL,
  `customersID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `accounts` (`customersID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `email`, `password`, `role`, `customersID`) VALUES
(1, 'ryc@ryc.com', 'e10adc3949ba59abbe56e057f20f883e', 'USER', 1),
(2, 'asdf@asdf.com', 'e10adc3949ba59abbe56e057f20f883e', 'USER', 2),
(3, 'f32ee@eee.com', '104f3964c928caca9ae58a5511e6bb9c', 'USER', 3),
(4, 'admin@example.com', 'e00cf25ad42683b3df678c61f42c6bda', 'ADMN', 4);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fullName` varchar(100) NOT NULL,
  `gender` char(1) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(150) NOT NULL,
  `country` varchar(20) NOT NULL,
  `birthday` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `fullName`, `gender`, `phone`, `address`, `country`, `birthday`) VALUES
(1, 'hi', 'M', '12345678', '36', 'Singapore', '2000-02-02'),
(2, 'gg', 'W', '12345678', 'gg', 'Singapore', NULL),
(3, 'alice', 'W', '88888888', '123 nanyang', 'Malaysia', NULL),
(4, 'admin', 'M', '66666666', 'ntu', 'Singapore', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productsID` int(10) unsigned NOT NULL,
  `color` varchar(20) NOT NULL,
  `size` varchar(3) NOT NULL,
  `stock` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `productsID` (`productsID`,`color`,`size`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=91 ;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `productsID`, `color`, `size`, `stock`) VALUES
(1, 1, 'Blue', '7', 1230),
(2, 1, 'Blue', '8', 10),
(3, 1, 'Blue', '9', 10),
(4, 1, 'Blue', '10', 180),
(5, 1, 'Blue', '11', 12),
(6, 1, 'Blue', '12', 103),
(7, 1, 'White', '7', 12),
(8, 1, 'White', '8', 1862),
(9, 1, 'White', '9', 182),
(10, 1, 'White', '10', 192),
(11, 2, 'Brown', '6', 686),
(12, 2, 'Brown', '7', 686),
(13, 2, 'Brown', '8', 896),
(14, 2, 'Brown', '9', 6332),
(15, 2, 'Brown', '10', 6865),
(16, 2, 'White', '6', 6526),
(17, 2, 'White', '7', 638),
(18, 2, 'White', '8', 6634),
(19, 2, 'White', '9', 686),
(20, 2, 'White', '10', 6),
(21, 3, 'Black', '6', 686),
(22, 3, 'Black', '7', 686),
(23, 3, 'Black', '8', 896),
(24, 3, 'Black', '9', 6332),
(25, 3, 'Black', '10', 6865),
(26, 3, 'White', '6', 6526),
(27, 3, 'White', '7', 638),
(28, 3, 'White', '8', 6634),
(29, 3, 'White', '9', 686),
(30, 3, 'White', '10', 6),
(31, 4, 'Black', '6', 686),
(32, 4, 'Black', '7', 686),
(33, 4, 'Black', '8', 896),
(34, 4, 'Black', '9', 6333),
(35, 4, 'Black', '10', 6865),
(36, 4, 'White', '6', 6536),
(37, 4, 'White', '7', 638),
(38, 4, 'White', '8', 6634),
(39, 4, 'White', '9', 686),
(40, 4, 'White', '10', 6),
(41, 5, 'Black', '6', 686),
(42, 5, 'Black', '7', 686),
(43, 5, 'Black', '8', 896),
(44, 5, 'Black', '9', 6333),
(45, 5, 'Black', '10', 6865),
(46, 5, 'Orange', '6', 6536),
(47, 5, 'White', '7', 638),
(48, 5, 'Orange', '8', 6634),
(49, 5, 'White', '9', 686),
(50, 5, 'Orange', '10', 6),
(51, 6, 'Blue', '6', 686),
(52, 6, 'Blue', '7', 686),
(53, 6, 'Blue', '8', 896),
(54, 6, 'Blue', '9', 6333),
(55, 6, 'Blue', '10', 6865),
(56, 6, 'Blue', '10.', 6536),
(57, 6, 'Blue', '11.', 638),
(58, 6, 'Blue', '12', 6634),
(59, 6, 'Blue', '13', 686),
(60, 6, 'Blue', '13.', 6),
(71, 7, 'Brown', '6', 686),
(72, 7, 'Brown', '7', 686),
(73, 7, 'Brown', '8', 896),
(74, 7, 'Brown', '9', 6333),
(75, 7, 'Brown', '10', 6865),
(76, 7, 'Pink', '6', 6536),
(77, 7, 'Pink', '7', 638),
(78, 7, 'Pink', '8', 6634),
(79, 7, 'Pink', '9', 686),
(80, 7, 'Pink', '10', 6),
(81, 8, 'White', '6', 686),
(82, 8, 'White', '7', 686),
(83, 8, 'White', '8', 896),
(84, 8, 'White', '9', 6333),
(85, 8, 'White', '10', 6865),
(86, 8, 'Pink', '6', 6536),
(87, 8, 'Pink', '7', 638),
(88, 8, 'Pink', '8', 6634),
(89, 8, 'Pink', '9', 686),
(90, 8, 'Pink', '10', 6);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ordersDate` datetime NOT NULL,
  `customersID` int(10) unsigned NOT NULL,
  `shipping` char(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orders` (`customersID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `ordersDate`, `customersID`, `shipping`) VALUES
(11, '2020-11-01 18:06:11', 4, ''),
(12, '2020-11-01 18:08:15', 4, ''),
(13, '2020-11-01 20:11:23', 1, ''),
(14, '2020-11-01 20:22:09', 1, ''),
(15, '2020-11-01 20:41:47', 1, ''),
(16, '2020-11-01 20:42:02', 1, ''),
(17, '2020-11-01 20:42:19', 1, ''),
(19, '2020-11-01 20:42:51', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `orders_inventory`
--

CREATE TABLE IF NOT EXISTS `orders_inventory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ordersID` int(10) unsigned NOT NULL,
  `inventoryID` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `pricePerItem` decimal(7,2) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ordersID` (`ordersID`,`inventoryID`),
  KEY `orders_inventory` (`inventoryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `orders_inventory`
--

INSERT INTO `orders_inventory` (`id`, `ordersID`, `inventoryID`, `quantity`, `pricePerItem`) VALUES
(1, 15, 1, 2, 129.90),
(2, 16, 1, 2, 129.90),
(3, 17, 1, 2, 129.90),
(5, 19, 1, 1, 129.90);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `category` char(4) NOT NULL,
  `gender` char(1) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` decimal(7,2) unsigned NOT NULL,
  `discount` float(4,2) unsigned DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `gender`, `description`, `price`, `discount`) VALUES
(1, 'Nike MAX 2020', 'BRD', 'M', 'Comfortable experience in casual style.', 129.90, 0.00),
(2, 'Air RUN MAX', 'RUN', 'M', 'Running performance, at joy.', 199.90, 0.00),
(3, 'Air ZOOMX', 'RUN', 'W', 'Running performance, at joy.', 199.90, 0.00),
(4, 'Zebro Slipper', 'CAS', 'W', 'Casual style.', 39.90, 0.00),
(5, 'Air JORDAN F', 'BAS', 'W', 'Beyond capable and controllable.', 399.90, 0.00),
(6, 'Air JORDAN M', 'BAS', 'M', 'Beyond capable and controllable.', 399.90, 0.00),
(7, 'Nike MAX SE', 'CAS', 'M', 'Mate on the ground.', 199.90, 0.00),
(8, 'Nike ZOOM', 'RUN', 'W', 'Running performance, at joy.', 249.90, 0.00);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`customersID`) REFERENCES `customers` (`id`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`productsID`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customersID`) REFERENCES `customers` (`id`);

--
-- Constraints for table `orders_inventory`
--
ALTER TABLE `orders_inventory`
  ADD CONSTRAINT `orders_inventory_ibfk_1` FOREIGN KEY (`ordersID`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `orders_inventory_ibfk_2` FOREIGN KEY (`inventoryID`) REFERENCES `inventory` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
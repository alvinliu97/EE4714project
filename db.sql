-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2021-10-26 14:01:13
-- 服务器版本： 5.5.29
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `work_shop_en_01`
--

-- --------------------------------------------------------

--
-- 表的结构 `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `title` char(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `brand`
--

INSERT INTO `brand` (`id`, `title`) VALUES
(1, 'Sony');

-- --------------------------------------------------------

--
-- 表的结构 `cate`
--

CREATE TABLE `cate` (
  `id` int(11) NOT NULL,
  `title` char(20) NOT NULL,
  `icon` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cate`
--

INSERT INTO `cate` (`id`, `title`, `icon`) VALUES
(1, 'Sensors', '1.png'),
(2, 'Cables', '2.png'),
(3, 'LCD Screens', '3.png'),
(4, 'Light Emitting Diode', '4.png'),
(5, 'Motor', '5.png');

-- --------------------------------------------------------

--
-- 表的结构 `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `topic` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `enquiry` text NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `message`
--

INSERT INTO `message` (`id`, `topic`, `email`, `enquiry`, `create_at`) VALUES
(1, '', '', '', '2021-10-26 10:26:21'),
(3, 'Topic', 'ccccd@qq.com', 'Enquiry', '2021-10-26 10:27:28');

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `id` mediumint(6) NOT NULL,
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
  `create_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`id`, `uid`, `product`, `c_email`, `s_firstname`, `s_lastname`, `s_address`, `s_apartment`, `s_post`, `p_email`, `p_firstname`, `p_lastname`, `p_card`, `p_expiry`, `p_cvv`, `p_promo`, `status`, `create_at`) VALUES
(11, 14, '[{\"id\":\"11\",\"num\":4,\"size\":\"s\"},{\"id\":\"10\",\"num\":\"1\",\"size\":\"l\"}]', '1234@qq,com', 'LI', 'LEI', '', '', '', '', 'LI', '', '', '', '', '', 0, '2021-10-25 21:00:14'),
(12, 15, '[{\"id\":\"11\",\"num\":2,\"size\":\"s\"},{\"id\":\"13\",\"num\":\"3\",\"size\":\"l\"}]', '1234@qq,com', 'LI', 'LEI', '', '', '', '', 'LI', '', '', '', '', '', 0, '2021-10-25 21:04:37'),
(13, 15, '[{\"id\":\"11\",\"num\":2,\"size\":\"s\"},{\"id\":\"13\",\"num\":\"3\",\"size\":\"l\"}]', '1234@qq,com', 'LI', 'LEI', '', '', '', '', 'LI', '', '', '', '', '', 0, '2021-10-25 21:04:54'),
(14, 14, '[{\"id\":\"12\",\"num\":\"1\",\"size\":\"s\"}]', '1234@qq,com', 'LI', 'LEI', '', '', '', '', 'LI', '', '', '', '', '', 0, '2021-10-26 09:12:33'),
(15, 14, '[{\"id\":\"12\",\"num\":\"1\",\"size\":\"s\"},{\"id\":\"11\",\"num\":\"1\",\"size\":\"m\"}]', '1234@qq,com', 'LI', 'LEI', '', '', '', '', 'LI', '', '', '', '', '', 0, '2021-10-26 09:59:28'),
(16, 14, '[{\"id\":\"12\",\"num\":\"1\",\"size\":\"s\"},{\"id\":\"11\",\"num\":\"1\",\"size\":\"s\"}]', '1234@qq,com', 'LI', 'LEI', '', '', '', '', 'LI', '', '', '', '', '', 0, '2021-10-26 09:59:55'),
(17, 14, '[{\"id\":\"11\",\"num\":2,\"size\":\"s\"},{\"id\":\"10\",\"num\":\"1\",\"size\":\"s\"}]', '1234@qq,com', 'LI', 'LEI', 'au', 'as', '100001', '1234@qq,com', 'LI', 'LEI', '10002124111200', '20251050', '05', '112240', 0, '2021-10-26 10:01:21'),
(18, 14, '[{\"id\":\"11\",\"num\":\"1\",\"size\":\"s\"},{\"id\":\"13\",\"num\":\"1\",\"size\":\"s\"}]', '1234@qq,com', 'LI', 'LEI', 'au', 'as', '100001', '1234@qq,com', 'LI', 'LEI', '1000001022', '2025/01/24', '10', '1120021', 0, '2021-10-26 10:28:36'),
(19, 14, '[{\"id\":\"11\",\"num\":4,\"size\":\"s\"}]', '1234@qq.com', 'LI', 'LEI', 'au', 'as', '100001', '1234@qq.com', 'LI', 'LEI', '10002121', '2021/12/06', '52', '1211', 0, '2021-10-26 13:26:42');

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `band_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  `descption` text,
  `price` varchar(500) NOT NULL,
  `image` varchar(500) NOT NULL,
  `stock` int(10) NOT NULL DEFAULT '100',
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`id`, `title`, `band_id`, `category_id`, `descption`, `price`, `image`, `stock`, `create_at`, `update_at`) VALUES
(10, 'HDMI CABLE 3M', 1, 1, 'Breadboard Friendy 4-pin Push Button Switch\r\n                        Dimensions: 6 x 6mm\r\n                        Height: 5mm without pins, 8mm with pins\r\n                        Weight: Approx. 0.24g', '4.9', '[\"product_4 1.png\",\"product_4 1.png\",\"product_4 1.png\"]', 100, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'HDMI CABLE 5M', 1, 1, 'Breadboard Friendy 4-pin Push Button Switch\r\n                        Dimensions: 6 x 6mm\r\n                        Height: 5mm without pins, 8mm with pins\r\n                        Weight: Approx. 0.24g', '4.9', '[\"product_4 1.png\",\"product_4 1.png\",\"product_4 1.png\"]', 96, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'HDMI CABLE 8M', 1, 1, 'Breadboard Friendy 4-pin Push Button Switch\r\n                        Dimensions: 6 x 6mm\r\n                        Height: 5mm without pins, 8mm with pins\r\n                        Weight: Approx. 0.24g', '4.9', '[\"product_4 1.png\",\"product_4 1.png\",\"product_4 1.png\"]', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'HDMI CABLE 10M', 1, 1, 'Breadboard Friendy 4-pin Push Button Switch\r\n                        Dimensions: 6 x 6mm\r\n                        Height: 5mm without pins, 8mm with pins\r\n                        Weight: Approx. 0.24g', '4.9', '[\"product_4 1.png\",\"product_4 1.png\",\"product_4 1.png\"]', 100, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstName` varchar(40) NOT NULL,
  `lastName` varchar(40) NOT NULL,
  `password` varchar(80) NOT NULL,
  `email` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `create_at` timestamp default '0000-00-00 00:00:00', 
  `update_at` timestamp default now() on update now()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `password`, `email`, `mobile`, `last_login`, `create_at`, `update_at`) VALUES
(14, 'del', 'lili', '123456', '1111@qq.com', NULL, NULL, NULL, NULL),
(15, 'WANG', 'MING', '123456', '22222@qq.com', NULL, NULL, NULL, NULL);

--
-- 转储表的索引
--

--
-- 表的索引 `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cate`
--
ALTER TABLE `cate`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `cate`
--
ALTER TABLE `cate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `id` mediumint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- 使用表AUTO_INCREMENT `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
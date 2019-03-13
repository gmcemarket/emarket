-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 27, 2019 at 12:43 PM
-- Server version: 5.7.17-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id2` int(11) NOT NULL,
  `prd_id2` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id2`, `prd_id2`, `price`, `quantity`, `status`) VALUES
(20, 19, 8, 1, 2, 1),
(21, 19, 7, 70, 2, 1),
(22, 19, 6, 20, 3, 1),
(23, 19, 7, 70, 1, 0),
(24, 19, 6, 20, 2, 0),
(25, 19, 5, 30, 1, 0),
(26, 19, 8, 1, 2, 0),
(27, 20, 1, 10, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_title` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(1, 'Fruits'),
(2, 'Vegetables'),
(3, 'Fish'),
(4, 'Meat');

-- --------------------------------------------------------

--
-- Table structure for table `chat_message`
--

CREATE TABLE `chat_message` (
  `chat_message_id` int(11) NOT NULL,
  `to_user_id` int(11) DEFAULT NULL,
  `from_user_id` int(11) DEFAULT NULL,
  `chat_message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL,
  `m_id1` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chat_message`
--

INSERT INTO `chat_message` (`chat_message_id`, `to_user_id`, `from_user_id`, `chat_message`, `timestamp`, `status`, `m_id1`) VALUES
(1, 19, 19, 'aaaaaaaa', '2018-11-30 09:40:10', 1, NULL),
(2, 20, 19, 'ssssssssss', '2018-12-03 04:39:31', 1, NULL),
(3, 20, 19, 'aaaaaaaaaaaasdadsad', '2018-12-03 04:39:31', 1, NULL),
(32, 19, 19, 'asda1', '2018-11-30 09:51:24', 1, NULL),
(33, 20, 19, 'asdsadas1231312', '2018-12-03 04:39:31', 1, NULL),
(34, 20, 19, 'asdasdsa', '2018-12-03 04:39:31', 1, 1),
(37, 20, 19, 'asdasd123131', '2018-12-03 04:39:31', 1, 1),
(38, 20, 19, 'asdasd123131', '2018-12-03 04:39:31', 1, 1),
(39, 20, 19, 'ssssssssssss', '2018-12-03 04:39:31', 1, 2),
(40, 20, 19, 'aaaaaaaaaaaaaa', '2018-12-03 04:39:31', 1, 1),
(41, 19, 20, 'aaaaaaaaaaaaaa', '2018-12-03 05:25:59', 1, 1),
(50, 20, 19, '1234', '2018-12-03 08:04:31', 1, 2),
(56, 19, 19, 'bbbbbbbbbbbbbbbbbbbbbbb', '2018-12-03 06:04:58', 1, 3),
(57, 19, 19, 'AB', '2018-12-03 06:04:58', 1, 3),
(70, 20, 19, 'RRRRRRRRRR', '2018-12-03 10:30:16', 1, 1),
(77, 20, 19, '123', '2018-12-03 10:49:23', 1, 1),
(78, 20, 19, 'AAAAAAAAAAAAAAAAAAA sadsasds', '2018-12-19 03:26:47', 1, 1),
(79, 20, 19, 'AWWW', '2018-12-19 04:51:28', 1, 1),
(80, 19, 19, 'z', '2018-12-19 04:53:51', 1, 3),
(81, 20, 19, '1', '2018-12-19 04:54:00', 1, 2),
(89, 19, 19, 'a', '2018-12-19 05:27:22', 1, 4),
(90, 19, 19, 'a', '2018-12-19 05:27:34', 1, 4),
(91, 19, 19, 'a', '2018-12-19 05:28:23', 1, 4),
(92, 20, 19, 'a', '2019-01-06 14:13:25', 1, 1),
(93, 20, 0, '', '2019-01-09 05:11:15', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `deliver`
--

CREATE TABLE `deliver` (
  `deliver_id` int(11) NOT NULL,
  `deliver_code` int(11) NOT NULL,
  `user_id3` int(11) NOT NULL,
  `prd_id3` int(11) NOT NULL,
  `qty_left` int(11) NOT NULL,
  `qty_deliver` int(11) NOT NULL,
  `deliver_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `deliver`
--

INSERT INTO `deliver` (`deliver_id`, `deliver_code`, `user_id3`, `prd_id3`, `qty_left`, `qty_deliver`, `deliver_date`) VALUES
(6, 1234, 20, 5, 10, 1, '2019-01-23'),
(7, 1234, 20, 6, 4, 2, '2019-01-23'),
(8, 1234, 20, 7, 1, 3, '2019-01-23'),
(9, 1234, 20, 8, 6, 4, '2019-01-23'),
(10, 1235, 20, 9, 12, 6, '2019-01-23');

-- --------------------------------------------------------

--
-- Table structure for table `friend`
--

CREATE TABLE `friend` (
  `id` int(11) NOT NULL,
  `user_id1` int(11) DEFAULT NULL,
  `friend_id` int(11) DEFAULT NULL,
  `accept` int(11) DEFAULT NULL,
  `notify` int(11) DEFAULT NULL,
  `prd_notif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `friend`
--

INSERT INTO `friend` (`id`, `user_id1`, `friend_id`, `accept`, `notify`, `prd_notif`) VALUES
(4, 19, 20, 1, 1, 1),
(7, 20, 19, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `message_connect`
--

CREATE TABLE `message_connect` (
  `m_id` int(11) NOT NULL,
  `to_user_id` int(11) DEFAULT NULL,
  `from_user_id` int(11) DEFAULT NULL,
  `prd_id1` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `message_connect`
--

INSERT INTO `message_connect` (`m_id`, `to_user_id`, `from_user_id`, `prd_id1`) VALUES
(1, 20, 19, 7),
(2, 20, 19, 6),
(3, 19, 19, 4),
(4, 19, 19, 3),
(5, 20, 0, 8);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_code` int(11) NOT NULL,
  `o_producer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `orderby_id` int(11) NOT NULL,
  `o_quantity` int(11) NOT NULL,
  `o_price` double NOT NULL,
  `order_date` date NOT NULL,
  `order_time` time NOT NULL,
  `status` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_code`, `o_producer_id`, `product_id`, `orderby_id`, `o_quantity`, `o_price`, `order_date`, `order_time`, `status`) VALUES
(25, 100001, 20, 8, 19, 2, 1, '2019-01-14', '15:01:00', 'paid'),
(26, 100001, 20, 7, 19, 2, 70, '2019-01-14', '15:01:00', 'paid'),
(27, 100002, 20, 6, 19, 3, 20, '2019-01-16', '15:01:00', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `prd_id` int(11) NOT NULL,
  `producer_id` int(11) DEFAULT NULL,
  `prd_cat` int(11) DEFAULT NULL,
  `prd_title` varchar(45) DEFAULT NULL,
  `prd_price` double DEFAULT NULL,
  `prd_desc` text,
  `prd_img` text,
  `prd_quantity` int(11) NOT NULL,
  `status_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prd_id`, `producer_id`, `prd_cat`, `prd_title`, `prd_price`, `prd_desc`, `prd_img`, `prd_quantity`, `status_time`) VALUES
(1, 19, 1, 'banana', 10, 'Banana', 'prof1.jpg', 0, '2019-01-27 12:43:03'),
(2, 19, 1, 'grapes', 20, 'Grapes', 'prof3.jpg', 1, '2019-01-08 04:41:39'),
(3, 19, 3, 'Isda', 40, 'Isda', 'profi1.jpg', 3, '2019-01-08 04:41:42'),
(4, 19, 4, 'baboy', 70, 'Baboy', 'prom1.jpg', 10, '2019-01-17 03:38:48'),
(5, 20, 2, 'gulay', 30, 'Gulay', 'prov1.jpg', 11, '2019-01-23 08:07:30'),
(6, 20, 2, 'talong', 20, 'Talong', 'prov2.jpg', 6, '2019-01-23 08:07:30'),
(7, 20, 4, 'manok', 70, 'Manok', 'prom2.jpg', 4, '2019-01-23 08:07:30'),
(8, 20, 4, 'fruits', 1, '1', 'image1.jpg', 10, '2019-01-23 08:07:30'),
(9, 20, 0, 'aaaaa', 33, 'asdasd', 'image2.jpg', 18, '2019-01-23 08:07:30');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(45) DEFAULT NULL,
  `lname` varchar(45) DEFAULT NULL,
  `profile_image` text NOT NULL,
  `sellerOf` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `phone_number` int(11) NOT NULL,
  `code` varchar(45) DEFAULT NULL,
  `verify` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`user_id`, `fname`, `lname`, `profile_image`, `sellerOf`, `email`, `password`, `phone_number`, `code`, `verify`) VALUES
(1, 'asd', 'asdd', '', 'Buyer', 'sadas@gmail.com', 'aaa1', 0, NULL, 0),
(2, 'asd', 'asdd', '', 'Producer', 'sadas@gmail.com', 'aaa', 0, NULL, 1),
(19, 'First Name1', 'Last Name', 'images.jpg', 'Fish,Meat', 'markzfabroa@gmail.com', '202cb962ac59075b964b07152d234b70', 123456789, 'ITOu6FS3yVMq', 1),
(20, 'Name', 'Last', 'profile.jpg', 'Meat', 'markzfabroa1@gmail.com', '202cb962ac59075b964b07152d234b70', 2147483647, '4xnlwLBc7OPu', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`chat_message_id`);

--
-- Indexes for table `deliver`
--
ALTER TABLE `deliver`
  ADD PRIMARY KEY (`deliver_id`);

--
-- Indexes for table `friend`
--
ALTER TABLE `friend`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_connect`
--
ALTER TABLE `message_connect`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prd_id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
--
-- AUTO_INCREMENT for table `deliver`
--
ALTER TABLE `deliver`
  MODIFY `deliver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `friend`
--
ALTER TABLE `friend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

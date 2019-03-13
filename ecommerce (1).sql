-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 12, 2019 at 06:09 AM
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
(47, 20, 8, 20, 1, 0),
(49, 20, 4, 70, 2, 0),
(53, 20, 7, 70, 3, 0);

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
(100, 21, 20, 'Message', '2019-03-11 03:54:57', 1, 7),
(101, 19, 20, 'ASD', '2019-03-11 03:55:26', 1, 6),
(102, 20, 21, 'BBB', '2019-03-11 03:55:12', 1, 7),
(103, 20, 19, 'DDDDDDDDDDD', '2019-03-11 04:15:17', 1, 6);

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
(4, 19, 20, 1, 1, 2),
(7, 20, 19, 1, 1, 1),
(8, 21, 20, 1, 1, 1),
(9, 20, 24, 1, 1, 1),
(10, 20, 25, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `user_id4` int(11) NOT NULL,
  `log_text` text NOT NULL,
  `log_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`log_id`, `user_id4`, `log_text`, `log_date`) VALUES
(3, 20, 'You have updated the product talong', '2019-01-30'),
(4, 20, 'You have updated the product gulay', '2019-01-31'),
(5, 20, 'You have updated the product gulay', '2019-01-31'),
(6, 20, 'You have updated the product fruits', '2019-01-31'),
(7, 20, 'You have updated the product fruits', '2019-01-31'),
(8, 20, 'You have updated the product fruits', '2019-01-31'),
(10, 20, 'You have change the following: gulay2; 301; ', '2019-02-07'),
(11, 20, 'You have change the following: gulay; 30; Gulay Gulay; ', '2019-02-07');

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
(5, 20, 0, 8),
(6, 19, 20, 3),
(7, 21, 20, 8);

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
(26, 100001, 20, 7, 19, 1, 70, '2019-01-14', '15:01:00', 'paid'),
(27, 100002, 20, 6, 19, 3, 20, '2019-01-16', '15:01:00', 'paid'),
(30, 100004, 20, 8, 19, 2, 1, '2019-02-14', '15:01:00', 'paid'),
(31, 100005, 20, 7, 19, 3, 70, '2019-02-20', '15:01:00', 'paid'),
(32, 100006, 20, 6, 19, 4, 20, '2019-03-04', '15:01:00', 'paid'),
(33, 100006, 20, 8, 19, 2, 1, '2019-03-04', '15:01:00', 'paid');

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
(1, 21, 1, 'Fresh Banana', 10, 'New Harvest Banana', 'banana.jpg,banana_1.jpg', 10, '2019-03-12 05:40:22'),
(2, 21, 1, 'Grapes', 20, 'Fresh Grapes', 'grapes.jpg', 20, '2019-03-12 05:26:38'),
(3, 19, 3, 'Bangus', 40, 'Newly Harvest Bangus', 'bangus.jpg,bangus_1.jpg', 20, '2019-03-12 05:41:06'),
(4, 19, 4, 'Ribs', 70, 'Ribs From young pig', 'ribs.jpg', 10, '2019-03-12 05:23:46'),
(5, 20, 2, 'Carrot', 30, 'New Harvest Carrots', 'carrots.jpg,carrots_1.jpg', 11, '2019-03-12 05:41:52'),
(6, 22, 2, 'Radish', 21, 'Radish with no chemicals', 'radish.jpg', 30, '2019-03-12 05:26:42'),
(7, 22, 3, 'Barilis', 70, 'Newly Caught Barilis', 'barilis.jpg,barilis_1.jpg', 20, '2019-03-12 05:43:21'),
(8, 23, 4, 'Belly', 20, 'Belly from a Fresh Pig', 'belley.jpg', 10, '2019-03-12 05:37:16'),
(9, 24, 1, 'Coconut', 10, 'Fresh Coconut', 'coconut.jpg', 10, '2019-03-12 05:27:44'),
(10, 25, 1, 'Apple', 20, 'Newly Fresh two kinds of apples', 'apples.jpg', 20, '2019-03-12 05:28:12'),
(11, 26, 4, 'Drumstick', 40, 'Drumstick From a Fresh Chicken', 'drumstick.jpg', 20, '2019-03-12 05:37:19'),
(12, 27, 3, 'Tilipia', 70, 'Newly Caught Tilipia', 'tilapia.jpg', 10, '2019-03-12 05:37:21'),
(13, 28, 4, 'Chicken', 30, 'All Parts of Chicken that is fresh', 'chicken_all.jpg', 11, '2019-03-12 05:45:54'),
(14, 28, 3, 'Shrimp', 21, 'Big Shrimp that is fresh', 'shrimp.jpg', 30, '2019-03-12 05:37:24'),
(15, 28, 1, 'JackFruit', 70, 'JackFruit that is yummy', 'jackfruit.jpg', 20, '2019-03-12 05:37:26'),
(16, 25, 2, 'Kalabasa', 20, 'Kalbasa in a friendly price', 'kalabasa.jpg', 10, '2019-03-12 05:37:31'),
(17, 19, 4, 'Legs', 30, 'Leg from a girl pig', 'leg.jpg', 11, '2019-03-12 05:37:33'),
(18, 25, 1, 'Mangosteen', 21, 'Sweet Mangosteen', 'mangosteen.jpg', 30, '2019-03-12 05:37:35'),
(19, 20, 1, 'Durian', 70, 'Durian that is Yummy', 'durian.jpg,durian_1.jpg,durian_2.jpg', 20, '2019-03-12 05:39:30'),
(20, 24, 4, 'Whole Pig', 20, 'Whole Pig For A Small Price', 'pig.jpg,pig1.jpg', 10, '2019-03-12 05:38:33');

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
  `phone_number` int(20) NOT NULL,
  `code` varchar(45) DEFAULT NULL,
  `verify` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`user_id`, `fname`, `lname`, `profile_image`, `sellerOf`, `email`, `password`, `phone_number`, `code`, `verify`) VALUES
(19, 'Joshua', 'Santos', 'images.jpg', 'Fish,Meat,Vegetables', 'joshua@gmail.com', '202cb962ac59075b964b07152d234b70', 936587412, 'ITOu6FS3yVMq', 1),
(20, 'James', 'Tomas', 'profile.jpg', 'Fruits,Vegetables', 'james@gmail.com', '202cb962ac59075b964b07152d234b70', 978643512, '4xnlwLBc7OPu', 1),
(21, 'Angelica', 'Cruz', 'profile.jpg', 'Fruits', 'angelica@gmail.com', '202cb962ac59075b964b07152d234b70', 978631452, '4xnlwLBc7OPu', 1),
(22, 'Nicole', 'Bautista', 'images.jpg', 'Fish,Vegetables', 'nicole@gmail.com', '202cb962ac59075b964b07152d234b70', 978546231, 'ITOu6FS3yVMq', 1),
(23, 'Mary Joy', 'Ocampo', 'profile.jpg', 'Meat,Vegetables', 'maryjoy@gmail.com', '202cb962ac59075b964b07152d234b70', 936587415, '4xnlwLBc7OPu', 1),
(24, 'Jerome', 'Garcia', 'profile.jpg', 'Meat,Fruits', 'jerome@gmail.com', '202cb962ac59075b964b07152d234b70', 963752148, '4xnlwLBc7OPu', 1),
(25, 'Stephanie', 'Mendoza', 'images.jpg', 'Fruits,Meat,Vegetables', 'stephanie@gmail.com', '202cb962ac59075b964b07152d234b70', 936541278, 'ITOu6FS3yVMq', 1),
(26, 'Jenney', 'Torres', 'profile.jpg', 'Meat,Fish', 'jenney@gmail.com', '202cb962ac59075b964b07152d234b70', 987416532, '4xnlwLBc7OPu', 1),
(27, 'Ryan', 'Flores', 'profile.jpg', 'Fish', 'ryan@gmail.com', '202cb962ac59075b964b07152d234b70', 934568712, '4xnlwLBc7OPu', 1),
(28, 'Daniel', 'Castillo', 'images.jpg', 'Fish,Meat,Fruits', 'daniel@gmail.com', '202cb962ac59075b964b07152d234b70', 931256478, 'ITOu6FS3yVMq', 1);

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
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`);

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
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;
--
-- AUTO_INCREMENT for table `deliver`
--
ALTER TABLE `deliver`
  MODIFY `deliver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `friend`
--
ALTER TABLE `friend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

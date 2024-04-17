-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2024 at 12:36 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `c_name` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_number` int(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `Date_of_Birth` date NOT NULL,
  `phone` int(32) NOT NULL,
  `card_id` int(32) NOT NULL,
  `card_expirationdate` date NOT NULL,
  `card_name` varchar(32) NOT NULL,
  `bank_name` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `customer_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`c_name`, `email`, `id_number`, `address`, `Date_of_Birth`, `phone`, `card_id`, `card_expirationdate`, `card_name`, `bank_name`, `username`, `password`, `customer_id`) VALUES
('yazan zidan', 'yazanzidan@gmail.com', 123456, 'aa', '2024-02-08', 599, 8963983, '0000-00-00', 'ertbg', 'tbtfd', 'yazan_zidan', '123456789', 1921312507);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`email`, `password`) VALUES
('yazan@gmail.com', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(32) NOT NULL,
  `customer_id` int(32) NOT NULL,
  `date` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `process_status` varchar(255) DEFAULT 'not charged'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `date`, `status`, `process_status`) VALUES
(18, 1921312507, '2024-02-08', 1, 'charged'),
(19, 1921312507, '2024-02-08', 1, 'charged'),
(20, 1921312507, '2024-03-10', 0, 'not charged'),
(21, 1921312507, '2024-03-10', 0, 'not charged'),
(22, 1921312507, '2024-03-10', 0, 'not charged'),
(23, 1921312507, '2024-03-10', 0, 'not charged'),
(24, 1921312507, '2024-03-10', 1, 'charged');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `p_id` int(32) NOT NULL,
  `quantity` int(32) NOT NULL,
  `order_id` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`p_id`, `quantity`, `order_id`) VALUES
(1, 5, 19),
(1, 1, 20),
(1, 1, 21),
(1, 1, 22),
(1, 1, 23),
(1, 1, 24);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `p_id` int(10) NOT NULL,
  `p_name` varchar(32) NOT NULL,
  `p_description` varchar(255) NOT NULL,
  `p_category` varchar(30) NOT NULL DEFAULT 'Normal',
  `p_price` int(30) NOT NULL,
  `p_quantity` int(32) NOT NULL,
  `p_remarks` varchar(32) NOT NULL,
  `p_photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`p_id`, `p_name`, `p_description`, `p_category`, `p_price`, `p_quantity`, `p_remarks`, `p_photo`) VALUES
(1, 'regrgr', 'grege', 'new arrival', 53, 34, 'sg', 'itemsImages/item1img.jpeg'),
(2, 'wefe', 'rgfvrg', 'new arrival', 534, 345, 'erg', 'itemsImages/item2img.jpeg'),
(3, 'severs', 'grg', 'on sale', 5, 54, 'dv', 'itemsImages/item3img.jpeg'),
(4, 'sdgsdg', 'fgdsf', 'featured', 53, 543, 'rg', 'itemsImages/item4img.jpeg'),
(5, 'fgsbdfg', 'drfgr', 'high demand', 534, 453, 'ssg', 'itemsImages/item5img.jpeg'),
(6, 'gsr', 'ggwe', 'normal', 543, 34, 'sgvsdfg', 'itemsImages/item6img.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `id_number` (`id_number`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`p_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`p_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1921312508;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `p_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`p_id`) REFERENCES `product` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

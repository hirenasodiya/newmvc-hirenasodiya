-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2023 at 06:01 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newmvc-hirenasodiya`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`, `status`, `created_at`, `updated_at`) VALUES
(1, 'this@gmail.com', '1234', 2, '2023-03-29 21:41:01', '2023-04-10 10:16:44'),
(2, 'this1@gmail,com', '4567', 2, '2023-03-29 22:07:19', '2023-03-30 08:19:22'),
(3, 'this22222@gmail.com', '1234', 1, '0000-00-00 00:00:00', '2023-04-01 09:52:16'),
(4, 'abc1111@gmail.com', '1111', 2, '2023-03-30 08:19:39', '2023-03-30 08:20:11'),
(5, '321@gmail.com', '321', 1, '2023-03-30 08:38:20', '2023-03-30 08:38:30');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `brand_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brand_id`, `name`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'abc', 'abc', 0, '2023-04-18 12:17:44', '2023-04-18 12:31:17'),
(3, 'aaaa', 'bbbb', 0, '2023-04-18 12:26:15', '2023-04-18 12:30:29');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `path` varchar(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `parent_id`, `path`, `name`, `status`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, '1=1=1', 'root ', 1, 'root', '2023-04-11 10:40:16', '2023-04-11 10:44:56'),
(2, 1, '1=1=1=2', ' livingroom ', 2, 'livingroom', '2023-04-11 10:41:07', '2023-04-11 10:44:59'),
(3, 2, '1=1=1=2=3', ' chair ', 2, 'chair', '2023-04-11 10:41:26', '2023-04-11 10:45:01'),
(4, 2, '1=1=1=2=4', ' sofa ', 2, 'sofa', '2023-04-11 10:41:41', '2023-04-11 10:45:04'),
(5, 4, '1=1=1=2=4=5', ' type1 ', 2, 'type1', '2023-04-11 10:42:21', '2023-04-11 10:45:06'),
(6, 1, '1=1=1=6', ' bedroom ', 2, 'bedroom', '2023-04-11 10:44:03', '2023-04-11 10:45:08'),
(7, 6, '1=1=1=6=7', ' bed ', 1, 'bed', '2023-04-11 10:44:21', '2023-04-11 10:44:54'),
(8, 7, '1=1=1=6=7=8', ' panelbed ', 2, 'panelbed', '2023-04-11 10:44:45', '2023-04-11 10:44:51');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `billing_address_id` int(11) DEFAULT NULL,
  `shipping_address_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `mobile` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `billing_address_id`, `shipping_address_id`, `first_name`, `last_name`, `email`, `gender`, `mobile`, `status`, `created_at`, `updated_at`) VALUES
(24, 9, 10, '8', '8', '8', 'male', 8, 2, '2023-04-16 11:48:35', NULL),
(25, 11, 12, '99999', '88888', '777777', 'male', 6, 2, '2023-04-16 12:13:50', '2023-04-19 08:06:54');

-- --------------------------------------------------------

--
-- Table structure for table `customer_address`
--

CREATE TABLE `customer_address` (
  `address_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `address` varchar(11) NOT NULL,
  `city` varchar(11) NOT NULL,
  `state` varchar(11) NOT NULL,
  `country` varchar(11) NOT NULL,
  `zipcode` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_address`
--

INSERT INTO `customer_address` (`address_id`, `customer_id`, `address`, `city`, `state`, `country`, `zipcode`) VALUES
(9, 24, '3', '3', '3', '3', '3'),
(10, 24, '5', '5', '5', '5', '5'),
(11, 25, '5', '5555', '5555', '5555', '5555'),
(12, 25, '4', '4444', '4444', '4444', '4444');

-- --------------------------------------------------------

--
-- Table structure for table `eav_attribute`
--

CREATE TABLE `eav_attribute` (
  `attribute_id` int(11) NOT NULL,
  `entity_type_id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `backend_type` varchar(20) DEFAULT NULL,
  `name` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `backend_model` varchar(255) NOT NULL,
  `input_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eav_attribute`
--

INSERT INTO `eav_attribute` (`attribute_id`, `entity_type_id`, `code`, `backend_type`, `name`, `status`, `backend_model`, `input_type`) VALUES
(28, 6, 'color', 'integer', 'Color', 1, '', 'select'),
(29, 6, 'name', 'varchar', 'Name', 1, '', 'textbox'),
(31, 6, 'random', 'integer', 'Random', 1, '2', 'multiselect'),
(32, 8, 'method', 'text', 'method', 1, '1', 'textbox'),
(33, 9, 'method name', 'integer', 'MethodName', 1, '1', 'select');

-- --------------------------------------------------------

--
-- Table structure for table `eav_attribute_option`
--

CREATE TABLE `eav_attribute_option` (
  `option_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eav_attribute_option`
--

INSERT INTO `eav_attribute_option` (`option_id`, `name`, `attribute_id`, `position`) VALUES
(27, 'black', 28, 0),
(28, 'red', 28, 0),
(29, 'blue', 28, 0),
(33, 'type3', 31, 0),
(34, 'type1', 31, 0),
(35, 'type2', 31, 0),
(36, 'silver', 33, 0),
(37, 'golden', 33, 0),
(38, 'platinium', 33, 0);

-- --------------------------------------------------------

--
-- Table structure for table `entity_type`
--

CREATE TABLE `entity_type` (
  `entity_type_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `entity_model` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `entity_type`
--

INSERT INTO `entity_type` (`entity_type_id`, `name`, `entity_model`) VALUES
(1, 'product', ''),
(2, 'category', ''),
(3, 'customer', ''),
(4, 'vendor', ''),
(5, 'salesman', ''),
(6, 'item', ''),
(8, 'payment_method', ''),
(9, 'shipping_method', ''),
(10, 'admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `entity_id` int(11) NOT NULL,
  `SKU` varchar(255) NOT NULL,
  `entity_type_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`entity_id`, `SKU`, `entity_type_id`, `status`, `created_at`, `updated_at`) VALUES
(52, 'sku 2', 0, 2, '2023-04-19 09:42:23', '2023-04-19 09:43:05'),
(53, '111', 0, 1, '2023-04-19 10:09:53', '2023-04-19 10:32:59'),
(54, '123', 0, 1, '2023-04-19 10:21:07', '2023-04-19 10:29:58'),
(56, '123', 0, 1, '2023-04-20 07:54:15', '0000-00-00 00:00:00'),
(57, '123', 0, 1, '2023-04-20 07:55:07', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `item_decimal`
--

CREATE TABLE `item_decimal` (
  `value_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_integer`
--

CREATE TABLE `item_integer` (
  `value_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_integer`
--

INSERT INTO `item_integer` (`value_id`, `entity_id`, `attribute_id`, `value`) VALUES
(9, 52, 28, 28),
(11, 53, 28, 28),
(13, 54, 28, 28),
(14, 54, 31, 33),
(18, 55, 28, 28),
(19, 55, 31, 34);

-- --------------------------------------------------------

--
-- Table structure for table `item_text`
--

CREATE TABLE `item_text` (
  `value_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_varchar`
--

CREATE TABLE `item_varchar` (
  `value_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_varchar`
--

INSERT INTO `item_varchar` (`value_id`, `entity_id`, `attribute_id`, `value`) VALUES
(34, 54, 29, 'abcdef'),
(36, 53, 29, ''),
(37, 55, 29, 'test name');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `media_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `base` tinyint(4) NOT NULL,
  `thumbnail` tinyint(4) NOT NULL,
  `small` tinyint(4) NOT NULL,
  `gallery` tinyint(4) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`media_id`, `product_id`, `name`, `status`, `image`, `base`, `thumbnail`, `small`, `gallery`, `created_at`) VALUES
(35, 118, 'chair', 1, '35.jpg', 1, 1, 1, 1, '2023-03-03'),
(39, 118, 'cha123', 1, '39.jpeg', 0, 0, 0, 0, '2023-03-03'),
(40, 118, 'chair456', 1, '40.jpeg', 0, 0, 0, 0, '2023-03-03'),
(122, 119, 'cupboaerd1', 1, '122.jpeg', 1, 0, 1, 1, '2023-03-21'),
(123, 119, 'cupboard2', 1, '123.jpeg', 0, 1, 0, 1, '2023-03-21');

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `payment_method_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`payment_method_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(47, '123321', 1, '2023-04-20 07:17:29', '0000-00-00 00:00:00'),
(48, '2', 1, '2023-04-20 07:40:27', '0000-00-00 00:00:00'),
(49, '2', 1, '2023-04-20 07:43:38', '0000-00-00 00:00:00'),
(52, '654645', 1, '2023-04-20 07:55:48', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `payment_method_integer`
--

CREATE TABLE `payment_method_integer` (
  `value_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_method_text`
--

CREATE TABLE `payment_method_text` (
  `value_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_method_text`
--

INSERT INTO `payment_method_text` (`value_id`, `entity_id`, `attribute_id`, `value`) VALUES
(1, 54, 32, 'method five');

-- --------------------------------------------------------

--
-- Table structure for table `payment_method_varchar`
--

CREATE TABLE `payment_method_varchar` (
  `value_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `attribute_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `SKU` varchar(255) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(5) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `color` enum('blue','black') NOT NULL,
  `material` enum('hard','soft') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `base` int(11) DEFAULT NULL,
  `thumbnail` int(11) DEFAULT NULL,
  `small` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `SKU`, `cost`, `price`, `quantity`, `description`, `status`, `color`, `material`, `created_at`, `updated_at`, `base`, `thumbnail`, `small`) VALUES
(118, 'chair', '123-10', '2000.00', '2500.00', 25, '999', 1, 'blue', 'hard', '2023-03-03 06:50:57', '2023-04-18 12:28:02', 35, 35, 35),
(119, 'cupbord', '123-11', '10000.00', '11000.00', 25, 'bbbbb', 1, 'black', 'soft', '2023-03-03 06:51:40', '2023-03-23 10:56:48', 122, 123, 122),
(291, '32', '132', '132.00', '1.00', 32, '131', 2, 'blue', 'hard', '2023-04-04 08:01:42', '0000-00-00 00:00:00', 0, 0, 0),
(292, '32', '132', '132.00', '1.00', 32, '131', 2, 'blue', 'hard', '2023-04-04 08:02:04', '0000-00-00 00:00:00', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_int`
--

CREATE TABLE `product_int` (
  `value_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quote`
--

CREATE TABLE `quote` (
  `quote_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `shipping_method_id` int(11) NOT NULL,
  `shipping_amount` int(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salesman`
--

CREATE TABLE `salesman` (
  `salesman_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `mobile` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `company` varchar(25) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salesman`
--

INSERT INTO `salesman` (`salesman_id`, `first_name`, `last_name`, `email`, `gender`, `mobile`, `status`, `company`, `created_at`, `updated_at`) VALUES
(4, 'yash', '8', 'this@gmail.com', 'female', 8, 2, '8', '2023-04-01 07:12:47', '2023-04-18 12:28:49');

-- --------------------------------------------------------

--
-- Table structure for table `salesman_address`
--

CREATE TABLE `salesman_address` (
  `address_id` int(11) NOT NULL,
  `salesman_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `zipcode` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salesman_address`
--

INSERT INTO `salesman_address` (`address_id`, `salesman_id`, `address`, `city`, `state`, `country`, `zipcode`) VALUES
(4, 4, '8', '8', '8', '8', '8'),
(5, 5, '9', '9', '9', '9', '9');

-- --------------------------------------------------------

--
-- Table structure for table `salesman_price`
--

CREATE TABLE `salesman_price` (
  `entity_id` int(11) NOT NULL,
  `salesman_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `salesman_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salesman_price`
--

INSERT INTO `salesman_price` (`entity_id`, `salesman_id`, `product_id`, `salesman_price`) VALUES
(48, 4, 118, 456),
(49, 4, 119, 654);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_method`
--

CREATE TABLE `shipping_method` (
  `shipping_method_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` decimal(50,0) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping_method`
--

INSERT INTO `shipping_method` (`shipping_method_id`, `name`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(64, '5', '5', 1, '2023-04-19 08:20:39', '0000-00-00 00:00:00'),
(65, '321', '10000', 1, '2023-04-20 08:11:06', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_method_integer`
--

CREATE TABLE `shipping_method_integer` (
  `value_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping_method_integer`
--

INSERT INTO `shipping_method_integer` (`value_id`, `entity_id`, `attribute_id`, `value`) VALUES
(1, 65, 33, 37);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_method_text`
--

CREATE TABLE `shipping_method_text` (
  `value_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendor_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `company` varchar(25) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`vendor_id`, `first_name`, `last_name`, `email`, `gender`, `mobile`, `status`, `company`, `created_at`, `updated_at`) VALUES
(4, '1', '1', 'this@gmail.com', 'male', '1', 2, '1', '2023-04-11 10:47:12', '2023-04-11 10:47:21');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_address`
--

CREATE TABLE `vendor_address` (
  `address_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor_address`
--

INSERT INTO `vendor_address` (`address_id`, `vendor_id`, `address`, `city`, `state`, `country`, `zipcode`) VALUES
(4, 4, '1', '1', '1', '1', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `eav_attribute`
--
ALTER TABLE `eav_attribute`
  ADD PRIMARY KEY (`attribute_id`),
  ADD KEY `entity_type_id` (`entity_type_id`);

--
-- Indexes for table `eav_attribute_option`
--
ALTER TABLE `eav_attribute_option`
  ADD PRIMARY KEY (`option_id`),
  ADD KEY `attribute_id` (`attribute_id`);

--
-- Indexes for table `entity_type`
--
ALTER TABLE `entity_type`
  ADD PRIMARY KEY (`entity_type_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`entity_id`);

--
-- Indexes for table `item_decimal`
--
ALTER TABLE `item_decimal`
  ADD PRIMARY KEY (`value_id`);

--
-- Indexes for table `item_integer`
--
ALTER TABLE `item_integer`
  ADD PRIMARY KEY (`value_id`),
  ADD UNIQUE KEY `entity_id` (`entity_id`,`attribute_id`),
  ADD UNIQUE KEY `entity_id_2` (`entity_id`,`attribute_id`);

--
-- Indexes for table `item_text`
--
ALTER TABLE `item_text`
  ADD PRIMARY KEY (`value_id`),
  ADD UNIQUE KEY `entity_id` (`entity_id`,`attribute_id`);

--
-- Indexes for table `item_varchar`
--
ALTER TABLE `item_varchar`
  ADD PRIMARY KEY (`value_id`),
  ADD UNIQUE KEY `entity_id` (`entity_id`,`attribute_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`media_id`),
  ADD KEY `Product_id` (`product_id`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`payment_method_id`);

--
-- Indexes for table `payment_method_integer`
--
ALTER TABLE `payment_method_integer`
  ADD PRIMARY KEY (`value_id`),
  ADD UNIQUE KEY `entity_id` (`entity_id`,`attribute_id`);

--
-- Indexes for table `payment_method_text`
--
ALTER TABLE `payment_method_text`
  ADD PRIMARY KEY (`value_id`),
  ADD UNIQUE KEY `entity_id` (`entity_id`,`attribute_id`);

--
-- Indexes for table `payment_method_varchar`
--
ALTER TABLE `payment_method_varchar`
  ADD PRIMARY KEY (`value_id`),
  ADD UNIQUE KEY `entity_id` (`entity_id`,`attribute_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_int`
--
ALTER TABLE `product_int`
  ADD PRIMARY KEY (`value_id`),
  ADD UNIQUE KEY `entity_id_2` (`entity_id`,`attribute_id`),
  ADD KEY `entity_id` (`entity_id`),
  ADD KEY `attribute_id` (`attribute_id`);

--
-- Indexes for table `quote`
--
ALTER TABLE `quote`
  ADD PRIMARY KEY (`quote_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `payment_method_id` (`payment_method_id`),
  ADD KEY `shipping_method_id` (`shipping_method_id`);

--
-- Indexes for table `salesman`
--
ALTER TABLE `salesman`
  ADD PRIMARY KEY (`salesman_id`);

--
-- Indexes for table `salesman_address`
--
ALTER TABLE `salesman_address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `salesman_price`
--
ALTER TABLE `salesman_price`
  ADD PRIMARY KEY (`entity_id`),
  ADD KEY `salesman_id` (`salesman_id`),
  ADD KEY `salesman_price_ibfk_1` (`product_id`);

--
-- Indexes for table `shipping_method`
--
ALTER TABLE `shipping_method`
  ADD PRIMARY KEY (`shipping_method_id`);

--
-- Indexes for table `shipping_method_integer`
--
ALTER TABLE `shipping_method_integer`
  ADD PRIMARY KEY (`value_id`),
  ADD UNIQUE KEY `entity_id` (`entity_id`,`attribute_id`);

--
-- Indexes for table `shipping_method_text`
--
ALTER TABLE `shipping_method_text`
  ADD PRIMARY KEY (`value_id`),
  ADD UNIQUE KEY `entity_id` (`entity_id`,`attribute_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_id`);

--
-- Indexes for table `vendor_address`
--
ALTER TABLE `vendor_address`
  ADD PRIMARY KEY (`address_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `customer_address`
--
ALTER TABLE `customer_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `eav_attribute`
--
ALTER TABLE `eav_attribute`
  MODIFY `attribute_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `eav_attribute_option`
--
ALTER TABLE `eav_attribute_option`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `entity_type`
--
ALTER TABLE `entity_type`
  MODIFY `entity_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `entity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `item_decimal`
--
ALTER TABLE `item_decimal`
  MODIFY `value_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_integer`
--
ALTER TABLE `item_integer`
  MODIFY `value_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `item_text`
--
ALTER TABLE `item_text`
  MODIFY `value_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `item_varchar`
--
ALTER TABLE `item_varchar`
  MODIFY `value_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `payment_method_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `payment_method_integer`
--
ALTER TABLE `payment_method_integer`
  MODIFY `value_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_method_text`
--
ALTER TABLE `payment_method_text`
  MODIFY `value_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_method_varchar`
--
ALTER TABLE `payment_method_varchar`
  MODIFY `value_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=319;

--
-- AUTO_INCREMENT for table `product_int`
--
ALTER TABLE `product_int`
  MODIFY `value_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quote`
--
ALTER TABLE `quote`
  MODIFY `quote_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salesman`
--
ALTER TABLE `salesman`
  MODIFY `salesman_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `salesman_address`
--
ALTER TABLE `salesman_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `salesman_price`
--
ALTER TABLE `salesman_price`
  MODIFY `entity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `shipping_method`
--
ALTER TABLE `shipping_method`
  MODIFY `shipping_method_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `shipping_method_integer`
--
ALTER TABLE `shipping_method_integer`
  MODIFY `value_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shipping_method_text`
--
ALTER TABLE `shipping_method_text`
  MODIFY `value_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vendor_address`
--
ALTER TABLE `vendor_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD CONSTRAINT `customer_address_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `eav_attribute`
--
ALTER TABLE `eav_attribute`
  ADD CONSTRAINT `eav_attribute_ibfk_1` FOREIGN KEY (`entity_type_id`) REFERENCES `entity_type` (`entity_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `eav_attribute_option`
--
ALTER TABLE `eav_attribute_option`
  ADD CONSTRAINT `eav_attribute_option_ibfk_1` FOREIGN KEY (`attribute_id`) REFERENCES `eav_attribute` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_ibfk_1` FOREIGN KEY (`Product_id`) REFERENCES `product` (`Product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_int`
--
ALTER TABLE `product_int`
  ADD CONSTRAINT `product_int_ibfk_1` FOREIGN KEY (`entity_id`) REFERENCES `eav_attribute` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_int_ibfk_2` FOREIGN KEY (`entity_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quote`
--
ALTER TABLE `quote`
  ADD CONSTRAINT `quote_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quote_ibfk_2` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_method` (`payment_method_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quote_ibfk_3` FOREIGN KEY (`shipping_method_id`) REFERENCES `shipping_method` (`shipping_method_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `salesman_price`
--
ALTER TABLE `salesman_price`
  ADD CONSTRAINT `salesman_price_ibfk_1` FOREIGN KEY (`Product_id`) REFERENCES `product` (`Product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salesman_price_ibfk_2` FOREIGN KEY (`salesman_id`) REFERENCES `salesman` (`salesman_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

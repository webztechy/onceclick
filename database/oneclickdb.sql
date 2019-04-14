-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2019 at 02:35 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oneclickdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `oc_products`
--

CREATE TABLE `oc_products` (
  `product_id` mediumint(5) NOT NULL,
  `product_barcode` varchar(250) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `product_cost` float NOT NULL DEFAULT '0',
  `product_vat` smallint(3) NOT NULL,
  `product_created_date` datetime DEFAULT NULL,
  `product_created_by` mediumint(5) NOT NULL DEFAULT '0',
  `product_modified_date` datetime DEFAULT NULL,
  `product_modified_by` mediumint(5) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oc_products`
--

INSERT INTO `oc_products` (`product_id`, `product_barcode`, `product_name`, `product_cost`, `product_vat`, `product_created_date`, `product_created_by`, `product_modified_date`, `product_modified_by`) VALUES
(1, '1234', 'Nescafe', 2.5, 6, '2019-04-13 20:32:26', 0, NULL, 0),
(4, '1235', 'Dove', 4.25, 6, '2019-04-13 20:45:20', 0, NULL, 0),
(5, '1236', 'Orange', 3.2, 6, '2019-04-13 21:12:35', 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `oc_receipts`
--

CREATE TABLE `oc_receipts` (
  `receipt_id` mediumint(5) NOT NULL,
  `receipt_code` varchar(250) NOT NULL,
  `receipt_products` longtext,
  `receipt_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-pending,1-finish',
  `receipt_created_by` mediumint(5) NOT NULL DEFAULT '0',
  `receipt_created_date` datetime DEFAULT NULL,
  `receipt_modified_by` mediumint(5) NOT NULL DEFAULT '0',
  `receipt_modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oc_receipts`
--

INSERT INTO `oc_receipts` (`receipt_id`, `receipt_code`, `receipt_products`, `receipt_status`, `receipt_created_by`, `receipt_created_date`, `receipt_modified_by`, `receipt_modified_date`) VALUES
(1, '123', 'a:6:{i:0;a:6:{s:10:"product_id";s:1:"4";s:15:"product_barcode";s:4:"1235";s:12:"product_name";s:4:"Dove";s:12:"product_cost";s:4:"4.25";s:11:"product_vat";s:1:"6";s:12:"product_time";s:19:"2019-04-13 22:02:31";}i:1;a:6:{s:10:"product_id";s:1:"1";s:15:"product_barcode";s:4:"1234";s:12:"product_name";s:7:"Nescafe";s:12:"product_cost";s:3:"2.5";s:11:"product_vat";s:1:"6";s:12:"product_time";s:19:"2019-04-13 22:02:34";}i:2;a:6:{s:10:"product_id";s:1:"1";s:15:"product_barcode";s:4:"1234";s:12:"product_name";s:7:"Nescafe";s:12:"product_cost";s:3:"2.5";s:11:"product_vat";s:1:"6";s:12:"product_time";s:19:"2019-04-13 22:02:38";}i:3;a:6:{s:10:"product_id";s:1:"1";s:15:"product_barcode";s:4:"1234";s:12:"product_name";s:7:"Nescafe";s:12:"product_cost";s:3:"2.5";s:11:"product_vat";s:1:"6";s:12:"product_time";s:19:"2019-04-13 22:04:47";}i:4;a:6:{s:10:"product_id";s:1:"1";s:15:"product_barcode";s:4:"1234";s:12:"product_name";s:7:"Nescafe";s:12:"product_cost";s:1:"3";s:11:"product_vat";s:1:"6";s:12:"product_time";s:19:"2019-04-13 22:04:56";}i:5;a:6:{s:10:"product_id";s:1:"1";s:15:"product_barcode";s:4:"1234";s:12:"product_name";s:7:"Nescafe";s:12:"product_cost";s:3:"2.5";s:11:"product_vat";s:1:"6";s:12:"product_time";s:19:"2019-04-14 00:38:59";}}', 1, 0, NULL, 0, '2019-04-14 00:38:59'),
(3, '124', 'a:1:{i:0;a:6:{s:10:"product_id";s:1:"1";s:15:"product_barcode";s:4:"1234";s:12:"product_name";s:7:"Nescafe";s:12:"product_cost";s:3:"2.5";s:11:"product_vat";s:1:"6";s:12:"product_time";s:19:"2019-04-13 22:43:08";}}', 0, 0, NULL, 0, '2019-04-13 22:43:08'),
(4, '125', 'a:3:{i:0;a:6:{s:10:"product_id";s:1:"1";s:15:"product_barcode";s:4:"1234";s:12:"product_name";s:7:"Nescafe";s:12:"product_cost";s:3:"2.5";s:11:"product_vat";s:1:"6";s:12:"product_time";s:19:"2019-04-14 00:39:57";}i:2;a:6:{s:10:"product_id";s:1:"1";s:15:"product_barcode";s:4:"1234";s:12:"product_name";s:7:"Nescafe";s:12:"product_cost";s:3:"2.5";s:11:"product_vat";s:1:"6";s:12:"product_time";s:19:"2019-04-14 00:40:04";}i:3;a:6:{s:10:"product_id";s:1:"1";s:15:"product_barcode";s:4:"1234";s:12:"product_name";s:7:"Nescafe";s:12:"product_cost";s:3:"2.5";s:11:"product_vat";s:1:"6";s:12:"product_time";s:19:"2019-04-14 00:40:08";}}', 1, 0, '2019-04-14 00:39:33', 0, '2019-04-14 01:38:56');

-- --------------------------------------------------------

--
-- Table structure for table `oc_users`
--

CREATE TABLE `oc_users` (
  `user_id` mediumint(5) NOT NULL,
  `user_name` varchar(250) DEFAULT NULL,
  `user_password` varchar(250) DEFAULT NULL,
  `user_fname` varchar(250) DEFAULT NULL,
  `user_lname` varchar(250) DEFAULT NULL,
  `user_role_id` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1-admin/2-cashier',
  `user_email` varchar(100) DEFAULT NULL,
  `user_contact` varchar(100) DEFAULT NULL,
  `user_registered_date` date DEFAULT NULL,
  `user_created_date` datetime DEFAULT NULL,
  `user_created_by` mediumint(9) NOT NULL DEFAULT '0',
  `user_modified_date` datetime DEFAULT NULL,
  `user_modified_by` mediumint(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oc_users`
--

INSERT INTO `oc_users` (`user_id`, `user_name`, `user_password`, `user_fname`, `user_lname`, `user_role_id`, `user_email`, `user_contact`, `user_registered_date`, `user_created_date`, `user_created_by`, `user_modified_date`, `user_modified_by`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Adam', 'Smith', 1, 'admin@yahoo.com', '+971 400 0000', '2019-04-14', NULL, 0, NULL, 0),
(2, 'cashier', '6ac2470ed8ccf204fd5ff89b32a355cf', 'Cashier', 'Samuel', 2, 'cashier@yahoo.com', '+971 400 0000', '2019-04-14', NULL, 0, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `oc_products`
--
ALTER TABLE `oc_products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_barcode` (`product_barcode`);

--
-- Indexes for table `oc_receipts`
--
ALTER TABLE `oc_receipts`
  ADD PRIMARY KEY (`receipt_id`),
  ADD UNIQUE KEY `receipt_code` (`receipt_code`);

--
-- Indexes for table `oc_users`
--
ALTER TABLE `oc_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `oc_products`
--
ALTER TABLE `oc_products`
  MODIFY `product_id` mediumint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `oc_receipts`
--
ALTER TABLE `oc_receipts`
  MODIFY `receipt_id` mediumint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `oc_users`
--
ALTER TABLE `oc_users`
  MODIFY `user_id` mediumint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

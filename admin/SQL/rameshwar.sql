-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2025 at 11:01 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rameshwar`
--

-- --------------------------------------------------------

--
-- Table structure for table `challan`
--

CREATE TABLE `challan` (
  `challan_id` int(11) NOT NULL,
  `challan_no` varchar(50) NOT NULL,
  `challan_date` date NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `po_no` varchar(50) DEFAULT NULL,
  `po_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `challan`
--

INSERT INTO `challan` (`challan_id`, `challan_no`, `challan_date`, `customer_id`, `po_no`, `po_date`) VALUES
(1, '1', '2025-06-03', 2, '12', '2025-06-06'),
(2, '1', '2025-06-03', 2, '12', '2025-06-06'),
(3, '2', '2025-06-04', 2, '34', '2025-06-13'),
(4, '1', '2025-06-13', 2, '2', '2025-06-19');

-- --------------------------------------------------------

--
-- Table structure for table `challan_items`
--

CREATE TABLE `challan_items` (
  `item_id` int(11) NOT NULL,
  `challan_id` int(11) DEFAULT NULL,
  `particulars` text DEFAULT NULL,
  `qty` varchar(50) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `challan_items`
--

INSERT INTO `challan_items` (`item_id`, `challan_id`, `particulars`, `qty`, `rate`) VALUES
(1, 1, 'aaa', '12', '13.60'),
(2, 2, 'aaa', '12.5', '13.60'),
(3, 3, 'xdw', '123', '23.00'),
(4, 4, 'saw2', 'fr', '12.50');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `Customer_ID` int(11) NOT NULL,
  `Customer_name` varchar(100) NOT NULL,
  `Customer_address` text DEFAULT NULL,
  `GST_in` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Customer_ID`, `Customer_name`, `Customer_address`, `GST_in`) VALUES
(2, 'neel store 123', 'R1 to R4, R7, Q5 to Q9, Sayan Textile Park Ichhapor, Hazira Road, Surat', '24AAHCN5519P1ZZ'),
(3, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `invoice_date` date DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `sale_type` enum('State','Interstate') DEFAULT NULL,
  `hsn_code` varchar(20) DEFAULT NULL,
  `cgst` decimal(10,2) DEFAULT NULL,
  `sgst` decimal(10,2) DEFAULT NULL,
  `igst` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `round_off` decimal(10,2) DEFAULT NULL,
  `final_amount` decimal(10,2) DEFAULT NULL,
  `amount_in_words` text DEFAULT NULL,
  `cgst_rate` decimal(5,2) DEFAULT 0.00,
  `sgst_rate` decimal(5,2) DEFAULT 0.00,
  `igst_rate` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `invoice_no`, `invoice_date`, `customer_id`, `sale_type`, `hsn_code`, `cgst`, `sgst`, `igst`, `total_amount`, `round_off`, `final_amount`, `amount_in_words`, `cgst_rate`, `sgst_rate`, `igst_rate`) VALUES
(24, '56', '2025-05-31', 2, 'State', '998821', '2.50', '2.50', '2.50', '464436.00', '0.00', '464436.00', 'Rupees Four Lakh Sixty Four Thousand Four Hundred and Thirty Six Only', '2.50', '2.50', '2.50'),
(25, '9', '2025-05-31', 2, 'State', '998821', '2.50', '2.50', '2.50', '522490.50', '0.50', '522491.00', 'Rupees Five Lakh Twenty Two Thousand Four Hundred and Ninety One Only', '2.50', '2.50', '2.50'),
(26, '10', '2025-05-31', 2, 'State', '998821', '12440.25', '12440.25', '0.00', '522490.50', '0.50', '522491.00', 'Rupees Five Lakh Twenty Two Thousand Four Hundred and Ninety One Only', '0.00', '0.00', '0.00'),
(31, '56', '2025-05-17', 2, 'State', '998821', '2.50', '2.50', '5.00', '297381.00', '0.00', '297381.00', 'Rupees Two Lakh Ninety Seven Thousand Three Hundred and Eighty One Only', '2.50', '2.50', '2.50'),
(32, '32', '2025-05-31', 2, 'State', '998821', '7930.13', '7930.13', '0.00', '333065.25', '-0.25', '333065.00', 'Rupees Three Lakh Thirty Three Thousand and Sixty Five Only', '2.50', '2.50', '5.00'),
(33, '55', '2025-06-07', 2, 'State', '998821', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '2.50', '2.50', '5.00'),
(34, '100', '2025-06-27', 2, 'State', '998821', '2450.00', '2450.00', '0.00', '102900.00', '0.00', '102900.00', 'Rupees One Lakh Two Thousand Nine Hundred Only', '2.50', '2.50', '5.00'),
(35, '16', '0000-00-00', 2, 'State', '998821', '35.36', '35.36', '0.00', '1485.22', '-0.22', '1485.00', 'Rupees One Thousand Four Hundred and Eighty Five Only', '2.50', '2.50', '5.00'),
(36, '17', '2025-06-05', 2, 'State', '998821', '3.45', '3.45', '0.00', '144.90', '0.10', '145.00', 'Rupees One Hundred and Forty Five Only', '2.50', '2.50', '5.00'),
(37, '1234', '2025-06-07', 2, 'State', '998821', '1066.40', '1066.40', '0.00', '44788.80', '0.20', '44789.00', 'Rupees Forty Four Thousand Seven Hundred and Eighty Nine Only', '2.50', '2.50', '5.00'),
(38, 'fb', '0000-00-00', 2, 'State', '998821', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '2.50', '2.50', '5.00');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `item_id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `qty` varchar(50) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `discount` decimal(5,2) DEFAULT NULL,
  `net_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`item_id`, `invoice_id`, `product_name`, `qty`, `rate`, `amount`, `discount`, `net_amount`) VALUES
(15, 24, 'D. NO. 81047 C PALLU ', '582', '800.00', '465600.00', '5.00', '442320.00'),
(16, 24, 'PINK - 118', '0', '0.00', '0.00', '0.00', '0.00'),
(17, 24, 'YELLOW - 122', '0', '0.00', '0.00', '0.00', '0.00'),
(18, 25, 'D. NO. 81047 C PALLU ', '582', '900.00', '523800.00', '5.00', '497610.00'),
(19, 26, 'D. NO. 81047 C PALLU ', '582', '900.00', '523800.00', '5.00', '497610.00'),
(20, 26, 'newww', '0', '0.00', '0.00', '0.00', '0.00'),
(26, 31, 'aa', '578', '500.00', '289000.00', '2.00', '283220.00'),
(27, 32, 'D. NO. 81047 C PALLU  PINK - 118 YELLOW - 122 FIROJI - 119 GREY - 118', '477', '700.00', '333900.00', '5.00', '317205.00'),
(28, 32, 'One new', '0', '0.00', '0.00', '0.00', '0.00'),
(29, 33, 'D. NO. 81047 C PALLU\r\nPINK - 118\r\nYELLOW - 122\r\nFIROJI - 119\r\nGREY - 11', '0', '0.00', '0.00', '0.00', '0.00'),
(30, 34, 'abc\r\nnhj', '200', '500.00', '100000.00', '2.00', '98000.00'),
(32, 35, 'adsc', '123', '11.50', '1414.50', '0.00', '1414.50'),
(33, 36, 'qawq', '12 mtr', '11.50', '138.00', '0.00', '138.00'),
(34, 37, 'fedxfe4', '124', '344.00', '42656.00', '0.00', '42656.00'),
(35, 38, 'fbc', '14.5', '0.00', '0.00', '0.00', '0.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `challan`
--
ALTER TABLE `challan`
  ADD PRIMARY KEY (`challan_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `challan_items`
--
ALTER TABLE `challan_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `challan_id` (`challan_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Customer_ID`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `invoice_ibfk_1` (`customer_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `challan`
--
ALTER TABLE `challan`
  MODIFY `challan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `challan_items`
--
ALTER TABLE `challan_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `Customer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `challan`
--
ALTER TABLE `challan`
  ADD CONSTRAINT `challan_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`Customer_ID`) ON DELETE CASCADE;

--
-- Constraints for table `challan_items`
--
ALTER TABLE `challan_items`
  ADD CONSTRAINT `challan_items_ibfk_1` FOREIGN KEY (`challan_id`) REFERENCES `challan` (`challan_id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`Customer_ID`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`invoice_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

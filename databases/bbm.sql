-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2019 at 05:12 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bbm`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_setCustomVal` (`sSeqName` VARCHAR(50), `sSeqGroup` VARCHAR(10), `nVal` INT UNSIGNED)  BEGIN
    IF (SELECT COUNT(*) FROM _sequence  
            WHERE seq_name = sSeqName  
                AND seq_group = sSeqGroup) = 0 THEN
        INSERT INTO _sequence (seq_name,seq_group,seq_val)
        VALUES (sSeqName,sSeqGroup,nVal);
    ELSE
        UPDATE _sequence SET seq_val = nVal
        WHERE seq_name = sSeqName AND seq_group = sSeqGroup;
    END IF;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `getNextCustomSeq` (`sSeqName` VARCHAR(50), `sSeqGroup` VARCHAR(10)) RETURNS VARCHAR(200) CHARSET latin1 BEGIN
    DECLARE nLast_val INT; 
    DECLARE nLast_Year INT; 
    DECLARE nYear INT; 
 
    SET nLast_val =  (SELECT seq_val 
                          FROM _sequence
                          WHERE seq_name = sSeqName
                                AND seq_group = sSeqGroup);
	SET nLast_Year =  (SELECT seq_year 
                          FROM _sequence
                          WHERE seq_name = sSeqName
                                AND seq_group = sSeqGroup);
    IF nLast_val IS NULL THEN
        SET nLast_val = 1;
        INSERT INTO _sequence (seq_name,seq_group,seq_val)
        VALUES (sSeqName,sSeqGroup,nLast_Val);
    ELSE
        SET nLast_val = nLast_val + 1;
        UPDATE _sequence SET seq_val = nLast_val
        WHERE seq_name = sSeqName AND seq_group = sSeqGroup;
    END IF; 
 	SET nYear = (SELECT YEAR(CURDATE()) );
    
    IF nLast_Year IS NOT NULL THEN
        IF nYear != nLast_Year THEN
            SET nLast_val = 1;
            SET nLast_Year = nYear;
            UPDATE _sequence SET seq_val = nLast_val, seq_year = nLast_Year
            WHERE seq_name = sSeqName AND seq_group = sSeqGroup;    
        END IF;
    ELSE
        SET nLast_Year = nYear;
        UPDATE _sequence SET seq_year = nLast_Year
        WHERE seq_name = sSeqName AND seq_group = sSeqGroup;
    END IF;
    
    SET @ret = (SELECT concat(sSeqGroup,'_',nLast_Year,'_',lpad(nLast_val,6,'0')));
    RETURN @ret;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `car`
--

CREATE TABLE `car` (
  `id` int(10) UNSIGNED NOT NULL,
  `plat_number` varchar(20) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `capacity` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `car`
--

INSERT INTO `car` (`id`, `plat_number`, `brand`, `capacity`) VALUES
(6, 'DT 1111 AS', 'pertamina A', 8000),
(7, 'DT 2222 QE', 'pertamina B', 16000),
(8, 'DT 3333 KJ', 'pertamina C', 24000),
(9, 'DT 4444 NB', 'pertamina D', 32000),
(10, 'DT 5555 SD', 'pertamina E', 40000);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `npwp` varchar(200) NOT NULL,
  `situ` varchar(200) NOT NULL,
  `siup` varchar(200) NOT NULL,
  `tdo` varchar(200) NOT NULL,
  `tdp` varchar(200) NOT NULL,
  `business_fields` varchar(200) NOT NULL,
  `pph` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `user_id`, `name`, `address`, `npwp`, `situ`, `siup`, `tdo`, `tdp`, `business_fields`, `pph`) VALUES
(3, 23, 'PT madukubah', 'jln mutiara no 8', '1234087', '123470', '124', '123709', '871239870', '123912', 0.003);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_address`
--

CREATE TABLE `delivery_address` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  `postal_code` varchar(200) NOT NULL,
  `province` varchar(200) NOT NULL,
  `company_id` int(11) UNSIGNED NOT NULL,
  `pbbkb` float UNSIGNED NOT NULL,
  `discount` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_address`
--

INSERT INTO `delivery_address` (`id`, `code`, `name`, `city`, `postal_code`, `province`, `company_id`, `pbbkb`, `discount`) VALUES
(2, '11111', 'jln tipulu', 'kendari', '93126', 'sulawesi tenggara', 3, 0.0129, 0.1),
(3, '11112', 'jln tapak kuda', 'kendari', '93126', 'sulawesi tenggara', 3, 0.0675, 0.2);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_order`
--

CREATE TABLE `delivery_order` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(100) NOT NULL,
  `purchase_order_id` int(10) UNSIGNED NOT NULL,
  `car_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `create_date` int(10) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL,
  `trip` varchar(20) NOT NULL,
  `travel_cost` double UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_order`
--

INSERT INTO `delivery_order` (`id`, `code`, `purchase_order_id`, `car_id`, `quantity`, `user_id`, `create_date`, `status`, `trip`, `travel_cost`) VALUES
(1, 'DO_2019_000017', 5, 8, 20000, 18, 1559372320, 2, 'Pertamina', 50000),
(2, 'DO_2019_000018', 6, 10, 40000, 18, 1559424096, 2, 'Pertamina', 100000),
(3, 'DO_2019_000019', 7, 8, 20000, 18, 1559426092, 2, 'Pertamina', 50000),
(4, 'DO_2019_000020', 8, 7, 10000, 19, 1559451404, 2, 'Pertamina', 50000);

--
-- Triggers `delivery_order`
--
DELIMITER $$
CREATE TRIGGER `delivery_order_bi` BEFORE INSERT ON `delivery_order` FOR EACH ROW BEGIN
	SET NEW.code = getNextCustomSeq("delivery_order", "DO");
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `do_log`
--

CREATE TABLE `do_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `delivery_order_id` int(10) UNSIGNED NOT NULL,
  `flag` int(11) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `do_log`
--

INSERT INTO `do_log` (`id`, `delivery_order_id`, `flag`, `date`) VALUES
(1, 1, 1, 1559372561),
(2, 1, 2, 1559372563),
(3, 1, 3, 1559373338),
(4, 2, 1, 1559424119),
(5, 2, 2, 1559424121),
(6, 2, 3, 1559424138),
(7, 3, 1, 1559426115),
(8, 3, 2, 1559426118),
(9, 3, 3, 1559426135),
(10, 4, 1, 1559451440),
(11, 4, 2, 1559451451),
(12, 4, 3, 1559451476);

-- --------------------------------------------------------

--
-- Table structure for table `do_news_and_tax`
--

CREATE TABLE `do_news_and_tax` (
  `id` int(10) UNSIGNED NOT NULL,
  `delivery_order_id` int(10) UNSIGNED NOT NULL,
  `news` text NOT NULL,
  `tax_factor` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `do_news_and_tax`
--

INSERT INTO `do_news_and_tax` (`id`, `delivery_order_id`, `news`, `tax_factor`) VALUES
(4, 3, 'NEWS_DO_2019_000019_1559546269.pdf', 'TAX_DO_2019_000019_1559546269.pdf'),
(5, 1, 'NEWS_DO_2019_000017_1559547704.pdf', 'TAX_DO_2019_000017_1559547704.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `do_report`
--

CREATE TABLE `do_report` (
  `id` int(10) UNSIGNED NOT NULL,
  `delivery_order_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `temperature` varchar(20) NOT NULL,
  `tank_condition` varchar(200) NOT NULL,
  `quality` varchar(50) NOT NULL,
  `information` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `do_report`
--

INSERT INTO `do_report` (`id`, `delivery_order_id`, `quantity`, `temperature`, `tank_condition`, `quality`, `information`) VALUES
(1, 1, 20000, '30', 'Penutup Atas dan atau Bawah Tersegel', 'Baik', 'Tidak Terkontaminasi'),
(2, 2, 39500, '30', 'Penutup Atas dan atau Bawah Tersegel', 'Baik', 'Tidak Terkontaminasi'),
(3, 3, 19000, '32', 'Penutup Atas dan atau Bawah Tersegel', 'Baik', 'Tidak Terkontaminasi'),
(4, 4, 10000, '30', 'Penutup Atas dan atau Bawah Tersegel', 'Baik', 'Tidak Terkontaminasi');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'customers', 'General User'),
(3, 'driver', 'driver');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(100) NOT NULL,
  `purchase_order_id` int(10) UNSIGNED NOT NULL,
  `price` float UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `sub_total` float UNSIGNED NOT NULL,
  `ppn` float UNSIGNED NOT NULL,
  `pph` float UNSIGNED NOT NULL,
  `pbbkb` float UNSIGNED NOT NULL,
  `total` double UNSIGNED NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `code`, `purchase_order_id`, `price`, `quantity`, `date`, `sub_total`, `ppn`, `pph`, `pbbkb`, `total`, `status`) VALUES
(1, 'INVOICE_2019_000016', 5, 9000, 20000, 1559374944, 180000000, 18000000, 0, 2322000, 200322000, 2),
(2, 'INVOICE_2019_000017', 6, 9000, 39500, 1559424174, 355500000, 35550000, 1066500, 4585950, 396702450, 2),
(3, 'INVOICE_2019_000018', 7, 8000, 19000, 1559426155, 152000000, 15200000, 456000, 10260000, 177916000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `price_1` float UNSIGNED NOT NULL,
  `price_2` float UNSIGNED NOT NULL,
  `unit` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`id`, `product_id`, `name`, `price_1`, `price_2`, `unit`) VALUES
(8, 3, 'Premium', 10000, 11000, 'liter');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`) VALUES
(3, 'bahan bakar minyak', 'bahan bakar minyak');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(100) NOT NULL,
  `vendor_id` int(10) UNSIGNED NOT NULL,
  `material_id` int(10) UNSIGNED NOT NULL,
  `delivery_address_id` int(10) UNSIGNED NOT NULL,
  `price` float UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `sub_total` float UNSIGNED NOT NULL,
  `ppn` float UNSIGNED NOT NULL,
  `pph` float UNSIGNED NOT NULL,
  `pbbkb` float UNSIGNED NOT NULL,
  `total` double UNSIGNED NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_order`
--

INSERT INTO `purchase_order` (`id`, `code`, `vendor_id`, `material_id`, `delivery_address_id`, `price`, `quantity`, `date`, `sub_total`, `ppn`, `pph`, `pbbkb`, `total`, `status`) VALUES
(5, 'PO_2019_000016', 1, 8, 2, 9900, 20000, 1559200918, 198000000, 19800000, 0, 2554200, 220354200, 2),
(6, 'PO_2019_000017', 1, 8, 2, 9900, 40000, 1559308677, 396000000, 39600000, 0, 5108400, 440708400, 2),
(7, 'PO_2019_000018', 1, 8, 3, 8000, 20000, 1559426062, 160000000, 16000000, 480000, 10800000, 187280000, 2),
(8, 'PO_2019_000019', 2, 8, 3, 8000, 10000, 1559426249, 80000000, 8000000, 240000, 5400000, 93640000, 2);

--
-- Triggers `purchase_order`
--
DELIMITER $$
CREATE TRIGGER `purchase_order_ci` BEFORE INSERT ON `purchase_order` FOR EACH ROW BEGIN
	SET NEW.code =	getNextCustomSeq("purchase_order", "PO");
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `image` text NOT NULL,
  `address` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `phone`, `image`, `address`) VALUES
(1, '127.0.0.1', 'admin', '$2y$12$qDOWoHGT36XJXrbRexNNreZCKWqDcqiIbpNb3yxgxIzlnMEACZwcm', 'admin@admin.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1559636515, 1, 'alan', 'madukubah', '081342989185', 'USER_1_1557662206.jpg', 'jln mutiara no 8'),
(18, '::1', 'DRV_1', '$2y$10$51nmMUyOHw/bsXeHv66xqexSQdyq7NrdwRMzccA5X9j0YqmZUI9Te', 'driver@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1558525437, 1559451350, 1, 'Driver A', 'Driver A', '098712346543', 'USER_18_1559202064.jpg', 'alamat'),
(19, '::1', 'DRV_2', '$2y$10$SrLctPAt8n/yLNyyGBJso.U.9SYR6f9ACSqS5fgz5yRRDKT6GmdKm', 'a@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1558527551, 1559451420, 1, 'Alun', 'madukubah', '012334569687', 'USER_19_1558529038.jpg', 'jln tipulu'),
(20, '::1', 'DRV_3', '$2y$10$XKE9sPXBfAntCdfyTQzeBuBQwHYI4Adni2n4Jkn35i8qDO890mR6K', 'xyz@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1558527681, NULL, 1, 'alin', 'xyz', '087919284930', '', 'jln mandonga'),
(23, '::1', '1111', '$2y$10$MIAB3hUgEry4TeyfGL93heZr6mO2QJDBAf7Kve1aFKAzzqvtBXxde', 'alan@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1559200026, 1559595604, 1, '1', '1', '1', 'USER_23_1559201932.jpg', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(29, 18, 3),
(30, 19, 3),
(31, 20, 3),
(34, 23, 2);

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `phone_2` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `bank_account` varchar(50) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `bank_branch` varchar(100) NOT NULL,
  `swift_code` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `name`, `address`, `phone`, `phone_2`, `description`, `bank_account`, `bank_name`, `bank_branch`, `swift_code`, `email`) VALUES
(1, 'PT Harum Bumi Mandiri', 'Jln Ronga III No.87', '0401-3123003', '53588061', 'PT harum bumi mandiri', '900-1234-1232-4', 'BRI', 'kendari', '1231', 'pcc@harumbumimandiri.com'),
(2, 'PT. Energi Nusantara Mandiri', 'Jln Pembangunan Komp TPPI Kendari', '0401-312-3922', '0812-4229-7683', 'Energi Nusantara Mandiri', '230-00-123465-9', 'Mandiri', 'kendari', '3123', 'energinusantaramandiri@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `_sequence`
--

CREATE TABLE `_sequence` (
  `seq_name` varchar(50) NOT NULL,
  `seq_group` varchar(10) NOT NULL,
  `seq_year` int(11) NOT NULL,
  `seq_val` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_sequence`
--

INSERT INTO `_sequence` (`seq_name`, `seq_group`, `seq_year`, `seq_val`) VALUES
('delivery_order', 'DO', 2019, 20),
('purchase_order', 'PO', 2019, 19);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`user_id`);

--
-- Indexes for table `delivery_address`
--
ALTER TABLE `delivery_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_address_ibfk_1` (`company_id`);

--
-- Indexes for table `delivery_order`
--
ALTER TABLE `delivery_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_id` (`purchase_order_id`);

--
-- Indexes for table `do_log`
--
ALTER TABLE `do_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `do_news_and_tax`
--
ALTER TABLE `do_news_and_tax`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_order_id` (`delivery_order_id`);

--
-- Indexes for table `do_report`
--
ALTER TABLE `do_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_order_id` (`purchase_order_id`),
  ADD KEY `delivery_address_id` (`purchase_order_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_id` (`material_id`),
  ADD KEY `vendor_id` (`vendor_id`),
  ADD KEY `delivery_address_id` (`delivery_address_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `_sequence`
--
ALTER TABLE `_sequence`
  ADD PRIMARY KEY (`seq_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `car`
--
ALTER TABLE `car`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `delivery_address`
--
ALTER TABLE `delivery_address`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `delivery_order`
--
ALTER TABLE `delivery_order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `do_log`
--
ALTER TABLE `do_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `do_news_and_tax`
--
ALTER TABLE `do_news_and_tax`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `do_report`
--
ALTER TABLE `do_report`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchase_order`
--
ALTER TABLE `purchase_order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `delivery_address`
--
ALTER TABLE `delivery_address`
  ADD CONSTRAINT `delivery_address_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`);

--
-- Constraints for table `delivery_order`
--
ALTER TABLE `delivery_order`
  ADD CONSTRAINT `delivery_order_ibfk_1` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_order` (`id`);

--
-- Constraints for table `do_news_and_tax`
--
ALTER TABLE `do_news_and_tax`
  ADD CONSTRAINT `do_news_and_tax_ibfk_1` FOREIGN KEY (`delivery_order_id`) REFERENCES `delivery_order` (`id`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_order` (`id`);

--
-- Constraints for table `material`
--
ALTER TABLE `material`
  ADD CONSTRAINT `material_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD CONSTRAINT `purchase_order_ibfk_1` FOREIGN KEY (`material_id`) REFERENCES `material` (`id`),
  ADD CONSTRAINT `purchase_order_ibfk_2` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`),
  ADD CONSTRAINT `purchase_order_ibfk_3` FOREIGN KEY (`delivery_address_id`) REFERENCES `delivery_address` (`id`);

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

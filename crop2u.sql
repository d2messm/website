		-- phpMyAdmin SQL Dump
		-- version 4.5.1
		-- http://www.phpmyadmin.net
		--
		-- Host: 127.0.0.1
		-- Generation Time: Apr 22, 2018 at 05:43 PM
		-- Server version: 10.1.13-MariaDB
		-- PHP Version: 7.0.8

		SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
		SET time_zone = "+00:00";


		/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
		/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
		/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
		/*!40101 SET NAMES utf8mb4 */;

		--
		-- Database: `crop2u`
		--

		-- --------------------------------------------------------

		--
		-- Table structure for table `admin`
		--

		CREATE TABLE `admin` (
		  `admin_id` int(11) UNSIGNED NOT NULL,
		  `ref_user_id` int(11) UNSIGNED NOT NULL,
		  `name` varchar(50) NOT NULL,
		  `mobile` bigint(20) UNSIGNED NOT NULL,
		  `email` varchar(50) DEFAULT NULL,
		  `address` varchar(500) NOT NULL,
		  `gender` char(1) NOT NULL,
		  `dob` date NOT NULL,
		  `ref_company_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
		  `added_by` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'employee parent id',
		  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		--
		-- Dumping data for table `admin`
		--

		INSERT INTO `admin` (`admin_id`, `ref_user_id`, `name`, `mobile`, `email`, `address`, `gender`, `dob`, `ref_company_id`, `added_by`, `timestamp`) VALUES
		(1, 1, 'admin admin', 1212123454, 'chandan@gmail.com', 'Koeria Greater Noida', 'm', '2018-03-05', 1, 0, '2018-03-25 13:20:07');

		-- --------------------------------------------------------

		--
		-- Table structure for table `associate_partner`
		--

		CREATE TABLE `associate_partner` (
		  `assoc_id` int(11) UNSIGNED NOT NULL,
		  `ref_user_id` int(11) NOT NULL,
		  `name` varchar(50) NOT NULL,
		  `mobile` bigint(15) NOT NULL DEFAULT '0',
		  `email` varchar(100) NOT NULL DEFAULT 'not defined',
		  `is_company` tinyint(3) NOT NULL DEFAULT '0',
		  `ref_company_id` tinyint(3) NOT NULL DEFAULT '0',
		  `document_no` varchar(50) NOT NULL DEFAULT '0' COMMENT '# seperated parallel to document',
		  `document_name` varchar(500) NOT NULL DEFAULT '0' COMMENT '# seperated parallel to identification',
		  `document_url` varchar(500) NOT NULL DEFAULT '0' COMMENT '# seperated',
		  `status` tinyint(3) NOT NULL DEFAULT '1',
		  `address` varchar(500) NOT NULL DEFAULT 'NULL',
		  `gender` char(1) NOT NULL,
		  `dob` date NOT NULL DEFAULT '0000-00-00',
		  `added_by` int(11) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		--
		-- Dumping data for table `associate_partner`
		--

		INSERT INTO `associate_partner` (`assoc_id`, `ref_user_id`, `name`, `mobile`, `email`, `is_company`, `ref_company_id`, `document_no`, `document_name`, `document_url`, `status`, `address`, `gender`, `dob`, `added_by`) VALUES
		(1, 117, 'salman khan bhai', 3838383838, 'admin@123.com', 0, 0, '12 # 132', 'qw # 234', '3008.jpg # 4157.jpg', 0, 'greate noida', 'f', '1212-12-12', 1),
		(4, 122, 'admin name', 3838383838, 'admin@123.com', 0, 22, '12`', 'chandan', '3008.jpg', 0, 'greate noida', 'm', '1212-12-12', 1);

		-- --------------------------------------------------------

		--
		-- Table structure for table `company`
		--

		CREATE TABLE `company` (
		  `company_id` int(11) UNSIGNED NOT NULL,
		  `company_name` varchar(150) NOT NULL,
		  `company_logo_url` varchar(100) DEFAULT NULL,
		  `company_address` varchar(150) DEFAULT NULL,
		  `company_phone` bigint(20) UNSIGNED NOT NULL,
		  `company_state` varchar(50) DEFAULT NULL,
		  `company_country` varchar(50) DEFAULT NULL,
		  `gstin` varchar(20) DEFAULT NULL,
		  `tin_no` bigint(20) UNSIGNED DEFAULT NULL,
		  `pan_no` varchar(15) DEFAULT NULL,
		  `added_by` int(11) NOT NULL,
		  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		--
		-- Dumping data for table `company`
		--

		INSERT INTO `company` (`company_id`, `company_name`, `company_logo_url`, `company_address`, `company_phone`, `company_state`, `company_country`, `gstin`, `tin_no`, `pan_no`, `added_by`, `timestamp`) VALUES
		(1, 'bsrnetwork', 'abc.jpg', 'Greate noida', 323234543, 'Kerla', 'India', 'KJK43544KL', 234345454, 'CXCDE324334', 1, '2018-03-23 17:44:41'),
		(22, 'Bs', 'shoks.jpeg', 'Greate noida', 323234543, 'Kerla', 'India', 'KJK43544KL', 234345454, 'CXCDE324334', 1, '2018-04-06 13:39:35'),
		(25, 'Bs', '', 'Greate noida', 323234543, 'Kerla', 'India', '234345454', 0, 'CXCDE324334', 1, '2018-04-10 17:53:38'),
		(26, 'hello company', '', 'Greater NOida', 4848484848484, 'up', 'India', '1112394959', 0, 'FFR84ddr', 1, '2018-04-12 21:17:41'),
		(27, 'new company 1', '', 'greate noida', 11112123454, 'mp', 'india', '112344583423', 184467440737095, 'ssqwessd', 1, '2018-04-13 20:08:47');

		-- --------------------------------------------------------

		--
		-- Table structure for table `customers`
		--

		CREATE TABLE `customers` (
		  `customer_id` int(10) NOT NULL,
		  `organisation_or_person` varchar(255) DEFAULT NULL,
		  `orgabisation_name` varchar(255) DEFAULT NULL,
		  `gender` char(45) DEFAULT NULL,
		  `first_name` varchar(25) DEFAULT NULL,
		  `middle_initial` varchar(25) DEFAULT NULL,
		  `last_name` varchar(25) DEFAULT NULL,
		  `email_address` varchar(50) DEFAULT NULL,
		  `login_name` varchar(16) DEFAULT NULL,
		  `login_password` varchar(50) DEFAULT NULL,
		  `phone_number` varchar(20) DEFAULT NULL,
		  `address_line_1` varchar(50) DEFAULT NULL,
		  `address_line_2` varchar(50) DEFAULT NULL,
		  `address_line_3` varchar(50) DEFAULT NULL,
		  `address_line_4` varchar(50) DEFAULT NULL,
		  `town_city` varchar(50) DEFAULT NULL,
		  `country` varchar(50) DEFAULT NULL,
		  `added_by` int(10) DEFAULT NULL,
		  `status` time DEFAULT NULL,
		  `timestamp` datetime DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		-- --------------------------------------------------------

		--
		-- Table structure for table `department`
		--

		CREATE TABLE `department` (
		  `department_id` bigint(11) NOT NULL,
		  `department_name` varchar(100) NOT NULL,
		  `department_code` varchar(100) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		--
		-- Dumping data for table `department`
		--

		INSERT INTO `department` (`department_id`, `department_name`, `department_code`) VALUES
		(1, 'Human Resource', 'HR'),
		(2, 'Project Manager', 'PM'),
		(3, 'COMPUTER SCIENCE', 'CSE');

		-- --------------------------------------------------------

		--
		-- Table structure for table `designation`
		--

		CREATE TABLE `designation` (
		  `designation_id` int(10) NOT NULL,
		  `designation_name` varchar(200) NOT NULL,
		  `designation_code` varchar(200) NOT NULL,
		  `basic_pay` float NOT NULL DEFAULT '0',
		  `pf_deduction` int(4) NOT NULL DEFAULT '0',
		  `esi_deduction` int(4) NOT NULL DEFAULT '0',
		  `other_deduction` int(4) NOT NULL DEFAULT '0',
		  `cl` int(3) NOT NULL DEFAULT '0',
		  `sl` int(3) NOT NULL DEFAULT '0',
		  `el` int(3) NOT NULL DEFAULT '0',
		  `other_leave` int(3) NOT NULL DEFAULT '0'
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		--
		-- Dumping data for table `designation`
		--

		INSERT INTO `designation` (`designation_id`, `designation_name`, `designation_code`, `basic_pay`, `pf_deduction`, `esi_deduction`, `other_deduction`, `cl`, `sl`, `el`, `other_leave`) VALUES
		(1, 'Project Manager', 'PM', 100000, 12, 12, 1, 2, 4, 5, 5);

		-- --------------------------------------------------------

		--
		-- Table structure for table `employee`
		--

		CREATE TABLE `employee` (
		  `emp_id` int(11) UNSIGNED NOT NULL,
		  `ref_user_id` int(11) NOT NULL DEFAULT '0',
		  `name` varchar(50) NOT NULL,
		  `mobile` bigint(10) NOT NULL,
		  `email` varchar(100) NOT NULL,
		  `address` varchar(500) NOT NULL,
		  `gender` char(1) NOT NULL,
		  `dob` date NOT NULL,
		  `department_id` int(11) NOT NULL,
		  `designation_id` int(11) NOT NULL,
		  `emp_code` varchar(50) NOT NULL DEFAULT 'null',
		  `ref_company_id` tinyint(3) NOT NULL DEFAULT '0',
		  `document_no` varchar(50) NOT NULL DEFAULT '0' COMMENT '# seperated parallel to document',
		  `document_name` varchar(500) NOT NULL DEFAULT '0' COMMENT '# seperated parallel to identification',
		  `document_url` varchar(500) NOT NULL DEFAULT '0' COMMENT '# seperated',
		  `status` tinyint(3) NOT NULL DEFAULT '0',
		  `date_of_joining` date NOT NULL,
		  `basic_pay` bigint(20) NOT NULL DEFAULT '0',
		  `added_by` int(11) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		--
		-- Dumping data for table `employee`
		--

		INSERT INTO `employee` (`emp_id`, `ref_user_id`, `name`, `mobile`, `email`, `address`, `gender`, `dob`, `department_id`, `designation_id`, `emp_code`, `ref_company_id`, `document_no`, `document_name`, `document_url`, `status`, `date_of_joining`, `basic_pay`, `added_by`) VALUES
		(18, 154, 'aasaasaas', 1111111111, 'asaswsaswedsw', 'aasqwseecddfrtgd', 'f', '2018-12-31', 1, 1, 'as121', 0, '', '', '', 0, '2018-12-31', 100000, 1),
		(19, 155, 'pratik mehta ji', 1212123234, 'pratikmehta31@gmail.com', 'New delhi', 'm', '2010-10-10', 1, 1, 'PRA121121', 0, 'as', 'as', '3008.jpg', 0, '2012-12-12', 100000, 1),
		(20, 156, 'Narendra', 4459949534, 'emp@gmail.com', 'New delhi', 'f', '2006-06-06', 1, 1, 'NER121', 0, '', '', '', 0, '2003-12-06', 10000000, 1),
		(21, 157, 'akash', 3334495493, 'datear@gmail.com', 'greater noida', 'm', '2013-06-12', 2, 1, 'akash121', 0, '', '', '', 0, '2018-12-31', 100000, 1);

		-- --------------------------------------------------------

		--
		-- Table structure for table `emp_feedback`
		--

		CREATE TABLE `emp_feedback` (
		  `feed_id` int(11) UNSIGNED NOT NULL,
		  `emp_id` int(11) NOT NULL,
		  `rating_basis` varchar(500) NOT NULL DEFAULT '0' COMMENT '# seperated rating heading',
		  `rating_score` varchar(500) NOT NULL DEFAULT '0' COMMENT '# seperted rating score',
		  `avg_score` float NOT NULL DEFAULT '0',
		  `comment` varchar(500) NOT NULL DEFAULT '0',
		  `added_by` tinyint(3) NOT NULL DEFAULT '0',
		  `rating_date` date NOT NULL,
		  `time_stamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		--
		-- Dumping data for table `emp_feedback`
		--

		INSERT INTO `emp_feedback` (`feed_id`, `emp_id`, `rating_basis`, `rating_score`, `avg_score`, `comment`, `added_by`, `rating_date`, `time_stamp`) VALUES
		(1, 122, 'behaviour#dressing#communication', '4#3#4', 4, 'old employee', 1, '1212-12-12', '2018-04-07 13:05:00'),
		(2, 122, 'behaviour#dressing#communication', '4#3#4', 4, 'old employee', 1, '1212-12-12', '2018-04-07 13:08:38'),
		(3, 2, 'Communication#Behaviour', '4#1', 8, 'NA#NA', 1, '1212-12-12', '2018-04-10 01:49:25'),
		(4, 133, 'Behaviour#Communication', '1#2', 8, 'asas#asasas', 1, '1212-11-12', '2018-04-10 01:54:28');

		-- --------------------------------------------------------

		--
		-- Table structure for table `event`
		--

		CREATE TABLE `event` (
		  `event_id` int(11) UNSIGNED NOT NULL,
		  `event_name` varchar(200) NOT NULL,
		  `event_date` date NOT NULL,
		  `image_url` varchar(200) NOT NULL,
		  `punch_line` varchar(500) NOT NULL,
		  `detail` varchar(500) NOT NULL,
		  `added_by` tinyint(3) NOT NULL,
		  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `status` tinyint(4) DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		--
		-- Dumping data for table `event`
		--

		INSERT INTO `event` (`event_id`, `event_name`, `event_date`, `image_url`, `punch_line`, `detail`, `added_by`, `timestamp`, `status`) VALUES
		(2, 'Hello New Item', '2001-01-01', 'ac.JPG', 'new punch line', 'Hello there', 1, '2018-04-12 12:31:05', 1),
		(3, 'Kjkljlkjlk', '0000-00-00', 'GuadalupeCloudsNP_EN-IN11356375152_1920x1080.jpg', 'lkjlkjljj', ';klj;lkj;kj;lklj;lkj;lkj', 1, '2018-04-12 13:27:41', 1),
		(4, 'Hula Hula', '0000-00-00', '3170.jpg', 'keena keena', 'abcdefghijklmnopqrstuve', 1, '2018-04-12 16:36:16', 1),
		(5, 'Aaaaaa', '0000-00-00', '858.jpg', 'aasades', 'aaqwsxxcderfvdcxesw', 1, '2018-04-12 16:38:29', 1),
		(6, 'Dance India Dance', '0000-00-00', '1046.jpg', 'nach le', 'hello there...', 1, '2018-04-14 12:04:38', 1),
		(7, 'New Event Date', '2018-12-31', '741.jpg', 'new punchline', 'Hello there', 1, '2018-04-14 16:35:25', 1),
		(8, 'New Event Chandan', '2021-01-01', '741.jpg', 'aasqwwsdesswdffcxdvvfr', 'aasqwssade', 1, '2018-04-14 17:35:15', 1),
		(34, 'Dancekkkkk', '0000-00-00', '3170.jpg', 'Just Dok', 'kljkj;lkj;lkj;lkj;lkj', 1, '2018-04-12 12:30:48', 1);

		-- --------------------------------------------------------

		--
		-- Table structure for table `invoices`
		--

		CREATE TABLE `invoices` (
		  `invoice_number` int(50) NOT NULL,
		  `order_id` int(10) DEFAULT NULL,
		  `invoice_status_code` varchar(50) DEFAULT NULL,
		  `invoice_date` date DEFAULT NULL,
		  `invoice_details` varchar(255) DEFAULT NULL,
		  `added_by` int(10) DEFAULT NULL,
		  `status` time DEFAULT NULL,
		  `timestamp` datetime DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		-- --------------------------------------------------------

		--
		-- Table structure for table `mail_log`
		--

		CREATE TABLE `mail_log` (
		  `mail_id` int(11) UNSIGNED NOT NULL,
		  `to_client_id` int(11) NOT NULL,
		  `from` varchar(200) NOT NULL,
		  `loan_no` varchar(200) NOT NULL,
		  `msg` varchar(500) DEFAULT NULL,
		  `medium` varchar(200) NOT NULL,
		  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		-- --------------------------------------------------------

		--
		-- Table structure for table `offers`
		--

		CREATE TABLE `offers` (
		  `offer_id` int(11) UNSIGNED NOT NULL,
		  `offer_name` varchar(500) NOT NULL,
		  `image_url` varchar(500) NOT NULL COMMENT '# seperated',
		  `punch_line` varchar(500) NOT NULL,
		  `detail` varchar(500) NOT NULL,
		  `offer_start_date` date NOT NULL,
		  `offer_end_date` date NOT NULL,
		  `added_by` tinyint(3) NOT NULL,
		  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `status` tinyint(4) DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		--
		-- Dumping data for table `offers`
		--

		INSERT INTO `offers` (`offer_id`, `offer_name`, `image_url`, `punch_line`, `detail`, `offer_start_date`, `offer_end_date`, `added_by`, `timestamp`, `status`) VALUES
		(1, 'Offer Hai Bhai Offer Hai Bhai Offer Hai Bhai', '1046.jpg', 'sab ke liye sb ke liye', 'fkdsjf;skdlfjsdf;skfj', '2019-01-01', '2019-01-01', 1, '2018-04-12 13:13:30', 1),
		(2, 'Offer Hi Offer', '4157.jpg', 'aaj hi offer hai 2', '2019-09-09', '2001-01-01', '0000-00-00', 1, '2018-04-12 13:14:01', 1),
		(3, 'new offer date', '4157.jpg', 'detail of new offer date', '2018-12-31', '2019-11-02', '0000-00-00', 1, '2018-04-14 16:44:32', 1),
		(4, 'kjkj', '1470.jpg', ';klj;', '2018-01-01', '2018-04-14', '0000-00-00', 1, '2018-04-14 16:48:40', 1),
		(5, 'Hello offer', '1046.jpg', ';lkfsdf;', '2018-12-31', '2018-12-31', '0000-00-00', 1, '2018-04-14 17:09:34', 1),
		(6, 'kljk', '1046.jpg', ';kj;klj', '2018-12-31', '2017-11-30', '0000-00-00', 1, '2018-04-14 17:12:42', 1),
		(7, 'kkkkkk', '4157.jpg', 'jjjjjjjjj', '2021-01-01', '2024-12-24', '0000-00-00', 1, '2018-04-14 17:25:39', 1),
		(8, 'sasasasas', '858.jpg', 'asasasasas', 'asasasasassasasas', '2069-01-01', '2079-01-01', 1, '2018-04-14 17:27:56', 1);

		-- --------------------------------------------------------

		--
		-- Table structure for table `orders`
		--

		CREATE TABLE `orders` (
		  `order_id` int(10) NOT NULL,
		  `customer_id` int(10) DEFAULT NULL,
		  `order_status_code` int(30) DEFAULT NULL,
		  `date_order_placed` date DEFAULT NULL,
		  `order_details` varchar(255) DEFAULT NULL,
		  `payment_id` int(50) DEFAULT NULL,
		  `status` varchar(45) DEFAULT NULL,
		  `timestamp` datetime DEFAULT NULL,
		  `added_by` int(10) DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		-- --------------------------------------------------------

		--
		-- Table structure for table `order_items`
		--

		CREATE TABLE `order_items` (
		  `order_items_id` int(11) NOT NULL,
		  `product_id` int(10) DEFAULT NULL,
		  `order_id` int(10) DEFAULT NULL,
		  `order_item_status_code` int(50) DEFAULT NULL,
		  `order_item_quantity` int(10) DEFAULT NULL,
		  `order_item_price` int(10) DEFAULT NULL,
		  `rma_number` int(50) DEFAULT NULL,
		  `rma_issued_by` varchar(45) DEFAULT NULL,
		  `rma_issued_date` date DEFAULT NULL,
		  `other_order_item_details` varchar(255) DEFAULT NULL,
		  `timestamp` datetime DEFAULT NULL,
		  `added_by` int(10) DEFAULT NULL,
		  `status` time DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		-- --------------------------------------------------------

		--
		-- Table structure for table `payments`
		--

		CREATE TABLE `payments` (
		  `payment_id` int(10) NOT NULL,
		  `invoice_number` int(10) DEFAULT NULL,
		  `payment_date` date DEFAULT NULL,
		  `payment_amount` varchar(20) DEFAULT NULL,
		  `deliver_id` int(20) DEFAULT NULL,
		  `bag_id` int(20) DEFAULT NULL,
		  `session_user_id` int(20) DEFAULT NULL,
		  `pay_mtd` varchar(45) DEFAULT NULL,
		  `added-by` int(10) DEFAULT NULL,
		  `status` time DEFAULT NULL,
		  `timestamp` datetime DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		-- --------------------------------------------------------

		--
		-- Table structure for table `product_basic_info`
		--

		CREATE TABLE `product_basic_info` (
		  `product_id` int(20) NOT NULL,
		  `product_name` varchar(45) DEFAULT NULL,
		  `product_make` int(10) DEFAULT NULL,
		  `category_id` int(20) DEFAULT NULL,
		  `hsn` varchar(50) NOT NULL,
		  `barcode` int(11) NOT NULL,
		  `product_description` varchar(255) DEFAULT NULL,
		  `product_imp_url` varchar(200) DEFAULT NULL,
		  `remark` varchar(500) DEFAULT NULL,
		  `added_by` int(10) DEFAULT NULL,
		  `timestamp` datetime DEFAULT NULL,
		  `status` time DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		-- --------------------------------------------------------

		--
		-- Table structure for table `product_extra_info`
		--

		CREATE TABLE `product_extra_info` (
		  `product_id` int(20) NOT NULL,
		  `ref_product_id` int(11) NOT NULL,
		  `chemical_composition` varchar(255) DEFAULT NULL,
		  `dosage` varchar(255) DEFAULT NULL,
		  `method_of_application` varchar(255) DEFAULT NULL,
		  `spectrum` varchar(255) DEFAULT NULL,
		  `compatibility` varchar(255) DEFAULT NULL,
		  `duration_of_effect` varchar(255) DEFAULT NULL,
		  `frequency_of_application` varchar(45) DEFAULT NULL,
		  `applicable_crop` varchar(255) DEFAULT NULL,
		  `status` time DEFAULT NULL,
		  `timestamp` datetime DEFAULT NULL,
		  `added_by` int(10) DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		-- --------------------------------------------------------

		--
		-- Table structure for table `product_extra_info_crop`
		--

		CREATE TABLE `product_extra_info_crop` (
		  `peic_id` int(10) NOT NULL,
		  `ref_product_id` int(10) DEFAULT NULL,
		  `famous_for` varchar(255) DEFAULT NULL,
		  `variety` varchar(255) DEFAULT NULL,
		  `seed_rate` varchar(45) DEFAULT NULL,
		  `sowing_season` varchar(45) DEFAULT NULL,
		  `sowing_method` varchar(255) DEFAULT NULL,
		  `extra_description` varchar(500) DEFAULT NULL,
		  `fruit_weight` varchar(45) DEFAULT NULL,
		  `nature_of_flesh` varchar(45) DEFAULT NULL,
		  `crop_duration` varchar(45) DEFAULT NULL,
		  `shape_of_fruit` varchar(45) DEFAULT NULL,
		  `status` time DEFAULT NULL,
		  `timestamp` datetime DEFAULT NULL,
		  `added_by` int(10) DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		-- --------------------------------------------------------

		--
		-- Table structure for table `rating_parameters`
		--

		CREATE TABLE `rating_parameters` (
		  `para_id` int(11) NOT NULL,
		  `para_name` varchar(100) NOT NULL,
		  `para_desc` varchar(100) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		--
		-- Dumping data for table `rating_parameters`
		--

		INSERT INTO `rating_parameters` (`para_id`, `para_name`, `para_desc`) VALUES
		(1, 'Behaviour', ''),
		(2, 'Communication', ''),
		(3, 'Dressing', '');

		-- --------------------------------------------------------

		--
		-- Table structure for table `ref_order_status_codes`
		--

		CREATE TABLE `ref_order_status_codes` (
		  `order_status_code` int(10) NOT NULL,
		  `order_status_description` varchar(255) DEFAULT NULL,
		  `added_by` int(10) DEFAULT NULL,
		  `status` time DEFAULT NULL,
		  `timestamp` datetime DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		-- --------------------------------------------------------

		--
		-- Table structure for table `shipments`
		--

		CREATE TABLE `shipments` (
		  `shipment_id` int(50) NOT NULL,
		  `order_id` int(50) DEFAULT NULL,
		  `invoice_number` int(15) DEFAULT NULL,
		  `shipment_tracking_number` int(20) DEFAULT NULL,
		  `shipment_date` date DEFAULT NULL,
		  `other_shipment_details` varchar(255) DEFAULT NULL,
		  `added_by` int(10) DEFAULT NULL,
		  `status` time DEFAULT NULL,
		  `timestamp` datetime DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		-- --------------------------------------------------------

		--
		-- Table structure for table `transaction`
		--

		CREATE TABLE `transaction` (
		  `txn_id` int(11) UNSIGNED NOT NULL,
		  `txn_no` varchar(100) NOT NULL,
		  `status` varchar(100) NOT NULL,
		  `ref_cl_id` int(11) NOT NULL,
		  `gateway_name` varchar(200) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		-- --------------------------------------------------------

		--
		-- Table structure for table `user_login`
		--

		CREATE TABLE `user_login` (
		  `user_id` int(11) UNSIGNED NOT NULL,
		  `user_name` varchar(512) NOT NULL,
		  `user_password` varchar(512) NOT NULL,
		  `user_type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1 for SuperAdmin',
		  `user_right` varchar(200) DEFAULT NULL,
		  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'active and deactive'
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		--
		-- Dumping data for table `user_login`
		--

		INSERT INTO `user_login` (`user_id`, `user_name`, `user_password`, `user_type`, `user_right`, `status`) VALUES
		(1, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 1, '1#2#3#4#5#6#7#8#9', 1),
		(2, 'employee', '2fdc0177057d3a5c6c2c0821e01f4fa8d90f9a3bb7afd82b0db526af98d68de8', 2, '1#2#3', 1),
		(3, 'associate', '178b6e061a04a75e46b85f8c9ef1803583f5cb5a459d4ba45c3b7529c5f0c3ec', 3, '1#2', 1),
		(4, 'client', '948fe603f61dc036b5c596dc09fe3ce3f3d30dc90f024c85f3c82db2ccab679d', 4, '1', 1);

		-- --------------------------------------------------------

		--
		-- Table structure for table `user_rights`
		--

		CREATE TABLE `user_rights` (
		  `id` int(10) UNSIGNED NOT NULL,
		  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
		  `page_name` varchar(50) NOT NULL,
		  `icon` varchar(50) NOT NULL,
		  `Display_name` varchar(50) NOT NULL,
		  `extra_icon` varchar(50) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		--
		-- Dumping data for table `user_rights`
		--

		INSERT INTO `user_rights` (`id`, `parent_id`, `page_name`, `icon`, `Display_name`, `extra_icon`) VALUES
		(1, 0, 'dashboard', 'icon icon-home', 'Dashboard', ''),
		(2, 0, 'addassociate', 'icon icon-user', 'Add Associate Partner', ''),
		(5, 0, 'addoffer', 'icon icon-picture', 'Add Offer', ''),
		(7, 0, 'addclient', 'icon icon-user', 'Add & Manage Client', ''),
		(9, 0, 'addemp', 'icon icon-user', 'Add & Manage Employee', '');

		--
		-- Indexes for dumped tables
		--

		--
		-- Indexes for table `admin`
		--
		ALTER TABLE `admin`
		  ADD PRIMARY KEY (`admin_id`),
		  ADD UNIQUE KEY `admin_mobile` (`mobile`);

		--
		-- Indexes for table `associate_partner`
		--
		ALTER TABLE `associate_partner`
		  ADD PRIMARY KEY (`assoc_id`),
		  ADD UNIQUE KEY `ref_user_id` (`ref_user_id`);

		--
		-- Indexes for table `company`
		--
		ALTER TABLE `company`
		  ADD PRIMARY KEY (`company_id`);

		--
		-- Indexes for table `customers`
		--
		ALTER TABLE `customers`
		  ADD PRIMARY KEY (`customer_id`);

		--
		-- Indexes for table `department`
		--
		ALTER TABLE `department`
		  ADD PRIMARY KEY (`department_id`);

		--
		-- Indexes for table `designation`
		--
		ALTER TABLE `designation`
		  ADD PRIMARY KEY (`designation_id`);

		--
		-- Indexes for table `employee`
		--
		ALTER TABLE `employee`
		  ADD PRIMARY KEY (`emp_id`);

		--
		-- Indexes for table `emp_feedback`
		--
		ALTER TABLE `emp_feedback`
		  ADD PRIMARY KEY (`feed_id`);

		--
		-- Indexes for table `event`
		--
		ALTER TABLE `event`
		  ADD PRIMARY KEY (`event_id`);

		--
		-- Indexes for table `invoices`
		--
		ALTER TABLE `invoices`
		  ADD PRIMARY KEY (`invoice_number`);

		--
		-- Indexes for table `mail_log`
		--
		ALTER TABLE `mail_log`
		  ADD PRIMARY KEY (`mail_id`);

		--
		-- Indexes for table `offers`
		--
		ALTER TABLE `offers`
		  ADD PRIMARY KEY (`offer_id`);

		--
		-- Indexes for table `orders`
		--
		ALTER TABLE `orders`
		  ADD PRIMARY KEY (`order_id`);

		--
		-- Indexes for table `order_items`
		--
		ALTER TABLE `order_items`
		  ADD PRIMARY KEY (`order_items_id`);

		--
		-- Indexes for table `payments`
		--
		ALTER TABLE `payments`
		  ADD PRIMARY KEY (`payment_id`);

		--
		-- Indexes for table `product_basic_info`
		--
		ALTER TABLE `product_basic_info`
		  ADD PRIMARY KEY (`product_id`);

		--
		-- Indexes for table `product_extra_info`
		--
		ALTER TABLE `product_extra_info`
		  ADD PRIMARY KEY (`product_id`);

		--
		-- Indexes for table `product_extra_info_crop`
		--
		ALTER TABLE `product_extra_info_crop`
		  ADD PRIMARY KEY (`peic_id`);

		--
		-- Indexes for table `rating_parameters`
		--
		ALTER TABLE `rating_parameters`
		  ADD PRIMARY KEY (`para_id`);

		--
		-- Indexes for table `ref_order_status_codes`
		--
		ALTER TABLE `ref_order_status_codes`
		  ADD PRIMARY KEY (`order_status_code`);

		--
		-- Indexes for table `shipments`
		--
		ALTER TABLE `shipments`
		  ADD PRIMARY KEY (`shipment_id`);

		--
		-- Indexes for table `transaction`
		--
		ALTER TABLE `transaction`
		  ADD PRIMARY KEY (`txn_id`);

		--
		-- Indexes for table `user_login`
		--
		ALTER TABLE `user_login`
		  ADD PRIMARY KEY (`user_id`),
		  ADD UNIQUE KEY `user_name` (`user_name`);

		--
		-- Indexes for table `user_rights`
		--
		ALTER TABLE `user_rights`
		  ADD PRIMARY KEY (`id`);

		--
		-- AUTO_INCREMENT for dumped tables
		--

		--
		-- AUTO_INCREMENT for table `admin`
		--
		ALTER TABLE `admin`
		  MODIFY `admin_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
		--
		-- AUTO_INCREMENT for table `associate_partner`
		--
		ALTER TABLE `associate_partner`
		  MODIFY `assoc_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
		--
		-- AUTO_INCREMENT for table `company`
		--
		ALTER TABLE `company`
		  MODIFY `company_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
		--
		-- AUTO_INCREMENT for table `customers`
		--
		ALTER TABLE `customers`
		  MODIFY `customer_id` int(10) NOT NULL AUTO_INCREMENT;
		--
		-- AUTO_INCREMENT for table `department`
		--
		ALTER TABLE `department`
		  MODIFY `department_id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
		--
		-- AUTO_INCREMENT for table `designation`
		--
		ALTER TABLE `designation`
		  MODIFY `designation_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
		--
		-- AUTO_INCREMENT for table `employee`
		--
		ALTER TABLE `employee`
		  MODIFY `emp_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
		--
		-- AUTO_INCREMENT for table `emp_feedback`
		--
		ALTER TABLE `emp_feedback`
		  MODIFY `feed_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
		--
		-- AUTO_INCREMENT for table `event`
		--
		ALTER TABLE `event`
		  MODIFY `event_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
		--
		-- AUTO_INCREMENT for table `invoices`
		--
		ALTER TABLE `invoices`
		  MODIFY `invoice_number` int(50) NOT NULL AUTO_INCREMENT;
		--
		-- AUTO_INCREMENT for table `mail_log`
		--
		ALTER TABLE `mail_log`
		  MODIFY `mail_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
		--
		-- AUTO_INCREMENT for table `offers`
		--
		ALTER TABLE `offers`
		  MODIFY `offer_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
		--
		-- AUTO_INCREMENT for table `orders`
		--
		ALTER TABLE `orders`
		  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT;
		--
		-- AUTO_INCREMENT for table `order_items`
		--
		ALTER TABLE `order_items`
		  MODIFY `order_items_id` int(11) NOT NULL AUTO_INCREMENT;
		--
		-- AUTO_INCREMENT for table `product_basic_info`
		--
		ALTER TABLE `product_basic_info`
		  MODIFY `product_id` int(20) NOT NULL AUTO_INCREMENT;
		--
		-- AUTO_INCREMENT for table `product_extra_info`
		--
		ALTER TABLE `product_extra_info`
		  MODIFY `product_id` int(20) NOT NULL AUTO_INCREMENT;
		--
		-- AUTO_INCREMENT for table `product_extra_info_crop`
		--
		ALTER TABLE `product_extra_info_crop`
		  MODIFY `peic_id` int(10) NOT NULL AUTO_INCREMENT;
		--
		-- AUTO_INCREMENT for table `rating_parameters`
		--
		ALTER TABLE `rating_parameters`
		  MODIFY `para_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
		--
		-- AUTO_INCREMENT for table `ref_order_status_codes`
		--
		ALTER TABLE `ref_order_status_codes`
		  MODIFY `order_status_code` int(10) NOT NULL AUTO_INCREMENT;
		--
		-- AUTO_INCREMENT for table `shipments`
		--
		ALTER TABLE `shipments`
		  MODIFY `shipment_id` int(50) NOT NULL AUTO_INCREMENT;
		--
		-- AUTO_INCREMENT for table `transaction`
		--
		ALTER TABLE `transaction`
		  MODIFY `txn_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
		--
		-- AUTO_INCREMENT for table `user_login`
		--
		ALTER TABLE `user_login`
		  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;
		--
		-- AUTO_INCREMENT for table `user_rights`
		--
		ALTER TABLE `user_rights`
		  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
		/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
		/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
		/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

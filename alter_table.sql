-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 12, 2025 at 02:46 AM
-- Server version: 10.6.23-MariaDB-cll-lve
-- PHP Version: 8.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `deccan_clap`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(1000) NOT NULL,
  `status` varchar(1000) NOT NULL DEFAULT 'Active',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city_id`, `city_name`, `status`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, 'HYD', 'Active', 1, '2025-12-11 03:35:58', NULL, NULL),
(2, 'Bangalore', 'Active', 1, '2025-12-11 03:36:10', NULL, NULL),
(3, 'Pune', 'Active', 1, '2025-12-11 03:36:10', NULL, NULL),
(4, 'Delhi', 'Active', 1, '2025-12-11 03:37:06', NULL, NULL);

--
-- Triggers `cities`
--
DELIMITER $$
CREATE TRIGGER `t_cities_archive` BEFORE DELETE ON `cities` FOR EACH ROW INSERT INTO cities_archive (select *, now() from cities where cities.city_id = old.city_id)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `t_cities_audit` BEFORE UPDATE ON `cities` FOR EACH ROW INSERT INTO cities_audit (select * from cities where cities.city_id = old.city_id)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cities_archive`
--

CREATE TABLE `cities_archive` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(1000) NOT NULL,
  `status` varchar(1000) NOT NULL DEFAULT 'Active',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities_audit`
--

CREATE TABLE `cities_audit` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(1000) NOT NULL,
  `status` varchar(1000) NOT NULL DEFAULT 'Active',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `item_name` varchar(2000) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `product_id`, `item_name`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(2, 1, 'Item', 1, '2025-12-12 15:02:16', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `lead_id` int(10) UNSIGNED NOT NULL,
  `lead_code` varchar(50) DEFAULT NULL,
  `lead_name` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `address` text NOT NULL,
  `work_details` text NOT NULL,
  `current_stage` enum('Unassigned','Sales Manager','Inside Sales Executive','Field Sales Executive','Follow-Up Executive') DEFAULT 'Unassigned',
  `current_status` enum('New','Connected','Not Responding','Rescheduled','Cancelled','Qualified','Estimation Given','Approved','Rejected','Converted','Closed','Lost') DEFAULT 'New',
  `current_assigned_to` int(10) UNSIGNED DEFAULT NULL,
  `lead_source` varchar(50) DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`lead_id`, `lead_code`, `lead_name`, `contact_number`, `email`, `service_id`, `city_id`, `address`, `work_details`, `current_stage`, `current_status`, `current_assigned_to`, `lead_source`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(5, 'LEAD0005', 'Lead 1', '7876565434', 'lead1@gmail.com', 1, 1, 'test', 'test', 'Inside Sales Executive', 'Connected', 36, 'walk-ins/referrals', 36, '2025-12-11 17:40:32', NULL, NULL),
(6, 'LEAD0006', 'Lead 2', '7656543434', 'lead2@gmail.com', 1, 1, 'test', 'test', 'Inside Sales Executive', 'Connected', 36, 'walk-ins/referrals', 36, '2025-12-11 17:41:38', NULL, NULL),
(7, 'LEAD0007', 'Lead 3', '9878767876', 'lead3@gmail.com', 2, 3, 'test', 'test', 'Inside Sales Executive', 'Connected', 36, 'walk-ins/referrals', 36, '2025-12-11 17:43:47', NULL, NULL);

--
-- Triggers `leads`
--
DELIMITER $$
CREATE TRIGGER `trg_leads_archive` BEFORE DELETE ON `leads` FOR EACH ROW BEGIN
  INSERT INTO leads_archive (
    lead_id, lead_code, lead_name, contact_number, email,
    service_id, city_id, address, work_details,
    current_stage, current_status, current_assigned_to, lead_source,
    created_by, created_on, updated_by, updated_on,
    deleted_on
  )
  VALUES (
    OLD.lead_id, OLD.lead_code, OLD.lead_name, OLD.contact_number, OLD.email,
    OLD.service_id, OLD.city_id, OLD.address, OLD.work_details,
    OLD.current_stage, OLD.current_status, OLD.current_assigned_to, OLD.lead_source,
    OLD.created_by, OLD.created_on, OLD.updated_by, OLD.updated_on,
    NOW()
  );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_leads_audit` BEFORE UPDATE ON `leads` FOR EACH ROW INSERT INTO leads_audit (
    lead_id, lead_code, lead_name, contact_number, email,
    service_id, city_id, address, work_details,
    current_stage, current_status, current_assigned_to, lead_source,
    created_by, created_on, updated_by, updated_on, audit_time
)
VALUES (
    OLD.lead_id, OLD.lead_code, OLD.lead_name, OLD.contact_number, OLD.email,
    OLD.service_id, OLD.city_id, OLD.address, OLD.work_details,
    OLD.current_stage, OLD.current_status, OLD.current_assigned_to, OLD.lead_source,
    OLD.created_by, OLD.created_on, OLD.updated_by, OLD.updated_on,
    NOW()
)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `leads_archive`
--

CREATE TABLE `leads_archive` (
  `archive_id` int(10) UNSIGNED NOT NULL,
  `lead_id` int(10) UNSIGNED NOT NULL,
  `lead_code` varchar(50) DEFAULT NULL,
  `lead_name` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `service_id` int(10) UNSIGNED DEFAULT NULL,
  `city_id` int(10) UNSIGNED DEFAULT NULL,
  `address` text DEFAULT NULL,
  `work_details` text DEFAULT NULL,
  `current_stage` varchar(100) DEFAULT NULL,
  `current_status` varchar(100) DEFAULT NULL,
  `current_assigned_to` int(10) UNSIGNED DEFAULT NULL,
  `lead_source` varchar(50) DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `leads_archive`
--

INSERT INTO `leads_archive` (`archive_id`, `lead_id`, `lead_code`, `lead_name`, `contact_number`, `email`, `service_id`, `city_id`, `address`, `work_details`, `current_stage`, `current_status`, `current_assigned_to`, `lead_source`, `created_by`, `created_on`, `updated_by`, `updated_on`, `deleted_on`) VALUES
(1, 2, 'LEAD0002', 'Test', '6565454345', 'info@inrisoft.com', 1, 1, 'test', 'test', 'Inside Sales Executive', 'Connected', 36, NULL, 36, '2025-12-11 17:11:55', NULL, NULL, '2025-12-11 17:39:42'),
(2, 3, 'LEAD0003', 'Test', '6565454345', 'info@inrisoft.com', 1, 1, 'test', 'test', 'Inside Sales Executive', 'Connected', 36, NULL, 36, '2025-12-11 17:15:21', NULL, NULL, '2025-12-11 17:39:44'),
(3, 4, 'LEAD0004', 'Test 2', '1234563434', 'test@gmail.com', 1, 1, 'test', 'test', 'Inside Sales Executive', 'Connected', 36, NULL, 36, '2025-12-11 17:22:48', NULL, NULL, '2025-12-11 17:39:46');

-- --------------------------------------------------------

--
-- Table structure for table `leads_audit`
--

CREATE TABLE `leads_audit` (
  `audit_id` int(10) UNSIGNED NOT NULL,
  `lead_id` int(10) UNSIGNED NOT NULL,
  `lead_code` varchar(50) DEFAULT NULL,
  `lead_name` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `service_id` int(10) UNSIGNED DEFAULT NULL,
  `city_id` int(10) UNSIGNED DEFAULT NULL,
  `address` text DEFAULT NULL,
  `work_details` text DEFAULT NULL,
  `current_stage` varchar(100) DEFAULT NULL,
  `current_status` varchar(100) DEFAULT NULL,
  `current_assigned_to` int(10) UNSIGNED DEFAULT NULL,
  `lead_source` varchar(50) DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `audit_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `leads_audit`
--

INSERT INTO `leads_audit` (`audit_id`, `lead_id`, `lead_code`, `lead_name`, `contact_number`, `email`, `service_id`, `city_id`, `address`, `work_details`, `current_stage`, `current_status`, `current_assigned_to`, `lead_source`, `created_by`, `created_on`, `updated_by`, `updated_on`, `audit_time`) VALUES
(2, 2, NULL, 'Test', '6565454345', 'info@inrisoft.com', 1, 1, 'test', 'test', 'Inside Sales Executive', 'Connected', 36, NULL, 36, '2025-12-11 17:11:55', NULL, NULL, '2025-12-11 17:11:55'),
(3, 3, NULL, 'Test', '6565454345', 'info@inrisoft.com', 1, 1, 'test', 'test', 'Inside Sales Executive', 'Connected', 36, NULL, 36, '2025-12-11 17:15:21', NULL, NULL, '2025-12-11 17:15:21'),
(4, 4, NULL, 'Test 2', '1234563434', 'test@gmail.com', 1, 1, 'test', 'test', 'Inside Sales Executive', 'Connected', 36, NULL, 36, '2025-12-11 17:22:48', NULL, NULL, '2025-12-11 17:22:48'),
(5, 5, NULL, 'Lead 1', '7876565434', 'lead1@gmail.com', 1, 1, 'test', 'test', 'Inside Sales Executive', 'Connected', 0, 'walk-ins/referrals', 36, '2025-12-11 17:40:32', NULL, NULL, '2025-12-11 17:40:32'),
(6, 6, NULL, 'Lead 2', '7656543434', 'lead2@gmail.com', 1, 1, 'test', 'test', 'Inside Sales Executive', 'Connected', 0, 'walk-ins/referrals', 36, '2025-12-11 17:41:38', NULL, NULL, '2025-12-11 17:41:38'),
(7, 5, 'LEAD0005', 'Lead 1', '7876565434', 'lead1@gmail.com', 1, 1, 'test', 'test', 'Inside Sales Executive', 'Connected', 0, 'walk-ins/referrals', 36, '2025-12-11 17:40:32', NULL, NULL, '2025-12-11 17:43:05'),
(8, 6, 'LEAD0006', 'Lead 2', '7656543434', 'lead2@gmail.com', 1, 1, 'test', 'test', 'Inside Sales Executive', 'Connected', 0, 'walk-ins/referrals', 36, '2025-12-11 17:41:38', NULL, NULL, '2025-12-11 17:43:09'),
(9, 7, NULL, 'Lead 3', '9878767876', 'lead3@gmail.com', 2, 3, 'test', 'test', 'Inside Sales Executive', 'Connected', 36, 'walk-ins/referrals', 36, '2025-12-11 17:43:47', NULL, NULL, '2025-12-11 17:43:47');

-- --------------------------------------------------------

--
-- Table structure for table `lead_assignments`
--

CREATE TABLE `lead_assignments` (
  `assign_id` int(10) UNSIGNED NOT NULL,
  `lead_id` int(10) UNSIGNED NOT NULL,
  `assigned_from` int(10) UNSIGNED DEFAULT NULL,
  `assigned_to` int(10) UNSIGNED NOT NULL,
  `assigned_by` int(10) UNSIGNED NOT NULL,
  `from_stage` enum('Unassigned','Sales Manager','Inside Sales Executive','Field Sales Executive','Follow-Up Executive') NOT NULL,
  `to_stage` enum('Sales Manager','Inside Sales Executive','Field Sales Executive','Follow-Up Executive') NOT NULL,
  `assigned_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `lead_assignments`
--

INSERT INTO `lead_assignments` (`assign_id`, `lead_id`, `assigned_from`, `assigned_to`, `assigned_by`, `from_stage`, `to_stage`, `assigned_on`) VALUES
(1, 5, NULL, 36, 36, 'Unassigned', 'Inside Sales Executive', '2025-12-11 17:40:32'),
(2, 6, NULL, 36, 36, 'Unassigned', 'Inside Sales Executive', '2025-12-11 17:41:38'),
(3, 7, NULL, 36, 36, 'Unassigned', 'Inside Sales Executive', '2025-12-11 17:43:47');

--
-- Triggers `lead_assignments`
--
DELIMITER $$
CREATE TRIGGER `trg_lead_assignments_archive` BEFORE DELETE ON `lead_assignments` FOR EACH ROW INSERT INTO lead_assignments_archive (
  assign_id, lead_id, assigned_from, assigned_to, assigned_by,
  from_stage, to_stage, assigned_on, deleted_on
)
VALUES (
  OLD.assign_id, OLD.lead_id, OLD.assigned_from, OLD.assigned_to,
  OLD.assigned_by, OLD.from_stage, OLD.to_stage,
  OLD.assigned_on, NOW()
)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_lead_assignments_audit` BEFORE UPDATE ON `lead_assignments` FOR EACH ROW INSERT INTO lead_assignments_audit (
  assign_id, lead_id, assigned_from, assigned_to, assigned_by,
  from_stage, to_stage, assigned_on, audit_time
)
VALUES (
  OLD.assign_id, OLD.lead_id, OLD.assigned_from, OLD.assigned_to,
  OLD.assigned_by, OLD.from_stage, OLD.to_stage,
  OLD.assigned_on, NOW()
)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `lead_assignments_archive`
--

CREATE TABLE `lead_assignments_archive` (
  `archive_id` int(10) UNSIGNED NOT NULL,
  `assign_id` int(10) UNSIGNED NOT NULL,
  `lead_id` int(10) UNSIGNED NOT NULL,
  `assigned_from` int(10) UNSIGNED DEFAULT NULL,
  `assigned_to` int(10) UNSIGNED DEFAULT NULL,
  `assigned_by` int(10) UNSIGNED DEFAULT NULL,
  `from_stage` varchar(100) DEFAULT NULL,
  `to_stage` varchar(100) DEFAULT NULL,
  `assigned_on` datetime DEFAULT NULL,
  `deleted_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_assignments_audit`
--

CREATE TABLE `lead_assignments_audit` (
  `audit_id` int(10) UNSIGNED NOT NULL,
  `assign_id` int(10) UNSIGNED NOT NULL,
  `lead_id` int(10) UNSIGNED NOT NULL,
  `assigned_from` int(10) UNSIGNED DEFAULT NULL,
  `assigned_to` int(10) UNSIGNED DEFAULT NULL,
  `assigned_by` int(10) UNSIGNED DEFAULT NULL,
  `from_stage` varchar(100) DEFAULT NULL,
  `to_stage` varchar(100) DEFAULT NULL,
  `assigned_on` datetime DEFAULT NULL,
  `audit_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_followups`
--

CREATE TABLE `lead_followups` (
  `followup_id` int(10) UNSIGNED NOT NULL,
  `lead_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `stage` enum('Sales Manager','Inside Sales Executive','Field Sales Executive','Follow-Up Executive') NOT NULL,
  `action` enum('Connected','Not Responding','Rescheduled','Cancelled','Qualified','Estimation Given','Approved','Rejected','Follow-Up Call','Follow-Up Pending','Converted','Closed','Lost') NOT NULL,
  `note` text DEFAULT NULL,
  `next_followup_date` date DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `lead_followups`
--

INSERT INTO `lead_followups` (`followup_id`, `lead_id`, `user_id`, `stage`, `action`, `note`, `next_followup_date`, `created_on`) VALUES
(1, 5, 36, 'Inside Sales Executive', 'Connected', NULL, NULL, '2025-12-11 17:40:32'),
(2, 6, 36, 'Inside Sales Executive', 'Connected', NULL, NULL, '2025-12-11 17:41:38'),
(3, 7, 36, 'Inside Sales Executive', 'Connected', NULL, NULL, '2025-12-11 17:43:47');

--
-- Triggers `lead_followups`
--
DELIMITER $$
CREATE TRIGGER `trg_lead_followups_archive` BEFORE DELETE ON `lead_followups` FOR EACH ROW INSERT INTO lead_followups_archive (
  followup_id, lead_id, user_id, stage, action, note,
  next_followup_date, created_on, deleted_on
)
VALUES (
  OLD.followup_id, OLD.lead_id, OLD.user_id, OLD.stage, OLD.action,
  OLD.note, OLD.next_followup_date, OLD.created_on, NOW()
)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_lead_followups_audit` BEFORE UPDATE ON `lead_followups` FOR EACH ROW INSERT INTO lead_followups_audit (
  followup_id, lead_id, user_id, stage, action, note,
  next_followup_date, created_on, audit_time
)
VALUES (
  OLD.followup_id, OLD.lead_id, OLD.user_id, OLD.stage, OLD.action,
  OLD.note, OLD.next_followup_date, OLD.created_on, NOW()
)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `lead_followups_archive`
--

CREATE TABLE `lead_followups_archive` (
  `archive_id` int(10) UNSIGNED NOT NULL,
  `followup_id` int(10) UNSIGNED NOT NULL,
  `lead_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `stage` varchar(100) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `next_followup_date` date DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `deleted_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_followups_audit`
--

CREATE TABLE `lead_followups_audit` (
  `audit_id` int(10) UNSIGNED NOT NULL,
  `followup_id` int(10) UNSIGNED NOT NULL,
  `lead_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `stage` varchar(100) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `next_followup_date` date DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `audit_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `service_id`, `product_name`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, 1, 'Product', 1, '2025-12-12 14:01:28', 1, '2025-12-12 14:16:49');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(500) NOT NULL,
  `status` varchar(55) NOT NULL DEFAULT 'Active',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `status`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, 'Super Admin', 'Active', 1, '2025-11-27 04:17:42', NULL, NULL),
(2, 'Admin', 'Active', 1, '2025-11-27 04:17:58', NULL, NULL),
(3, 'Sales Manager', 'Active', 1, '2025-11-27 04:18:35', NULL, NULL),
(4, 'Inside Sales Executive', 'Active', 1, '2025-11-27 04:18:50', NULL, NULL),
(5, 'Field Sales Executive', 'Active', 1, '2025-11-27 04:19:06', NULL, NULL),
(6, 'Follow-Up Executive', 'Active', 1, '2025-11-27 04:19:21', NULL, NULL),
(7, 'Vendor Manager', 'Active', 1, '2025-11-27 04:19:35', NULL, NULL),
(8, 'Vendor', 'Active', 1, '2025-11-27 04:20:00', NULL, NULL),
(9, 'Accounts Executive', 'Active', 1, '2025-11-27 04:20:10', NULL, NULL),
(10, 'Customer', 'Active', 1, '2025-11-27 04:20:33', NULL, NULL);

--
-- Triggers `roles`
--
DELIMITER $$
CREATE TRIGGER `t_roles_archive` BEFORE DELETE ON `roles` FOR EACH ROW INSERT INTO roles_archive (select *, now() from roles where roles.role_id = old.role_id)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `t_roles_audit` BEFORE UPDATE ON `roles` FOR EACH ROW INSERT INTO roles_audit (select * from roles where roles.role_id = old.role_id)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `roles_archive`
--

CREATE TABLE `roles_archive` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles_audit`
--

CREATE TABLE `roles_audit` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `roles_audit`
--

INSERT INTO `roles_audit` (`role_id`, `role_name`, `status`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(5, ' Sales Manager', 'Active', 1, '2025-11-27 04:19:06', NULL, NULL),
(6, 'Customer', 'Active', 1, '2025-11-27 04:19:21', NULL, NULL),
(7, 'Follow-Up Executive', 'Active', 1, '2025-11-27 04:19:35', NULL, NULL),
(8, 'Vendor Manager', 'Active', 0, '2025-11-27 04:20:00', NULL, NULL),
(9, 'Vendor', 'Active', 1, '2025-11-27 04:20:10', NULL, NULL),
(10, 'Accounts Executive', 'Active', 1, '2025-11-27 04:20:33', NULL, NULL),
(3, 'Inside Sales Executive', 'Active', 1, '2025-11-27 04:18:35', NULL, NULL),
(5, 'Sales Manager', 'Active', 1, '2025-11-27 04:19:06', NULL, NULL),
(4, 'Field Sales Executive', 'Active', 1, '2025-11-27 04:18:50', NULL, NULL),
(5, 'Inside Sales Executive', 'Active', 1, '2025-11-27 04:19:06', NULL, NULL),
(8, 'Vendor', 'Active', 0, '2025-11-27 04:20:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(1000) NOT NULL,
  `service_img_url` varchar(1000) DEFAULT NULL,
  `status` varchar(1000) NOT NULL DEFAULT 'Active',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `service_img_url`, `status`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, 'Painting', NULL, 'Active', 1, '2025-12-10 11:46:46', NULL, NULL),
(2, 'Waterproofing', NULL, 'Active', 1, '2025-12-10 11:47:17', NULL, NULL),
(3, 'Wood polish', NULL, 'Active', 1, '2025-12-10 11:47:43', NULL, NULL),
(4, 'Wood and Metal painting', NULL, 'Active', 1, '2025-12-10 11:48:12', NULL, NULL);

--
-- Triggers `services`
--
DELIMITER $$
CREATE TRIGGER `t_services_archive` BEFORE DELETE ON `services` FOR EACH ROW INSERT INTO services_archive (select *, now() from services where services.service_id = old.service_id)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `t_services_audit` BEFORE UPDATE ON `services` FOR EACH ROW INSERT INTO services_audit (select * from services where services.service_id = old.service_id)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `services_archive`
--

CREATE TABLE `services_archive` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(1000) NOT NULL,
  `service_img_url` varchar(1000) DEFAULT NULL,
  `status` varchar(1000) NOT NULL DEFAULT 'Active',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `services_archive`
--

INSERT INTO `services_archive` (`service_id`, `service_name`, `service_img_url`, `status`, `created_by`, `created_on`, `updated_by`, `updated_on`, `deleted_on`) VALUES
(5, 'test111', NULL, 'Active', 1, '2025-12-12 13:07:27', 1, '2025-12-12 13:13:52', '2025-12-12 00:54:46');

-- --------------------------------------------------------

--
-- Table structure for table `services_audit`
--

CREATE TABLE `services_audit` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(1000) NOT NULL,
  `service_img_url` varchar(1000) DEFAULT NULL,
  `status` varchar(1000) NOT NULL DEFAULT 'Active',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `services_audit`
--

INSERT INTO `services_audit` (`service_id`, `service_name`, `service_img_url`, `status`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(5, 'test', NULL, 'Active', 1, '2025-12-12 13:07:27', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `employee_code` varchar(111) DEFAULT NULL,
  `user_name` varchar(222) NOT NULL,
  `profile_image` varchar(2000) DEFAULT NULL,
  `email_id` varchar(222) NOT NULL,
  `password` varchar(111) NOT NULL,
  `phone` varchar(40) NOT NULL,
  `dob` date NOT NULL,
  `pan_card` varchar(22) DEFAULT NULL,
  `aadhaar_card` int(11) DEFAULT NULL,
  `date_of_joining` date NOT NULL,
  `date_of_cessation` date DEFAULT NULL,
  `address` varchar(555) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `otp` varchar(200) DEFAULT NULL,
  `status` varchar(222) DEFAULT 'Active',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `employee_code`, `user_name`, `profile_image`, `email_id`, `password`, `phone`, `dob`, `pan_card`, `aadhaar_card`, `date_of_joining`, `date_of_cessation`, `address`, `parent_id`, `otp`, `status`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, 'DECA0001', 'satish', 'profile_692d6c3daa3e57.99049354.png', 'satish1@gmail.com', '123456', '09949143133', '2025-11-05', 'HBGHH2323J', 23456543, '2025-11-27', NULL, 'Test 123', 0, NULL, 'Active', 1, '2025-11-27 18:36:27', NULL, '2025-12-01 15:56:28'),
(3, 'DECA0003', 'mahendar 123', 'profile_69299c3cd484a2.74666027.png', 'mahi@gmail.com', '123456', '1234567896', '1999-02-28', '', 0, '2025-11-28', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-28 11:16:29', NULL, '2025-12-01 18:55:29'),
(8, 'DECA0008', 'Test admin 2', 'profile_692d72d68f7412.14642569.jpg', 'testadmin2@gmail.com', '123456', '1234567898', '1998-02-03', 'JHYJH7677H', 1234567898, '2025-12-01', NULL, 'Test', 0, NULL, 'Active', 1, '2025-12-01 16:19:58', NULL, NULL),
(9, 'DECISE0009', 'sales m', 'profile_692d9338a1c815.30162838.png', 'inidesales@gmail.com', '123456', '1234567895', '1997-06-10', 'DFRED5654D', 2147483647, '2025-12-01', NULL, 'TEST test', 8, NULL, 'Active', 1, '2025-12-01 17:14:39', 1, '2025-12-01 19:28:59'),
(12, 'DECFSE0012', 'Field Sales 1', 'profile_692d979e412df9.67604852.jpg', 'fieldsales1@gmail.com', '123456', '1234568795', '1998-02-01', 'SDRS8767S', 2147483647, '2025-12-01', NULL, 'Test', 3, NULL, 'Active', 1, '2025-12-01 18:56:54', 1, '2025-12-01 19:27:21'),
(13, 'DECFSE0013', 'Field Sales 2', 'profile_692d9d6e310900.47721926.png', 'fieldsales2@gmail.com', '123456', '14234565245', '2025-12-01', 'SDED3423D', 2147483647, '2025-12-01', NULL, 'Test', 8, NULL, 'Active', 1, '2025-12-01 19:21:42', NULL, NULL),
(16, 'DECFSE0016', 'Sales Manager 1', 'profile_692da48c70e470.55190795.png', 'salesmanager1@gmail.com', '123456', '1256478568', '2025-12-01', 'HNGB5265S', 2147483647, '2025-12-01', NULL, 'Test', 3, NULL, 'Active', 1, '2025-12-01 19:44:35', 1, '2025-12-01 19:49:47'),
(20, 'DECISE0020', 'Sales Manager 1', 'profile_692db69f2a9829.03618989.png', 'test1@gmail.com', '123456', '1234567656', '2025-12-01', 'JHYGT6765G', 1234324345, '2025-12-01', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-01 21:07:26', NULL, NULL),
(24, 'DECFUE0024', 'Follow up executive ', 'profile_692dbd306ef378.23955229.png', 'test090@gmail.com', '123456', '5645654345', '2025-12-01', 'HTGF5654G', 2147483647, '2025-12-01', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-01 21:33:21', 1, '2025-12-01 21:34:14'),
(26, 'DECVM0026', 'Vender Manager 1', 'profile_692e5f5421a864.30542412.png', 'vender@demo.com', '123456', '1256478569', '2025-12-02', 'HYTG5654G', 2147483647, '2025-12-02', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-02 09:09:00', 1, '2025-12-02 09:09:25'),
(28, 'DECVM0028', 'Vendor test new', 'profile_692e607c77f6c1.33886165.PNG', 'vendor1@demo.com', '123456', '09949143133', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 8, NULL, 'Active', 1, '2025-12-02 09:13:56', NULL, NULL),
(29, 'DECAE0029', 'AE 1', 'profile_692e6379e9eba8.15496241.png', 'ae1@gmail.com', '123456', '2564585698', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-02 09:25:45', 1, '2025-12-02 09:26:03'),
(31, 'DECVM0031', 'Vender Manager 2', NULL, 'vendor12@demo.com', '123456', '2564586984', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-02 10:03:29', NULL, NULL),
(32, 'DECVM0032', 'vendor test test', 'profile_692ed91ca7b0f5.10762503.PNG', 'vendor@demo.com', '123456', '1234563454', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test tests', 26, NULL, 'Active', 1, '2025-12-02 17:37:37', 1, '2025-12-02 17:38:25'),
(34, 'DECFSE0034', 'Inside sales1 test', 'profile_692edd6a195ca5.72111140.jpg', 'inidesales76@gmail.com', '123456', '5654565456', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 20, NULL, 'Active', 1, '2025-12-02 18:06:58', NULL, NULL),
(36, 'DECISE0036', 'Inside sales1 test', 'profile_692ee02ed04633.63683510.png', 'inidesales78@gmail.com', '123456', '09949143133', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 0, NULL, 'Active', 1, '2025-12-02 18:18:46', NULL, NULL),
(37, 'DECISE0037', 'Inside sales1 test', 'profile_692ee09d106b95.06453703.png', 'inidesales67@gmail.com', '123456', '09949143133', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 20, NULL, 'Active', 1, '2025-12-02 18:19:52', 1, '2025-12-02 18:20:17'),
(39, 'DECSM0039', 'dfsdf', NULL, 'dsfsdf@gmail.com', '123456', '5546565656', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'dfsdfsdf', 3, NULL, 'Active', 1, '2025-12-09 12:29:15', NULL, NULL),
(43, 'DECSM0043', 'fsdfsdf', NULL, 'dfsdf@gmail.com', '123456', '2546554854', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-09 12:31:24', NULL, NULL),
(47, 'DECSM0047', 'vhvgj', NULL, 'jhghhbj@gmail.com', '56765434567', '765456789', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-09 14:16:34', NULL, NULL),
(48, 'DECSM0048', 'vhvgj', NULL, 'jhghsdasdhbj@gmail.com', '56765434567', '765456789', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-09 14:17:08', NULL, NULL),
(49, 'DECSM0049', 'vhvgj', NULL, 'jhghsdsdhbj@gmail.com', '56765434567', '765456789', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-09 14:17:35', NULL, NULL),
(50, 'DECSM0050', 'vhvgj', 'profile_6937f654a05d78.07984075.png', 'jhghsdshbj@gmail.com', '56765434567', '765456789', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-09 14:18:13', NULL, NULL),
(51, 'DECSM0051', 'vhvgj', NULL, 'jhghsdshbsaj@gmail.com', '56765434567', '765456789', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-09 14:18:44', NULL, NULL),
(54, 'DECSM0054', 'hjlkjfsdfs', NULL, 'sbkjdgasd@gmail.com', '3456765435345', '65454657545345', '2025-12-10', 'SDEF3433Ddfsfd', 2147483647, '2025-12-29', NULL, 'hsgdadfsdfdsfds', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(55, 'DECSM0055', 'dfsdfsd', NULL, 'satish@gmail.com', '546416541', '5646545', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'fgdfgfdg', 20, NULL, 'Active', 1, '2025-12-09 15:52:20', NULL, NULL),
(56, 'DECSM0056', 'sdfsdf', 'profile_6937f9e216fe25.48581359.png', 'satishyrtyrty@gmail.com', '445345', '34554353535345', '2025-12-09', 'SDEF3433D', 0, '2025-12-09', NULL, 'fgfg', 20, NULL, 'Active', 1, '2025-12-09 15:53:42', NULL, NULL),
(57, 'DECSM0057', 'dfsdfsdgfdgdf', 'profile_6937fb994bd784.16415801.png', 'satishfdfdfdsf@gmail.com', '24324324', '5435345345', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'gdfgfdg', 20, NULL, 'Active', 1, '2025-12-09 16:03:53', NULL, NULL),
(58, 'DECSM0058', 'ndfgndfgFGDGgdfgfdg', 'profile_6937fe8aa65219.16637424.png', 'dfdgdsf@gmail.com', '425465856', '256458565843454', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'dfdsfsdfdgfdgsfdgsfdg', 3, NULL, 'Active', 1, '2025-12-09 16:18:08', NULL, NULL),
(59, 'DECSM0059', 'gdfgdfg', NULL, 'fgdfg@gmail.com', '123456', '5264859759', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'dfgfdgdfg', 3, NULL, 'Active', 1, '2025-12-09 16:24:14', NULL, NULL),
(60, 'DECSM0060', 'vhvgjfsdfsdf', 'profile_6938009ec1b374.48970790.png', 'sbkjdasdasdgasd@gmail.com', '24324324', '65454657', '2025-12-23', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'sdasdasdsagfdgfsdgf', 26, NULL, 'Active', 1, '2025-12-09 16:26:47', NULL, NULL),
(61, 'DECSM0061', 'sfdsfsdf', 'profile_693801840ed722.60648771.png', 'jhgdsfsdhsdshbj@gmail.com', '24324324', '65454657', '2025-12-03', 'SDEF3433D', 2147483647, '2025-12-11', NULL, 'sdfsdfsdf', 3, NULL, 'Active', 1, '2025-12-09 16:31:24', NULL, NULL),
(62, 'DECSM0062', 'dfsfdsf', 'profile_6938028f49acd6.94505607.png', 'dfsfdsfsddf@gmail.com', '24324324', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'dsfsdfsdf erwerewr', 3, NULL, 'Active', 1, '2025-12-09 16:35:34', NULL, NULL);

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `t_users_archive` BEFORE DELETE ON `users` FOR EACH ROW INSERT INTO users_archive (select *, now() from users where users.user_id = old.user_id)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `t_users_audit` BEFORE UPDATE ON `users` FOR EACH ROW INSERT INTO users_audit (select * from users where users.user_id = old.user_id)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users_archive`
--

CREATE TABLE `users_archive` (
  `user_id` int(11) NOT NULL,
  `employee_code` varchar(111) DEFAULT NULL,
  `user_name` varchar(222) NOT NULL,
  `profile_image` varchar(2000) DEFAULT NULL,
  `email_id` varchar(222) NOT NULL,
  `password` varchar(111) NOT NULL,
  `phone` varchar(40) NOT NULL,
  `dob` date NOT NULL,
  `pan_card` varchar(22) DEFAULT NULL,
  `aadhaar_card` int(11) DEFAULT NULL,
  `date_of_joining` date NOT NULL,
  `date_of_cessation` date DEFAULT NULL,
  `address` varchar(555) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `otp` varchar(200) DEFAULT NULL,
  `status` varchar(500) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users_archive`
--

INSERT INTO `users_archive` (`user_id`, `employee_code`, `user_name`, `profile_image`, `email_id`, `password`, `phone`, `dob`, `pan_card`, `aadhaar_card`, `date_of_joining`, `date_of_cessation`, `address`, `parent_id`, `otp`, `status`, `created_by`, `created_on`, `updated_by`, `updated_on`, `deleted_on`) VALUES
(1, NULL, 'satish', 'profile_692836f86a3418.99511210.png', 'satish@gmail.com', '123456', '12346567879', '2002-07-26', 'SFRE5353F', 2147483647, '2025-11-27', NULL, 'TEST', 0, NULL, 'Active', 1, '2025-11-27 17:03:12', 0, NULL, '2025-11-27 17:03:44'),
(2, 'DECA0002', 'mahendar', 'profile_69284d0d131874.93279060.png', 'mahendhar@inriosft.com', '123456', '1247555445', '2024-06-13', 'SDRFGDDF', 453545345, '2025-11-27', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-27 18:37:25', 0, '2025-11-28 11:15:08', '2025-11-28 11:15:08'),
(4, 'DECA0004', 'Vamsi', 'profile_69297d5a4e5ac5.69976962.png', 'vamsi@inrisoft.com', '123456', '1234567898', '1998-06-28', 'JHGT7676J', 2147483647, '2025-11-28', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-28 16:15:46', 0, '2025-11-28 16:16:05', '2025-11-28 16:16:05'),
(5, 'DECA0005', 'test 12', 'profile_6929a421a1be80.48133979.png', 'satish@gmail.com', '123456', '1234567895', '1999-06-28', '', 0, '2025-11-28', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-28 18:58:57', 0, '2025-11-28 19:01:32', '2025-11-28 19:01:32'),
(6, 'DECSA0006', 'Super Admin1', 'profile_692d694a55be61.80860916.jpg', 'superadmin@gmail.com', '123456', '123454323', '2004-02-03', 'GHYG6765G', 2147483647, '2025-12-01', NULL, 'Test', 0, NULL, 'Active', 1, '2025-12-01 15:39:14', 0, '2025-12-01 15:59:14', '2025-12-01 15:59:14'),
(7, 'DECA0007', 'Test admin1', 'profile_692d7174005c84.30764709.jpg', 'testadmin@gmail.com', '123456', '1234567656', '1998-06-08', 'HUHY6765G', 123457654, '2025-12-01', NULL, 'test', 0, NULL, 'Active', 1, '2025-12-01 16:08:32', 0, '2025-12-01 16:16:08', '2025-12-01 16:16:08'),
(10, 'DECISE0010', 'Inside sales 2', 'profile_692d9091f311d1.79510749.png', 'insidesales2@gmail.com', '123456', '1235465897545', '2025-12-01', 'JKjs73263hd', 1256488565, '2025-12-02', NULL, 'tesrt', 8, NULL, 'Active', 1, '2025-12-01 18:26:50', 0, '2025-12-01 18:40:53', '2025-12-01 18:40:53'),
(11, 'DECISE0011', 'Inside sales1 test', 'profile_692d943f3fe860.37975016.png', 'insidesales2@gmail.com', '123456', '1235648595', '2025-12-01', 'SDEF5454F', 1256485956, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 18:41:55', 0, '2025-12-01 18:42:39', '2025-12-01 18:42:39'),
(14, 'DECISE0014', 'TEset', 'profile_692d9fdbf1e4f0.72102594.PNG', 'test1@gmail.com', '123456', '1256412568', '2025-12-01', 'DSER4534', 1256478595, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 19:32:03', 0, '2025-12-01 19:33:27', '2025-12-01 19:33:27'),
(15, 'DECFSE0015', 'test 1 ddgdg', 'profile_692da0a4b796a1.20174416.png', 'test1@gmail.com', '123456', '1256415685', '2025-12-01', 'SDED3432A', 2147483647, '2025-12-01', NULL, 'testfgfdgdfgdfg', 3, NULL, 'Active', 1, '2025-12-01 19:34:16', 0, '2025-12-01 19:35:39', '2025-12-01 19:35:39'),
(17, 'DECFSE0017', 'test gdfgdfg', 'profile_692da3eb09a1d6.54734794.png', 'test@gmail.com', '123456', '1256547859', '2025-12-01', 'SADE3423D', 2147483647, '2025-12-01', NULL, 'Test fgdfgdfg', 3, NULL, 'Active', 1, '2025-12-01 19:49:23', 0, '2025-12-01 19:52:54', '2025-12-01 19:52:54'),
(18, 'DECSA0018', 'test sa gyty', 'profile_692db1eee74ec7.43213382.png', 'testsa@gmail.com', '123456', '1234567890', '2025-12-01', 'JHTH7876H', 2147483647, '2025-12-01', NULL, 'TEST', 0, NULL, 'Active', 1, '2025-12-01 20:47:59', 0, '2025-12-01 20:52:27', '2025-12-01 20:52:27'),
(19, 'DECA0019', 'test admin', 'profile_692db4e70bd3d1.75308473.png', 'testadmin@gmail.com', '123456', '654567654', '2025-12-01', 'JUHU5454J', 2147483647, '2025-12-01', NULL, 'test', 0, NULL, 'Active', 1, '2025-12-01 20:58:57', 0, '2025-12-01 21:03:05', '2025-12-01 21:03:05'),
(21, 'DECISE0021', 'test ise 2', 'profile_692db6c28fc1d4.21457526.png', 'test12@gmail.com', '123456', '1234543456', '2025-12-01', 'HBGHH2323J', 2147483647, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 21:08:52', 0, '2025-12-01 21:09:57', '2025-12-01 21:09:57'),
(22, 'DECFSE0022', 'satish', 'profile_692db7d7107fe2.79751975.png', 'test12@gmail.com', '123456', '1232345434', '2025-12-01', 'HJYUG5654G', 2147483647, '2025-12-01', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-01 21:14:02', 0, '2025-12-01 21:15:10', '2025-12-01 21:15:10'),
(23, 'DECSM0023', 'test sm', 'profile_692db94a766969.99874981.png', 'test781@gmail.com', '123456', '3423567876', '2025-12-01', 'HGTF7656H', 2147483647, '2025-12-01', NULL, 'Test', 8, NULL, 'Active', 1, '2025-12-01 21:19:51', 0, '2025-12-01 21:20:52', '2025-12-01 21:20:52'),
(25, 'DECFUE0025', 'test hkgyub', 'profile_692dbda11dd160.67104311.png', 'testnew@gmail.com', '123456', '1234345654', '2025-12-01', 'JUHS6545G', 2147483647, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 21:38:31', 0, '2025-12-01 21:39:18', '2025-12-01 21:39:18'),
(27, 'DECVM0027', 'test', 'profile_692e600fc8eb45.83199235.jpg', 'testadmin@gmail.com', '123456', '2564875956', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-02 09:10:03', 0, '2025-12-02 09:13:20', '2025-12-02 09:13:20'),
(30, 'DECAE0030', 'test ae', 'profile_692e63af7e9769.57132843.png', 'testae@gmail.com', '123456', '2564856985', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'Test', 8, NULL, 'Active', 1, '2025-12-02 09:27:23', 0, '2025-12-02 09:27:42', '2025-12-02 09:27:42'),
(33, 'DECV0033', 'Vendor test new', 'profile_692ed6f3a807d5.71796118.png', 'vendor2@demo.com', '123456', '1232345456', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 31, NULL, 'Active', 1, '2025-12-02 17:39:23', 0, '2025-12-02 17:39:53', '2025-12-02 17:39:53'),
(35, 'DECFSE0035', 'satish test', 'profile_692ede949b1212.23583454.PNG', 'john@inrisoft.com', '123456', '09949143133', '2025-12-02', 'DFRED5654D', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 9, NULL, 'Active', 1, '2025-12-02 18:11:31', 0, '2025-12-02 18:12:26', '2025-12-02 18:12:26'),
(38, 'DECISE0038', 'Inside sales', 'profile_692ee0ee2e5f57.45628537.png', 'inidesales56@gmail.com', '123456', '09949143133', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 9, NULL, 'Active', 1, '2025-12-02 18:21:28', 0, '2025-12-02 18:22:09', '2025-12-02 18:22:09');

-- --------------------------------------------------------

--
-- Table structure for table `users_audit`
--

CREATE TABLE `users_audit` (
  `user_id` int(11) NOT NULL,
  `employee_code` varchar(111) DEFAULT NULL,
  `user_name` varchar(222) NOT NULL,
  `profile_image` varchar(2000) DEFAULT NULL,
  `email_id` varchar(222) NOT NULL,
  `password` varchar(111) NOT NULL,
  `phone` varchar(40) NOT NULL,
  `dob` date NOT NULL,
  `pan_card` varchar(22) NOT NULL,
  `aadhaar_card` int(11) NOT NULL,
  `date_of_joining` date NOT NULL,
  `date_of_cessation` date DEFAULT NULL,
  `address` varchar(555) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `otp` varchar(200) DEFAULT NULL,
  `status` varchar(500) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users_audit`
--

INSERT INTO `users_audit` (`user_id`, `employee_code`, `user_name`, `profile_image`, `email_id`, `password`, `phone`, `dob`, `pan_card`, `aadhaar_card`, `date_of_joining`, `date_of_cessation`, `address`, `parent_id`, `otp`, `status`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, NULL, 'satish', 'profile_69283e13210c36.04494110.png', 'satish@gmail.com', '123456', '1234567890', '1999-02-02', 'SDER3434', 132423434, '2025-11-27', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-27 17:33:31', NULL, NULL),
(2, NULL, 'Mahi', NULL, 'mahendhar@inriosft.com', '123456', '1234564589', '1998-06-27', '', 0, '2025-11-27', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-27 18:34:33', NULL, NULL),
(1, NULL, 'satish', 'profile_69284cd34f0408.33193505.jpg', 'satish@gmail.com', '123456', '09949143133', '2025-11-05', '', 0, '2025-11-27', NULL, 'test\r\ntest', 0, NULL, 'Active', 1, '2025-11-27 18:36:27', NULL, NULL),
(2, NULL, 'mahendar', 'profile_69284d0d131874.93279060.png', 'mahendhar@inriosft.com', '123456', '1247555445', '2024-06-13', 'SDRFGDDF', 453545345, '2025-11-27', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-27 18:37:25', NULL, NULL),
(1, 'DECA0001', 'satish', 'profile_69284cd34f0408.33193505.jpg', 'satish@gmail.com', '123456', '09949143133', '2025-11-05', '', 0, '2025-11-27', NULL, 'test\r\ntest', 0, NULL, 'Active', 1, '2025-11-27 18:36:27', NULL, NULL),
(1, 'DECA0001', 'satish', 'profile_69284cd34f0408.33193505.jpg', 'satish@gmail.com', '123456', '09949143133', '2025-11-05', '', 0, '2025-11-27', NULL, 'test\r\ntest', 0, NULL, 'Inactive', 1, '2025-11-27 18:36:27', NULL, '2025-11-28 09:31:21'),
(1, 'DECA0001', 'satish', 'profile_69284cd34f0408.33193505.jpg', 'satish@gmail.com', '123456', '09949143133', '2025-11-05', '', 0, '2025-11-27', NULL, 'test\r\ntest', 0, NULL, 'Active', 1, '2025-11-27 18:36:27', NULL, '2025-11-28 09:31:27'),
(1, 'DECA0001', 'satish', 'profile_69284cd34f0408.33193505.jpg', 'satish@gmail.com', '123456', '09949143133', '2025-11-05', '', 0, '2025-11-27', NULL, 'test\r\ntest', 0, NULL, 'Inactive', 1, '2025-11-27 18:36:27', NULL, '2025-11-28 09:31:45'),
(2, 'DECA0002', 'mahendar', 'profile_69284d0d131874.93279060.png', 'mahendhar@inriosft.com', '123456', '1247555445', '2024-06-13', 'SDRFGDDF', 453545345, '2025-11-27', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-27 18:37:25', NULL, NULL),
(3, NULL, 'mahendar', 'profile_692937355e9af2.98414663.png', 'mahi@gmail.com', '123456', '1234567896', '1999-02-28', '', 0, '2025-11-28', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-28 11:16:29', NULL, NULL),
(4, NULL, 'Vamsi', 'profile_69297d5a4e5ac5.69976962.png', 'vamsi@inrisoft.com', '123456', '1234567898', '1998-06-28', 'JHGT7676J', 2147483647, '2025-11-28', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-28 16:15:46', NULL, NULL),
(4, 'DECA0004', 'Vamsi', 'profile_69297d5a4e5ac5.69976962.png', 'vamsi@inrisoft.com', '123456', '1234567898', '1998-06-28', 'JHGT7676J', 2147483647, '2025-11-28', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-28 16:15:46', NULL, NULL),
(4, 'DECA0004', 'Vamsi', 'profile_69297d5a4e5ac5.69976962.png', 'vamsi@inrisoft.com', '123456', '1234567898', '1998-06-28', 'JHGT7676J', 2147483647, '2025-11-28', NULL, 'test', 0, NULL, 'Inactive', 1, '2025-11-28 16:15:46', NULL, '2025-11-28 16:15:54'),
(4, 'DECA0004', 'Vamsi', 'profile_69297d5a4e5ac5.69976962.png', 'vamsi@inrisoft.com', '123456', '1234567898', '1998-06-28', 'JHGT7676J', 2147483647, '2025-11-28', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-28 16:15:46', NULL, '2025-11-28 16:15:58'),
(1, 'DECA0001', 'satish', 'profile_69284cd34f0408.33193505.jpg', 'satish@gmail.com', '123456', '09949143133', '2025-11-05', '', 0, '2025-11-27', NULL, 'test\r\ntest', 0, NULL, 'Active', 1, '2025-11-27 18:36:27', NULL, '2025-11-28 09:31:49'),
(1, 'DECA0001', 'satish', 'profile_69284cd34f0408.33193505.jpg', 'satish@gmail.com', '123456', '09949143133', '2025-11-05', '', 0, '2025-11-27', NULL, 'test\r\ntest', 0, NULL, 'Active', 1, '2025-11-27 18:36:27', NULL, '2025-11-28 09:31:49'),
(1, 'DECA0001', 'satish', 'profile_69284cd34f0408.33193505.jpg', 'satish@gmail.com', '123456', '09949143133', '2025-11-05', '', 0, '2025-11-27', NULL, 'test\r\ntest', 0, NULL, 'Active', 1, '2025-11-27 18:36:27', NULL, '2025-11-28 09:31:49'),
(1, 'DECA0001', 'satish 123', 'profile_69284cd34f0408.33193505.jpg', 'satish1@gmail.com', '123456', '09949143133', '2025-11-05', 'HBGHH2323J', 0, '2025-11-27', NULL, 'test\r\ntest', 0, NULL, 'Active', 1, '2025-11-27 18:36:27', NULL, '2025-11-28 09:31:49'),
(1, 'DECA0001', 'satish 123', 'profile_69284cd34f0408.33193505.jpg', 'satish1@gmail.com', '123456', '09949143133', '2025-11-05', 'HBGHH2323J', 0, '2025-11-27', NULL, 'test\r\ntest', 0, NULL, 'Active', 1, '2025-11-27 18:36:27', NULL, '2025-11-28 09:31:49'),
(1, 'DECA0001', 'satish 123', 'profile_69284cd34f0408.33193505.jpg', 'satish1@gmail.com', '123456', '09949143133', '2025-11-05', 'HBGHH2323J', 0, '2025-11-27', NULL, 'Test 123', 0, NULL, 'Active', 1, '2025-11-27 18:36:27', NULL, '2025-11-28 09:31:49'),
(3, 'DECA0003', 'mahendar', 'profile_692937355e9af2.98414663.png', 'mahi@gmail.com', '123456', '1234567896', '1999-02-28', '', 0, '2025-11-28', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-28 11:16:29', NULL, NULL),
(3, 'DECA0003', 'mahendar 123', 'profile_69299c1cbd6813.22127280.PNG', 'mahi@gmail.com', '123456', '1234567896', '1999-02-28', '', 0, '2025-11-28', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-28 11:16:29', NULL, NULL),
(3, 'DECA0003', 'mahendar 123', 'profile_69299c3cd484a2.74666027.png', 'mahi@gmail.com', '123456', '1234567896', '1999-02-28', '', 0, '2025-11-28', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-28 11:16:29', NULL, NULL),
(5, NULL, 'test', 'profile_6929a399ac77d5.98931418.jpg', 'satish@gmail.com', '123456', '1234567895', '1999-06-28', '', 0, '2025-11-28', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-28 18:58:57', NULL, NULL),
(5, 'DECA0005', 'test', 'profile_6929a399ac77d5.98931418.jpg', 'satish@gmail.com', '123456', '1234567895', '1999-06-28', '', 0, '2025-11-28', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-28 18:58:57', NULL, NULL),
(5, 'DECA0005', 'test', 'profile_6929a399ac77d5.98931418.jpg', 'satish@gmail.com', '123456', '1234567895', '1999-06-28', '', 0, '2025-11-28', NULL, 'test', 0, NULL, 'Inactive', 1, '2025-11-28 18:58:57', NULL, '2025-11-28 18:59:06'),
(5, 'DECA0005', 'test', 'profile_6929a399ac77d5.98931418.jpg', 'satish@gmail.com', '123456', '1234567895', '1999-06-28', '', 0, '2025-11-28', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-28 18:58:57', NULL, '2025-11-28 18:59:11'),
(5, 'DECA0005', 'test 12', 'profile_6929a4126bd9d7.29155272.png', 'satish@gmail.com', '123456', '1234567895', '1999-06-28', '', 0, '2025-11-28', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-28 18:58:57', NULL, '2025-11-28 18:59:11'),
(5, 'DECA0005', 'test 12', 'profile_6929a421a1be80.48133979.png', 'satish@gmail.com', '123456', '1234567895', '1999-06-28', '', 0, '2025-11-28', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-28 18:58:57', NULL, '2025-11-28 18:59:11'),
(6, NULL, 'Super Admin1', 'profile_692d694a55be61.80860916.jpg', 'superadmin@gmail.com', '123456', '123454323', '2004-02-03', 'GHYG6765G', 2147483647, '2025-12-01', NULL, 'Test', 0, NULL, 'Active', 1, '2025-12-01 15:39:14', NULL, NULL),
(1, 'DECA0001', 'satish 123', 'profile_69299c02ba0a68.45026154.png', 'satish1@gmail.com', '123456', '09949143133', '2025-11-05', 'HBGHH2323J', 0, '2025-11-27', NULL, 'Test 123', 0, NULL, 'Active', 1, '2025-11-27 18:36:27', NULL, '2025-11-28 09:31:49'),
(1, 'DECA0001', 'satish', 'profile_692d6c066341f0.37853108.PNG', 'satish1@gmail.com', '123456', '09949143133', '2025-11-05', 'HBGHH2323J', 23456543, '2025-11-27', NULL, 'Test 123', 0, NULL, 'Active', 1, '2025-11-27 18:36:27', NULL, '2025-11-28 09:31:49'),
(1, 'DECA0001', 'satish', 'profile_692d6c3daa3e57.99049354.png', 'satish1@gmail.com', '123456', '09949143133', '2025-11-05', 'HBGHH2323J', 23456543, '2025-11-27', NULL, 'Test 123', 0, NULL, 'Active', 1, '2025-11-27 18:36:27', NULL, '2025-11-28 09:31:49'),
(1, 'DECA0001', 'satish', 'profile_692d6c3daa3e57.99049354.png', 'satish1@gmail.com', '123456', '09949143133', '2025-11-05', 'HBGHH2323J', 23456543, '2025-11-27', NULL, 'Test 123', 0, NULL, 'Inactive', 1, '2025-11-27 18:36:27', NULL, '2025-12-01 15:52:29'),
(1, 'DECA0001', 'satish', 'profile_692d6c3daa3e57.99049354.png', 'satish1@gmail.com', '123456', '09949143133', '2025-11-05', 'HBGHH2323J', 23456543, '2025-11-27', NULL, 'Test 123', 0, NULL, 'Active', 1, '2025-11-27 18:36:27', NULL, '2025-12-01 15:55:50'),
(1, 'DECA0001', 'satish', 'profile_692d6c3daa3e57.99049354.png', 'satish1@gmail.com', '123456', '09949143133', '2025-11-05', 'HBGHH2323J', 23456543, '2025-11-27', NULL, 'Test 123', 0, NULL, 'Inactive', 1, '2025-11-27 18:36:27', NULL, '2025-12-01 15:56:21'),
(6, 'DECSA0006', 'Super Admin1', 'profile_692d694a55be61.80860916.jpg', 'superadmin@gmail.com', '123456', '123454323', '2004-02-03', 'GHYG6765G', 2147483647, '2025-12-01', NULL, 'Test', 0, NULL, 'Active', 1, '2025-12-01 15:39:14', NULL, NULL),
(7, NULL, 'Test admin', 'profile_692d70283cb541.15097125.png', 'testadmin@gmail.com', '123456', '1234567656', '1998-06-08', 'HUHY6765G', 123457654, '2025-12-01', NULL, 'test', 0, NULL, 'Active', 1, '2025-12-01 16:08:32', NULL, NULL),
(7, 'DECA0007', 'Test admin', 'profile_692d70283cb541.15097125.png', 'testadmin@gmail.com', '123456', '1234567656', '1998-06-08', 'HUHY6765G', 123457654, '2025-12-01', NULL, 'test', 0, NULL, 'Active', 1, '2025-12-01 16:08:32', NULL, NULL),
(7, 'DECA0007', 'Test admin1', 'profile_692d70283cb541.15097125.png', 'testadmin@gmail.com', '123456', '1234567656', '1998-06-08', 'HUHY6765G', 123457654, '2025-12-01', NULL, 'test', 0, NULL, 'Active', 1, '2025-12-01 16:08:32', NULL, NULL),
(7, 'DECA0007', 'Test admin1', 'profile_692d7174005c84.30764709.jpg', 'testadmin@gmail.com', '123456', '1234567656', '1998-06-08', 'HUHY6765G', 123457654, '2025-12-01', NULL, 'test', 0, NULL, 'Active', 1, '2025-12-01 16:08:32', NULL, NULL),
(7, 'DECA0007', 'Test admin1', 'profile_692d7174005c84.30764709.jpg', 'testadmin@gmail.com', '123456', '1234567656', '1998-06-08', 'HUHY6765G', 123457654, '2025-12-01', NULL, 'test', 0, NULL, 'Inactive', 1, '2025-12-01 16:08:32', NULL, '2025-12-01 16:15:23'),
(7, 'DECA0007', 'Test admin1', 'profile_692d7174005c84.30764709.jpg', 'testadmin@gmail.com', '123456', '1234567656', '1998-06-08', 'HUHY6765G', 123457654, '2025-12-01', NULL, 'test', 0, NULL, 'Active', 1, '2025-12-01 16:08:32', NULL, '2025-12-01 16:15:28'),
(8, NULL, 'Test admin 2', 'profile_692d72d68f7412.14642569.jpg', 'testadmin2@gmail.com', '123456', '1234567898', '1998-02-03', 'JHYJH7677H', 1234567898, '2025-12-01', NULL, 'Test', 0, NULL, 'Active', 1, '2025-12-01 16:19:58', NULL, NULL),
(3, 'DECA0003', 'mahendar 123', 'profile_69299c3cd484a2.74666027.png', 'mahi@gmail.com', '123456', '1234567896', '1999-02-28', '', 0, '2025-11-28', NULL, 'test', 0, NULL, 'Active', 1, '2025-11-28 11:16:29', NULL, NULL),
(9, NULL, 'Inside sales1', NULL, 'inidesales@gmail.com', '123456', '1234567895', '1997-06-10', 'DFRED5654D', 2147483647, '2025-12-01', NULL, 'TEST', 8, NULL, 'Active', 1, '2025-12-01 17:14:39', NULL, NULL),
(9, 'DECISE0009', 'Inside sales1', NULL, 'inidesales@gmail.com', '123456', '1234567895', '1997-06-10', 'DFRED5654D', 2147483647, '2025-12-01', NULL, 'TEST', 8, NULL, 'Active', 1, '2025-12-01 17:14:39', NULL, NULL),
(9, 'DECISE0009', 'Inside sales1', NULL, 'inidesales@gmail.com', '123456', '1234567895', '1997-06-10', 'DFRED5654D', 2147483647, '2025-12-01', NULL, 'TEST', 8, NULL, 'Active', 1, '2025-12-01 17:14:39', 1, '2025-12-01 18:19:45'),
(9, 'DECISE0009', 'Inside sales1', NULL, 'inidesales@gmail.com', '123456', '1234567895', '1997-06-10', 'DFRED5654D', 2147483647, '2025-12-01', NULL, 'TEST', 8, NULL, 'Inactive', 1, '2025-12-01 17:14:39', 1, '2025-12-01 18:22:44'),
(10, NULL, 'Inside sales 2', 'profile_692d9091f311d1.79510749.png', 'insidesales2@gmail.com', '123456', '1235465897545', '2025-12-01', 'JKjs73263hd', 1256488565, '2025-12-02', NULL, 'tesrt', 8, NULL, 'Active', 1, '2025-12-01 18:26:50', NULL, NULL),
(10, 'DECISE0010', 'Inside sales 2', 'profile_692d9091f311d1.79510749.png', 'insidesales2@gmail.com', '123456', '1235465897545', '2025-12-01', 'JKjs73263hd', 1256488565, '2025-12-02', NULL, 'tesrt', 8, NULL, 'Active', 1, '2025-12-01 18:26:50', NULL, NULL),
(10, 'DECISE0010', 'Inside sales 2', 'profile_692d9091f311d1.79510749.png', 'insidesales2@gmail.com', '123456', '1235465897545', '2025-12-01', 'JKjs73263hd', 1256488565, '2025-12-02', NULL, 'tesrt', 8, NULL, 'Inactive', 1, '2025-12-01 18:26:50', 1, '2025-12-01 18:26:58'),
(9, 'DECISE0009', 'Inside sales1', NULL, 'inidesales@gmail.com', '123456', '1234567895', '1997-06-10', 'DFRED5654D', 2147483647, '2025-12-01', NULL, 'TEST', 8, NULL, 'Active', 1, '2025-12-01 17:14:39', 1, '2025-12-01 18:25:29'),
(9, 'DECISE0009', 'Inside sales1 test', 'profile_692d9338a1c815.30162838.png', 'inidesales@gmail.com', '123456', '1234567895', '1997-06-10', 'DFRED5654D', 2147483647, '2025-12-01', NULL, 'TEST test', 8, NULL, 'Active', 1, '2025-12-01 17:14:39', 1, '2025-12-01 18:25:29'),
(10, 'DECISE0010', 'Inside sales 2', 'profile_692d9091f311d1.79510749.png', 'insidesales2@gmail.com', '123456', '1235465897545', '2025-12-01', 'JKjs73263hd', 1256488565, '2025-12-02', NULL, 'tesrt', 8, NULL, 'Active', 1, '2025-12-01 18:26:50', 1, '2025-12-01 18:27:07'),
(11, NULL, 'Inside sales1 test', 'profile_692d941b40fe00.20876108.PNG', 'insidesales2@gmail.com', '123456', '1235648595', '2025-12-01', 'SDEF5454F', 1256485956, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 18:41:55', NULL, NULL),
(11, 'DECISE0011', 'Inside sales1 test', 'profile_692d941b40fe00.20876108.PNG', 'insidesales2@gmail.com', '123456', '1235648595', '2025-12-01', 'SDEF5454F', 1256485956, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 18:41:55', NULL, NULL),
(11, 'DECISE0011', 'Inside sales1 test', 'profile_692d941b40fe00.20876108.PNG', 'insidesales2@gmail.com', '123456', '1235648595', '2025-12-01', 'SDEF5454F', 1256485956, '2025-12-01', NULL, 'test', 8, NULL, 'Inactive', 1, '2025-12-01 18:41:55', 1, '2025-12-01 18:42:02'),
(11, 'DECISE0011', 'Inside sales1 test', 'profile_692d941b40fe00.20876108.PNG', 'insidesales2@gmail.com', '123456', '1235648595', '2025-12-01', 'SDEF5454F', 1256485956, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 18:41:55', 1, '2025-12-01 18:42:09'),
(11, 'DECISE0011', 'Inside sales1 test', 'profile_692d943f3fe860.37975016.png', 'insidesales2@gmail.com', '123456', '1235648595', '2025-12-01', 'SDEF5454F', 1256485956, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 18:41:55', 1, '2025-12-01 18:42:09'),
(3, 'DECA0003', 'mahendar 123', 'profile_69299c3cd484a2.74666027.png', 'mahi@gmail.com', '123456', '1234567896', '1999-02-28', '', 0, '2025-11-28', NULL, 'test', 0, NULL, 'Inactive', 1, '2025-11-28 11:16:29', NULL, '2025-12-01 16:20:06'),
(12, NULL, 'Field Sales 1', 'profile_692d979e412df9.67604852.jpg', 'fieldsales1@gmail.com', '123456', '1234568795', '1998-02-01', 'SDRS8767S', 2147483647, '2025-12-01', NULL, 'Test', 3, NULL, 'Active', 1, '2025-12-01 18:56:54', NULL, NULL),
(9, 'DECISE0009', 'Inside sales1 test', 'profile_692d9338a1c815.30162838.png', 'inidesales@gmail.com', '123456', '1234567895', '1997-06-10', 'DFRED5654D', 2147483647, '2025-12-01', NULL, 'TEST test', 8, NULL, 'Active', 1, '2025-12-01 17:14:39', 1, '2025-12-01 18:25:29'),
(9, 'DECISE0009', 'Inside sales1 test', 'profile_692d9338a1c815.30162838.png', 'inidesales@gmail.com', '123456', '1234567895', '1997-06-10', 'DFRED5654D', 2147483647, '2025-12-01', NULL, 'TEST test', 8, NULL, 'Inactive', 1, '2025-12-01 17:14:39', 1, '2025-12-01 19:20:14'),
(13, NULL, 'Field Sales 2', 'profile_692d9d6e310900.47721926.png', 'fieldsales2@gmail.com', '123456', '14234565245', '2025-12-01', 'SDED3423D', 2147483647, '2025-12-01', NULL, 'Test', 8, NULL, 'Active', 1, '2025-12-01 19:21:42', NULL, NULL),
(12, 'DECFSE0012', 'Field Sales 1', 'profile_692d979e412df9.67604852.jpg', 'fieldsales1@gmail.com', '123456', '1234568795', '1998-02-01', 'SDRS8767S', 2147483647, '2025-12-01', NULL, 'Test', 3, NULL, 'Active', 1, '2025-12-01 18:56:54', NULL, NULL),
(12, 'DECFSE0012', 'Field Sales 1', 'profile_692d979e412df9.67604852.jpg', 'fieldsales1@gmail.com', '123456', '1234568795', '1998-02-01', 'SDRS8767S', 2147483647, '2025-12-01', NULL, 'Test', 3, NULL, 'Inactive', 1, '2025-12-01 18:56:54', 1, '2025-12-01 19:27:14'),
(9, 'DECISE0009', 'Inside sales1 test', 'profile_692d9338a1c815.30162838.png', 'inidesales@gmail.com', '123456', '1234567895', '1997-06-10', 'DFRED5654D', 2147483647, '2025-12-01', NULL, 'TEST test', 8, NULL, 'Active', 1, '2025-12-01 17:14:39', 1, '2025-12-01 19:20:26'),
(9, 'DECISE0009', 'Inside sales1 test', 'profile_692d9338a1c815.30162838.png', 'inidesales@gmail.com', '123456', '1234567895', '1997-06-10', 'DFRED5654D', 2147483647, '2025-12-01', NULL, 'TEST test', 8, NULL, 'Inactive', 1, '2025-12-01 17:14:39', 1, '2025-12-01 19:28:51'),
(14, NULL, 'TEset', 'profile_692d9fdbf1e4f0.72102594.PNG', 'test1@gmail.com', '123456', '1256412568', '2025-12-01', 'DSER4534', 1256478595, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 19:32:03', NULL, NULL),
(14, 'DECISE0014', 'TEset', 'profile_692d9fdbf1e4f0.72102594.PNG', 'test1@gmail.com', '123456', '1256412568', '2025-12-01', 'DSER4534', 1256478595, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 19:32:03', NULL, NULL),
(14, 'DECISE0014', 'TEset', 'profile_692d9fdbf1e4f0.72102594.PNG', 'test1@gmail.com', '123456', '1256412568', '2025-12-01', 'DSER4534', 1256478595, '2025-12-01', NULL, 'test', 8, NULL, 'Inactive', 1, '2025-12-01 19:32:03', 1, '2025-12-01 19:32:12'),
(14, 'DECISE0014', 'TEset', 'profile_692d9fdbf1e4f0.72102594.PNG', 'test1@gmail.com', '123456', '1256412568', '2025-12-01', 'DSER4534', 1256478595, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 19:32:03', 1, '2025-12-01 19:32:27'),
(14, 'DECISE0014', 'TEset', 'profile_692d9fdbf1e4f0.72102594.PNG', 'test1@gmail.com', '123456', '1256412568', '2025-12-01', 'DSER4534', 1256478595, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 19:32:03', 1, '2025-12-01 19:32:27'),
(14, 'DECISE0014', 'TEset', 'profile_692d9fdbf1e4f0.72102594.PNG', 'test1@gmail.com', '123456', '1256412568', '2025-12-01', 'DSER4534', 1256478595, '2025-12-01', NULL, 'test', 8, NULL, 'Inactive', 1, '2025-12-01 19:32:03', 1, '2025-12-01 19:33:04'),
(14, 'DECISE0014', 'TEset', 'profile_692d9fdbf1e4f0.72102594.PNG', 'test1@gmail.com', '123456', '1256412568', '2025-12-01', 'DSER4534', 1256478595, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 19:32:03', 1, '2025-12-01 19:33:12'),
(14, 'DECISE0014', 'TEset', 'profile_692d9fdbf1e4f0.72102594.PNG', 'test1@gmail.com', '123456', '1256412568', '2025-12-01', 'DSER4534', 1256478595, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 19:32:03', 1, '2025-12-01 19:33:12'),
(15, NULL, 'test', 'profile_692da0601876c1.86385235.PNG', 'test1@gmail.com', '123456', '1256415685', '2025-12-01', 'SDED3432A', 2147483647, '2025-12-01', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-01 19:34:16', NULL, NULL),
(15, 'DECFSE0015', 'test', 'profile_692da0601876c1.86385235.PNG', 'test1@gmail.com', '123456', '1256415685', '2025-12-01', 'SDED3432A', 2147483647, '2025-12-01', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-01 19:34:16', NULL, NULL),
(15, 'DECFSE0015', 'test', 'profile_692da0601876c1.86385235.PNG', 'test1@gmail.com', '123456', '1256415685', '2025-12-01', 'SDED3432A', 2147483647, '2025-12-01', NULL, 'test', 3, NULL, 'Inactive', 1, '2025-12-01 19:34:16', 1, '2025-12-01 19:34:25'),
(15, 'DECFSE0015', 'test', 'profile_692da0601876c1.86385235.PNG', 'test1@gmail.com', '123456', '1256415685', '2025-12-01', 'SDED3432A', 2147483647, '2025-12-01', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-01 19:34:16', 1, '2025-12-01 19:34:32'),
(15, 'DECFSE0015', 'test 1', 'profile_692da0601876c1.86385235.PNG', 'test1@gmail.com', '123456', '1256415685', '2025-12-01', 'SDED3432A', 2147483647, '2025-12-01', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-01 19:34:16', 1, '2025-12-01 19:34:32'),
(15, 'DECFSE0015', 'test 1 ddgdg', 'profile_692da0a4b796a1.20174416.png', 'test1@gmail.com', '123456', '1256415685', '2025-12-01', 'SDED3432A', 2147483647, '2025-12-01', NULL, 'testfgfdgdfgdfg', 3, NULL, 'Active', 1, '2025-12-01 19:34:16', 1, '2025-12-01 19:34:32'),
(16, NULL, 'Sales Manager 1', NULL, 'salesmanager1@gmail.com', '123456', '1256478568', '2025-12-01', 'HNGB5265S', 2147483647, '2025-12-01', NULL, 'Test', 3, NULL, 'Active', 1, '2025-12-01 19:44:35', NULL, NULL),
(17, NULL, 'test', 'profile_692da3eb09a1d6.54734794.png', 'test@gmail.com', '123456', '1256547859', '2025-12-01', 'SADE3423D', 2147483647, '2025-12-01', NULL, 'Test', 3, NULL, 'Active', 1, '2025-12-01 19:49:23', NULL, NULL),
(16, 'DECFSE0016', 'Sales Manager 1', NULL, 'salesmanager1@gmail.com', '123456', '1256478568', '2025-12-01', 'HNGB5265S', 2147483647, '2025-12-01', NULL, 'Test', 3, NULL, 'Active', 1, '2025-12-01 19:44:35', NULL, NULL),
(16, 'DECFSE0016', 'Sales Manager 1', NULL, 'salesmanager1@gmail.com', '123456', '1256478568', '2025-12-01', 'HNGB5265S', 2147483647, '2025-12-01', NULL, 'Test', 3, NULL, 'Inactive', 1, '2025-12-01 19:44:35', 1, '2025-12-01 19:49:35'),
(16, 'DECFSE0016', 'Sales Manager 1', NULL, 'salesmanager1@gmail.com', '123456', '1256478568', '2025-12-01', 'HNGB5265S', 2147483647, '2025-12-01', NULL, 'Test', 3, NULL, 'Active', 1, '2025-12-01 19:44:35', 1, '2025-12-01 19:49:47'),
(17, 'DECFSE0017', 'test', 'profile_692da3eb09a1d6.54734794.png', 'test@gmail.com', '123456', '1256547859', '2025-12-01', 'SADE3423D', 2147483647, '2025-12-01', NULL, 'Test', 3, NULL, 'Active', 1, '2025-12-01 19:49:23', NULL, NULL),
(17, 'DECFSE0017', 'test gdfgdfg', 'profile_692da3eb09a1d6.54734794.png', 'test@gmail.com', '123456', '1256547859', '2025-12-01', 'SADE3423D', 2147483647, '2025-12-01', NULL, 'Test fgdfgdfg', 3, NULL, 'Active', 1, '2025-12-01 19:49:23', NULL, NULL),
(18, NULL, 'test sa', NULL, 'testsa@gmail.com', '123456', '1234567890', '2025-12-01', 'JHTH7876H', 2147483647, '2025-12-01', NULL, 'TEST', 0, NULL, 'Active', 1, '2025-12-01 20:47:59', NULL, NULL),
(18, 'DECSA0018', 'test sa', NULL, 'testsa@gmail.com', '123456', '1234567890', '2025-12-01', 'JHTH7876H', 2147483647, '2025-12-01', NULL, 'TEST', 0, NULL, 'Active', 1, '2025-12-01 20:47:59', NULL, NULL),
(18, 'DECSA0018', 'test sa gyty', 'profile_692db1eee74ec7.43213382.png', 'testsa@gmail.com', '123456', '1234567890', '2025-12-01', 'JHTH7876H', 2147483647, '2025-12-01', NULL, 'TEST', 0, NULL, 'Active', 1, '2025-12-01 20:47:59', NULL, NULL),
(18, 'DECSA0018', 'test sa gyty', 'profile_692db1eee74ec7.43213382.png', 'testsa@gmail.com', '123456', '1234567890', '2025-12-01', 'JHTH7876H', 2147483647, '2025-12-01', NULL, 'TEST', 0, NULL, 'Inactive', 1, '2025-12-01 20:47:59', 1, '2025-12-01 20:51:57'),
(18, 'DECSA0018', 'test sa gyty', 'profile_692db1eee74ec7.43213382.png', 'testsa@gmail.com', '123456', '1234567890', '2025-12-01', 'JHTH7876H', 2147483647, '2025-12-01', NULL, 'TEST', 0, NULL, 'Active', 1, '2025-12-01 20:47:59', 1, '2025-12-01 20:52:06'),
(19, NULL, 'test admin', NULL, 'testadmin@gmail.com', '123456', '654567654', '2025-12-01', 'JUHU5454J', 2147483647, '2025-12-01', NULL, 'test', 0, NULL, 'Active', 1, '2025-12-01 20:58:57', NULL, NULL),
(19, 'DECA0019', 'test admin', NULL, 'testadmin@gmail.com', '123456', '654567654', '2025-12-01', 'JUHU5454J', 2147483647, '2025-12-01', NULL, 'test', 0, NULL, 'Active', 1, '2025-12-01 20:58:57', NULL, NULL),
(19, 'DECA0019', 'test admin', NULL, 'testadmin@gmail.com', '123456', '654567654', '2025-12-01', 'JUHU5454J', 2147483647, '2025-12-01', NULL, 'test', 0, NULL, 'Inactive', 1, '2025-12-01 20:58:57', 1, '2025-12-01 21:00:14'),
(19, 'DECA0019', 'test admin', NULL, 'testadmin@gmail.com', '123456', '654567654', '2025-12-01', 'JUHU5454J', 2147483647, '2025-12-01', NULL, 'test', 0, NULL, 'Active', 1, '2025-12-01 20:58:57', 1, '2025-12-01 21:00:21'),
(19, 'DECA0019', 'test admin', 'profile_692db4e70bd3d1.75308473.png', 'testadmin@gmail.com', '123456', '654567654', '2025-12-01', 'JUHU5454J', 2147483647, '2025-12-01', NULL, 'test', 0, NULL, 'Active', 1, '2025-12-01 20:58:57', 1, '2025-12-01 21:00:21'),
(19, 'DECA0019', 'test admin', 'profile_692db4e70bd3d1.75308473.png', 'testadmin@gmail.com', '123456', '654567654', '2025-12-01', 'JUHU5454J', 2147483647, '2025-12-01', NULL, 'test', 0, NULL, 'Active', 1, '2025-12-01 20:58:57', 1, '2025-12-01 21:00:21'),
(20, NULL, 'test ise', NULL, 'test1@gmail.com', '123456', '1234567656', '2025-12-01', 'JHYGT6765G', 1234324345, '2025-12-01', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-01 21:07:26', NULL, NULL),
(21, NULL, 'test ise 2', 'profile_692db68c2db083.38061226.jpg', 'test12@gmail.com', '123456', '1234543456', '2025-12-01', 'HBGHH2323J', 2147483647, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 21:08:52', NULL, NULL),
(20, 'DECISE0020', 'test ise', NULL, 'test1@gmail.com', '123456', '1234567656', '2025-12-01', 'JHYGT6765G', 1234324345, '2025-12-01', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-01 21:07:26', NULL, NULL),
(21, 'DECISE0021', 'test ise 2', 'profile_692db68c2db083.38061226.jpg', 'test12@gmail.com', '123456', '1234543456', '2025-12-01', 'HBGHH2323J', 2147483647, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 21:08:52', NULL, NULL),
(21, 'DECISE0021', 'test ise 2', 'profile_692db68c2db083.38061226.jpg', 'test12@gmail.com', '123456', '1234543456', '2025-12-01', 'HBGHH2323J', 2147483647, '2025-12-01', NULL, 'test', 8, NULL, 'Inactive', 1, '2025-12-01 21:08:52', 1, '2025-12-01 21:09:24'),
(21, 'DECISE0021', 'test ise 2', 'profile_692db68c2db083.38061226.jpg', 'test12@gmail.com', '123456', '1234543456', '2025-12-01', 'HBGHH2323J', 2147483647, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 21:08:52', 1, '2025-12-01 21:09:32'),
(21, 'DECISE0021', 'test ise 2', 'profile_692db6c28fc1d4.21457526.png', 'test12@gmail.com', '123456', '1234543456', '2025-12-01', 'HBGHH2323J', 2147483647, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 21:08:52', 1, '2025-12-01 21:09:32'),
(22, NULL, 'satish', NULL, 'test12@gmail.com', '123456', '1232345434', '2025-12-01', 'HJYUG5654G', 2147483647, '2025-12-01', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-01 21:14:02', NULL, NULL),
(22, 'DECFSE0022', 'satish', NULL, 'test12@gmail.com', '123456', '1232345434', '2025-12-01', 'HJYUG5654G', 2147483647, '2025-12-01', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-01 21:14:02', NULL, NULL),
(22, 'DECFSE0022', 'satish', 'profile_692db7d7107fe2.79751975.png', 'test12@gmail.com', '123456', '1232345434', '2025-12-01', 'HJYUG5654G', 2147483647, '2025-12-01', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-01 21:14:02', NULL, NULL),
(22, 'DECFSE0022', 'satish', 'profile_692db7d7107fe2.79751975.png', 'test12@gmail.com', '123456', '1232345434', '2025-12-01', 'HJYUG5654G', 2147483647, '2025-12-01', NULL, 'test', 3, NULL, 'Inactive', 1, '2025-12-01 21:14:02', 1, '2025-12-01 21:14:30'),
(22, 'DECFSE0022', 'satish', 'profile_692db7d7107fe2.79751975.png', 'test12@gmail.com', '123456', '1232345434', '2025-12-01', 'HJYUG5654G', 2147483647, '2025-12-01', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-01 21:14:02', 1, '2025-12-01 21:14:37'),
(23, NULL, 'test sm', NULL, 'test781@gmail.com', '123456', '3423567876', '2025-12-01', 'HGTF7656H', 2147483647, '2025-12-01', NULL, 'Test', 8, NULL, 'Active', 1, '2025-12-01 21:19:51', NULL, NULL),
(23, 'DECSM0023', 'test sm', NULL, 'test781@gmail.com', '123456', '3423567876', '2025-12-01', 'HGTF7656H', 2147483647, '2025-12-01', NULL, 'Test', 8, NULL, 'Active', 1, '2025-12-01 21:19:51', NULL, NULL),
(23, 'DECSM0023', 'test sm', NULL, 'test781@gmail.com', '123456', '3423567876', '2025-12-01', 'HGTF7656H', 2147483647, '2025-12-01', NULL, 'Test', 8, NULL, 'Inactive', 1, '2025-12-01 21:19:51', 1, '2025-12-01 21:19:59'),
(23, 'DECSM0023', 'test sm', NULL, 'test781@gmail.com', '123456', '3423567876', '2025-12-01', 'HGTF7656H', 2147483647, '2025-12-01', NULL, 'Test', 8, NULL, 'Active', 1, '2025-12-01 21:19:51', 1, '2025-12-01 21:20:06'),
(23, 'DECSM0023', 'test sm', 'profile_692db94a766969.99874981.png', 'test781@gmail.com', '123456', '3423567876', '2025-12-01', 'HGTF7656H', 2147483647, '2025-12-01', NULL, 'Test', 8, NULL, 'Active', 1, '2025-12-01 21:19:51', 1, '2025-12-01 21:20:06'),
(24, NULL, 'test fup', NULL, 'test090@gmail.com', '123456', '5645654345', '2025-12-01', 'HTGF5654G', 2147483647, '2025-12-01', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-01 21:33:21', NULL, NULL),
(24, 'DECFUE0024', 'test fup', NULL, 'test090@gmail.com', '123456', '5645654345', '2025-12-01', 'HTGF5654G', 2147483647, '2025-12-01', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-01 21:33:21', NULL, NULL),
(24, 'DECFUE0024', 'test fup', NULL, 'test090@gmail.com', '123456', '5645654345', '2025-12-01', 'HTGF5654G', 2147483647, '2025-12-01', NULL, 'test', 3, NULL, 'Inactive', 1, '2025-12-01 21:33:21', 1, '2025-12-01 21:34:02'),
(24, 'DECFUE0024', 'test fup', NULL, 'test090@gmail.com', '123456', '5645654345', '2025-12-01', 'HTGF5654G', 2147483647, '2025-12-01', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-01 21:33:21', 1, '2025-12-01 21:34:14'),
(25, NULL, 'test', 'profile_692dbd7fbd0754.01660523.PNG', 'testnew@gmail.com', '123456', '1234345654', '2025-12-01', 'JUHS6545G', 2147483647, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 21:38:31', NULL, NULL),
(25, 'DECFUE0025', 'test', 'profile_692dbd7fbd0754.01660523.PNG', 'testnew@gmail.com', '123456', '1234345654', '2025-12-01', 'JUHS6545G', 2147483647, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 21:38:31', NULL, NULL),
(25, 'DECFUE0025', 'test', 'profile_692dbd7fbd0754.01660523.PNG', 'testnew@gmail.com', '123456', '1234345654', '2025-12-01', 'JUHS6545G', 2147483647, '2025-12-01', NULL, 'test', 8, NULL, 'Inactive', 1, '2025-12-01 21:38:31', 1, '2025-12-01 21:38:41'),
(25, 'DECFUE0025', 'test', 'profile_692dbd7fbd0754.01660523.PNG', 'testnew@gmail.com', '123456', '1234345654', '2025-12-01', 'JUHS6545G', 2147483647, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 21:38:31', 1, '2025-12-01 21:38:48'),
(25, 'DECFUE0025', 'test hkgyub', 'profile_692dbda11dd160.67104311.png', 'testnew@gmail.com', '123456', '1234345654', '2025-12-01', 'JUHS6545G', 2147483647, '2025-12-01', NULL, 'test', 8, NULL, 'Active', 1, '2025-12-01 21:38:31', 1, '2025-12-01 21:38:48'),
(26, NULL, 'Vender Manager 1', 'profile_692e5f5421a864.30542412.png', 'vender@demo.com', '123456', '1256478569', '2025-12-02', 'HYTG5654G', 2147483647, '2025-12-02', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-02 09:09:00', NULL, NULL),
(26, 'DECVM0026', 'Vender Manager 1', 'profile_692e5f5421a864.30542412.png', 'vender@demo.com', '123456', '1256478569', '2025-12-02', 'HYTG5654G', 2147483647, '2025-12-02', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-02 09:09:00', NULL, NULL),
(26, 'DECVM0026', 'Vender Manager 1', 'profile_692e5f5421a864.30542412.png', 'vender@demo.com', '123456', '1256478569', '2025-12-02', 'HYTG5654G', 2147483647, '2025-12-02', NULL, 'test', 3, NULL, 'Inactive', 1, '2025-12-02 09:09:00', 1, '2025-12-02 09:09:16'),
(27, NULL, 'test', NULL, 'testadmin@gmail.com', '123456', '2564875956', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-02 09:10:03', NULL, NULL),
(27, 'DECVM0027', 'test', NULL, 'testadmin@gmail.com', '123456', '2564875956', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-02 09:10:03', NULL, NULL),
(27, 'DECVM0027', 'test', 'profile_692e600fc8eb45.83199235.jpg', 'testadmin@gmail.com', '123456', '2564875956', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-02 09:10:03', NULL, NULL),
(27, 'DECVM0027', 'test', 'profile_692e600fc8eb45.83199235.jpg', 'testadmin@gmail.com', '123456', '2564875956', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-02 09:10:03', NULL, NULL),
(28, NULL, 'Vendor test new', 'profile_692e607c77f6c1.33886165.PNG', 'vendor1@demo.com', '123456', '09949143133', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 8, NULL, 'Active', 1, '2025-12-02 09:13:56', NULL, NULL),
(29, NULL, 'AE 1', 'profile_692e63414930a7.57640757.png', 'ae1@gmail.com', '123456', '2564585698', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-02 09:25:45', NULL, NULL),
(29, 'DECAE0029', 'AE 1', 'profile_692e63414930a7.57640757.png', 'ae1@gmail.com', '123456', '2564585698', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-02 09:25:45', NULL, NULL),
(29, 'DECAE0029', 'AE 1', 'profile_692e63414930a7.57640757.png', 'ae1@gmail.com', '123456', '2564585698', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 3, NULL, 'Inactive', 1, '2025-12-02 09:25:45', 1, '2025-12-02 09:25:56'),
(29, 'DECAE0029', 'AE 1', 'profile_692e63414930a7.57640757.png', 'ae1@gmail.com', '123456', '2564585698', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-02 09:25:45', 1, '2025-12-02 09:26:03'),
(29, 'DECAE0029', 'AE 1', 'profile_692e636698c3c2.68980472.PNG', 'ae1@gmail.com', '123456', '2564585698', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test dfgdfgd', 3, NULL, 'Active', 1, '2025-12-02 09:25:45', 1, '2025-12-02 09:26:03'),
(30, NULL, 'test ae', NULL, 'testae@gmail.com', '123456', '2564856985', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'Test', 8, NULL, 'Active', 1, '2025-12-02 09:27:23', NULL, NULL),
(30, 'DECAE0030', 'test ae', NULL, 'testae@gmail.com', '123456', '2564856985', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'Test', 8, NULL, 'Active', 1, '2025-12-02 09:27:23', NULL, NULL),
(30, 'DECAE0030', 'test ae', 'profile_692e63af7e9769.57132843.png', 'testae@gmail.com', '123456', '2564856985', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'Test', 8, NULL, 'Active', 1, '2025-12-02 09:27:23', NULL, NULL),
(31, NULL, 'Vender Manager 2', NULL, 'vendor12@demo.com', '123456', '2564586984', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-02 10:03:29', NULL, NULL),
(32, NULL, 'vendor test', NULL, 'vendor@demo.com', '123456', '1234563454', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 26, NULL, 'Active', 1, '2025-12-02 17:37:37', NULL, NULL),
(32, 'DECVM0032', 'vendor test', NULL, 'vendor@demo.com', '123456', '1234563454', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 26, NULL, 'Active', 1, '2025-12-02 17:37:37', NULL, NULL),
(32, 'DECVM0032', 'vendor test', NULL, 'vendor@demo.com', '123456', '1234563454', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 26, NULL, 'Inactive', 1, '2025-12-02 17:37:37', 1, '2025-12-02 17:38:18'),
(33, NULL, 'Vendor test new', 'profile_692ed6f3a807d5.71796118.png', 'vendor2@demo.com', '123456', '1232345456', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 31, NULL, 'Active', 1, '2025-12-02 17:39:23', NULL, NULL),
(33, 'DECV0033', 'Vendor test new', 'profile_692ed6f3a807d5.71796118.png', 'vendor2@demo.com', '123456', '1232345456', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 31, NULL, 'Active', 1, '2025-12-02 17:39:23', NULL, NULL),
(33, 'DECV0033', 'Vendor test new', 'profile_692ed6f3a807d5.71796118.png', 'vendor2@demo.com', '123456', '1232345456', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 31, NULL, 'Inactive', 1, '2025-12-02 17:39:23', 1, '2025-12-02 17:39:32'),
(33, 'DECV0033', 'Vendor test new', 'profile_692ed6f3a807d5.71796118.png', 'vendor2@demo.com', '123456', '1232345456', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 31, NULL, 'Active', 1, '2025-12-02 17:39:23', 1, '2025-12-02 17:39:43'),
(32, 'DECVM0032', 'vendor test', NULL, 'vendor@demo.com', '123456', '1234563454', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 26, NULL, 'Active', 1, '2025-12-02 17:37:37', 1, '2025-12-02 17:38:25'),
(20, 'DECISE0020', 'test ise', 'profile_692db69f2a9829.03618989.png', 'test1@gmail.com', '123456', '1234567656', '2025-12-01', 'JHYGT6765G', 1234324345, '2025-12-01', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-01 21:07:26', NULL, NULL),
(9, 'DECISE0009', 'Inside sales1 test', 'profile_692d9338a1c815.30162838.png', 'inidesales@gmail.com', '123456', '1234567895', '1997-06-10', 'DFRED5654D', 2147483647, '2025-12-01', NULL, 'TEST test', 8, NULL, 'Active', 1, '2025-12-01 17:14:39', 1, '2025-12-01 19:28:59'),
(34, NULL, 'Inside sales1 test', 'profile_692edd6a195ca5.72111140.jpg', 'inidesales76@gmail.com', '123456', '5654565456', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-02 18:06:58', NULL, NULL),
(34, 'DECFSE0034', 'Inside sales1 test', 'profile_692edd6a195ca5.72111140.jpg', 'inidesales76@gmail.com', '123456', '5654565456', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-02 18:06:58', NULL, NULL),
(35, NULL, 'satish', NULL, 'john@inrisoft.com', '123456', '09949143133', '2025-12-02', 'DFRED5654D', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 9, NULL, 'Active', 1, '2025-12-02 18:11:31', NULL, NULL),
(35, 'DECFSE0035', 'satish', NULL, 'john@inrisoft.com', '123456', '09949143133', '2025-12-02', 'DFRED5654D', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 9, NULL, 'Active', 1, '2025-12-02 18:11:31', NULL, NULL),
(35, 'DECFSE0035', 'satish test', 'profile_692ede949b1212.23583454.PNG', 'john@inrisoft.com', '123456', '09949143133', '2025-12-02', 'DFRED5654D', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 9, NULL, 'Active', 1, '2025-12-02 18:11:31', NULL, NULL),
(35, 'DECFSE0035', 'satish test', 'profile_692ede949b1212.23583454.PNG', 'john@inrisoft.com', '123456', '09949143133', '2025-12-02', 'DFRED5654D', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 9, NULL, 'Inactive', 1, '2025-12-02 18:11:31', 1, '2025-12-02 18:12:07'),
(35, 'DECFSE0035', 'satish test', 'profile_692ede949b1212.23583454.PNG', 'john@inrisoft.com', '123456', '09949143133', '2025-12-02', 'DFRED5654D', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 9, NULL, 'Active', 1, '2025-12-02 18:11:31', 1, '2025-12-02 18:12:14'),
(36, NULL, 'Inside sales1 test', 'profile_692ee02ed04633.63683510.png', 'inidesales78@gmail.com', '123456', '09949143133', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 0, NULL, 'Active', 1, '2025-12-02 18:18:46', NULL, NULL),
(37, NULL, 'Inside sales1 test', NULL, 'inidesales67@gmail.com', '123456', '09949143133', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 20, NULL, 'Active', 1, '2025-12-02 18:19:52', NULL, NULL),
(37, 'DECISE0037', 'Inside sales1 test', NULL, 'inidesales67@gmail.com', '123456', '09949143133', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 20, NULL, 'Active', 1, '2025-12-02 18:19:52', NULL, NULL),
(37, 'DECISE0037', 'Inside sales1 test', NULL, 'inidesales67@gmail.com', '123456', '09949143133', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 20, NULL, 'Inactive', 1, '2025-12-02 18:19:52', 1, '2025-12-02 18:20:08'),
(37, 'DECISE0037', 'Inside sales1 test', NULL, 'inidesales67@gmail.com', '123456', '09949143133', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 20, NULL, 'Active', 1, '2025-12-02 18:19:52', 1, '2025-12-02 18:20:17'),
(38, NULL, 'Inside sales', NULL, 'inidesales56@gmail.com', '123456', '09949143133', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 9, NULL, 'Active', 1, '2025-12-02 18:21:28', NULL, NULL),
(38, 'DECISE0038', 'Inside sales', NULL, 'inidesales56@gmail.com', '123456', '09949143133', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 9, NULL, 'Active', 1, '2025-12-02 18:21:28', NULL, NULL),
(38, 'DECISE0038', 'Inside sales', NULL, 'inidesales56@gmail.com', '123456', '09949143133', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 9, NULL, 'Inactive', 1, '2025-12-02 18:21:28', 1, '2025-12-02 18:21:37'),
(38, 'DECISE0038', 'Inside sales', NULL, 'inidesales56@gmail.com', '123456', '09949143133', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 9, NULL, 'Active', 1, '2025-12-02 18:21:28', 1, '2025-12-02 18:21:44'),
(38, 'DECISE0038', 'Inside sales', 'profile_692ee0ee2e5f57.45628537.png', 'inidesales56@gmail.com', '123456', '09949143133', '2025-12-02', 'HBGHH2323J', 2147483647, '2025-12-02', NULL, 'test\r\ntest', 9, NULL, 'Active', 1, '2025-12-02 18:21:28', 1, '2025-12-02 18:21:44'),
(39, NULL, 'dfsdf', NULL, 'dsfsdf@gmail.com', '123456', '5546565656', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'dfsdfsdf', 3, NULL, 'Active', 1, '2025-12-09 12:29:15', NULL, NULL),
(43, NULL, 'fsdfsdf', NULL, 'dfsdf@gmail.com', '123456', '2546554854', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-09 12:31:24', NULL, NULL),
(47, NULL, 'vhvgj', NULL, 'jhghhbj@gmail.com', '56765434567', '765456789', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-09 14:16:34', NULL, NULL),
(48, NULL, 'vhvgj', NULL, 'jhghsdasdhbj@gmail.com', '56765434567', '765456789', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-09 14:17:08', NULL, NULL),
(49, NULL, 'vhvgj', NULL, 'jhghsdsdhbj@gmail.com', '56765434567', '765456789', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-09 14:17:35', NULL, NULL),
(50, NULL, 'vhvgj', NULL, 'jhghsdshbj@gmail.com', '56765434567', '765456789', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-09 14:18:13', NULL, NULL),
(51, NULL, 'vhvgj', NULL, 'jhghsdshbsaj@gmail.com', '56765434567', '765456789', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-09 14:18:44', NULL, NULL),
(54, NULL, 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(54, 'DECSM0054', 'hjlkj', NULL, 'sbkjdgasd@gmail.com', '34567654', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'hsgda', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(49, 'DECSM0049', 'vhvgj', NULL, 'jhghsdsdhbj@gmail.com', '56765434567', '765456789', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-09 14:17:35', NULL, NULL),
(49, 'DECSM0049', 'vhvgj', NULL, 'jhghsdsdhbj@gmail.com', '56765434567', '765456789', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-09 14:17:35', NULL, NULL),
(54, 'DECSM0054', 'hjlkjfsdfs', NULL, 'sbkjdgasd@gmail.com', '3456765435345', '65454657545345', '2025-12-10', 'SDEF3433Ddfsfd', 2147483647, '2025-12-29', NULL, 'hsgdadfsdfdsfds', 3, NULL, 'Active', 1, '2025-12-09 14:30:51', NULL, NULL),
(50, 'DECSM0050', 'vhvgj', NULL, 'jhghsdshbj@gmail.com', '56765434567', '765456789', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-09 14:18:13', NULL, NULL),
(50, 'DECSM0050', 'vhvgj', 'profile_6937f654a05d78.07984075.png', 'jhghsdshbj@gmail.com', '56765434567', '765456789', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-09 14:18:13', NULL, NULL),
(50, 'DECSM0050', 'vhvgj', 'profile_6937f654a05d78.07984075.png', 'jhghsdshbj@gmail.com', '56765434567', '765456789', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-09 14:18:13', NULL, NULL),
(50, 'DECSM0050', 'vhvgj', 'profile_6937f654a05d78.07984075.png', 'jhghsdshbj@gmail.com', '56765434567', '765456789', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-09 14:18:13', NULL, NULL),
(50, 'DECSM0050', 'vhvgj', 'profile_6937f654a05d78.07984075.png', 'jhghsdshbj@gmail.com', '56765434567', '765456789', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'test', 3, NULL, 'Active', 1, '2025-12-09 14:18:13', NULL, NULL),
(55, NULL, 'dfsdfsd', NULL, 'satish@gmail.com', '546416541', '5646545', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'fgdfgfdg', 20, NULL, 'Active', 1, '2025-12-09 15:52:20', NULL, NULL),
(56, NULL, 'sdfsdf', NULL, 'satishyrtyrty@gmail.com', '445345', '34554353535345', '2025-12-09', 'SDEF3433D', 0, '2025-12-09', NULL, 'fgfg', 20, NULL, 'Active', 1, '2025-12-09 15:53:42', NULL, NULL),
(56, 'DECSM0056', 'sdfsdf', NULL, 'satishyrtyrty@gmail.com', '445345', '34554353535345', '2025-12-09', 'SDEF3433D', 0, '2025-12-09', NULL, 'fgfg', 20, NULL, 'Active', 1, '2025-12-09 15:53:42', NULL, NULL),
(56, 'DECSM0056', 'sdfsdf', NULL, 'satishyrtyrty@gmail.com', '445345', '34554353535345', '2025-12-09', 'SDEF3433D', 0, '2025-12-09', NULL, 'fgfg', 20, NULL, 'Active', 1, '2025-12-09 15:53:42', NULL, NULL),
(56, 'DECSM0056', 'sdfsdf', NULL, 'satishyrtyrty@gmail.com', '445345', '34554353535345', '2025-12-09', 'SDEF3433D', 0, '2025-12-09', NULL, 'fgfg', 20, NULL, 'Active', 1, '2025-12-09 15:53:42', NULL, NULL);
INSERT INTO `users_audit` (`user_id`, `employee_code`, `user_name`, `profile_image`, `email_id`, `password`, `phone`, `dob`, `pan_card`, `aadhaar_card`, `date_of_joining`, `date_of_cessation`, `address`, `parent_id`, `otp`, `status`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(57, NULL, 'dfsdfsd', NULL, 'satishfdfdsf@gmail.com', '24324324', '5435345345', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'gdfgfdg', 20, NULL, 'Active', 1, '2025-12-09 16:03:53', NULL, NULL),
(57, 'DECSM0057', 'dfsdfsd', NULL, 'satishfdfdsf@gmail.com', '24324324', '5435345345', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'gdfgfdg', 20, NULL, 'Active', 1, '2025-12-09 16:03:53', NULL, NULL),
(57, 'DECSM0057', 'dfsdfsd', NULL, 'satishfdfdsf@gmail.com', '24324324', '5435345345', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'gdfgfdg', 20, NULL, 'Active', 1, '2025-12-09 16:03:53', NULL, NULL),
(57, 'DECSM0057', 'dfsdfsdgfdgdf', 'profile_6937fb994bd784.16415801.png', 'satishfdfdfdsf@gmail.com', '24324324', '5435345345', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'gdfgfdg', 20, NULL, 'Active', 1, '2025-12-09 16:03:53', NULL, NULL),
(57, 'DECSM0057', 'dfsdfsdgfdgdf', 'profile_6937fb994bd784.16415801.png', 'satishfdfdfdsf@gmail.com', '24324324', '5435345345', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'gdfgfdg', 20, NULL, 'Active', 1, '2025-12-09 16:03:53', NULL, NULL),
(57, 'DECSM0057', 'dfsdfsdgfdgdf', 'profile_6937fb994bd784.16415801.png', 'satishfdfdfdsf@gmail.com', '24324324', '5435345345', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'gdfgfdg', 20, NULL, 'Active', 1, '2025-12-09 16:03:53', NULL, NULL),
(57, 'DECSM0057', 'dfsdfsdgfdgdf', 'profile_6937fb994bd784.16415801.png', 'satishfdfdfdsf@gmail.com', '24324324', '5435345345', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'gdfgfdg', 20, NULL, 'Active', 1, '2025-12-09 16:03:53', NULL, NULL),
(58, NULL, 'ndfgndfgFGDG', NULL, 'dfdgdsf@gmail.com', '4254658', '25645856584', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'dfdsfsd', 3, NULL, 'Active', 1, '2025-12-09 16:18:08', NULL, NULL),
(58, 'DECSM0058', 'ndfgndfgFGDG', NULL, 'dfdgdsf@gmail.com', '4254658', '25645856584', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'dfdsfsd', 3, NULL, 'Active', 1, '2025-12-09 16:18:08', NULL, NULL),
(59, NULL, 'gdfgdfg', NULL, 'fgdfg@gmail.com', '123456', '5264859759', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'dfgfdgdfg', 3, NULL, 'Active', 1, '2025-12-09 16:24:14', NULL, NULL),
(60, NULL, 'vhvgj', NULL, 'sbkjdasdasdgasd@gmail.com', '24324324', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'sdasdasdsa', 26, NULL, 'Active', 1, '2025-12-09 16:26:47', NULL, NULL),
(60, 'DECSM0060', 'vhvgj', NULL, 'sbkjdasdasdgasd@gmail.com', '24324324', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'sdasdasdsa', 26, NULL, 'Active', 1, '2025-12-09 16:26:47', NULL, NULL),
(60, 'DECSM0060', 'vhvgjfsdfsdf', NULL, 'sbkjdasdasdgasd@gmail.com', '24324324', '65454657', '2025-12-23', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'sdasdasdsagfdgfsdgf', 26, NULL, 'Active', 1, '2025-12-09 16:26:47', NULL, NULL),
(61, NULL, 'sfdsfsdf', 'profile_693801840ed722.60648771.png', 'jhgdsfsdhsdshbj@gmail.com', '24324324', '65454657', '2025-12-03', 'SDEF3433D', 2147483647, '2025-12-11', NULL, 'sdfsdfsdf', 3, NULL, 'Active', 1, '2025-12-09 16:31:24', NULL, NULL),
(61, 'DECSM0061', 'sfdsfsdf', 'profile_693801840ed722.60648771.png', 'jhgdsfsdhsdshbj@gmail.com', '24324324', '65454657', '2025-12-03', 'SDEF3433D', 2147483647, '2025-12-11', NULL, 'sdfsdfsdf', 3, NULL, 'Active', 1, '2025-12-09 16:31:24', NULL, NULL),
(62, NULL, 'dfsfdsf', NULL, 'dfsfdsfsddf@gmail.com', '24324324', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'dsfsdfsdf', 3, NULL, 'Active', 1, '2025-12-09 16:35:34', NULL, NULL),
(62, 'DECSM0062', 'dfsfdsf', NULL, 'dfsfdsfsddf@gmail.com', '24324324', '65454657', '2025-12-09', 'SDEF3433D', 2147483647, '2025-12-09', NULL, 'dsfsdfsdf', 3, NULL, 'Active', 1, '2025-12-09 16:35:34', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_bank_details`
--

CREATE TABLE `user_bank_details` (
  `user_bank_detail_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bank_account_number` varchar(1000) DEFAULT NULL,
  `ifsc_code` varchar(1000) NOT NULL,
  `bank_name` varchar(1000) NOT NULL,
  `branch_name` varchar(1000) NOT NULL,
  `bank_passbook_image` varchar(1000) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_bank_details`
--

INSERT INTO `user_bank_details` (`user_bank_detail_id`, `user_id`, `bank_account_number`, `ifsc_code`, `bank_name`, `branch_name`, `bank_passbook_image`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, 47, '51448758958', 'ettete55145', 'fdgdfgdf', 'fgdfgdfg', '', 1, '2025-12-09 14:16:34', NULL, NULL),
(2, 48, '51448758958', 'ettete55145', 'fdgdfgdf', 'fgdfgdfg', '', 1, '2025-12-09 14:17:08', NULL, NULL),
(3, 49, '51448758958', 'ettete55145', 'fdgdfgdf', 'fgdfgdfg', 'passbook_6937f528b94579.88653184.jpg', 1, '2025-12-09 14:17:35', 1, '2025-12-09 15:39:02'),
(4, 50, '51448758958', 'ettete55145', 'fdgdfgdf', 'fgdfgdfg', 'passbook_6937f654a1e7d2.66758607.jpg', 1, '2025-12-09 14:18:13', 1, '2025-12-09 15:46:02'),
(5, 51, '51448758958', 'ettete55145', 'fdgdfgdf', 'fgdfgdfg', '', 1, '2025-12-09 14:18:44', NULL, NULL),
(6, 54, '875867765875', 'ifsc_code3434', 'fdgdfgdf43434', 'fgdfgdfg4334r3', 'passbook_6937f5121d6045.53912467.jpg', 1, '2025-12-09 14:30:51', 1, '2025-12-09 15:39:47'),
(7, 55, '5646456', 'ettete55145', 'gfgdg', 'fdgdfgfdg', 'bank_passbook_6937f85c1ef955.77793078.jpg', 1, '2025-12-09 15:52:20', NULL, NULL),
(8, 56, '56456456', 'fdr654656', 'yrytryrthfhgf', 'yrtytrytr', 'passbook_6937f9b6c19830.74314470.jpg', 1, '2025-12-09 15:53:42', 1, '2025-12-09 15:58:50'),
(9, 57, '6456456456', 'fgdfger65464', 'fsddsfdsf', 'dsfdsfdsf', 'passbook_6937fb994d15a5.26476776.png', 1, '2025-12-09 16:03:53', 1, '2025-12-09 16:08:38'),
(10, 58, '45345345656456', 'ssdfsdfsd', 'dfsdfdfsd', 'sdfsdfsdf', 'bank_passbook_6937fe68e51e77.20212755.png', 1, '2025-12-09 16:18:08', 1, '2025-12-09 16:18:42'),
(11, 59, '51448758958', 'ettete55145', 'dfsdfdfsd', 'sdfsdfsdf', 'bank_passbook_6937ffd6d8d373.14776726.png', 1, '2025-12-09 16:24:14', NULL, NULL),
(12, 60, '3423434435345345', 'rewr34234', 'rewrwer', 'sdfsdfsdf', 'passbook_6938008e923721.35882109.jpg', 1, '2025-12-09 16:26:47', 1, '2025-12-09 16:27:34'),
(13, 61, '6456456456', 'rewr34234', 'sdfsdfsdf', 'dsfdsfdsf', 'bank_passbook_69380184109104.92420150.png', 1, '2025-12-09 16:31:24', 1, '2025-12-09 16:32:08'),
(14, 62, '51448758958', 'dfsdf345435', 'dsfdsfsd', 'dsfsdfds', 'bank_passbook_6938027e440e38.31137147.png', 1, '2025-12-09 16:35:34', 1, '2025-12-09 16:35:51');

--
-- Triggers `user_bank_details`
--
DELIMITER $$
CREATE TRIGGER `t_user_bank_details_archive` BEFORE DELETE ON `user_bank_details` FOR EACH ROW INSERT INTO user_bank_details_archive (select *, now() from user_bank_details where user_bank_details.user_bank_detail_id = old.user_bank_detail_id)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `t_user_bank_details_audit` BEFORE UPDATE ON `user_bank_details` FOR EACH ROW INSERT INTO user_bank_details_audit (select * from user_bank_details where user_bank_details.user_bank_detail_id = old.user_bank_detail_id)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_bank_details_archive`
--

CREATE TABLE `user_bank_details_archive` (
  `user_bank_detail_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bank_account_number` varchar(1000) DEFAULT NULL,
  `ifsc_code` varchar(1000) NOT NULL,
  `bank_name` varchar(1000) NOT NULL,
  `branch_name` varchar(1000) NOT NULL,
  `bank_passbook_image` varchar(1000) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_bank_details_audit`
--

CREATE TABLE `user_bank_details_audit` (
  `user_bank_detail_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bank_account_number` varchar(1000) DEFAULT NULL,
  `ifsc_code` varchar(1000) NOT NULL,
  `bank_name` varchar(1000) NOT NULL,
  `branch_name` varchar(1000) NOT NULL,
  `bank_passbook_image` varchar(1000) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_bank_details_audit`
--

INSERT INTO `user_bank_details_audit` (`user_bank_detail_id`, `user_id`, `bank_account_number`, `ifsc_code`, `bank_name`, `branch_name`, `bank_passbook_image`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(6, 54, '875867765875', 'ifsc_code', 'fdgdfgdf', 'fgdfgdfg', 'bank_passbook_6937e5435b0a49.30914620.png', 1, '2025-12-09 14:30:51', NULL, NULL),
(6, 54, '875867765875', 'ifsc_code', 'fdgdfgdf', 'fgdfgdfg', 'bank_passbook_6937e5435b0a49.30914620.png', 1, '2025-12-09 14:30:51', 1, '2025-12-09 15:30:31'),
(6, 54, '875867765875', 'ifsc_code', 'fdgdfgdf', 'fgdfgdfg', 'passbook_6937f34c557546.55120643.jpg', 1, '2025-12-09 14:30:51', 1, '2025-12-09 15:30:44'),
(6, 54, '875867765875', 'ifsc_code', 'fdgdfgdf', 'fgdfgdfg', 'passbook_6937f388dae0f1.15094515.jpg', 1, '2025-12-09 14:30:51', 1, '2025-12-09 15:31:44'),
(3, 49, '51448758958', 'ettete55145', 'fdgdfgdf', 'fgdfgdfg', '', 1, '2025-12-09 14:17:35', NULL, NULL),
(3, 49, '51448758958', 'ettete55145', 'fdgdfgdf', 'fgdfgdfg', 'passbook_6937f528b94579.88653184.jpg', 1, '2025-12-09 14:17:35', 1, '2025-12-09 15:38:40'),
(6, 54, '875867765875', 'ifsc_code3434', 'fdgdfgdf43434', 'fgdfgdfg4334r3', 'passbook_6937f5121d6045.53912467.jpg', 1, '2025-12-09 14:30:51', 1, '2025-12-09 15:38:18'),
(4, 50, '51448758958', 'ettete55145', 'fdgdfgdf', 'fgdfgdfg', '', 1, '2025-12-09 14:18:13', NULL, NULL),
(4, 50, '51448758958', 'ettete55145', 'fdgdfgdf', 'fgdfgdfg', 'passbook_6937f654a1e7d2.66758607.jpg', 1, '2025-12-09 14:18:13', 1, '2025-12-09 15:43:40'),
(4, 50, '51448758958', 'ettete55145', 'fdgdfgdf', 'fgdfgdfg', 'passbook_6937f654a1e7d2.66758607.jpg', 1, '2025-12-09 14:18:13', 1, '2025-12-09 15:44:21'),
(4, 50, '51448758958', 'ettete55145', 'fdgdfgdf', 'fgdfgdfg', 'passbook_6937f654a1e7d2.66758607.jpg', 1, '2025-12-09 14:18:13', 1, '2025-12-09 15:45:02'),
(4, 50, '51448758958', 'ettete55145', 'fdgdfgdf', 'fgdfgdfg', 'passbook_6937f654a1e7d2.66758607.jpg', 1, '2025-12-09 14:18:13', 1, '2025-12-09 15:45:35'),
(8, 56, '56456456', 'fdr654656', 'yrytryrt', 'yrtytrytr', 'bank_passbook_6937f8ae42f4d6.93320149.jpg', 1, '2025-12-09 15:53:42', NULL, NULL),
(8, 56, '56456456', 'fdr654656', 'yrytryrthfhgf', 'yrtytrytr', 'passbook_6937f9b6c19830.74314470.jpg', 1, '2025-12-09 15:53:42', 1, '2025-12-09 15:58:06'),
(8, 56, '56456456', 'fdr654656', 'yrytryrthfhgf', 'yrtytrytr', 'passbook_6937f9b6c19830.74314470.jpg', 1, '2025-12-09 15:53:42', 1, '2025-12-09 15:58:30'),
(9, 57, '6456456456', 'fgdfger65464', 'fsddsfdsf', 'dsfdsfdsf', 'bank_passbook_6937fb1153d1d7.96472102.png', 1, '2025-12-09 16:03:53', NULL, NULL),
(9, 57, '6456456456', 'fgdfger65464', 'fsddsfdsf', 'dsfdsfdsf', 'bank_passbook_6937fb1153d1d7.96472102.png', 1, '2025-12-09 16:03:53', 1, '2025-12-09 16:05:31'),
(9, 57, '6456456456', 'fgdfger65464', 'fsddsfdsf', 'dsfdsfdsf', 'passbook_6937fb994d15a5.26476776.png', 1, '2025-12-09 16:03:53', 1, '2025-12-09 16:06:09'),
(9, 57, '6456456456', 'fgdfger65464', 'fsddsfdsf', 'dsfdsfdsf', 'passbook_6937fb994d15a5.26476776.png', 1, '2025-12-09 16:03:53', 1, '2025-12-09 16:06:54'),
(9, 57, '6456456456', 'fgdfger65464', 'fsddsfdsf', 'dsfdsfdsf', 'passbook_6937fb994d15a5.26476776.png', 1, '2025-12-09 16:03:53', 1, '2025-12-09 16:07:14'),
(9, 57, '6456456456', 'fgdfger65464', 'fsddsfdsf', 'dsfdsfdsf', 'passbook_6937fb994d15a5.26476776.png', 1, '2025-12-09 16:03:53', 1, '2025-12-09 16:07:54'),
(10, 58, '45345345', 'ssdfsdfsd', 'dfsdfdfsd', 'sdfsdfsdf', 'bank_passbook_6937fe68e51e77.20212755.png', 1, '2025-12-09 16:18:08', NULL, NULL),
(12, 60, 'd3423434', 'rewr34234', 'rewrwer', 'sdfsdfsdf', 'bank_passbook_6938006f4dcf94.48814723.png', 1, '2025-12-09 16:26:47', NULL, NULL),
(12, 60, '3423434435345345', 'rewr34234', 'rewrwer', 'sdfsdfsdf', 'passbook_6938008e923721.35882109.jpg', 1, '2025-12-09 16:26:47', 1, '2025-12-09 16:27:18'),
(13, 61, '6456456456', 'rewr34234', 'sdfsdfsdf', 'dsfdsfdsf', 'bank_passbook_69380184109104.92420150.png', 1, '2025-12-09 16:31:24', NULL, NULL),
(14, 62, '51448758958', 'dfsdf345435', 'dsfdsfsd', 'dsfsdfds', 'bank_passbook_6938027e440e38.31137147.png', 1, '2025-12-09 16:35:34', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_documents`
--

CREATE TABLE `user_documents` (
  `user_document_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_document_type` varchar(1000) DEFAULT NULL,
  `user_document_url` varchar(1000) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_documents`
--

INSERT INTO `user_documents` (`user_document_id`, `user_id`, `user_document_type`, `user_document_url`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, 43, 'PANCARD', 'pan_image_6937c944a82af3.58598635.png', 1, '2025-12-09 12:31:24', NULL, NULL),
(2, 43, 'AADHAAR CARD', 'aadhaar_image_6937c944a8cfc1.26912066.png', 1, '2025-12-09 12:31:24', NULL, NULL),
(3, 43, 'AGREEMENT', 'agreement_file_6937c944a95449.46966333.png', 1, '2025-12-09 12:31:24', NULL, NULL),
(4, 43, 'BANK PASSBOOK', 'bank_passbook_image_6937c944a9cf45.87459542.png', 1, '2025-12-09 12:31:24', NULL, NULL),
(5, 47, 'PANCARD', 'pan_image_6937e1ea0ef6a6.56299162.png', 1, '2025-12-09 14:16:34', NULL, NULL),
(6, 47, 'AADHAAR CARD', 'aadhaar_image_6937e1ea0f7a07.10406199.png', 1, '2025-12-09 14:16:34', NULL, NULL),
(7, 47, 'AGREEMENT', 'agreement_file_6937e1ea0fdf74.04185561.png', 1, '2025-12-09 14:16:34', NULL, NULL),
(8, 48, 'PANCARD', 'pan_image_6937e20c3940a5.92522156.png', 1, '2025-12-09 14:17:08', NULL, NULL),
(9, 48, 'AADHAAR CARD', 'aadhaar_image_6937e20c3a04b1.07813714.png', 1, '2025-12-09 14:17:08', NULL, NULL),
(10, 48, 'AGREEMENT', 'agreement_file_6937e20c3ad5f1.42347882.png', 1, '2025-12-09 14:17:08', NULL, NULL),
(11, 49, 'PANCARD', 'pan_image_6937e227d9e8d4.00624537.png', 1, '2025-12-09 14:17:35', NULL, NULL),
(12, 49, 'AADHAAR CARD', 'aadhaar_image_6937e227da7640.76733674.png', 1, '2025-12-09 14:17:35', NULL, NULL),
(13, 49, 'AGREEMENT', 'agreement_file_6937e227daf786.85807457.png', 1, '2025-12-09 14:17:35', NULL, NULL),
(14, 50, 'PANCARD', 'doc_6937f6c7786547.45566820.png', 1, '2025-12-09 14:18:13', 1, '2025-12-09 15:45:35'),
(15, 50, 'AADHAAR CARD', 'aadhaar_image_6937e24dabcac2.86471712.png', 1, '2025-12-09 14:18:13', NULL, NULL),
(16, 50, 'AGREEMENT', 'doc_6937f6c779f485.72198367.PNG', 1, '2025-12-09 14:18:13', 1, '2025-12-09 15:45:35'),
(17, 51, 'PANCARD', 'pan_image_6937e26cd03763.10298921.png', 1, '2025-12-09 14:18:44', NULL, NULL),
(18, 51, 'AADHAAR CARD', 'aadhaar_image_6937e26cd09cd9.72319087.png', 1, '2025-12-09 14:18:44', NULL, NULL),
(19, 51, 'AGREEMENT', 'agreement_file_6937e26cd0ed95.72615610.png', 1, '2025-12-09 14:18:44', NULL, NULL),
(20, 54, 'PANCARD', 'pan_image_6937e5435ba6d1.78512961.png', 1, '2025-12-09 14:30:51', NULL, NULL),
(21, 54, 'AADHAAR CARD', 'aadhaar_image_6937e5435c5a46.78544226.png', 1, '2025-12-09 14:30:51', NULL, NULL),
(22, 54, 'AGREEMENT', 'agreement_file_6937e5435cceb5.50894072.png', 1, '2025-12-09 14:30:51', NULL, NULL),
(23, 55, 'PANCARD', 'pan_image_6937f85c1f7e84.05045484.jpg', 1, '2025-12-09 15:52:20', NULL, NULL),
(24, 55, 'AADHAAR CARD', 'aadhaar_image_6937f85c1fd856.10928452.jpg', 1, '2025-12-09 15:52:20', NULL, NULL),
(25, 55, 'AGREEMENT', 'agreement_file_6937f85c202753.54480987.jpg', 1, '2025-12-09 15:52:20', NULL, NULL),
(26, 56, 'PANCARD', 'pan_image_6937f8ae438de5.06771905.png', 1, '2025-12-09 15:53:42', NULL, NULL),
(27, 56, 'AADHAAR CARD', 'aadhaar_image_6937f8ae4406a6.27174678.jpg', 1, '2025-12-09 15:53:42', NULL, NULL),
(28, 56, 'AGREEMENT', 'doc_6937f9ce966d14.05677393.PNG', 1, '2025-12-09 15:53:42', 1, '2025-12-09 15:58:30'),
(29, 57, 'PANCARD', 'doc_6937fc2ead1c00.69445842.jpg', 1, '2025-12-09 16:03:53', 1, '2025-12-09 16:08:38'),
(30, 57, 'AADHAAR CARD', 'aadhaar_image_6937fb1154ef84.42362968.jpg', 1, '2025-12-09 16:03:53', NULL, NULL),
(31, 57, 'AGREEMENT', 'doc_6937fbc63878f6.66077880.jpg', 1, '2025-12-09 16:03:53', 1, '2025-12-09 16:06:54'),
(32, 58, 'PANCARD', 'pan_image_6937fe68e5c0f3.33756772.PNG', 1, '2025-12-09 16:18:08', NULL, NULL),
(33, 58, 'AADHAAR CARD', 'aadhaar_image_6937fe68e64a14.67987380.png', 1, '2025-12-09 16:18:08', NULL, NULL),
(34, 58, 'AGREEMENT', 'agreement_file_6937fe68e70fc3.28258025.png', 1, '2025-12-09 16:18:08', NULL, NULL),
(35, 59, 'PANCARD', 'pan_image_6937ffd6d91d75.49573441.png', 1, '2025-12-09 16:24:14', NULL, NULL),
(36, 59, 'AADHAAR CARD', 'aadhaar_image_6937ffd6d957c5.50847369.png', 1, '2025-12-09 16:24:14', NULL, NULL),
(37, 59, 'AGREEMENT', 'agreement_file_6937ffd6d991e8.04712320.png', 1, '2025-12-09 16:24:14', NULL, NULL),
(38, 60, 'PANCARD', 'pan_image_6938006f4e23a4.57086990.png', 1, '2025-12-09 16:26:47', NULL, NULL),
(39, 60, 'AADHAAR CARD', 'aadhaar_image_6938006f4e7310.96586371.png', 1, '2025-12-09 16:26:47', NULL, NULL),
(40, 60, 'AGREEMENT', 'agreement_file_6938006f4ebcb5.70477933.png', 1, '2025-12-09 16:26:47', NULL, NULL),
(41, 61, 'PANCARD', 'pan_image_6938018410e407.19776916.jpg', 1, '2025-12-09 16:31:24', NULL, NULL),
(42, 61, 'AADHAAR CARD', 'aadhaar_image_69380184112ab7.32953784.png', 1, '2025-12-09 16:31:24', NULL, NULL),
(43, 61, 'AGREEMENT', 'agreement_file_69380184116968.49087085.jpg', 1, '2025-12-09 16:31:24', NULL, NULL),
(44, 62, 'PANCARD', 'pan_image_6938027e448705.41185826.png', 1, '2025-12-09 16:35:34', NULL, NULL),
(45, 62, 'AADHAAR CARD', 'aadhaar_image_6938027e44e2f5.00148474.png', 1, '2025-12-09 16:35:34', NULL, NULL),
(46, 62, 'AGREEMENT', 'agreement_file_6938027e452ea0.96036154.png', 1, '2025-12-09 16:35:34', NULL, NULL);

--
-- Triggers `user_documents`
--
DELIMITER $$
CREATE TRIGGER `t_user_documents_archive` BEFORE DELETE ON `user_documents` FOR EACH ROW INSERT INTO user_documents_archive (select *, now() from user_documents where user_documents.user_document_id = old.user_document_id)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `t_user_documents_audit` BEFORE UPDATE ON `user_documents` FOR EACH ROW INSERT INTO user_documents_audit (select * from user_documents where user_documents.user_document_id = old.user_document_id)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_documents_archive`
--

CREATE TABLE `user_documents_archive` (
  `user_document_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_document_type` varchar(1000) DEFAULT NULL,
  `user_document_url` varchar(1000) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_documents_audit`
--

CREATE TABLE `user_documents_audit` (
  `user_document_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_document_type` varchar(1000) DEFAULT NULL,
  `user_document_url` varchar(1000) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_documents_audit`
--

INSERT INTO `user_documents_audit` (`user_document_id`, `user_id`, `user_document_type`, `user_document_url`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(14, 50, 'PANCARD', 'pan_image_6937e24dab87b7.27190222.png', 1, '2025-12-09 14:18:13', NULL, NULL),
(16, 50, 'AGREEMENT', 'agreement_file_6937e24dabfe47.00222145.png', 1, '2025-12-09 14:18:13', NULL, NULL),
(14, 50, 'PANCARD', 'doc_6937f654a331e8.52847853.PNG', 1, '2025-12-09 14:18:13', 1, '2025-12-09 15:43:40'),
(16, 50, 'AGREEMENT', 'doc_6937f654a3e2a5.43499897.jpg', 1, '2025-12-09 14:18:13', 1, '2025-12-09 15:43:40'),
(14, 50, 'PANCARD', 'doc_6937f67ddf6328.09007244.png', 1, '2025-12-09 14:18:13', 1, '2025-12-09 15:44:21'),
(16, 50, 'AGREEMENT', 'doc_6937f67de094d7.57244365.png', 1, '2025-12-09 14:18:13', 1, '2025-12-09 15:44:21'),
(14, 50, 'PANCARD', 'doc_6937f6a6ba0d06.31616413.jpg', 1, '2025-12-09 14:18:13', 1, '2025-12-09 15:45:02'),
(16, 50, 'AGREEMENT', 'doc_6937f6a6bb63d9.70023528.png', 1, '2025-12-09 14:18:13', 1, '2025-12-09 15:45:02'),
(28, 56, 'AGREEMENT', 'agreement_file_6937f8ae447b72.35990251.jpg', 1, '2025-12-09 15:53:42', NULL, NULL),
(29, 57, 'PANCARD', 'pan_image_6937fb11547604.17681144.jpg', 1, '2025-12-09 16:03:53', NULL, NULL),
(31, 57, 'AGREEMENT', 'agreement_file_6937fb11557008.84672284.jpg', 1, '2025-12-09 16:03:53', NULL, NULL),
(29, 57, 'PANCARD', 'doc_6937fb994e1db2.20934622.jpg', 1, '2025-12-09 16:03:53', 1, '2025-12-09 16:06:09'),
(31, 57, 'AGREEMENT', 'doc_6937fb994efe30.66644577.png', 1, '2025-12-09 16:03:53', 1, '2025-12-09 16:06:09'),
(29, 57, 'PANCARD', 'doc_6937fbc6377ad2.30343965.png', 1, '2025-12-09 16:03:53', 1, '2025-12-09 16:06:54');

-- --------------------------------------------------------

--
-- Table structure for table `user_role_mapping`
--

CREATE TABLE `user_role_mapping` (
  `user_role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_role_mapping`
--

INSERT INTO `user_role_mapping` (`user_role_id`, `user_id`, `role_id`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, 1, 1, 1, '2025-11-27 18:36:27', NULL, '2025-11-28 18:26:16'),
(3, 3, 2, 1, '2025-11-28 11:16:29', NULL, '2025-11-28 18:27:48'),
(8, 8, 2, 1, '2025-12-01 16:19:58', NULL, '0000-00-00 00:00:00'),
(9, 9, 3, 1, '2025-12-01 17:14:39', NULL, '0000-00-00 00:00:00'),
(12, 12, 4, 1, '2025-12-01 18:56:54', NULL, '0000-00-00 00:00:00'),
(13, 13, 4, 1, '2025-12-01 19:21:42', NULL, '0000-00-00 00:00:00'),
(16, 16, 5, 1, '2025-12-01 19:44:35', NULL, '0000-00-00 00:00:00'),
(20, 20, 3, 1, '2025-12-01 21:07:26', NULL, '0000-00-00 00:00:00'),
(24, 24, 6, 1, '2025-12-01 21:33:21', NULL, '0000-00-00 00:00:00'),
(26, 26, 7, 1, '2025-12-02 09:09:00', NULL, '0000-00-00 00:00:00'),
(28, 28, 7, 1, '2025-12-02 09:13:56', NULL, '0000-00-00 00:00:00'),
(29, 29, 9, 1, '2025-12-02 09:25:45', NULL, '0000-00-00 00:00:00'),
(31, 31, 7, 1, '2025-12-02 10:03:29', NULL, '0000-00-00 00:00:00'),
(32, 32, 8, 1, '2025-12-02 17:37:37', NULL, '0000-00-00 00:00:00'),
(34, 34, 5, 1, '2025-12-02 18:06:58', NULL, '0000-00-00 00:00:00'),
(36, 36, 4, 1, '2025-12-02 18:18:46', NULL, '0000-00-00 00:00:00'),
(37, 37, 4, 1, '2025-12-02 18:19:52', NULL, '0000-00-00 00:00:00'),
(39, 39, 3, 1, '2025-12-09 12:29:15', NULL, '0000-00-00 00:00:00'),
(40, 43, 3, 1, '2025-12-09 12:31:24', NULL, '0000-00-00 00:00:00'),
(41, 47, 3, 1, '2025-12-09 14:16:34', NULL, '0000-00-00 00:00:00'),
(42, 48, 3, 1, '2025-12-09 14:17:08', NULL, '0000-00-00 00:00:00'),
(43, 49, 3, 1, '2025-12-09 14:17:35', NULL, '0000-00-00 00:00:00'),
(44, 50, 3, 1, '2025-12-09 14:18:13', NULL, '0000-00-00 00:00:00'),
(45, 51, 3, 1, '2025-12-09 14:18:44', NULL, '0000-00-00 00:00:00'),
(46, 54, 3, 1, '2025-12-09 14:30:51', NULL, '0000-00-00 00:00:00'),
(47, 55, 4, 1, '2025-12-09 15:52:20', NULL, '0000-00-00 00:00:00'),
(48, 56, 4, 1, '2025-12-09 15:53:42', NULL, '0000-00-00 00:00:00'),
(49, 57, 5, 1, '2025-12-09 16:03:53', NULL, '0000-00-00 00:00:00'),
(50, 58, 6, 1, '2025-12-09 16:18:08', NULL, '0000-00-00 00:00:00'),
(51, 59, 8, 1, '2025-12-09 16:24:14', NULL, '0000-00-00 00:00:00'),
(52, 60, 8, 1, '2025-12-09 16:26:47', NULL, '0000-00-00 00:00:00'),
(53, 61, 7, 1, '2025-12-09 16:31:24', NULL, '0000-00-00 00:00:00'),
(54, 62, 9, 1, '2025-12-09 16:35:34', NULL, '0000-00-00 00:00:00');

--
-- Triggers `user_role_mapping`
--
DELIMITER $$
CREATE TRIGGER `t_user_role_mapping_archive` BEFORE DELETE ON `user_role_mapping` FOR EACH ROW INSERT INTO user_role_mapping_archive (select *, now() from user_role_mapping where user_role_mapping.user_role_id = old.user_role_id)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `t_user_role_mapping_audit` BEFORE UPDATE ON `user_role_mapping` FOR EACH ROW INSERT INTO user_role_mapping_audit (select * from user_role_mapping where user_role_mapping.user_role_id = old.user_role_id)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_role_mapping_archive`
--

CREATE TABLE `user_role_mapping_archive` (
  `user_role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_role_mapping_archive`
--

INSERT INTO `user_role_mapping_archive` (`user_role_id`, `user_id`, `role_id`, `created_by`, `created_on`, `updated_by`, `updated_on`, `deleted_on`) VALUES
(2, 2, 2, 1, '2025-11-27 18:37:25', 0, '2025-11-28 11:15:08', '2025-11-28 11:15:08'),
(4, 4, 1, 1, '2025-11-28 16:15:46', 0, '2025-11-28 16:16:05', '2025-11-28 16:16:05'),
(5, 5, 2, 1, '2025-11-28 18:58:57', 0, '2025-11-28 19:01:32', '2025-11-28 19:01:32'),
(6, 6, 1, 1, '2025-12-01 15:39:14', 0, '2025-12-01 15:59:14', '2025-12-01 15:59:14'),
(7, 7, 2, 1, '2025-12-01 16:08:32', 0, '2025-12-01 16:16:08', '2025-12-01 16:16:08'),
(10, 10, 3, 1, '2025-12-01 18:26:50', 0, '2025-12-01 18:40:53', '2025-12-01 18:40:53'),
(11, 11, 3, 1, '2025-12-01 18:41:55', 0, '2025-12-01 18:42:39', '2025-12-01 18:42:39'),
(14, 14, 3, 1, '2025-12-01 19:32:04', 0, '2025-12-01 19:33:27', '2025-12-01 19:33:27'),
(15, 15, 4, 1, '2025-12-01 19:34:16', 0, '2025-12-01 19:35:39', '2025-12-01 19:35:39'),
(17, 17, 5, 1, '2025-12-01 19:49:23', 0, '2025-12-01 19:52:54', '2025-12-01 19:52:54'),
(18, 18, 1, 1, '2025-12-01 20:47:59', 0, '2025-12-01 20:52:27', '2025-12-01 20:52:27'),
(19, 19, 2, 1, '2025-12-01 20:58:57', 0, '2025-12-01 21:03:05', '2025-12-01 21:03:05'),
(21, 21, 3, 1, '2025-12-01 21:08:52', 0, '2025-12-01 21:09:57', '2025-12-01 21:09:57'),
(22, 22, 4, 1, '2025-12-01 21:14:02', 0, '2025-12-01 21:15:10', '2025-12-01 21:15:10'),
(23, 23, 5, 1, '2025-12-01 21:19:51', 0, '2025-12-01 21:20:52', '2025-12-01 21:20:52'),
(25, 25, 6, 1, '2025-12-01 21:38:31', 0, '2025-12-01 21:39:18', '2025-12-01 21:39:18'),
(27, 27, 7, 1, '2025-12-02 09:10:03', 0, '2025-12-02 09:13:20', '2025-12-02 09:13:20'),
(30, 30, 9, 1, '2025-12-02 09:27:23', 0, '2025-12-02 09:27:42', '2025-12-02 09:27:42'),
(33, 33, 8, 1, '2025-12-02 17:39:23', 0, '2025-12-02 17:39:53', '2025-12-02 17:39:53'),
(35, 35, 5, 1, '2025-12-02 18:11:31', 0, '2025-12-02 18:12:26', '2025-12-02 18:12:26'),
(38, 38, 4, 1, '2025-12-02 18:21:28', 0, '2025-12-02 18:22:09', '2025-12-02 18:22:09');

-- --------------------------------------------------------

--
-- Table structure for table `user_role_mapping_audit`
--

CREATE TABLE `user_role_mapping_audit` (
  `user_role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_role_mapping_audit`
--

INSERT INTO `user_role_mapping_audit` (`user_role_id`, `user_id`, `role_id`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(2, 2, 2, 1, '2025-11-27 18:37:25', NULL, '0000-00-00 00:00:00'),
(4, 4, 1, 1, '2025-11-28 16:15:46', NULL, '0000-00-00 00:00:00'),
(1, 1, 1, 1, '2025-11-27 18:36:27', NULL, '0000-00-00 00:00:00'),
(1, 1, 2, 1, '2025-11-27 18:36:27', NULL, '2025-11-28 18:25:47'),
(3, 3, 2, 1, '2025-11-28 11:16:29', NULL, '0000-00-00 00:00:00'),
(3, 3, 1, 1, '2025-11-28 11:16:29', NULL, '2025-11-28 18:27:32'),
(5, 5, 1, 1, '2025-11-28 18:58:57', NULL, '0000-00-00 00:00:00'),
(5, 5, 2, 1, '2025-11-28 18:58:57', NULL, '2025-11-28 19:00:58'),
(6, 6, 1, 1, '2025-12-01 15:39:14', NULL, '0000-00-00 00:00:00'),
(7, 7, 2, 1, '2025-12-01 16:08:32', NULL, '0000-00-00 00:00:00'),
(10, 10, 3, 1, '2025-12-01 18:26:50', NULL, '0000-00-00 00:00:00'),
(11, 11, 3, 1, '2025-12-01 18:41:55', NULL, '0000-00-00 00:00:00'),
(14, 14, 3, 1, '2025-12-01 19:32:04', NULL, '0000-00-00 00:00:00'),
(15, 15, 4, 1, '2025-12-01 19:34:16', NULL, '0000-00-00 00:00:00'),
(16, 16, 4, 1, '2025-12-01 19:44:35', NULL, '0000-00-00 00:00:00'),
(17, 17, 5, 1, '2025-12-01 19:49:23', NULL, '0000-00-00 00:00:00'),
(18, 18, 1, 1, '2025-12-01 20:47:59', NULL, '0000-00-00 00:00:00'),
(19, 19, 2, 1, '2025-12-01 20:58:57', NULL, '0000-00-00 00:00:00'),
(21, 21, 3, 1, '2025-12-01 21:08:52', NULL, '0000-00-00 00:00:00'),
(22, 22, 4, 1, '2025-12-01 21:14:02', NULL, '0000-00-00 00:00:00'),
(23, 23, 5, 1, '2025-12-01 21:19:51', NULL, '0000-00-00 00:00:00'),
(25, 25, 6, 1, '2025-12-01 21:38:31', NULL, '0000-00-00 00:00:00'),
(27, 27, 7, 1, '2025-12-02 09:10:03', NULL, '0000-00-00 00:00:00'),
(30, 30, 9, 1, '2025-12-02 09:27:23', NULL, '0000-00-00 00:00:00'),
(33, 33, 8, 1, '2025-12-02 17:39:23', NULL, '0000-00-00 00:00:00'),
(35, 35, 5, 1, '2025-12-02 18:11:31', NULL, '0000-00-00 00:00:00'),
(38, 38, 4, 1, '2025-12-02 18:21:28', NULL, '0000-00-00 00:00:00'),
(53, 61, 8, 1, '2025-12-09 16:31:24', NULL, '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`lead_id`),
  ADD UNIQUE KEY `lead_code` (`lead_code`);

--
-- Indexes for table `leads_archive`
--
ALTER TABLE `leads_archive`
  ADD PRIMARY KEY (`archive_id`);

--
-- Indexes for table `leads_audit`
--
ALTER TABLE `leads_audit`
  ADD PRIMARY KEY (`audit_id`);

--
-- Indexes for table `lead_assignments`
--
ALTER TABLE `lead_assignments`
  ADD PRIMARY KEY (`assign_id`),
  ADD KEY `lead_id` (`lead_id`);

--
-- Indexes for table `lead_assignments_archive`
--
ALTER TABLE `lead_assignments_archive`
  ADD PRIMARY KEY (`archive_id`);

--
-- Indexes for table `lead_assignments_audit`
--
ALTER TABLE `lead_assignments_audit`
  ADD PRIMARY KEY (`audit_id`);

--
-- Indexes for table `lead_followups`
--
ALTER TABLE `lead_followups`
  ADD PRIMARY KEY (`followup_id`),
  ADD KEY `lead_id` (`lead_id`);

--
-- Indexes for table `lead_followups_archive`
--
ALTER TABLE `lead_followups_archive`
  ADD PRIMARY KEY (`archive_id`);

--
-- Indexes for table `lead_followups_audit`
--
ALTER TABLE `lead_followups_audit`
  ADD PRIMARY KEY (`audit_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_bank_details`
--
ALTER TABLE `user_bank_details`
  ADD PRIMARY KEY (`user_bank_detail_id`);

--
-- Indexes for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD PRIMARY KEY (`user_document_id`);

--
-- Indexes for table `user_role_mapping`
--
ALTER TABLE `user_role_mapping`
  ADD PRIMARY KEY (`user_role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `lead_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `leads_archive`
--
ALTER TABLE `leads_archive`
  MODIFY `archive_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `leads_audit`
--
ALTER TABLE `leads_audit`
  MODIFY `audit_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `lead_assignments`
--
ALTER TABLE `lead_assignments`
  MODIFY `assign_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lead_assignments_archive`
--
ALTER TABLE `lead_assignments_archive`
  MODIFY `archive_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_assignments_audit`
--
ALTER TABLE `lead_assignments_audit`
  MODIFY `audit_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_followups`
--
ALTER TABLE `lead_followups`
  MODIFY `followup_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lead_followups_archive`
--
ALTER TABLE `lead_followups_archive`
  MODIFY `archive_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_followups_audit`
--
ALTER TABLE `lead_followups_audit`
  MODIFY `audit_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `user_bank_details`
--
ALTER TABLE `user_bank_details`
  MODIFY `user_bank_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_documents`
--
ALTER TABLE `user_documents`
  MODIFY `user_document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `user_role_mapping`
--
ALTER TABLE `user_role_mapping`
  MODIFY `user_role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lead_assignments`
--
ALTER TABLE `lead_assignments`
  ADD CONSTRAINT `lead_assignments_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`lead_id`) ON DELETE CASCADE;

--
-- Constraints for table `lead_followups`
--
ALTER TABLE `lead_followups`
  ADD CONSTRAINT `lead_followups_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`lead_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

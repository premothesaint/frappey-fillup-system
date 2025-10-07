-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2025 at 08:57 AM
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
-- Database: `frappey_franchise`
--

-- --------------------------------------------------------

--
-- Table structure for table `franchise_applications`
--

CREATE TABLE `franchise_applications` (
  `id` int(11) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `given_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `civil_status` varchar(20) NOT NULL,
  `home_address` text NOT NULL,
  `proposed_location` text NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `position_role` varchar(100) DEFAULT NULL,
  `years_in_job` varchar(20) DEFAULT NULL,
  `owned_business` varchar(3) NOT NULL,
  `owned_business_details` text DEFAULT NULL,
  `fb_experience` varchar(3) NOT NULL,
  `fb_experience_details` text DEFAULT NULL,
  `available_capital` varchar(50) NOT NULL,
  `fund_source` varchar(50) NOT NULL,
  `fund_source_other` text DEFAULT NULL,
  `ownership_type` varchar(50) NOT NULL,
  `learned_about` varchar(50) NOT NULL,
  `learned_about_other` text DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `franchise_applications`
--

INSERT INTO `franchise_applications` (`id`, `last_name`, `given_name`, `middle_name`, `date_of_birth`, `nationality`, `civil_status`, `home_address`, `proposed_location`, `contact_number`, `email`, `occupation`, `company_name`, `position_role`, `years_in_job`, `owned_business`, `owned_business_details`, `fb_experience`, `fb_experience_details`, `available_capital`, `fund_source`, `fund_source_other`, `ownership_type`, `learned_about`, `learned_about_other`, `submission_date`, `status`) VALUES
(9, 'Guillermo', 'Mark John', 'Ignacio', '2025-10-03', 'safdsafa', 'Widowed', 'Caramutan, Villasis, Pangasinan\r\nPogo, Bautista, Pangasinan', 'safsafsaafs', '09556806336', 'markjohnguillermo47@gmail.com', 'aasffaasfa', 'sfafasfasf', 'asfasfafs', 'asffasasf', 'Yes', 'sffasdf', 'Yes', 'asfasfsafasfsasfaafs', '500000000', 'Loan', '', 'Partnership', 'Social Media', '', '2025-10-07 06:32:56', 'pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `franchise_applications`
--
ALTER TABLE `franchise_applications`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `franchise_applications`
--
ALTER TABLE `franchise_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

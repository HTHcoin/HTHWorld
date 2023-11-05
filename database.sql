-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.1.1
-- Generation Time: Jun 15, 2018 at 05:57 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS hthworld;
USE hthworld;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Table structure for table `admin`
CREATE TABLE IF NOT EXISTS `admin` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT IGNORE INTO `admin` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin@admin.com', '9ae2be73b58b565bce3e47493a56e26a');

-- Table structure for table `feedback`
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `sender` VARCHAR(50) NOT NULL,
  `receiver` VARCHAR(50) NOT NULL,
  `title` VARCHAR(100) NOT NULL,
  `feedbackdata` VARCHAR(500) NOT NULL,
  `attachment` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `notification`
CREATE TABLE IF NOT EXISTS `notification` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `notiuser` VARCHAR(50) NOT NULL,
  `notireceiver` VARCHAR(50) NOT NULL,
  `notitype` VARCHAR(50) NOT NULL,
  `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `users`
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  `gender` VARCHAR(50) NOT NULL,
  `mobile` VARCHAR(50) NOT NULL,
  `designation` VARCHAR(50) NOT NULL,
  `image` VARCHAR(50) NOT NULL,
  `status` INT(10) NOT NULL,
  `user_type` VARCHAR(50),
  `xp_points` INT(11) NOT NULL DEFAULT 0,
  `level` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `messages`
CREATE TABLE IF NOT EXISTS `messages` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `sender` VARCHAR(50) NOT NULL,
  `recipient` VARCHAR(50) NOT NULL,
  `message` TEXT NOT NULL,
  `message_type` VARCHAR(50) NOT NULL DEFAULT 'text',
  `status` VARCHAR(10) NOT NULL,
  `recipient_status` VARCHAR(10) NOT NULL,
  `sender_deleted` TINYINT(1) NOT NULL,
  `receiver_deleted` TINYINT(1) NOT NULL,
  `attachment` VARCHAR(255),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `donations`
CREATE TABLE IF NOT EXISTS `donations` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `donor_name` VARCHAR(50) NOT NULL,
  `donor_email` VARCHAR(50) NOT NULL,
  `donation_amount` DECIMAL(10, 2) NOT NULL,
  `donation_date` DATE NOT NULL,
  `notes` TEXT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `fundraisers`
CREATE TABLE IF NOT EXISTS `fundraisers` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `campaign_name` VARCHAR(100) NOT NULL,
  `organizer` VARCHAR(50) NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `goal_amount` DECIMAL(10, 2) NOT NULL,
  `progress` DECIMAL(10, 2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `shelters`
CREATE TABLE IF NOT EXISTS `shelters` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `shelter_name` VARCHAR(100) NOT NULL,
  `address` VARCHAR(255) NOT NULL,
  `capacity` INT(10) NOT NULL,
  `availability` INT(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `food_banks`
CREATE TABLE IF NOT EXISTS `food_banks` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `address` VARCHAR(255) NOT NULL,
  `contact_email` VARCHAR(50),
  `contact_phone` VARCHAR(20),
  `services` TEXT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `outside_organizations`
CREATE TABLE IF NOT EXISTS `outside_organizations` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `address` VARCHAR(255) NOT NULL,
  `contact_email` VARCHAR(50),
  `contact_phone` VARCHAR(20),
  `services` TEXT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `homeless_people`
CREATE TABLE IF NOT EXISTS `homeless_people` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `gender` VARCHAR(50) NOT NULL,
  `age` INT(10) NOT NULL,
  `special_requirements` TEXT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `volunteers`
CREATE TABLE IF NOT EXISTS `volunteers` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `phone` VARCHAR(20),
  `expertise` TEXT,
  `designation` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `services`
CREATE TABLE IF NOT EXISTS `services` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `service_name` VARCHAR(100) NOT NULL,
  `description` TEXT,
  `start_date` DATE,
  `end_date` DATE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `service_records`
CREATE TABLE IF NOT EXISTS `service_records` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `homeless_person_id` INT(11) NOT NULL,
  `service_id` INT(11) NOT NULL,
  `volunteer_id` INT(11) NOT NULL,
  `service_date` DATE NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `collaboration_records`
CREATE TABLE IF NOT EXISTS `collaboration_records` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `organization_id` INT(11) NOT NULL,
  `collaboration_type` VARCHAR(50) NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE,
  `notes` TEXT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `homeless_registration`
CREATE TABLE IF NOT EXISTS `homeless_registration` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `gender` VARCHAR(50) NOT NULL,
  `age` INT(10) NOT NULL,
  `special_requirements` TEXT,
  `current_sponsor_id` INT(11),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `sponsorship`
CREATE TABLE IF NOT EXISTS `sponsorship` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `sponsor_id` INT(11) NOT NULL,
  `homeless_person_id` INT(11) NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE,
  `notes` TEXT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `quests`
CREATE TABLE IF NOT EXISTS `quests` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT,
  `xp_reward` INT(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `user_quests`
CREATE TABLE IF NOT EXISTS `user_quests` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `quest_id` INT(11) NOT NULL,
  `completed` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Create a table to store wallet addresses
CREATE TABLE IF NOT EXISTS `wallet_addresses` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `wallet_address` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `employers` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `company_name` VARCHAR(100) NOT NULL,
  `industry` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `employees` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `gender` VARCHAR(50) NOT NULL,
  `mobile` VARCHAR(50) NOT NULL,
  `designation` VARCHAR(50) NOT NULL,
  `user_type` VARCHAR(50),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table to store job listings
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `employer_id` INT(11) NOT NULL,
  `job_title` VARCHAR(100) NOT NULL,
  `job_description` TEXT NOT NULL,
  `requirements` TEXT NOT NULL,
  `location` VARCHAR(255) NOT NULL,
  `salary` DECIMAL(10, 2) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`employer_id`) REFERENCES `employers`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Create the 'job_applications' table if it doesn't exist
CREATE TABLE IF NOT EXISTS job_applications (
    id INT(11) NOT NULL AUTO_INCREMENT,
    job_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    cover_letter TEXT NOT NULL,
    skills TEXT NOT NULL,
    resume TEXT NOT NULL,
    application_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    application_status ENUM('Pending', 'Accepted', 'Denied') NOT NULL DEFAULT 'Pending',
    PRIMARY KEY (id),
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- AUTO_INCREMENT definitions
ALTER TABLE `admin`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE users MODIFY password VARCHAR(255) NOT NULL;

ALTER TABLE `feedback`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `notification`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `messages`
  MODIFY `message_type` VARCHAR(50) NOT NULL DEFAULT 'text';

ALTER TABLE `homeless_registration`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `sponsorship`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `quests`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_quests`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE employees MODIFY designation VARCHAR(50) DEFAULT '';


-- Insert data into the 'employers' table
INSERT IGNORE INTO `employers` (`user_id`, `company_name`, `industry`) VALUES (1, 'Company Name', 'Industry');

-- Commit the changes
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

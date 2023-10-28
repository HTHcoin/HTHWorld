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

USE HTHWorld;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `HTHWorld`
--

-- Table structure for table `admin`
CREATE TABLE IF NOT EXISTS `admin` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `feedback`
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `sender` VARCHAR(50) NOT NULL,
  `reciver` VARCHAR(50) NOT NULL,
  `title` VARCHAR(100) NOT NULL,
  `feedbackdata` VARCHAR(500) NOT NULL,
  `attachment` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `notification`
CREATE TABLE IF NOT EXISTS `notification` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `notiuser` VARCHAR(50) NOT NULL,
  `notireciver` VARCHAR(50) NOT NULL,
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

-- Table structure for table `badges`
CREATE TABLE IF NOT EXISTS `badges` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `badge_name` VARCHAR(100) NOT NULL,
  `description` TEXT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- AUTO_INCREMENT definitions
ALTER TABLE `admin`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

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

-- Add columns to the badges table to associate with users and quests
ALTER TABLE badges
MODIFY `user_id` INT(11);

DELIMITER $$
CREATE PROCEDURE AddForeignKeyIfNeeded()
BEGIN
  DECLARE fk_user_exists INT;
  DECLARE fk_quest_exists INT;
  
  -- Check if 'fk_badges_user' constraint exists
  SELECT COUNT(*) INTO fk_user_exists
  FROM information_schema.TABLE_CONSTRAINTS
  WHERE CONSTRAINT_SCHEMA = 'HTHWorld' -- Replace with your database name
    AND TABLE_NAME = 'badges'
    AND CONSTRAINT_NAME = 'fk_badges_user';

  -- If the constraint doesn't exist, create it
  IF fk_user_exists = 0 THEN
    ALTER TABLE `badges`
    ADD CONSTRAINT `fk_badges_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `users`(`id`)
    ON DELETE CASCADE;
  END IF;

  -- Check if 'fk_badges_quest' constraint exists
  SELECT COUNT(*) INTO fk_quest_exists
  FROM information_schema.TABLE_CONSTRAINTS
  WHERE CONSTRAINT_SCHEMA = 'HTHWorld' -- Replace with your database name
    AND TABLE_NAME = 'badges'
    AND CONSTRAINT_NAME = 'fk_badges_quest';

  -- If the constraint doesn't exist, create it
  IF fk_quest_exists = 0 THEN
    ALTER TABLE `badges`
    ADD CONSTRAINT `fk_badges_quest`
    FOREIGN KEY (`quest_id`)
    REFERENCES `quests`(`id`)
    ON DELETE CASCADE;
  END IF;
END $$
DELIMITER ;

-- Call the stored procedure to add foreign keys if needed
CALL AddForeignKeyIfNeeded();


COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

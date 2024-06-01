-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 23, 2024 at 02:24 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `car_rental_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

DROP TABLE IF EXISTS `cars`;
CREATE TABLE IF NOT EXISTS `cars` (
  `id` varchar(10) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `year` int NOT NULL,
  `mpg` int NOT NULL,
  `top_speed` int NOT NULL,
  `price_per_day` int NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `brand`, `model`, `type`, `year`, `mpg`, `top_speed`, `price_per_day`, `description`, `img`, `status`) VALUES
('C-91NC0', 'Honda', 'Civic', 'Sedan', 2022, 35, 200, 100, 'A compact car known for its fuel efficiency, sporty design, and affordability.', './assets/2.png', 'Unvailable'),
('C-8GL1H', 'Ford', 'Mustang', 'Coupe', 2021, 25, 210, 90, 'An iconic American muscle car with powerful performance and a bold design.', './assets/3.png', 'Available'),
('C-MVK01', 'Chevrolet', 'Camaro', 'SUV', 2020, 39, 190, 80, 'A versatile compact SUV with a spacious interior and advanced safety features.', './assets/4.png', 'Available'),
('C-5NFAS', 'Tesla', 'Model 3', 'Sedan', 2021, 0, 210, 100, 'A fully electric sedan offering cutting-edge technology, impressive range, and sleek design.', './assets/5.png', 'Available'),
('C-9WQE0', 'BMW', 'X5', 'SUV', 2022, 32, 220, 90, 'A luxury midsize SUV with powerful performance, premium features, and a comfortable ride.', './assets/6.png', 'Available'),
('C-N0G70', 'Audi', 'A4', 'Sedan', 2021, 31, 221, 92, 'A compact luxury sedan known for its sophisticated design, advanced technology, and smooth ride.', './assets/7.png', 'Available'),
('C-190B8', 'Mercedes-Benz', 'C-Class', 'Sedan', 2020, 29, 190, 85, 'A stylish and luxurious sedan offering refined performance and cutting-edge features.', './assets/8.png', 'Available'),
('C-193N2', 'Hyundai', 'Elantra', 'SUV', 2022, 30, 220, 92, 'A compact car with a modern design, excellent fuel economy, and a competitive price.', './assets/9.png', 'Available'),
('C-10DJ1', 'Kia', 'Sorento', 'SUV', 2022, 31, 200, 110, 'A midsize SUV with a spacious interior, advanced safety features, and a comfortable ride.', './assets/10.png', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `rents`
--

DROP TABLE IF EXISTS `rents`;
CREATE TABLE IF NOT EXISTS `rents` (
  `id` varchar(10) NOT NULL,
  `car_id` varchar(10) DEFAULT NULL,
  `user_id` varchar(10) DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `finish_date` datetime NOT NULL,
  `total_days` int NOT NULL,
  `total` int NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `car_id` (`car_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rents`
--

INSERT INTO `rents` (`id`, `car_id`, `user_id`, `start_date`, `finish_date`, `total_days`, `total`, `status`) VALUES
('R-F5EFC', 'C-91NC0', 'U-2F611', '2024-05-31 00:00:00', '2024-06-08 00:00:00', 8, 800, 'on-going');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
('U-2F611', 'hideffrand@gmail.com', '$2y$10$rqPEjI3CoHHBPwPbYZpTDeucsmwrhSk/GcXN..fyHS8gg2GNoTvO6'),
('U-47753', 'admin@gmail.com', '$2y$10$Ly8F5dkSAbFY1S1HLQwbculOC2zd2HXYR25ZRgg9MEQmQgXx.m2wC');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

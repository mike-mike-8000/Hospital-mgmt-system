-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2025 at 11:41 AM
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
-- Database: `hospital_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'hospital_admin', 'admin2025');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `patient_name` varchar(100) NOT NULL,
  `doctor_name` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('Scheduled','Completed','Cancelled') DEFAULT 'Scheduled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `notification` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `patient_name`, `doctor_name`, `department`, `appointment_date`, `appointment_time`, `status`, `created_at`, `notification`) VALUES
(1, NULL, 'Charlie Rackel', 'Charles Rubia', 'General Physician', '2025-04-08', '08:00:00', '', '2025-04-07 12:19:24', NULL),
(2, 3, 'Charlie Rackel', 'David Kim', 'Dentist', '2025-04-09', '15:00:00', '', '2025-04-07 12:28:23', NULL),
(3, 1, 'Ryan Stevenson', 'Charles Rubia', 'General Physician', '2025-04-09', '11:00:00', '', '2025-04-08 18:47:45', 'Your appointment has been modified. Please check the details.');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `dob` date NOT NULL,
  `specialty` enum('General Physician','Pediatrician','Cardiologist','Dentist','Neurologist') NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_approved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `fname`, `lname`, `email`, `phone`, `dob`, `specialty`, `gender`, `password`, `is_approved`) VALUES
(1, 'Charles', 'Rubia', 'charlirb@gmail.com', '0777201000', '1980-01-24', 'General Physician', 'male', '$2y$10$1gPM0wBCU.HHtW628oiexeR.t/btRw2vxXIGKDUwH25VkOdRI6tZ2', 1),
(2, 'Lillian', 'Karimi', 'lilkar@gmail.com', '0799003091', '1975-08-12', 'Pediatrician', 'female', '$2y$10$yCXNDWwZdLjJ.zlxeHhE5e19HZ0pkzcLO2Qn.1M.TKCd7eEa9hdxS', 1),
(3, 'Alan', 'Greene', 'alan.greene@gmail.com', '0755123001', '1980-03-15', 'General Physician', 'male', '$2y$10$CCp0u2cKuHqPhqYwrSl.zO.B3nX98K7VDJ1/OpFPKq8f8Q6MEX4CO', 1),
(4, 'Sandra', 'Leto', 'sandra.lee@hotmail.com', '0755123002', '1978-07-08', 'General Physician', 'female', '$2y$10$1dYHhlmwr6i8dACf1vHrVOE6DTRDdhQoMHiePJvNKq8SCeZ4D3Y9O', 1),
(5, 'Marcus', 'Young', 'marcus.young@gmail.com', '0555123003', '1985-01-22', 'General Physician', 'male', '$2y$10$CCp0u2cKuHqPhqYwrSl.zO.B3nX98K7VDJ1/OpFPKq8f8Q6MEX4CO', 1),
(6, 'Emily', 'Njuguna', 'emily.njuguna@hotmail.com', '5551230010', '1990-05-10', 'Pediatrician', 'female', '$2y$10$1dYHhlmwr6i8dACf1vHrVOE6DTRDdhQoMHiePJvNKq8SCeZ4D3Y9O', 1),
(7, 'Brian', 'Stone', 'brian.stone@gmail.com', '5551230011', '1987-11-04', 'Pediatrician', 'male', '$2y$10$CCp0u2cKuHqPhqYwrSl.zO.B3nX98K7VDJ1/OpFPKq8f8Q6MEX4CO', 1),
(8, 'Lisa', 'Goretti', 'lisa.goretti@gmail.com', '5551230012', '1992-09-30', 'Pediatrician', 'female', '$2y$10$1dYHhlmwr6i8dACf1vHrVOE6DTRDdhQoMHiePJvNKq8SCeZ4D3Y9O', 1),
(9, 'Kevin', 'Onyango', 'kevin.onyango@hotmail.com', '5551230020', '1981-02-14', 'Cardiologist', 'male', '$2y$10$CCp0u2cKuHqPhqYwrSl.zO.B3nX98K7VDJ1/OpFPKq8f8Q6MEX4CO', 1),
(10, 'Julia', 'Truphena', 'julia.tran@gmail.com', '5551230021', '1989-06-21', 'Cardiologist', 'female', '$2y$10$1dYHhlmwr6i8dACf1vHrVOE6DTRDdhQoMHiePJvNKq8SCeZ4D3Y9O', 1),
(11, 'Ahmed', 'Malik', 'ahmed.malik@hotmail.com', '5551230022', '1983-12-05', 'Cardiologist', 'male', '$2y$10$CCp0u2cKuHqPhqYwrSl.zO.B3nX98K7VDJ1/OpFPKq8f8Q6MEX4CO', 1),
(12, 'Waithera', 'Muthoni', 'waithera.muthoni@gmail.com', '5551230030', '1991-08-11', 'Dentist', 'female', '$2y$10$1dYHhlmwr6i8dACf1vHrVOE6DTRDdhQoMHiePJvNKq8SCeZ4D3Y9O', 1),
(13, 'David', 'Kim', 'david.kim@hotmail.com', '5551230031', '1986-10-25', 'Dentist', 'male', '$2y$10$CCp0u2cKuHqPhqYwrSl.zO.B3nX98K7VDJ1/OpFPKq8f8Q6MEX4CO', 1),
(14, 'Fatima', 'Noor', 'fatima.noor@hotmail.com', '5551230032', '1993-04-19', 'Dentist', 'female', '$2y$10$1dYHhlmwr6i8dACf1vHrVOE6DTRDdhQoMHiePJvNKq8SCeZ4D3Y9O', 1),
(15, 'Anika', 'Rao', 'anika.rao@gmail.com', '5551230040', '1984-09-13', 'Neurologist', 'female', '$2y$10$1dYHhlmwr6i8dACf1vHrVOE6DTRDdhQoMHiePJvNKq8SCeZ4D3Y9O', 1),
(16, 'James', 'Mutemi', 'james.mutemi@hotmail.com', '5551230041', '1982-03-02', 'Neurologist', 'male', '$2y$10$CCp0u2cKuHqPhqYwrSl.zO.B3nX98K7VDJ1/OpFPKq8f8Q6MEX4CO', 1),
(17, 'Amira', 'Patel', 'amira.patel@gmail.com', '5551230042', '1990-12-28', 'Neurologist', 'female', '$2y$10$1dYHhlmwr6i8dACf1vHrVOE6DTRDdhQoMHiePJvNKq8SCeZ4D3Y9O', 1),
(18, 'Michael', 'Otieno', 'motieno@gmail.com', '0789223004', '1991-04-19', 'Dentist', 'male', '$2y$10$0Y.5KX4GRphbQRAGE8GUqO58KJ6rd1VVvuPQugmOMMw.zXvIbpi4a', 1);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `first_name`, `last_name`, `email`, `phone`, `gender`, `password`) VALUES
(1, 'Ryan', 'Stevenson', 'rysty@gmail.com', '0777890110', 'male', '$2y$10$pQONRt29KWi5xbB80ZVTtOO8juSBYQaC44J1DM/5USrhcWB9LzG72'),
(2, '', 'Brown', 'cb@gmail.com', '04354325524', 'female', '$2y$10$vvap1wUCzv4mhQdEuhUHYuAdLkVvkrfxmbMZrxHeeffP7A6qTI5Bq'),
(3, 'Charlie', 'Rackel', 'rara@r.com', '0039204540', 'female', '$2y$10$sU6ZiJ9X0QG9RMbjbrLlze.1e5YivxikNn85h16My7LMyg6KnDrde');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

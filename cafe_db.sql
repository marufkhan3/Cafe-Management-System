-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2025 at 02:16 AM
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
-- Database: `cafe_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`) VALUES
(1, 'Maruf Khan', 'maruf@gmail.com', 'maruf'),
(2, 'Shakila', 'shakila@gmail.com', 'shakila'),
(3, 'Samir Khan', 'samir@gmail.com', 'samir'),
(4, 'Suchona', 'suchona@gmail.com', 'suchona');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `password`) VALUES
(2, 'Roshi', 'roshi@gmail.com', 'roshiu'),
(3, 'adria', 'adria@yahoo.com', 'adria'),
(4, 'Alice', 'alice@example.com', 'alice'),
(5, 'Bob', 'bob@example.com', 'bob'),
(6, 'Charlie', 'charlie@example.com', 'charlie'),
(7, 'David', 'david@example.com', 'david'),
(8, 'Eve', 'eve@example.com', 'eve'),
(9, 'joy', 'joy@hotmail.com', 'joytt'),
(10, 'Holam', 'holam@yahoo.com', 'holam'),
(11, 'Kutub', 'kutub@yahoo.com', 'kutub'),
(13, 'paglu', 'paglu@gmail.com', 'paglu');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `item_name`, `price`, `category`, `description`) VALUES
(1, 'Espresso', 120.00, 'Coffee', 'Strong and rich black coffee'),
(2, 'Cappuccino', 180.00, 'Coffee', 'Espresso with steamed milk and foam'),
(3, 'Latte', 200.00, 'Coffee', 'Smooth espresso with lots of milk'),
(4, 'Iced Coffee', 150.00, 'Coffee', 'Chilled coffee with ice and milk'),
(5, 'Green Tea', 130.00, 'Tea', 'Refreshing hot green tea'),
(6, 'Black Tea', 100.00, 'Tea', 'Classic black tea served hot'),
(7, 'Blueberry Muffin', 100.00, 'Pastry', 'Soft muffin with fresh blueberries'),
(8, 'Chocolate Croissant', 120.00, 'Pastry', 'Buttery croissant filled with chocolate'),
(9, 'Cheesecake Slice', 220.00, 'Dessert', 'Creamy cheesecake with a biscuit base'),
(10, 'Cold Brew', 160.00, 'Coffee', 'Slowly steeped coffee for a smooth taste'),
(11, 'Mocha', 210.00, 'Coffee', 'Espresso with chocolate and steamed milk'),
(12, 'Strawberry Smoothie', 250.00, 'Juice', 'Blended strawberries, yogurt, and honey'),
(13, 'Chocolate Brownie', 150.00, 'Dessert', 'Rich and fudgy chocolate brownie'),
(14, 'French Fries', 180.00, 'Snack', 'Crispy golden potato fries'),
(15, 'Club Sandwich', 300.00, 'Snack', 'Triple-layer sandwich with chicken, egg, and veggies'),
(17, 'b', 400.00, 'Coffee', 'ggggggg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `item_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `item_id`, `order_date`, `status`, `total_price`, `item_name`, `quantity`) VALUES
(16, 2, 3, '2025-03-25 14:30:00', 'Cancelled', 200.00, 'Latte', 0),
(17, 3, 5, '2025-03-24 10:15:00', 'Completed', 130.00, 'Green Tea', 0),
(18, 4, 8, '2025-03-23 18:45:00', 'Pending', 120.00, 'Chocolate Croissant', 0),
(19, 5, 12, '2025-03-22 09:30:00', 'Completed', 250.00, 'Strawberry Smoothie', 0),
(21, 7, 10, '2025-03-20 15:10:00', 'Pending', 160.00, 'Cold Brew', 0),
(23, 3, 1, '2025-03-26 03:04:38', 'Cancelled', 120.00, 'Espresso', 1),
(24, 3, 1, '2025-03-26 03:04:47', 'Cancelled', 120.00, 'Espresso', 1),
(28, 3, 9, '2025-03-26 03:12:10', 'Cancelled', 220.00, 'Cheesecake Slice', 1),
(29, 3, 1, '2025-03-26 03:13:33', 'Cancelled', 120.00, 'Espresso', 1),
(30, 3, 1, '2025-03-26 03:14:58', 'Completed', 360.00, 'Espresso', 3);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `reservation_date` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `customer_id`, `reservation_date`, `status`) VALUES
(1, 2, '2025-03-26 18:30:00', 'Confirmed'),
(2, 3, '2025-03-27 12:00:00', 'Confirmed'),
(3, 4, '2025-03-28 19:45:00', 'Confirmed'),
(4, 5, '2025-03-29 14:30:00', 'Cancelled'),
(5, 6, '2025-03-30 20:15:00', 'Confirmed'),
(6, 7, '2025-03-31 17:00:00', 'Pending'),
(7, 8, '2025-04-01 21:00:00', 'Confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `role`) VALUES
(1, 'Johnson', 'Chef'),
(2, 'Smith', 'Waiter'),
(3, 'Hola', 'Waiter'),
(4, 'Shobuj', 'Waiter');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `menu` (`id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

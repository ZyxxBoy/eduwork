-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2026 at 05:24 PM
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
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `product_id`, `quantity`, `total`) VALUES
(1, 1, 1, 1, 350000),
(2, 2, 2, 2, 300000),
(3, 3, 3, 1, 1750000),
(4, 4, 4, 1, 8500000),
(5, 5, 5, 2, 550000),
(6, 6, 6, 1, 220000),
(7, 7, 7, 1, 650000),
(8, 8, 8, 3, 255000),
(9, 9, 9, 1, 1250000),
(10, 10, 10, 1, 2100000);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(255) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `stok` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `nama_produk`, `harga`, `deskripsi`, `stok`) VALUES
(1, 'Mouse Gaming', 150000, 'RGB Wireless', 15),
(2, 'Keyboard Gaming', 350000, 'Mechanical RGB Keyboard', 15),
(3, 'Mouse Wireless', 150000, 'Wireless Gaming Mouse', 25),
(4, 'Monitor 24 Inch', 1750000, 'Full HD IPS Monitor', 8),
(5, 'Laptop ASUS', 8500000, 'Laptop Ryzen 5', 5),
(6, 'Headset Gaming', 275000, 'Surround Sound Headset', 18),
(7, 'Webcam HD', 220000, '1080p Webcam', 12),
(8, 'SSD 512GB', 650000, 'NVMe SSD Storage', 20),
(9, 'Flashdisk 64GB', 85000, 'USB 3.0 Flashdisk', 40),
(10, 'Kursi Gaming', 1250000, 'Ergonomic Gaming Chair', 7),
(11, 'Printer Epson', 2100000, 'Ink Tank Printer', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`) VALUES
(1, 'Andi', 'andi@gmail.com', 'andi123'),
(2, 'Budi', 'budi@gmail.com', 'budi123'),
(3, 'Citra', 'citra@gmail.com', 'citra123'),
(4, 'Dewi', 'dewi@gmail.com', 'dewi123'),
(5, 'Eka', 'eka@gmail.com', 'eka123'),
(6, 'Farhan', 'farhan@gmail.com', 'farhan123'),
(7, 'Gina', 'gina@gmail.com', 'gina123'),
(8, 'Hadi', 'hadi@gmail.com', 'hadi123'),
(9, 'Indah', 'indah@gmail.com', 'indah123'),
(10, 'Joko', 'joko@gmail.com', 'joko123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

INSERT INTO products (nama_produk, harga, deskripsi, stok)
VALUES ('Mouse Gaming', 150000, 'RGB Wireless', 20);

SELECT * FROM products;

UPDATE products
SET stok = 15
WHERE id = 1;

DELETE FROM products
WHERE id = 1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
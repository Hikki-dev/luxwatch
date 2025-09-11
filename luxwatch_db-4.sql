-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Sep 11, 2025 at 04:21 AM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `luxwatch_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(2, 6, 1, 6, '2025-09-11 02:20:50', '2025-09-11 02:20:50');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image_url`, `is_active`, `created_at`) VALUES
(1, 'Rolex', 'rolex', 'Crown jewel of Swiss watchmaking', NULL, 1, '2025-09-09 08:01:37'),
(2, 'Omega', 'omega', 'Precision timekeeping since 1848', NULL, 1, '2025-09-09 08:01:37'),
(3, 'Patek Philippe', 'patek-philippe', 'Geneva\'s finest complications', NULL, 1, '2025-09-09 08:01:37'),
(4, 'Audemars Piguet', 'audemars-piguet', 'Masters of haute horlogerie', NULL, 1, '2025-09-09 08:01:37'),
(5, 'Richard Mille', 'richard-mille', 'Racing machine on the wrist', NULL, 1, '2025-09-09 08:01:37'),
(6, 'Swatch', 'swatch', 'Swiss innovation in accessible timepieces', NULL, 1, '2025-09-09 18:02:03');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `order_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','confirmed','processing','shipped','delivered','cancelled') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `subtotal` decimal(10,2) NOT NULL,
  `tax_amount` decimal(10,2) DEFAULT '0.00',
  `shipping_amount` decimal(10,2) DEFAULT '0.00',
  `total_amount` decimal(10,2) NOT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('pending','paid','failed','refunded') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `status`, `subtotal`, `tax_amount`, `shipping_amount`, `total_amount`, `shipping_address`, `billing_address`, `payment_method`, `payment_status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 6, 'ORD-20250911-0ALKC3', 'confirmed', 75000.00, 6000.00, 0.00, 81000.00, '{\"first_name\":\"Yusuf\",\"last_name\":\"Inam\",\"email\":\"yusuffinam@gmail.com\",\"phone\":\"0763423243\",\"address\":\"safdfasfdfdfdsfdsf\",\"city\":\"fafdfdfda\",\"state\":\"dfsfds\",\"country\":\"US\",\"postal_code\":\"dfsfds\"}', '{\"first_name\":\"Yusuf\",\"last_name\":\"Inam\",\"email\":\"yusuffinam@gmail.com\",\"phone\":\"0763423243\",\"address\":\"safdfasfdfdfdsfdsf\",\"city\":\"fafdfdfda\",\"state\":\"dfsfds\",\"country\":\"US\",\"postal_code\":\"dfsfds\"}', 'credit_card', 'paid', '', '2025-09-11 02:39:30', '2025-09-11 02:39:30');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `total_price`, `created_at`) VALUES
(1, 1, 1, 6, 12500.00, 75000.00, '2025-09-11 02:39:30');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `seller_id` int NOT NULL,
  `category_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `brand` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `condition_type` enum('new','pre-owned','vintage') COLLATE utf8mb4_unicode_ci DEFAULT 'new',
  `movement_type` enum('automatic','manual','quartz') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `case_material` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dial_color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `strap_material` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `water_resistance` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year_manufactured` year DEFAULT NULL,
  `warranty_info` text COLLATE utf8mb4_unicode_ci,
  `stock_quantity` int DEFAULT '1',
  `is_featured` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `category_id`, `name`, `slug`, `description`, `brand`, `model`, `reference_number`, `price`, `original_price`, `condition_type`, `movement_type`, `case_material`, `dial_color`, `strap_material`, `water_resistance`, `year_manufactured`, `warranty_info`, `stock_quantity`, `is_featured`, `is_active`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Rolex Submariner Date', 'rolex-submariner', 'Iconic diving watch with date display. Excellent condition with box and papers.', 'Rolex', 'Submariner', '126610LN', 12500.00, 9100.00, 'pre-owned', 'automatic', 'Stainless Steel', 'Black', 'Steel Bracelet', '300m', '2022', 'Full warranty until 2027', 2, 1, 1, 'approved', '2025-09-09 08:48:01', '2025-09-11 02:39:30'),
(2, 2, 2, 'Omega Speedmaster Professional', 'omega-speedmaster', 'The legendary moonwatch. Unworn condition with full kit.', 'Omega', 'Speedmaster', '310.30.42.50.01.001', 6500.00, 6350.00, 'new', 'manual', 'Stainless Steel', 'Black', 'Steel Bracelet', '50m', '2023', '2 year international warranty', 1, 1, 1, 'approved', '2025-09-09 08:48:01', '2025-09-09 10:06:11'),
(3, 3, 3, 'Patek Philippe Nautilus', 'patek-nautilus', 'Rare steel sports watch in mint condition. Investment grade timepiece.', 'Patek Philippe', 'Nautilus', '5711/1A-010', 65000.00, 34893.00, 'pre-owned', 'automatic', 'Stainless Steel', 'Blue', 'Steel Bracelet', '120m', '2021', 'Patek Philippe service guarantee', 1, 1, 1, 'approved', '2025-09-09 08:48:01', '2025-09-09 10:06:11'),
(4, 2, 4, 'Audemars Piguet Royal Oak', 'ap-royal-oak', 'Classic luxury sports watch with distinctive octagonal bezel.', 'Audemars Piguet', 'Royal Oak', '15400ST.OO.1220ST.03', 35000.00, 27800.00, 'pre-owned', 'automatic', 'Stainless Steel', 'Silver', 'Steel Bracelet', '50m', '2020', 'Full service history', 1, 1, 1, 'approved', '2025-09-09 08:48:01', '2025-09-09 10:06:11'),
(5, 3, 5, 'Richard Mille RM 035', 'richard-mille', 'Ultra-lightweight titanium case with skeletonized dial.', 'Richard Mille', 'RM 035', 'RM35-01', 125000.00, 180000.00, 'pre-owned', 'automatic', 'Titanium', 'Skeleton', 'Rubber Strap', '50m', '2019', 'Richard Mille service completed', 1, 1, 1, 'approved', '2025-09-09 08:48:01', '2025-09-09 10:06:11'),
(6, 2, 1, 'Rolex GMT-Master II', 'rolex-gmt', 'Perfect travel companion with dual time zone function.', 'Rolex', 'GMT-Master II', '126710BLRO', 18500.00, 10700.00, 'pre-owned', 'automatic', 'Stainless Steel', 'Black', 'Steel Bracelet', '100m', '2023', 'Under Rolex warranty', 1, 0, 1, 'approved', '2025-09-09 08:48:01', '2025-09-09 10:06:11'),
(7, 3, 2, 'Omega Seamaster Planet Ocean', 'omega-seamaster', 'Professional diving watch with ceramic bezel.', 'Omega', 'Seamaster', '215.30.44.21.01.001', 4200.00, 5400.00, 'pre-owned', 'automatic', 'Stainless Steel', 'Black', 'Steel Bracelet', '600m', '2022', 'Omega warranty active', 1, 0, 1, 'approved', '2025-09-09 08:48:01', '2025-09-09 10:06:11'),
(8, 2, 3, 'Patek Philippe Calatrava', 'patek-calatrava', 'Timeless dress watch embodying pure elegance.', 'Patek Philippe', 'Calatrava', '5196P-001', 45000.00, 41520.00, 'new', 'manual', 'Platinum', 'White', 'Leather Strap', '25m', '2023', 'Full Patek Philippe warranty', 1, 0, 1, 'pending', '2025-09-09 08:48:01', '2025-09-09 10:06:11'),
(9, 2, 6, 'Swatch Skin Classic', 'swatch-skin-classic', 'Ultra-thin Swiss quartz watch with minimalist design.', 'Swatch', 'Skin Classic', 'SVOM100', 85.00, 95.00, 'new', 'quartz', 'Plastic', 'White', NULL, '30m', '2024', '2 year Swatch warranty', 1, 0, 1, 'approved', '2025-09-09 18:02:26', '2025-09-09 18:02:26'),
(10, 3, 6, 'Swatch Sistem51 Irony', 'swatch-sistem51-irony', 'Automatic movement with 90-hour power reserve.', 'Swatch', 'Sistem51', 'YIS408', 150.00, 160.00, 'new', 'automatic', 'Steel', 'Blue', NULL, '30m', '2024', '2 year Swatch warranty', 1, 1, 1, 'approved', '2025-09-09 18:02:26', '2025-09-09 18:02:26'),
(11, 2, 6, 'Swatch Big Bold Chrono', 'swatch-big-bold-chrono', 'Bold chronograph with striking design and reliable quartz movement.', 'Swatch', 'Big Bold', 'SB02B400', 120.00, 130.00, 'new', 'quartz', 'Plastic', 'Black', NULL, '30m', '2023', '2 year Swatch warranty', 1, 0, 1, 'approved', '2025-09-09 18:02:26', '2025-09-09 18:02:26');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_primary` tinyint(1) DEFAULT '0',
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `alt_text`, `is_primary`, `sort_order`, `created_at`) VALUES
(1, 1, 'images/products/rolex-submariner-1.jpg', 'Rolex Submariner front view', 1, 1, '2025-09-09 10:06:24'),
(2, 1, 'images/products/rolex-submariner-2.jpg', 'Rolex Submariner detail view', 0, 2, '2025-09-09 10:06:24'),
(3, 2, 'images/products/omega-speedmaster-1.jpg', 'Omega Speedmaster front view', 1, 1, '2025-09-09 10:06:24'),
(4, 2, 'images/products/omega-speedmaster-2.jpg', 'Omega Speedmaster detail view', 0, 2, '2025-09-09 10:06:24'),
(5, 3, 'images/products/patek-nautilus-1.jpg', 'Patek Philippe Nautilus front view', 1, 1, '2025-09-09 10:06:24'),
(6, 3, 'images/products/patek-nautilus-2.jpg', 'Patek Philippe Nautilus detail view', 0, 2, '2025-09-09 10:06:24'),
(7, 4, 'images/products/ap-royal-oak-1.jpg', 'AP Royal Oak front view', 1, 1, '2025-09-09 10:06:24'),
(8, 4, 'images/products/ap-royal-oak-2.jpg', 'AP Royal Oak detail view', 0, 2, '2025-09-09 10:06:24'),
(9, 5, 'images/products/richard-mille-1.jpg', 'Richard Mille front view', 1, 1, '2025-09-09 10:06:24'),
(10, 5, 'images/products/richard-mille-2.jpg', 'Richard Mille detail view', 0, 2, '2025-09-09 10:06:24'),
(11, 6, 'images/products/rolex-gmt-1.jpg', 'Rolex GMT-Master II front view', 1, 1, '2025-09-09 10:06:24'),
(12, 7, 'images/products/omega-seamaster-1.jpg', 'Omega Seamaster front view', 1, 1, '2025-09-09 10:06:24'),
(13, 8, 'images/products/patek-calatrava-1.jpg', 'Patek Philippe Calatrava front view', 1, 1, '2025-09-09 10:06:24'),
(14, 9, 'images/products/swatch-skin-classic-1.jpg', 'Swatch Skin Classic front view', 1, 1, '2025-09-09 18:02:33'),
(15, 10, 'images/products/swatch-sistem51-irony-1.jpg', 'Swatch Sistem51 Irony front view', 1, 1, '2025-09-09 18:02:33'),
(16, 11, 'images/products/swatch-big-bold-chrono-1.jpg', 'Swatch Big Bold Chrono front view', 1, 1, '2025-09-09 18:02:33');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `rating` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_verified_purchase` tinyint(1) DEFAULT '0',
  `is_approved` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','seller','customer') COLLATE utf8mb4_unicode_ci DEFAULT 'customer',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `email_verified` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `role`, `phone`, `address`, `city`, `country`, `postal_code`, `is_active`, `email_verified`, `created_at`, `updated_at`) VALUES
(1, 'admin@chronos.com', '$2y$10$ofJtqr81p6Ki5XOiS3oble5P03lhkDlM5bFiCb745v/QVOAquNdz6', 'Admin', 'User', 'admin', NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-09-09 08:01:37', '2025-09-09 19:35:38'),
(2, 'seller1@example.com', '$2y$10$ofJtqr81p6Ki5XOiS3oble5P03lhkDlM5bFiCb745v/QVOAquNdz6', 'Mark', 'Luthor', 'seller', '', '', '', '', '', 1, 0, '2025-09-09 08:48:01', '2025-09-09 20:21:02'),
(3, 'seller2@example.com', '$2y$10$ofJtqr81p6Ki5XOiS3oble5P03lhkDlM5bFiCb745v/QVOAquNdz6', 'Maria', 'Garcia', 'seller', '+1-555-0456', NULL, 'Geneva', 'Switzerland', NULL, 1, 0, '2025-09-09 08:48:01', '2025-09-09 19:35:38'),
(4, 'customer1@example.com', '$2y$10$ofJtqr81p6Ki5XOiS3oble5P03lhkDlM5bFiCb745v/QVOAquNdz6', 'David', 'Johnson', 'customer', '+1-555-0789', NULL, 'London', 'UK', NULL, 1, 0, '2025-09-09 08:48:01', '2025-09-09 19:35:38'),
(5, 'customer2@example.com', '$2y$10$ofJtqr81p6Ki5XOiS3oble5P03lhkDlM5bFiCb745v/QVOAquNdz6', 'Sarah', 'Wilson', 'customer', '+1-555-0987', NULL, 'Tokyo', 'Japan', NULL, 1, 0, '2025-09-09 08:48:01', '2025-09-09 19:35:38'),
(6, 'yusuffinam@gmail.com', '$2y$10$gUHg2jE4Chdii4HOa7op4.akmoIJppMSpM6XA.x4xbBIrVg2vGCXu', 'Yusuf', 'Inam', 'customer', NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-09-09 19:23:03', '2025-09-09 19:23:03');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cart_item` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_wishlist_item` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

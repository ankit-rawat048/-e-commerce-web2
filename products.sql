-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 26, 2025 at 08:04 AM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u713383587_shriganga`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `disease` varchar(255) DEFAULT NULL,
  `brand_name` varchar(255) DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `description`, `category_id`, `disease`, `brand_name`, `meta_keywords`, `meta_description`, `created_at`) VALUES
(1, 'Himalayan Ghutno ke Dard Grice ki Fanki', 'https://cdn.pixabay.com/photo/2018/08/04/11/30/draw-3583548_1280.png', 'A powerful herbal remedy for joint and knee pain relief.', 1, 'Joint Pain', 'Shri Ganga Herbal', 'joint pain oil, knee pain relief, ayurvedic oil, herbal remedy, pain relief', 'Discover Himalayan Ghutno ke Dard Grice ki Fanki, an ayurvedic oil for effective joint and knee pain relief.', '2025-09-26 06:55:08'),
(2, 'Hari Ganga Balm', 'https://cdn.pixabay.com/photo/2018/08/04/11/30/draw-3583548_1280.png', 'An herbal balm for instant pain relief.', 2, 'Joint Pain', 'Shri Ganga Herbal', 'herbal balm, pain relief balm, ayurvedic balm, joint pain relief', 'Hari Ganga Balm provides instant relief from joint pain with its natural ayurvedic formula.', '2025-09-26 06:55:08'),
(3, 'Samahan Herbal Tea', 'https://cdn.pixabay.com/photo/2018/08/04/11/30/draw-3583548_1280.png', 'Natural herbal tea to boost immunity and relieve cold symptoms.', 3, 'Cold, Cough', 'Shri Ganga Herbal', 'herbal tea, immunity booster, cold relief, ayurvedic tea, cough remedy', 'Samahan Herbal Tea boosts immunity and relieves cold and cough symptoms naturally.', '2025-09-26 06:55:08'),
(4, 'Nidco Shilajit Paste', 'https://shrigangaherbal.com/assets/p_img62-D0zloGw6.png', 'Pure Shilajit paste for energy and vitality.', 4, NULL, 'Shri Ganga Herbal', 'shilajit paste, energy booster, vitality supplement, ayurvedic paste', 'Nidco Shilajit Paste enhances energy and vitality with pure ayurvedic ingredients.', '2025-09-26 06:55:08'),
(5, 'Kailash Jeevan MultiPurpose Cream', 'https://shrigangaherbal.com/assets/p_img63-C5T-AwaF.png', 'Multi-purpose ayurvedic cream for skin and body.', 5, 'Cold', 'Shri Ganga Herbal', 'ayurvedic cream, multipurpose cream, skin care, herbal cream', 'Kailash Jeevan MultiPurpose Cream is an ayurvedic solution for skin and body care.', '2025-09-26 06:55:08'),
(6, 'Nidco Shilajeet Tablet', 'https://shrigangaherbal.com/assets/p_img64-C8_eQaK1.png', 'Shilajit tablets for energy and vitality.', 6, NULL, 'Shri Ganga Herbal', 'shilajit tablets, energy supplement, vitality tablets, ayurvedic tablets', 'Nidco Shilajeet Tablets boost energy and vitality with natural ayurvedic ingredients.', '2025-09-26 06:55:08'),
(7, 'Kesri Marham', 'https://shrigangaherbal.com/assets/p_img65-jtLWbZUI.png', 'Ayurvedic marham for external use.\nAyurvedic marham for external use.\n\nAyurvedic marham for external use.\n\nAyurvedic marham for external use.\n\nAyurvedic marham for external use.\n\n', 2, 'Cold', 'Shri Ganga Herbal', 'ayurvedic marham, herbal balm, external pain relief, kesri marham', 'Kesri Marham is an ayurvedic balm for effective external pain relief.', '2025-09-26 06:55:08'),
(8, 'Herbal Product 8', 'https://shrigangaherbal.com/assets/p_img55-BB5qRI_o.png', 'General herbal health product.', 7, NULL, 'Shri Ganga Herbal', 'herbal supplement, ayurvedic health product, natural wellness', 'Herbal Product 8 supports overall health with natural ayurvedic ingredients.', '2025-09-26 06:55:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

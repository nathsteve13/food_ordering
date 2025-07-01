-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2025 at 12:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_ordering`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `menus_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `menus_price` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_ingredients`
--

CREATE TABLE `cart_ingredients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `menus_has_ingredient_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image_path`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Makanan Berats', 'images/categories/makanan_berat.jpg', NULL, NULL, NULL),
(2, 'Minuman', 'images/categories/minuman.jpg', NULL, NULL, NULL),
(3, 'Cemilan', 'images/categories/cemilan.jpg', NULL, NULL, NULL),
(4, 'Makanan Penutup', 'images/categories/penutup.jpg', NULL, NULL, NULL),
(5, 'Makanan Berat', 'images/categories/makanan_berat.jpg', NULL, NULL, NULL),
(6, 'Minuman', 'images/categories/minuman.jpg', NULL, NULL, NULL),
(7, 'Cemilan', 'images/categories/cemilan.jpg', NULL, NULL, NULL),
(9, 'Dessert', NULL, NULL, '2025-05-28 00:41:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detail_transactions`
--

CREATE TABLE `detail_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transactions_invoice_number` varchar(255) NOT NULL,
  `menus_id` bigint(20) UNSIGNED NOT NULL,
  `portion` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` double NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_transactions`
--

INSERT INTO `detail_transactions` (`id`, `transactions_invoice_number`, `menus_id`, `portion`, `quantity`, `total`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'INV-SMITQ4Q2', 2, 2, 2, 22906, '', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(2, 'INV-SMITQ4Q2', 1, 1, 2, 42822, '', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(3, 'INV-SMITQ4Q2', 3, 2, 2, 59692, 'extra keju', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(4, 'INV-SMITQ4Q2', 3, 1, 3, 53385, 'extra keju', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(5, 'INV-SMITQ4Q2', 3, 2, 3, 85515, 'extra keju', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(6, 'INVCVNMGJF1', 1, 1, 1, 26491, 'tanpa sambal', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(7, 'INVCVNMGJF1', 1, 2, 2, 43660, 'garing', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(8, 'INVCVNMGJF1', 3, 1, 1, 26397, '', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(9, 'INVCVNMGJF1', 1, 2, 1, 29451, 'extra keju', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(10, 'INVCVNMGJF1', 1, 1, 2, 24860, 'extra keju', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(11, 'INVD5AOHFT2', 2, 1, 1, 12986, 'tanpa sambal', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(12, 'INVD5AOHFT2', 3, 2, 1, 11154, 'extra keju', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(13, 'INVD5AOHFT2', 2, 1, 2, 38782, 'tanpa sambal', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(14, 'INVD5AOHFT2', 2, 2, 2, 59292, 'garing', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(15, 'INVD5AOHFT2', 3, 2, 1, 28084, 'extra keju', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(16, 'INVJEBGGHZL', 1, 2, 3, 59616, 'tanpa sambal', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(17, 'INVJEBGGHZL', 1, 1, 2, 47242, 'extra keju', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(18, 'INVJEBGGHZL', 2, 2, 2, 42946, '', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(19, 'INVJEBGGHZL', 1, 1, 1, 21936, '', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(20, 'INVJEBGGHZL', 3, 2, 3, 52899, 'garing', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(21, 'INVJII7BXQQ', 3, 1, 3, 40719, '', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(22, 'INVJII7BXQQ', 3, 1, 1, 28019, 'garing', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(23, 'INVJII7BXQQ', 1, 2, 2, 24126, '', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(24, 'INVJII7BXQQ', 2, 1, 2, 46104, 'tanpa sambal', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(25, 'INVJII7BXQQ', 1, 2, 3, 30450, 'extra keju', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(26, 'INVZU5AXIC2', 2, 2, 2, 57812, '', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(27, 'INVZU5AXIC2', 3, 2, 2, 24854, 'tanpa sambal', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(28, 'INVZU5AXIC2', 2, 2, 3, 48513, '', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(29, 'INVZU5AXIC2', 3, 1, 2, 32896, 'tanpa sambal', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(30, 'INVZU5AXIC2', 2, 1, 2, 52828, 'extra keju', '2025-04-20 01:51:28', '2025-04-20 01:51:28'),
(31, 'INV-SMITQ4Q2', 3, 1, 2, 41744, '', '2025-05-27 23:43:06', '2025-05-27 23:43:06'),
(32, 'INV-SMITQ4Q2', 1, 1, 2, 48670, '', '2025-05-27 23:43:06', '2025-05-27 23:43:06'),
(33, 'INV-SMITQ4Q2', 2, 2, 1, 19869, '', '2025-05-27 23:43:06', '2025-05-27 23:43:06'),
(34, 'INV-SMITQ4Q2', 3, 1, 1, 26424, '', '2025-05-27 23:43:06', '2025-05-27 23:43:06'),
(35, 'INV-SMITQ4Q2', 1, 1, 2, 36152, '', '2025-05-27 23:43:06', '2025-05-27 23:43:06'),
(36, 'INV209MUWOO', 2, 2, 1, 24196, '', '2025-05-27 23:43:06', '2025-05-27 23:43:06'),
(37, 'INV209MUWOO', 3, 2, 1, 16563, 'garing', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(38, 'INV209MUWOO', 2, 1, 2, 52784, '', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(39, 'INV209MUWOO', 3, 2, 3, 71394, '', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(40, 'INV209MUWOO', 1, 2, 1, 15147, '', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(41, 'INV7CZLHCTP', 1, 1, 1, 19970, '', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(42, 'INV7CZLHCTP', 2, 2, 1, 17793, '', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(43, 'INV7CZLHCTP', 1, 1, 3, 84312, '', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(44, 'INV7CZLHCTP', 3, 2, 1, 22580, 'garing', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(45, 'INV7CZLHCTP', 3, 2, 3, 30921, 'extra keju', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(46, 'INVCVNMGJF1', 3, 2, 2, 51904, '', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(47, 'INVCVNMGJF1', 2, 2, 1, 21774, 'extra keju', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(48, 'INVCVNMGJF1', 2, 1, 2, 57994, 'extra keju', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(49, 'INVCVNMGJF1', 2, 1, 1, 19841, '', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(50, 'INVCVNMGJF1', 1, 1, 1, 20785, 'extra keju', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(51, 'INVD5AOHFT2', 2, 2, 1, 26693, 'extra keju', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(52, 'INVD5AOHFT2', 2, 2, 2, 48132, '', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(53, 'INVD5AOHFT2', 3, 2, 2, 32376, 'garing', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(54, 'INVD5AOHFT2', 1, 2, 2, 47102, 'tanpa sambal', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(55, 'INVD5AOHFT2', 3, 1, 3, 76428, 'extra keju', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(56, 'INVJEBGGHZL', 3, 2, 3, 60633, '', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(57, 'INVJEBGGHZL', 1, 1, 3, 67641, '', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(58, 'INVJEBGGHZL', 1, 1, 2, 40278, 'tanpa sambal', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(59, 'INVJEBGGHZL', 1, 2, 3, 75468, '', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(60, 'INVJEBGGHZL', 2, 2, 1, 15808, '', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(61, 'INVJII7BXQQ', 3, 2, 2, 55364, 'garing', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(62, 'INVJII7BXQQ', 3, 2, 1, 18523, 'garing', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(63, 'INVJII7BXQQ', 2, 2, 2, 22760, '', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(64, 'INVJII7BXQQ', 1, 1, 1, 19860, 'extra keju', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(65, 'INVJII7BXQQ', 1, 2, 3, 79896, 'garing', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(66, 'INVNLC3UWMI', 1, 1, 3, 41046, 'garing', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(67, 'INVNLC3UWMI', 1, 2, 3, 78504, '', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(68, 'INVNLC3UWMI', 1, 2, 3, 38631, 'tanpa sambal', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(69, 'INVNLC3UWMI', 2, 2, 3, 56346, 'tanpa sambal', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(70, 'INVNLC3UWMI', 1, 2, 1, 19597, 'tanpa sambal', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(71, 'INVNVG4HEIN', 2, 1, 1, 19324, 'garing', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(72, 'INVNVG4HEIN', 2, 1, 3, 38073, '', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(73, 'INVNVG4HEIN', 1, 2, 1, 11724, 'garing', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(74, 'INVNVG4HEIN', 2, 1, 2, 28310, '', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(75, 'INVNVG4HEIN', 2, 1, 2, 46344, 'tanpa sambal', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(76, 'INVZBBNANJU', 2, 2, 2, 21536, 'garing', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(77, 'INVZBBNANJU', 3, 2, 3, 53451, 'tanpa sambal', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(78, 'INVZBBNANJU', 2, 1, 1, 26408, '', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(79, 'INVZBBNANJU', 2, 1, 1, 13168, '', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(80, 'INVZBBNANJU', 2, 1, 3, 71193, 'extra keju', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(81, 'INVZU5AXIC2', 2, 1, 3, 54372, '', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(82, 'INVZU5AXIC2', 3, 1, 3, 77142, 'garing', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(83, 'INVZU5AXIC2', 1, 2, 2, 58900, 'garing', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(84, 'INVZU5AXIC2', 1, 1, 2, 42604, 'tanpa sambal', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(85, 'INVZU5AXIC2', 2, 2, 1, 19813, 'garing', '2025-05-27 23:43:07', '2025-05-27 23:43:07'),
(86, '1', 2, 1, 1, 2, 'halo', '2025-05-28 01:00:20', '2025-05-28 01:00:20');

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaction_excludes`
--

CREATE TABLE `detail_transaction_excludes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `detail_transaction_id` bigint(20) UNSIGNED NOT NULL,
  `ingredients_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Fresh Melon', NULL, NULL),
(2, 'Mineral Water', NULL, NULL),
(3, 'Ripe Bananas', NULL, NULL),
(4, 'Low-fat Milk', NULL, NULL),
(5, 'Fresh Melon', NULL, NULL),
(6, 'Mineral Water', NULL, NULL),
(7, 'Ripe Bananas', NULL, NULL),
(8, 'Low-fat Milk', NULL, NULL),
(10, 'nasi', '2025-06-21 01:16:03', '2025-06-21 01:16:03'),
(11, 'ayam', '2025-06-21 01:16:03', '2025-06-21 01:16:03'),
(12, 'udang', '2025-06-21 01:16:53', '2025-06-21 01:16:53');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `nutrition_fact` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `stock` int(11) NOT NULL,
  `categories_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `description`, `nutrition_fact`, `price`, `stock`, `categories_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sunstar Fresh Melon Juices', 'Melon juice segar dan menyehatkan.', 'Vitamin C tinggi, tanpa pemanis buatan', 18000, 50, 2, '2025-06-02 05:39:21', '2025-05-27 23:52:43', NULL),
(2, 'Tropical Banana Smoothie', 'Smoothie pisang tropis yang creamy dan lezat.', 'Mengandung serat dan kalium', 20000, 40, 2, NULL, NULL, NULL),
(3, 'Sunstar Fresh Melon Juice', 'Melon juice segar dan menyehatkan.', 'Vitamin C tinggi, tanpa pemanis buatan', 18000, 50, 2, NULL, NULL, NULL),
(10, 'nasi goreng', 'enak', 'sehat', 15000, 5, 1, '2025-06-20 01:13:28', '2025-06-20 01:13:28', NULL),
(11, 'Nasi Putih', 'Enak', 'Sehat', 15000, 20, 1, '2025-06-26 22:36:24', '2025-06-26 22:36:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menus_has_ingredients`
--

CREATE TABLE `menus_has_ingredients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menus_id` bigint(20) UNSIGNED NOT NULL,
  `ingredients_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus_has_ingredients`
--

INSERT INTO `menus_has_ingredients` (`id`, `menus_id`, `ingredients_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 2, 3, NULL, NULL),
(4, 2, 4, NULL, NULL),
(5, 1, 1, NULL, NULL),
(6, 1, 2, NULL, NULL),
(7, 2, 3, NULL, NULL),
(8, 2, 4, NULL, NULL),
(15, 10, 1, '2025-06-20 01:13:29', '2025-06-20 01:13:29'),
(16, 1, 3, NULL, NULL),
(17, 1, 10, NULL, NULL),
(18, 1, 11, NULL, NULL),
(19, 1, 12, NULL, NULL),
(20, 11, 10, '2025-06-26 22:36:26', '2025-06-26 22:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `menu_images`
--

CREATE TABLE `menu_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menus_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_images`
--

INSERT INTO `menu_images` (`id`, `menus_id`, `image_path`, `created_at`, `updated_at`) VALUES
(4, 10, 'menus/iRIvuu2yFlqdWkR9xujabHu04UVucjDWJZfvLfGC.jpg', NULL, NULL),
(5, 11, 'menus/7Pd1Adrnhlhx5XZob4P4fRAMeVG9EHqb7I1HD2hg.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_04_13_121350_create_users_table', 1),
(6, '2025_04_13_121428_create_transactions_table', 1),
(7, '2025_04_13_121455_create_menus_table', 1),
(8, '2025_04_13_121526_create_detail_transactions_table', 1),
(9, '2025_04_13_121546_create_order_status_table', 1),
(10, '2025_04_13_121605_create_ingredients_table', 1),
(11, '2025_04_13_121623_create_menus_has_ingredients_table', 1),
(12, '2025_04_13_125042_create_categories_table', 1),
(13, '2025_04_13_125112_update_menus_table', 1),
(14, '2025_04_13_125151_create_menu_images_table', 1),
(15, '2025_04_17_032134_add_role_column_to_users_table', 2),
(16, '2025_05_25_062146_alter_category_table', 3),
(17, '2025_05_25_062331_alter_menus_table', 3),
(18, '2025_05_25_134556_change_notes_column_to_nullable_in_detail_transactions_table', 3),
(19, '2025_05_26_032749_alter_transaction_table', 4),
(20, '2025_06_21_054416_update_order_status_table', 5),
(21, '2025_06_21_055142_create_detail_transaction_excludes_table', 6),
(22, '2025_06_27_064452_create_table_cart', 6),
(23, '2025_06_27_071751_create_table_cart_ingredients', 6);

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transactions_invoice_number` varchar(255) NOT NULL,
  `status_type` enum('pending','proccessed','ready') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `transactions_invoice_number`, `status_type`, `created_at`, `updated_at`) VALUES
(1, 'INV-SMITQ4Q2', 'proccessed', '2025-04-19 09:19:52', '2025-06-20 01:25:18'),
(2, 'INVCVNMGJF1', 'pending', '2025-04-21 04:55:46', '2025-04-21 04:55:46'),
(3, 'INVD5AOHFT2', 'pending', '2025-04-21 04:59:49', '2025-04-21 04:59:49'),
(4, '1', 'ready', '2025-05-28 01:00:20', '2025-05-28 01:22:30'),
(5, 'INV209MUWOO', 'proccessed', '2025-06-30 11:06:24', '2025-06-30 11:06:24'),
(6, 'INV7CZLHCTP', 'proccessed', '2025-06-30 11:06:33', '2025-06-30 11:06:33');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `invoice_number` varchar(255) NOT NULL,
  `subtotal` double NOT NULL,
  `discount` double NOT NULL,
  `total` double NOT NULL,
  `order_type` enum('dinein','takeaway') NOT NULL,
  `payment_type` enum('qris','credit','debit','e-wallet') NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`invoice_number`, `subtotal`, `discount`, `total`, `order_type`, `payment_type`, `users_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
('1', 20000, 5000, 150000, 'dinein', 'e-wallet', 3, '2025-05-28 01:00:20', '2025-05-28 01:00:20', NULL),
('INV-SMITQ4Q2', 50000, 5000, 45000, 'dinein', 'qris', 1, '2025-04-19 09:19:52', '2025-04-19 09:19:52', NULL),
('INV209MUWOO', 150000, 10000, 140000, 'dinein', 'credit', 3, '2025-05-27 23:43:06', '2025-05-27 23:43:06', NULL),
('INV7CZLHCTP', 150000, 10000, 140000, 'dinein', 'e-wallet', 2, '2025-05-27 23:43:06', '2025-05-27 23:43:06', NULL),
('INVCVNMGJF1', 150000, 10000, 140000, 'dinein', 'qris', 1, '2025-04-20 01:51:27', '2025-04-20 01:51:27', NULL),
('INVD5AOHFT2', 150000, 10000, 140000, 'takeaway', 'debit', 1, '2025-04-20 01:51:27', '2025-04-20 01:51:27', NULL),
('INVJEBGGHZL', 150000, 10000, 140000, 'takeaway', 'e-wallet', 1, '2025-04-20 01:51:27', '2025-04-20 01:51:27', NULL),
('INVJII7BXQQ', 150000, 10000, 140000, 'takeaway', 'credit', 1, '2025-04-20 01:51:27', '2025-04-20 01:51:27', NULL),
('INVNLC3UWMI', 150000, 10000, 140000, 'dinein', 'credit', 3, '2025-05-27 23:43:06', '2025-05-27 23:43:06', NULL),
('INVNVG4HEIN', 150000, 10000, 140000, 'takeaway', 'credit', 2, '2025-05-27 23:43:06', '2025-05-27 23:43:06', NULL),
('INVZBBNANJU', 150000, 10000, 140000, 'takeaway', 'qris', 3, '2025-05-27 23:43:06', '2025-05-27 23:43:06', NULL),
('INVZU5AXIC2', 150000, 10000, 140000, 'dinein', 'credit', 1, '2025-04-20 01:51:27', '2025-05-28 00:40:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone_numeber` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `address`, `phone_numeber`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'bryan', 's160422045@student.ubaya.ac.id', 'Jl Tenggilis Mejoyo', '081336140271', 'bry', '$2y$12$GPUdFMgk0OESj0/8UXPsKu0Rvcd.lgdYY5LfkfsFhVQEHuwY9GQFW', 'admin', '2025-04-19 09:01:58', '2025-04-19 09:01:58'),
(2, 'cennia', 's160322045@student.ubaya.ac.id', 'Jl Tenggilis Mejoyo', '081336140271', 'cen', '$2y$12$DbaWyXPlVI5SQ55jNUWYX.jdPQHmcQunCvVI3U57K9BQeHLdiIIPu', 'admin', '2025-04-20 02:23:03', '2025-04-20 02:23:03'),
(3, 'kenji', 'halo@gmail.com', 'Jl Tenggilis Mejoyo', '081336140271', 'ken', '$2y$12$Zd2jpTE/7.u0UHo0Up8.LeeiSEVk7CkI14fIwyBfg4D/i2BNXBTPe', 'customer', '2025-04-20 02:25:41', '2025-04-20 02:25:41'),
(4, 'mikel', 'mik@gmail.com', 'Jl Wisma Permai', '081336140242', 'mik', '$2y$12$XeudvxITtA/YeVsFeP/G5OCuDVIQjikCp9fJJ7Rwk5q34rMNWebPm', 'customer', '2025-07-01 03:02:48', '2025-07-01 03:02:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_users_id_foreign` (`users_id`),
  ADD KEY `carts_menus_id_foreign` (`menus_id`);

--
-- Indexes for table `cart_ingredients`
--
ALTER TABLE `cart_ingredients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_ingredients_cart_id_foreign` (`cart_id`),
  ADD KEY `cart_ingredients_menus_has_ingredient_id_foreign` (`menus_has_ingredient_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_transactions`
--
ALTER TABLE `detail_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_transactions_transactions_invoice_number_foreign` (`transactions_invoice_number`),
  ADD KEY `detail_transactions_menus_id_foreign` (`menus_id`);

--
-- Indexes for table `detail_transaction_excludes`
--
ALTER TABLE `detail_transaction_excludes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_transaction_excludes_detail_transaction_id_foreign` (`detail_transaction_id`),
  ADD KEY `detail_transaction_excludes_ingredients_id_foreign` (`ingredients_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_categories_id_foreign` (`categories_id`);

--
-- Indexes for table `menus_has_ingredients`
--
ALTER TABLE `menus_has_ingredients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_has_ingredients_menus_id_foreign` (`menus_id`),
  ADD KEY `menus_has_ingredients_ingredients_id_foreign` (`ingredients_id`);

--
-- Indexes for table `menu_images`
--
ALTER TABLE `menu_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_images_menus_id_foreign` (`menus_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_status_transactions_invoice_number_foreign` (`transactions_invoice_number`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`invoice_number`),
  ADD KEY `transactions_users_id_foreign` (`users_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_ingredients`
--
ALTER TABLE `cart_ingredients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `detail_transactions`
--
ALTER TABLE `detail_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `detail_transaction_excludes`
--
ALTER TABLE `detail_transaction_excludes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `menus_has_ingredients`
--
ALTER TABLE `menus_has_ingredients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `menu_images`
--
ALTER TABLE `menu_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_menus_id_foreign` FOREIGN KEY (`menus_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_ingredients`
--
ALTER TABLE `cart_ingredients`
  ADD CONSTRAINT `cart_ingredients_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ingredients_menus_has_ingredient_id_foreign` FOREIGN KEY (`menus_has_ingredient_id`) REFERENCES `menus_has_ingredients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `detail_transactions`
--
ALTER TABLE `detail_transactions`
  ADD CONSTRAINT `detail_transactions_menus_id_foreign` FOREIGN KEY (`menus_id`) REFERENCES `menus` (`id`),
  ADD CONSTRAINT `detail_transactions_transactions_invoice_number_foreign` FOREIGN KEY (`transactions_invoice_number`) REFERENCES `transactions` (`invoice_number`);

--
-- Constraints for table `detail_transaction_excludes`
--
ALTER TABLE `detail_transaction_excludes`
  ADD CONSTRAINT `detail_transaction_excludes_detail_transaction_id_foreign` FOREIGN KEY (`detail_transaction_id`) REFERENCES `detail_transactions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_transaction_excludes_ingredients_id_foreign` FOREIGN KEY (`ingredients_id`) REFERENCES `ingredients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_categories_id_foreign` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `menus_has_ingredients`
--
ALTER TABLE `menus_has_ingredients`
  ADD CONSTRAINT `menus_has_ingredients_ingredients_id_foreign` FOREIGN KEY (`ingredients_id`) REFERENCES `ingredients` (`id`),
  ADD CONSTRAINT `menus_has_ingredients_menus_id_foreign` FOREIGN KEY (`menus_id`) REFERENCES `menus` (`id`);

--
-- Constraints for table `menu_images`
--
ALTER TABLE `menu_images`
  ADD CONSTRAINT `menu_images_menus_id_foreign` FOREIGN KEY (`menus_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_status`
--
ALTER TABLE `order_status`
  ADD CONSTRAINT `order_status_transactions_invoice_number_foreign` FOREIGN KEY (`transactions_invoice_number`) REFERENCES `transactions` (`invoice_number`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

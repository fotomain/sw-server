-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 07, 2025 at 04:13 PM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u235058084_sw_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `attribute_entity`
--

CREATE TABLE `attribute_entity` (
  `attribute_id` int(11) NOT NULL,
  `attribute_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attribute_entity`
--

INSERT INTO `attribute_entity` (`attribute_id`, `attribute_name`) VALUES
(801, 'Size'),
(802, 'Color'),
(803, 'Capacity'),
(804, 'With USB 3 ports'),
(805, 'Touch ID in keyboard'),
(806, 'Operational system');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_options`
--

CREATE TABLE `attribute_options` (
  `attribute_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `displayValue` varchar(255) DEFAULT NULL,
  `id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attribute_options`
--

INSERT INTO `attribute_options` (`attribute_id`, `option_id`, `value`, `displayValue`, `id`) VALUES
(801, 80001, '40', '40', '40'),
(801, 80002, '41', '41', '41'),
(801, 80003, '42', '42', '42'),
(801, 80004, '43', '43', '43'),
(801, 80005, 'S', 'Small', 'Small'),
(801, 80006, 'M', 'Medium', 'Medium'),
(801, 80007, 'L', 'Large', 'Large'),
(801, 80008, 'XL', 'Extra Large', 'Extra Large'),
(802, 80009, '#44FF03', 'Green', 'Green'),
(802, 80010, '#03FFF7', 'Cyan', 'Cyan'),
(802, 80011, '#030BFF', 'Blue', 'Blue'),
(802, 80012, '#000000', 'Black', 'Black'),
(802, 80013, '#FFFFFF', 'White', 'White'),
(802, 80021, '#ff0000', 'Red', 'Red'),
(803, 80014, '512GB', '512GB', '512GB'),
(803, 80015, '1T', '1T', '1T'),
(803, 80016, '256GB', '256GB', '256GB'),
(804, 80017, 'Yes', 'Yes', 'Yes'),
(804, 80018, 'No', 'No', 'No'),
(805, 80019, 'Yes', 'Yes', 'Yes'),
(805, 80020, 'No', 'No', 'No'),
(806, 80022, 'iOS12', 'iOS 12', 'iOS12'),
(806, 80023, 'iOS16', 'iOS 16', 'iOS16'),
(806, 80024, 'Android12', 'Android 12', 'Android12'),
(806, 80025, 'Android13', 'Android 13', 'Android13');

-- --------------------------------------------------------

--
-- Table structure for table `cart_header`
--

CREATE TABLE `cart_header` (
  `cart_id` int(11) NOT NULL,
  `cart_guid` uuid NOT NULL,
  `total_sum` float NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_header`
--

INSERT INTO `cart_header` (`cart_id`, `cart_guid`, `total_sum`, `created`, `comment`) VALUES
(1, 'aaaaacca-92d4-42fe-a455-383d139a45ca', 111, '2025-03-02 12:11:05', 'c111'),
(19, 'cc6bb519-f811-11ef-a13a-55e370885b2f', 0, '2025-03-03 09:27:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cart_lines`
--

CREATE TABLE `cart_lines` (
  `cart_id` int(11) NOT NULL,
  `cart_line_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_has_options` int(11) DEFAULT NULL,
  `qty` float NOT NULL,
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_lines`
--

INSERT INTO `cart_lines` (`cart_id`, `cart_line_id`, `product_id`, `product_has_options`, `qty`, `comment`) VALUES
(19, 149, 104, 1, 3, ''),
(19, 150, 101, 1, 4, ''),
(19, 152, 102, 1, 2, ''),
(19, 153, 103, 1, 5, '');

-- --------------------------------------------------------

--
-- Table structure for table `cart_line_options`
--

CREATE TABLE `cart_line_options` (
  `cart_line_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_line_options`
--

INSERT INTO `cart_line_options` (`cart_line_id`, `attribute_id`, `option_id`) VALUES
(143, 801, 80001),
(143, 802, 80002),
(143, 803, 80003),
(144, 801, 80001),
(144, 802, 80002),
(144, 803, 80005),
(145, 801, 80001),
(145, 802, 80002),
(145, 803, 80003),
(146, 801, 80001),
(146, 802, 80002),
(146, 803, 80005),
(147, 801, 80001),
(147, 802, 80002),
(147, 803, 80005),
(148, 801, 80001),
(148, 802, 80002),
(148, 803, 80005),
(149, 801, 80001),
(149, 802, 80002),
(149, 803, 80005),
(150, 801, 80004),
(151, 801, 80001),
(152, 801, 80004),
(153, 802, 80005),
(153, 803, 80010);

-- --------------------------------------------------------

--
-- Table structure for table `catalog_product_entity_text`
--

CREATE TABLE `catalog_product_entity_text` (
  `entity_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `catalog_product_entity_text`
--

INSERT INTO `catalog_product_entity_text` (`entity_id`, `attribute_id`, `value`) VALUES
(101, 801, 80001),
(101, 801, 80002),
(101, 801, 80003),
(101, 801, 80004),
(102, 801, 80005),
(102, 801, 80006),
(102, 801, 80007),
(102, 801, 80008),
(103, 802, 80009),
(103, 802, 80010),
(103, 802, 80011),
(103, 802, 80012),
(103, 802, 80013),
(103, 803, 80014),
(103, 803, 80015),
(104, 802, 80009),
(104, 802, 80010),
(104, 802, 80011),
(104, 802, 80012),
(104, 802, 80013),
(104, 803, 80014),
(104, 803, 80015),
(105, 803, 80014),
(105, 803, 80016),
(105, 804, 80017),
(105, 804, 80018),
(105, 805, 80019),
(105, 805, 80020),
(106, 802, 80009),
(106, 802, 80010),
(106, 802, 80011),
(106, 802, 80012),
(106, 802, 80013),
(106, 803, 80014),
(106, 803, 80015),
(109, 802, 80009),
(109, 802, 80010),
(109, 802, 80011),
(109, 802, 80012),
(109, 802, 80021),
(109, 803, 80015),
(109, 803, 80016),
(109, 806, 80022),
(109, 806, 80023),
(110, 802, 80009),
(110, 802, 80010),
(110, 802, 80011),
(110, 802, 80012),
(110, 802, 80021),
(110, 803, 80015),
(110, 803, 80016),
(110, 806, 80024),
(110, 806, 80025);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Name` varchar(255) NOT NULL,
  `TypeName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Name`, `TypeName`) VALUES
('all', 'Category'),
('clothes', 'Category'),
('tech', 'Category');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `currency_id` varchar(3) NOT NULL,
  `label` varchar(3) DEFAULT NULL,
  `symbol` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`currency_id`, `label`, `symbol`) VALUES
('EUR', 'EUR', '€'),
('USD', 'USD', '$');

-- --------------------------------------------------------

--
-- Table structure for table `order_header`
--

CREATE TABLE `order_header` (
  `order_id` int(11) NOT NULL,
  `order_total` decimal(10,0) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_header`
--

INSERT INTO `order_header` (`order_id`, `order_total`, `comment`) VALUES
(1, 111, 'order #1');

-- --------------------------------------------------------

--
-- Table structure for table `order_lines`
--

CREATE TABLE `order_lines` (
  `order_line_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `comment` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_lines`
--

INSERT INTO `order_lines` (`order_line_id`, `order_id`, `comment`) VALUES
(1, 1, 'line1'),
(2, 1, 'line2');

-- --------------------------------------------------------

--
-- Table structure for table `price_list`
--

CREATE TABLE `price_list` (
  `entity_id` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `currency_id` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `price_list`
--

INSERT INTO `price_list` (`entity_id`, `price`, `currency_id`) VALUES
(101, 144.69, 'USD'),
(102, 518.47, 'USD'),
(103, 844.02, 'USD'),
(104, 333.99, 'USD'),
(105, 1688.03, 'USD'),
(106, 1000.76, 'USD'),
(107, 300.23, 'USD'),
(108, 120.57, 'USD'),
(109, 888.00, 'USD'),
(110, 555.00, 'USD');

-- --------------------------------------------------------

--
-- Table structure for table `product_entity`
--

CREATE TABLE `product_entity` (
  `product_id` int(11) NOT NULL,
  `sku` varchar(15) NOT NULL,
  `inStock` int(11) DEFAULT NULL,
  `has_options` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_entity`
--

INSERT INTO `product_entity` (`product_id`, `sku`, `inStock`, `has_options`, `name`) VALUES
(101, '101', 1, 1, 'Nike Air Huarache Le'),
(102, '102', 1, 1, 'Jacket'),
(103, '103', 1, 1, 'PlayStation 5'),
(104, '104', 1, 1, 'Xbox Series S 512GB'),
(105, '105', 1, 1, 'iMac 2021'),
(106, '106', 1, 1, 'iPhone 12 Pro'),
(107, '107', 1, 0, 'AirPods Pro'),
(108, '108', 1, 0, 'AirTag'),
(109, '109', 1, 1, 'iPhone'),
(110, '110', 1, 1, 'Samsung');

-- --------------------------------------------------------

--
-- Table structure for table `product_gallery`
--

CREATE TABLE `product_gallery` (
  `entity_id` int(11) NOT NULL,
  `url_order` int(11) DEFAULT NULL,
  `url_path` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_gallery`
--

INSERT INTO `product_gallery` (`entity_id`, `url_order`, `url_path`) VALUES
(101, 1, 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_1_720x.jpg?v=1612816087'),
(101, 0, 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_2_720x.jpg?v=1612816087'),
(101, 2, 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_3_720x.jpg?v=1612816087'),
(101, 4, 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_4_720x.jpg?v=1612816087'),
(101, 3, 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_5_720x.jpg?v=1612816087'),
(102, 6, 'https://images.canadagoose.com/image/upload/w_1333,c_scale,f_auto,q_auto:best/v1634058159/product-image/2409L_61_p.png'),
(102, 5, 'https://images.canadagoose.com/image/upload/w_1333,c_scale,f_auto,q_auto:best/v1634058169/product-image/2409L_61_o.png'),
(102, 0, 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016105/product-image/2409L_61.jpg'),
(102, 1, 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016107/product-image/2409L_61_a.jpg'),
(102, 2, 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016108/product-image/2409L_61_b.jpg'),
(102, 3, 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016109/product-image/2409L_61_c.jpg'),
(102, 4, 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016110/product-image/2409L_61_d.jpg'),
(103, 0, 'https://images-na.ssl-images-amazon.com/images/I/510VSJ9mWDL._SL1262_.jpg'),
(103, 4, 'https://images-na.ssl-images-amazon.com/images/I/51HCjA3rqYL._SL1230_.jpg'),
(103, 2, 'https://images-na.ssl-images-amazon.com/images/I/51iPoFwQT3L._SL1230_.jpg'),
(103, 1, 'https://images-na.ssl-images-amazon.com/images/I/610%2B69ZsKCL._SL1500_.jpg'),
(103, 3, 'https://images-na.ssl-images-amazon.com/images/I/61qbqFcvoNL._SL1500_.jpg'),
(104, 3, 'https://images-na.ssl-images-amazon.com/images/I/61IYrCrBzxL._SL1500_.jpg'),
(104, 4, 'https://images-na.ssl-images-amazon.com/images/I/61RnXmpAmIL._SL1500_.jpg'),
(104, 2, 'https://images-na.ssl-images-amazon.com/images/I/71iQ4HGHtsL._SL1500_.jpg'),
(104, 1, 'https://images-na.ssl-images-amazon.com/images/I/71q7JTbRTpL._SL1500_.jpg'),
(104, 0, 'https://images-na.ssl-images-amazon.com/images/I/71vPCX0bS-L._SL1500_.jpg'),
(105, 0, 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/imac-24-blue-selection-hero-202104?wid=904&hei=840&fmt=jpeg&qlt=80&.v=1617492405000'),
(106, 0, 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-12-pro-family-hero?wid=940&amp;hei=1112&amp;fmt=jpeg&amp;qlt=80&amp;.v=1604021663000'),
(107, 0, 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MWP22?wid=572&hei=572&fmt=jpeg&qlt=95&.v=1591634795000'),
(108, 0, 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/airtag-double-select-202104?wid=445&hei=370&fmt=jpeg&qlt=95&.v=1617761672000'),
(109, 0, 'https://lmt-web.mstatic.lv/eshop/11528/conversions/Apple-iPhone-11_purple_front-860.webp'),
(109, 1, 'https://lmt-web.mstatic.lv/eshop/11530/conversions/Apple-iPhone-11_purple_back-860.webp'),
(109, 2, 'https://www.apple.com/v/iphone-11/g/images/specs/hero__dqxrmndp9n2a_large.jpg'),
(110, 1, 'https://image-us.samsung.com/SamsungUS/home/mobile/galaxy-a50/freeform/storage-d-0905.png'),
(110, 2, 'https://images.samsung.com/is/image/samsung/lv-galaxy-a50-sm-a505fzkse40--Black-308536043?$330_330_JPG$'),
(110, 0, 'https://lmt-web.mstatic.lv/eshop/28913/conversions/2-samsung-galaxy-s25-s931-icy-blue-860.webp');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attribute_entity`
--
ALTER TABLE `attribute_entity`
  ADD PRIMARY KEY (`attribute_id`);

--
-- Indexes for table `attribute_options`
--
ALTER TABLE `attribute_options`
  ADD PRIMARY KEY (`attribute_id`,`option_id`);

--
-- Indexes for table `cart_header`
--
ALTER TABLE `cart_header`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `cart_lines`
--
ALTER TABLE `cart_lines`
  ADD PRIMARY KEY (`cart_line_id`);

--
-- Indexes for table `cart_line_options`
--
ALTER TABLE `cart_line_options`
  ADD PRIMARY KEY (`cart_line_id`,`attribute_id`,`option_id`);

--
-- Indexes for table `catalog_product_entity_text`
--
ALTER TABLE `catalog_product_entity_text`
  ADD PRIMARY KEY (`entity_id`,`attribute_id`,`value`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Name`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indexes for table `order_header`
--
ALTER TABLE `order_header`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_lines`
--
ALTER TABLE `order_lines`
  ADD PRIMARY KEY (`order_line_id`);

--
-- Indexes for table `price_list`
--
ALTER TABLE `price_list`
  ADD PRIMARY KEY (`entity_id`,`price`);

--
-- Indexes for table `product_entity`
--
ALTER TABLE `product_entity`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_entity_ui_sku` (`sku`);

--
-- Indexes for table `product_gallery`
--
ALTER TABLE `product_gallery`
  ADD PRIMARY KEY (`entity_id`,`url_path`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_header`
--
ALTER TABLE `cart_header`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `cart_lines`
--
ALTER TABLE `cart_lines`
  MODIFY `cart_line_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `order_header`
--
ALTER TABLE `order_header`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_lines`
--
ALTER TABLE `order_lines`
  MODIFY `order_line_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 28, 2019 at 09:58 AM
-- Server version: 5.7.27-0ubuntu0.16.04.1
-- PHP Version: 7.1.31-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cars`
--

-- --------------------------------------------------------

--
-- Table structure for table `aboutus`
--

CREATE TABLE `aboutus` (
  `id` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aboutus`
--

INSERT INTO `aboutus` (`id`, `description`, `image`) VALUES
(1, '<p><strong>Lorem simply dummy is a texted of the printing costed and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, </strong>when an unknown printer took a galley of type. Lorem simply dummy is a texted of the printing costed and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type.when an unknown printer took a galley of type. Lorem simply dummy is a texted of the printing costed and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type.</p>', '1568436217.home-2-about.png');

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `myid` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '0',
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8 NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `adminType` tinyint(1) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `issubadmin` int(11) NOT NULL COMMENT '1=superAdmin,2=showroomAdmin,3=store,4=company'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`myid`, `first_name`, `last_name`, `email`, `password`, `isActive`, `address`, `description`, `city`, `zip`, `country`, `phone`, `image`, `adminType`, `category`, `remember_token`, `created_at`, `updated_at`, `issubadmin`) VALUES
(1, 'Admin', '', 'car@gmail.com', '$2y$10$K2DV.mc/GEIlRcmMuoCqs.ND214ea2STV/lH5dVn/a/wxhgzJEp3e', 1, 'address', '', 'Nivada', '38000', '218', '123456789', 'resources/views/admin/images/admin_profile/1513671470.fast.jpg', 1, '', 'N87GqnynJVVkdVemEqC9ueNpwK4PKOkGBLfA6s5tUIj2c7m4x8ovHOBQKOiD', '0000-00-00 00:00:00', '2019-09-27 01:15:57', 0),
(8, 'Admin', '', 'demo@android.com', '$2y$10$vbQE1Lbu1kXCAILSvaH0uOZ3oA6oZdCf/0kjQB16iGnjc3eTaFBeu', 1, 'address', '', 'Nivada', '38000', '223', '', 'resources/views/admin/images/admin_profile/1513671470.fast.jpg', 1, '', 'resources/views/admin/images/admin_profile/1505132393.1486628854.fast.jpg', NULL, NULL, 0),
(9, 'Admin', '', 'demo@ionic.com', '$2y$10$vbQE1Lbu1kXCAILSvaH0uOZ3oA6oZdCf/0kjQB16iGnjc3eTaFBeu', 1, 'address', '', 'Nivada', '38000', '223', '', 'resources/views/admin/images/admin_profile/1513671470.fast.jpg', 1, '', 'c68im2rP1dzUw7guozSqEbxZHY5ebSGGOprcPezzYDo2ZIvxCaGplhjn5rFP', NULL, NULL, 0),
(23, 'prakash', 'sonule', 'prakash@gmail.com', '$2y$10$DDugbqADUP14v3wh8xwmfejd8eJWErzZaWYp5Lnag7wsztPltj2lK', 0, 'jasodanagar', '', '15', '382445', '99', '7894561230', 'resources/views/admin/images/admin_profile/1563960498.blog-image-real-estate-listing-descriptions.jpg', 1, '', '0s79xe1x4O3OrI3Ee4eNbRyYoPly4KciJ24osQJxh905UAgGINEGHXsygIhK', '2019-07-24 03:58:18', '2019-07-24 07:23:04', 2),
(24, 'akash', 'tsdddd', 'akash@gmail.com', '$2y$10$YGuwUH/t0FXfk1o7TAL9bONfLg1vJa.kyIsfY4tlK2Bvnaci2LlDm', 0, 'dhjfvshjdafvhjadfahjdfvahdfvfhfhhhdfhh', '', '14', '54775', '223', '5764567467667', 'resources/views/admin/images/admin_profile/1563960699.businesspeople-brainstorming-with-creative-ideas-picture-id950560696-1024x512.jpg', 1, '', 'aiqtgFXnuFaUpcYSlp7NwVfE0xCKDCKtQmFaKzoUKEmroIn1Xsw0Nlkxb0Hn', '2019-07-24 04:01:39', '2019-07-24 07:22:59', 2),
(25, 'abbas bhai', 'daruvala', 'daruvala@gmail.com', '$2y$10$xDdmgzSXnS5ADWOnGVwW3u1jWeaZ2FI2fD5AyZoIuPt56efGxPSBm', 0, 'new dubai', '', '12', '693200', '1', '963258741', 'resources/views/admin/images/admin_profile/1564654286.user4.jpeg', 1, '', NULL, '2019-08-01 04:41:26', '0000-00-00 00:00:00', 2),
(28, 'sanvi', 'patel', 'sanvi@gmail.com', '$2y$10$kTuxk9myBry.FWcBwVwzduLikWAg4eOR2n0gdvfRI/O/KzkHYFU..', 0, 'gds', '', '14', '6546', '2', '8795463210', 'resources/views/admin/images/admin_profile/1564660580.laptop4.jpg', 1, '3,5,7,8', 'OR8j0dlpg77vMmE5DwYZRcdstRYsSj3BFEGgCARBIdjO9owjzhykv16vcdAi', '2019-08-01 06:26:20', '2019-08-02 06:01:56', 4),
(29, 'riya', 't', 'riya@gmail.com', '$2y$10$Dz1o9Uk2v7D0LQXGR0Fl/ObB5J9lmO4cRzYIHvVsu3cYe5E1RORey', 0, 'gdsg', 'Global Travels represents the CABGURGAON.COM, which is the first Gurgaon based online booking system of cab rentals in India as the master licensee of GlGlobal Travels represents the CABGURGAON.COM, which is the first Gurgaon based online booking system of cab rentals in India as the master licensee of Global Travels.', '12', '', '12', '', 'resources/views/admin/images/admin_profile/1564663719.wallet1.jpeg', 1, '7,8', 'JCWBC2WZvjdeRP0e4S3oRPwOVgA7q1KQ9w5nmnXm6pHwUf6Itp4gq2rCqZ6s', '2019-08-01 07:18:39', '2019-09-22 23:51:12', 4),
(30, 'hakim bhai', 'potliwala', 'potliwala@gmail.com', '$2y$10$xe8.Q.hnKEglgsep1chrWOXNkdhHaii4uYWDGogmMY.yWTq9yw3DS', 0, 'ghh', '', '11', '45000', '1', '9876541323', '', 1, '', NULL, '2019-08-18 23:16:32', '2019-09-25 19:50:27', 2),
(31, 'heery', '1son', 'car1234@gmail.com', '$2y$10$u1CkMeuqKQ57kz0256jzwe1EL1iG/8nID4GfBhKyEL/S..6928qD2', 0, 'new', 'new', '12', '380015', '16', '9632587410', 'resources/views/admin/images/admin_profile/1568274546.laptop1.jpeg', 1, '', 'iYOaMHchdzgzcwDf1FiZvpickttj5SlKn8CGP8oePTLEy6GmRr9Z1Awv1wUe', '2019-09-12 02:19:06', '2019-09-25 03:17:19', 4),
(32, 'simon', 'smith', 'simonsmith@gmail.com', '$2y$10$kQymI5q3SjaI3HGP04au8O3fAorywdUUyPlEN.tIsXhCyOvWQCfw6', 0, 'america', '', '16', '123123', '4', '9874561230', 'resources/views/admin/images/admin_profile/1568356448.d1.jpg', 1, '3,4', 'sbtqUCSaohIIKVXcID53eNCLfo76mLk7gP3PQhjUh6KINbdWKCgOBf9yRcVq', '2019-09-13 01:04:08', '2019-09-16 00:52:32', 3),
(33, 'Patrik', 'Nash', 'patriknash@gmail.com', '$2y$10$fnDJmUBlDXuLGJJ/3t.2jOrE9VsPxhSc45h07lrj67blZH1y/efNS', 0, 'dubai', '', '12', '456123', '13', '9876543332', 'resources/views/admin/images/admin_profile/1568356849.d2.jpg', 1, '5,6,7', NULL, '2019-09-13 01:10:49', '0000-00-00 00:00:00', 3),
(34, 'Henry', 'Shaw', 'henryshaw@gmail.com', '$2y$10$aB1WQeP/g4IpBX.rMUrZ2eL/Wm77oI8JrBC9eUKN29VMVNnJLCa3O', 0, 'africa', '', '15', '5555555555', '1', '9876543211', 'resources/views/admin/images/admin_profile/1568356983.d4.jpg', 1, '3,8,9,11', NULL, '2019-09-13 01:13:03', '2019-09-16 00:53:39', 3),
(35, 'Metthew', 'Pattern', 'metthewpattern@gmail.com', '$2y$10$/hDmw/2MCW9twkc78zOiO.tJpz73rJ/C8UefKY6sOPwxvIlQgw72O', 0, '04,kerala,dubai', '', '14', '4444444444', '57', '9873216541', 'resources/views/admin/images/admin_profile/1568357127.d3.jpeg', 1, '3,4,5,6', NULL, '2019-09-13 01:15:27', '2019-09-16 23:33:13', 3),
(36, 'priyabrta', 'posta', 'posta@gmail.com', '$2y$10$9BZJHBS2G.WTnmox6hrpnOT.WZ6g7FlkcoRl0zY8wo/3l465TSOLq', 0, 'ahmedabad', 'new', '11', '34444', '20', '7894561320', 'resources/views/admin/images/admin_profile/1568712513.rose-blue-flower-rose-blooms-67636.jpeg', 1, '9', NULL, '2019-09-17 03:58:34', '2019-09-18 00:22:11', 3),
(37, 'jatin', 'bhai', 'jatin@gmail.com', '$2y$10$ttdozBvnZ0Xe6RD2e3tPou8HMeGb.lzuUlBhA2i5PqBJXS3y.NMNW', 0, 'abad', 'abd', '11', '4444', '8', '444444', 'resources/views/admin/images/admin_profile/1569321769.male1.jpeg', 1, '7', NULL, '2019-09-24 05:12:49', '0000-00-00 00:00:00', 3),
(38, 'mahesh', 'bhai', 'mahesh@gmail.com', '$2y$10$Drdz6e1TV3XH.LjbhH5sZ.pPbtwmJ3nRUkeFm8rti9xshHlC0qxkC', 0, 'abad', 'abd', '17', '4444', '17', '4545454', 'resources/views/admin/images/admin_profile/1569321821.male2.jpg', 1, '5', NULL, '2019-09-24 05:13:41', '0000-00-00 00:00:00', 3),
(39, 'Damu', 'bhai', 'don@gmail.com', '$2y$10$9JqLz.wXQjscggF5STAL8.IHgUGM4TULCL27uLVexJwHPEYK1R/0i', 0, 'vadodara', 'vcadodara', '21', '5656', '13', '879789879', 'resources/views/admin/images/admin_profile/1569321892.male3.jpg', 1, '7', NULL, '2019-09-24 05:14:52', '0000-00-00 00:00:00', 3),
(40, 'raju', 'bhai', 'raju@gmail.com', '$2y$10$5a.owHbImFRvswhapqyKieDvYyHR4iZVVr6/zzu5zRA3I2cwa4WMe', 0, 'sdsds', 'sdsd', '10', '45654', '19', '546546546', 'resources/views/admin/images/admin_profile/1569321968.male4.jpg', 1, '7', NULL, '2019-09-24 05:16:08', '0000-00-00 00:00:00', 3),
(41, 'fasino', 'sed', 'fasino@gmail.com', '$2y$10$0Xs9GzSZjxXb6Z8vENnQrerMiHx8R82pAxANNZgIIk5orE4Je5a1K', 0, 'fgfg', 'dfgdfg', '10', '546', '17', '546546', 'resources/views/admin/images/admin_profile/1569322023.male6.jpg', 1, '5,8', NULL, '2019-09-24 05:17:04', '0000-00-00 00:00:00', 3),
(42, 'mukesh', 'bhai', 'mukesh@gmail.com', '$2y$10$p4MAlbtj8RKwcmWvlG07uemlPrLPBKfHhGMmc7KIrakIIlKoOPMg2', 0, 'dsf', 'dsfdsf', '20', '546', '16', '546546', 'resources/views/admin/images/admin_profile/1569325588.male5.jpg', 1, '3', NULL, '2019-09-24 06:16:28', '0000-00-00 00:00:00', 3),
(43, 'jack', 'sparrow', 'jalpa@gmail.com', '$2y$10$D0CCqB.76CBxiYFim4QjSeiulSIcurE9ut/faA0CFGl/neGlsrxVq', 0, 'vfdgd', 'fdgfdg', '19', '567', '14', '657657', 'resources/views/admin/images/admin_profile/1569325938.male1.jpeg', 1, '4', NULL, '2019-09-24 06:22:18', '0000-00-00 00:00:00', 3),
(44, 'hitesh', 'bhai', 'hitesh@gmail.com', '$2y$10$B34RdJVQBxmgjlK.qoP9t.XCW.PVGUFYwwAPjOcYi1gJQFV1YV5z6', 0, 'dfgdg', 'fdgfdgdfg', '21', '567', '', '657657', 'resources/views/admin/images/admin_profile/1569325984.male5.jpg', 1, '3,7', '8Vk489g2cxkDM0DHpbPrTRz9FqPzsWp1S6zP1d2bvMuHyYT81dnaRPAM7OlN', '2019-09-24 06:23:04', '2019-09-26 23:17:57', 3),
(45, 'fgdfg', 'dfghdgh', 'kinnari@gmail.com', '$2y$10$CAm6UUJrs6HFkMjKsQzjS.D80HOmh1NRL1jj4i9.Z4Z468Ol9/egO', 0, 'dfghdgh', 'dfghdgh', '', '789456', '13', '5894564532132', '', 1, '', 'HwH3ccFvwSWWjFSHBqumRYW8FT3nF7BdCkv1GCsGHSmfjP6S4RQxFngzJ3nw', '2019-09-26 07:52:53', '2019-09-27 01:11:57', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `fromdate` date NOT NULL,
  `todate` date NOT NULL,
  `published` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `type`, `name`, `description`, `fromdate`, `todate`, `published`, `image`) VALUES
(1, 1, 'test1', 'test1', '2019-09-05', '2019-09-04', 1, '1568615409.shutterstock1.jpg'),
(2, 1, 'test 2', 'test 2', '2019-09-04', '2019-09-04', 1, '1568616371.shutterstock2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `car_accessories`
--

CREATE TABLE `car_accessories` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `specification` longtext NOT NULL,
  `status` tinyint(4) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `car_accessories`
--

INSERT INTO `car_accessories` (`id`, `store_id`, `category_id`, `name`, `description`, `price`, `size`, `model`, `color`, `specification`, `status`, `quantity`) VALUES
(7, 33, 0, 'Tire Set', 'packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '435435', '400', 'fgdfsg', 'fsdgsfg', 'jbdfgkjsb', 1, 10),
(8, 33, 5, 'Back Light', 'packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '2500', '4000', 'fdhfdh', 'dhjvfj', 'sbdfkghb', 1, 10),
(9, 33, 6, 'Parking Light', 'packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '566', '400', 'thth', 'rthtrh', 'Parking Light', 1, 10),
(10, 33, 7, 'Mirrors', 'gcgh', '50.00', '5', '23', 'black', 'bj', 2, 10),
(11, 32, 3, 'Sound System', 'packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '50000', '90\' cm', 'a1', 'Blue', 'Nothing but good', 1, 20),
(12, 32, 4, 'AC colder', 'packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '100000', '300 cm', 'ac-1', 'black', 'noooo', 1, 110),
(13, 44, 3, 'demo pro', 'dfhdghfgh', '45000', '4500', '2019', 'red', 'kfjbgfskj', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `car_accessories_img`
--

CREATE TABLE `car_accessories_img` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `img_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `car_accessories_img`
--

INSERT INTO `car_accessories_img` (`id`, `product_id`, `img_name`) VALUES
(28, 7, '1565701755.download-(5).jpeg'),
(29, 8, '1565702033.maruti-suzuki-eeco-back-light-500x500.jpg'),
(30, 9, '1565702111.download-(9).jpeg'),
(31, 10, '1565702301.wing-mirror.jpeg'),
(32, 10, '1565702301.rear-mirror.jpeg'),
(33, 10, '1565702301.blind-spot-mirrors.jpeg'),
(34, 8, '1565702449.download-(7).jpeg'),
(36, 11, '1568357435.download.jpeg'),
(37, 12, '1568357621.download-(1).jpeg'),
(38, 13, '1569559765.photo-1511919884226-fd3cad34687c.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `car_brand`
--

CREATE TABLE `car_brand` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ar` varchar(255) NOT NULL,
  `ku` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `car_brand`
--

INSERT INTO `car_brand` (`id`, `name`, `ar`, `ku`, `description`, `status`) VALUES
(2, 'Maruti-Suzuki', 'يع / شراء سيارة', 'يع / شراء سيارة', 'Made In India', 1),
(3, 'Mahindra', 'Mahindra', 'Mahindra', 'made in india', 1),
(4, 'Tata', 'Tata', 'Tata', 'made in india', 1),
(5, 'Ford', 'Ford', 'Ford', 'made in ford', 1),
(10, 'Volvo', 'Volvo', 'Volvo', 'Luxurious', 1),
(11, 'Jeep', 'Jeep', 'Jeep', 'sdfgfsg', 1),
(12, 'Ashok Leyland', 'Ashok Leyland', 'Ashok Leyland', 'dsfgsdg', 1),
(13, 'Chinkara Motors', 'Chinkara Motors', 'Chinkara Motors', 'dfdf', 1),
(14, 'Opel', 'Opel', 'Opel', 'dafdaf', 1),
(15, 'Eicher Motors', 'Eicher Motors', 'Eicher Motors', 'dfdfdf', 1),
(16, 'Honda', 'Honda', 'Honda', 'fdfdf', 1),
(17, 'Hyundai', 'Hyundai', 'Hyundai', 'dfdf', 1),
(18, 'Skoda', 'Skoda', 'Skoda', 'dfdf', 1),
(19, 'Ariel', 'Ariel', 'Ariel', 'dafa', 1),
(20, 'Aston Martin', 'Aston Martin', 'Aston Martin', 'adfdaf', 1),
(21, 'Audi', 'Audi', 'Audi', 'adsfadf', 1),
(22, 'Bajaj', 'Bajaj', 'Bajaj', 'dsfgds', 1),
(23, 'Bentley', 'Bentley', 'Bentley', 'dsfdsf', 1),
(24, 'BMW', 'BMW', 'BMW', 'df', 1),
(25, 'Bugatti', 'Bugatti', 'Bugatti', 'dsfgd', 1),
(26, 'Chevrolet', 'Chevrolet', 'Chevrolet', 'dsfgdsg', 1),
(27, 'Datsun', 'Datsun', 'Datsun', 'sfdg', 1),
(28, 'Ferrari', 'Ferrari', 'Ferrari', 'sdfgsg', 1),
(29, 'Fiat', 'Fiat', 'Fiat', 'fsgfg', 1),
(30, 'Force', 'Force', 'Force', 'sdfg', 1),
(31, 'HM', 'HM', 'HM', 'dsf', 1),
(32, 'ICML', 'ICML', 'ICML', 'dsfg', 1),
(33, 'Isuzu', 'Isuzu', 'Isuzu', 'dsf', 1),
(34, 'Jaguar', 'Jaguar', 'Jaguar', 'dsfg', 1),
(35, 'Koenigsegg', 'Koenigsegg', 'Koenigsegg', 'dsfgdg', 1),
(36, 'Lamborghini', 'Lamborghini', 'Lamborghini', 'dsf', 1),
(37, 'Land Rover', 'Land Rover', 'Land Rover', 'dgd', 1),
(38, 'Mahindra - Reva', 'Mahindra - Reva', 'Mahindra - Reva', 'dfsg', 1),
(39, 'Maserati', 'Maserati', 'Maserati', 'dsgg', 1),
(40, 'Maybach', 'Maybach', 'Maybach', 'dsg', 1),
(41, 'Mercedes-Benz', 'Mercedes-Benz', 'Mercedes-Benz', 'dsfg', 1),
(42, 'Mini', 'Mini', 'Mini', 'dsfg', 1),
(43, 'Mitsubishi', 'Mitsubishi', 'Mitsubishi', 'dfg', 1),
(44, 'Nissan', 'Nissan', 'Nissan', 'dsfg', 1),
(45, 'Porsche', 'Porsche', 'Porsche', 'dsg', 1),
(46, 'Premier', 'Premier', 'Premier', 'dfg', 1),
(47, 'Renault', 'Renault', 'Renault', 'dsg', 1),
(48, 'Rolls-Royce', 'Rolls-Royce', 'Rolls-Royce', 'dgfdg', 1),
(49, 'San', 'San', 'San', 'daf', 1),
(50, 'Ssangyong', 'Ssangyong', 'Ssangyong', 'dgds', 1),
(51, 'Toyota', 'Toyota', 'Toyota', 'gfsrg', 1),
(52, 'Volkswagen', 'Volkswagen', 'Volkswagen', 'sdfg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ar` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ku` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name`, `ar`, `ku`) VALUES
(10, 'Ad-Dawr', 'الدور', 'Ad-Dawr'),
(11, 'Afak', 'عفك', 'Afak'),
(12, 'Al-Awja', 'العوجا', 'Al-Awja'),
(13, 'Al Diwaniyah', 'الديوانية', 'Al Diwaniyah'),
(14, 'Al Hillah', 'الحلة', 'Al Hillah'),
(15, 'Al-Qa\'im', 'القائم', 'Al-Qa\'im'),
(16, 'Amarah', 'العمارة', 'Amarah'),
(17, 'Arbil', 'اربيل', 'Arbil'),
(18, 'Baghdad', 'بغداد', 'Baghdad'),
(19, 'Baghdadi', 'البغدادي', 'Baghdadi'),
(20, 'Taji', 'التاجي', 'Taji'),
(21, 'Ad-Dawr', 'الدور', 'Ad-Dawr');

-- --------------------------------------------------------

--
-- Table structure for table `contact_admin`
--

CREATE TABLE `contact_admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `userId` int(11) NOT NULL,
  `userType` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_admin`
--

INSERT INTO `contact_admin` (`id`, `name`, `userId`, `userType`, `email`, `subject`, `message`) VALUES
(4, 'prakash', 5, '', 'prakash@harmistechnology.com', 'testing', 'testing message');

-- --------------------------------------------------------

--
-- Table structure for table `contact_agent`
--

CREATE TABLE `contact_agent` (
  `id` int(11) NOT NULL,
  `carId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `user_type` int(11) NOT NULL COMMENT '1 = show room admin , 2 = store admin , 3 = Company Admin',
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `dateFrom` date NOT NULL,
  `dateTo` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_agent`
--

INSERT INTO `contact_agent` (`id`, `carId`, `userId`, `user_type`, `firstName`, `lastName`, `nationality`, `email`, `phone`, `dateFrom`, `dateTo`) VALUES
(9, 0, 23, 1, 'chotu bhai', 'Don', 'indian', 'chotudon@gmail.com', '789456123', '2019-07-30', '2019-08-01'),
(10, 0, 23, 1, 'chotu bhai', 'Don', 'indian', 'chotudon@gmail.com', '789456123', '2019-07-30', '2019-08-01'),
(11, 0, 24, 2, 'chotu bhai', 'Don', 'indian', 'chotudon@gmail.com', '789456123', '2019-07-30', '2019-08-01'),
(12, 2, 8, 1, 'chotu bhai', 'Don', 'indian', 'chotudon@gmail.com', '789456123', '2019-07-30', '2019-08-01'),
(13, 2, 8, 1, 'chotu bhai', 'Don', 'indian', 'chotudon@gmail.com', '789456123', '2019-07-30', '2019-08-01'),
(14, 41, 12, 1, 'carlocal', 'carlocal', 'India', 'carlocal@gmail.com', '9865323652', '0000-00-00', '0000-00-00'),
(15, 41, 12, 1, 'carlocal', 'carlocal', 'India', 'carlocal@gmail.com', '9865323652', '0000-00-00', '0000-00-00'),
(16, 41, 12, 1, 'carlocal', 'carlocal', 'India', 'carlocal@gmail.com', '9865323652', '2019-09-17', '2019-09-28'),
(17, 41, 12, 1, 'carlocal', 'carlocal', 'India', 'carlocal@gmail.com', '9865323652', '2019-09-17', '2019-09-28'),
(18, 2, 8, 1, 'chotu bhai', 'Don', 'indian', 'chotudon@gmail.com', '789456123', '2019-07-30', '2019-08-01'),
(19, 2, 8, 1, 'chotu bhai', 'Don', 'indian', 'chotudon@gmail.com', '789456123', '2019-07-30', '2019-08-01'),
(20, 41, 12, 1, 'carlocal', 'carlocal', 'India', 'carlocal@gmail.com', '9865323652', '2019-09-17', '2019-09-28'),
(21, 2, 8, 1, 'chotu bhai', 'Don', 'indian', 'chotudon@gmail.com', '789456123', '2019-07-30', '2019-08-01'),
(22, 41, 12, 1, 'carlocal', 'carlocal', 'India', 'carlocal@gmail.com', '9865323652', '2019-09-17', '2019-09-28'),
(23, 41, 16, 1, 'carloc', 'patel', 'Afghan', 'carloc@gmail.com', '9898989898', '2030-09-16', '2022-09-16'),
(36, 44, 4, 3, 'heery', 'son', '1', 'herry@gmail.com', '9632587410', '2017-06-01', '2019-06-01'),
(37, 39, 15, 3, 'sandip', 'hawlett', '2', 'sandip1@gmail.com', '78755555', '2017-06-01', '2019-06-01'),
(38, 39, 15, 3, 'Nancy', 'hawlett', '1', 'nancyhawlett@gmail.com', '7845127845', '2017-06-01', '2019-06-01'),
(39, 54, 12, 1, 'carlocal', 'olpoo', 'Dubai', 'carlocal@gmail.com', '9865323652', '2019-12-21', '2023-09-21'),
(40, 39, 12, 1, 'carlocal', 'olpoo', 'India', 'carlocal@gmail.com', '9865323652', '2023-09-26', '2024-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` longtext,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `email`, `message`, `created_date`) VALUES
(1, 'HITESH', 'hp@gmail.com', 'car sell', '2019-09-18 07:59:17');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `countries_id` int(11) NOT NULL,
  `countries_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `countries_iso_code_2` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `countries_iso_code_3` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `address_format_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`countries_id`, `countries_name`, `countries_iso_code_2`, `countries_iso_code_3`, `address_format_id`) VALUES
(1, 'Afghanistan', 'AF', 'AFG', 1),
(2, 'Albania', 'AL', 'ALB', 1),
(3, 'Algeria', 'DZ', 'DZA', 1),
(4, 'American Samoa', 'AS', 'ASM', 1),
(5, 'Andorra', 'AD', 'AND', 1),
(6, 'Angola', 'AO', 'AGO', 1),
(7, 'Anguilla', 'AI', 'AIA', 1),
(8, 'Antarctica', 'AQ', 'ATA', 1),
(9, 'Antigua and Barbuda', 'AG', 'ATG', 1),
(10, 'Argentina', 'AR', 'ARG', 1),
(11, 'Armenia', 'AM', 'ARM', 1),
(12, 'Aruba', 'AW', 'ABW', 1),
(13, 'Australia', 'AU', 'AUS', 1),
(14, 'Austria', 'AT', 'AUT', 5),
(15, 'Azerbaijan', 'AZ', 'AZE', 1),
(16, 'Bahamas', 'BS', 'BHS', 1),
(17, 'Bahrain', 'BH', 'BHR', 1),
(18, 'Bangladesh', 'BD', 'BGD', 1),
(19, 'Barbados', 'BB', 'BRB', 1),
(20, 'Belarus', 'BY', 'BLR', 1),
(21, 'Belgium', 'BE', 'BEL', 1),
(22, 'Belize', 'BZ', 'BLZ', 1),
(23, 'Benin', 'BJ', 'BEN', 1),
(24, 'Bermuda', 'BM', 'BMU', 1),
(25, 'Bhutan', 'BT', 'BTN', 1),
(26, 'Bolivia', 'BO', 'BOL', 1),
(27, 'Bosnia and Herzegowina', 'BA', 'BIH', 1),
(28, 'Botswana', 'BW', 'BWA', 1),
(29, 'Bouvet Island', 'BV', 'BVT', 1),
(30, 'Brazil', 'BR', 'BRA', 1),
(31, 'British Indian Ocean Territory', 'IO', 'IOT', 1),
(32, 'Brunei Darussalam', 'BN', 'BRN', 1),
(33, 'Bulgaria', 'BG', 'BGR', 1),
(34, 'Burkina Faso', 'BF', 'BFA', 1),
(35, 'Burundi', 'BI', 'BDI', 1),
(36, 'Cambodia', 'KH', 'KHM', 1),
(37, 'Cameroon', 'CM', 'CMR', 1),
(38, 'Canada', 'CA', 'CAN', 1),
(39, 'Cape Verde', 'CV', 'CPV', 1),
(40, 'Cayman Islands', 'KY', 'CYM', 1),
(41, 'Central African Republic', 'CF', 'CAF', 1),
(42, 'Chad', 'TD', 'TCD', 1),
(43, 'Chile', 'CL', 'CHL', 1),
(44, 'China', 'CN', 'CHN', 1),
(45, 'Christmas Island', 'CX', 'CXR', 1),
(46, 'Cocos (Keeling) Islands', 'CC', 'CCK', 1),
(47, 'Colombia', 'CO', 'COL', 1),
(48, 'Comoros', 'KM', 'COM', 1),
(49, 'Congo', 'CG', 'COG', 1),
(50, 'Cook Islands', 'CK', 'COK', 1),
(51, 'Costa Rica', 'CR', 'CRI', 1),
(52, 'Cote D\'Ivoire', 'CI', 'CIV', 1),
(53, 'Croatia', 'HR', 'HRV', 1),
(54, 'Cuba', 'CU', 'CUB', 1),
(55, 'Cyprus', 'CY', 'CYP', 1),
(56, 'Czech Republic', 'CZ', 'CZE', 1),
(57, 'Denmark', 'DK', 'DNK', 1),
(58, 'Djibouti', 'DJ', 'DJI', 1),
(59, 'Dominica', 'DM', 'DMA', 1),
(60, 'Dominican Republic', 'DO', 'DOM', 1),
(61, 'East Timor', 'TP', 'TMP', 1),
(62, 'Ecuador', 'EC', 'ECU', 1),
(63, 'Egypt', 'EG', 'EGY', 1),
(64, 'El Salvador', 'SV', 'SLV', 1),
(65, 'Equatorial Guinea', 'GQ', 'GNQ', 1),
(66, 'Eritrea', 'ER', 'ERI', 1),
(67, 'Estonia', 'EE', 'EST', 1),
(68, 'Ethiopia', 'ET', 'ETH', 1),
(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', 1),
(70, 'Faroe Islands', 'FO', 'FRO', 1),
(71, 'Fiji', 'FJ', 'FJI', 1),
(72, 'Finland', 'FI', 'FIN', 1),
(73, 'France', 'FR', 'FRA', 1),
(74, 'France, Metropolitan', 'FX', 'FXX', 1),
(75, 'French Guiana', 'GF', 'GUF', 1),
(76, 'French Polynesia', 'PF', 'PYF', 1),
(77, 'French Southern Territories', 'TF', 'ATF', 1),
(78, 'Gabon', 'GA', 'GAB', 1),
(79, 'Gambia', 'GM', 'GMB', 1),
(80, 'Georgia', 'GE', 'GEO', 1),
(81, 'Germany', 'DE', 'DEU', 5),
(82, 'Ghana', 'GH', 'GHA', 1),
(83, 'Gibraltar', 'GI', 'GIB', 1),
(84, 'Greece', 'GR', 'GRC', 1),
(85, 'Greenland', 'GL', 'GRL', 1),
(86, 'Grenada', 'GD', 'GRD', 1),
(87, 'Guadeloupe', 'GP', 'GLP', 1),
(88, 'Guam', 'GU', 'GUM', 1),
(89, 'Guatemala', 'GT', 'GTM', 1),
(90, 'Guinea', 'GN', 'GIN', 1),
(91, 'Guinea-bissau', 'GW', 'GNB', 1),
(92, 'Guyana', 'GY', 'GUY', 1),
(93, 'Haiti', 'HT', 'HTI', 1),
(94, 'Heard and Mc Donald Islands', 'HM', 'HMD', 1),
(95, 'Honduras', 'HN', 'HND', 1),
(96, 'Hong Kong', 'HK', 'HKG', 1),
(97, 'Hungary', 'HU', 'HUN', 1),
(98, 'Iceland', 'IS', 'ISL', 1),
(99, 'India', 'IN', 'IND', 1),
(100, 'Indonesia', 'ID', 'IDN', 1),
(101, 'Iran (Islamic Republic of)', 'IR', 'IRN', 1),
(102, 'Iraq', 'IQ', 'IRQ', 1),
(103, 'Ireland', 'IE', 'IRL', 1),
(104, 'Israel', 'IL', 'ISR', 1),
(105, 'Italy', 'IT', 'ITA', 1),
(106, 'Jamaica', 'JM', 'JAM', 1),
(107, 'Japan', 'JP', 'JPN', 1),
(108, 'Jordan', 'JO', 'JOR', 1),
(109, 'Kazakhstan', 'KZ', 'KAZ', 1),
(110, 'Kenya', 'KE', 'KEN', 1),
(111, 'Kiribati', 'KI', 'KIR', 1),
(112, 'Korea, Democratic People\'s Republic of', 'KP', 'PRK', 1),
(113, 'Korea, Republic of', 'KR', 'KOR', 1),
(114, 'Kuwait', 'KW', 'KWT', 1),
(115, 'Kyrgyzstan', 'KG', 'KGZ', 1),
(116, 'Lao People\'s Democratic Republic', 'LA', 'LAO', 1),
(117, 'Latvia', 'LV', 'LVA', 1),
(118, 'Lebanon', 'LB', 'LBN', 1),
(119, 'Lesotho', 'LS', 'LSO', 1),
(120, 'Liberia', 'LR', 'LBR', 1),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', 1),
(122, 'Liechtenstein', 'LI', 'LIE', 1),
(123, 'Lithuania', 'LT', 'LTU', 1),
(124, 'Luxembourg', 'LU', 'LUX', 1),
(125, 'Macau', 'MO', 'MAC', 1),
(126, 'Macedonia, The Former Yugoslav Republic of', 'MK', 'MKD', 1),
(127, 'Madagascar', 'MG', 'MDG', 1),
(128, 'Malawi', 'MW', 'MWI', 1),
(129, 'Malaysia', 'MY', 'MYS', 1),
(130, 'Maldives', 'MV', 'MDV', 1),
(131, 'Mali', 'ML', 'MLI', 1),
(132, 'Malta', 'MT', 'MLT', 1),
(133, 'Marshall Islands', 'MH', 'MHL', 1),
(134, 'Martinique', 'MQ', 'MTQ', 1),
(135, 'Mauritania', 'MR', 'MRT', 1),
(136, 'Mauritius', 'MU', 'MUS', 1),
(137, 'Mayotte', 'YT', 'MYT', 1),
(138, 'Mexico', 'MX', 'MEX', 1),
(139, 'Micronesia, Federated States of', 'FM', 'FSM', 1),
(140, 'Moldova, Republic of', 'MD', 'MDA', 1),
(141, 'Monaco', 'MC', 'MCO', 1),
(142, 'Mongolia', 'MN', 'MNG', 1),
(143, 'Montserrat', 'MS', 'MSR', 1),
(144, 'Morocco', 'MA', 'MAR', 1),
(145, 'Mozambique', 'MZ', 'MOZ', 1),
(146, 'Myanmar', 'MM', 'MMR', 1),
(147, 'Namibia', 'NA', 'NAM', 1),
(148, 'Nauru', 'NR', 'NRU', 1),
(149, 'Nepal', 'NP', 'NPL', 1),
(150, 'Netherlands', 'NL', 'NLD', 1),
(151, 'Netherlands Antilles', 'AN', 'ANT', 1),
(152, 'New Caledonia', 'NC', 'NCL', 1),
(153, 'New Zealand', 'NZ', 'NZL', 1),
(154, 'Nicaragua', 'NI', 'NIC', 1),
(155, 'Niger', 'NE', 'NER', 1),
(156, 'Nigeria', 'NG', 'NGA', 1),
(157, 'Niue', 'NU', 'NIU', 1),
(158, 'Norfolk Island', 'NF', 'NFK', 1),
(159, 'Northern Mariana Islands', 'MP', 'MNP', 1),
(160, 'Norway', 'NO', 'NOR', 1),
(161, 'Oman', 'OM', 'OMN', 1),
(162, 'Pakistan', 'PK', 'PAK', 1),
(163, 'Palau', 'PW', 'PLW', 1),
(164, 'Panama', 'PA', 'PAN', 1),
(165, 'Papua New Guinea', 'PG', 'PNG', 1),
(166, 'Paraguay', 'PY', 'PRY', 1),
(167, 'Peru', 'PE', 'PER', 1),
(168, 'Philippines', 'PH', 'PHL', 1),
(169, 'Pitcairn', 'PN', 'PCN', 1),
(170, 'Poland', 'PL', 'POL', 1),
(171, 'Portugal', 'PT', 'PRT', 1),
(172, 'Puerto Rico', 'PR', 'PRI', 1),
(173, 'Qatar', 'QA', 'QAT', 1),
(174, 'Reunion', 'RE', 'REU', 1),
(175, 'Romania', 'RO', 'ROM', 1),
(176, 'Russian Federation', 'RU', 'RUS', 1),
(177, 'Rwanda', 'RW', 'RWA', 1),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA', 1),
(179, 'Saint Lucia', 'LC', 'LCA', 1),
(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', 1),
(181, 'Samoa', 'WS', 'WSM', 1),
(182, 'San Marino', 'SM', 'SMR', 1),
(183, 'Sao Tome and Principe', 'ST', 'STP', 1),
(184, 'Saudi Arabia', 'SA', 'SAU', 1),
(185, 'Senegal', 'SN', 'SEN', 1),
(186, 'Seychelles', 'SC', 'SYC', 1),
(187, 'Sierra Leone', 'SL', 'SLE', 1),
(188, 'Singapore', 'SG', 'SGP', 4),
(189, 'Slovakia (Slovak Republic)', 'SK', 'SVK', 1),
(190, 'Slovenia', 'SI', 'SVN', 1),
(191, 'Solomon Islands', 'SB', 'SLB', 1),
(192, 'Somalia', 'SO', 'SOM', 1),
(193, 'South Africa', 'ZA', 'ZAF', 1),
(194, 'South Georgia and the South Sandwich Islands', 'GS', 'SGS', 1),
(195, 'Spain', 'ES', 'ESP', 3),
(196, 'Sri Lanka', 'LK', 'LKA', 1),
(197, 'St. Helena', 'SH', 'SHN', 1),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM', 1),
(199, 'Sudan', 'SD', 'SDN', 1),
(200, 'Suriname', 'SR', 'SUR', 1),
(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', 1),
(202, 'Swaziland', 'SZ', 'SWZ', 1),
(203, 'Sweden', 'SE', 'SWE', 1),
(204, 'Switzerland', 'CH', 'CHE', 1),
(205, 'Syrian Arab Republic', 'SY', 'SYR', 1),
(206, 'Taiwan', 'TW', 'TWN', 1),
(207, 'Tajikistan', 'TJ', 'TJK', 1),
(208, 'Tanzania, United Republic of', 'TZ', 'TZA', 1),
(209, 'Thailand', 'TH', 'THA', 1),
(210, 'Togo', 'TG', 'TGO', 1),
(211, 'Tokelau', 'TK', 'TKL', 1),
(212, 'Tonga', 'TO', 'TON', 1),
(213, 'Trinidad and Tobago', 'TT', 'TTO', 1),
(214, 'Tunisia', 'TN', 'TUN', 1),
(215, 'Turkey', 'TR', 'TUR', 1),
(216, 'Turkmenistan', 'TM', 'TKM', 1),
(217, 'Turks and Caicos Islands', 'TC', 'TCA', 1),
(218, 'Tuvalu', 'TV', 'TUV', 1),
(219, 'Uganda', 'UG', 'UGA', 1),
(220, 'Ukraine', 'UA', 'UKR', 1),
(221, 'United Arab Emirates', 'AE', 'ARE', 1),
(222, 'United Kingdom', 'GB', 'GBR', 1),
(223, 'United States', 'US', 'USA', 2),
(224, 'United States Minor Outlying Islands', 'UM', 'UMI', 1),
(225, 'Uruguay', 'UY', 'URY', 1),
(226, 'Uzbekistan', 'UZ', 'UZB', 1),
(227, 'Vanuatu', 'VU', 'VUT', 1),
(228, 'Vatican City State (Holy See)', 'VA', 'VAT', 1),
(229, 'Venezuela', 'VE', 'VEN', 1),
(230, 'Viet Nam', 'VN', 'VNM', 1),
(231, 'Virgin Islands (British)', 'VG', 'VGB', 1),
(232, 'Virgin Islands (U.S.)', 'VI', 'VIR', 1),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF', 1),
(234, 'Western Sahara', 'EH', 'ESH', 1),
(235, 'Yemen', 'YE', 'YEM', 1),
(236, 'Yugoslavia', 'YU', 'YUG', 1),
(237, 'Zaire', 'ZR', 'ZAR', 1),
(238, 'Zambia', 'ZM', 'ZMB', 1),
(239, 'Zimbabwe', 'ZW', 'ZWE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `currencies_id` int(11) NOT NULL,
  `title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `code` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `symbol_left` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `symbol_right` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `decimal_point` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thousands_point` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `decimal_places` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` float(13,8) DEFAULT NULL,
  `last_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`currencies_id`, `title`, `code`, `symbol_left`, `symbol_right`, `decimal_point`, `thousands_point`, `decimal_places`, `value`, `last_updated`) VALUES
(1, 'U.S. Dollar', 'USD', '$', NULL, '.', '.', '2', NULL, '2017-02-09 00:00:00'),
(2, 'Euro', 'EUR', NULL, '€', '.', '.', '2', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customers_id` int(11) NOT NULL,
  `customers_gender` char(1) COLLATE utf8_unicode_ci DEFAULT '0',
  `customers_firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customers_lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `countries_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customers_dob` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customers_default_address_id` int(11) DEFAULT NULL,
  `customers_telephone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customers_fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `customers_newsletter` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `fb_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customers_picture` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(100) NOT NULL,
  `updated_at` int(100) NOT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customers_id`, `customers_gender`, `customers_firstname`, `customers_lastname`, `company_name`, `title_name`, `countries_name`, `customers_dob`, `email`, `user_name`, `customers_default_address_id`, `customers_telephone`, `customers_fax`, `password`, `customers_newsletter`, `isActive`, `fb_id`, `google_id`, `customers_picture`, `created_at`, `updated_at`, `is_seen`, `remember_token`) VALUES
(1, NULL, 'harmis', 'harmis', 'harmistest new', 'harmistest title', 'India', '', 'harmistest@gmail.com', '', NULL, '5452132123211', NULL, '$2y$10$GpsgFS4HG04M8e8xdFidLOie8gZ2IpIuBkww98jkfB/0qHYgLY4nu', NULL, 1, NULL, NULL, 'resources/assets/images/user_profile/default_user.png', 19, 19, 0, 'KHhBzGINzlpTOmNP1DRka1gKyjTJEhhRbRs5TgacFchUBDzTJ8gnnGuIZyU2'),
(2, NULL, 'test', 'test', 'test', 'test', 'Afghanistan', '', 'test@gmail.com', '', NULL, '', NULL, '$2y$10$B0vsSXQai8KCq.Tdp4SbD.9W4Nh6XRx/7ltQhgB4is/f.MIJvNacm', NULL, 1, NULL, NULL, 'resources/assets/images/user_profile/default_user.png', 19, 19, 0, '8kRXrVrSbi16RLYsOIbw32kTMTE2A7PZ76th5BgQrhJz7YWAI9cSmL65X72X'),
(3, NULL, 'demo', 'demo', 'demo123456', 'demo123', 'Canada', '', 'demo@gmail.com', '', NULL, '', NULL, '$2y$10$8N0FlkUdNOZRr0eb79mJBukWnBExjuksmb0/qA4RIlcLgHhQJzkAy', NULL, 1, NULL, NULL, 'resources/assets/images/user_profile/default_user.png', 19, 19, 0, 'UFfULVxIpeSg5qcCp1GONw4fL0rtijDrVSH6HZCbSTnRHvI1AoNIo6bGOqzo'),
(4, NULL, 'dddd', 'dddd', 'ccccc', 'aaaa', 'Cocos (Keeling) Islands', '', 'ddd@gmail.com', '', NULL, '787987889', NULL, '$2y$10$25wMKPnlDG1LaLjYFklVQ.vRfG1rzZcxUPQMgcYp8mU18A.f8qCbq', NULL, 1, NULL, NULL, 'resources/assets/images/user_profile/default_user.png', 19, 19, 0, ''),
(5, NULL, 'harmis', 'harmis123', 'harmis technology', 'new test', 'India', '', 'urvisha@harmistechnology.com', '', NULL, '', NULL, '$2y$10$RQZRpw2BvXMkx2a0YfSCyeGLzirwXQch5/1jexW/FXoWRGcK0hPiu', NULL, 1, NULL, NULL, 'resources/assets/images/user_profile/1550835854.googleplus.png', 19, 19, 0, 't0a3qDIP5KzVZNxrqQ9GSwp0OHBHcqp2e06khwXrgCGByhrGuPUaXbnpDl8s');

-- --------------------------------------------------------

--
-- Table structure for table `driverLicense`
--

CREATE TABLE `driverLicense` (
  `id` int(11) NOT NULL,
  `c_agentId` int(11) NOT NULL,
  `license` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `driverLicense`
--

INSERT INTO `driverLicense` (`id`, `c_agentId`, `license`) VALUES
(20, 9, '1566207496.index.jpeg'),
(21, 10, '1566207937.index.jpeg'),
(22, 11, '1566207998.index.jpeg'),
(23, 13, '1568617782.bugati.jpg'),
(24, 13, '1568617782.download.jpg'),
(25, 13, '1568617783.images.jpg'),
(26, 14, '1568625395.IMG-20190916-WA0000.jpg'),
(27, 15, '1568625578.test.png'),
(28, 16, '1568625797.IMG-20190916-WA0000.jpg'),
(29, 17, '1568625812.test.png'),
(30, 20, '1568626194.test.png'),
(31, 22, '1568626312.IMG-20190916-WA0000.jpg'),
(32, 23, '1568627251.IMG-20190807-WA0000.jpg'),
(42, 36, '1568973017_0_coocker1.jpeg'),
(43, 36, '1568973018_1_speaker5.jpg'),
(44, 36, '1568973018_2_speaker4.jpeg'),
(45, 37, '1568974696_0_wallet7.jpeg'),
(46, 37, '1568974696_1_wallet3.jpg'),
(47, 37, '1568974696_2_user7.jpeg'),
(48, 38, '1568975101_0_wallet3.jpg'),
(49, 38, '1568975101_1_wallet1.jpeg'),
(50, 38, '1568975101_2_user6.jpeg'),
(51, 38, '1568975101_3_user5.jpeg'),
(52, 39, '1569059714.images-(1).jpeg'),
(53, 40, '1569483395.images-(2).jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `fueltype`
--

CREATE TABLE `fueltype` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ar` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ku` varchar(255) CHARACTER SET utf8 NOT NULL,
  `published` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fueltype`
--

INSERT INTO `fueltype` (`id`, `name`, `ar`, `ku`, `published`) VALUES
(1, 'Petrol', 'Petrol', 'Petrol', 1),
(2, 'Diesel', 'Diesel', 'Diesel', 1),
(3, 'Gas', 'Gas', 'Gas', 1);

-- --------------------------------------------------------

--
-- Table structure for table `get_touch`
--

CREATE TABLE `get_touch` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `get_touch`
--

INSERT INTO `get_touch` (`id`, `title`, `description`, `address`, `phone`, `email`) VALUES
(1, 'Iraq Cars', '<p>Sed do eiusmod temporut labore et dolore magna aliqua. Your perfect place to buy &amp; sell</p>', '804/2 Baghdad, iraq', '+91 0123456789', 'info@contact.com');

-- --------------------------------------------------------

--
-- Table structure for table `homeslide`
--

CREATE TABLE `homeslide` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `titlearabic` varchar(255) CHARACTER SET utf8 NOT NULL,
  `descriptionarabic` longtext CHARACTER SET utf8 NOT NULL,
  `titlekurdish` varchar(255) NOT NULL,
  `descriptionkurdish` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `homeslide`
--

INSERT INTO `homeslide` (`id`, `title`, `image`, `description`, `titlearabic`, `descriptionarabic`, `titlekurdish`, `descriptionkurdish`) VALUES
(1, 'BOOK A CAR TODAY!', '1568612006.slider-img-1.jpg', '<p>FOR AS LOW AS $10 A DAY PLUS 15% DISCOUNT</p><p>FOR OUR RETURNING CUSTOMERS</p>', 'احجز سيارة اليوم!', '<p>مقابل أقل من 10 دولارات في اليوم بالإضافة إلى خصم 15 ٪</p><p>لعملائنا العائدين</p>', 'TENOD LI KIRIN!', '<p>JI BO JI BO 10 $ A DAY PLN PLUS 15% KIRIN</p><p>JI BO XWARN XWEYN XWEYN</p>'),
(2, 'BOOK A CAR TODAY!', '1568612104.slider-img-2.jpg', '<p>FOR AS LOW AS $10 A DAY PLUS 15% DISCOUNT</p><p>FOR OUR RETURNING CUSTOMERS</p>', 'احجز سيارة اليوم!', '<p>مقابل أقل من 10 دولارات في اليوم بالإضافة إلى خصم 15 ٪</p><p>لعملائنا العائدين</p>', 'TENOD LI KIRIN!', '<p>JI BO JI BO 10 $ A DAY PLN PLUS 15% KIRIN</p><p>JI BO XWARN XWEYN XWEYN</p>'),
(3, 'BOOK A CAR TODAY!', '1568612148.slider-img-3.jpg', '<p>FOR AS LOW AS $10 A DAY PLUS 15% DISCOUNT</p><p>FOR OUR RETURNING CUSTOMERS</p>', 'احجز سيارة اليوم!', '<p>مقابل أقل من 10 دولارات في اليوم بالإضافة إلى خصم 15 ٪</p><p>لعملائنا العائدين</p>', 'TENOD LI KIRIN!', '<p>JI BO JI BO 10 $ A DAY PLN PLUS 15% KIRIN</p><p>JI BO XWARN XWEYN XWEYN</p>'),
(4, 'BOOK A CAR TODAY!', '1568873696.slider-img-4.jpg', '<p>FOR AS LOW AS $10 A DAY PLUS 15% DISCOUNT</p><p>FOR OUR RETURNING CUSTOMERS</p>', 'احجز سيارة اليوم!', '<p>مقابل أقل من 10 دولارات في اليوم بالإضافة إلى خصم 15 ٪</p><p>لعملائنا العائدين</p>', 'TENOD LI KIRIN!', '<p>JI BO JI BO 10 $ A DAY PLN PLUS 15% KIRIN</p><p>JI BO XWARN XWEYN XWEYN</p>');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `languages_id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `code` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `image` mediumtext COLLATE utf8_unicode_ci,
  `directory` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(3) DEFAULT NULL,
  `direction` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_default` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`languages_id`, `name`, `code`, `image`, `directory`, `sort_order`, `direction`, `is_default`) VALUES
(1, 'English', 'en', 'resources/assets/images/language_flags/1486556365.503984030_english.jpg', 'english', 1, 'ltr', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_05_01_064329_user_group', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `Order_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `TotalCount` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Mobile` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `address` longtext NOT NULL,
  `city` int(255) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`Order_ID`, `User_ID`, `Status`, `TotalCount`, `Name`, `Mobile`, `pincode`, `address`, `city`, `datetime`) VALUES
(1, 4, 'Delivered', '4404350', 'edward', '9632587410', '380015', 'new', 12, '2019-09-17 07:50:16'),
(2, 5, 'Delivered', '20', 'hello', '3698521470', 'nehrunagar', 'nehrunagar', 0, '2019-09-17 09:00:45'),
(3, 5, 'Shipping', '20', 'hello', '3698521470', 'nehrunagar', 'nehrunagar', 0, '2019-09-17 09:05:15'),
(4, 5, 'Pending', '20', 'hello', '3698521470', 'nehrunagar', 'nehrunagar', 0, '2019-09-17 09:35:59'),
(5, 16, 'Pending', '400000.0', 'carloc patel', '9898989898', 'Iraq', 'Iraq', 0, '2019-09-17 09:43:38'),
(6, 16, 'Pending', '400000.0', 'carloc patel', '9898989898', 'Iraq', 'Iraq', 0, '2019-09-17 09:50:22'),
(7, 15, 'Pending', '50000', 'Nancy hawlett', '7845127845', '78964563', 'america', 12, '2019-09-17 10:41:11'),
(8, 4, 'Pending', '450000', 'bcxb', '9632587410', '380015', 'new', 17, '2019-09-17 12:31:24'),
(9, 4, 'Pending', '450000', 'jfg', '9632587410', '380015', 'newjgfjf', 19, '2019-09-17 12:32:42'),
(10, 17, 'Pending', '3048045', 'test1', '9789', '879', '87987', 18, '2019-09-17 12:33:24'),
(11, 4, 'Pending', '450000', 'jfg', '9632587410', '380015', 'newjgfjf', 19, '2019-09-17 12:33:44'),
(12, 4, 'Pending', '450000', 'jfg', '9632587410', '380015', 'newjgfjf', 19, '2019-09-17 12:35:34'),
(13, 4, 'Pending', '450000', 'jfg', '9632587410', '380015', 'newjgfjf', 19, '2019-09-17 12:35:54'),
(14, 4, 'Pending', '450000', 'jfg', '9632587410', '380015', 'newjgfjf', 19, '2019-09-17 12:36:00'),
(15, 4, 'Pending', '100000', 'helloma', '9632587410', '380015', '123456', 20, '2019-09-18 04:41:46'),
(16, 15, 'Pending', '970870', 'sandip', '78755555', '7874125', 'ahmedabad', 11, '2019-09-19 04:43:16'),
(17, 15, 'Pending', '435435', 'Nancy hawlett', '7845127845', '78964563', 'america', 12, '2019-09-19 07:21:24'),
(20, 12, 'Pending', '100000.0', 'carlocal olpoo', '9865323652', 'Mosul, Iraq', 'Mosul, Iraq', 0, '2019-09-20 11:55:15'),
(21, 15, 'Pending', '50000', 'Nancy hawlett', '7845127845', '78964563', 'america', 12, '2019-09-20 12:00:19'),
(22, 4, 'Pending', '50000', 'urvi', '9856232653', '380015', 'new', 19, '2019-09-20 12:01:12'),
(23, 15, 'Pending', '150000', 'Nancy hawlett', '7845127845', '78964563', 'america', 12, '2019-09-20 12:54:32'),
(24, 15, 'Pending', '100000', 'Nancy hawlett', '7845127845', '78964563', 'america', 12, '2019-09-20 12:55:06'),
(26, 12, 'Pending', '1035435.0', 'carlocal olpoo', '9865323652', 'Mosul, Iraq', 'Mosul, Iraq', 0, '2019-09-21 05:14:35'),
(27, 12, 'Pending', '635435.0', 'carlocal olpoo', '9865323652', 'Mosul, Iraq', 'Mosul, Iraq', 0, '2019-09-21 05:15:34'),
(28, 12, 'Pending', '635435.0', 'carlocal olpoo', '9865323652', 'Mosul, Iraq', 'Mosul, Iraq', 0, '2019-09-21 05:28:44'),
(29, 12, 'Pending', '150000.0', 'carlocal olpoo', '9865323652', 'Mosul, Iraq', 'Mosul, Iraq', 0, '2019-09-21 09:26:04'),
(30, 15, 'Pending', '300000', 'sandip', '78755555', '7874125', 'ahmedabad', 11, '2019-09-23 04:10:19'),
(31, 15, 'Pending', '100000', 'sandip', '78755555', '7874125', 'B 304/2,harmis technology,\nGopal palace jhansi ki rani BRTS bus stop,\nnear siromani complex', 12, '2019-09-23 05:18:11'),
(33, 19, 'Pending', '250000.0', 'testuser ', '9898989898', 'hello', 'hello', 0, '2019-09-23 09:21:31'),
(34, 19, 'Pending', '250000.0', 'testuser ', '7889788978', 'hello', 'hello', 0, '2019-09-23 09:22:58'),
(35, 19, 'Pending', '250000.0', 'testuser ', '896325410', 'hello', 'hello', 0, '2019-09-23 09:24:15'),
(36, 19, 'Pending', '250000.0', 'testuser ', '9898653265', 'nadiad', 'nadiad', 0, '2019-09-23 10:16:12'),
(37, 21, 'Pending', '150000.0', 'carlive ssss', '9898653265', 'Mosul, Iraq', 'Mosul, Iraq', 0, '2019-09-26 06:57:19'),
(38, 23, 'Pending', '100000', 'ravi', '7845127845', '78964563', 'america', 12, '2019-09-26 12:59:08'),
(39, 17, 'Pending', '1000000', 'prakash', '789456123', '78954', 'bsdjgbjsfbg', 11, '2019-09-27 05:25:36'),
(40, 17, 'Pending', '435435', 'prakash', '7845623123', '78946', 'dvshfjvhdsjvf', 10, '2019-09-27 05:30:32'),
(41, 19, 'Pending', '45000', 'test', '785464132', '7845', 'ljbdfhkgv', 20, '2019-09-27 05:39:21'),
(42, 14, 'Shipping', '90000', 'kinjal', '789456123', '789584', 'jsfbgjkbsk', 12, '2019-09-27 07:47:56'),
(43, 14, 'Pending', '435435', 'kinajal', '785456456', '789456', 'fsbgj', 11, '2019-09-27 07:50:39'),
(44, 14, 'Delivered', '145000', 'kinjal', '789456123', '798456', 'fjkdbshgvb', 17, '2019-09-27 07:51:48');

-- --------------------------------------------------------

--
-- Table structure for table `paymentGatway`
--

CREATE TABLE `paymentGatway` (
  `id` int(11) NOT NULL,
  `ownerid` int(11) NOT NULL,
  `propertyid` int(11) NOT NULL,
  `paymentId` longtext NOT NULL,
  `amount` varchar(255) NOT NULL,
  `customerId` longtext NOT NULL,
  `status` longtext NOT NULL,
  `recipetUrl` longtext NOT NULL,
  `balId` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `video` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paymentGatway`
--

INSERT INTO `paymentGatway` (`id`, `ownerid`, `propertyid`, `paymentId`, `amount`, `customerId`, `status`, `recipetUrl`, `balId`, `date`, `video`) VALUES
(1, 0, 0, 'ch_1EfM6jGebdXgb90nZvPswGoO', '50', 'cus_F9fRICC4rTN2TQ', 'Payment complete.', 'https://pay.stripe.com/receipts/acct_1Eb63KGebdXgb90n/ch_1EfM6jGebdXgb90nZvPswGoO/rcpt_F9fRMju0FzdBPs8UmKeq83sFH8EXONc', 'txn_1EfM6jGebdXgb90nR2vzvwbQ', '2019-07-13 12:46:09', ''),
(2, 0, 0, 'ch_1EfMESGebdXgb90n5vjL2XgW', '50', 'cus_F9fZNo3NAm9Fby', 'Payment complete.', 'https://pay.stripe.com/receipts/acct_1Eb63KGebdXgb90n/ch_1EfMESGebdXgb90n5vjL2XgW/rcpt_F9fZFMx5mkwpL28d6Ga0awqtC5dXxOh', 'txn_1EfMETGebdXgb90n98vnfIXq', '2019-07-13 12:46:09', ''),
(3, 0, 0, 'ch_1EnKgGGebdXgb90n90KTu9gx', '50', 'cus_FHuVWV49w76uPh', 'Payment complete.', 'https://pay.stripe.com/receipts/acct_1Eb63KGebdXgb90n/ch_1EnKgGGebdXgb90n90KTu9gx/rcpt_FHuVhKXGTQe0HzzzGpMAI5wkVTuapkO', 'txn_1EnKgGGebdXgb90n5dHR6bsG', '2019-07-13 12:46:09', ''),
(4, 1, 0, 'ch_1EvkaqGebdXgb90nFB7kpnHb', '50', 'cus_FQbolfs43kai5t', 'Payment complete.', 'https://pay.stripe.com/receipts/acct_1Eb63KGebdXgb90n/ch_1EvkaqGebdXgb90nFB7kpnHb/rcpt_FQboJjSsPjWZDBPIwaDjCqdgU9vNAj0', 'txn_1EvkaqGebdXgb90nHZjyznrO', '2019-07-13 12:46:09', ''),
(5, 1, 2, 'ch_1Evkh9GebdXgb90nDxejY6nN', '50', 'cus_FQbuGPCEpwOoZW', 'Payment complete.', 'https://pay.stripe.com/receipts/acct_1Eb63KGebdXgb90n/ch_1Evkh9GebdXgb90nDxejY6nN/rcpt_FQbuyRzTgungVgqSjw0DfXN2uY1XGua', 'txn_1Evkh9GebdXgb90nlWycMOsT', '2019-07-13 12:51:20', ''),
(6, 12, 102, 'ch_1EywDXGebdXgb90nPY3lo3Ql', '500', 'cus_FTu1QKzyzpwzIc', 'Payment complete.', 'https://pay.stripe.com/receipts/acct_1Eb63KGebdXgb90n/ch_1EywDXGebdXgb90nPY3lo3Ql/rcpt_FTu1my9K0uWBHWkVDqdjJhUSyEl2tzc', 'txn_1EywDXGebdXgb90nnRZPlXCx', '2019-07-22 07:45:56', 'http://192.168.1.20/realestate/public/templateVideo/20190516.180301_10_A_GardenHill_10.mp4'),
(7, 12, 102, 'ch_1EywEzGebdXgb90ndL7U5NeI', '500', 'cus_FTu3lQgvPwLZoR', 'Payment complete.', 'https://pay.stripe.com/receipts/acct_1Eb63KGebdXgb90n/ch_1EywEzGebdXgb90ndL7U5NeI/rcpt_FTu3ztlz1JR2DjCYq4on60dkelcRBtg', 'txn_1EywEzGebdXgb90n8tLOgHSO', '2019-07-22 07:47:26', 'public/templateVideo/20190516.180301_10_A_GardenHill_10.mp4'),
(8, 12, 102, 'ch_1EywGvGebdXgb90nX33QZtiA', '500', 'cus_FTu5E46rKdCNO9', 'Payment complete.', 'https://pay.stripe.com/receipts/acct_1Eb63KGebdXgb90n/ch_1EywGvGebdXgb90nX33QZtiA/rcpt_FTu5t0uwXRUcV7jBv5osJTQs7v0Ad63', 'txn_1EywGvGebdXgb90neKruwiBs', '2019-07-22 07:49:25', '20190516.180301_10_A_GardenHill_10.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `pdf_report`
--

CREATE TABLE `pdf_report` (
  `id` int(11) NOT NULL,
  `pro_name` varchar(255) NOT NULL,
  `pdf_upload` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pdf_report`
--

INSERT INTO `pdf_report` (`id`, `pro_name`, `pdf_upload`) VALUES
(1, '6', '1559127909.Two-page-Hello-World.pdf'),
(2, '7', '1559129065.Expense-Report.pdf'),
(3, '6', '1559547762.new_enquiry.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `Place_Order`
--

CREATE TABLE `Place_Order` (
  `Place_Order_ID` int(11) NOT NULL,
  `Order_ID` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Place_Order`
--

INSERT INTO `Place_Order` (`Place_Order_ID`, `Order_ID`, `Product_ID`, `Name`, `Price`, `Quantity`) VALUES
(1, 1, 7, 'Tire Set', '435435', 1),
(2, 1, 11, 'Sound System', '50000', 2),
(3, 2, 1, 'newone', '10', 1),
(4, 2, 1, 'newone', '10', 1),
(5, 3, 7, 'Tire Set', '10', 1),
(6, 3, 11, 'Sound System', '10', 1),
(7, 4, 7, 'Tire Set', '10', 1),
(8, 4, 11, 'Sound System', '10', 1),
(9, 5, 12, 'AC colder', '400000.0', 4),
(10, 6, 12, 'AC colder', '400000.0', 4),
(11, 7, 11, 'Sound System', '50000', 2),
(12, 14, 11, 'Sound System', '50000', 9),
(13, 15, 12, 'AC colder', '100000', 1),
(14, 16, 7, 'Tire Set', '435435', 1),
(15, 16, 12, 'AC colder', '100000', 25),
(16, 17, 7, 'Tire Set', '435435', 1),
(22, 23, 11, 'Sound System', '50000', 1),
(28, 26, 7, 'Tire Set', '435435.0', 1),
(30, 27, 7, 'Tire Set', '435435.0', 1),
(32, 28, 7, 'Tire Set', '435435.0', 1),
(33, 29, 12, 'AC colder', '100000.0', 1),
(35, 30, 12, 'AC colder', '100000', 3),
(36, 31, 12, 'AC colder', '100000', 1),
(38, 33, 12, 'AC colder', '100000.0', 1),
(39, 33, 11, 'Sound System', '150000.0', 3),
(40, 34, 12, 'AC colder', '100000.0', 1),
(41, 34, 11, 'Sound System', '150000.0', 3),
(42, 35, 12, 'AC colder', '100000.0', 1),
(43, 35, 11, 'Sound System', '150000.0', 3),
(44, 36, 12, 'AC colder', '100000.0', 1),
(45, 36, 11, 'Sound System', '150000.0', 3),
(46, 37, 12, 'AC colder', '100000.0', 1),
(47, 37, 11, 'Sound System', '50000.0', 1),
(48, 38, 12, 'AC colder', '100000', 1),
(49, 39, 12, 'AC colder', '100000', 10),
(50, 40, 7, 'Tire Set', '435435', 1),
(51, 41, 13, 'demo pro', '45000', 1),
(52, 42, 13, 'demo pro', '45000', 2),
(53, 43, 7, 'Tire Set', '435435', 1),
(54, 44, 13, 'demo pro', '45000', 1),
(55, 44, 12, 'AC colder', '100000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `procategory`
--

CREATE TABLE `procategory` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ar` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ku` varchar(255) CHARACTER SET utf8 NOT NULL,
  `published` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `procategory`
--

INSERT INTO `procategory` (`id`, `name`, `ar`, `ku`, `published`) VALUES
(3, 'Interior Parts', 'Interior Parts', 'Interior Parts', 1),
(4, 'Exterior Parts', 'الأجزاء الخارجية', 'Parçeyên derveyî', 1),
(5, 'Ignition System', 'Ignition System', 'Ignition System', 1),
(6, 'Engines & Components', 'Engines & Components', 'Engines & Components', 1),
(7, 'Air Intake System', 'Air Intake System', 'Air Intake System', 1),
(8, 'Brake System', 'Brake System', 'Brake System', 1),
(9, 'Cooling System', 'Cooling System', 'Cooling System', 1),
(10, 'Glasses & Windows', 'Glasses & Windows', 'Glasses & Windows', 1),
(11, 'Other Tools', 'Other Tools', 'Other Tools', 1);

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `property_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` int(11) NOT NULL,
  `sale_price` varchar(20) DEFAULT NULL,
  `month_rentprice` varchar(255) DEFAULT NULL,
  `daily_rentprice` float DEFAULT NULL,
  `weekly_rentprice` float DEFAULT NULL,
  `description` longtext NOT NULL,
  `pro_type` int(11) NOT NULL,
  `car_brand` int(11) NOT NULL,
  `kilometer` varchar(255) NOT NULL,
  `year_of_car` varchar(255) NOT NULL,
  `specification` varchar(255) NOT NULL,
  `prop_category` varchar(255) DEFAULT NULL,
  `fueltype` varchar(255) NOT NULL,
  `googleLocation` text NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL,
  `userType` varchar(255) NOT NULL COMMENT '1=users,2=showroom,3=company',
  `userId` int(11) NOT NULL,
  `showRoomId` int(11) NOT NULL,
  `companyId` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `isrequested` int(11) NOT NULL,
  `published` tinyint(4) NOT NULL,
  `video` varchar(255) NOT NULL,
  `gear_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `property_name`, `address`, `city`, `sale_price`, `month_rentprice`, `daily_rentprice`, `weekly_rentprice`, `description`, `pro_type`, `car_brand`, `kilometer`, `year_of_car`, `specification`, `prop_category`, `fueltype`, `googleLocation`, `lat`, `lng`, `userType`, `userId`, `showRoomId`, `companyId`, `email`, `phone`, `isrequested`, `published`, `video`, `gear_type`) VALUES
(1, 'swift', 'dshjkfhjv', 18, '150000', '12000', 0, 0, 'hdsvfhj', 1, 4, '50000', '1995', '3', '11', '1', 'Jashodanagar Fire Station, Jashoda Nagar, Ahmedabad, Gujarat, India', '22.9833426', '72.62410990000001', '1', 2, 0, 29, 'murat@gmail.com', '789456123', 0, 1, '', 'Automatic'),
(2, 'scorpio', 'fsgsfg', 11, '780000', '45000', NULL, NULL, 'dghdgh', 1, 3, '456', '2016', 'mahindra', '6', '', 'Naroda, Ahmedabad, Gujarat, India', '23.0685865', '72.65359609999996', '1', 3, 0, 0, 'bella@gmail.com', '789456123', 0, 1, '', ''),
(3, 'Wagon R', 'jdkbkf', 11, '7895000', '78000', 0, 0, 'sdfbhgb', 1, 2, '456000', '2016', '1', '2', '2', 'Jashodanagar Fire Station, Jashoda Nagar, Ahmedabad, Gujarat, India', '22.9833426', '72.62410990000001', '1', 3, 0, 0, 'prakash@gmail.com', '789456123', 1, 1, '', 'Automatic'),
(4, 'volo sport', 'dbafkjbdsfk', 17, '78000000', '4513', NULL, NULL, 'jskdbgkjbsd', 2, 10, '3550000', '2025', 'abcd', '18', '', 'Dubai - United Arab Emirates', '25.2048493', '55.270782800000006', '2', 0, 30, 0, 'prakash@gmail.com', '789456123', 0, 1, '', 'Manual'),
(6, 'volvo', 'fdsghfh', 13, '4500000', '369451', NULL, NULL, 'fsgdfg', 1, 10, '78000', '25', '2', '18', '2', 'Kuwait', '29.31166', '47.48176599999999', '2', 0, 24, 0, 'prakash@gmail.com', '789456132', 0, 1, '', 'Automatic'),
(7, 'maruti swift', 'bkfhjdsbgk', 15, '4500000', '985', NULL, NULL, 'sbfgkjb', 1, 2, '435', '40', 'bhjfs gh', '1', '', 'JSS Circle, 7th Block, Jayanagar, Bengaluru, Karnataka', '12.923413', '77.57621549999999', '2', 0, 24, 0, 'akash@gmail.com', '789456456132', 0, 1, '', ''),
(13, 'Mahindra', 'ahmedabad', 14, '56000', '', NULL, NULL, 'made in india', 1, 3, '7000', '2015', 'Petrol  Manual  20/22 KMPL', '7', '', 'ahmedabad', '', '', '1', 1, 0, 0, 'prakash@gmail.com', '789456123', 0, 1, '', ''),
(14, 'Mahindra', 'ahmedabad', 18, '56000', '', NULL, NULL, 'made in india', 1, 3, '7000', '2015', 'Petrol  Manual  20/22 KMPL', '7', '', 'ahmedabad', '', '', '1', 1, 0, 0, 'prakash@gmail.com', '789456123', 0, 1, '', ''),
(15, 'Mahindra', 'ahmedabad', 17, '56000', '', NULL, NULL, 'made in india', 1, 3, '7000', '2015', 'Petrol  Manual  20/22 KMPL', '7', '', 'ahmedabad', '', '', '1', 1, 0, 0, 'prakash@gmail.com', '789456123', 0, 1, '', ''),
(16, 'Mahindra', 'ahmedabad', 16, '450000', '', NULL, NULL, 'made in india', 1, 3, '50000', '2011', 'Petrol  Manual  20/22 KMPL', '6', '', 'iraq', '', '', '1', 1, 0, 0, 'prakash@gmail.com', '789456123', 0, 1, '', ''),
(17, 'dfhgd', 'fghgf', 0, '456476', '', NULL, NULL, 'gchfgh', 1, 3, '65365', '4567', 'gfhfghfgh', '2', '', 'Daftö, Sweden', '58.9037652', '11.183584600000017', '1', 2, 0, 0, 'cvhfg@gmail.com', '78945643123', 0, 1, '', ''),
(18, 'rt', 'df', 2, '67', '566', NULL, NULL, 'dfdf', 1, 3, '56', '2013', 'df', '2', '', 'Ahmednagar, Maharashtra, India', '19.0948287', '74.74797890000002', '1', 1, 0, 0, 'tes@gmail.com', '45', 0, 1, '', ''),
(19, 'Ford', 'Mosul, Iraq', 0, '', '3000000', NULL, NULL, 'bfhfj', 2, 5, '30000', '', '3 tear ac', '6', '', 'Mosul, Iraq', '', '', '1', 9, 0, 0, 'amit@gmail.com', '9724604987', 0, 0, '', ''),
(20, 'Ford', 'Mosul, Iraq', 0, '', '3000000', NULL, NULL, 'bfhfj', 2, 5, '30000', '', '3 tear ac', '6', '', 'Mosul, Iraq', '', '', '1', 9, 0, 0, 'amit@gmail.com', '9724604987', 0, 1, '', ''),
(21, 'Ford', 'Mosul, Iraq', 13, '2000000', '2000000', NULL, NULL, 'car desc updated', 2, 5, '200000', '2012', 'Heavy Body', '18', '', 'Mosul, Iraq', '', '', '1', 12, 0, 0, 'carlocal@gmail.com', '9865323652', 0, 1, '', ''),
(22, 'Ford', 'Mosul, Iraq', 0, '600000', '50000', NULL, NULL, 'car is actually 5years old and better comdomt', 1, 5, '60000', '', 'Auto', '8', '', 'Mosul, Iraq', '', '', '1', 12, 0, 0, 'carlocal@gmail.com', '9898989898', 0, 1, '', ''),
(23, 'Tata', 'Mosul, Iraq', 0, '500000', '', NULL, NULL, 'xbxxb', 1, 4, '10000', '', '320 speed', '8', '', 'Mosul, Iraq', '', '', '1', 12, 0, 0, 'carlocal@gmail.com', '9865323652', 0, 1, '', ''),
(24, 'Ford', 'Mosul, Iraq', 0, '20000', '', NULL, NULL, 'vxvd', 1, 5, '50000', '', '3 tear ac', '7', '', 'Mosul, Iraq', '', '', '1', 12, 0, 0, 'carlocal@gmail.com', '9865323652', 0, 1, '', ''),
(25, 'Mahindra', 'Mosul, Iraq', 0, '', '20000', NULL, NULL, 'ggsgs', 2, 3, '500000', '', '320 speed', '5', '', 'Mosul, Iraq', '', '', '1', 12, 0, 0, 'carlocal@gmail.com', '9865323652', 0, 0, '', ''),
(26, 'Tata', 'Mosul, Iraq', 0, '', '200000', NULL, NULL, 'gzgz', 2, 4, '98998888', '', '3 tear ac', '9', '', 'Mosul, Iraq', '', '', '1', 12, 0, 0, 'carlocal@gmail.com', '9865323652', 0, 0, '', ''),
(27, 'Tata', 'Mosul, Iraq', 0, '', '20000', NULL, NULL, 'xxnnc', 2, 4, '5000', '', 'Tubeless', '8', '', 'Mosul, Iraq', '', '', '1', 12, 0, 0, 'carlocal@gmail.com', '9865323652', 0, 1, '', ''),
(28, 'Tata', 'Mosul, Iraq', 0, '', '20000', NULL, NULL, 'gzgxg', 2, 4, '230', '', '320 speed', '6', '', 'Mosul, Iraq', '', '', '1', 12, 0, 0, 'carlocal@gmail.com', '9865323652', 0, 1, '', ''),
(29, 'Tata', 'Kurdistan, Erbil, Iraq', 0, '20000', '', NULL, NULL, 'dggdgd', 1, 4, '552525', '', 'Auto', '7', '', 'Kurdistan, Erbil, Iraq', '', '', '1', 12, 0, 0, 'carlocal@gmail.com', '9865323652', 0, 1, '', ''),
(30, 'Tata', 'Kurdistan, Erbil, Iraq', 0, '', '20000', NULL, NULL, 'gdgdg', 2, 4, '200', '', '3 tear ac', '7', '', 'Kurdistan, Erbil, Iraq', '', '', '1', 12, 0, 0, 'carlocal@gmail.com', '9865323652', 0, 1, '', ''),
(31, 'Ford', 'Mosul, Iraq', 0, '', '200000', NULL, NULL, 'good condition', 2, 5, '30000', '', '3 tear ac', '9', '', 'Mosul, Iraq', '', '', '1', 12, 0, 0, 'carlocal@gmail.com', '9865323652', 0, 1, '', ''),
(32, 'Mahindra', 'Mosul, Iraq', 0, '2000000', '2000000', NULL, NULL, 'good dafsd', 1, 3, '22322222', '', 'Tubeless', '8', '', 'Mosul, Iraq', '', '', '1', 12, 0, 0, 'carlocal@gmail.com', '9865323652', 0, 0, '', ''),
(33, 'new add car', 'test', 18, '4567', '345', NULL, NULL, 'test', 2, 4, '456', '19-09-1999', '3', '2', '3', 'Iraq', '33.223191', '43.679291000000035', '3', 0, 0, 28, 'kinnari@gmail.com', '7894561320', 0, 1, '', 'Manual'),
(34, 'Tata', 'Mosul, Iraq', 0, '', '2000', NULL, NULL, 'dhhdh', 2, 4, '20000', '', '320 speed', '9', '', 'Mosul, Iraq', '', '', '1', 12, 0, 0, 'carlocal@gmail.com', '9865323652', 0, 1, '', ''),
(35, 'Ford', 'Mosul, Iraq', 0, '', '20000', NULL, NULL, 'good', 2, 5, '2000', '', '3 tear ac', '7', '', 'Mosul, Iraq', '', '', '1', 12, 0, 0, 'carlocal@gmail.com', '9865323652', 0, 1, '', ''),
(36, 'Ford', 'Mosul, Iraq', 0, '', '20000', NULL, NULL, 'dhhdg', 2, 5, '2000', '', '320 speed', '7', '', 'Mosul, Iraq', '', '', '1', 12, 0, 0, 'carlocal@gmail.com', '9865323652', 0, 1, '', ''),
(37, 'Tata', 'Kurdistan, Erbil, Iraq', 0, '200000', '', NULL, NULL, 'fdfsfs', 1, 4, '23535', '', '320 speed', '8', '', 'Kurdistan, Erbil, Iraq', '', '', '1', 12, 0, 0, 'carlocal@gmail.com', '9865323652', 0, 1, '', ''),
(38, 'Tata', 'Kurdistan, Erbil, Iraq', 0, '', '2000000', NULL, NULL, 'dhhdgd', 2, 4, '20000', '', '320 speed', '8', '', 'Kurdistan, Erbil, Iraq', '', '', '1', 12, 0, 0, 'carlocal@gmail.com', '9865323652', 0, 1, '', ''),
(39, 'test harmiskj', 'nahrunagar', 10, '4567', '345', NULL, NULL, 'test', 2, 4, '456', '19-09-1999', 'trtrt', '6', '', 'iraq', '33.223191', '43.679291000000035', '3', 2, 0, 29, 'kinnari@gmail.com', '784561231230', 0, 1, '', ''),
(40, 'Ford', 'Mosul, Iraq', 0, '20000', '20000', NULL, NULL, 'hgdg', 2, 5, '5000000', '', 'Heavy Body', '18', '', 'Mosul, Iraq', '', '', '1', 12, 0, 0, 'carlocal@gmail.com', '9865323652', 0, 0, '', ''),
(41, 'new', '4224', 19, '242424242', '2424242', NULL, NULL, '24', 2, 3, '1500', '1205', '2', '2', '1', 'Iraq', '33.223191', '43.679291000000035', '3', 0, 0, 28, 'caifgigfr@gmail.com', '9632587410', 0, 1, '', 'Automatic'),
(42, 'Ford', 'Kurdistan, Erbil, Iraq', 0, '', '200000', NULL, NULL, 'vxvxg', 2, 5, '5000', '', '320 speed', '1', '', 'Kurdistan, Erbil, Iraq', '', '', '1', 16, 0, 0, 'carloc@gmail.com', '9898989898', 1, 1, '', ''),
(43, 'testst', 'testtt', 19, '4567', '345', NULL, NULL, 'teeeee', 2, 11, '4545', '2019', '2', '2', '2', 'Iraq', '33.223191', '43.679291000000035', '3', 0, 0, 28, 'card@gmail.com', '784561231230', 0, 1, '', ''),
(44, 'new property', 'tsanbvuii', 13, '4567', '30000', 500, 5000, 'sanvi car', 2, 3, '456', '2019', '2', '', '2', 'Iraq - Dubai - United Arab Emirates', '25.2275086', '55.171734300000026', '3', 0, 0, 28, 'test@gmail.com', '7894561320', 0, 1, '', 'Automatic'),
(45, 'new add car', '87987', 17, '4567', '4513', NULL, NULL, 'testt', 0, 5, '456', '2015', '4', '4', '3', 'Iraqi Museum, Baghdad, Iraq', '33.3284501', '44.385909800000036', '2', 0, 25, 0, 'kinnari@gmail.com', '9789', 0, 1, '', 'Automatic'),
(46, 'BMW', 'Iraq', 17, '200000', '', NULL, NULL, 'cncnnc', 1, 24, '50000', '', '4', '13', '2', 'Iraq', '', '', '1', 12, 0, 0, 'carlocal@gmail.com', '9865323652', 0, 0, '', 'Manual'),
(47, 'Maruti-Suzuki', 'Mosul, Iraq', 10, '20000', '', NULL, NULL, 'gghh', 1, 2, '2323', '', '3', '1', '3', 'Mosul, Iraq', '', '', '1', 12, 0, 0, 'carlocal@gmail.com', '9865323652', 1, 1, 'https://www.youtube.com/embed/IyETom5jxDc', 'Automatic'),
(48, 'mahindra XUV300', 'chfghghfghfsghfsgh', 11, '4500000', '', NULL, NULL, 'ghghsgdfhdfgh', 1, 3, '50000', '2019', '2', '5', '2', 'iraq', '', '', '1', 2, 0, 0, 'prakash@gmail.com', '789456123', 0, 1, 'https://www.youtube.com/watch?v=22zDVWH9cgM', 'Automatic'),
(49, 'tigor', 'fsgsgs', 14, '45000000', '', NULL, NULL, 'grgfsgsg', 1, 4, '45000', '2016', '2', '13', '2', 'Iraq - Dubai - United Arab Emirates', '25.2275086', '55.171734300000026', '1', 2, 0, 0, 'prakash@gmail.com', '789456123', 0, 1, 'https://www.youtube.com/watch?v=epJqtMGk4Jk', 'Manual'),
(50, 'audi mix', '', 12, '230000', '230000', NULL, NULL, 'test', 2, 4, '2013', '2013', '2', '10', '3', 'India', '20.593684', '78.96288000000004', '1', 17, 0, 0, 'hp1@hmail.com', '6599999991', 0, 2, 'https://www.youtube.com/watch?v=tQ0mzXRk-oM', 'Manual'),
(51, 'Endevour', '', 12, '360000', '', NULL, NULL, 'psum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of', 1, 5, '25000', '2016', '5', '16', '1', 'India', '20.593684', '78.96288000000004', '1', 17, 0, 0, 'hitesh@gmail.com', '9866788891', 0, 1, 'https://www.youtube.com/watch?v=Tp6Xu6i7sLg', 'Manual'),
(54, 'verna 1.6', '', 13, '780000', '', NULL, NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containin', 1, 4, '26000', '2016', '3', '10', '2', 'India', '20.593684', '78.96288000000004', '1', 17, 0, 0, 'hp@hmail.com', '9834523331', 0, 1, 'https://www.youtube.com/watch?v=uJ8a8-i1cqE', 'Manual'),
(55, 'Premier', 'Mosul, Iraq', 10, '2009', '', NULL, NULL, 'very good condition of this car', 1, 46, '20000', '', '1', '1', '1', 'Mosul, Iraq', '', '', '1', 19, 0, 0, 'testuser@gmail.com', '9865326598', 0, 1, '', ''),
(56, 'Khataro', 'america', 13, '10', '0', 0, 0, 'first Number Car', 1, 3, '30', '1.5', '3', '2', '3', 'america', '', '', '1', 2, 0, 0, 'sandeep@harmistechnology.com', '78787878787', 0, 1, 'http://192.168.1.25/cars/admin/property/56/edit', 'Manual'),
(57, 'Khataro', 'B 304/2,harmis technology,\r\nGopal palace jhansi ki rani BRTS bus stop,\r\nnear siromani complex', 11, '0', '1000000', 1000, 10000, 'hiiii', 2, 4, '50', '1.5', '3', '4', '3', 'fffff', '', '', '1', 1, 0, 0, 'car@gmail.com', '78755555', 0, 1, 'https://www.youtube.com/watch?v=NtzftGb0EcM', 'Automatic'),
(58, 'sandip', '', 11, NULL, '50000', NULL, NULL, 'all place', 2, 4, '2220', '1.5', '2', '11', '2', 'All Places Map, Pocket 4, Sector 25, Rohini, New Delhi, Delhi, India', '28.7358489', '77.09602999999993', '1', 15, 0, 0, 'car@gmail.com', '78755555', 0, 1, 'https://www.youtube.com/watch?v=NtzftGb0EcM', 'Manual'),
(59, 'new car', '', 15, '4500000', NULL, NULL, NULL, 'fhgdhfghjj', 1, 4, '5000000', '2016', '2', '10', '3', 'Al Qa\'im, Iraq', '34.316858', '41.16025969999998', '1', 4, 0, 0, 'prakash@gmail.com', '7894561232', 0, 1, '', 'Manual'),
(60, 'Audi', 'Mosul, Iraq', 10, '2019', NULL, NULL, NULL, 'good description', 1, 21, '20000', '', '5', '18', '2', 'Mosul, Iraq', '', '', '1', 21, 0, 0, 'carlive@gmail.com', '9898986532', 0, 1, '', ''),
(61, 'Ashok Leyland', 'Mosul, iraq', 10, '2015', NULL, NULL, NULL, 'shhdgd', 1, 12, '2000', '', '2', '8', '2', 'Mosul, iraq', '', '', '1', 14, 0, 0, 'carlive@gmail.com', '9865323652', 0, 1, 'fdgfdgdf', ''),
(62, 'Ashok Leyland', 'Mosul, iraq', 10, '2015', NULL, NULL, NULL, 'shhdgd', 1, 12, '2000', '', '2', '8', '2', 'Mosul, iraq', '', '', '1', 14, 0, 0, 'carlive@gmail.com', '9865323652', 0, 1, '', ''),
(63, 'audi mix', 'zsczxc', 13, '', '345', 13000, 200, 'xzcxzc', 1, 3, '2013', '2016', '1', '6', '3', 'India', '20.593684', '78.96288000000004', '2', 0, 28, 0, 'car@gmail.com', '9789', 0, 1, '435', 'Manual'),
(64, 'audi mix', 'jkjk', 10, 'dsf', '0', 0, 0, 'lkl', 2, 3, '2013', '2013', '2', '6', '2', 'India', '20.593684', '78.96288000000004', '3', 0, 28, 28, 'car@gmail.com', '9789', 0, 1, '', 'Manual'),
(66, 'cfxg', '5465454564556t5', 15, '', '', 0, 0, 'dfgfdg', 1, 4, '546', '2016', '3', '12', '1', 'India', '20.593684', '78.96288000000004', '2', 0, 45, 0, 'hitesh@gmail.com', '9789', 0, 1, '', 'Automatic');

-- --------------------------------------------------------

--
-- Table structure for table `property_category`
--

CREATE TABLE `property_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ar` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ku` varchar(255) CHARACTER SET utf8 NOT NULL,
  `car_brand_id` int(11) NOT NULL,
  `published` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `property_category`
--

INSERT INTO `property_category` (`id`, `name`, `ar`, `ku`, `car_brand_id`, `published`) VALUES
(1, 'Maruti Swift', 'ماروتي سويفت', 'ماروتی سوئفٹ۔', 2, 1),
(2, 'Maruti Wagon R', '', '', 2, 1),
(3, 'Maruti Vitara Brezza', '', '', 2, 1),
(4, 'Maruti Dzire', '', '', 2, 1),
(5, 'Mahindra XUV300', '', '', 3, 1),
(6, 'Mahindra Scorpio', '', '', 3, 1),
(7, 'Mahindra XUV500', '', '', 3, 1),
(8, 'Mahindra Thar', '', '', 3, 1),
(9, 'Mahindra Bolero', '', '', 3, 1),
(10, 'Tata Tiago NRG', 'ghg', 'fjhj', 4, 1),
(11, 'Tata Tiago', 'ماروتي سوزوكي', 'Beşa Navxwe', 4, 1),
(12, 'Tata Tiago JTP', '', '', 4, 1),
(13, 'Tata Tigor JTP', '', '', 4, 1),
(14, 'Ford EcoSport', '', '', 5, 1),
(15, 'Ford Freestyle', '', '', 5, 1),
(16, 'Ford Endeavour', '', '', 5, 1),
(17, 'Ford Figo', '', '', 5, 1),
(18, 'Volvo', '', '', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `property_img`
--

CREATE TABLE `property_img` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `img_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `property_img`
--

INSERT INTO `property_img` (`id`, `property_id`, `img_name`) VALUES
(1, 1, '1564481212.8602019-maruti_swift.jpg'),
(2, 2, '1564481277.scorpio.jpeg'),
(3, 3, '1564555733.scorpio.jpeg'),
(25, 7, '1564564838.8602019-maruti_swift.jpg'),
(26, 4, '1564642089.scorpio.jpeg'),
(27, 5, '1564996050.8602019-maruti_swift.jpg'),
(28, 6, '1564996158.8602019-maruti_swift.jpg'),
(41, 13, '1565682293.download.jpeg'),
(42, 14, '1565700651.download-(1).jpeg'),
(43, 16, '1566540734.ic_bus.png'),
(44, 1, '1566541533.bicycle5.jpeg'),
(46, 17, '1566544011.bicycle5.jpeg'),
(47, 18, '1566557357.download.jpeg'),
(48, 19, '1566907805.McLaren.jpg'),
(49, 19, '1566907805.bugati.jpg'),
(50, 20, '1566907959.bugati.jpg'),
(51, 20, '1566907959.download.jpg'),
(52, 20, '1566907959.images.jpg'),
(58, 22, '1568268731.images-(3).jpeg'),
(59, 22, '1568268731.mclaren-mso-600lt-coupe.jpg'),
(60, 22, '1568268731.images-(2).jpeg'),
(63, 23, '1568272815.images-(3).jpeg'),
(64, 23, '1568272815.images-(2).jpeg'),
(65, 23, '1568272816.images.jpeg'),
(66, 24, '1568273052.images-(1).jpeg'),
(67, 25, '1568273443.images.jpeg'),
(68, 26, '1568273739.images-(3).jpeg'),
(69, 27, '1568274494.images-(3).jpeg'),
(70, 28, '1568275013.images-(3).jpeg'),
(71, 29, '1568275131.1568271759366.jpg'),
(72, 30, '1568275204.1568195406431.jpg'),
(73, 31, '1568365245.mclaren-mso-600lt-coupe.jpg'),
(74, 32, '1568368431.images-(2).jpeg'),
(75, 32, '1568368644.images.jpeg'),
(76, 31, '1568368666.images.jpeg'),
(77, 33, '1568368796.maruti-suzuki-baleno.jpg'),
(78, 34, '1568368827.1568196952203.jpg'),
(79, 35, '1568368972.images-(3).jpeg'),
(80, 36, '1568369081.images-(2).jpeg'),
(81, 37, '1568369217.images-(1).jpeg'),
(82, 36, '1568369439.images-(2).jpeg'),
(83, 38, '1568369621.images-(2).jpeg'),
(84, 39, '1568445582.home-2-about.png'),
(85, 40, '1568459475.images-(2).jpeg'),
(86, 40, '1568459592.images.jpeg'),
(87, 21, '1568460274.home-2-about.png'),
(88, 41, '1568614958.camera5.jpeg'),
(89, 41, '1568614959.speaker2.jpg'),
(90, 42, '1568627368.IMG-20190806-WA0001.jpg'),
(91, 42, '1568627661.IMG-20190809-WA0000.jpg'),
(92, 43, '1568721582.maruti-suzuki-baleno.jpg'),
(93, 44, '1568722288.home-2-about.png'),
(94, 45, '1568792375.photo-1514316703755-dca7d7d9d882.jpeg'),
(95, 45, '1568792375.photo-1511919884226-fd3cad34687c.jpeg'),
(96, 46, '1568798848.mclaren-mso-600lt-coupe.jpg'),
(97, 47, '1568801558.mclaren-mso-600lt-coupe.jpg'),
(98, 48, '1568874331.download.jpg'),
(111, 51, '1568981835.en1.jpg'),
(112, 51, '1568981835.en2.jpg'),
(113, 51, '1568981835.en3.jpg'),
(149, 54, '1569056190.vn1.png'),
(153, 50, '1569056657.bz3.jpg'),
(154, 50, '1569056657.bz4.jpg'),
(155, 55, '1569234160.mclaren-mso-600lt-coupe.jpg'),
(156, 56, '1569317924.user6.jpeg'),
(157, 57, '1569318925.wallet7.jpeg'),
(158, 47, '1569320681.images-(2).jpeg'),
(159, 58, '1569329290.wallet7.jpeg'),
(161, 59, '1569386935.maruti-suzuki-baleno.jpg'),
(162, 59, '1569386935.photo-1511919884226-fd3cad34687c.jpeg'),
(163, 59, '1569386935.photo-1514316703755-dca7d7d9d882.jpeg'),
(206, 54, '1569402411.vn2.jpg'),
(207, 54, '1569402411.vn3.jpg'),
(226, 58, '1569407150.android.png'),
(238, 58, '1569408003.bottle3.jpg'),
(239, 60, '1569480925.mclaren-mso-600lt-coupe.jpg'),
(240, 60, '1569480925.images-(2).jpeg'),
(241, 61, '1569490225.home-2-about.png'),
(242, 62, '1569491857.home-2-about.png'),
(243, 63, '1569577875.bm2.jpg'),
(244, 64, '1569579424.bm3.jpg'),
(246, 66, '1569583654.bm3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `property_types`
--

CREATE TABLE `property_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ar` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ku` varchar(255) CHARACTER SET utf8 NOT NULL,
  `published` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `property_types`
--

INSERT INTO `property_types` (`id`, `name`, `ar`, `ku`, `published`) VALUES
(1, 'For Buy & Sale', 'للبيع والبيع', 'خرید و فروخت کے لئے۔', 1),
(2, 'For Rent', 'للإيجار', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pro_feature`
--

CREATE TABLE `pro_feature` (
  `id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pro_feature`
--

INSERT INTO `pro_feature` (`id`, `pro_id`, `feature_id`) VALUES
(128, 0, 2),
(129, 0, 3),
(490, 187, 1),
(491, 187, 2),
(492, 187, 3),
(493, 187, 4),
(494, 187, 5),
(495, 187, 6),
(496, 187, 7),
(497, 187, 8),
(498, 187, 9),
(499, 187, 10),
(880, 57, 1),
(881, 57, 2),
(882, 57, 3),
(883, 57, 4),
(884, 57, 5),
(885, 57, 6),
(886, 57, 7),
(887, 57, 8),
(888, 57, 9),
(889, 57, 10);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `secure_secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `online_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `access_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `merchantTxnref` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `merchantId` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setting_payment`
--

CREATE TABLE `setting_payment` (
  `id` int(11) NOT NULL,
  `stripe_key` longtext NOT NULL,
  `published_key` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting_payment`
--

INSERT INTO `setting_payment` (`id`, `stripe_key`, `published_key`) VALUES
(1, 'sk_test_qKFL1d1wFqDp4DaVlL6gZzzr00eHSfRz5K', 'pk_test_zQm8B5ZcNuC0zdNyOdRxT5bt00mUd7EHk8');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_address`
--

CREATE TABLE `shipping_address` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shipping_address`
--

INSERT INTO `shipping_address` (`id`, `fname`, `lname`, `company`, `address`, `email`, `phone`) VALUES
(1, 'test', 'test', 'test', 'test', 'test@gmail.comn', '9632587410'),
(2, 'ggdsg', 'dsgdsg', 'gsdg', 'gdsgsgsd', 'gdsgd', 'gsdgsd'),
(3, 'bfbhfd', 'hfdhd', 'hdh', 'hdfhd', 'hdfhd', 'dfh'),
(4, 'bfbhfd', 'hfdhd', 'hdh', 'hdfhd', 'hdfhd', 'dfh'),
(5, 'gsgds', 'ggsdg', 'sdgd', 'gsdg', 'dsgsd', 'gdsgd'),
(6, 'dfsaf', 'fsfasf', 'fsaf', 'faf', 'faf', 'fasfa'),
(7, 'dfda', 'fasfsaf', 'fsa', 'fsafaf', 'fsafs', 'fas'),
(8, 'fasdfsaf', 'safaf', 'afa', 'fsaff', 'afsafa', 'ffafa'),
(9, 'wew', 'v', 'vdfa', 'fasfaf', 'asfaf', 'afas'),
(10, 'dsgsg', 'gsd', 'gdsgsg', 'sgsg', 'sgsg', 'sgs'),
(11, 'dfh', 'hshs', 'hsh', 'sh', 'hsdfh', 'shs'),
(12, 'hdfh', 'hsh', 'shshs', 'hsh', 'hdshs', 'ghsgsg'),
(13, 'fd', 'fdf', 'd', 'fd', 'fd', 'fd'),
(14, 'tw', 'twe', 'tewtwt', 'twt', 'wetew', 't'),
(15, 'gdsg', 'gg', 'gsg', 'gsg', 'gsg', 'gsgs'),
(16, 'dfh', 'hshs', 'hsh', 'sh', 'hsdfh', 'shs'),
(17, 'GFDSG', 'DAGADGA', 'GDSGD', 'GADGA', 'GAGA', 'GA'),
(18, 'vdzg', 'fgsa', 'afaf', 'fasf', 'test@gmail.com', 'afas'),
(19, 'rewr', 'fasfa', 'fasf', 'fasfsa', 'fasfa@hotmail.com', 'fasfasf');

-- --------------------------------------------------------

--
-- Table structure for table `showroom_city`
--

CREATE TABLE `showroom_city` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `showroom_city`
--

INSERT INTO `showroom_city` (`id`, `admin_id`, `city_id`) VALUES
(1, 30, 11),
(2, 30, 12),
(3, 30, 14),
(4, 30, 11),
(5, 30, 12),
(6, 30, 13),
(7, 45, 12),
(8, 45, 14),
(9, 44, 12),
(10, 44, 14),
(11, 44, 15),
(12, 1, 11),
(13, 1, 13),
(14, 1, 11),
(15, 1, 13),
(16, 44, 12),
(17, 44, 14),
(18, 44, 15),
(19, 44, 12),
(20, 44, 14),
(21, 44, 15),
(22, 1, 11),
(23, 1, 13),
(24, 1, 15),
(25, 45, 11),
(26, 45, 12),
(27, 45, 14),
(28, 1, 11),
(29, 1, 12),
(30, 1, 13),
(31, 1, 15);

-- --------------------------------------------------------

--
-- Table structure for table `specification`
--

CREATE TABLE `specification` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ar` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ku` varchar(255) CHARACTER SET utf8 NOT NULL,
  `published` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `specification`
--

INSERT INTO `specification` (`id`, `name`, `ar`, `ku`, `published`) VALUES
(1, 'Auto', 'Auto', 'Auto', 1),
(2, '3 tear ac', '3 tear ac', '3 tear ac', 1),
(3, '320 speed', '320 السرعة', '320 رفتار۔', 1),
(4, 'Tubeless', 'Tubeless', 'Tubeless', 1),
(5, 'Heavy Body', 'Heavy Body', 'Heavy Body', 1);

-- --------------------------------------------------------

--
-- Table structure for table `store_city`
--

CREATE TABLE `store_city` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_city`
--

INSERT INTO `store_city` (`id`, `admin_id`, `city_id`) VALUES
(1, 44, 11),
(2, 44, 12),
(3, 44, 14);

-- --------------------------------------------------------

--
-- Table structure for table `top_property`
--

CREATE TABLE `top_property` (
  `id` int(11) NOT NULL,
  `propertyId` int(11) NOT NULL,
  `fromdate` date NOT NULL,
  `todate` date NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `top_property`
--

INSERT INTO `top_property` (`id`, `propertyId`, `fromdate`, `todate`, `date`) VALUES
(1, 2, '2019-08-09', '2019-08-22', '2019-09-25 12:18:49');

-- --------------------------------------------------------

--
-- Table structure for table `upload_id`
--

CREATE TABLE `upload_id` (
  `id` int(11) NOT NULL,
  `c_agentId` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `upload_id`
--

INSERT INTO `upload_id` (`id`, `c_agentId`, `image`) VALUES
(15, 9, '1566207496.Maruti-Suzuki-Baleno-Right-Front-Three-Quarter-147420.jpg'),
(16, 10, '1566207937.Maruti-Suzuki-Baleno-Right-Front-Three-Quarter-147420.jpg'),
(17, 11, '1566207998.Maruti-Suzuki-Baleno-Right-Front-Three-Quarter-147420.jpg'),
(18, 13, '1568617782.bugati.jpg'),
(19, 13, '1568617782.download.jpg'),
(20, 13, '1568617782.images.jpg'),
(21, 14, '1568625395.IMG-20190916-WA0011.jpg'),
(22, 15, '1568625578.test.png'),
(23, 16, '1568625797.IMG-20190916-WA0011.jpg'),
(24, 17, '1568625812.test.png'),
(25, 20, '1568626193.test.png'),
(26, 22, '1568626312.IMG-20190916-WA0011.jpg'),
(27, 23, '1568627251.IMG-20190807-WA0001.jpg'),
(28, 26, '1568964650_0_wallet5.jpeg'),
(29, 26, '1568964650_1_wallet1.jpeg'),
(30, 26, '1568964650_2_user6.jpeg'),
(42, 30, '1568964932_2_user4.jpeg'),
(47, 36, '1568973017_0_speaker3.jpeg'),
(48, 36, '1568973017_1_speaker1.jpeg'),
(49, 37, '1568974695_0_wallet7.jpeg'),
(50, 37, '1568974696_1_user6.jpeg'),
(51, 37, '1568974696_2_user4.jpeg'),
(52, 37, '1568974696_3_user2.jpeg'),
(53, 38, '1568975101_0_wallet7.jpeg'),
(54, 38, '1568975101_1_wallet2.jpg'),
(55, 38, '1568975101_2_user7.jpeg'),
(56, 38, '1568975101_3_user6.jpeg'),
(57, 39, '1569059714.mclaren-mso-600lt-coupe.jpg'),
(58, 40, '1569483395.mclaren-mso-600lt-coupe.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `userdevicetoken`
--

CREATE TABLE `userdevicetoken` (
  `id` int(11) NOT NULL,
  `deviceType` tinyint(4) NOT NULL,
  `deviceToken` varchar(225) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usergroups`
--

CREATE TABLE `usergroups` (
  `id` int(11) NOT NULL,
  `typeName` varchar(255) NOT NULL,
  `parentGroup` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usergroups`
--

INSERT INTO `usergroups` (`id`, `typeName`, `parentGroup`) VALUES
(1, 'admin', 0),
(2, 'owner', 0),
(3, 'agent', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `gender` int(11) NOT NULL,
  `aged` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `lname`, `username`, `dob`, `gender`, `aged`, `email`, `password`, `phone`, `image`, `created_at`, `updated_at`, `address`) VALUES
(1, 'murat', 'patel', 'murat', '1994-07-07', 1, 0, 'murat@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9632587410', '1564557880.silhouette-car-with-key-auto-car-logo-png_33231.jpg', '2019-08-02 11:13:23', '2019-07-25 01:36:50', 'nehrunagar,ahmedabad,gujarat'),
(2, 'prakash', 's', 'prakash', '1995-08-01', 1, 0, 'testing@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '1564046714.user6.jpeg', '2019-07-31 06:25:59', '2019-07-25 02:06:04', 'jasodanagar'),
(3, 'Bella', 'g', 'Bella', '0000-00-00', 1, 0, 'bella@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', '2019-09-11 13:23:07', '2019-07-25 02:06:04', ''),
(4, 'kavya', 't', 'kavya', '2019-07-15', 2, 0, 'kavya@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '1568633638.bottle1.jpeg', '2019-09-16 11:34:02', '2019-09-16 06:04:02', 'navshari'),
(5, 'test1', '', 'test1', '0000-00-00', 0, 0, 'test1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', '2019-07-29 07:03:04', NULL, ''),
(6, 'demo', 'demo l', 'demo', '2019-07-30', 1, 0, 'demo@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '1564465854.23703JD_01_1553616680.jpg', '2019-07-30 05:50:54', '2019-07-30 00:20:54', 'sdfgsfg'),
(7, 'dfh', 'dfh', 'dgfh', '2019-08-23', 1, 1, 'sdf@gmail.com', '202cb962ac59075b964b07152d234b70', '', '', '2019-08-07 05:25:05', '2019-08-06 23:54:29', 'sfgdfgh'),
(8, 'p', 's', 'ps', '2019-08-27', 1, 0, 'prakash@gmail.com', '3db20af828d7bbfb0b0b6043dea3b24c', '', '', '2019-08-13 05:03:18', '2019-08-12 23:33:18', 'dsgs'),
(9, 'Amit', 'zala', 'Amit', '1996-08-28', 0, 0, 'amit@gmail.com', 'e35cf7b66449df565f93c607d5a81d09', '9724604987', '1566983061.Screenshot_2019-08-27-08-54-21-69_dac7cc7571c39b392df64923967cf7da.png', '2019-08-28 09:08:37', NULL, 'Mosul, Iraq'),
(10, 'dolly', 'patel', 'dolly', '1994-08-26', 0, 0, 'dolly@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9898989898', '1567052677.Screenshot_2019-08-27-08-54-21-69_dac7cc7571c39b392df64923967cf7da.png', '2019-08-29 04:24:37', NULL, 'Iraq'),
(11, 'piyu', 'zala', 'piyu', '0000-00-00', 0, 0, 'piyu@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '1534567893', '1566470544.pfour.jpg', '2019-08-22 10:42:24', NULL, 'Kurdistan, Erbil, Iraq'),
(12, 'carlocal', 'olpoo', 'carlocal', '2002-09-12', 0, 0, 'carlocal@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9865323652', '1568267137.IMG-20190904-WA0007.jpg', '2019-09-20 06:12:17', NULL, 'Mosul, Iraq'),
(13, '', '', 'komal', '0000-00-00', 0, 0, 'komal@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', '2019-09-12 05:58:42', '2019-09-12 05:58:42', ''),
(14, '', '', 'Kinjal', '0000-00-00', 0, 0, 'kinjal@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', '2019-09-12 06:19:28', '2019-09-12 06:19:28', ''),
(15, 'sandip', 'dalvadi', 'sandip', '1999-07-03', 1, 0, 'sandeep@harmistechnology.com', 'e10adc3949ba59abbe56e057f20f883e', '78755555', '', '2019-09-25 09:24:41', '2019-09-25 03:54:41', 'B 304/2,harmis technology,, Gopal palace jhansi ki rani BRTS bus stop,, near siromani complex'),
(16, 'carloc', 'patel', 'carloc', '2008-09-16', 0, 0, 'carloc@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9898989898', '', '2019-09-16 09:46:09', NULL, 'Iraq'),
(17, 'Hitesh', 'devaiya', 'hitesh', '1997-08-02', 1, 0, 'hitesh@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9523695263', '1569214716.male.jpeg', '2019-09-23 04:59:57', '2019-09-22 23:29:57', ''),
(18, '', '', 'urvi', '0000-00-00', 0, 0, 'urvi@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '1568889511.user2.jpeg', '2019-09-19 10:38:31', '2019-09-19 04:10:10', ''),
(19, 'testuser', 'zzzz', 'testuser', '1994-09-23', 0, 0, 'testuser@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9865326598', '', '2019-09-23 10:20:13', NULL, 'Baghdad, Iraq'),
(20, '', '', 'hardik', '0000-00-00', 0, 0, 'harmistechnology@gmail.com', '4ef3c0949f24bc5f2d2f1bac8f2d3454', '', '', '2019-09-24 00:08:29', '2019-09-24 00:08:29', ''),
(21, 'carlive', 'ssss', 'carlive', '1994-09-26', 0, 0, 'carlive@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9898653265', '1569480975.images.jpeg', '2019-09-26 06:56:15', NULL, 'Mosul, Iraq'),
(22, '', '', 'jay', '0000-00-00', 0, 0, 'jay@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', '2019-09-26 07:26:57', '2019-09-26 07:26:57', ''),
(23, '', '', 'ravi', '0000-00-00', 0, 0, 'ravi@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', '2019-09-26 07:27:42', '2019-09-26 07:27:42', '');

-- --------------------------------------------------------

--
-- Table structure for table `zones`
--

CREATE TABLE `zones` (
  `zone_id` int(11) NOT NULL,
  `zone_country_id` int(11) NOT NULL,
  `zone_code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `zone_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `zones`
--

INSERT INTO `zones` (`zone_id`, `zone_country_id`, `zone_code`, `zone_name`) VALUES
(1, 223, 'AL', 'Alabama'),
(2, 223, 'AK', 'Alaska'),
(3, 223, 'AS', 'American Samoa'),
(4, 223, 'AZ', 'Arizona'),
(5, 223, 'AR', 'Arkansas'),
(6, 223, 'AF', 'Armed Forces Africa'),
(7, 223, 'AA', 'Armed Forces Americas'),
(8, 223, 'AC', 'Armed Forces Canada'),
(9, 223, 'AE', 'Armed Forces Europe'),
(10, 223, 'AM', 'Armed Forces Middle East'),
(11, 223, 'AP', 'Armed Forces Pacific'),
(12, 223, 'CA', 'California'),
(13, 223, 'CO', 'Colorado'),
(14, 223, 'CT', 'Connecticut'),
(15, 223, 'DE', 'Delaware'),
(16, 223, 'DC', 'District of Columbia'),
(17, 223, 'FM', 'Federated States Of Micronesia'),
(18, 223, 'FL', 'Florida'),
(19, 223, 'GA', 'Georgia'),
(20, 223, 'GU', 'Guam'),
(21, 223, 'HI', 'Hawaii'),
(22, 223, 'ID', 'Idaho'),
(23, 223, 'IL', 'Illinois'),
(24, 223, 'IN', 'Indiana'),
(25, 223, 'IA', 'Iowa'),
(26, 223, 'KS', 'Kansas'),
(27, 223, 'KY', 'Kentucky'),
(28, 223, 'LA', 'Louisiana'),
(29, 223, 'ME', 'Maine'),
(30, 223, 'MH', 'Marshall Islands'),
(31, 223, 'MD', 'Maryland'),
(32, 223, 'MA', 'Massachusetts'),
(33, 223, 'MI', 'Michigan'),
(34, 223, 'MN', 'Minnesota'),
(35, 223, 'MS', 'Mississippi'),
(36, 223, 'MO', 'Missouri'),
(37, 223, 'MT', 'Montana'),
(38, 223, 'NE', 'Nebraska'),
(39, 223, 'NV', 'Nevada'),
(40, 223, 'NH', 'New Hampshire'),
(41, 223, 'NJ', 'New Jersey'),
(42, 223, 'NM', 'New Mexico'),
(43, 223, 'NY', 'New York'),
(44, 223, 'NC', 'North Carolina'),
(45, 223, 'ND', 'North Dakota'),
(46, 223, 'MP', 'Northern Mariana Islands'),
(47, 223, 'OH', 'Ohio'),
(48, 223, 'OK', 'Oklahoma'),
(49, 223, 'OR', 'Oregon'),
(50, 223, 'PW', 'Palau'),
(51, 223, 'PA', 'Pennsylvania'),
(52, 223, 'PR', 'Puerto Rico'),
(53, 223, 'RI', 'Rhode Island'),
(54, 223, 'SC', 'South Carolina'),
(55, 223, 'SD', 'South Dakota'),
(56, 223, 'TN', 'Tennessee'),
(57, 223, 'TX', 'Texas'),
(58, 223, 'UT', 'Utah'),
(59, 223, 'VT', 'Vermont'),
(60, 223, 'VI', 'Virgin Islands'),
(61, 223, 'VA', 'Virginia'),
(62, 223, 'WA', 'Washington'),
(63, 223, 'WV', 'West Virginia'),
(64, 223, 'WI', 'Wisconsin'),
(65, 223, 'WY', 'Wyoming'),
(66, 38, 'AB', 'Alberta'),
(67, 38, 'BC', 'British Columbia'),
(68, 38, 'MB', 'Manitoba'),
(69, 38, 'NF', 'Newfoundland'),
(70, 38, 'NB', 'New Brunswick'),
(71, 38, 'NS', 'Nova Scotia'),
(72, 38, 'NT', 'Northwest Territories'),
(73, 38, 'NU', 'Nunavut'),
(74, 38, 'ON', 'Ontario'),
(75, 38, 'PE', 'Prince Edward Island'),
(76, 38, 'QC', 'Quebec'),
(77, 38, 'SK', 'Saskatchewan'),
(78, 38, 'YT', 'Yukon Territory'),
(79, 81, 'NDS', 'Niedersachsen'),
(80, 81, 'BAW', 'Baden-Württemberg'),
(81, 81, 'BAY', 'Bayern'),
(82, 81, 'BER', 'Berlin'),
(83, 81, 'BRG', 'Brandenburg'),
(84, 81, 'BRE', 'Bremen'),
(85, 81, 'HAM', 'Hamburg'),
(86, 81, 'HES', 'Hessen'),
(87, 81, 'MEC', 'Mecklenburg-Vorpommern'),
(88, 81, 'NRW', 'Nordrhein-Westfalen'),
(89, 81, 'RHE', 'Rheinland-Pfalz'),
(90, 81, 'SAR', 'Saarland'),
(91, 81, 'SAS', 'Sachsen'),
(92, 81, 'SAC', 'Sachsen-Anhalt'),
(93, 81, 'SCN', 'Schleswig-Holstein'),
(94, 81, 'THE', 'Thüringen'),
(95, 14, 'WI', 'Wien'),
(96, 14, 'NO', 'Niederösterreich'),
(97, 14, 'OO', 'Oberösterreich'),
(98, 14, 'SB', 'Salzburg'),
(99, 14, 'KN', 'Kärnten'),
(100, 14, 'ST', 'Steiermark'),
(101, 14, 'TI', 'Tirol'),
(102, 14, 'BL', 'Burgenland'),
(103, 14, 'VB', 'Voralberg'),
(104, 204, 'AG', 'Aargau'),
(105, 204, 'AI', 'Appenzell Innerrhoden'),
(106, 204, 'AR', 'Appenzell Ausserrhoden'),
(107, 204, 'BE', 'Bern'),
(108, 204, 'BL', 'Basel-Landschaft'),
(109, 204, 'BS', 'Basel-Stadt'),
(110, 204, 'FR', 'Freiburg'),
(111, 204, 'GE', 'Genf'),
(112, 204, 'GL', 'Glarus'),
(113, 204, 'JU', 'Graubünden'),
(114, 204, 'JU', 'Jura'),
(115, 204, 'LU', 'Luzern'),
(116, 204, 'NE', 'Neuenburg'),
(117, 204, 'NW', 'Nidwalden'),
(118, 204, 'OW', 'Obwalden'),
(119, 204, 'SG', 'St. Gallen'),
(120, 204, 'SH', 'Schaffhausen'),
(121, 204, 'SO', 'Solothurn'),
(122, 204, 'SZ', 'Schwyz'),
(123, 204, 'TG', 'Thurgau'),
(124, 204, 'TI', 'Tessin'),
(125, 204, 'UR', 'Uri'),
(126, 204, 'VD', 'Waadt'),
(127, 204, 'VS', 'Wallis'),
(128, 204, 'ZG', 'Zug'),
(129, 204, 'ZH', 'Zürich'),
(130, 195, 'A Coruña', 'A Coruña'),
(131, 195, 'Alava', 'Alava'),
(132, 195, 'Albacete', 'Albacete'),
(133, 195, 'Alicante', 'Alicante'),
(134, 195, 'Almeria', 'Almeria'),
(135, 195, 'Asturias', 'Asturias'),
(136, 195, 'Avila', 'Avila'),
(137, 195, 'Badajoz', 'Badajoz'),
(138, 195, 'Baleares', 'Baleares'),
(139, 195, 'Barcelona', 'Barcelona'),
(140, 195, 'Burgos', 'Burgos'),
(141, 195, 'Caceres', 'Caceres'),
(142, 195, 'Cadiz', 'Cadiz'),
(143, 195, 'Cantabria', 'Cantabria'),
(144, 195, 'Castellon', 'Castellon'),
(145, 195, 'Ceuta', 'Ceuta'),
(146, 195, 'Ciudad Real', 'Ciudad Real'),
(147, 195, 'Cordoba', 'Cordoba'),
(148, 195, 'Cuenca', 'Cuenca'),
(149, 195, 'Girona', 'Girona'),
(150, 195, 'Granada', 'Granada'),
(151, 195, 'Guadalajara', 'Guadalajara'),
(152, 195, 'Guipuzcoa', 'Guipuzcoa'),
(153, 195, 'Huelva', 'Huelva'),
(154, 195, 'Huesca', 'Huesca'),
(155, 195, 'Jaen', 'Jaen'),
(156, 195, 'La Rioja', 'La Rioja'),
(157, 195, 'Las Palmas', 'Las Palmas'),
(158, 195, 'Leon', 'Leon'),
(159, 195, 'Lleida', 'Lleida'),
(160, 195, 'Lugo', 'Lugo'),
(161, 195, 'Madrid', 'Madrid'),
(162, 195, 'Malaga', 'Malaga'),
(163, 195, 'Melilla', 'Melilla'),
(164, 195, 'Murcia', 'Murcia'),
(165, 195, 'Navarra', 'Navarra'),
(166, 195, 'Ourense', 'Ourense'),
(167, 195, 'Palencia', 'Palencia'),
(168, 195, 'Pontevedra', 'Pontevedra'),
(169, 195, 'Salamanca', 'Salamanca'),
(170, 195, 'Santa Cruz de Tenerife', 'Santa Cruz de Tenerife'),
(171, 195, 'Segovia', 'Segovia'),
(172, 195, 'Sevilla', 'Sevilla'),
(173, 195, 'Soria', 'Soria'),
(174, 195, 'Tarragona', 'Tarragona'),
(175, 195, 'Teruel', 'Teruel'),
(176, 195, 'Toledo', 'Toledo'),
(177, 195, 'Valencia', 'Valencia'),
(178, 195, 'Valladolid', 'Valladolid'),
(179, 195, 'Vizcaya', 'Vizcaya'),
(180, 195, 'Zamora', 'Zamora'),
(181, 195, 'Zaragoza', 'Zaragoza'),
(182, 99, 'GJ', 'Gujarat'),
(183, 99, 'MH', 'Mharashtra');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aboutus`
--
ALTER TABLE `aboutus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`myid`),
  ADD UNIQUE KEY `administrators_email_unique` (`email`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car_accessories`
--
ALTER TABLE `car_accessories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car_accessories_img`
--
ALTER TABLE `car_accessories_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car_brand`
--
ALTER TABLE `car_brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_admin`
--
ALTER TABLE `contact_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_agent`
--
ALTER TABLE `contact_agent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`countries_id`);

--
-- Indexes for table `driverLicense`
--
ALTER TABLE `driverLicense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fueltype`
--
ALTER TABLE `fueltype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `get_touch`
--
ALTER TABLE `get_touch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homeslide`
--
ALTER TABLE `homeslide`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`Order_ID`);

--
-- Indexes for table `paymentGatway`
--
ALTER TABLE `paymentGatway`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pdf_report`
--
ALTER TABLE `pdf_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Place_Order`
--
ALTER TABLE `Place_Order`
  ADD PRIMARY KEY (`Place_Order_ID`);

--
-- Indexes for table `procategory`
--
ALTER TABLE `procategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_category`
--
ALTER TABLE `property_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_img`
--
ALTER TABLE `property_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_types`
--
ALTER TABLE `property_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pro_feature`
--
ALTER TABLE `pro_feature`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_payment`
--
ALTER TABLE `setting_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_address`
--
ALTER TABLE `shipping_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `showroom_city`
--
ALTER TABLE `showroom_city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specification`
--
ALTER TABLE `specification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_city`
--
ALTER TABLE `store_city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `top_property`
--
ALTER TABLE `top_property`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upload_id`
--
ALTER TABLE `upload_id`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userdevicetoken`
--
ALTER TABLE `userdevicetoken`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usergroups`
--
ALTER TABLE `usergroups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`zone_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aboutus`
--
ALTER TABLE `aboutus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `myid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `car_accessories`
--
ALTER TABLE `car_accessories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `car_accessories_img`
--
ALTER TABLE `car_accessories_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `car_brand`
--
ALTER TABLE `car_brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `contact_admin`
--
ALTER TABLE `contact_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `contact_agent`
--
ALTER TABLE `contact_agent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `countries_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;
--
-- AUTO_INCREMENT for table `driverLicense`
--
ALTER TABLE `driverLicense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `fueltype`
--
ALTER TABLE `fueltype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `get_touch`
--
ALTER TABLE `get_touch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `homeslide`
--
ALTER TABLE `homeslide`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `Order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `paymentGatway`
--
ALTER TABLE `paymentGatway`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `pdf_report`
--
ALTER TABLE `pdf_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Place_Order`
--
ALTER TABLE `Place_Order`
  MODIFY `Place_Order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `procategory`
--
ALTER TABLE `procategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT for table `property_category`
--
ALTER TABLE `property_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `property_img`
--
ALTER TABLE `property_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;
--
-- AUTO_INCREMENT for table `property_types`
--
ALTER TABLE `property_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pro_feature`
--
ALTER TABLE `pro_feature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=890;
--
-- AUTO_INCREMENT for table `setting_payment`
--
ALTER TABLE `setting_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `shipping_address`
--
ALTER TABLE `shipping_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `showroom_city`
--
ALTER TABLE `showroom_city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `specification`
--
ALTER TABLE `specification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `store_city`
--
ALTER TABLE `store_city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `top_property`
--
ALTER TABLE `top_property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `upload_id`
--
ALTER TABLE `upload_id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `userdevicetoken`
--
ALTER TABLE `userdevicetoken`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usergroups`
--
ALTER TABLE `usergroups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `zones`
--
ALTER TABLE `zones`
  MODIFY `zone_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

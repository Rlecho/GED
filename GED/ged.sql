-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2023 at 06:19 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ged`
--

-- --------------------------------------------------------

--
-- Table structure for table `ged_categories`
--

CREATE TABLE `ged_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `refer` varchar(250) NOT NULL,
  `author` varchar(250) NOT NULL,
  `role` int(250) NOT NULL,
  `date_arrivee` date DEFAULT NULL,
  `id_files` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ged_categories`
--

INSERT INTO `ged_categories` (`id`, `name`, `description`, `refer`, `author`, `role`, `date_arrivee`, `id_files`, `id_tag`) VALUES
(49, 'bv', 'bvg', 'bb', 'bb', 2, '2023-07-06', 0, 0),
(48, 'cb', 'cd', '2', 'Sergevv', 5, '2023-07-07', 0, 0),
(46, 'fer', 'bgy', 'doo_2', 'Serge', 1, '2023-06-06', 0, 0),
(47, 'cc', 'cd', '1', 'Serge', 2, '2023-07-07', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ged_doss_as_tags`
--

CREATE TABLE `ged_doss_as_tags` (
  `id` int(11) NOT NULL,
  `dossi_id` int(11) NOT NULL,
  `tags_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ged_files`
--

CREATE TABLE `ged_files` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `nameView` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `url` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `author` varchar(255) DEFAULT NULL,
  `size` int(11) NOT NULL DEFAULT 0,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `version` varchar(255) NOT NULL,
  `metaData` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ged_files`
--

INSERT INTO `ged_files` (`id`, `name`, `nameView`, `type`, `date`, `url`, `path`, `category_id`, `author`, `size`, `description`, `keywords`, `version`, `metaData`) VALUES
(120, '007-chapitre1.pdf', '007-chapitre1.pdf', 'application/pdf', '2023-07-10 14:49:44', 'http://localhost/GED/folderRoot/007-chapitre1.pdf', 'C:\\xampp\\htdocs\\GED\\folderRoot\\007-chapitre1.pdf', 48, NULL, 0, '', '', '', ''),
(122, 'ffffff.docx', 'ffffff.docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', '2023-07-10 14:50:49', 'http://localhost/GED/folderRoot/ffffff.docx', 'C:\\xampp\\htdocs\\GED\\folderRoot\\ffffff.docx', 46, NULL, 0, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ged_files_as_tags`
--

CREATE TABLE `ged_files_as_tags` (
  `id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `doss_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ged_informations`
--

CREATE TABLE `ged_informations` (
  `id` int(11) NOT NULL,
  `ged_name` varchar(255) NOT NULL,
  `ged_coment` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ged_informations`
--

INSERT INTO `ged_informations` (`id`, `ged_name`, `ged_coment`) VALUES
(1, 'SJKP', 'Ici avec Lookiou');

-- --------------------------------------------------------

--
-- Table structure for table `ged_tags`
--

CREATE TABLE `ged_tags` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ged_tags`
--

INSERT INTO `ged_tags` (`id`, `name`, `description`) VALUES
(46, 'ff', 'n'),
(47, 'v', 'b');

-- --------------------------------------------------------

--
-- Table structure for table `ged_trash`
--

CREATE TABLE `ged_trash` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ged_users`
--

CREATE TABLE `ged_users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(60) NOT NULL,
  `right_read` int(11) DEFAULT 0,
  `right_up` int(11) NOT NULL DEFAULT 0,
  `right_admin` int(11) NOT NULL DEFAULT 0,
  `token` varchar(255) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ged_users`
--

INSERT INTO `ged_users` (`id`, `login`, `password`, `username`, `right_read`, `right_up`, `right_admin`, `token`, `role_id`) VALUES
(98, '', '09d7154825af89fc52c5f060cf7b5020f60d051b', 'admin', 0, 0, 0, '277e57a0cbe7a59c26f36e0a6e1889fe751571dd', 0),
(96, 'b', 'e9d71f5ee7c92d6dc9e92ffdad17b8bd49418f98', 'b', 0, 0, 0, '4cf6eabd72fda323b6f4e8ca7d029faa7ea21e3b_CREATE', 0),
(97, 'c', '84a516841ba77a5b4648de2cd0dfcb30ea46dbb4', 'c', 0, 0, 0, 'b8fcafe3658c5da95bfbd2ff554f271b6cb2cf31_CREATE', 0),
(99, 'x', '11f6ad8ec52a2984abaafd7c3b516503785c2072', 'x', 1, 1, 1, '93858967611fb51a69cbc924d01c384f18ccfc69_CREATE', 0),
(72, 'serges', 'c9ddb6c25a8f77bd31ba26bb8332c4e1aa2c6778', 'serge', 1, 1, 1, 'c62f842ef1ce84ed818998e25accac7148e0289b_CREATE', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ged_user_roles`
--

CREATE TABLE `ged_user_roles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ged_user_roles`
--

INSERT INTO `ged_user_roles` (`id`, `user_id`, `role_id`) VALUES
(80, 97, 1),
(81, 97, 2),
(82, 97, 3),
(79, 96, 2),
(78, 96, 1),
(77, 95, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'DBA'),
(3, 'agent'),
(4, 'Compta'),
(5, 'DNSI'),
(6, 'A'),
(7, 'B'),
(8, 'C'),
(9, 'D'),
(10, 'E'),
(11, 'F'),
(12, 'G'),
(13, 'H'),
(14, 'I'),
(15, 'J'),
(16, 'K'),
(17, 'A'),
(18, 'B'),
(19, 'C'),
(20, 'D'),
(21, 'E'),
(22, 'F'),
(23, 'G'),
(24, 'H'),
(25, 'I'),
(26, 'J'),
(27, 'K');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ged_categories`
--
ALTER TABLE `ged_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `refer` (`refer`),
  ADD KEY `cads` (`id_files`),
  ADD KEY `nom_contrainte` (`role`),
  ADD KEY `id_tag` (`id_tag`);

--
-- Indexes for table `ged_doss_as_tags`
--
ALTER TABLE `ged_doss_as_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ged_files`
--
ALTER TABLE `ged_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `ged_files_as_tags`
--
ALTER TABLE `ged_files_as_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ged_informations`
--
ALTER TABLE `ged_informations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ged_tags`
--
ALTER TABLE `ged_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ged_trash`
--
ALTER TABLE `ged_trash`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ged_users`
--
ALTER TABLE `ged_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `ged_user_roles`
--
ALTER TABLE `ged_user_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ged_categories`
--
ALTER TABLE `ged_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `ged_doss_as_tags`
--
ALTER TABLE `ged_doss_as_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `ged_files`
--
ALTER TABLE `ged_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `ged_files_as_tags`
--
ALTER TABLE `ged_files_as_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `ged_informations`
--
ALTER TABLE `ged_informations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ged_tags`
--
ALTER TABLE `ged_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `ged_trash`
--
ALTER TABLE `ged_trash`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `ged_users`
--
ALTER TABLE `ged_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `ged_user_roles`
--
ALTER TABLE `ged_user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

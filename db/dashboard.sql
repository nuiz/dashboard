-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2015 at 01:19 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dashboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `facebook_page`
--

CREATE TABLE IF NOT EXISTS `facebook_page` (
  `facebook_page_id` varchar(255) NOT NULL,
  `access_token` varchar(255) NOT NULL,
  `expire_token` int(11) NOT NULL,
  `facebook_user_id` varchar(255) NOT NULL,
  `facebook_page_name` varchar(255) NOT NULL,
  PRIMARY KEY (`facebook_page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `facebook_page`
--

INSERT INTO `facebook_page` (`facebook_page_id`, `access_token`, `expire_token`, `facebook_user_id`, `facebook_page_name`) VALUES
('123071314565399', 'CAAFd70Qisn0BAJpmlmZAh3aMRKe9kg3QthIntThE0JYYJmJ3CFDI9k4CU54rQCqCE1HjIxTs63Mqnk3jloSc5wbjpnN9qhZBrJHhjXirFpBVkOSXLq60B6SrTrhfojCNFWTApdYq5L8zbnmmvLQQcovIbK6MWTvvfDNdH1vb0WM8vj2ix5', 0, '1097750773585844', 'ร้านดวงดาว'),
('380089075352518', 'CAAFd70Qisn0BABZBIZBoP5tPbsdOgxNLfTuD1mZAfl81pjuimIZAWHbOWCe9bQu9DqjIhspySZBiyg4DhJlfShMmLZCRUkSK0sqs9GIFPZB4fdW8v6PpHmueR9A2Ai61V5OuisM0ineeOOqP10ZBOegUmX7gI9UTrf2ap6MrkMZCClDM0ZAr3AO8RlZCWX0gNZCjn38ZD', 0, '1097750773585844', 'กากสัส');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

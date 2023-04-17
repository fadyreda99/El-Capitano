-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2021 at 03:37 AM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gradproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `Car_ID` int(11) NOT NULL,
  `Car_Type` varchar(255) NOT NULL COMMENT 'no3 l 3rbya',
  `Car_Color` varchar(255) NOT NULL,
  `Car_Number` varchar(255) NOT NULL COMMENT 'rkmel 3rbya',
  `Car_Characters` varchar(255) NOT NULL,
  `License_Car_ID` varchar(255) NOT NULL COMMENT 'rkm ro5st l 3rbya',
  `End_Date_License` varchar(255) NOT NULL COMMENT 'tare5 entha2 elro5sa',
  `User_id` int(11) NOT NULL,
  `CatID` int(11) NOT NULL,
  `Car_Images` varchar(255) NOT NULL,
  `Reg_Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`Car_ID`, `Car_Type`, `Car_Color`, `Car_Number`, `Car_Characters`, `License_Car_ID`, `End_Date_License`, `User_id`, `CatID`, `Car_Images`, `Reg_Date`) VALUES
(52, 'golf3', 'green', '222', 'fff', '11111111111112', '2021-04-20', 73, 2, '5993729727827885.jfif,7266497455981720.jfif,7105598847219970.jfif', '2021-04-14 20:15:50'),
(53, 'byd ', 'green', '999', 'hhh', '22222222222222', '2021-05-04', 74, 5, '9029252648159702.png,6910720971131072.jpg', '2021-04-14 20:18:17'),
(54, 'bmw x3', 'black', '663', 'hbj', '33333333333333', '2021-04-19', 75, 4, '6090050072187432.jpg', '2021-04-14 20:20:02'),
(55, 'mazda 6', 'green', '321', 'hag', '44444444444444', '2021-04-05', 76, 6, '5411207043062057.jpg', '2021-04-14 20:22:36'),
(57, 'golf 5', 'green', '852', 'gdh', '66666666666666', '2021-04-11', 78, 2, '7065825364407737.jpg', '2021-04-14 20:27:51'),
(58, 'golf 4 ', 'green', '846', 'hdb', '77777777777777', '2021-04-01', 79, 2, '7984619416762757.jfif,8950529597767700.jfif,6815538077926859.jfif', '2021-04-14 20:29:32'),
(59, 'byd', 'blue', '963', 'hnb', '88888888888888', '2021-04-08', 80, 5, '8790652455027731.jfif,2316306060120941.jfif,9209826864864110.jfif', '2021-04-14 20:31:14'),
(60, 'mazda 3', 'green', '539', 'jbh', '99999999999999', '2023-09-12', 81, 6, '3736863239631526.jfif,348471194415517.jfif,8197826982792383.jfif', '2021-04-14 20:33:27'),
(61, 'golf 5', 'blue', '842', 'jvb', '99999966666633', '2021-04-12', 82, 2, '7489512394395196.jpg', '2021-04-14 20:34:55'),
(62, 'golf2', 'green', '523', 'uhj', '77777744444411', '2021-04-07', 84, 2, '4067920557666674.jpg', '2021-04-14 20:44:45'),
(63, 'golf', 'green', '222', 'UUU', '99966611177744', '2021-05-03', 90, 2, '7026772408994427.jpg,8085896442765341.jpg', '2021-05-04 15:24:18');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Category_ID` int(11) NOT NULL,
  `Category_Name` varchar(255) NOT NULL,
  `Rag_Date_Cat` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'date and time when category added'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Category_ID`, `Category_Name`, `Rag_Date_Cat`) VALUES
(2, 'Goolf', '2021-02-08 11:40:49'),
(4, 'bmw', '2021-02-08 13:39:26'),
(5, 'BYD', '2021-04-14 20:11:53'),
(6, 'Mazda', '2021-04-14 20:12:22'),
(7, 'kia', '2021-04-15 09:59:03');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `Chat_ID` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `driverid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`Chat_ID`, `userid`, `driverid`) VALUES
(6, 89, 77),
(7, 89, 78),
(8, 89, 82),
(13, 92, 78),
(14, 93, 74),
(15, 93, 90),
(16, 92, 73),
(17, 93, 73);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `Message_ID` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Mobile` varchar(255) NOT NULL,
  `Subject` varchar(255) NOT NULL,
  `Message` text NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`Message_ID`, `Email`, `Mobile`, `Subject`, `Message`, `Date`, `userid`) VALUES
(9, 'bisho@gmail.com', '01212442330', 'change car', 'i want to stop this car because i bought a new car', '2021-04-15 10:13:36', 73),
(10, 'omar@gmail.com', '01212442330', 'change information', 'i want to change information or delete this account and make another account ', '2021-06-22 19:10:12', 93),
(11, 'omar@gmail.com', '01212442330', 'i want to delete this account', 'i want to delete this account so what should i do', '2021-06-22 19:11:35', 93);

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `Driver_ID` int(11) NOT NULL,
  `First_Name` varchar(255) NOT NULL,
  `Last_Name` varchar(255) NOT NULL,
  `Mobile` varchar(255) NOT NULL,
  `Age` int(11) NOT NULL,
  `Country` varchar(255) NOT NULL,
  `National_ID` varchar(255) NOT NULL COMMENT 'rkm l bta2a',
  `License_ID` varchar(255) NOT NULL,
  `Driver_Image` varchar(255) NOT NULL,
  `Reg_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`Driver_ID`, `First_Name`, `Last_Name`, `Mobile`, `Age`, `Country`, `National_ID`, `License_ID`, `Driver_Image`, `Reg_Date`, `UserID`) VALUES
(46, 'bishoy', 'raafat', '01212442330', 21, 'cairo', '11111111111112', '11111111111112', '9867432869_image.jfif', '2021-04-14 20:14:25', 73),
(47, 'mohamed', 'ahmed', '01212442031', 35, 'giza', '22222222222222', '22222222222222', '1773329105_image.jfif', '2021-04-14 20:17:47', 74),
(48, 'ahmed', 'mohamed', '01212442332', 55, 'cairo', '33333333333333', '33333333333333', '3535249473_image.jfif', '2021-04-14 20:19:31', 75),
(49, 'mohsen', 'gmal', '01212442333', 24, 'giza', '44444444444444', '44444444444444', '2025436066_image.jfif', '2021-04-14 20:22:08', 76),
(51, 'kerollos', 'osama', '01212442335', 28, 'cairo', '66666666666666', '66666666666666', '2606730_image.jfif', '2021-04-14 20:27:28', 78),
(52, 'saad ', 'sameh', '01212442336', 29, 'giza', '77777777777777', '77777777777777', '8370692850_image.jfif', '2021-04-14 20:29:05', 79),
(53, 'kareem', 'ahmed', '01212442337', 55, 'giza', '88888888888888', '88888888888888', '1054511268_image.jfif', '2021-04-14 20:30:51', 80),
(54, 'abanoub', 'simon', '01212442338', 21, 'cairo', '99999999999999', '99999999999999', '4444429083_image.jfif', '2021-04-14 20:32:51', 81),
(55, 'amir', 'ahmed', '01212442339', 25, 'cairo', '99999966666633', '99999966666633', '9709401289_image.jfif', '2021-04-14 20:34:34', 82),
(56, 'ahmed', 'ahmed', '01212442310', 21, 'cairo', '77777744444411', '77777744444411', '5735232195_image.jfif', '2021-04-14 20:44:12', 84),
(57, 'samuel', 'yousef', '01212445987', 22, 'cairo', '99966611177744', '99966611177744', '9052769022_image.jfif', '2021-05-04 15:23:48', 90);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `Feedback_ID` int(11) NOT NULL,
  `Rating` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `DriverID` int(11) NOT NULL,
  `TripID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`Feedback_ID`, `Rating`, `UserID`, `DriverID`, `TripID`) VALUES
(77, 5, 85, 74, 15),
(78, 4, 85, 82, 20),
(79, 5, 85, 82, 20),
(80, 4, 86, 75, 25),
(81, 5, 93, 74, 26),
(82, 4, 92, 73, 28),
(83, 5, 93, 90, 29);

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `Membership_ID` int(11) NOT NULL,
  `Start_Date_Of_Membership` varchar(255) NOT NULL,
  `End_Date_Of_Membership` varchar(255) NOT NULL,
  `Cost_Of_Membership` varchar(255) NOT NULL,
  `DriverID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`Membership_ID`, `Start_Date_Of_Membership`, `End_Date_Of_Membership`, `Cost_Of_Membership`, `DriverID`) VALUES
(1, '2021-06-10', '2021-06-30', '100', 57),
(2, '2021-06-09', '2021-06-30', '200', 46),
(3, '2021-06-27', '2021-06-30', '100', 47),
(4, '2021-06-25', '2021-06-12', '100', 48),
(5, '2021-06-15', '2021-06-19', '100', 51),
(6, '2021-06-11', '2021-06-23', '100', 52),
(7, '2021-06-01', '2021-06-07', '100', 49);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `Message_ID` int(11) NOT NULL,
  `income_message_id` int(11) NOT NULL,
  `outing_message_id` int(11) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `Chat_ID` int(11) NOT NULL,
  `Time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`Message_ID`, `income_message_id`, `outing_message_id`, `message`, `Chat_ID`, `Time`) VALUES
(50, 77, 89, 'sa', 6, '2021-04-28 11:19:42'),
(51, 77, 89, 'test', 6, '2021-04-28 11:19:42'),
(52, 77, 89, 'gsajn', 6, '2021-04-28 11:19:42'),
(53, 89, 77, 'hsaj', 6, '2021-04-28 11:19:42'),
(54, 89, 77, 'tsgsh', 6, '2021-04-28 11:19:42'),
(55, 89, 77, 'nxbmcb', 6, '2021-04-28 11:19:42'),
(56, 78, 89, 'dasdas', 7, '2021-04-28 11:19:42'),
(57, 78, 89, 'asdasd', 7, '2021-04-28 11:19:42'),
(58, 82, 89, 'dasdasd.', 8, '2021-04-28 11:19:42'),
(59, 82, 89, 'dsaasd', 8, '2021-04-28 11:19:42'),
(60, 77, 89, 'asasas', 6, '2021-04-28 11:20:02'),
(61, 77, 89, 'asdasd', 6, '2021-04-28 11:20:03'),
(62, 78, 89, 'sasAS', 7, '2021-04-28 11:20:19'),
(63, 77, 89, 'sa', 6, '2021-04-28 11:25:24'),
(64, 89, 77, 'test', 6, '2021-04-28 14:49:00'),
(75, 78, 92, 'tests', 13, '2021-05-28 15:38:13'),
(76, 78, 92, 'hi', 13, '2021-05-28 15:38:14'),
(79, 74, 93, 'Ù„Ùˆ Ø³Ù…Ø­Øª ', 14, '2021-06-18 22:22:11'),
(80, 74, 93, 'ÙƒÙ†Øª Ø¹Ø§ÙŠØ² Ø§Ø±ÙˆØ­ Ù…Ù† Ø´Ø¨Ø±Ø§ Ø§Ù„Ù‰ Ø§Ù„Ø§Ø³ÙƒÙ†Ø¯Ø±ÙŠØ© ÙŠÙˆÙ… 22 ', 14, '2021-06-18 22:22:43'),
(81, 74, 93, 'Ø§Ù„Ø³Ø§Ø¹Ø© 7 Ø§Ù„ØµØ¨Ø­ ', 14, '2021-06-18 22:22:58'),
(82, 74, 93, 'Ù‡ØªØªÙƒÙ„Ù ÙƒØ§Ù…', 14, '2021-06-18 22:23:09'),
(83, 93, 74, 'Ø§Ù‡Ù„Ø§ Ø¨Ø­Ø¶Ø±ØªÙƒ', 14, '2021-06-18 22:24:47'),
(84, 93, 74, 'ØªÙ…Ø§Ù… Ù…ØªØ§Ø­ ', 14, '2021-06-18 22:24:53'),
(85, 93, 74, 'Ø­Ø¶Ø±ØªÙƒ ÙÙŠÙ† ÙÙ‰ Ø´Ø¨Ø±Ø§ Ùˆ Ù‡ØªØ±ÙˆØ­ ÙÙŠÙ† ÙÙ‰ Ø§Ù„Ø§Ø³ÙƒÙ†Ø¯Ø±ÙŠØ©', 14, '2021-06-18 22:26:08'),
(86, 74, 93, 'Ù…Ù† Ø¯ÙˆØ±Ø§Ù† Ø´Ø¨Ø±Ø§ Ùˆ Ù‡Ø±ÙˆØ­ Ù…Ø­Ø·Ø© Ø§Ù„Ø±Ù…Ù„ ', 14, '2021-06-18 22:28:00'),
(87, 93, 74, 'ÙƒØ§Ù… ÙØ±Ø¯', 14, '2021-06-18 22:28:11'),
(88, 74, 93, 'Ø§Ù†Ø§ Ùˆ 3 ØªØ§Ù†Ù‰ ', 14, '2021-06-18 22:28:39'),
(89, 93, 74, 'ØªÙ…Ø§Ù… ÙƒØ¯Ø© Ù‡ØªØªÙƒÙ„Ù 350 Ø¬Ù†ÙŠØ© ', 14, '2021-06-18 22:29:06'),
(90, 74, 93, 'ØªÙ…Ø§Ù… Ù…ÙÙŠØ´ Ù…Ø´ÙƒÙ„Ø© ', 14, '2021-06-18 22:29:16'),
(91, 93, 74, 'ØªÙ…Ø§Ù… Ù‡Ø³ØªØ£Ø°Ù† Ø­Ø¶Ø±ØªÙƒ ØªØ¯Ø®Ù„ Ø¹Ù„Ù‰ Ø§Ù„ØµÙØ­Ø© Ø¨ØªØ§Ø¹ØªÙ‰ Ùˆ ØªØ¹Ù…Ù„ Ø·Ù„Ø¨ Ø§Ù„Ø±Ø­Ù„Ø© Ùˆ ØªÙƒØªØ¨ Ø§Ù„Ø³Ø¹Ø±Ø§Ù„Ù„Ù‰ Ø§ØªÙÙ‚Ù†Ø§ Ø¹Ù„ÙŠØ© ', 14, '2021-06-18 22:30:20'),
(92, 74, 93, 'ØªÙ…Ø§Ù…', 14, '2021-06-18 22:30:28'),
(93, 74, 93, 'Ù…Ù…ÙƒÙ† Ø¨Ø³ Ø±Ù‚Ù… Ù…ÙˆØ¨ÙŠÙ„Ùƒ Ø¹Ù„Ø´Ø§Ù† Ø§ÙƒÙ„Ù…Ùƒ Ù‚Ø¨Ù„Ù‡Ø§ Ø¨ÙŠÙˆÙ… ', 14, '2021-06-18 22:30:52'),
(94, 93, 74, 'ØªÙ…Ø§Ù…', 14, '2021-06-18 22:30:56'),
(95, 93, 74, '01212442335', 14, '2021-06-18 22:31:01'),
(96, 74, 93, 'ØªÙ…Ø§Ù… Ø´ÙƒØ±Ø§', 14, '2021-06-18 22:31:10'),
(97, 90, 93, 'helo ', 15, '2021-06-22 15:56:26'),
(98, 73, 92, 'Ø¹Ø§ÙŠØ² Ø§Ø±ÙˆØ­ Ø§Ø³ÙƒÙ†Ø¯Ø±ÙŠØ©', 16, '2021-06-24 18:19:06'),
(99, 90, 93, 'Ù„Ùˆ Ø³Ù…Ø­Øª', 15, '2021-06-25 18:33:59'),
(100, 90, 93, 'hi', 15, '2021-06-26 17:46:34'),
(101, 93, 90, 'hello', 15, '2021-06-26 17:46:38'),
(102, 73, 93, 'Ù„Ùˆ Ø³Ù…Ø­Øª', 17, '2021-06-27 14:19:19'),
(103, 93, 73, 'Ø§ÙŠÙˆØ©', 17, '2021-06-27 14:19:26');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `Report_ID` int(11) NOT NULL,
  `Report_Maker_Name` varchar(255) NOT NULL,
  `Report_Maker_Email` varchar(255) NOT NULL,
  `Report_Maker_Mobile` varchar(255) NOT NULL,
  `Report_Receiver_Name` varchar(255) NOT NULL,
  `Reason` text NOT NULL,
  `Report_Maker_ID` int(11) NOT NULL,
  `Report_Receiver_ID` int(11) NOT NULL,
  `TripID` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`Report_ID`, `Report_Maker_Name`, `Report_Maker_Email`, `Report_Maker_Mobile`, `Report_Receiver_Name`, `Reason`, `Report_Maker_ID`, `Report_Receiver_ID`, `TripID`, `time`) VALUES
(2, 'fady reda', 'fady@gmail.com', '01212442330', 'mohamed ahmed', 'he late on me and talking with me with dirty way ', 85, 74, 14, '2021-06-09 18:33:05'),
(3, 'samuel yousef', 'saas@gmail.com', '01212442330', 'omar', 'canelled trip after i arrival to him', 90, 85, 13, '2021-06-09 18:48:58'),
(4, 'test test', 'test@gmail.com', '01212442330', 'omar', 'test test test test test ', 90, 85, 13, '2021-06-09 18:50:33'),
(5, 'omar ahmed', 'omar@gmail.com', '01212442330', 'test test ', 'he late on me and he speake by wrong way', 93, 74, 15, '2021-06-22 14:46:25'),
(6, 'omar ahmed', 'omar2@gmail.com', '01212442330', 'samue yousef', 'late on me and he drive very bad', 93, 90, 27, '2021-06-22 15:58:28'),
(7, 'ahmed seddawey', 'ahmed@gmail.com', '01212442330', 'bishoy', 'he is very late teeeeeeeeeeesttttttttttttttttt', 92, 73, 28, '2021-06-24 18:21:55'),
(8, 'omar ahmed ', 'omar@gmail.com', '01212442330', 'bishoy', 'tessssssssssst tesssssssssst tessssssst', 93, 74, 15, '2021-06-27 14:24:56');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `Trip_ID` int(11) NOT NULL,
  `Full_Name_User` varchar(255) NOT NULL,
  `Email_User` varchar(255) NOT NULL,
  `Phone_User` varchar(255) NOT NULL,
  `Driver_Name` varchar(255) NOT NULL,
  `Trip_Date` varchar(255) NOT NULL,
  `Trip_Day` varchar(255) NOT NULL,
  `From_Place` varchar(255) NOT NULL,
  `To_Place` varchar(255) NOT NULL,
  `Trip_Cost` varchar(255) NOT NULL,
  `DriverID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 0 COMMENT '0 = unfinished 1 = finished 2 = canceld'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`Trip_ID`, `Full_Name_User`, `Email_User`, `Phone_User`, `Driver_Name`, `Trip_Date`, `Trip_Day`, `From_Place`, `To_Place`, `Trip_Cost`, `DriverID`, `UserID`, `Status`) VALUES
(13, 'fady reda', 'fady@gmail.com', '01212442330', 'micheal reda', '2021-05-24', 'MonDay', 'shoubra misr', 'aleexx', '1000', 90, 93, 1),
(14, 'fady reda', 'f@f.com', '01212442330', 'micheal ', '2021-05-18', 'WednesDay', 'cairo', 'aleeex', '500', 74, 93, 2),
(15, 'test test', 't@g.com', '01212442330', 'tesssssttt', '2021-05-11', 'WednesDay', 'tessssst', 'tessssst', '300', 74, 93, 1),
(16, 'testtest', 't@g.com', '01212442330', 'micjheakm', '2021-05-29', 'ThursDay', 'ddddddd', 'ssssssssss', '200', 74, 93, 1),
(17, 'mina reda', 'mina@gmail.com', '01212442330', 'micheal reda', '2021-05-25', 'TuesDay', 'cairo', 'alex', '1000', 82, 93, 1),
(18, 'test yest', 't@g.com', '01212442330', 'test test ', '2021-05-22', 'TuesDay', 'test', 'test', '200', 82, 93, 2),
(19, 'test test ', 't@t.com', '01212442330', 'test test ', '2021-05-22', 'WednesDay', 'test', 'test', '200', 75, 93, 2),
(20, 'test yrtdt', 'y@g.com', '01212442330', 'test test', '2021-05-11', 'SaturDay', 'ewss', 'sadad', '200', 82, 93, 1),
(21, 'test test ', 't@t.com', '01212442330', 'resfbvcbvb', '2021-05-29', 'ThursDay', 'gjhgjg', 'hgfhgfhgf', '200', 82, 93, 1),
(22, 'teststyesb', 't@g.com', '01212442330', 'test test ', '2021-05-29', 'TuesDay', 'jhasgjdgaj', 'jhgjgjg', '200', 75, 93, 1),
(23, 'fdjggdjagjjg', 'h@h.com', '01212442330', 'dsadasdad', '2021-05-11', 'WednesDay', 'sadasd', 'dasdas', '200', 75, 93, 1),
(24, 'test test ', 't@gb.com', '01212442330', 'jhdgajsgj', '2021-05-19', 'WednesDay', 'sdadasd', 'dasda', '200', 84, 93, 2),
(25, 'abanoub', 'abanoub@gmail.com', '01212442330', 'ahmed', '2021-06-22', 'SaturDay', 'giza', 'alex', '500', 75, 86, 1),
(26, 'omar ahmed', 'omar@gmail.com', '01222443220', 'mohamed', '2021-06-22', 'TuesDay', 'shoubra egypt', 'alex', '350', 74, 93, 1),
(27, 'omar ahmed', 'omar@gmail.com', '01212442330', 'samuel yousef', '2021-06-30', 'TuesDay', 'shoubra', 'giza', '200', 90, 93, 1),
(28, 'ahmed seddawey', 'ahmed@gmail.com', '01212442330', 'bishoy', '2021-06-25', 'FriDay', 'shoubra', 'alex', '300', 73, 92, 1),
(29, 'omar ahmed ', 'omar@gmail.com', '01212442330', 'samuel yousef', '2021-07-08', 'TuesDay', 'cairo', 'alex', '300', 90, 93, 1),
(30, 'omar ahmed ', 'omar@gmail.com', '01212442330', 'bishoy', '2021-06-24', 'ThursDay', 'cairo', 'alex', '300', 73, 93, 0);

-- --------------------------------------------------------

--
-- Table structure for table `uprofiles`
--

CREATE TABLE `uprofiles` (
  `Profile_ID` int(11) NOT NULL,
  `First_Name` varchar(255) NOT NULL,
  `Last_Name` varchar(255) NOT NULL,
  `Mobile` varchar(255) NOT NULL,
  `Age` int(11) NOT NULL,
  `Country` varchar(255) NOT NULL,
  `Gender` int(11) NOT NULL COMMENT 'male = 1   female = 2',
  `User_Image` varchar(255) NOT NULL,
  `regStatus` timestamp NOT NULL DEFAULT current_timestamp(),
  `UID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uprofiles`
--

INSERT INTO `uprofiles` (`Profile_ID`, `First_Name`, `Last_Name`, `Mobile`, `Age`, `Country`, `Gender`, `User_Image`, `regStatus`, `UID`) VALUES
(8, 'abanoub', 'simon', '01204383556', 22, 'egypt', 1, '8522957385_image.jfif', '2021-04-15 10:19:53', 86),
(9, 'mrmr', 'mrmr', '01212448559', 22, 'cairo', 2, '9216488313_3.png', '2021-04-28 10:53:52', 89),
(10, 'omar', 'ahmed', '01224423300', 22, 'cairo', 1, '8111231958_image.jfif', '2021-06-18 22:21:15', 93),
(11, 'ahmed', 'seddawey', '01221559660', 25, 'cairo', 1, '570929553_image.jfif', '2021-06-24 18:16:01', 92);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` int(11) NOT NULL,
  `User_Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Group_ID` int(11) NOT NULL DEFAULT 0 COMMENT 'user = 0\r\ndriver = 1\r\nadmin = 2',
  `User_Status` int(11) NOT NULL DEFAULT 0 COMMENT 'active = 1\r\npending = 0',
  `Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `User_Name`, `Email`, `Password`, `Group_ID`, `User_Status`, `Date`) VALUES
(26, 'fady', 'fadyreda1212@gmail.com', '$2y$10$i3g6xPuWenYM/iEOAtEgcOEKU/152n2Ert7kUxnq3BtnaHkcqu/iW', 2, 1, '2021-02-23 16:02:10'),
(73, 'bishoy', 'bishoy@gmail.com', '$2y$10$aFhjTgs4ZaYcCgC043U7VOwiEiRygJjsV4ArNYDzYwHl8mPsUvepy', 1, 1, '2021-04-14 20:13:23'),
(74, 'mohamed3', 'mohamed@gmail.com', '$2y$10$4oq6asbxuHYajQt8JNUUOO6UtreLOcOvVwlmEhfExlDaxXtJC8hmq', 1, 1, '2021-04-14 20:16:42'),
(75, 'ahmed', 'ahmed@gmail.com', '$2y$10$AAXpD4XjNfSBHpL.xef0ye44FoSGIikTSeoR5DPMMhwzZ5gBw9YHW', 1, 1, '2021-04-14 20:18:48'),
(76, 'mohsen', 'mohsen@gmail.com', '$2y$10$u526r3pihC8dBbcSV8tmMOxD72x.QZviq.ulG4zYTXAl.DV3TgYKS', 1, 1, '2021-04-14 20:21:08'),
(78, 'kerollos', 'kerollos@gmail.com', '$2y$10$saQ/5B83PRy1sFk0eY5t/O.8ICkz3in8b9vse1iQd3CXmwsoPXBhq', 1, 1, '2021-04-14 20:26:31'),
(79, 'saad', 'saad@gmail.com', '$2y$10$ouvvlSRWlnfy04alxN41B.8ZiNfHO.GlkxySUUYIND78INQTDg.fq', 1, 0, '2021-04-14 20:28:24'),
(80, 'kareem', 'kareem@gmail.com', '$2y$10$KS/feuAouyPWJI6OGR5c2Ou6feM0J3.dlODiiz.4y9jn7QI2Q.yqu', 1, 0, '2021-04-14 20:30:06'),
(81, 'abanoub', 'abanoub@gmail.com', '$2y$10$5SMKXaqHHSrd2/kV7hWLxuUYmi7C/OWbmWcO7zUS4eQ/qoPR9rL5G', 1, 0, '2021-04-14 20:32:09'),
(82, 'amir', 'amir@gmail.com', '$2y$10$5tB8dwqXu536FvrcW55uWelTmjeSNWsSmB1bXy.ztIpnVhN.NyaRm', 1, 0, '2021-04-14 20:33:47'),
(84, 'ahmed2', 'ahmed2@gmail.com', '$2y$10$ZlftZBgrjUs9nQjEdtORv.M0LidtP0UNeS/7BsHPEa3P0wdJ48ek.', 1, 1, '2021-04-14 20:41:49'),
(86, 'abanoub simon', 'tamersimon55@gamil.com', '$2y$10$ZplV/WqGzoD9pHMInIaV7./0Hdr4jUHAOrR..eVFyc.gNGjrb4cYW', 0, 0, '2021-04-15 10:15:46'),
(87, 'test', 'test@gmail.com', '$2y$10$MznYU/6oq.Q/Nt4etVUMoOyFyj7pRtViPdvbEKU5j670mCL11MVjG', 0, 0, '2021-04-24 13:19:45'),
(88, 'testtest', 'testtest@gmail.com', '$2y$10$RC9aSQVtdNonN3YgwWVgyuKEPLFgqMxJIixn.12rfb0g0Nd.AYSYe', 1, 0, '2021-04-24 22:38:38'),
(89, 'mrmr', 'mrmr@gmail.com', '$2y$10$AzjwOdf8x0/7q/fRME5QduTU9zFNjL4U8NldozHbGbBxw9.00NxEG', 0, 0, '2021-04-28 10:53:14'),
(90, 'samuel', 'samuel2@gmail.com', '$2y$10$c.B07Oet8SkB4HATvmYjweKhHpkDCi2VquXkAnQRmw843Gkx1FNFq', 1, 1, '2021-05-04 15:22:53'),
(91, '3dma', '3dma@gmail.com', '$2y$10$ehMXZ.4vQHZH7tX5idS.CeaEA1EXjyzRu99iMeCg3J4/Hq4QJpXS.', 1, 0, '2021-05-24 16:52:21'),
(92, 'seddawey', 'seddawey@gmail.com', '$2y$10$KA8hLa.JNUzyzPfy1piKKOlTWM.6nXEdNGKH0L5Bag1m00UWK/fAi', 0, 0, '2021-05-28 15:30:53'),
(93, 'omar', 'omar@gmail.com', '$2y$10$1yMNTqAhLIniZTjWPu/3cew337bTCdAXNU/OGoe9wNj3qhPxhEPX.', 0, 0, '2021-06-18 22:12:04'),
(94, 'micheal123', 'micheal12@gmail.com', '$2y$10$VuDjgg/SRJFwl2/htg7cGeBQd2riXo0vfL8DRg.kpt4pYoq.1sM.C', 1, 0, '2021-06-18 22:14:35'),
(95, 'mina', 'mina@gmail.com', '$2y$10$GXnXx67GSBRID4xTS.HO4ejWJsUEf5i6F3uhEalmIQt35kDo6A23q', 1, 0, '2021-06-22 20:50:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`Car_ID`),
  ADD UNIQUE KEY `License_Car_ID` (`License_Car_ID`),
  ADD KEY `car_1` (`User_id`),
  ADD KEY `car_2` (`CatID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Category_ID`),
  ADD UNIQUE KEY `Category_Name` (`Category_Name`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`Chat_ID`),
  ADD KEY `chat_1` (`userid`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`Message_ID`),
  ADD KEY `contact_1` (`userid`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`Driver_ID`),
  ADD UNIQUE KEY `Mobile` (`Mobile`),
  ADD UNIQUE KEY `National_ID` (`National_ID`),
  ADD UNIQUE KEY `License_ID` (`License_ID`),
  ADD KEY `driver_1` (`UserID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`Feedback_ID`),
  ADD KEY `feed_1` (`TripID`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`Membership_ID`),
  ADD KEY `membership_1` (`DriverID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`Message_ID`),
  ADD KEY `message_1` (`Chat_ID`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`Report_ID`),
  ADD KEY `reprottrip_1` (`TripID`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`Trip_ID`),
  ADD KEY `trip_1` (`DriverID`);

--
-- Indexes for table `uprofiles`
--
ALTER TABLE `uprofiles`
  ADD PRIMARY KEY (`Profile_ID`),
  ADD UNIQUE KEY `Mobile` (`Mobile`),
  ADD KEY `profile_1` (`UID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `User_Name` (`User_Name`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `Car_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `Chat_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `Message_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `Driver_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `Feedback_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `Membership_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `Message_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `Report_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `Trip_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `uprofiles`
--
ALTER TABLE `uprofiles`
  MODIFY `Profile_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `car_1` FOREIGN KEY (`User_id`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `car_2` FOREIGN KEY (`CatID`) REFERENCES `categories` (`Category_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chat_1` FOREIGN KEY (`userid`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contact_1` FOREIGN KEY (`userid`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `drivers`
--
ALTER TABLE `drivers`
  ADD CONSTRAINT `driver_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feed_1` FOREIGN KEY (`TripID`) REFERENCES `trips` (`Trip_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `memberships`
--
ALTER TABLE `memberships`
  ADD CONSTRAINT `membership_1` FOREIGN KEY (`DriverID`) REFERENCES `drivers` (`Driver_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `message_1` FOREIGN KEY (`Chat_ID`) REFERENCES `chats` (`Chat_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reprottrip_1` FOREIGN KEY (`TripID`) REFERENCES `trips` (`Trip_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `trip_1` FOREIGN KEY (`DriverID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `uprofiles`
--
ALTER TABLE `uprofiles`
  ADD CONSTRAINT `profile_1` FOREIGN KEY (`UID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

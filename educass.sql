-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2024 at 05:47 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `educass`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminid` int(11) NOT NULL,
  `empid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminid`, `empid`, `username`) VALUES
(1, 1, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `announceid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announceid`, `title`, `details`, `date`) VALUES
(1, 'new educ ass updated', '                wala mema lang to\r\n\r\noo try lang            \r\nwith pic', '2024-08-30 11:52:23'),
(3, 'application extended', '        start of application is on aug 5, 2024\r\nend of app is until aug 10, 2024    \r\n\r\nkajajja', '2024-08-03 00:00:00'),
(9, 'due to typhoon payout will be moved to aug 20, 2027', 'please keep all you req\r\n\r\nreq are as follor:\r\n1 copy of grade\r\n1 copy of cor\r\n1 copy of id', '2024-08-03 10:11:32'),
(10, 'tanggalin ang message', 'hindi ko sya magets huhuhu\r\n😭😭😭😭', '2024-08-07 03:50:20'),
(12, 'good', 'all are working good', '2024-08-29 11:50:58'),
(13, 'employee', 'announcement', '2024-08-29 11:56:13'),
(14, 'staff announcement', 'checking', '2024-09-01 03:12:21'),
(15, 'payout will be moved on september 12', 'fggg', '2024-09-11 10:38:37'),
(16, 'malapit na  matapos', 'yehey, fighting!!\r\nemail nalang\r\n💙💙💙', '2024-09-21 12:19:04'),
(17, 'email', 'test', '2024-09-26 09:52:43'),
(18, 'new email acc', 'try', '2024-09-27 02:01:43'),
(19, 'email name ', 'cgururu', '2024-09-27 02:17:49'),
(20, 'separate email and insertion', 'almost done?', '2024-09-27 10:20:58'),
(21, 'staff email notif', 'try', '2024-09-28 10:16:45'),
(22, 'consultation', 'system consultation', '2024-10-01 09:39:25'),
(23, 'one more', 'hello\r\n\r\nhello, world!\r\nhello, Lord!\r\n', '2024-10-01 09:42:55'),
(29, 'again', 'hello\r\n\r\nhello, World!\r\n\r\nreporting\r\ncase study\r\nconsultation\r\nphilnits\r\ngroup activity', '2024-10-01 10:23:51'),
(30, 'hshahahas', 'bsssgsgs\r\njshsgdshhsd\r\nssjsdhsh', '2024-10-02 10:00:22'),
(31, 'gdggd', 'shdgshdgsh\r\n\r\njhdhsgdshd\r\n\r\nsjdhshdshd', '2024-10-02 10:02:19'),
(32, '12344ddd', 'hshsshshshs\r\nnshsb', '2024-10-02 10:06:22'),
(33, 'hhd', 'df', '2024-10-02 01:36:59'),
(34, 'hhjjkk', 'fghhjj', '2024-10-02 01:39:09'),
(35, 'hhjjkk', 'fghhjj', '2024-10-02 01:40:15'),
(36, 'to be fixed', 'ui color\r\nfont-size\r\nhosting', '2024-10-06 06:55:00'),
(37, 'batch sending', 'try muna', '2024-10-06 07:53:49'),
(38, 'staff announce', 'check if all email received email\r\nok', '2024-10-07 11:54:51'),
(39, 'email notif in staff is working', 'try on admin', '2024-10-07 12:01:47'),
(40, 'print using modal', 'staff and admin\r\nsoon sk and applicants', '2024-10-13 03:31:18'),
(41, 'alert(\"Hello!\\nWelcome to our site.\\nEnjoy your stay!\");', 'alert(\"Hello!\\nWelcome to our site.\\nEnjoy your stay!\");', '2024-10-19 06:59:56');

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `appid` int(11) NOT NULL,
  `studid` int(11) NOT NULL,
  `educid` int(11) NOT NULL,
  `reqid` int(11) NOT NULL,
  `courseid` int(11) NOT NULL,
  `parentsid` int(11) NOT NULL,
  `gradesid` int(11) NOT NULL,
  `appstatus` varchar(255) NOT NULL,
  `appremark` varchar(255) NOT NULL,
  `appdate` date NOT NULL DEFAULT current_timestamp(),
  `reviewedby` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`appid`, `studid`, `educid`, `reqid`, `courseid`, `parentsid`, `gradesid`, `appstatus`, `appremark`, `appdate`, `reviewedby`) VALUES
(100001, 19, 21, 944647, 17, 8, 0, 'Approved', 'complete', '2024-09-30', 'test test'),
(789847, 15, 17, 944643, 13, 3, 0, 'Pending', '', '2024-09-07', ''),
(789848, 14, 17, 944644, 14, 1, 0, 'Approved', 'complete requirements', '2024-09-07', 'admin'),
(789849, 18, 17, 944645, 15, 7, 0, 'Pending', 'Please, complete your requirements.', '2024-09-09', 'SK-Loob'),
(789850, 18, 18, 944646, 16, 7, 0, 'Approved', '', '2024-09-11', 'admin'),
(789852, 25, 22, 944648, 18, 9, 0, 'Approved', 'Complete requirements', '2024-10-18', 'SK-Loob');

-- --------------------------------------------------------

--
-- Table structure for table `concerns`
--

CREATE TABLE `concerns` (
  `concernid` int(11) NOT NULL,
  `studid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `concerns`
--

INSERT INTO `concerns` (`concernid`, `studid`, `title`, `description`, `file`, `date`, `status`, `remarks`) VALUES
(4, 14, 'isa pa ', 'filllllle', 'emoji.png', '2024-08-27', 'In Process', ''),
(6, 14, 'last na sana ', 'may file', 'use case PS.png', '2024-08-27', 'Close', ''),
(7, 14, 'last na last na try na', 'gumana ka na', 'context.png', '2024-08-27', 'Pending', ''),
(8, 15, 'snshhss', 'sshsshsh', NULL, '2024-08-30', 'Pending', ''),
(9, 25, 'hi', 'hello', 'chick.jpg', '2024-10-21', 'Pending', '');

-- --------------------------------------------------------

--
-- Table structure for table `educ aids`
--

CREATE TABLE `educ aids` (
  `educid` int(11) NOT NULL,
  `educname` varchar(255) NOT NULL,
  `sem` varchar(255) NOT NULL,
  `sy` varchar(255) NOT NULL,
  `start` date NOT NULL DEFAULT current_timestamp(),
  `end` date NOT NULL DEFAULT current_timestamp(),
  `min_grade` decimal(10,0) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `educ aids`
--

INSERT INTO `educ aids` (`educid`, `educname`, `sem`, `sy`, `start`, `end`, `min_grade`, `date`, `status`) VALUES
(17, 'Wagan Educational Assistance', 'First Semester', '2024-2025', '2024-09-07', '2024-09-23', '3', '2024-09-07', 'Closed'),
(22, 'educational assistance ', 'Second Sem', '2024-2025', '2024-10-18', '2024-10-25', '0', '2024-10-18', 'Open');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `gradesid` int(11) NOT NULL,
  `studid` int(11) NOT NULL,
  `educid` int(11) NOT NULL,
  `grade1` decimal(10,2) NOT NULL,
  `grade2` decimal(10,2) NOT NULL,
  `grade3` decimal(10,2) NOT NULL,
  `grade4` decimal(10,2) NOT NULL,
  `grade5` decimal(10,2) NOT NULL,
  `grade6` decimal(10,2) NOT NULL,
  `grade7` decimal(10,2) NOT NULL,
  `grade8` decimal(10,2) NOT NULL,
  `grade9` decimal(10,2) NOT NULL,
  `grade10` decimal(10,2) NOT NULL,
  `sub1` varchar(255) NOT NULL,
  `sub2` varchar(255) NOT NULL,
  `sub3` varchar(255) NOT NULL,
  `sub4` varchar(255) NOT NULL,
  `sub5` varchar(255) NOT NULL,
  `sub6` varchar(255) NOT NULL,
  `sub7` varchar(255) NOT NULL,
  `sub8` varchar(255) NOT NULL,
  `sub9` varchar(255) NOT NULL,
  `sub10` varchar(255) NOT NULL,
  `average` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `messageid` int(11) NOT NULL,
  `empid` int(11) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `parentinfo`
--

CREATE TABLE `parentinfo` (
  `parentid` int(11) NOT NULL,
  `studid` int(11) NOT NULL,
  `parentname` varchar(255) NOT NULL,
  `parentage` int(11) NOT NULL,
  `parent_occu` varchar(255) NOT NULL,
  `parent_income` decimal(10,0) NOT NULL,
  `parent_status` varchar(255) NOT NULL,
  `parent_educattain` varchar(255) NOT NULL,
  `parent_address` varchar(255) NOT NULL,
  `parent_contact` varchar(11) NOT NULL,
  `m_occu` varchar(255) NOT NULL,
  `m_income` decimal(10,0) NOT NULL,
  `m_status` varchar(255) NOT NULL,
  `m_educattain` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parentinfo`
--

INSERT INTO `parentinfo` (`parentid`, `studid`, `parentname`, `parentage`, `parent_occu`, `parent_income`, `parent_status`, `parent_educattain`, `parent_address`, `parent_contact`, `m_occu`, `m_income`, `m_status`, `m_educattain`) VALUES
(1, 14, 'Lorenzo Montefalco', 58, 'Businessman', '50000', 'Alive', 'College', 'cagayan', '09123456789', 's', '23333', 'Alive', 's'),
(3, 15, 'Elijah Montefalco', 49, 'Businessman', '90000', 'Alive', 'Highschool', 'san antonio', '09123456789', 'ff', '44333', 'Alive', 'hgf'),
(5, 16, 'mm', 55, 'e', '9000', 'Alive', 'college', 'gg', '54', 'entrepreneur', '80500', 'Deceased', 'college'),
(6, 17, 'saa', 45, 'fd', '9000', 'Alive', 'hgg', 'viky', '43', 's', '8050', 'Alive', 'hgf'),
(7, 18, 'jella', 21, 'student', '10000', 'Alive', 'college', 'quezon', '09123456789', '', '0', '', ''),
(8, 19, 'JJ', 47, 'ceo', '10000', 'Alive', '', 'san antonio', '09123456789', '', '0', '', ''),
(9, 25, 'JJ', 49, 'ceo', '10000', 'Alive', '', 'san antonio', '09123456789', '', '0', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `remark`
--

CREATE TABLE `remark` (
  `remarkid` int(11) NOT NULL,
  `concernid` int(11) NOT NULL,
  `studid` int(11) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `sender` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `remark`
--

INSERT INTO `remark` (`remarkid`, `concernid`, `studid`, `remarks`, `date`, `sender`) VALUES
(1, 3, 14, 'dfdfd', '2024-08-31 19:58:15', ' '),
(2, 3, 14, 'yung name', '2024-08-31 20:12:02', 'test test'),
(3, 3, 14, 'we are currently resolving your queries', '2024-08-31 20:25:39', '<br />\r\n<b>Notice</b>:  Undefined variable: name in <b>C:\\xampp\\htdocs\\educass\\staff\\view_complaint.php</b> on line <b>268</b><br />\r\n'),
(4, 4, 14, 'received. we\'ll be back', '2024-08-31 20:30:58', 'test test'),
(5, 4, 14, '', '2024-08-31 20:35:00', 'test test'),
(6, 4, 14, '', '2024-08-31 20:37:19', 'test test'),
(7, 8, 15, 'okay na po', '2024-08-31 20:38:04', 'test test'),
(8, 8, 15, '', '2024-08-31 20:38:35', 'test test'),
(9, 7, 14, 'for the go', '2024-08-31 21:05:22', 'test test'),
(10, 8, 15, 'done', '2024-09-04 22:00:17', 'ryuji mori'),
(11, 8, 15, 'one more using sk', '2024-09-04 22:02:34', 'SK-Loob'),
(12, 4, 14, 'admin here', '2024-09-08 21:56:18', 'test test'),
(13, 7, 14, 'admin?', '2024-09-08 21:56:52', 'test test'),
(14, 6, 14, 'admin again', '2024-09-08 22:01:13', 'test test'),
(15, 7, 14, 'update', '2024-09-09 21:05:07', 'test test'),
(16, 8, 15, 'pending', '2024-09-09 21:05:22', 'test test');

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE `reply` (
  `replyid` int(11) NOT NULL,
  `studid` int(11) NOT NULL,
  `concernid` int(11) NOT NULL,
  `reply` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reply`
--

INSERT INTO `reply` (`replyid`, `studid`, `concernid`, `reply`, `date`) VALUES
(1, 14, 7, 'okay na po', '2024-08-27 00:00:00'),
(2, 14, 3, 'okay na', '2024-08-27 00:00:00'),
(3, 14, 3, 'isa pa', '2024-08-27 00:00:00'),
(4, 15, 8, 'gwgwhwjw', '2024-08-30 00:00:00'),
(5, 15, 8, 'gjshshsbddivaahoq;', '2024-08-30 00:00:00'),
(6, 14, 6, 'no need na po pala', '2024-09-07 00:00:00'),
(7, 14, 6, 'time fixed', '2024-09-07 00:00:00'),
(8, 14, 6, 'ulit walang time', '2024-09-07 17:24:33'),
(9, 14, 4, 'okay po', '2024-09-20 23:16:05');

-- --------------------------------------------------------

--
-- Table structure for table `requirements`
--

CREATE TABLE `requirements` (
  `reqid` int(11) NOT NULL,
  `educid` int(11) NOT NULL,
  `studid` int(11) NOT NULL,
  `letter` varchar(255) NOT NULL,
  `schoolid` varchar(255) NOT NULL,
  `cor` varchar(255) NOT NULL,
  `indigency` varchar(255) NOT NULL,
  `grades` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requirements`
--

INSERT INTO `requirements` (`reqid`, `educid`, `studid`, `letter`, `schoolid`, `cor`, `indigency`, `grades`) VALUES
(944646, 18, 18, 'ASIA clearance.vpd.jpg', 'Untitled.png', 'logo.jpg', 'gantt chart.pdf', 'context PS.jpg'),
(944648, 22, 25, 'non-scholarship-magnaye.pdf', 'ID-Magnaye.pdf', 'cor-magnaye.pdf', 'indigency-magnaye.pdf', 'grades-Magnaye.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffid` int(11) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact_no` varchar(11) NOT NULL,
  `age` int(11) NOT NULL,
  `birthday` date NOT NULL DEFAULT current_timestamp(),
  `address` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffid`, `lastname`, `firstname`, `email`, `password`, `contact_no`, `age`, `birthday`, `address`, `position`, `image`, `gender`) VALUES
(1, 'test', 'test', 'test@gmail.com', '$2y$10$jxA9gFY04p5jtJt.uFk3C.oybzvL45pFg7WEU.I7zbx6rmThfVsn.', '912345678', 32, '2024-05-25', 'san antonio', 'Admin', '19102024124914DarkBlueBeigeCircleY2KIllustrativeClassLogo.jpg', 'Male'),
(8, 'zamora', 'janis', 'janis@dylan.com', 'fcb7c217c638fe897711da11cec7a38f', '09123456789', 21, '1999-01-28', 'cebu', 'interior', '', 'Female'),
(10, 'leelang', 'sanda', 'sampaguita@gmail.com', '$2y$10$lqH9hKoXj2kJswd/9pc65ejT6BLkhq6AHxZ9mHKbRQM1yoYEgZl2a', '977373334', 46, '2024-07-28', 'Purok 6, Sampaguita', 'SK-Sampaguita', '', 'Male'),
(11, 'mori', 'enya', 'enya@ryuji.com', '77e24e13edf735aff00a7ef5268ddbd8', '2147483647', 26, '2024-08-08', 'bgc-manila', 'SK-Poblacion', '', 'Female'),
(12, 'Riego', 'Soleil', 'soleil@gmail.com', '23206deb7eba65b3fbc80a2ffbc53c28', '09123456789', 24, '2000-06-07', 'Callejon', 'SK-Callejon', '', 'Female'),
(13, 'Niing', 'Sk', 'niing@gmail.com', '$2y$10$Q7mFpQiHO1vVZJ4lXMM3DujsnZqXIed0TamtgYH53Tb5aztc4meAu', '09123899452', 25, '1999-03-08', 'poblacion, san antonio', 'SK-Niing', '', 'Male'),
(14, 'SK', 'Loob', 'loob@gmail.com', '$2y$10$c2YWXb/iKUReNHH6hmx.8uxLDR35m0GJvXga7pNpaNfh.6UU2jBMi', '09987654321', 20, '2004-06-15', 'Loob', 'SK-Loob', '', 'Male'),
(15, 'Magnaye', 'Erika', 'erikariyamagnaye31@gmail.com', '$2y$10$f5/0DQSzkSd5x0uzqLdo9OM3FGS9uq4uLXbX5mMHoYWl3nVvf9OTq', '09683771234', 21, '2024-10-24', ' Sampaguita', 'Admin', '', 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studid` int(11) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `midname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthday` date NOT NULL DEFAULT current_timestamp(),
  `contact_no` varchar(11) NOT NULL,
  `brgy` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `street_name` varchar(255) NOT NULL,
  `validid` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `citizenship` varchar(255) NOT NULL,
  `religion` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `civilstatus` varchar(255) NOT NULL,
  `accstatus` varchar(255) NOT NULL,
  `is_activated` tinyint(1) NOT NULL,
  `activation_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studid`, `lastname`, `firstname`, `midname`, `email`, `password`, `birthday`, `contact_no`, `brgy`, `municipality`, `province`, `street_name`, `validid`, `picture`, `gender`, `citizenship`, `religion`, `age`, `civilstatus`, `accstatus`, `is_activated`, `activation_token`) VALUES
(14, 'Montefalco', 'Klare', 'T', 'erikariyamagnaye31@gmail.com', 'f7f7591403c6c431053920223069550a', '2003-03-31', '9683775270', 'Callejon', 'San Antonio', 'Quezon', 'Purok 6', 'logo.jpg', '13082024080436erika-card.png', 'Female', 'Filipino', 'catholic', 21, 'Single', 'Verified', 0, ''),
(15, 'Magnaye', 'Erika', 'R', 'eka@gmail.com', '79ee82b17dfb837b1be94a6827fa395a', '2024-08-07', '9683775270', 'Loob', 'San Antonio', 'Quezon', 'Purok 6, Sampaguita', 'uml.png', ' ', 'Female', '', '', 21, '', 'Verified', 0, ''),
(16, 'Alde', 'Dylan', 'p', 'dylan@gmail.com', '4f97319b308ed6bd3f0c195c176bbd77', '2024-08-01', '9123456789', 'Sampaguita', 'San Antonio', 'Quezon', 'viejo', 'Untitled.png', ' ', 'Male', 'fil', 'inc', 28, 'Single', 'Verified', 0, ''),
(17, 'torres', 'enya', 'sasa', 'enya@gmail.com', '77e24e13edf735aff00a7ef5268ddbd8', '2024-08-06', '9683775270', 'Niing', 'San Antonio', 'Quezon', 'Purok 6, Sampaguita', 'erd.jpg', ' ', 'Female', 'Japanese', 'muslim', 25, 'Single', 'Verified', 0, ''),
(18, 'Dimaculangan', 'evers', 'D', 'ever@gmail.com', 'c8d11180c956e5b5afc3d1970ce2193e', '1994-06-22', '9123456789', 'Loob', 'San Antonio', 'Quezon', 'Castillo', 'emoji.png', ' ', 'Male', 'Japanese', 'muslim', 30, 'Married', 'Verified', 0, ''),
(19, 'Peloramas', 'Jelladane', 'L', 'jella@gmail.com', '$2y$10$qrw4xgNjkXDSr4ijZyARwuFEmexBM1dXiLeeanEK7CDrDq9ppW54m', '2002-07-11', '9123899453', 'Poblacion', 'San Antonio', 'Quezon', 'san antonio', 'ES_Magnaye.png', ' ', 'Male', '', '', 21, '', ' ', 0, ''),
(21, 'guo', 'jenny', 'sy', 'jenny@gmail.com', 'ebe6941ee8a10c14dc933ae37a0f43fc', '2024-02-29', '09987654321', 'Sampaguita', 'San Antonio', 'Quezon', 'quilo', '', '', 'Female', '', '', 34, '', '', 0, ''),
(22, 'Razon', 'joana', 'r', 'joana@gmail.com', '18f01959ff46071d73905d549cafde20', '2001-06-11', '09126789432', 'Poblacion', 'San Antonio', 'Quezon', 'dimaano', '', '', 'Female', '', '', 22, '', '', 0, ''),
(23, 'Magnaye', 'akira', 'r', 'erinayeeyangma@gmail.com', '$2y$10$KsZTDQ0iw9AJQ3DGh2oqJ.obzogjiQ9MahtpvziypY3a9cFLK9rLa', '2024-10-16', '09123456789', 'Sampaguita', 'San Antonio', 'Quezon', 'purok 3', '', '', 'Female', '', '', 21, '', '', 0, 'ef0d0ddb5adc096e6b328b6b0219c6e7'),
(25, 'lim', 'jessa', 'r', 'jessariyamagnaye@gmail.com', '$2y$10$OPvImuUWHI6M2cueQBBCMeEQNUpbHbIV0nkVgJ4lXgoRtrnQnEUBC', '2024-01-31', '09683775567', 'Loob', 'San Antonio', 'Quezon', 'street dos', '', '', 'Female', '', '', 24, '', '', 1, ''),
(26, 'gabuya', 'jenny', 'a', 'erinayeeyangam@gmail.com', '$2y$10$icnR5nmxUNGQKmZPexsznu5PzgmkgeNJjRhtVOqcA6qW1TMcq9l2e', '2008-07-10', '09683775270', 'Balat Atis', 'San Antonio', 'Quezon', 'Purok 6, Sampaguita', '', '', 'Male', '', '', 23, '', '', 1, ''),
(27, 'dimaculangan', 'everson', 'd', 'eversonlasat@gmail.com', '$2y$10$69FopN9t1NnopyMIC8D8aulkXshsSjGBCCJcKDRKGLsRKcNE7r91W', '2000-10-10', '09123899453', 'Sinturisan', 'san antonio', 'Quezon', 'stree 1', '', '', 'Male', '', '', 24, '', '', 0, 'e457f9419b530e63bec164638dbd0d84');

-- --------------------------------------------------------

--
-- Table structure for table `studentcourse`
--

CREATE TABLE `studentcourse` (
  `courseid` int(11) NOT NULL,
  `studid` int(11) NOT NULL,
  `educid` int(11) NOT NULL,
  `course` varchar(255) NOT NULL,
  `major` varchar(255) NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `school_address` varchar(255) NOT NULL,
  `sem` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `sy` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `studentcourse`
--

INSERT INTO `studentcourse` (`courseid`, `studid`, `educid`, `course`, `major`, `school_name`, `school_address`, `sem`, `year`, `sy`) VALUES
(1, 14, 17, 'finance', 'legal management', 'BSU', 'Cagayan De Oro', 'First Semester', 'First Year', '2024-2025'),
(2, 15, 17, 'dentistry', 'med', 'manila university', 'manila', 'First Semester', 'First Year', '2024-2025'),
(12, 15, 17, 'dentistry', 'med', 'manila university', 'manila', 'First Semester', 'Third Year', '2024-2025'),
(13, 15, 17, 'dentistry', 'med', 'manila university', 'manila', 'First Semester', 'Third Year', '2024-2025'),
(14, 14, 17, 'finance', 'legal management', 'BSU', 'Cagayan De Oro', 'First Semester', 'First Year', '2024-2025'),
(15, 18, 17, 'BSIT', 'Service management', 'BSU', 'lipa', 'First Semester', 'Fourth Year', '2024-2025'),
(16, 18, 18, 'BSIT', 'Service management', 'BSU', 'lipa', 'Second Semester', 'Fourth Year', '2024-2025'),
(17, 19, 21, 'bsit', 'sm', 'BSU', 'lipa', 'Second Semester', 'Fifth Year', '2025-2026'),
(18, 25, 22, 'arts', 'archi', 'BSU', 'lipa', 'Second Semester', 'Second Year', '2024-2025');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminid`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`announceid`);

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`appid`),
  ADD KEY `studid` (`studid`),
  ADD KEY `educid` (`educid`),
  ADD KEY `reqid` (`reqid`),
  ADD KEY `courseid` (`courseid`),
  ADD KEY `parentsid` (`parentsid`),
  ADD KEY `gradesid` (`gradesid`);

--
-- Indexes for table `concerns`
--
ALTER TABLE `concerns`
  ADD PRIMARY KEY (`concernid`);

--
-- Indexes for table `educ aids`
--
ALTER TABLE `educ aids`
  ADD PRIMARY KEY (`educid`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`gradesid`),
  ADD KEY `studid` (`studid`),
  ADD KEY `educid` (`educid`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`messageid`);

--
-- Indexes for table `parentinfo`
--
ALTER TABLE `parentinfo`
  ADD PRIMARY KEY (`parentid`);

--
-- Indexes for table `remark`
--
ALTER TABLE `remark`
  ADD PRIMARY KEY (`remarkid`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`replyid`);

--
-- Indexes for table `requirements`
--
ALTER TABLE `requirements`
  ADD PRIMARY KEY (`reqid`),
  ADD KEY `studid` (`studid`),
  ADD KEY `educid` (`educid`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffid`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studid`);

--
-- Indexes for table `studentcourse`
--
ALTER TABLE `studentcourse`
  ADD PRIMARY KEY (`courseid`),
  ADD KEY `studid` (`studid`),
  ADD KEY `educid` (`educid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announceid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `appid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=789853;

--
-- AUTO_INCREMENT for table `concerns`
--
ALTER TABLE `concerns`
  MODIFY `concernid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `educ aids`
--
ALTER TABLE `educ aids`
  MODIFY `educid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `gradesid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=745;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `messageid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parentinfo`
--
ALTER TABLE `parentinfo`
  MODIFY `parentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `remark`
--
ALTER TABLE `remark`
  MODIFY `remarkid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `replyid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `requirements`
--
ALTER TABLE `requirements`
  MODIFY `reqid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=944649;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `studid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `studentcourse`
--
ALTER TABLE `studentcourse`
  MODIFY `courseid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

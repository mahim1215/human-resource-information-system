-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2024 at 08:19 AM
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
-- Database: `hrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `admindashboard`
--

CREATE TABLE `admindashboard` (
  `adminDashboardId` int(30) NOT NULL,
  `employeeID` int(100) DEFAULT NULL,
  `dashboardContent` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admindashboard`
--

INSERT INTO `admindashboard` (`adminDashboardId`, `employeeID`, `dashboardContent`) VALUES
(1, 1, 'Admin dashboard content goes here'),
(2, 4, 'Admin dashboard content goes here');

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` enum('Male','Female','No Mention') NOT NULL,
  `address` text NOT NULL,
  `salary_expectation` varchar(255) NOT NULL,
  `cv_path` varchar(255) NOT NULL,
  `applied_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `job_id`, `name`, `email`, `gender`, `address`, `salary_expectation`, `cv_path`, `applied_time`) VALUES
(6, 2, 'Md. Rejoan Siddiky', 'siddikyrejoan.work@gmail.com', 'Male', 'Dhaka, Bd', '10K', 'uploads/Resume of Md. Rejoan Siddiky.pdf', '2024-06-03 12:35:36');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendanceId` int(11) NOT NULL,
  `employeeId` int(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `clockInTime` time DEFAULT NULL,
  `clockOutTime` time DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `leaveType` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendanceId`, `employeeId`, `date`, `clockInTime`, `clockOutTime`, `status`, `leaveType`) VALUES
(1, 2, '2024-06-04', '12:09:00', '18:09:00', 'Present', NULL),
(2, 1, '2024-06-04', '12:09:00', '18:09:00', 'Present', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `clientId` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `contactInfo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`clientId`, `name`, `contactInfo`) VALUES
(1, 'Lorem Softwares', 'contact@loremsoftwares.com'),
(2, 'Go Forces Ltd', 'info@goforcesltd.com'),
(3, 'Video Go Limited', 'support@videogolimited.com'),
(4, 'Lorem Golds', 'sales@loremgolds.com'),
(5, 'Ipsum Clouds', 'help@ipsumclouds.com'),
(6, 'Ipsumm E-commerce Ltd', 'admin@ipsummecltd.com');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contactID` int(11) NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `contactPerson` varchar(255) DEFAULT NULL,
  `phoneNumber` varchar(15) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contactID`, `department`, `contactPerson`, `phoneNumber`, `email`) VALUES
(1, 'HR Administration', 'John Doe', '+1234567890', 'hr@example.com'),
(2, 'Electrical Maintenance', 'Jane Smith', '+0987654321', 'electric@example.com'),
(3, 'Water Supply', 'Alice Johnson', '+1122334455', 'water@example.com'),
(4, 'IT Support', 'Bob Brown', '+6677889900', 'it@example.com'),
(5, 'Security', 'Charlie Davis', '+2233445566', 'security@example.com'),
(6, 'Facilities Management', 'David Edwards', '+3344556677', 'facilities@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `departmentId` int(10) NOT NULL,
  `departmentName` varchar(100) NOT NULL,
  `description` varchar(300) NOT NULL,
  `headOfDepartment` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`departmentId`, `departmentName`, `description`, `headOfDepartment`) VALUES
(1, 'Human Resources', 'Responsible for managing employee relations and organizational development.', 112),
(2, 'Finance', 'Responsible for managing financial transactions and reporting.', 117),
(3, 'IT', 'Responsible for managing information technology systems and infrastructure.', 1),
(5, 'Marketing', 'This department works on promoting the product and attracting prospects.', 102),
(6, 'Customer Support', 'This department addresses all incoming client concerns, complaints, and requests.', 110),
(7, 'Design', 'his department is responsible for the visual aspects of the product.', 114);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employeeId` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(200) NOT NULL,
  `jobTitle` varchar(60) NOT NULL,
  `departmentId` int(30) NOT NULL,
  `dateOfJoining` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `baseSalary` decimal(10,2) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(80) NOT NULL,
  `role` enum('employee','admin') NOT NULL,
  `leave_request` enum('NotApplied','Applied','Approved','Rejected') DEFAULT 'NotApplied'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employeeId`, `name`, `email`, `phone`, `address`, `jobTitle`, `departmentId`, `dateOfJoining`, `status`, `baseSalary`, `username`, `password`, `role`, `leave_request`) VALUES
(1, 'sohan', 'sohan@example.com', '123-456-7890', '123 Main St, Anytown, BD', 'Sr. Software Engineer', 3, '2020-01-15', 'Active', 50000.00, 'sohan', '1234', 'admin', 'NotApplied'),
(2, 'tahmina', 'tahmina@example.com', '987-654-3210', '456 Oak St, Anytown, BD', 'Data Analyst', 3, '2020-03-20', 'Active', 48000.00, 'tahmina', '5678', 'employee', 'NotApplied'),
(3, 'hridoy', 'hridoy@example.com', '555-123-4567', '789 Elm St, Anytown, BD', 'Sr. Programmer', 3, '2020-02-10', 'Active', 48000.00, 'hridoy', '91011', 'employee', 'NotApplied'),
(4, 'rejoan', 'rejoan@example.com', '113-112-4567', '709 Fnt St, Anytown, BD', 'IT Specialist', 3, '2020-02-10', 'Active', 38000.00, 'rejoan', '123', 'admin', 'NotApplied'),
(102, 'hasib', 'hasib@example.com', '1234567890', 'Netrokona, BGD', 'Media Manager', 5, '2021-06-25', 'Active', 38000.00, 'hasib', 'hasib', 'employee', 'NotApplied'),
(103, 'sejuti', 'sejuti@example.com', '1234567123', 'Dhaka, BGD', 'Associate Media Manager', 5, '2023-06-10', 'Active', 30000.00, 'sejuti', 'sejuti', 'employee', 'Approved'),
(110, 'rahman', 'rahman@example.com', '99997454', 'Mymensingh, BGD', 'Customer Support Head', 6, '2023-06-10', 'Active', 34000.00, 'rahman', 'rahman', 'employee', 'NotApplied'),
(111, 'joyita', 'joyita@example.com', '67123329', 'Dhaka, BGD', 'Junior Customer Support', 6, '2024-03-10', 'Active', 25000.00, 'joyita', 'joyita', 'employee', 'NotApplied'),
(112, 'ahmed', 'ahmed@example.com', '121212121', 'Dhaka, BGD', 'HR Admin', 1, '2021-02-10', 'Active', 40000.00, 'ahmed', 'ahmed', 'admin', 'NotApplied'),
(113, 'sojib', 'sojib@example.com', '1234597123', 'Dhaka, BGD', 'Assistant HR Admin', 1, '2022-04-10', 'Active', 30000.00, 'sojib', 'sojib', 'admin', 'NotApplied'),
(114, 'bilkis', 'bilkis@example.com', '1234789', 'Cumilla, BGD', 'Product Designer', 7, '2021-01-16', 'Active', 38000.00, 'bilkis', 'bilkis', 'employee', 'NotApplied'),
(115, 'ayesha', 'ayesha@example.com', '67123294', 'Barishal, BGD', 'Junior Product Designer', 7, '2022-05-10', 'Active', 30000.00, 'ayesha', 'ayesha', 'employee', 'NotApplied'),
(116, 'roksana', 'roksana@example.com', '1325815', 'Dhaka, BGD', 'Associate Accountant', 2, '2024-06-01', '', 35000.00, 'roksana', 'roksana', 'employee', 'NotApplied'),
(117, 'Mahedy', 'mahedy@example.com', '13453434', 'Barishal, BGD', 'Senior Accountant', 2, '2022-01-01', '', 40000.00, 'mahedy', 'mahedy', 'employee', 'NotApplied');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `holidayID` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `description` varchar(120) DEFAULT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`holidayID`, `date`, `description`, `year`) VALUES
(1, '2024-01-01', 'New Year\'s Day', 2024),
(2, '2024-02-14', 'Valentine\'s Day', 2024),
(3, '2024-03-17', 'St. Patrick\'s Day', 2024),
(4, '2024-04-21', 'Easter Sunday', 2024),
(5, '2024-05-27', 'Memorial Day', 2024),
(6, '2024-07-04', 'Independence Day', 2024),
(7, '2024-09-02', 'Labor Day', 2024),
(8, '2024-10-31', 'Halloween', 2024),
(9, '2024-11-28', 'Thanksgiving Day', 2024),
(10, '2024-12-25', 'Christmas Day', 2024);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `position_name` varchar(255) NOT NULL,
  `published_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `vacancy` int(11) NOT NULL,
  `deadline` date NOT NULL,
  `experience_years` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `salary_range` varchar(255) NOT NULL,
  `job_type` enum('Full-time','Part-time','Intern','Contractual') NOT NULL,
  `qualifications` text NOT NULL,
  `benefits` text NOT NULL,
  `education_requirement` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `position_name`, `published_time`, `vacancy`, `deadline`, `experience_years`, `location`, `salary_range`, `job_type`, `qualifications`, `benefits`, `education_requirement`) VALUES
(1, 'Software Engineer (Java)', '2024-06-02 09:55:38', 2, '2024-06-10', 2, 'Dhaka, Bangladesh.', '50k - 60k (BDT)', 'Full-time', 'Analyzing information\r\nGeneral programming skills\r\nSoftware design\r\nSoftware debugging\r\nSoftware documentation\r\nSoftware testing\r\nProblem solving\r\nTeamwork\r\nSoftware development fundamentals\r\nSoftware development process\r\nSoftware requirements', 'paid time off\r\npaid parental leave\r\nhealth insurance\r\ndental insurance\r\nremote work\r\na flexible schedule\r\ntuition reimbursement\r\nbonuses(2/year)', 'BSc. / MSc. from any reputated university. '),
(2, 'Intern Software Engineer', '2024-06-02 09:59:07', 5, '2024-06-10', 0, 'Dhaka, Bangladesh.', '10k - 12k (BDT)', 'Intern', 'Outstanding coding abilities\r\nThorough knowledge of atleast 1 programming language.\r\nWorking knowledge of HTML, CSS, Javascript is a must.\r\nPassion to learn new technology\r\nShould work with seniors and be a team player.', 'Comprehensive training in web, mobile development.\r\nSeed capital to launch your first app or solution.\r\nA dynamic, supportive, and innovative work environment.', 'Completing last semester of your BSc.');

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int(11) NOT NULL,
  `employeeId` int(100) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `reason` varchar(200) DEFAULT NULL,
  `departmentId` int(11) NOT NULL,
  `jobTitle` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `leave_status` enum('Approved','Rejected','Applied') DEFAULT 'Applied'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `employeeId`, `from_date`, `to_date`, `reason`, `departmentId`, `jobTitle`, `email`, `leave_status`) VALUES
(11, 103, '2024-06-10', '2024-06-15', 'Sibling Marriage.', 5, 'Associate Media Manager', 'sejuti@example.com', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `salaryId` bigint(20) NOT NULL,
  `employeeId` int(100) DEFAULT NULL,
  `bonuses` decimal(10,2) DEFAULT NULL,
  `deductions` decimal(10,2) DEFAULT NULL,
  `baseSalary` decimal(10,2) DEFAULT NULL,
  `paymentDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`salaryId`, `employeeId`, `bonuses`, `deductions`, `baseSalary`, `paymentDate`) VALUES
(1, 1, 500.00, 100.00, 50000.00, '2024-05-01'),
(2, 2, 500.00, 50.00, 48000.00, '2024-05-01'),
(3, 3, 500.00, 0.00, 48000.00, '2024-05-01'),
(4, 4, 500.00, 200.00, 45000.00, '2024-05-01');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `ServiceID` int(11) NOT NULL,
  `ClientID` int(11) DEFAULT NULL,
  `ProjectName` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `TotalEarnings` decimal(10,2) DEFAULT NULL,
  `Status` enum('On going','Completed') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`ServiceID`, `ClientID`, `ProjectName`, `Description`, `StartDate`, `EndDate`, `TotalEarnings`, `Status`) VALUES
(11, 1, 'Custom CRM Development', 'Developing a custom Customer Relationship Management system.', '2018-01-15', '2018-12-31', 120000.00, 'Completed'),
(12, 2, 'AI Chatbot Integration', 'Integrating an AI chatbot for customer support automation.', '2019-02-20', '2019-08-30', 80000.00, 'Completed'),
(13, 3, 'E-commerce Platform Upgrade', 'Upgrading an existing e-commerce platform with new features.', '2020-04-05', '2020-11-15', 150000.00, 'Completed'),
(14, 4, 'Cloud Migration', 'Migrating existing infrastructure to cloud services.', '2021-07-10', '2022-01-25', 200000.00, 'Completed'),
(15, 5, 'Video Streaming App Development', 'Creating a video streaming app for mobile devices.', '2022-03-01', '2022-09-30', 180000.00, 'Completed'),
(16, 1, 'Data Analysis Tool', 'Building a tool for analyzing sales and marketing data.', '2023-01-15', '2023-06-30', 90000.00, 'Completed'),
(17, 2, 'Cybersecurity Audit', 'Performing a comprehensive cybersecurity audit and implementing security measures.', '2023-08-01', '2023-12-31', 75000.00, 'Completed'),
(18, 3, 'Mobile App Development', 'Developing a mobile app for internal communication and task management.', '2024-02-01', '2024-07-31', 130000.00, 'Completed'),
(19, 5, 'Social Media Marketing Campaign', 'Designing and executing a social media marketing campaign.', '2024-05-15', '2024-08-15', 50000.00, 'On going'),
(20, 6, 'Website Redesign', 'Redesigning the company website for better user experience and SEO optimization.', '2024-09-01', '2024-12-31', 60000.00, 'On going');

-- --------------------------------------------------------

--
-- Table structure for table `userdashboard`
--

CREATE TABLE `userdashboard` (
  `userDashboardId` int(120) NOT NULL,
  `employeeID` int(100) DEFAULT NULL,
  `dashboardContent` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdashboard`
--

INSERT INTO `userdashboard` (`userDashboardId`, `employeeID`, `dashboardContent`) VALUES
(1, 2, 'User dashboard content goes here'),
(2, 3, 'User dashboard content goes here');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admindashboard`
--
ALTER TABLE `admindashboard`
  ADD PRIMARY KEY (`adminDashboardId`),
  ADD KEY `employeeID` (`employeeID`);

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendanceId`),
  ADD KEY `employeeId` (`employeeId`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`clientId`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contactID`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`departmentId`),
  ADD KEY `fk_headOfDepartment` (`headOfDepartment`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employeeId`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password` (`password`),
  ADD KEY `fk_departmentId` (`departmentId`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`holidayID`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_requests_ibfk_1` (`employeeId`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`salaryId`),
  ADD KEY `employeeId` (`employeeId`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`ServiceID`),
  ADD KEY `ClientID` (`ClientID`);

--
-- Indexes for table `userdashboard`
--
ALTER TABLE `userdashboard`
  ADD PRIMARY KEY (`userDashboardId`),
  ADD KEY `employeeID` (`employeeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendanceId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `clientId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contactID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `departmentId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employeeId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `holidayID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `ServiceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admindashboard`
--
ALTER TABLE `admindashboard`
  ADD CONSTRAINT `admindashboard_ibfk_1` FOREIGN KEY (`employeeID`) REFERENCES `employee` (`employeeId`);

--
-- Constraints for table `applicants`
--
ALTER TABLE `applicants`
  ADD CONSTRAINT `applicants_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`);

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employeeId`) REFERENCES `employee` (`employeeId`);

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `fk_headOfDepartment` FOREIGN KEY (`headOfDepartment`) REFERENCES `employee` (`employeeId`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `fk_departmentId` FOREIGN KEY (`departmentId`) REFERENCES `department` (`departmentId`);

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `leave_requests_ibfk_1` FOREIGN KEY (`employeeId`) REFERENCES `employee` (`employeeId`) ON DELETE CASCADE;

--
-- Constraints for table `salary`
--
ALTER TABLE `salary`
  ADD CONSTRAINT `salary_ibfk_1` FOREIGN KEY (`employeeId`) REFERENCES `employee` (`employeeId`);

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `clients` (`clientId`);

--
-- Constraints for table `userdashboard`
--
ALTER TABLE `userdashboard`
  ADD CONSTRAINT `userdashboard_ibfk_1` FOREIGN KEY (`employeeID`) REFERENCES `employee` (`employeeId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

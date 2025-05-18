-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2025 at 04:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zeus`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `user_id`, `status`, `created_at`) VALUES
(35, 55, 1, 'pending', '2025-04-08 16:28:08'),
(36, 55, 2, 'pending', '2025-04-08 16:28:26'),
(37, 57, 3, 'pending', '2025-04-14 12:30:45'),
(38, 2, 4, 'pending', '2025-04-14 14:45:35'),
(39, 61, 5, 'pending', '2025-04-14 14:53:17'),
(40, 62, 6, 'pending', '2025-04-14 15:06:04'),
(41, 62, 7, 'pending', '2025-04-14 15:06:07'),
(42, 63, 8, 'pending', '2025-04-14 15:20:28'),
(43, 64, 38, 'pending', '2025-04-21 09:26:20'),
(44, 65, 38, 'pending', '2025-04-21 09:28:43'),
(45, 66, 38, 'pending', '2025-04-21 09:34:55'),
(46, 67, 38, 'pending', '2025-04-21 09:41:33'),
(47, 68, 33, 'pending', '2025-04-21 09:47:58'),
(48, 70, 39, 'pending', '2025-04-21 09:54:01'),
(49, 71, 33, 'pending', '2025-04-21 09:57:31'),
(50, 72, 33, 'pending', '2025-04-21 10:00:49'),
(51, 73, 35, 'pending', '2025-04-21 10:05:30'),
(52, 70, 35, 'cancelled', '2025-04-21 10:30:01'),
(53, 69, 35, 'pending', '2025-04-21 10:33:05');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_reports`
--

CREATE TABLE `doctor_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `diseases` longtext DEFAULT NULL,
  `height` varchar(50) DEFAULT NULL,
  `weight` varchar(50) DEFAULT NULL,
  `allergies` longtext DEFAULT NULL,
  `test_status` varchar(100) DEFAULT NULL,
  `blood_group` varchar(100) DEFAULT NULL,
  `chronic_illnesses` text DEFAULT NULL,
  `past_surgeries` text DEFAULT NULL,
  `family_history` text DEFAULT NULL,
  `symptoms` longtext DEFAULT NULL,
  `prescriptions` longtext DEFAULT NULL,
  `diagnosis` longtext DEFAULT NULL,
  `prescribed_medicines` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_reports`
--

INSERT INTO `doctor_reports` (`id`, `patient_id`, `diseases`, `height`, `weight`, `allergies`, `test_status`, `blood_group`, `chronic_illnesses`, `past_surgeries`, `family_history`, `symptoms`, `prescriptions`, `diagnosis`, `prescribed_medicines`, `created_at`) VALUES
(26, 72, 'Diabetes Mellitus Type 2', NULL, '60', 'Penicillin', 'Done', 'B+', NULL, NULL, NULL, 'Frequent urination, excessive thirst, fatigue', 'Metformin 500mg twice daily', 'Type 2 Diabetes', 'Metformin, Glimepiride', '2025-04-21 10:09:02'),
(27, 71, 'Acute Bronchitis', NULL, NULL, 'None', 'Done', 'O+', NULL, NULL, NULL, 'Persistent cough, chest congestion, mild fever', 'Azithromycin 500mg once daily for 3 days', 'Respiratory tract infection (likely bronchitis)', 'Azithromycin, Cough Syrup, Paracetamol', '2025-04-21 10:11:24'),
(28, 68, 'Hypertension and Coronary Artery Disease', NULL, NULL, 'Sulfa drugs', 'Pending', 'A+', NULL, NULL, NULL, 'Chest pain on exertion, shortness of breath, dizziness', 'Atenolol 50mg, Aspirin 75mg, Atorvastatin 10mg', 'Stable Angina', 'Atenolol, Aspirin, Atorvastatin', '2025-04-21 10:14:05'),
(29, 73, 'Acute Tonsillitis', NULL, NULL, 'Dust, Pollen', 'Pending', 'AB+', NULL, NULL, NULL, 'Sore throat, difficulty swallowing, fever', 'Amoxicillin 250mg syrup, Paracetamol syrup', 'Bacterial Tonsillitis', 'Amoxicillin, Paracetamol, Cough Drops', '2025-04-21 10:16:18'),
(30, 70, 'Hypertension, Osteoarthritis', NULL, NULL, 'NSAIDs (nonsteroidal anti-inflammatory drugs)', 'Done', 'A+', NULL, NULL, NULL, 'Joint pain, swelling in knees, dizziness', ' Calcium + Vitamin D3, Telmisartan 40mg, JointFlex Gel', 'Age-related osteoarthritis and high blood pressure', 'Telmisartan, JointFlex Gel, Calci-D tablets', '2025-04-21 10:32:03'),
(31, 69, 'Type 2 Diabetes, Mild Cognitive Impairment', NULL, '50', 'None', 'Done', 'A+', NULL, NULL, NULL, 'Forgetfulness, frequent urination, blurred vision', 'Metformin 500mg, Donepezil 5mg', 'Early-stage Type 2 Diabetes with mild memory loss (suspected dementia)', 'Metformin, Donepezil, Vitamin B Complex', '2025-04-21 10:34:52');

-- --------------------------------------------------------

--
-- Table structure for table `fingerprint`
--

CREATE TABLE `fingerprint` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fid` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fingerprint`
--

INSERT INTO `fingerprint` (`id`, `fid`) VALUES
(58, 1),
(59, 2),
(60, 3),
(61, 4),
(62, 5),
(63, 6),
(64, 7),
(65, 8),
(66, 9),
(67, 10),
(68, 11);

-- --------------------------------------------------------

--
-- Table structure for table `fresponder_form`
--

CREATE TABLE `fresponder_form` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fresponder_reports`
--

CREATE TABLE `fresponder_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location` varchar(500) DEFAULT NULL,
  `incident_cause` varchar(500) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fresponder_reports`
--

INSERT INTO `fresponder_reports` (`id`, `patient_id`, `location`, `incident_cause`, `description`, `image`, `created_at`, `user_id`) VALUES
(18, 68, 'Pepsicola Health Post, Kathmandu', 'Sudden chest pain during morning walk', 'Patient reported sharp chest pain and shortness of breath while walking. Immediate ECG indicated signs of stable angina. Patient was advised rest and medication, with further lipid profile and cardiology consultation scheduled. Vitals were within control upon arrival.', 'Screenshot 2025-04-21 153217.png', '2025-04-21 10:17:53', 34),
(19, 67, 'Near Pepsicola Ring Road, Kathmandu', 'Road traffic accident while riding a scooter', 'Patient was involved in a road accident while riding a two-wheeler. She sustained minor abrasions on the right elbow and a suspected ankle sprain. Conscious and alert upon arrival. Vitals are stable. X-ray of the ankle has been advised along with basic wound cleaning and pain management.', 'Screenshot 2025-04-21 152606.png', '2025-04-21 10:19:34', 34),
(20, 69, 'Outside Jorpati Chowk, Kathmandu', 'Slipped on wet pavement while walking', 'Patient slipped and fell on a wet sidewalk, sustaining mild abrasions on the left knee and bruises on the left palm. No signs of head trauma or loss of consciousness. Patient advised to rest, keep the wound clean, and apply prescribed topical ointment. X-ray not deemed necessary at this stage.', 'Screenshot 2025-04-21 153502.png', '2025-04-21 10:20:59', 34),
(21, 70, 'Near Baluwatar Chowk, Kathmandu', 'Bicycle collision with a pedestrian', 'Patient was riding a bicycle and accidentally collided with a pedestrian. She sustained a minor cut on the forehead and bruising on the right shoulder. Conscious and oriented. Basic wound cleaning was performed and patient was advised to rest. A tetanus injection was administered as a precaution.', 'Screenshot 2025-04-21 153834.png', '2025-04-21 10:22:32', 34),
(22, 71, 'Outside Pepsicola Bus Stop, Kathmandu', 'Fell while boarding a moving bus', 'Patient lost balance while attempting to board a moving local bus. She sustained mild to moderate abrasions on both knees and experienced dizziness. Vitals were stable. Wound area was cleaned and dressed. Patient was given Azithromycin and Paracetamol for preventive care and advised rest. No fractures suspected; further X-ray recommended if pain persists.', 'Screenshot 2025-04-21 154200.png', '2025-04-21 10:24:26', 34),
(23, 72, 'Thimi Bus Station, Bhaktapur', 'Involved in a low-speed motorbike collision with a parked vehicle', 'Patient, a known diabetic, was riding a two-wheeler and collided with a stationary car due to sudden brake failure. He fell sideways, sustaining a laceration on the left forearm and bruises on the knee. Though conscious and oriented, the bleeding was moderate and required 3 stitches. Blood sugar was slightly elevated on arrival, and antibiotics were prescribed with caution due to penicillin allergy. Wound dressing and tetanus prophylaxis were provided. Follow-up required in 48 hours.', 'Screenshot 2025-04-21 154530.png', '2025-04-21 10:26:16', 34),
(24, 73, 'Bode Sports Ground, Bhaktapur', 'Hit in the face by a cricket ball during a local match', 'Patient sustained a direct impact on the left side of his face while fielding during a cricket game. Swelling and bruising around the cheekbone were observed. No signs of fracture or concussion, but an X-ray was advised to rule out minor fractures. Patient is allergic to dust and pollen, so care was taken while treating outdoors. Prescribed Paracetamol for pain and recommended cold compress. Advised rest for 2 days and follow-up for swelling reduction.', 'Screenshot 2025-04-21 154653.png', '2025-04-21 10:27:34', 34);

-- --------------------------------------------------------

--
-- Table structure for table `injuries`
--

CREATE TABLE `injuries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_details`
--

CREATE TABLE `patient_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `fingerprint_id` int(11) NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `ephone` varchar(255) DEFAULT NULL,
  `relation` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `dp` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_details`
--

INSERT INTO `patient_details` (`id`, `created_at`, `updated_at`, `fingerprint_id`, `fname`, `address`, `email`, `phone`, `ephone`, `relation`, `gender`, `dp`, `dob`) VALUES
(67, '2025-04-21 09:39:16', '2025-04-21 09:39:16', 1, 'Bipashna Rayamajhi', 'Kageshowri Manohara-7, Kathmandu', 'rayamajhibipashna@gmail.com', '9845273154', '9841865789', 'parents', 'female', 'Screenshot 2025-04-21 152606.png', '2003-08-27'),
(68, '2025-04-21 09:41:59', '2025-04-21 09:41:59', 2, 'Babita Singh Thakuri', 'Pepsicola,Kathmandu', 'babitarayamajhi16@gmail.com', '9843199510', '9841865789', 'spouse', 'female', 'Screenshot 2025-04-21 153217.png', '1978-06-21'),
(69, '2025-04-21 09:48:23', '2025-04-21 09:48:23', 3, 'Sandhy Gole', 'Jorpati', 'sandhyagole072@gmail.com', '9765569297', '9845273154', 'sister', 'female', 'Screenshot 2025-04-21 153502.png', '2003-05-21'),
(70, '2025-04-21 09:51:13', '2025-04-21 09:51:13', 4, 'Aagya Shrestha', 'Baluwatar', 'aagya.shrestha12@gmail.com', '9860561640', '9818376109', 'sister', 'female', 'Screenshot 2025-04-21 153834.png', '2002-07-20'),
(71, '2025-04-21 09:54:32', '2025-04-21 09:54:32', 5, 'Bidhata Rayamajhi', 'Pepsicola,Kathmandu', 'bidhata.ray24@gmail.com', '9863800562', '9845273154', 'sister', 'female', 'Screenshot 2025-04-21 154200.png', '2000-11-21'),
(72, '2025-04-21 09:58:27', '2025-04-21 09:58:27', 6, 'Suman Singh', 'Thimi,Bhaktapur', 'suman8.bhujel@gmail.com', '9807779563', '9843199510', 'parents', 'male', 'Screenshot 2025-04-21 154530.png', '2001-06-21'),
(73, '2025-04-21 10:02:14', '2025-04-21 10:02:14', 7, 'Rahul Yadav', 'Bode', 'ry1858576@gmail.com', '9808055786', '9807779563', 'brother', 'male', 'Screenshot 2025-04-21 154653.png', '2001-02-01'),
(74, '2025-04-21 10:38:14', '2025-04-21 10:38:14', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, '2025-04-22 08:49:59', '2025-04-22 08:49:59', 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, '2025-04-22 08:58:22', '2025-04-22 08:58:22', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, '2025-04-22 09:11:11', '2025-04-22 09:11:11', 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(78, '2025-04-22 15:54:02', '2025-04-22 15:54:02', 0, NULL, NULL, NULL, '9840340674', NULL, NULL, NULL, NULL, NULL),
(79, '2025-04-22 15:54:48', '2025-04-22 15:54:48', 0, 'haaaaaaaaaa', 'ha@gmail.com', 'shailedrarayamajhi@gmail.com', '9843199510', '9841865789', 'parents', 'female', 'IMG_20200909_085153_778.jpg', '2025-04-03'),
(80, '2025-04-22 16:39:44', '2025-04-22 16:39:44', 0, NULL, NULL, NULL, '9841182202', NULL, NULL, NULL, NULL, NULL),
(81, '2025-04-23 03:18:15', '2025-04-23 03:18:15', 0, NULL, NULL, NULL, '9842827734', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_injuries`
--

CREATE TABLE `patient_injuries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `injury_id` bigint(20) UNSIGNED NOT NULL,
  `desc_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_injuries_desc`
--

CREATE TABLE `patient_injuries_desc` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` longtext DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `image` varchar(2000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `retrieve_fingerprint`
--

CREATE TABLE `retrieve_fingerprint` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fid` bigint(20) UNSIGNED DEFAULT NULL,
  `retrieved_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT 'PATIENT'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Admin', 'admin@example.com', '$2y$10$31YThHS3EUsYhTKLnMRXp.SNGgot8DhzzGZv5qq6nK35HrAE0C9YK', 'ADMIN'),
(33, 'Hari', 'rayamajhibipashna@gmail.com', '$2y$10$s/UcyyW5oNTgXLSpvTcDB.7BTleLqGLWuKPUifG81Tak1v0vXmBKm', 'DOCTOR'),
(34, 'Reechal', 'reechalray@gmail.com', '$2y$10$6vP2e2cT1MniqeoX1j8G.utk5NhAUgq6NY8BY8d5ze1jZa4xxeisS', 'FRESPONDER'),
(35, 'Bipashna', 'bipashnar@gmail.com', '$2y$10$KPwKMJKj85UZ8kTHnifKbu2ZhErujZrSyznRpt54hsYhaKNPiv81e', 'DOCTOR'),
(36, 'Babita Rayamajhi', 'babita12@gmail.com', '$2y$10$dW8oIm/3pztixXNVuEoqouBB2YshOCsLvXXe0r0TIyrlRe/CTeRSa', 'RECEPTIONIST'),
(37, 'Bikhyat Rayamajhi', 'bikhyat12@gmail.com', '$2y$10$8JdvNhFpKXI9Nwqcs7qAH.jVype6Gs2kJXt80haQm7P6urpJWNbNC', 'FRESPONDER'),
(40, 'Rojy Thapa', 'rojythapa128@gmail.com', '$2y$10$VBs..PqoLnTZykYlpXkeIOxgmvKOSWQHoI11ZJWyTUlZ.Z4u7u4fe', 'RECEPTIONIST');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_reports`
--
ALTER TABLE `doctor_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fingerprint`
--
ALTER TABLE `fingerprint`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fresponder_form`
--
ALTER TABLE `fresponder_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fresponder_reports`
--
ALTER TABLE `fresponder_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `injuries`
--
ALTER TABLE `injuries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_details`
--
ALTER TABLE `patient_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Indexes for table `patient_injuries`
--
ALTER TABLE `patient_injuries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `desc_id` (`desc_id`),
  ADD KEY `injury_id` (`injury_id`);

--
-- Indexes for table `patient_injuries_desc`
--
ALTER TABLE `patient_injuries_desc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `retrieve_fingerprint`
--
ALTER TABLE `retrieve_fingerprint`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `doctor_reports`
--
ALTER TABLE `doctor_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `fingerprint`
--
ALTER TABLE `fingerprint`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `fresponder_form`
--
ALTER TABLE `fresponder_form`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fresponder_reports`
--
ALTER TABLE `fresponder_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `injuries`
--
ALTER TABLE `injuries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `patient_details`
--
ALTER TABLE `patient_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `patient_injuries`
--
ALTER TABLE `patient_injuries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `patient_injuries_desc`
--
ALTER TABLE `patient_injuries_desc`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `retrieve_fingerprint`
--
ALTER TABLE `retrieve_fingerprint`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `patient_injuries`
--
ALTER TABLE `patient_injuries`
  ADD CONSTRAINT `patient_injuries_ibfk_1` FOREIGN KEY (`desc_id`) REFERENCES `patient_injuries_desc` (`id`),
  ADD CONSTRAINT `patient_injuries_ibfk_2` FOREIGN KEY (`injury_id`) REFERENCES `injuries` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

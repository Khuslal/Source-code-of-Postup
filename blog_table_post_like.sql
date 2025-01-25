
-- --------------------------------------------------------

--
-- Table structure for table `post_like`
--
-- Creation: Jan 02, 2025 at 10:26 AM
--

DROP TABLE IF EXISTS `post_like`;
CREATE TABLE IF NOT EXISTS `post_like` (
  `like_id` int(11) NOT NULL AUTO_INCREMENT,
  `liked_by` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `liked_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`like_id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_like`
--

INSERT INTO `post_like` (`like_id`, `liked_by`, `post_id`, `liked_at`) VALUES
(61, 4, 14, '2023-07-21 19:04:18'),
(62, 4, 13, '2023-07-21 19:04:22'),
(63, 4, 12, '2023-07-21 19:04:24'),
(64, 2, 14, '2023-07-21 19:05:10'),
(66, 2, 12, '2023-07-21 19:05:47'),
(68, 2, 15, '2023-07-21 19:11:30'),
(69, 6, 15, '2023-07-21 19:17:00'),
(70, 6, 14, '2023-07-21 19:17:03');

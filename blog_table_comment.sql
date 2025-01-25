
-- --------------------------------------------------------

--
-- Table structure for table `comment`
--
-- Creation: Jan 02, 2025 at 10:25 AM
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `crated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `comment`, `user_id`, `post_id`, `crated_at`) VALUES
(21, 'good', 4, 14, '2023-07-21 19:04:30'),
(22, 'thanks', 4, 12, '2023-07-21 19:04:46'),
(23, 'new comment', 2, 14, '2023-07-21 19:05:16'),
(24, 'Nice', 2, 14, '2023-07-21 19:05:20'),
(25, 'thanks', 2, 12, '2023-07-21 19:05:56'),
(26, 'thanks', 2, 15, '2023-07-21 19:11:38');

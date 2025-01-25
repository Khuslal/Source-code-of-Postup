
-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Jan 02, 2025 at 04:49 PM
-- Last update: Jan 07, 2025 at 10:50 AM
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `bio` varchar(300) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `username`, `password`, `email`, `phone`, `bio`) VALUES
(7, 'Khuslal Gupta', 'admin', '$2y$10$tj5GtGxJVXljlCPmhlgXrOixM1iYjjehaT4NNxCAbYBy4I6MYsmzC', 'guptakhuslal@gmail.com', '9702546615', 'Jai Shree Ram!'),
(8, 'Parmi Thapa', 'parmi', '$2y$10$oG3oVA7vIxVDJXQC8FvgUegbtqaz6T9GGT5/jN6OeS1RFwOkegq.m', 'parmithapa@gmail.com', '9800000001', 'Pramisha Thapa Magar'),
(16, 'Khuslal Gupta', 'khush', '$2y$10$CeXY8Tb4vW5Ef4.PkuSNzO1r2LRIAufncDRXvJv1LbAvT3qRp.37u', 'guptakhuslal@gmail.com', '9702546615', ''),
(17, '', 'sagar', '$2y$10$X1VKrr9SiP/diSuvNphZ8O0tDNKvRKgyHM6lanFusYm7SzDSOW6WO', '', '', ''),
(18, '', 'asd', '$2y$10$00HwIFBQgp2TRjoaQN61p.mIE6142OdF7wxZQUcNrJGSSwyx5eE5G', '', '', ''),
(19, 'dads', 'dsa', '$2y$10$dCjDaLZbYKJ3m9mKXGzhg.jVxN9DDd2vT6mPYftXhwGOrjpZSMP2O', 'dsda@gmail.com', 'dfji', ''),
(20, 'Sandip Chhetri', 'asdf', '$2y$10$CieQ/XFlASMndv5DTm1Sc.dLyQCeRlA292uOlfDcHa2t46DQFZvDW', 'sandipchhetri@gmail.com', '9702541234', 'Sandip'),
(21, 'Sagar', 'gks', '$2y$10$MT9er57vOUupUgpPRjlc.O4CNuyiwlAJPa5oalbBQcn9Vnp8Iih.2', 'sagar@gmail.com', '9504234', '');

--
-- Triggers `users`
--
DROP TRIGGER IF EXISTS `after_user_delete_fname`;
DELIMITER $$
CREATE TRIGGER `after_user_delete_fname` AFTER DELETE ON `users` FOR EACH ROW BEGIN
    DELETE FROM post WHERE fname = OLD.fname;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `after_user_delete_username`;
DELIMITER $$
CREATE TRIGGER `after_user_delete_username` AFTER DELETE ON `users` FOR EACH ROW BEGIN
    DELETE FROM post WHERE username = OLD.username;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `after_user_update_fname`;
DELIMITER $$
CREATE TRIGGER `after_user_update_fname` AFTER UPDATE ON `users` FOR EACH ROW BEGIN
    IF OLD.fname <> NEW.fname THEN
        UPDATE post 
        SET fname = NEW.fname
        WHERE fname = OLD.fname;
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `after_user_update_username`;
DELIMITER $$
CREATE TRIGGER `after_user_update_username` AFTER UPDATE ON `users` FOR EACH ROW BEGIN
    IF OLD.username <> NEW.username THEN
        UPDATE post 
        SET username = NEW.username
        WHERE username = OLD.username;
    END IF;
END
$$
DELIMITER ;

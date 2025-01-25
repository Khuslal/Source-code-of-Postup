
-- --------------------------------------------------------

--
-- Table structure for table `post`
--
-- Creation: Jan 07, 2025 at 05:33 AM
-- Last update: Jan 07, 2025 at 10:39 AM
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_title` varchar(127) NOT NULL,
  `post_text` text NOT NULL,
  `category` varchar(150) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `username` varchar(255) DEFAULT NULL,
  `fname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`post_id`),
  KEY `fk_user` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `post_title`, `post_text`, `category`, `image_url`, `video_url`, `created_at`, `username`, `fname`) VALUES
(26, 'Premier League: Isak scores again as Newcastle defeats Spurs', 'BBC Sport, January 4 — Alexander Isak continued his magnificent scoring run as Newcastle came from behind to inflict another home defeat on Ange Postecoglou\'s Tottenham and stretch their winning run in all competitions to six matches.\r\n\r\nThe visitors came into Saturday\'s Premier League game in scintillating form but fell behind after just three minutes when Pedro Porro\'s in-swinging delivery was headed in by Dominic Solanke.\r\n\r\nHowever, Anthony Gordon restored parity two minutes later, firing low past Spurs\' debutant goalkeeper Brandon Austin into the far corner in front of watching England manager Thomas Tuchel.\r\n\r\nSpurs were adamant Joelinton should have been penalised for handball in the build-up to Gordon\'s goal, but the officials deemed that the contact with Lucas Bergvall\'s pass was accidental and that the Brazilian\'s arm was in a natural position.\r\n\r\nIsak dragged a Jacob Murphy cross off target shortly after the half-hour mark but made no mistake from a similar position moments later, slotting home after Radu Dragusin had deflected another Murphy delivery into his path.\r\n\r\nThe Swede becomes the third Newcastle player to score in seven consecutive Premier League matches, after Alan Shearer in 1996 and Joe Willock in 2021.\r\n\r\nTottenham improved after the break and almost equalised 10 minutes into the second half, but Brennan Johnson struck the woodwork from the tightest of angles after Martin Dubravka had kept out Pape Sarr\'s effort from outside the box.\r\n\r\nSecond-half substitute James Maddison curled an effort narrowly wide of the far post and Sergio Reguilon lashed a shot off target late on, but there was no way back for Spurs as Postecoglou\'s team slumped to a fifth home league defeat of the campaign.\r\n\r\n', 'sports news', 'uploads/67796aaf94774.webp', '', '2025-01-04 22:51:55', 'parmi', 'Parmi Thapa'),
(27, 'पाँच दिनदेखि बेपत्ता सर्लाहीका व्यवसायी प्रसाईंंको शव उखुबारीमा गाडेको भेटियो', 'सर्लाहीको हरिवनमा ६ दिनदेखि बेपत्ता एक पुरुषको हत्या गरेर गाडेको अवस्थामा शव फेला परेको छ।\r\nहरिवन नगरपालिका–१० निवासी ३९ वर्षीय हरिप्रसाद प्रसाईंको हत्या गरी उखुबारीमा गाडेको अवस्थामा आज शव फेला परेको प्रहरीले जनाएको छ।\r\n\r\nउखुबारीमा गाडेको अवस्थामा फेला परेको शवको टाउकोमा चोट देखिएको जिल्ला प्रहरी कार्यालयका प्रवक्ता एवं प्रहरी नायब उपरीक्षक दीपक श्रेष्ठले जानकारी दिए।', 'crime that revealed after 5 days', 'uploads/67796e58e81e5.jpg', '', '2025-01-04 23:07:32', 'admin', 'Sandip Chhetri'),
(28, 'South Korea’s Yoon: Embittered survivor facing unprecedented arrest', 'SEOUL, Jan 3 (Reuters) - South Korean President Yoon Suk Yeol faces the greatest threat to his brief but chequered political career as he struggles to thwart an unprecedented arrest attempt in a criminal probe alleging he led an insurrection.\r\nA tough political survivor who has become increasingly isolated halfway through his five-year term, Yoon, 64, has been dogged by personal scandals, an unyielding opposition and rifts within his own party', 'internation news', 'uploads/677a24d361328.jpg', '', '2025-01-05 12:06:07', 'admin', 'Sandip Chhetri'),
(52, 'Hello', 'web_test', 'Testing', '', '', '2025-01-07 16:24:42', 'asdf', NULL);

--
-- Triggers `post`
--
DROP TRIGGER IF EXISTS `before_post_insert_fname`;
DELIMITER $$
CREATE TRIGGER `before_post_insert_fname` BEFORE INSERT ON `post` FOR EACH ROW BEGIN
    SET NEW.fname = (SELECT u.fname FROM users u WHERE u.fname = NEW.fname LIMIT 1);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_post_insert_username`;
DELIMITER $$
CREATE TRIGGER `before_post_insert_username` BEFORE INSERT ON `post` FOR EACH ROW BEGIN
    SET NEW.username = (SELECT u.username FROM users u WHERE u.username = NEW.username LIMIT 1);
END
$$
DELIMITER ;

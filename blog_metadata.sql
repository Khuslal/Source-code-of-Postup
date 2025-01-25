
--
-- Indexes for dumped tables
--

--
-- Indexes for table `post`
--
ALTER TABLE `post` ADD FULLTEXT KEY `category` (`category`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

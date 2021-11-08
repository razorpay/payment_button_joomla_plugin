CREATE TABLE IF NOT EXISTS `user_auth` (
  `id` int(11) NOT NULL COMMENT 'user auth id',
  `user_id` varchar(50) NOT NULL,
  `key_id` varchar(50) NOT NULL,
  `key_secret` varchar(50) NOT NULL,

  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `user_auth` (`id`, `user_id`, `key_id`, `key_secret`) VALUES
(1, '1', 'rzp_test_ity0GEP8f37S7v', 'SM3wHN1c4WFs9eRGY7EpTNvY');
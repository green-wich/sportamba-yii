INSERT INTO `sport_user` (`id`, `role`, `status`) VALUES
(1, 'admin', 1);

INSERT INTO `sport_login` (`id`, `user_id`, `username`, `password`, `session_data`, `created_at`, `provider`) VALUES
(1, 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '', '2014-03-31 00:00:00', '');

INSERT INTO `sport_user_profile` (`id`, `login_id`, `profileUrl`, `photoUrl`, `displayName`, `firstName`, `lastName`, `gender`, `region`, `email`) VALUES
(1, 1, '', '', '', 'admin', '', '', NULL, NULL);


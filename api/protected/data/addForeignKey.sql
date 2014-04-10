ALTER TABLE `sport_user_news`
  ADD CONSTRAINT `fkn_user_id` FOREIGN KEY (`user_id`) REFERENCES `sport_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_news_id` FOREIGN KEY (`news_id`) REFERENCES `sport_news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `sport_connection`
  ADD CONSTRAINT `fk_user_id_1` FOREIGN KEY (`user_id_1`) REFERENCES `sport_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_id_2` FOREIGN KEY (`user_id_2`) REFERENCES `sport_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `sport_user_match`
  ADD CONSTRAINT `fk_match_id` FOREIGN KEY (`match_id`) REFERENCES `sport_match` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `sport_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_command_id` FOREIGN KEY (`command_id`) REFERENCES `sport_command` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `sport_match`
  ADD CONSTRAINT `fk_id_command_1` FOREIGN KEY (`id_command_1`) REFERENCES `sport_command` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_command_2` FOREIGN KEY (`id_command_2`) REFERENCES `sport_command` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stadion_id` FOREIGN KEY (`stadion_id`) REFERENCES `sport_stadion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `sport_user_profile`
  ADD CONSTRAINT `ifk_login_id` FOREIGN KEY (`login_id`) REFERENCES `sport_login` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `sport_login`
  ADD CONSTRAINT `ifk_user_id` FOREIGN KEY (`user_id`) REFERENCES `sport_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;



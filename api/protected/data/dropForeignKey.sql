ALTER TABLE `sport_match`        DROP FOREIGN KEY `fk_id_command_1`;
ALTER TABLE `sport_match`        DROP KEY         `fk_id_command_1`;
ALTER TABLE `sport_match`        DROP FOREIGN KEY `fk_id_command_2`;
ALTER TABLE `sport_match`        DROP KEY         `fk_id_command_2`;
ALTER TABLE `sport_match`        DROP FOREIGN KEY `fk_stadion_id`;
ALTER TABLE `sport_match`        DROP KEY         `fk_stadion_id`;

ALTER TABLE `sport_login`        DROP FOREIGN KEY `ifk_user_id`;
ALTER TABLE `sport_login`        DROP KEY         `ifk_user_id`;

ALTER TABLE `sport_user_profile` DROP FOREIGN KEY `ifk_login_id`;
ALTER TABLE `sport_user_profile` DROP KEY         `ifk_login_id`;
  
ALTER TABLE `sport_user_match`   DROP FOREIGN KEY `fk_match_id`;
ALTER TABLE `sport_user_match`   DROP KEY         `fk_match_id`;
ALTER TABLE `sport_user_match`   DROP FOREIGN KEY `fk_user_id`;
ALTER TABLE `sport_user_match`   DROP KEY         `fk_user_id`;
ALTER TABLE `sport_user_match`   DROP FOREIGN KEY `fk_command_id`;
ALTER TABLE `sport_user_match`   DROP KEY         `fk_command_id`;

ALTER TABLE `sport_connection`   DROP FOREIGN KEY `fk_user_id_1`;  
ALTER TABLE `sport_connection`   DROP KEY         `fk_user_id_1`;
ALTER TABLE `sport_connection`   DROP FOREIGN KEY `fk_user_id_2`;
ALTER TABLE `sport_connection`   DROP KEY         `fk_user_id_2`;

ALTER TABLE `sport_user_news`    DROP FOREIGN KEY  `fk_news_id`;  
ALTER TABLE `sport_user_news`    DROP KEY          `fk_news_id`;
ALTER TABLE `sport_user_news`    DROP FOREIGN KEY  `fkn_user_id`;  
ALTER TABLE `sport_user_news`    DROP KEY          `fkn_user_id`;

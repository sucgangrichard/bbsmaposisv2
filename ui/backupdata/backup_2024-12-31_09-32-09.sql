

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `userpassword` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL,
  `logintime` datetime NOT NULL,
  `logout` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_user VALUES("1","admin","admin","Admin","2024-12-31 16:17:34","2024-12-30 16:34:19");
INSERT INTO tbl_user VALUES("2","user","user","User","2024-12-26 16:03:48","2024-12-31 16:17:30");


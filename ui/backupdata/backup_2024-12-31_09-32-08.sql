

CREATE TABLE `tbl_taxdis` (
  `taxdis_id` int(11) NOT NULL AUTO_INCREMENT,
  `vat` float NOT NULL,
  `seniordiscount` float NOT NULL,
  PRIMARY KEY (`taxdis_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_taxdis VALUES("1","12","20");


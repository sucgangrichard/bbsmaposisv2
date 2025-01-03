

CREATE TABLE `tbl_invoice` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `total_due` double NOT NULL,
  `change_amount` double NOT NULL,
  `paid` double NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `vatable_sales` double NOT NULL,
  `vat_amount` double NOT NULL,
  `order_date` date NOT NULL,
  `table_number` int(11) NOT NULL,
  `dine_in` varchar(255) NOT NULL,
  `menu_category` varchar(255) NOT NULL,
  `time_value` time NOT NULL,
  PRIMARY KEY (`invoice_id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_invoice VALUES("59","450","50","500","Cash","401.79","48.21","2024-12-26","50","Dine In","NULL","18:24:55");
INSERT INTO tbl_invoice VALUES("60","763","37","800","Cash","681.25","81.75","2024-12-27","60","Take Out","NULL","18:25:11");
INSERT INTO tbl_invoice VALUES("61","4410","590","5000","Cash","3937.5","472.5","2024-12-27","45","Dine In","NULL","16:25:53");
INSERT INTO tbl_invoice VALUES("62","61","39","100","Cash","54.46","6.54","2024-12-28","61","Take Out","NULL","01:55:38");
INSERT INTO tbl_invoice VALUES("63","475","25","500","Cash","424.11","50.89","2024-12-28","47","Dine In","NULL","01:56:15");
INSERT INTO tbl_invoice VALUES("64","1805","195","2000","Cash","1611.61","193.39","2024-12-28","20","Take Out","NULL","02:29:41");
INSERT INTO tbl_invoice VALUES("65","4246","754","5000","Cash","3791.07","454.93","2024-12-28","70","Dine In","NULL","02:32:49");
INSERT INTO tbl_invoice VALUES("66","1078","922","2000","Cash","962.5","115.5","2024-12-29","23","Dine In","NULL","14:16:51");
INSERT INTO tbl_invoice VALUES("67","1594","406","2000","Cash","1423.21","170.79","2024-12-30","45","Take Out","NULL","16:26:23");
INSERT INTO tbl_invoice VALUES("68","340","-320","20","Cash","303.57","36.43","2024-12-30","45","Dine In","NULL","16:52:26");



CREATE TABLE `tbl_invoice_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `qty` double NOT NULL,
  `total_per_qty` double NOT NULL,
  `table_number` int(11) NOT NULL,
  `dine_in` varchar(255) NOT NULL,
  `menu_category` varchar(255) NOT NULL,
  `order_date` date NOT NULL,
  `time_value` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=285 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_invoice_details VALUES("255","59","91","IMPERIAL CHICKEN CHOP WITH EGG FRIED RICE","1","98","50","NULL","NULL","2024-12-26","18:24:55");
INSERT INTO tbl_invoice_details VALUES("256","59","130","SWEET & SOUR FISH LAURIAT","1","243","50","NULL","NULL","2024-12-26","18:24:55");
INSERT INTO tbl_invoice_details VALUES("257","59","138","LYCHEE FRUIT TEA WITH JELLY","1","109","50","NULL","NULL","2024-12-26","18:24:55");
INSERT INTO tbl_invoice_details VALUES("265","60","48","CHAO FAN WITH 2pc FRIED CHICKEN","1","231","60","NULL","NULL","2024-12-27","00:00:00");
INSERT INTO tbl_invoice_details VALUES("266","60","129","SWEET & SOUR CHICKEN LAURIAT","1","237","60","NULL","NULL","2024-12-27","00:00:00");
INSERT INTO tbl_invoice_details VALUES("267","60","133","BREAKFAST BEEF CHAO FAN","1","131","60","NULL","NULL","2024-12-27","00:00:00");
INSERT INTO tbl_invoice_details VALUES("268","60","90","CHIX & SAUCE RICE MEAL","1","164","60","NULL","NULL","2024-12-27","00:00:00");
INSERT INTO tbl_invoice_details VALUES("269","61","46","BEEF CHAO FAN","45","4410","45","NULL","NULL","2024-12-27","16:25:53");
INSERT INTO tbl_invoice_details VALUES("270","62","77","2PC SIOMAI","1","44","61","NULL","NULL","2024-12-28","01:55:38");
INSERT INTO tbl_invoice_details VALUES("271","62","119","ASIAN SPICY SAUCE","1","17","61","NULL","NULL","2024-12-28","01:55:38");
INSERT INTO tbl_invoice_details VALUES("272","63","78","3PC SIOPAO BOX","1","162","47","NULL","NULL","2024-12-28","01:56:15");
INSERT INTO tbl_invoice_details VALUES("273","63","138","LYCHEE FRUIT TEA WITH JELLY","1","109","47","NULL","NULL","2024-12-28","01:56:15");
INSERT INTO tbl_invoice_details VALUES("274","63","119","ASIAN SPICY SAUCE","1","17","47","NULL","NULL","2024-12-28","01:56:15");
INSERT INTO tbl_invoice_details VALUES("275","63","134","BREAKFAST CRISPY WONTON BEEF CHAO FAN","1","187","47","NULL","NULL","2024-12-28","01:56:15");
INSERT INTO tbl_invoice_details VALUES("276","64","91","IMPERIAL CHICKEN CHOP WITH EGG FRIED RICE","5","490","20","NULL","NULL","2024-12-28","02:29:41");
INSERT INTO tbl_invoice_details VALUES("277","64","139","MILKSHA PERFECT PAIR good for 2","5","1315","20","NULL","NULL","2024-12-28","02:29:41");
INSERT INTO tbl_invoice_details VALUES("278","65","39","BEEF MAMI","22","4246","70","NULL","NULL","2024-12-28","02:32:49");
INSERT INTO tbl_invoice_details VALUES("279","66","46","BEEF CHAO FAN","11","1078","23","NULL","NULL","2024-12-29","14:16:51");
INSERT INTO tbl_invoice_details VALUES("280","67","136","BLACK TEA LATTE WITH PUDDING","1","132","45","NULL","NULL","2024-12-30","16:26:23");
INSERT INTO tbl_invoice_details VALUES("281","67","134","BREAKFAST CRISPY WONTON BEEF CHAO FAN","7","1309","45","NULL","NULL","2024-12-30","16:26:23");
INSERT INTO tbl_invoice_details VALUES("282","67","126","WONTON SOUP","1","55","45","NULL","NULL","2024-12-30","16:26:23");
INSERT INTO tbl_invoice_details VALUES("283","67","91","IMPERIAL CHICKEN CHOP WITH EGG FRIED RICE","1","98","45","NULL","NULL","2024-12-30","16:26:23");
INSERT INTO tbl_invoice_details VALUES("284","68","119","ASIAN SPICY SAUCE","20","340","45","NULL","NULL","2024-12-30","16:52:26");



CREATE TABLE `tbl_menu_category` (
  `menu_cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`menu_cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_menu_category VALUES("10","Noodles Soup");
INSERT INTO tbl_menu_category VALUES("11","Chao Fan");
INSERT INTO tbl_menu_category VALUES("12","Drinks");
INSERT INTO tbl_menu_category VALUES("13","Siopao Dimsum");
INSERT INTO tbl_menu_category VALUES("14","Rice Meals");
INSERT INTO tbl_menu_category VALUES("15","Lauriat Family");
INSERT INTO tbl_menu_category VALUES("16","MilkSha");
INSERT INTO tbl_menu_category VALUES("17","BreakFast");
INSERT INTO tbl_menu_category VALUES("18","Sdish Dessert");


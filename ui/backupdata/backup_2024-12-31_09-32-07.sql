

CREATE TABLE `tbl_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `expiration_date` date NOT NULL,
  `date_of_receipt` date NOT NULL,
  `received_by` varchar(255) NOT NULL,
  `condition_at_receipt` varchar(255) NOT NULL,
  `packaging_type` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_product VALUES("8","NULL","50096610","Product 2","15","Dry","Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.    ","2024-12-31","2024-12-21","Ms. Norhanah","NULL","Cartons","67669a5c3d08f.jpg");
INSERT INTO tbl_product VALUES("9","NULL","17784196","Product 3","15","Freezer","Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.        ","2024-12-31","2024-12-21","Ms. Jade","NULL","Cans","67669aa712001.jpg");


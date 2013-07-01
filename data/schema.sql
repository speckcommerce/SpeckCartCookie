--
-- Table structure for table `cart_cookie`
--

CREATE TABLE IF NOT EXISTS `cart_cookie` (
  `cart_verifier` varchar(32) NOT NULL,
  `cart_id` int(11) NOT NULL,
  PRIMARY KEY (`cartVerifier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `cart_cookie` ADD INDEX (`cart_id`)
ALTER TABLE `cart_cookie` ADD FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE CASCADE ON UPDATE CASCADE ;
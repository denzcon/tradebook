-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 22, 2012 at 10:07 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tradebook`
--

-- --------------------------------------------------------

--
-- Table structure for table `collection`
--

CREATE TABLE IF NOT EXISTS `collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `collection`
--

INSERT INTO `collection` (`id`, `description`) VALUES
(1, 'Administrator top level'),
(2, 'Moderator'),
(3, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE IF NOT EXISTS `package` (
  `package_id` int(11) NOT NULL AUTO_INCREMENT,
  `wanted_id` int(11) NOT NULL,
  PRIMARY KEY (`package_id`),
  UNIQUE KEY `package_id` (`package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `package`
--


-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_name`) VALUES
(1, 'PSD to XHTML Conversion'),
(2, 'Logo Design'),
(3, 'Photoshop Design Comp');

-- --------------------------------------------------------

--
-- Table structure for table `user2collection`
--

CREATE TABLE IF NOT EXISTS `user2collection` (
  `user_id` int(11) NOT NULL,
  `collection_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user2collection`
--

INSERT INTO `user2collection` (`user_id`, `collection_id`) VALUES
(2, 1),
(2, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user2services`
--

CREATE TABLE IF NOT EXISTS `user2services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user2services`
--

INSERT INTO `user2services` (`id`, `user_id`, `service_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user2wants`
--

CREATE TABLE IF NOT EXISTS `user2wants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `want_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `user2wants`
--

INSERT INTO `user2wants` (`id`, `user_id`, `want_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 4, 6),
(6, 4, 7),
(7, 4, 8),
(8, 4, 9),
(9, 4, 10),
(10, 4, 11),
(11, 4, 12),
(12, 6, 13),
(13, 6, 14),
(14, 6, 15),
(15, 6, 16),
(16, 10, 17);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `email_address`) VALUES
(1, 'jdconoley', 'fe798b3eab75ccf1e77611e7ae17141b', 'Jonathan', 'Conoley', 'jdconoley@gmail.com'),
(2, 'Admin', 'fe798b3eab75ccf1e77611e7ae17141b', 'Jonathanbro', 'Conoley', 'jdconoley@gmail.com'),
(3, 'abayaua', '78f84361be478cf2d0829de20476db50', 'Allan', 'Bayaua', 'abayaua@gmail.com'),
(4, 'Abe', 'ad5187004da1488d61a8a0e358f5b4a7', 'Abraham', 'Conoley', 'ajconoley@gmail.com'),
(5, 'joelconoley', 'fe798b3eab75ccf1e77611e7ae17141b', 'Joel', 'Conoley', 'joel.conoley@gmail.com'),
(6, 'ElijahProto', '620ec9d8f8abe58709b8f4304df472b0', 'Elijah', 'Conoley', 'elijahproto@gmail.com'),
(10, 'Niccole', 'abc9936295cffbdb466221e0bf77255b', 'Niccole', 'Conoley', 'niccoleconoley@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users2xp`
--

CREATE TABLE IF NOT EXISTS `users2xp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `xp_value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users2xp`
--

INSERT INTO `users2xp` (`id`, `user_id`, `xp_value`) VALUES
(1, 1, 398),
(2, 4, 129),
(3, 5, 64),
(4, 6, 115),
(5, 10, 22);

-- --------------------------------------------------------

--
-- Table structure for table `user_avatars`
--

CREATE TABLE IF NOT EXISTS `user_avatars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `avatar_image_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_avatars`
--

INSERT INTO `user_avatars` (`id`, `user_id`, `avatar_image_url`) VALUES
(1, 1, 'http://users.cecs.anu.edu.au/~gmcintyr/img/gravatar-leaf.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `wanted`
--

CREATE TABLE IF NOT EXISTS `wanted` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `price` varchar(28) NOT NULL,
  `description` text,
  `preview_image` text NOT NULL,
  `url` varchar(128) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(12) NOT NULL,
  `google_id` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `wanted`
--

INSERT INTO `wanted` (`id`, `title`, `price`, `description`, `preview_image`, `url`, `quantity`, `status`, `google_id`) VALUES
(1, '27in iMac Quad-Core Intel Core i7 3.4GHz, 4GB RAM, 1TB Hard Drive, AMD', '2169.99', NULL, 'http://i2.cc-inc.com/prod/8537000/8537286_xlg.jpg', 'http://www.macmall.com/macmall/shop/detail.asp?source=MWBGOOGLEBASE&dpno=8537286', 1, 'a', ''),
(2, 'Polk Audio PSW10 10-Inch Monitor Series Powered Subwoofer (Single,', '129.99', NULL, 'http://c.shld.net/rpx/i/s/pi/mp/4171/6164266401p?src=http://www.rover-store.com/sears/747192118211.jpg', 'http://www.sears.com/shc/s/p_10153_12605_SP101A15936S6467233207P?sid=IDx20070921x00003a&ci_src=14110944&ci_sku=SPM6164266401', 1, 'd', ''),
(3, 'Abec 11 Abec 11 Flywheels 97mm 81a Longboard Wheels Set Of 4', '89.95', NULL, 'http://ecx.images-amazon.com/images/I/41zD7ooQunL.jpg?gdapi', 'http://tgm-skateboards.amazonwebstore.com/Abec-11-Flywheels-97mm-81a-Longboard/M/B002UZT0SQ.htm?traffic_src=froogle&utm_medium=C', 1, 'a', ''),
(4, 'Apple iPAD MC705LL/A iPad 3 with Wi-Fi 16GB - Black No Tax Outside NC', '499.00', NULL, 'http://www.avalive.com/pimages/pimage_165744.jpg', 'http://www.avalive.com/Apple-iPAD/MC705LL-A/165744/productDetail.php?utm_source=googleBase&utm_medium=feed&utm_content=MC705LL-A', 1, '', ''),
(5, 'Apple iPad with Wi-Fi 64GB - Black (3rd generation)', '699.00', NULL, 'http://store.storeimages.cdn-apple.com/2661/as-images.apple.com/is/image/AppleInc/IPAD2012-BLACK?wid=600', 'http://store.apple.com/us/xc/ipad?aosid=p228&cid=AOS-US-CSE-Google&site=Google', 1, '', '10204183048289872663'),
(6, 'Sony - Playstation 3 (160gb)', '249.99', NULL, 'http://images.bestbuy.com:80/BestBuy_US/images/products/3061/3061302_rc.jpg', 'http://www.bestbuy.com/site/Sony+-+PlayStation+3+(160GB)/3061302.p?id=1218379530906&skuId=3061302', 1, '', '9176580211084564623'),
(7, 'Minecraft Xbla: Digital - Xbox 360 [digital Download]', '19.99', NULL, 'http://images.bestbuy.com:80/BestBuy_US/images/products/00/002/1000002489_pr5.png', 'http://www.bestbuy.com/site/Minecraft+Xbla%3A+Digital+-+Xbox+360+%5BDigital+Download%5D/1000002489.p?id=1000002488&skuId=1000002', 1, '', '5486195857682506844'),
(8, 'Sony - Playstation 3 (160gb)', '249.99', NULL, 'http://images.bestbuy.com:80/BestBuy_US/images/products/3061/3061302_rc.jpg', 'http://www.bestbuy.com/site/Sony+-+PlayStation+3+(160GB)/3061302.p?id=1218379530906&skuId=3061302', 1, 'a', '9176580211084564623'),
(9, 'Minecraft Xbla: Digital - Xbox 360 [digital Download]', '19.99', NULL, 'http://images.bestbuy.com:80/BestBuy_US/images/products/00/002/1000002489_pr5.png', 'http://www.bestbuy.com/site/Minecraft+Xbla%3A+Digital+-+Xbox+360+%5BDigital+Download%5D/1000002489.p?id=1000002488&skuId=1000002', 1, 'a', '5486195857682506844'),
(10, 'Original Apex 40 Carbon Middleweight Double Concave Longboard Deck', '218.95', NULL, 'http://www.blackdiamondsports.com/v/vspfiles/photos/DKCAPEX40C-2T.jpg', 'http://www.blackdiamondsports.com/original%20apex%2040%20longboard%20deck_p/DKCAPEX40C.htm?gdftrk=gdfV21965_a_7c340_a_7c4159_a_7', 1, 'a', '16723351208215140263'),
(11, 'Apple 27" iMac Desktop Computer MC814LL/A', '1879.95', NULL, 'http://www.bhphotovideo.com/images/images345x345/767562.jpg', 'http://www.bhphotovideo.com/c/product/767562-REG/Apple_MC814LL_A_27_iMac_Desktop_Computer.html/BI/8612/kw/APIM3122127/%60', 1, 'a', '7929048372434262011'),
(12, 'Hukilau Classic 57 Wood Longboard and Pohaku Big Stick', '359.95', NULL, 'http://dyn-images.hsn.com/is/image/HomeShoppingNetwork/6805263w?$pd500$', 'http://www.hsn.com/redirect.aspx?pfid=1121714&sz=3&sf=HF0169&ac=INCHF0169&cm_mmc=Shopping%20Engine-_-Froogle-_-Health-_-1121714&', 1, 'a', '5372698754362865826'),
(13, 'Apple Imac 27" Mc814lla 3.1Ghz I5 4Gb Ram 1Tb7k Hdd', '1999.00', NULL, 'http://static.musiciansfriend.com/derivates/18/001/588/219/DV016_Jpg_Large_H74823_front.jpg', 'http://www.musiciansfriend.com/pro-audio/apple-imac-27-mc814lla-3.1ghz-i5-4gb-ram-1tb7k-hdd/h74823000000000?src=3WFRWXX&CAWELAID', 1, 'a', '2291646086541336911'),
(14, 'Hukilau Classic 57 Wood Longboard and Pohaku Big Stick', '359.95', NULL, 'http://dyn-images.hsn.com/is/image/HomeShoppingNetwork/6805263w?$pd500$', 'http://www.hsn.com/redirect.aspx?pfid=1121714&sz=3&sf=HF0169&ac=INCHF0169&cm_mmc=Shopping%20Engine-_-Froogle-_-Health-_-1121714&', 1, 'a', '5372698754362865826'),
(15, 'Sony - Playstation 3 (160gb)', '249.99', NULL, 'http://images.bestbuy.com:80/BestBuy_US/images/products/3061/3061302_rc.jpg', 'http://www.bestbuy.com/site/Sony+-+PlayStation+3+(160GB)/3061302.p?id=1218379530906&skuId=3061302', 1, 'a', '9176580211084564623'),
(16, 'Call of Duty: Modern Warfare 3 PlayStation 3 Game', '64.99', NULL, 'http://images.shopnbc.com/is/image/ShopNBC/422-656.jpg', 'http://www.shopnbc.com/offer/?offercode=422-656&rap=3505&chid=ciGB&ci_src=14110944&ci_sku=422-656', 1, 'a', '13878291281724157077'),
(17, 'Bermingham Traditional Warm Brown Finish Canopy California King Bed', '986.63', NULL, 'http://www.the-furniture-authority.com/v/vspfiles/photos/8890-6BA8-31B6-2187-86A-2T.jpg', 'http://www.the-furniture-authority.com/1418K-1CK-from-Homelegance-p/8890-6BA8-31B6-2187-86A.htm', 1, 'a', '4566872435188633527');

-- --------------------------------------------------------

--
-- Table structure for table `wants2services`
--

CREATE TABLE IF NOT EXISTS `wants2services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `want_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `wants2services`
--


-- --------------------------------------------------------

--
-- Table structure for table `wants2xp`
--

CREATE TABLE IF NOT EXISTS `wants2xp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wanted_id` int(11) NOT NULL,
  `xp_value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `wants2xp`
--

INSERT INTO `wants2xp` (`id`, `wanted_id`, `xp_value`) VALUES
(1, 1, 15190),
(2, 2, 910),
(3, 3, 630),
(4, 4, 3493),
(5, 6, 1750),
(6, 7, 140),
(7, 8, 1750),
(8, 9, 140),
(9, 10, 1533),
(10, 11, 13160),
(11, 12, 2520),
(12, 13, 13993),
(13, 14, 2520),
(14, 15, 1750),
(15, 16, 455),
(16, 17, 6906);

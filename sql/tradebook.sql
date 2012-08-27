-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 27, 2012 at 10:00 AM
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
-- Table structure for table `account_links`
--

CREATE TABLE IF NOT EXISTS `account_links` (
  `user_id_alpha` int(11) NOT NULL,
  `user_id_bravo` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `unq` (`user_id_alpha`,`user_id_bravo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_links`
--

INSERT INTO `account_links` (`user_id_alpha`, `user_id_bravo`, `status`, `last_modified`) VALUES
(1, 6, 1, '2012-08-05 19:05:47');

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
  `user_id` int(11) NOT NULL,
  `package_name` varchar(128) NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`package_id`),
  UNIQUE KEY `package_id` (`package_id`),
  UNIQUE KEY `user_id` (`user_id`,`package_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`package_id`, `user_id`, `package_name`, `date_modified`) VALUES
(2, 1, 'Prevost', '2012-08-26 13:04:36'),
(6, 1, 'Prevostas', '2012-08-26 13:42:03'),
(8, 1, 'Prevosts', '2012-08-26 13:42:34');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_name`) VALUES
(1, 'PSD to XHTML Conversion'),
(2, 'Logo Design'),
(3, 'Photoshop Design Comp'),
(4, 'Math'),
(5, 'Language Arts'),
(6, 'Good behavior report'),
(7, 'Good Appetite'),
(8, 'Good eating habbits');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

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
(16, 10, 17),
(17, 6, 18),
(18, 4, 19),
(19, 11, 20),
(20, 6, 21),
(21, 6, 22),
(22, 6, 23),
(23, 6, 24),
(24, 6, 25),
(25, 6, 26),
(26, 6, 27),
(27, 6, 28),
(28, 6, 29),
(29, 6, 30),
(30, 4, 31),
(31, 4, 32),
(32, 6, 33),
(33, 4, 34),
(34, 1, 35),
(35, 6, 36),
(36, 6, 37),
(37, 6, 38);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `email_address`) VALUES
(1, 'jdconoley', 'fe798b3eab75ccf1e77611e7ae17141b', 'Jonathan', 'Conoley', 'jdconoley@gmail.com'),
(2, 'Admin', 'fe798b3eab75ccf1e77611e7ae17141b', 'Jonathanbro', 'Conoley', 'jdconoley@gmail.com'),
(4, 'Abe', 'ad5187004da1488d61a8a0e358f5b4a7', 'Abraham', 'Conoley', 'ajconoley@gmail.com'),
(5, 'joelconoley', 'fe798b3eab75ccf1e77611e7ae17141b', 'Joel', 'Conoley', 'joel.conoley@gmail.com'),
(6, 'ElijahProto', '620ec9d8f8abe58709b8f4304df472b0', 'Elijah', 'Conoley', 'elijahproto@gmail.com'),
(10, 'Niccole', 'abc9936295cffbdb466221e0bf77255b', 'Niccole', 'Conoley', 'niccoleconoley@gmail.com'),
(11, 'abayaua', '78f84361be478cf2d0829de20476db50', 'Allan', 'Bayaua', 'abayaua@gmail.com'),
(12, 'johnny', 'f4eb27cea7255cea4d1ffabf593372e8', 'Johnny', 'Conoley', 'jdconoley@twiniverse.com'),
(13, 'johnny', 'f4eb27cea7255cea4d1ffabf593372e8', 'Johnny', 'Conoley', 'jdconoley@twiniverse.com');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `users2xp`
--

INSERT INTO `users2xp` (`id`, `user_id`, `xp_value`) VALUES
(1, 1, 398),
(2, 4, 153),
(3, 5, 64),
(4, 6, 208),
(5, 10, 22),
(6, 11, 1387),
(7, 12, 15),
(8, 13, 15);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

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
(17, 'Bermingham Traditional Warm Brown Finish Canopy California King Bed', '986.63', NULL, 'http://www.the-furniture-authority.com/v/vspfiles/photos/8890-6BA8-31B6-2187-86A-2T.jpg', 'http://www.the-furniture-authority.com/1418K-1CK-from-Homelegance-p/8890-6BA8-31B6-2187-86A.htm', 1, 'a', '4566872435188633527'),
(18, 'PS3 - Far Cry 3', '52.98', NULL, 'http://ak1.ostkcdn.com/images/products/L14143719.jpg', 'http://www.overstock.com/Books-Movies-Music-Games/PS3-Far-Cry-3/6566315/product.html?cid=123620', 1, 'a', '3694623570574951950'),
(19, 'Apple 21.5" iMac Desktop Computer MC812LL/A', '1399.00', NULL, 'http://www.bhphotovideo.com/images/images345x345/767559.jpg', 'http://www.bhphotovideo.com/c/product/767559-REG/Apple_MC812LL_A_21_5_iMac_Desktop_Computer.html/BI/8612/kw/APIM2722121/%60', 1, 'a', '7699512431996025836'),
(20, 'Apple iPad with wi-fi 16GB - White (3rd generation)', '499.00', NULL, 'http://store.storeimages.cdn-apple.com/2661/as-images.apple.com/is/image/AppleInc/IPAD2012-BLACK?wid=600', 'http://store.apple.com/us/xc/ipad?aosid=p228&cid=AOS-US-CSE-Google&site=Google', 1, 'a', '15017350025478534895'),
(21, 'Assassin''s Creed: Brotherhood ...', '29.99', NULL, 'http://ak.buy.com/PI/0/500/216495686.jpg', 'http://clickfrom.buy.com/default.asp?adid=17379&sURL=http%3A%2F%2Fwww.buy.com/prod/assassin-s-creed-brotherhood/216495686.html%3', 1, 'a', '9370551368345793595'),
(22, 'Ozark Trail 10-Person 3-Room XL Camping Tent, 20'' x 11''', '139.00', NULL, 'http://i.walmartimages.com/i/p/00/89/74/54/00/0089745400107_500X500.jpg', 'http://www.walmart.com/ip/Ozark-Trail-10-Person-3-Room-XL-Camping-Tent-20-x-11/16386306?ci_src=14110944&ci_sku=16386306&sourceid', 1, 'a', '3141696901449393544'),
(23, 'Portal 2 PC Game EA', '17.99', NULL, 'http://images10.newegg.com/NeweggImage/productimage/32-130-261-02.jpg', 'http://www.newegg.com/Product/Product.aspx?Item=N82E16832130261&nm_mc=OTC-FroogleNEW&cm_mmc=OTC-FroogleNEW-_-Software+-+PC+Games', 1, 'a', '2028997815642479463'),
(24, 'Heckler Koch G36c Black Airsoft Gun', '119.99', NULL, 'http://images.cabelas.com/is/image/cabelas/s7_230485_999_01', 'http://www.cabelas.com/soft-air-guns-accessories-h-k-g36c-black.shtml?WT.tsrc=CSE&WT.mc_id=GoogleBaseUSA&WT.z_mc_id1=03107217&ri', 1, 'a', '8374997523726421582'),
(25, 'Atom 50 Pintail Longboard', '99.99', NULL, 'http://tsa.imageg.net/graphics/product_images/p11122849dt.jpg', 'http://www.sportsauthority.com/entry.point?entry=12018106&source=CSE_GPS:12018106&mr:trackingCode=55D4757A-292D-E111-B2D2-001B21', 1, 'a', '9244403388203265016'),
(26, 'Minecraft Three Creeper Moon Men''s T-Shirt', '23.99', NULL, 'http://c.shld.net/rpx/i/s/pi/mp/12702/5873060903p?src=http://www.kryptonitekollectibles.com/images/prod/jinxmc3creepertee.jpg', 'http://www.sears.com/shc/s/p_10153_12605_00000000000000012702000jinxmc3creeperteeP?sid=IDx20070921x00003a&ci_src=14110944&ci_sku', 1, 'a', '13279587286010735760'),
(27, 'Call of Duty: Black Ops PC Game Steam', '23.98', NULL, 'http://img.fw1.biz/origin/123698/call-of-duty-black-ops-cover.jpg', 'http://www.kumbaso.com/index.aspx?pageid=1149137&prodid=5434251&currency=USD', 1, 'a', '16758169430472201631'),
(28, 'Saints Row: The Third [PC Game] STEAM RETAIL CD-KEY', '15.59', NULL, 'http://img.fw1.biz/origin/123698/saints-row-the-third_pc_cover.jpg', 'http://www.kumbaso.com/index.aspx?pageid=1149137&prodid=5268778&currency=USD', 1, 'a', '7632416885890486227'),
(29, 'Spec OPS : The Line - PlayStation 3', '59.96', NULL, 'http://images.frys.com/art/product/box_shots/6176309.box.GIF', 'http://www.frys.com/product/6176309?source=googleps', 1, 'a', '11640537115375397911'),
(30, 'Just Cause 2 (PC)', '14.99', NULL, 'http://www.microcenter.com/images/shared/products/0293851_988626.jpg', 'http://www.microcenter.com/single_product_results.phtml?product_id=0293851', 1, 'a', '13736590139489510732'),
(31, 'Spec OPS : The Line - PlayStation 3', '59.96', NULL, 'http://images.frys.com/art/product/box_shots/6176309.box.GIF', 'http://www.frys.com/product/6176309?source=googleps', 1, 'a', '11640537115375397911'),
(32, 'Minecraft Creeper T-shirt Video-game Shirts Kids And Adult Sizes', '18.00', NULL, 'http://i.ebayimg.com/00/s/OTYzWDY1NA==/$(KGrHqV,!hcE7VK6Dh9NBO2Fl8puYQ~~60_1.JPG?set_id=880000500F', 'http://rover.ebay.com/rover/1/711-67261-24966-0/2?ipn=psmain&icep_vectorid=263602&mtid=691&kwid=1&crlp=1_263602&icep_item_id=160', 1, 'a', '16253511691712450405'),
(33, 'Halo PC 1.0', '23.08', NULL, 'http://c.shld.net/rpx/i/s/pi/mp/3793/5055261001p?src=http://www.cp63.com/Images/images_prodLarge_MSCD46618WI.jpg', 'http://www.sears.com/shc/s/p_10153_12605_SPM5055261001P?sid=IDx20101019x00001a&ci_src=184425893&ci_sku=SPM5055261001', 1, 'a', '13991939603504287861'),
(34, 'Acer 11.6" AO722-0022 Laptop PC with AMD Fusion C-60 Dual-Core', '365.99', NULL, 'http://i.walmartimages.com/i/p/00/88/65/41/22/0088654122168_500X500.jpg', 'http://www.walmart.com/ip/Acer-11.6-AO722-0022-Laptop-PC-with-AMD-Fusion-C-60-Dual-Core-Processor-and-Windows-7-Home-Premium/178', 1, 'a', '7066706313946426849'),
(35, 'Family 45'' RV', '600000', '', 'http://dayerses.com/data_images/posts/prevost-h3/prevost-h3-03.jpg', '', 0, '', ''),
(36, 'Crysis 3 - PC DVD-Rom', '59.96', NULL, 'http://images.frys.com/art/product/box_shots/7125882.box.GIF', 'http://www.frys.com/product/7125882?source=googleps', 1, 'a', '8103865846095671682'),
(37, 'Boys Gift : Stardust Kids Minecraft Creeper Hoody  (Available In Other Colours)', '24.00', NULL, 'http://img3.etsystatic.com/006/0/5766287/il_570xN.363892955_aa69.jpg', 'http://www.etsy.com/listing/106370485/boys-gift-stardust-kids-minecraft?utm_source=googleproduct&utm_medium=syndication&utm_camp', 1, 'a', '9072769368967756438'),
(38, 'Halo 3 Deluxe Master Chief Teen Costume X-Small (34-36)', '69.95', NULL, 'http://www.3tailer.com/media/catalog/product/3/3/33208.jpg', 'http://www.3tailer.com/halo-3-deluxe-master-chief-teen-costume-x-small-34-36?utm_source=google&utm_medium=base&utm_campaign=goog', 1, 'a', '338316518430732788');

-- --------------------------------------------------------

--
-- Table structure for table `wants2services`
--

CREATE TABLE IF NOT EXISTS `wants2services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `want_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `wants2services`
--

INSERT INTO `wants2services` (`id`, `want_id`, `service_id`) VALUES
(1, 35, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wants2xp`
--

CREATE TABLE IF NOT EXISTS `wants2xp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wanted_id` int(11) NOT NULL,
  `xp_value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

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
(16, 17, 6906),
(17, 18, 371),
(18, 19, 9793),
(19, 20, 3493),
(20, 21, 210),
(21, 22, 973),
(22, 23, 126),
(23, 24, 840),
(24, 25, 700),
(25, 26, 168),
(26, 27, 168),
(27, 28, 109),
(28, 29, 420),
(29, 30, 105),
(30, 31, 420),
(31, 32, 126),
(32, 33, 162),
(33, 34, 1098),
(34, 36, 180),
(35, 37, 72),
(36, 38, 210);

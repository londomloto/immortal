/*
Navicat MySQL Data Transfer

Source Server         : mysql@local
Source Server Version : 50626
Source Host           : localhost:3306
Source Database       : immortal

Target Server Type    : MYSQL
Target Server Version : 50626
File Encoding         : 65001

Date: 2016-02-06 06:03:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pelanggan
-- ----------------------------
DROP TABLE IF EXISTS `pelanggan`;
CREATE TABLE `pelanggan` (
  `idpelanggan` int(10) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idpelanggan`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pelanggan
-- ----------------------------
INSERT INTO `pelanggan` VALUES ('1', 'B. Arif Harahap', 'ariefelf9999@gmail.com', '202cb962ac59075b964b07152d234b70');

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `foto` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES ('4', 'Baju', 'Baju Kaos', 'baju-kaos', 'image-product/product_01.jpg');
INSERT INTO `products` VALUES ('5', 'Baju', 'Baju Pesta', 'baju-pesta', 'image-product/product_02.jpg');
INSERT INTO `products` VALUES ('6', 'Sepatu', 'Sepatu Cowok', 'sepatu-cowok', 'image-product/product_03.jpg');
INSERT INTO `products` VALUES ('7', 'Sepatu', 'Sepatu Cewek', 'sepatu-cewek', 'image-product/product_04.jpg');
INSERT INTO `products` VALUES ('8', 'Tas', 'Tas Oakley', 'tas-oakley', 'image-product/product_05.jpg');
INSERT INTO `products` VALUES ('9', 'Topi', 'Topi Tompi', 'topi-tompi', 'image-product/product_06.jpg');
INSERT INTO `products` VALUES ('10', 'Kacamata', 'Kacamata Hitam', 'kacamata-hitam', 'image-product/product_07.jpg');
INSERT INTO `products` VALUES ('11', 'Gelang', 'Gelang Batu', 'gelang-batu', 'image-product/product_08.jpg');
INSERT INTO `products` VALUES ('12', 'df', 'ffd', 'ffdfdf', 'image-product/product_01.jpg');
INSERT INTO `products` VALUES ('13', 'yui', 'sgr', 'qwe', 'image-product/product_01.jpg');
INSERT INTO `products` VALUES ('14', 'tui', 'uyt', 'asd', 'image-product/product_01.jpg');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `passwd` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin@example.com', '21232f297a57a5a743894a0e4a801fc3', 'Administrator');

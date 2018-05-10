-- phpMyAdmin SQL Dump
-- version 2.8.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Apr 26, 2013 at 10:51 AM
-- Server version: 5.0.51
-- PHP Version: 5.1.6
-- 
-- Database: `siakad`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `tahunakademik`
-- 

CREATE TABLE `tahunakademik` (
  `id` int(4) NOT NULL auto_increment,
  `tahun` varchar(50) NOT NULL,
  `semester` char(10) NOT NULL,
  `aktif` char(1) NOT NULL default 'N',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- 
-- Dumping data for table `tahunakademik`
-- 

INSERT INTO `tahunakademik` VALUES (15, '2011-2012', 'GENAP', 'N');
INSERT INTO `tahunakademik` VALUES (14, '2012-2013', 'GENAP', 'N');
INSERT INTO `tahunakademik` VALUES (13, '2012-2013', 'GANJIL', 'Y');

-- --------------------------------------------------------

-- 
-- Table structure for table `tbl_kalender_akademik`
-- 

CREATE TABLE `tbl_kalender_akademik` (
  `id` int(4) NOT NULL auto_increment,
  `id_ta` int(4) NOT NULL,
  `tgl_dari` date NOT NULL,
  `tgl_sampai` date NOT NULL,
  `kegiatan` varchar(150) NOT NULL,
  `warna` char(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `tbl_kalender_akademik`
-- 

INSERT INTO `tbl_kalender_akademik` VALUES (1, 13, '2012-05-30', '2012-09-05', 'Penerimaan Mahasiswa Baru (PMB)', '1');
INSERT INTO `tbl_kalender_akademik` VALUES (2, 13, '2012-09-06', '2012-09-07', 'Seleksi Ujian Masuk', '2');
INSERT INTO `tbl_kalender_akademik` VALUES (3, 13, '2012-09-08', '2012-09-10', 'Pengumuman Hasil Ujian Masuk', '3');
INSERT INTO `tbl_kalender_akademik` VALUES (4, 13, '2012-09-03', '2012-09-08', 'Pengisian Kartu Rencana Studi (KRS)', '4');

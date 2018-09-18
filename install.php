<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

$sql = <<<EOF

CREATE TABLE `pre_reportmanager_member` (
  `departmentId` int(11) NOT NULL AUTO_INCREMENT,
  `departmentName` varchar(50) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `isAdmin` int(11) DEFAULT '0',
  `phoneNumber` char(10) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`departmentId`)
) ENGINE=MyISAM;

CREATE TABLE `pre_reportmanagertest_report` (
  `reportId` int(11) NOT NULL AUTO_INCREMENT,
  `departmentId` int(11) NOT NULL,
  `date` date NOT NULL,
  `title` char(50) NOT NULL,
  `media` varchar(50) NOT NULL,
  `content` varchar(500) DEFAULT NULL,
  `filePath` varchar(100) DEFAULT NULL,
  PRIMARY KEY  (`reportId`),
  FOREIGN KEY (`departmentId`) 
  REFERENCES `pre_reportmanager_member` (`departmentId`)
) ENGINE=MyISAM;

CREATE TABLE `pre_reportmanager_user` (
  `uid` int(11) NOT NULL,
  `departmentId` int(11) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`uid`),
  FOREIGN KEY (`departmentId`) 
  REFERENCES `pre_reportmanager_member` (`departmentId`)
) ENGINE=MyISAM;

EOF;

runquery($sql);

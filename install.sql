

DROP TABLE pre_reportmanager_report;
DROP TABLE pre_reportmanager_member;

CREATE TABLE `pre_reportmanager_member` (
  `departmentId` int(11) NOT NULL AUTO_INCREMENT,
  `departmentName` varchar(50) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `isAdmin` int(11) DEFAULT '0',
  `phoneNumber` char(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`departmentId`)
) ENGINE=MyISAM;

CREATE TABLE `pre_reportmanager_report` (
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


INSERT INTO `pre_reportmanager_member` (`departmentName`, `isAdmin`, `phoneNumber` , `email`, `address`) VALUES
('麻辣社区舆情部', 1, '123456', 'fratelli.yu@gmail.com', '天晖路晶科一号');

INSERT INTO `pre_reportmanager_user` (`uid`, `departmentId`) VALUES
(4336061, 1),
(7524095, 1),
(7497300, 1);

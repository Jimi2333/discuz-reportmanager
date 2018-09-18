<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

include_once 'source/plugin/reportmanager/controller/department_controller.class.php';

global $_G;
$uid = $_G['uid'];  //discuz的登陆ID
	if(!$uid) {
		echo "请登陆";
		return;
	}


$departments = DepartmentController::getDepartments();

$loggedDepartment = DepartmentController::getLoggedDepartment();
$isAdmin = $loggedDepartment['isAdmin'];
$loggedDepartmentName =$loggedDepartment['departmentName'];


include_once template('reportmanager:addreport');
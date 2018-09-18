<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

include_once 'source/plugin/reportmanager/controller/department_controller.class.php';
include_once 'source/plugin/reportmanager/controller/user_controller.class.php';


global $_G;
$uid = $_G['uid'];  //discuz的登陆ID
	if(!$uid) {
		echo "请登陆";
		return;
	}

$departments = DepartmentController::getDepartments();
$loggedDepartment = DepartmentController::getLoggedDepartment();
if(!$loggedDepartment) {
	echo '用户未绑定。请联系麻辣社区管理员。';
	return;
}


$isAdmin = $loggedDepartment['isAdmin'];



$users = UserController::getUsers();

include_once template('reportmanager:adduser');
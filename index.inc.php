<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

include_once 'source/plugin/reportmanager/controller/report_controller.class.php';
include_once 'source/plugin/reportmanager/controller/page_controller.class.php';
include_once 'source/plugin/reportmanager/controller/department_controller.class.php';

global $_G;
$uid = $_G['uid'];  //discuz的登陆ID
	if(!$uid) {
		echo "请登陆";
		return;
	}

$maxRecordPerpage = 10;

$currentPage=empty($_GET['currentPage']) ? 1 : $_GET['currentPage']; 


$departments = DepartmentController::getDepartments();

$loggedDepartment = DepartmentController::getLoggedDepartment();

if(!$loggedDepartment) {
	echo '用户未绑定。请联系麻辣社区管理员。';
	return;
}
 
$isAdmin = $loggedDepartment['isAdmin'];

$loggedDepartmentId = $loggedDepartment['departmentId'];
$loggedDepartmentName =$loggedDepartment['departmentName'];

$reportCount = ReportController::getReportCount($isAdmin, $loggedDepartmentId);
$totalPages = Paginate::getTotalPages($reportCount, $maxRecordPerpage);

//将总页数转化成array
$pages = Paginate::pagesToArray($totalPages);

$reports = ReportController::getReports($isAdmin, $loggedDepartmentId, $currentPage, $maxRecordPerpage);



$reports['departmentId'];

include_once template('reportmanager:index');

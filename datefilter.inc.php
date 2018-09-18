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
$startDate=empty($_GET['startDate']) ? "" : $_GET['startDate'];
$endDate=empty($_GET['endDate']) ? "" : $_GET['endDate'];



$departments = DepartmentController::getDepartments();

$loggedDepartment = DepartmentController::getLoggedDepartment();

if(!$loggedDepartment) {
	echo '用户未绑定。请联系麻辣社区管理员。';
	return;
}
 
$isAdmin = $loggedDepartment['isAdmin'];

$loggedDepartmentId = $loggedDepartment['departmentId'];
$loggedDepartmentName =$loggedDepartment['departmentName'];

$reportCount = ReportController::getFilteredReportCount($isAdmin, $loggedDepartmentId, $startDate, $endDate);

$totalPages = Paginate::getTotalPages($reportCount, $maxRecordPerpage);

//将总页数转化成array
$pages = Paginate::pagesToArray($totalPages);

$reports = ReportController::getReportsByDateRange($isAdmin, $loggedDepartmentId, $currentPage, $maxRecordPerpage, $startDate, $endDate);

$reports['departmentId'];

include_once template('reportmanager:datefilter');
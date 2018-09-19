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
  
$reportId=empty($_GET['reportId']) ? "" : $_GET['reportId'];
$title=empty($_GET['title']) ? "" : $_GET['title'];
$media=empty($_GET['media']) ? "" : $_GET['media'];
$date=empty($_GET['date']) ? "" : $_GET['date'];
$departmentId=empty($_GET['departmentId']) ? "" : $_GET['departmentId'];
$content=empty($_GET['content']) ? "" : $_GET['content'];

$loggedDepartment = DepartmentController::getLoggedDepartment();
$isAdmin = $loggedDepartment['isAdmin'];
$departments = DepartmentController::getDepartments();


include_once template('reportmanager:updatereport');
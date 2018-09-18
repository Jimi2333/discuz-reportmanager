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
  
$departmentId=empty($_GET['departmentId']) ? "" : $_GET['departmentId'];
$departmentName=empty($_GET['departmentName']) ? "" : $_GET['departmentName'];
$phoneNumber=empty($_GET['phoneNumber']) ? "" : $_GET['phoneNumber'];
$address=empty($_GET['address']) ? "" : $_GET['address'];
$email=empty($_GET['email']) ? "" : $_GET['email'];

$loggedDepartment = DepartmentController::getLoggedDepartment();
$isAdmin = $loggedDepartment['isAdmin'];
//$departments = DepartmentController::getDepartments();


include_once template('reportmanager:updatedepartment');
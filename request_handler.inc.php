<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

include_once 'source/plugin/reportmanager/controller/report_controller.class.php';
include_once 'source/plugin/reportmanager/controller/page_controller.class.php';
include_once 'source/plugin/reportmanager/controller/department_controller.class.php';
include_once 'source/plugin/reportmanager/controller/user_controller.class.php';


if(empty($_POST['requestType'])) exit('Error: post is not set!');

$requestType = empty($_POST['requestType']) ? "" : $_POST['requestType'];

switch ($requestType) {

    case 'insert':
        
        $reportId=empty($_POST['reportId']) ? "" : $_POST['reportId'];
        $departmentId=empty($_POST['departmentId']) ? "" : $_POST['departmentId'];
        $title=empty($_POST['title']) ? "" : $_POST['title'];
        $media=empty($_POST['media']) ? "" : $_POST['media'];
        $date=empty($_POST['date']) ? "" : $_POST['date'];
        $content=empty($_POST['content'])? "" : $_POST['content'];
        
        $uploadPath = DISCUZ_ROOT.'data/attachment/reportmanager/'; //linux 的上传路径
        //$uploadPath = DISCUZ_ROOT.'data/attachment/reportmanager/'; //文件存储路径(根路径)
        $downloadPath = 'data/attachment/reportmanager/';  //文件下载路径（即从http打开diucuz首页的路径）
        $allowedExts = array("txt", "xls", "ppt", "pdf", "doc", "docx", "xlsx");
        $temp = explode(".", $_FILES["file"]["name"]);
        $fileExtension = end($temp); // 获取文件后缀名
        $fileInfo= $_FILES['file'];

        ReportController::create($reportId, $departmentId, $title, $media, $date, $content, $fileInfo, $fileExtension, $allowedExts, $uploadPath, $downloadPath);
    break;

    case 'insertDepartment':
          
        $departmentName=empty($_POST['departmentName']) ? "" : $_POST['departmentName'];
        $phoneNumber=empty($_POST['phoneNumber']) ? "" : $_POST['phoneNumber'];
        $address=empty($_POST['address']) ? "" : $_POST['address'];
        $email=empty($_POST['email']) ? "" : $_POST['email'];
     
        DepartmentController::create($departmentName, $phoneNumber, $address, $email);
    break;

    case 'dateFilter':
          
        $startDate=empty($_POST['startDate']) ? "" : $_POST['startDate'];
        $endDate=empty($_POST['endDate']) ? "" : $_POST['endDate'];
     
        DepartmentController::getReportsByDateRange($departmentName, $phoneNumber, $address, $email);
    break;

    case 'updateDepartment':
        
        $departmentId=empty($_POST['departmentId']) ? "" : $_POST['departmentId'];
        $departmentName=empty($_POST['departmentName']) ? "" : $_POST['departmentName'];
        $phoneNumber=empty($_POST['phoneNumber']) ? "" : $_POST['phoneNumber'];
        $address=empty($_POST['address']) ? "" : $_POST['address'];
        $email=empty($_POST['email']) ? "" : $_POST['email'];
     
        DepartmentController::update($departmentId, $departmentName, $phoneNumber, $address, $email);

    break;

    case 'insertUser':

        $uid=empty($_POST['uid']) ? "" : $_POST['uid'];
        $departmentId=empty($_POST['departmentId']) ? "" : $_POST['departmentId'];

        UserController::create($uid, $departmentId);

    break;


    case 'delete':

		$reportId=empty($_POST['reportId']) ? "" : $_POST['reportId'];
		$filePath=empty($_POST['filePath']) ? "" : $_POST['filePath'];
		if(isset($filePath)) {
			$filePath = DISCUZ_ROOT . $filePath;
		}
		ReportController::delete($reportId, $filePath);
    break;

    case 'deleteUser':

        $uid=empty($_POST['uid']) ? "" : $_POST['uid'];

        UserController::delete($uid);
    break;

}

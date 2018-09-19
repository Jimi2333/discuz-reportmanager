<?php

include_once 'source/plugin/reportmanager/controller/page_controller.class.php';

class ReportController {


	public function delete($reportId, $filePath) {

		if(isset($filePath)) { //如果又文件，先删除文件
			unlink($filePath);
		} 
		
		DB::delete("reportmanager_report", "reportId = $reportId");

	    header('Location: ' . $_SERVER['HTTP_REFERER']);
	}


	public function getReportCount($isAdmin, $loggedDepartmentId) {
		if ($isAdmin != 1) {
            $reportCounter = DB::num_rows(DB::query("SELECT * FROM ".DB::table('reportmanager_report') . " WHERE departmentId = $loggedDepartmentId"));
		} else {
			$reportCounter = DB::num_rows(DB::query("SELECT * FROM ".DB::table('reportmanager_report')));
		}
		return $reportCounter;
	}

	public function getFilteredReportCount($isAdmin, $loggedDepartmentId, $startDate, $endDate) {
		if ($isAdmin != 1) {
            $reportCounter = DB::num_rows(DB::query("SELECT * FROM ".DB::table('reportmanager_report') . " WHERE date>='$startDate' and date<'$endDate' and departmentId = $loggedDepartmentId"));
		} else {
			$reportCounter = DB::num_rows(DB::query("SELECT * FROM ".DB::table('reportmanager_report') . " WHERE date>='$startDate' and date<'$endDate'"));
		}
		return $reportCounter;
	}


	public function getReports($isAdmin, $loggedDepartmentId, $currentPage, $maxRecordPerPage) {

        $offset = Paginate::getOffset($currentPage, $maxRecordPerPage);
		$report = $reports = array();

		//部门id为ADMIN，管理员登陆
		if($isAdmin == 1 ) {
			$side_query = DB::query("SELECT * FROM ".DB::table('reportmanager_report')." ORDER BY reportId DESC LIMIT $offset,$maxRecordPerPage");

			//查询得到结果集,管理员可以查看所有结果
		} else {
			$side_query = DB::query("SELECT * FROM ".DB::table('reportmanager_report')." WHERE departmentId = $loggedDepartmentId". " ORDER BY reportId DESC LIMIT $offset,$maxRecordPerPage"); 
			//查询得到结果集，非管理员只能查看自己部门的结果
			
		}

		//var_dump($side_query);

		while($report = DB::fetch($side_query)){   //将结果集赋值给数组
			$departmentId = $report["departmentId"];
			$departmentName = DB::fetch(DB::query("SELECT departmentName FROM ".DB::table('reportmanager_member'). " WHERE departmentId = $departmentId"));
			$report["departmentName"] = $departmentName["departmentName"];
			$reports[] = $report;
		}
	    return $reports;
	}

	public function getSearchResults($isAdmin, $loggedDepartmentId, $currentPage, $maxRecordPerPage, $keyword) {

		$offset = Paginate::getOffset($currentPage, $maxRecordPerPage);
		$report = $reports = array();

		//部门id为ADMIN，管理员登陆
		if($isAdmin == 1 ) {
			//$side_query = DB::query("SELECT * FROM ".DB::table('reportmanager_report'). "WHERE title like '%$keyword%'" . " ORDER BY reportId DESC LIMIT $offset,$maxRecordPerPage");

			$side_query = DB::query("SELECT * FROM %t WHERE title LIKE %s", array('reportmanager_report','%'.$keyword.'%')); 

			//查询得到结果集,管理员可以查看所有结果
		} else {
			$side_query = DB::query("SELECT * FROM ".DB::table('reportmanager_report')." WHERE departmentId = $loggedDepartmentId". " ORDER BY reportId DESC LIMIT $offset,$maxRecordPerPage"); 
			//查询得到结果集，非管理员只能查看自己部门的结果
			
		}

		while($report = DB::fetch($side_query)){   //将结果集赋值给数组
			$departmentId = $report["departmentId"];
			$departmentName = DB::fetch(DB::query("SELECT departmentName FROM ".DB::table('reportmanager_member'). " WHERE departmentId = $departmentId"));
			$report["departmentName"] = $departmentName["departmentName"];
			$reports[] = $report;
		}
	    return $reports;
	}

	public function getReportsByDateRange($isAdmin, $loggedDepartmentId, $currentPage, $maxRecordPerPage, $startDate, $endDate) {

		$offset = Paginate::getOffset($currentPage, $maxRecordPerPage);
		$report = $reports = array();

		//部门id为ADMIN，管理员登陆
		if($isAdmin == 1 ) {

			//$side_query = DB::query("SELECT * FROM ".DB::table('reportmanager_report')." WHERE date>=UNIX_TIMESTAMP($startDate) and date<UNIX_TIMESTAMP($endDate)  ORDER BY reportId DESC LIMIT $offset,$maxRecordPerPage");
			$side_query = DB::query("SELECT * FROM ".DB::table('reportmanager_report')." WHERE date>='$startDate' and date<'$endDate'" . "ORDER BY reportId DESC LIMIT $offset,$maxRecordPerPage");


			//查询得到结果集,管理员可以查看所有结果
		} else {
			$side_query = DB::query("SELECT * FROM ".DB::table('reportmanager_report')." WHERE departmentId = $loggedDepartmentId and date>='$startDate' and date<'$endDate'". " ORDER BY reportId DESC LIMIT $offset,$maxRecordPerPage"); 
			//查询得到结果集，非管理员只能查看自己部门的结果
			
		}

		while($report = DB::fetch($side_query)){   //将结果集赋值给数组
			$departmentId = $report["departmentId"];
			$departmentName = DB::fetch(DB::query("SELECT departmentName FROM ".DB::table('reportmanager_member'). " WHERE departmentId = $departmentId"));
			$report["departmentName"] = $departmentName["departmentName"];
			$reports[] = $report;
		}
	    return $reports;

	}

	public function create($reportId, $departmentId, $title, $media, $date, $content, $fileInfo, $fileExtension, $allowedExts, $uploadPath, $downloadPath) {
		if(!empty($_POST['departmentId']) && !empty($_POST['date']) && !empty($_POST['media']) && !empty($_POST['content']) && !empty($_POST['title'])) {
         
            //无上传文件
        	if(empty($_FILES["file"]["name"])) {

        		$data = [
                    'departmentId' => $departmentId,
                    'title' => $title,
                    'media' => $media,
                    'date' => $date,
                    'content' => $content
                ];

        		if(empty($reportId)){
	                $sql = DB::insert('reportmanager_report', $data, true);
				} else {
	                $sql = DB::update('reportmanager_report', $data, "reportId = $reportId", $unbuffered = false, $low_priority = false);
				}

                if( $sql ){  
					echo '<script type="text/javascript">alert("添加报告成功!");</script>';
				    header("refresh:0.5;url=". $_SERVER['HTTP_REFERER']);
                } else {
                    echo '数据库请求失败';
                }

        	} else {  //有上传文件
                 
        		if (($fileInfo["size"] < 819200) && in_array($fileExtension, $allowedExts)) {
					    if ($fileInfo["error"] > 0) {
					        echo "错误：: " . $fileInfo["error"] . "<br>";
					    } else {					        					        
					        if (file_exists($uploadPath . $fileInfo["name"])) {
					            echo $fileInfo["name"] . " 文件已经存在。 ";
					        } else {

                                //判断如果文件路径不存在，则创建子文件夹
					        	//if (!is_dir($uploadPath . $departmentId)) {
					        	//	$res=mkdir(($uploadPath . $departmentId), 0777, true);  
					            //}

					            $fileInfo["name"] = $departmentId . "_" . date('Y_m_d_h_i_s') . "." . $fileExtension;
                             
					            if(!move_uploaded_file($fileInfo["tmp_name"], $uploadPath . $fileInfo["name"])) {
					            	echo "上传文件失败！";
					            };

					            $filePath = $downloadPath . $fileInfo["name"];

					            $data = [
				                    'departmentId' => $departmentId,
				                    'title' => $title,
				                    'media' => $media,
				                    'date' => $date,
				                    'content' => $content,
				                    'filePath' => $filePath
				                ];

					            if(empty($reportId)){
					                $sql = DB::insert('reportmanager_report', $data, true);
								} else {
					                $sql = DB::update('reportmanager_report', $data, "reportId = $reportId", $unbuffered = false, $low_priority = false);
				                }

					            if( $sql ){  

					            	echo '<script type="text/javascript">alert("添加报告成功!");</script>';
				                    header("refresh:0.5;url=". $_SERVER['HTTP_REFERER']);
				                    
				                } else {
				                    echo '数据库请求失败';
				                }
					    				            
					        }
					    }
				} else {			
					echo "非法的文件格式";
				}

        	}
        } else {
        	echo "输入信息不完整";
        }
    }
}
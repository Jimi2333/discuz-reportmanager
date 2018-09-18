<?php

class DepartmentController {

	public function getDepartments() {

		$department = $departments = array();
		$side_query = DB::query("SELECT * FROM ".DB::table('reportmanager_member'));
		while($department = DB::fetch($side_query)){   //将结果集赋值给数组
			$departments[] = $department;
		}
		return $departments;
	}

	public function getLoggedDepartment() {
		global $_G;
        $uid = $_G['uid'];
        
        //取得用户所属的部门ID
        $user = DB::fetch_first("SELECT * FROM ".DB::table('reportmanager_user')." WHERE uid=$uid");

        if(array_filter($user)) {
        	$departmentId = $user['departmentId'];       	        	
        	$result = DB::fetch_first("SELECT * FROM ".DB::table('reportmanager_member')." WHERE departmentId=$departmentId");
        	return $result;
        } else {
        	return;
        }
	}

	public function create($departmentName, $phoneNumber, $address, $email) {
		if(!empty($_POST['departmentName'])) {
                                          	
        		$data = [
                    'departmentName' => $departmentName,
                    'phoneNumber' => $phoneNumber,
                    'address' => $address,
                    'email' => $email,
                ];

                $sql = DB::insert('reportmanager_member', $data, true);

                if( $sql){  
					echo '<script type="text/javascript">alert("添加部门成功!");</script>';
				    header("refresh:0.2;url=". $_SERVER['HTTP_REFERER']);
                } else {
                    echo '数据库请求失败';
                }
        } else {
            echo '输入的信息不全！';
        }
	}

    public function update($departmentId, $departmentName, $phoneNumber, $address, $email) {
       if(!empty($_POST['departmentName'])) {
                                            
                $data = [
                    'departmentName' => $departmentName,
                    'phoneNumber' => $phoneNumber,
                    'address' => $address,
                    'email' => $email,
                ];

                $sql = DB::update('reportmanager_member', $data, "departmentId = $departmentId", $unbuffered = false, $low_priority = false);
                
                if( $sql){  
                    echo '<script type="text/javascript">alert("修改成功!");</script>';
                    header("refresh:0.2;url=plugin.php?id=reportmanager:adddepartment");
                } else {
                    echo '数据库请求失败';
                }
        } else {
            echo '输入的信息不全！';
        }

    }
}
<?php

/**
 * 
 */
class UserController
{
	
	function __construct()
	{
		# code...
	}

    public function create($uid, $departmentId) {

    	if(!empty($_POST['departmentId']) && !empty($_POST['uid'])) {

    		$data = [
                    'departmentId' => $departmentId,
                    'uid' => $uid,
                ];

                $sql = DB::insert('reportmanager_user', $data, true);
           
                echo '<script type="text/javascript">alert("用户已绑定至部门!");</script>';
				header("refresh:0.2;url=". $_SERVER['HTTP_REFERER']);

				/*    
                if( $sql && mysql_affected_rows() == 1 ) {  
					echo '<script type="text/javascript">alert("用户已绑定至部门!");</script>';
				    header("refresh:0.2;url=". $_SERVER['HTTP_REFERER']);
                } else {
                    echo '数据库请求失败';
                }
                */

    	} else {
    		echo "输入信息不完整";
    	}
    }

    public function getUsers() {
    	$user = $users = array();
		$side_query = DB::query("SELECT * FROM ".DB::table('reportmanager_user'));
		while($user = DB::fetch($side_query)){   //将结果集赋值给数组
            $departmentId = $user["departmentId"];
            $departmentName = DB::fetch(DB::query("SELECT departmentName FROM ".DB::table('reportmanager_member'). " WHERE departmentId = $departmentId"));
            $user["departmentName"] = $departmentName["departmentName"];
			$users[] = $user;
		}
		return $users;
    }

    public function delete($uid) {
		
		DB::delete("reportmanager_user", "uid = $uid");

	    header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

}
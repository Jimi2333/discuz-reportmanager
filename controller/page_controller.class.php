<?php

class Paginate
{
	

	public function getOffset($page, $maxRecordPerpage) {

		if(!isset($page)){
			$page = 1;
		}

		if ($page <= 0) {
			$page = 1;
		}

		$offset = ($page-1)* $maxRecordPerpage; 
		
		return $offset;
	}

	public function getTotalPages($reportCount, $maxRecordPerpage) {

		$totalPages = $reportCount/$maxRecordPerpage;
		
		return intval(ceil($totalPages));
	}

	public function pagesToArray($pages) {

		if ($pages != 0){
			foreach (range(1, $pages) as $num) {
				$pageList[] = $num;
			}
			return $pageList;
			
        } else {
        	return $pageList = [1];
        }
       
	}
}
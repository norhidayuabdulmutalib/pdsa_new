<?
	/********************************************** 
	 *** Function to display date as DD/MM/YYYY ***
	 **********************************************/
	function DisplayDate($dtmDate){
		$year = substr($dtmDate, 0, 4); // returns YYYY
		$month = substr($dtmDate, 5, 2); // returns MM
		$day = substr($dtmDate, 8, 2); // returns DD
		if($day == '00' || $day == ''){
			$dtmDate = '';
		}else{			
			$dtmDate = $day."/".$month."/".$year;
		}
		return $dtmDate;
	}

	/********************************************** 
	 *** Function to display date as DD/MM/YYYY ***
	 **********************************************/
	function DisplayTime($dtmDate){
		$masa = substr($dtmDate, 11, 8); // returns YYYY
		return $masa;
	}
	
	/********************************************************* 
	 *** Function to convert date to database (YYYY-MM-DD) ***
	 *********************************************************/
	function DBDate($dtmDate){
		if($dtmDate == ''){
			$dtmDate = '';
		}else{
			$year = substr($dtmDate, 6, 4); // returns YYYY
			$month = substr($dtmDate, 3, 2); // returns MM
			$day = substr($dtmDate, 0, 2); // returns DD
			$dtmDate = $year."-".$month."-".$day;
		}
		return $dtmDate;
	}
	
	function DisplayDateF($dtmDate){
		$year = substr($dtmDate, 0, 4); // returns YYYY
		$month = substr($dtmDate, 5, 2); // returns MM
		$day = substr($dtmDate, 8, 2); // returns DD
		if($day == '00' || $day == ''){
			$dtmDate = '';
		}else{			
			$dtmDate = $day." ". month($month)." ".$year;
		}
		return $dtmDate;
	}

	function month($mth){
		if($mth=='01'){ $month_d = "JANUARI"; }
		else if($mth=='02'){ $month_d = "FEBRUARI"; }
		else if($mth=='03'){ $month_d = "MAC"; }
		else if($mth=='04'){ $month_d = "APRIL"; }
		else if($mth=='05'){ $month_d = "MEI"; }
		else if($mth=='06'){ $month_d = "JUN"; }
		else if($mth=='07'){ $month_d = "JULAI"; }
		else if($mth=='08'){ $month_d = "OGOS"; }
		else if($mth=='09'){ $month_d = "SEPTEMBER"; }
		else if($mth=='10'){ $month_d = "OKTOBER"; }
		else if($mth=='11'){ $month_d = "NOVEMBER"; }
		else if($mth=='12'){ $month_d = "DISEMBER"; }
		
		return $month_d;
	}

	/********************************************** 
	 *** Function to display date as DD/MM/YYYY ***
	 **********************************************/
	function get_datediff($dtmDate1,$dtmDate2){
		$year1 = substr($dtmDate1, 0, 4); // returns YYYY
		$month1 = substr($dtmDate1, 5, 2); // returns MM
		$day1 = substr($dtmDate1, 8, 2); // returns DD

		$year2 = substr($dtmDate2, 0, 4); // returns YYYY
		$month2 = substr($dtmDate2, 5, 2); // returns MM
		$day2 = substr($dtmDate2, 8, 2); // returns DD

		$d1=mktime(0,0,0,$month1,$day1,$year1);
		$d2=mktime(0,0,0,$month2,$day2,$year2);
		
		$ddiff = floor(($d2-$d1)/86400);


		return $ddiff+1;
	}

	function get_jadualdt($dtmDate1,$dtmDate2,$ddiff){
		$year1 = substr($dtmDate1, 0, 4); // returns YYYY
		$month1 = substr($dtmDate1, 5, 2); // returns MM
		$day1 = substr($dtmDate1, 8, 2); // returns DD

		//$d1=mktime(0,0,0,$month1,$day1+$ddiff,$year1);

		$dispdt = date("d-m",mktime(0,0,0,$month1,$day1+$ddiff,$year1));
	
		return $dispdt;	
	}

	function get_jadual_kursus($dtmDate1,$dtmDate2,$ddiff){
		$year1 = substr($dtmDate1, 0, 4); // returns YYYY
		$month1 = substr($dtmDate1, 5, 2); // returns MM
		$day1 = substr($dtmDate1, 8, 2); // returns DD

		//$d1=mktime(0,0,0,$month1,$day1+$ddiff,$year1);

		$dispdt = date("d/m/Y",mktime(0,0,0,$month1,$day1+$ddiff,$year1));
	
		return $dispdt;	
	}

?>
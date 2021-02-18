<?
/****
CHECK HARI INI
****/
	function Displaydobtoday($dtmDate){
		$tarikh = substr($dtmDate, 5, 5); // returns YYYY
		$dtmDate = $tarikh;
		return $dtmDate;
	}
	function Displaydobhari($dtmDate){
		$tarikh = substr($dtmDate, 8, 2); // returns YYYY
		$dtmDate = $tarikh;
		return $dtmDate;
	}
		function Displaydobbulan($dtmDate){
		$tarikh = substr($dtmDate, 5, 2); // returns YYYY
		$dtmDate = $tarikh;
		return $dtmDate;
	}
		function Displaydobtahun($dtmDate){
		$tarikh = substr($dtmDate, 0, 4); // returns YYYY
		$dtmDate = $tarikh;
		return $dtmDate;
	}


     /********************************************** 
	 *** Function to display date as DD/MM/YYYY ***
	 **********************************************/
	function DisplayDate($dtmDate,$spliter){
		$year = substr($dtmDate, 0, 4); // returns YYYY
		$month = substr($dtmDate, 5, 2); // returns MM
		$day = substr($dtmDate, 8, 2); // returns DD
		if($day == '00' || $day == ''){
			$dtmDate = '';
		}else{			
			$dtmDate = $day.$spliter.$month.$spliter.$year;
		}
		return $dtmDate;
	}

	function DisplayDateFull($dtmDate,$bahasa){
		$year = substr($dtmDate, 0, 4); // returns YYYY
		$month = substr($dtmDate, 5, 2); // returns MM
		$day = substr($dtmDate, 8, 2); // returns DD
		if($day == '00' || $day == ''){
			$dtmDate = '';
		}else{			
			$dtmDate = $day." ".show_month($month,$bahasa)." ".$year;
		}
		return $dtmDate;
	}

     /********************************************** 
	 *** Function to display date as DD/MM/YYYY ***
	 **********************************************/
	function DisplayDateShort($dtmDate,$bahasa){
		$year = substr($dtmDate, 0, 4); // returns YYYY
		$month = substr($dtmDate, 5, 2); // returns MM
		$day = substr($dtmDate, 8, 2); // returns DD
		if($day == '00' || $day == ''){
			$dtmDate = '';
		}else{			
			$dtmDate = $day." ".show_month_short($month,$bahasa)." ".$year;
		}
		return $dtmDate;
	}
		
	/********************************************************* 
	 *** Function to convert date to database (YYYY-MM-DD) ***
	 *********************************************************/
	function DBDate($dtmDate){
		if($dtmDate == '') return '';
		else{
			$year = substr($dtmDate, 6, 4); // returns YYYY
			$month = substr($dtmDate, 3, 2); // returns MM
			$day = substr($dtmDate, 0, 2); // returns DD
			$dtmDate = $year."-".$month."-".$day;
		}
		return $dtmDate;
	}


       
        /** function to convert EN to BM  (month)
                                                                 ****/

     /*  function show_month($month)  { // to show month in Bahasa
		if($bahasa=='BM'){	  
            switch($month) {
				case '01' : $m = 'Januari'; break;
				case '02' : $m = 'Februari'; break;
				case '03' : $m = 'Mac'; break; 
				case '04' : $m = 'April'; break; 
				case '05' : $m = 'Mei'; break; 
				case '06' : $m = 'Jun'; break;
				case '07' : $m = 'Julai'; break;
				case '08' : $m = 'Ogos'; break;
				case '09' : $m = 'September'; break;
				case '10' : $m = 'Oktober'; break;
				case '11' : $m = 'November'; break;
				case '12' : $m = 'Disember'; break;
            }  return $m;
		 } else {
            switch($month) {
				case '01' : $m = 'January'; break;
				case '02' : $m = 'February'; break;
				case '03' : $m = 'March'; break; 
				case '04' : $m = 'April'; break; 
				case '05' : $m = 'May'; break; 
				case '06' : $m = 'June'; break;
				case '07' : $m = 'July'; break;
				case '08' : $m = 'August'; break;
				case '09' : $m = 'September'; break;
				case '10' : $m = 'October'; break;
				case '11' : $m = 'November'; break;
				case '12' : $m = 'Disember'; break;
		 }
			return $m;
		}
      }  // end of show month */

      function show_month($month,$bahasa)  { // to show month in Bahasa
		if($bahasa=='BM'){	  
            switch($month) {
				case '01' : $m = 'Januari'; break;
				case '02' : $m = 'Februari'; break;
				case '03' : $m = 'Mac'; break; 
				case '04' : $m = 'April'; break; 
				case '05' : $m = 'Mei'; break; 
				case '06' : $m = 'Jun'; break;
				case '07' : $m = 'Julai'; break;
				case '08' : $m = 'Ogos'; break;
				case '09' : $m = 'September'; break;
				case '10' : $m = 'Oktober'; break;
				case '11' : $m = 'November'; break;
				case '12' : $m = 'Disember'; break;
            }  return $m;
		 } else {
            switch($month) {
				case '01' : $m = 'January'; break;
				case '02' : $m = 'February'; break;
				case '03' : $m = 'March'; break; 
				case '04' : $m = 'April'; break; 
				case '05' : $m = 'May'; break; 
				case '06' : $m = 'June'; break;
				case '07' : $m = 'July'; break;
				case '08' : $m = 'August'; break;
				case '09' : $m = 'September'; break;
				case '10' : $m = 'October'; break;
				case '11' : $m = 'November'; break;
				case '12' : $m = 'Disember'; break;
		 }
			return $m;
		}
      }  // end of show month

      function show_month_short($month,$bahasa)  { // to show month in Bahasa
		if($bahasa=='BM'){	  
            switch($month) {
				case '01' : $m = 'Jan'; break;
				case '02' : $m = 'Feb'; break;
				case '03' : $m = 'Mac'; break; 
				case '04' : $m = 'Apr'; break; 
				case '05' : $m = 'Mei'; break; 
				case '06' : $m = 'Jun'; break;
				case '07' : $m = 'Jul'; break;
				case '08' : $m = 'Ogos'; break;
				case '09' : $m = 'Sept'; break;
				case '10' : $m = 'Okt'; break;
				case '11' : $m = 'Nov'; break;
				case '12' : $m = 'Dis'; break;
            }  return $m;
		 } else {
            switch($month) {
				case '01' : $m = 'Jan'; break;
				case '02' : $m = 'Feb'; break;
				case '03' : $m = 'Mar'; break; 
				case '04' : $m = 'Apr'; break; 
				case '05' : $m = 'May'; break; 
				case '06' : $m = 'June'; break;
				case '07' : $m = 'July'; break;
				case '08' : $m = 'Aug'; break;
				case '09' : $m = 'Sep'; break;
				case '10' : $m = 'Oct'; break;
				case '11' : $m = 'Nov'; break;
				case '12' : $m = 'Dis'; break;
		 	} return $m;
		}
      }  // end of show month

?>
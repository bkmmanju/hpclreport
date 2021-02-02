<?php
function local_hpclreport_extend_navigation(global_navigation $nav) {

	global $CFG,$USER;
	$systemcontext = context_system::instance();
	$capability = has_capability('local/hpclreport:view',$systemcontext);
	$nav->showinflatnavigation = true;
	if($capability){
		$abc = $nav->add(get_string('pluginname','local_hpclreport'),$CFG->wwwroot.'/local/hpclreport/index.php'); 
		$abc->showinflatnavigation = true;
	}	
}

function loginuser_details_hpcl($month,$year){
	global $DB,$CFG,$USER;
	$resultvalue = [];	
	
	$a = '';
	$b = '';
	$dateformat = '%Y-%m-%d';
	$where = ' = '.$month;
	$where1 = ' = '.$year;
	$sql1 ="SELECT COUNT(id) as totalcount FROM {local_loginevent} WHERE action ='loggedin' and MONTH(FROM_UNIXTIME(logintime))".$where." and YEAR(FROM_UNIXTIME(logintime))".$where1;
	$v1 = $DB->get_record_sql($sql1);
				//print_object($v1);die;
	if($v1){
		$a  = $v1->totalcount;
	}
	$sql2 = "SELECT COUNT(DISTINCT(userid)) as uniqlogin  FROM {local_loginevent} WHERE action ='loggedin' and MONTH(FROM_UNIXTIME(logintime))".$where." and YEAR(FROM_UNIXTIME(logintime))".$where1;
	$v2 = $DB->get_record_sql($sql2);
	if($v2) {
		$b = $v2->uniqlogin;
	}
	$mn = '';
	if($month==1){$mn = 'Jan';}
	if($month==2){$mn = 'Feb';}
	if($month==3){$mn = 'Mar';}
	if($month==4){$mn = 'Apr';}
	if($month==5){$mn = 'May';}
	if($month==6){$mn = 'Jun';}
	if($month==7){$mn = 'July';}
	if($month==8){$mn = 'Aug';}
	if($month==9){$mn = 'Sept';}
	if($month==10){$mn = 'Oct';}
	if($month==11){$mn = 'Nov';}
	if($month==12){$mn = 'Dec';}
	$resultvalue = array(
		'month'=>$mn,
		'sofarlogin'=>$a,
		'uniquelogin'=>$b
		);	
	return $resultvalue;
}



//total course enrolled Technical


// this functiona accepts category id and month like 01- for jan
// this function returns the total number of enrolled user in this category

function enrolled_category_hpcl($catid, $month,$year) {

		// get all courses where categoryid = $catid

	global  $DB,$USER,$CFG;
	$courseids = $DB->get_records('course',array('category'=>$catid));
		// //here we get all course from particular id now we ill findenroleed users in above give month
	$countenr = 0;
	if($courseids){
		foreach ($courseids as $key => $courseid) {

			$getnumberenrq = "SELECT COUNT(ue.id) AS enroled FROM {course} AS c JOIN {enrol} AS en ON en.courseid = c.id JOIN {user_enrolments} AS ue ON ue.enrolid = en.id WHERE c.id = $courseid->id  and MONTH(FROM_UNIXTIME(ue.timecreated)) = $month and YEAR(FROM_UNIXTIME(ue.timecreated)) = $year GROUP BY c.id ";
			$result = $DB->get_record_sql($getnumberenrq);
			
			if (!empty($result)) {
				$countenr = $countenr + $result->enroled;	
			}
		}
	}

	return $countenr;	
	
}

// specially for technical as it has subcategory
function enrolled_category_hpcl_tech($techcatid,$month,$year) {
	// get all subcategory 
	global $DB;
	$enrolcattech = 0;

	$sql2 = "Select * from {course_categories} where path LIKE '%$techcatid%'";
	
	$get_subcat = $DB->get_records_sql($sql2);

	//$get_subcat = $DB->get_records('course_categories', array('parent' => $techcatid));
	
	if (!empty($get_subcat)) {
		foreach ($get_subcat as $key => $get_subcat_val){
			$countcatid = $get_subcat_val->id;
//echo $countcatid;
			$countthis = enrolled_category_hpcl($countcatid,$month,$year);

			$enrolcattech = $enrolcattech + $countthis ;//this should be technical

		}
	}

	return $enrolcattech;
}

//completed total courses completed other

function completed_category_hpcl($catid, $month ,$year) {

		// get all courses where categoryid = $catid

	global  $DB,$USER,$CFG;
	$courseids = $DB->get_records('course',array('category'=>$catid));
		// //here we get all course from particular id now we ill findenroleed users in above give month
	$countcmpl = 0;
	if($courseids){
		foreach ($courseids as $key => $courseid) {

			$getnumbercompletionq = "SELECT count(userid) as cmplnumber from {course_completions} 
			where course = $courseid->id and MONTH(FROM_UNIXTIME(timecompleted)) = $month and YEAR(FROM_UNIXTIME(timecompleted)) = $year ";
			$result = $DB->get_record_sql($getnumbercompletionq);
			
			
			if (!empty($result)) {
				$countcmpl = $countcmpl + $result->cmplnumber;	
			}
		}
	}
	return $countcmpl;	
}

//other Technical

function completed_category_hpcl_tech($catid, $month ,$year) {

// get all subcategory 
	global $DB;
	$enrolcattech = 0;

	$sql2 = "Select * from {course_categories} where path LIKE '%$techcatid%'";
	
	$get_subcat = $DB->get_records_sql($sql2);

	//$get_subcat = $DB->get_records('course_categories', array('parent' => $techcatid));
	
	if (!empty($get_subcat)) {
		foreach ($get_subcat as $key => $get_subcat_val){
			$countcatid = $get_subcat_val->id;
//echo $countcatid;
			$countthis = completed_category_hpcl($countcatid,$month,$year);

			$enrolcattech = $enrolcattech + $countthis ;//this should be technical

		}
	}

	return $enrolcattech;
	
}

//total certificate earned 
function certificate_category_hpcl($catid = NULL, $month, $allcat,$year) {
// get all courses where categoryid = $catid

	global  $DB,$USER,$CFG;
	
	if($allcat==1){
		$courseids = $DB->get_records('course');
	}else{
		$courseids = $DB->get_records('course',array('category'=>$catid));
	}
	// //here we get all course from particular id now we ill findenroleed users in above give month
	$certcomplted = 0;
	if($courseids){
		foreach ($courseids as $key => $courseid) {

			$getcertidq = "SELECT id from {simplecertificate} where course = $courseid->id"; 
			$getcertidqr = $DB->get_record_sql($getcertidq);
			if ($getcertidqr) { 
				$getcernumberq = "SELECT count(id) as  certdnumber from {simplecertificate_issues} 
				where certificateid = $getcertidqr->id and MONTH(FROM_UNIXTIME(timecreated)) = $month and YEAR(FROM_UNIXTIME(timecreated)) = $year"; 
				$result = $DB->get_record_sql($getcernumberq); 
			}			
			if (!empty($result)) {
				$certcomplted = $certcomplted + $result->certdnumber;	
			}
			
		}
	}
	return $certcomplted;		
}


//batches code 

function badges_category_hpcl ($catid = NULL,$month,$allcat,$year){
	global  $DB,$USER,$CFG;
	if($allcat==1){
		$courseids = $DB->get_records('course');
	}else{
		$courseids = $DB->get_records('course',array('category'=>$catid));
	}
	//here we get all course from particular id now we ill findenroleed users in above give month
	$totalcount = 0;
	$totalcountsilver = 0;
	$totalcountbronze = 0;
	$totalcountgold = 0;
	$totalcountcompleion = 0;
	$medal = [];
	if($courseids){
		foreach ($courseids as $key => $courseid) {	
			//badgesFrom:Mihir Jana//
			//silver badge 
			$getbadgesilverq = "SELECT id from {badge} where courseid = $courseid->id and badgelevel = 'Silver'";  
			$getbadgesilverr = $DB->get_record_sql($getbadgesilverq);
			if ($getbadgesilverr) { 
				$badgesilvernumberq = "SELECT count(id) as badgesilver from {badge_issued} where badgeid = $getbadgesilverr->id and MONTH(FROM_UNIXTIME(dateissued)) = $month and YEAR(FROM_UNIXTIME(dateissued)) = $year";   
				$badgesilvernumberr = $DB->get_record_sql($badgesilvernumberq);
				$totalcountsilver = $totalcountsilver + $badgesilvernumberr->badgesilver;
			} 
			     //bronze 
			$getbadgebrnzq = "SELECT id from {badge} where courseid = $courseid->id  and badgelevel = 'Bronze'"; 
			$getbadgebrnzr = $DB->get_record_sql($getbadgebrnzq); 
			if ($getbadgebrnzr) { 
				$getbadgebrnznumberq = "SELECT count(id) as badgebronze from {badge_issued} where badgeid = $getbadgebrnzr->id and MONTH(FROM_UNIXTIME(dateissued)) = $month and YEAR(FROM_UNIXTIME(dateissued)) = $year"; 
				$getbadgebrnznumberr = $DB->get_record_sql($getbadgebrnznumberq);
				$totalcountbronze = $totalcountbronze + $getbadgebrnznumberr->badgebronze;
			}       
			         //gold 
			$getbadgegoldq = "SELECT id from {badge} where courseid = $courseid->id and badgelevel = 'Gold'";   
			$getbadgegoldr = $DB->get_record_sql($getbadgegoldq); 
			if ($getbadgegoldr) { 
				$badgegoldnumberq = "SELECT count(id) as badgegold from {badge_issued} where badgeid = $getbadgegoldr->id and MONTH(FROM_UNIXTIME(dateissued)) = $month and YEAR(FROM_UNIXTIME(dateissued)) = $year ";  
				$badgegoldnumberr = $DB->get_record_sql($badgegoldnumberq); 
				$totalcountgold = $totalcountgold + $badgegoldnumberr->badgegold;
			}
			
			//completion  
			$getbadgecmplq = "SELECT id from {badge} where courseid = $courseid->id and name LIKE '%Completion%'";   
			$getbadgecmplr = $DB->get_record_sql($getbadgecmplq); 
			if ($getbadgecmplr) { 
				$badgecmplnumberq = "SELECT count(id) as badgecmpl from {badge_issued} where badgeid = $getbadgecmplr->id and MONTH(FROM_UNIXTIME(dateissued)) = $month and YEAR(FROM_UNIXTIME(dateissued)) = $year ";  
				$badgecmplnumberqr = $DB->get_record_sql($badgecmplnumberq); 
				$totalcountcompleion = $totalcountcompleion + $badgecmplnumberqr->badgecmpl;
			}

			$totalcount = $totalcountsilver +  $totalcountbronze + $totalcountgold + $totalcountcompleion;


			$medal = array(
				'total'=>	$totalcount,
				'bronze'=>$totalcountbronze,
				'silver'=>$totalcountsilver,
				'gold'=>$totalcountgold,
				'cmpl'=>$totalcountcompleion
				);
		}
	}
	return $medal;
}

function enrolled_category_courserank_hpcl($catid, $month,$rank,$year) {
	// get all courses where categoryid = $catid
	global  $DB,$USER,$CFG;
	$courseids = $DB->get_records('course',array('category'=>$catid));
	//here we get all course from particular id now we ill findenroleed users in above give month
	$totalrank = [];
	$countenr = 0;
	if($courseids){
		foreach ($courseids as $key => $courseid) {

			$getnumberenrq = "SELECT COUNT(ue.id) AS enroled FROM {course} AS c JOIN {enrol} AS en ON en.courseid = c.id JOIN {user_enrolments} AS ue ON ue.enrolid = en.id 
			WHERE c.id = $courseid->id  and MONTH(FROM_UNIXTIME(ue.timecreated)) = $month and YEAR(FROM_UNIXTIME(ue.timecreated)) = $year GROUP BY c.id ";
			$result = $DB->get_record_sql($getnumberenrq);
			
			if (!empty($result)) {
				$countenr = $result->enroled;	
				$totalrank[$countenr] = array(
				'enroled'=>$courseid->id
				);
			}
		}
	}
	$returnrank = '';
	if($totalrank){
		krsort($totalrank);
		foreach ($totalrank as $key => $value) {
			$noenr = $key ;
			$courseid = $value['enroled'];
			$crsname = $DB->get_record('course',array('id'=>$courseid));

			$crslink = '<a href="'.$CFG->wwwroot.'/course/view.php?id='.$courseid.'">'.$crsname->fullname.'</a>';
			//$resultvalue[] = $crsname->fullname.'-'.$noenr;
			$resultvalue[] = $crslink.'-'.$noenr;
		}
		for($i=0;$i<$rank;$i++){
			$returnrank .= $resultvalue[$i].'<br><hr>';
		}
	}
	return $returnrank;
}

//time spent code here added by prashant oct-25-2018 

function timespent_hpcl($month,$year){
	global $DB,$CFG;
	//login user details
	$logoutarray = [];
	$loginarray = [];
	$sql = "SELECT id,userid, 
	timecreated,DAY(FROM_UNIXTIME(timecreated)) AS day1
	FROM `mdl_logstore_standard_log` 
	WHERE action LIKE 'loggedin' and MONTH(FROM_UNIXTIME(timecreated)) = $month and YEAR(FROM_UNIXTIME(timecreated)) = $year 
	ORDER BY day1 ASC";
	$login = $DB->get_records_sql($sql);
	if(!empty($login)){
		foreach ($login as $key => $value) {
			if ($value->userid != 2) {
				$loginarray[$value->userid.$value->day1] = array(
					$value->id,
					$value->userid,
					$value->timecreated,
					$value->day1
					);
			}
		}
	}
	$sql1 = "SELECT id,userid, 
	timecreated,DAY(FROM_UNIXTIME(timecreated)) AS day2
	FROM `mdl_logstore_standard_log` 
	WHERE action LIKE 'loggedout' and MONTH(FROM_UNIXTIME(timecreated)) = $month and YEAR(FROM_UNIXTIME(timecreated)) = $year 
	ORDER BY day2 asc ";
	$logout = $DB->get_records_sql($sql1);
	if(!empty($logout)){
		foreach ($logout as $key => $value) {
			if ($value->userid != 2) {
				$logoutarray[$value->userid.$value->day2] = array(
					$value->id,
					$value->userid,
					$value->timecreated,
					$value->day2			
					);
			}
		}
	}
	$timediff = '';
	$myspentime = 0;
	if($logoutarray){
		foreach ($logoutarray as $key => $logoutvalue) {
			$myspentime1 =0;
			$mylogintime = $loginarray[$key][2];
			$mylogouttime = $logoutarray[$key][2];
			if (!empty($mylogintime) and !empty($mylogouttime) and ($mylogouttime > $mylogintime)) {
				$myspentime1 = $mylogouttime - $mylogintime;
			}
			$myspentime = $myspentime + $myspentime1;	
		}
	}
	$totalusercheck = count($logoutarray);
	$avgtime = $myspentime / $totalusercheck;
	if(!empty($avgtime)){
		$hours = floor($avgtime / 3600);
		$minutes = floor(($avgtime / 60) % 60);
		$seconds = $avgtime % 60;
		return $hours.'h'.$minutes.'m'.$seconds.'s';
	}else{
		return '-';
	}
}


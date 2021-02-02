<?php

// This file is part of the Certificate module for Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Handles uploading files
 *
 * @package    local_hpclreport
 * @copyright  Prashant Yallatti<prashant@elearn10.com>
 * @copyright  Dhruv Infoline Pvt Ltd <lmsofindia.com>
 * @license    http://www.lmsofindia.com 2017 or later
 */
require_once('../../config.php');
require_once($CFG->dirroot.'/local/hpclreport/lib.php');
require_once('hpclreport_form.php');
require_once($CFG->libdir . '/formslib.php');
require_once($CFG->dirroot.'/local/hpclreport/csslinks.php');

require_login(0,false);
$capadmin = is_siteadmin();
$context = context_system::instance();
$capability = has_capability('local/hpclreport:view',$context);
$PAGE->set_context(context_system::instance());
$title = get_string('pluginname', 'local_hpclreport');
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_pagelayout('standard');
$PAGE->set_url('/local/hpclreport/index.php');
require_login();
$previewnode = $PAGE->navigation->add(get_string('pluginname','local_hpclreport'), new moodle_url($CFG->wwwroot.'/local/hpclreport/index.php'), navigation_node::TYPE_CONTAINER);
$PAGE->requires->jquery();
include_once('jslink.php');	
echo $OUTPUT->header();
$mform = new local_hpclreport_form();
$table = new html_table();
$table->id =  'example';
$table->class =  'table generaltable';
$table->head = (array) get_strings(array('sl','monthname','thits', 'ulogin','tspent', 'rofvideo', 'tvideo','rankcourse','enroltech','enrolbeha',
'complettech','complbehav','totalbearn','bronze','silver','gold','cmplbadge','totalcetearn'), 'local_hpclreport');
//findind cateory id for technical and Behavioral ,video
$techcatid = $DB->get_record('course_categories',array('idnumber'=>'Technical'),'id');
$behavcatid = $DB->get_record('course_categories',array('idnumber'=>'Behavioral'),'id');
$videocatid = $DB->get_record('course_categories',array('idnumber'=>'Video'),'id');
if ($mform->is_cancelled()){
	redirect(new moodle_url('/', array()));
}else if ($data = $mform->get_data()) {
	if(!empty($data)){

		if($data->month !=99){
			$months = loginuser_details_hpcl($data->month,$data->year);
			//$enrolcattech = enrolled_category_hpcl($techcatid->id,$data->month,$data->year);//this should be technical
			$enrolcattech = enrolled_category_hpcl_tech($techcatid->id,$data->month,$data->year);//this should be technical
			
			$enrolcatbeh = enrolled_category_hpcl($behavcatid->id,$data->month,$data->year);//this should be behaviorial cat id
			$enrolcatvideo = enrolled_category_hpcl($videocatid->id,$data->month,$data->year);//this should be video catid
			
			//$compltedtech = completed_category_hpcl($techcatid->id,$data->month,$data->year);
			$compltedtech = completed_category_hpcl_tech($techcatid->id,$data->month,$data->year);
			
			$compltedbeha = completed_category_hpcl($behavcatid->id,$data->month,$data->year);
			
			$badgescategory = badges_category_hpcl($cat = null,$data->month,$allcat=1,$data->year);
			
			$certificate = certificate_category_hpcl($cat=NULL,$data->month,$allcat =1,$data->year);
			
			$topcourselist = enrolled_category_courserank_hpcl($techcatid->id,$data->month,$rank=4,$data->year);
			$topvideolist = enrolled_category_courserank_hpcl($videocatid->id,$data->month,$rank=4,$data->year);//this should 
			
			
			if($topvideolist){
				$topvideolist = $topvideolist;
			}else{
				$topvideolist = '-';
			}
			//hpcl report new line added by prashant oct-25-2018
$certificate =$compltedtech+$compltedbeha;
//time spent code here added by prashant oct-25-2018
$timespend = timespent_hpcl($data->month,$data->year);


			$sl = 01;
			$table->data[] = array(
				$sl,
				$months['month'],
				$months['sofarlogin'],
				$months['uniquelogin'],
				$timespend,
				$topvideolist,
				$enrolcatvideo,
				$topcourselist,
				$enrolcattech,
				$enrolcatbeh,
				$compltedtech,
				$compltedbeha,
				$badgescategory['total'],
				$badgescategory['bronze'],
				$badgescategory['silver'],
				$badgescategory['gold'],
				$badgescategory['cmpl'],
				$certificate
				);
		} else {

			$tempmonth = 01; 
			while($tempmonth<13){
				$data->month = $tempmonth;
				$months = loginuser_details_hpcl($data->month,$data->year);
			
			$enrolcattech = enrolled_category_hpcl($techcatid->id,$data->month,$data->year);//this should be technical
			
			$enrolcatbeh = enrolled_category_hpcl($behavcatid->id,$data->month,$data->year);//this should be behaviorial cat id
			
			$enrolcatvideo = enrolled_category_hpcl($videocatid->id,$data->month,$data->year);//this should be video catid
			
			$compltedtech = completed_category_hpcl($techcatid->id,$data->month,$data->year);
			
			$compltedbeha = completed_category_hpcl($behavcatid->id,$data->month,$data->year);
			
			$badgescategory = badges_category_hpcl($cat = null,$data->month,$allcat=1,$data->year);
			
			$certificate = certificate_category_hpcl($cat=NULL,$data->month,$allcat =1,$data->year);
			
			$topcourselist = enrolled_category_courserank_hpcl($techcatid->id,$data->month,$rank=4,$data->year);
			$topvideolist = enrolled_category_courserank_hpcl($videocatid->id,$data->month,$rank=4,$data->year);//this should 

			if($topvideolist){
				$topvideolist = $topvideolist;
			}else{
				$topvideolist = '';
			}
			//hpcl report new line added by prashant oct-25-2018
		$certificate = $compltedtech+$compltedbeha;
		//time spent code here added by prashant oct-25-2018
		$timespend = timespent_hpcl($data->month,$data->year);


			$table->data[] = array(
				$tempmonth,
				$months['month'],
				$months['sofarlogin'],
				$months['uniquelogin'],
				$timespend,
				$topvideolist,
				$enrolcatvideo,
				$topcourselist,
				$enrolcattech,
				$enrolcatbeh,
				$compltedtech,
				$compltedbeha,
				$badgescategory['total'],
				$badgescategory['bronze'],
				$badgescategory['silver'],
				$badgescategory['gold'],
				$badgescategory['cmpl'],
				$certificate
				);
			$tempmonth++;
		}
	}
}
}
if($capability){
	$mform->display();
	echo html_writer::table($table);
}else{
	echo html_writer::div(
		get_string('cap', 'local_hpclreport'),'alert alert-danger'
		);
}

echo $OUTPUT->footer();
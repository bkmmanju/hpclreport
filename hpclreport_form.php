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

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.'); /// It must be included from a Moodle page
}
require_once($CFG->libdir.'/formslib.php');
class local_hpclreport_form extends moodleform {
	function definition() {
		$mform = $this->_form; 
		//orgaziation name field
		$mform->addElement('header','hpclhdr',get_string('hpclhdr','local_hpclreport'));
		$mform->setExpanded('hpclhdr');
		$month = array(
			'99'=>'All',
			'1'=>'January',
			'2'=>'February',
			'3'=>'March',
			'4'=>'April',
			'5'=>'May',
			'6'=>'June',
			'7'=>'July',
			'8'=>'August',
			'9'=>'September',
			'10'=>'October',
			'11'=>'November',
			'12'=>'December'			
			);
		$select = $mform->addElement('select', 'month',
			get_string('month','local_hpclreport'),$month);
		$mform->addRule('month', get_string('required'), 'required', null, 'client'); 
		$select->setMultiple(false);
		$year = array('2018'=>2018,'2019'=>2019,'2020'=>2020);
		$select = $mform->addElement('select', 'year',
			get_string('syear','local_hpclreport'),$year);
		$mform->addRule('month', get_string('required'), 'required', null, 'client'); 
		$select->setMultiple(false);

		$this->add_action_buttons();
	}
}

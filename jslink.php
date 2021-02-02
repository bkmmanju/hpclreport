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
 * @author  	Prashant Yallatti<prashant@elearn10.com>
 * @copyright  Dhruv Infoline Pvt Ltd <lmsofindia.com>
 * @license    http://www.lmsofindia.com 2017 or later
 */
/**
* for dispalying data tables we need to add all js files here 
*/
$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/local/hpclreport/js/newjs/jquery-1.12.4.js'), true);

$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/local/hpclreport/js/newjs/jquery.dataTables.min.js'), true);

$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/local/hpclreport/js/newjs/dataTables.bootstrap4.min.js'), true);

$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/local/hpclreport/js/newjs/dataTables.buttons.min.js'), true);

$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/local/hpclreport/js/newjs/buttons.bootstrap4.min.js'), true);

$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/local/hpclreport/js/newjs/jszip.min.js'), true);

$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/local/hpclreport/js/newjs/pdfmake.min.js'), true);

$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/local/hpclreport/js/newjs/vfs_fonts.js'), true);

$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/local/hpclreport/js/newjs/buttons.html5.min.js'), true);

$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/local/hpclreport/js/newjs/buttons.print.min.js'), true);

$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/local/hpclreport/js/newjs/buttons.colVis.min.js'), true);

$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/local/hpclreport/js/newjs/table.js'), true);

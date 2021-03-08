<?php
/**
 * @package    Block compromiseto
 * @copyright  2019 Marcelo Cobias
 * @author     Marcelo Cobias <marcelo.amorim@projecao.br>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_compromiseto extends block_base {
	
    public function init() {
        $this->title = get_string('pluginname', 'block_compromiseto');
    }

    public function get_content() {
        global $CFG, $USER, $DB;
	
		$this->content = new stdClass();
		$this->content->text = "";
		
		$access = $DB->get_record_sql("SELECT COUNT(*) AS logincount FROM mdl_logstore_standard_log l JOIN mdl_user u ON u.id = l.userid AND u.id = ".$USER->id." WHERE l.target LIKE '%dashboard%'");
		if($access->logincount < 1){
			 if (!is_siteadmin()){
				$redirect = $CFG->wwwroot."/user/edit.php?id=".$USER->id;
			 }else{
				$redirect = $CFG->wwwroot."/user/editadvanced.php?id=".$USER->id;
			 }			
			$this->content->text .= "<script> setTimeout(function () {window.location.href= '".$redirect."';}, 10);</script>";
		}
		return $this->content;
    }

    public function applicable_formats() {
        return array('my' => true);
    }

    public function has_config() {
        return true;
    }

    public function instance_allow_multiple(){
        return false;
    }

    function hide_header() {
        return true;
    }
}
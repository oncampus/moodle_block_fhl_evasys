<?php
require_once($CFG->dirroot.'/blocks/fhl_evasys/evasys_lib.php');

class block_fhl_evasys extends block_base {
	
	public function init() {
		$this->title = get_string('default_title', 'block_fhl_evasys');
	}
	
	public function get_content() {
		Global $USER, $DB, $CFG, $SESSION;		
		
		if ($this->content !== null) {
			return $this->content;
		}
		
		$id = required_param('id', PARAM_INT);
		$course = $DB->get_record('course', array('id'=>$id));		
		
		$this->content =  new stdClass;
		$this->content->text='';
		$this->content->footer = '';
		$blocktext.='';
		$debug='';
		$global_wsdl=get_config('fhl_evasys','wsdl');
		$wsdl  = (!empty($global_wsdl)) ? $global_wsdl : false;
		$global_header=get_config('fhl_evasys','header');
		$header  = (!empty($global_header)) ? $global_header : false;
		$global_soapuser=get_config('fhl_evasys','soapuser');
		$soapuser  = (!empty($global_soapuser)) ? $global_soapuser : false;
		$global_soappass=get_config('fhl_evasys','soappass');
		$soappass  = (!empty($global_soappass)) ? $global_soappass : false;
		/*
		$global_proxy=get_config('fhl_evasys','proxy');
		$proxy  = (!empty($global_proxy)) ? $global_proxy : false;
		$global_proxyport=get_config('fhl_evasys','proxyport');
		$proxyport  = (!empty($global_proxyport)) ? $global_proxyport : false;
		*/		
		$global_participation_url=get_config('fhl_evasys','participation_url');
		$participation_url  = (!empty($global_participation_url)) ? $global_participation_url : false;
		$global_ongoing_evaluation=get_config('fhl_evasys','ongoing_evaluation');
		$ongoing_evaluation  = (!empty($global_ongoing_evaluation)) ? $global_ongoing_evaluation : false;			
		$global_evaluation_periode=get_config('fhl_evasys','evaluation_periode');
		$evaluation_periode  = (!empty($global_evaluation_periode)) ? $global_evaluation_periode : false;			
		
		if (has_capability('moodle/block:edit', $this->page->context)) {
			$blocktext.='<center>Diesen Block bitte<br/><u>nicht entfernen</u>!<br/><br/><a href="'.$CFG->wwwroot.'/blocks/fhl_evasys/dozenten_info.php?id='.$course->id.'">weitere Infos</a></center>';
		} else {
			$debug.='Student<br>';
			if($ongoing_evaluation=='yes') {

				$evasys=new Evasys($wsdl, $header, $soapuser, $soappass);
				if ($evasys) {
				
				// Infos zu Evaluationen aus Session holen
				$eva_info_found=false;
				$eva_exists=false;
				if (!empty($SESSION->evaluationsinfo)){
					$debug.="Info aus Session<br>";
					$course_evaluations=$SESSION->evaluationsinfo;
					foreach ($course_evaluations as $course_evaluation) {
						$evaluation_course=$course_evaluation[0];
						$evaluation_tan=$course_evaluation[2];
						if ($course->id==$evaluation_course){
							$eva_info_found=true;
							if ($evaluation_tan) {
								$eva_exists=true;
							}
						}
					}
				} else {
					$debug.="Keine Info aus Session<br>";
					$course_evaluations=array();
				}				
				
				if (!$eva_info_found) {
					$debug.="Keine Evainfos vorhanden<br>";
					$evaluations=$DB->get_records_sql('select * from mdl_evaluationen where moodle_kurs_id="'.$course->id.'" and semester="'.$evaluation_periode.'"');
					foreach ($evaluations as $evaluation) {
						if ($evaluation->survey_id!='') {
							$survey_id=intval($evaluation->survey_id);
							$survey=$evasys->GetSurveyById($survey_id);
							$survey_form=$survey->m_nFrmid;
							$survey_period=$survey->m_oPeriod->m_nPeriodId;
							$survey_open=$survey->m_nOpenState;
							$survey_title=$survey->m_sTitle;
							
							if ($survey_open==1) {
								if (!$teilnahmelink=$evasys->GetOnlineSurveyLinkByEmail($survey_id,$USER->email)) {
									$debug.="schon teilgenommen<br>";
								} else {
									$tanarray=explode('=', $teilnahmelink);
									$tan=$tanarray[1];
									$course_evaluations[]=array($course->id,$survey_title,$tan,$survey_form);
									$SESSION->evaluationsinfo=$course_evaluations;
									$eva_exists=true;
									$debug.="tan gefunden<br>";
								}
							}	
								
						}
					}
							
					if(!$eva_exists) {
						$course_evaluations[]=array($course->id,false,false,false);
						$SESSION->evaluationsinfo=$course_evaluations;
					}
				}				
				
				
				if ($eva_exists) {
					$blocktext.= '<div style="padding:5px;"><br/><center>';
					$blocktext.= get_string('entrytext', 'block_fhl_evasys').'<br/><br>';

					foreach ($course_evaluations as $course_evaluation) {
						$evaluation_course=$course_evaluation[0];
						$evaluation_title=$course_evaluation[1];
						$evaluation_tan=$course_evaluation[2];
						$evaluation_formtitle=$course_evaluation[3];

						if ($evaluation_course==$course->id){
							$blocktext.= '<a style="" href="'.$participation_url.$evaluation_tan.'" target="_blank"><span style="font-weight:bold;font-size:14px;text-decoration:underline;">'.$evaluation_title.'</span></a><br/><br/>';
						}
					}
					$blocktext.= get_string('footertext', 'block_fhl_evasys');
					$blocktext.= '</center><br/></div>';

				} 
				
			}
			}
		}		
		$this->content->text = $blocktext;
		
		
		return $this->content;  
	}
	

	public function instance_allow_multiple() {
		return false;
	}	

	public function html_attributes() {    
		$attributes = parent::html_attributes(); 
		$attributes['class'] .= ' block_fhl_evasys'; 
		return $attributes;
	}	

	public function applicable_formats() {  
		return array('course-view' => true);
	}	
		
}    
<?php
require_once($CFG->dirroot.'/blocks/fhl_evasys/evasys_lib.php');

$settings->add(new admin_setting_heading(            
	'headerconfig',            
	get_string('headerconfig', 'block_fhl_evasys'),            
	get_string('descconfig', 'block_fhl_evasys'),''        
)); 
$settings->add(new admin_setting_configtext(            
	'fhl_evasys/wsdl',            
	get_string('configlabel_wsdl', 'block_fhl_evasys'),            
	get_string('configdesc_wsdl', 'block_fhl_evasys'),''
));
$settings->add(new admin_setting_configtext(            
	'fhl_evasys/header',            
	get_string('configlabel_header', 'block_fhl_evasys'),            
	get_string('configdesc_header', 'block_fhl_evasys'),''
));
$settings->add(new admin_setting_configtext(            
	'fhl_evasys/soapuser',            
	get_string('configlabel_soapuser', 'block_fhl_evasys'),            
	get_string('configdesc_soapuser', 'block_fhl_evasys'),''
));
$settings->add(new admin_setting_configpasswordunmask(
	'fhl_evasys/soappass', 
	get_string('configlabel_soappass', 'block_fhl_evasys'),
	get_string('configdesc_soappass', 'block_fhl_evasys'), 
	'password'
));
$settings->add(new admin_setting_configtext(            
	'fhl_evasys/participation_url',            
	get_string('configlabel_participation_url', 'block_fhl_evasys'),            
	get_string('configdesc_participation_url', 'block_fhl_evasys'),''
));
/*
$settings->add(new admin_setting_configtext(            
	'fhl_evasys/proxy',            
	get_string('configlabel_proxy', 'block_fhl_evasys'),            
	get_string('configdesc_proxy', 'block_fhl_evasys'),''
));
$settings->add(new admin_setting_configtext(            
	'fhl_evasys/proxyport',            
	get_string('configlabel_proxyport', 'block_fhl_evasys'),            
	get_string('configdesc_proxyport', 'block_fhl_evasys'),''
));
*/
$settings->add(new admin_setting_configcheckbox(
	'fhl_evasys/ongoing_evaluation',  
	get_string('configlabel_ongoing_evaluation', 'block_fhl_evasys'),            
	get_string('configdesc_ongoing_evaluation', 'block_fhl_evasys'),
	'no',
	'yes',
	'no'
));


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
if (($wsdl!=false)&&($header!=false)&&($soapuser!=false)&&($soappass!=false)) {
	$evasys=new Evasys($wsdl, $header, $soapuser, $soappass);

	if ($evasys) {
		$periods=$evasys->getAllPeriods();
		$period_array=array();
		foreach ($periods->Periods as $period) {
			$period_id=$period->m_nPeriodId;
			$period_title=$period->m_sTitel;
			$period_array[$period_id]=$period_title;
			}
	
		$settings->add(new admin_setting_configselect(
			'fhl_evasys/evaluation_periode', 
			get_string('configlabel_evaluation_periode', 'block_fhl_evasys'),  
			get_string('configdesc_evaluation_periode', 'block_fhl_evasys'),
			'',
			$period_array
		));
	}
}


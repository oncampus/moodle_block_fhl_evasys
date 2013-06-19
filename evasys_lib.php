<?php
class Evasys
{
	public $client=false;
	 
	public function __construct($wsdl,$wsdlheader,$soapuser,$soappass,$proxy='',$proxyport=0)
	{
		$soapclient=false;
		try {
			if (($proxy!='')&&($proxyport!=0)) {
				$soapclient= new SoapClient($wsdl, array('proxy_host' => $proxy,'proxy_port' => intval($proxyport)));			
			} else {
				$soapclient= new SoapClient($wsdl);	
			}
			$ticket = $soapclient->RequestTicket($soapuser,$soappass);
			$header_input = array('Ticket' => $ticket);
			$soapHeaders = new SoapHeader($wsdlheader, 'Header', $header_input);
			$soapclient->__setSoapHeaders( $soapHeaders );
		}
		catch(Exception $e) {
			return false;
		}
		$this->client=$soapclient;
	}	
	
	
	public function getSubunits()
	{
		$return=false;
		try {
			$return = $this->client->GetSubunits();
		}
		catch(Exception $e) {}
		return $return;
	}

	public function getSubunit($SubunitId, $IdType='INTERNAL', $IncludeInstructors=false)
	{
		$return=false;
		try {
			$return = $this->client->GetSubunit(intval($SubunitId),$IdType, $IncludeInstructors);
		}
		catch(Exception $e) {}
		return $return;
	}

	public function GetUsersBySubunit($nSubunitId)
	{
		$return=false;
		try {
			$return = $this->client->GetUsersBySubunit($nSubunitId);
		}
		catch(Exception $e) {}
		return $return;
	}

	public function GetUser($UserId,$IdType='INTERNAL',$IncludeCourses=false,$IncludeSurveys=false,$IncludeParticipants=false)
	{
		$return=false;
		try {
			$return = $this->client->GetUser($UserId,$IdType,$IncludeCourses,$IncludeSurveys,$IncludeParticipants);
		}
		catch(Exception $e) {}
		return $return;
	}

	public function InsertUser($User)
	{
		$return=false;
		try {
			$return = $this->client->InsertUser($User);
		}
		catch(Exception $e) {}
		return $return;
	}

	public function GetCoursesByUserId($nUserId)
	{
		$return=false;
		try {
			$return = $this->client->GetCoursesByUserId($nUserId);
		}
		catch(Exception $e) {}
		return $return;
	}

	public function GetCourse($CourseId,$IdType='INTERNAL',$IncludeSurveys=false,$IncludeParticipants=false)
	{
		$return=false;
		try {
			$return = $this->client->GetCourse($CourseId,$IdType='INTERNAL',$IncludeSurveys,$IncludeParticipants);
		}
		catch(Exception $e) {}
		return $return;
	}

	public function InsertCourse($oCourse)
	{
		$return=false;
		try {
			$return = $this->client->InsertCourse($oCourse);
		}
		catch(Exception $e) {}
		return $return;
	}

	public function GetOnlineSurveyLinkByEmail($SurveyId, $EmailAddress, $AddRecipientToSurvey=true, $AutoIncreasePSWDCount=true)
	{
		$return=false;
		try {
			$return = $this->client->GetOnlineSurveyLinkByEmail(intval($SurveyId), $EmailAddress, $AddRecipientToSurvey, $AutoIncreasePSWDCount);
		}
		catch(Exception $e) {}
		return $return;
	}

	public function GetPDFReport($nSurveyId,$nUserId=0,$nCustomPDFId=0,$nLanguageID=0)
	{
		$return=false;
		try {
			$return = $this->client->GetPDFReport($nSurveyId,$nUserId,$nCustomPDFId,$nLanguageID);
		}
		catch(Exception $e) {}
		return $return;
	}

	public function GetAllPeriods()
	{
		$return=false;
		try {
			$return = $this->client->GetAllPeriods();
		}
		catch(Exception $e) {}
		return $return;
	}

	public function InsertCentralSurvey($nUserId, $nCourseId, $nFormId, $nPeriodId, $sSurveyType='o', $sNotice='')
	{
		$return=false;
		try {
			$return = $this->client->InsertCentralSurvey($nUserId, $nCourseId, $nFormId, $nPeriodId, $sSurveyType, $sNotice);
		}
		catch(Exception $e) {}
		return $return;
	}

	public function GetSurveysByCourse($nCourseId, $nFormId='', $nPeriodId='')
	{
		$return=false;
		try {
			$return = $this->client->GetSurveysByCourse($nCourseId, $nFormId, $nPeriodId);
		}
		catch(Exception $e) {}
		return $return;
	}
	
	public function GetAllForms($IncludeCustomReports=false)
	{
		$return=false;
		try {
			$return = $this->client->GetAllForms($IncludeCustomReports);
		}
		catch(Exception $e) {}
		return $return;
	}	

	public function GetCourseTypes($OnlyModuleCourseTypes=false)
	{
		$return=false;
		try {
			$return = $this->client->GetCourseTypes($OnlyModuleCourseTypes);
		}
		catch(Exception $e) {}
		return $return;
	}		
	
	public function OpenSurvey($nSurveyId)
	{
		$return=false;
		try {
			$return = $this->client->OpenSurvey($nSurveyId);
		}
		catch(Exception $e) {}
		return $return;
	}		
	
	public function CloseSurvey($nSurveyId)
	{
		$return=false;
		try {
			$return = $this->client->CloseSurvey($nSurveyId);
		}
		catch(Exception $e) {}
		return $return;
	}	

	public function GetPDFPswd($SurveyId)
	{
		$return=false;
		try {
			$return = $this->client->GetPDFPswd($SurveyId);
		}
		catch(Exception $e) {}
		return $return;
	}	
	
	public function GetSurveyById($nSurveyId)
	{
		$return=false;
		try {
			$return = $this->client->GetSurveyById($nSurveyId);
		}
		catch(Exception $e) {}
		return $return;
	}		
	
	public function UpdateSurvey($oSurvey)
	{
		$return=false;
		try {
			$return = $this->client->UpdateSurvey($oSurvey);
		}
		catch(Exception $e) {}
		return $return;
	}	

	public function GetPDFQuestionnaire($FormId, $SurveyId='')
	{
		$return=false;
		try {
			$return = $this->client->GetPDFQuestionnaire($FormId, $SurveyId='');
		}
		catch(Exception $e) {var_dump($e);}
		return $return;
	}	
	
	
	public function SendEvasysMail($empfaenger,$betreff='',$inhalt='',$datei=false,$dateiname=false) {
		$id = md5(uniqid(time()));
		$kopf = "From: Evaluationsteam <do_not_reply@oncampus.de>\n";
		$kopf .= "MIME-Version: 1.0\n";
		$kopf .= "Content-Type: multipart/mixed; boundary=$id\n\n";
		$kopf .= "This is a multi-part message in MIME format\n";
		$kopf .= "--$id\n";
		$kopf .= "Content-Type: text/plain\n";
		$kopf .= "Content-Transfer-Encoding: 8bit\n\n";
		$kopf .= utf8_decode($inhalt);
		if ($datei) {
			$dateiinhalt = fread(fopen($datei, "r"), filesize($datei));
			if (!$dateiname) {
				$dateiname=basename($datei);
			}
			$kopf .= "\n--$id";
			$kopf .= "\nContent-Type: application/pdf; name=$dateiname\n";
			$kopf .= "Content-Transfer-Encoding: base64\n";
			$kopf .= "Content-Disposition: attachment; filename=$dateiname\n\n";
			$kopf .= chunk_split(base64_encode($dateiinhalt));
			$kopf .= "\n--$id--";
		}
		mail($empfaenger, $betreff, "", $kopf);
	}
	
	public function GetMailText($anrede=0, $titel=false, $nachname=false, $mailtype='umfrage',$sprache='deutsch',$coursename=false,$linkurl=false) {
		if (($nachname==false) || ($nachname=='') || ($anrede==0)) {
			$begruessung_de='Sehr geehrte Dame, sehr geehrter Herr,';
			$begruessung_en='Dear Madam, dear Sir,';
		} elseif ($anrede==1) {
			$begruessung_de='Sehr geehrter Herr ';
			if (($titel!=false)&&($titel!=''))
				{$begruessung_de.=$titel.' ';}
			$begruessung_de.=$nachname.',';
			$begruessung_en='Dear ';
			if (($titel!=false)&&($titel!=''))
				{$begruessung_en.=$titel.' ';}
			$begruessung_en.=$nachname.',';
		} else {
			$begruessung_de='Sehr geehrte Frau ';
			if (($titel!=false)&&($titel!=''))
				{$begruessung_de.=$titel.' ';}
			$begruessung_de.=$nachname.',';
			$begruessung_en='Dear ';
			if (($titel!=false)&&($titel!=''))
				{$begruessung_en.=$titel.' ';}
			$begruessung_en.=$nachname.',';
		}
		
		$mail_footer_de='Mit freundlichen Grüßen, 
		
Das Evaluationsteam';
		$mail_footer_en='Yours Sincerely,
		 
The evaluation team';		
		
		$mailbody=array();
		$mailbody['umfrage']['deutsch']=$begruessung_de.'

Sie sind hiermit zur Stimmabgabe bei einer Online-Befragung berechtigt. Bitte folgen Sie dem Link, um den Fragebogen zu öffnen.

'.$linkurl.'

'.$mail_footer_de;
		$mailbody['umfrage']['englisch']=$begruessung_en.'
		
This email entitles you to respond to an online survey. Please follow the link to open the questionnaire.

'.$linkurl.'

'.$mail_footer_en;
		$mailbody['tans']['deutsch']=$begruessung_de.'
		
Sie erhalten im Anhang dieser E-Mail die TANs für Ihre Umfrage '.$coursename.'. Bitte drucken Sie diese Seite(n) nun aus. Die TANs können dann ausgeschnitten werden, um sie später nach dem Zufallsprinzip an Studenten zu verteilen.

Diese TANs gelten nur für diese Umfrage.
(Um die TANs darstellen zu können, muß der Adobe Acrobat Reader auf Ihrem Rechner installiert sein.)

'.$mail_footer_de;
		$mailbody['tans']['englisch']=$begruessung_en.'
		
This email contains the passwords (PSWD) for your survey '.$coursename.'. Please print the page(s) now. The PSWDs can later be cut out to be distributed randomly to students.  These PSWDs apply only to this survey. 

Note: Adobe Acrobat Reader must be installed on your computer in order to view the files.

'.$mail_footer_en;
		$mailbody['report']['deutsch']=$begruessung_de.'

Sie erhalten hier die Ergebnisse der automatisierten Auswertung der Lehrveranstaltungsevaluation zur Veranstaltung '.$coursename.'.		
		
'.$mail_footer_de;
		$mailbody['report']['englisch']=$begruessung_en.'
		
In the attachment you will find the evaluation results of the survey '.$coursename.'.	
		
'.$mail_footer_en;
		$mailbody['reminder']['deutsch']=$begruessung_de.'

wir möchten Sie erinnern, dass Sie zur Stimmabgabe bei einer Online-Befragung berechtigt sind. Bitte folgen Sie dem Link, um den Fragebogen zu öffnen.

'.$linkurl.'		
		
'.$mail_footer_de;
		$mailbody['reminder']['englisch']=$begruessung_en.'
		
This email should remind you that you are entitled respond to a survey. Please follow the link to open the questionnaire.
 
'.$linkurl.'
		
'.$mail_footer_en;		
		return utf8_encode($mailbody[$mailtype][$sprache]);
	}
		
	
	
}

?>
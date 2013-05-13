<?php

/**
 * IMVA Oxid2CR 3 (Open Source Edition)
 * 
 * 
 * Redistribution permitted.
 * 
 * Weitergabe verboten.
 * 
 *
 * This Software is intellectual property of imva.biz respectively of its author and is protected
 * by copyright law. This software product is open-source, but not freeware.
 *
 * Any unauthorized use of this software product - usage without a valid license,
 * modification, copying, redistribution, transmission is a violation of the license agreement
 * and will be prosecuted by civil and criminal law.
 * 
 * By applying and using this software product, you agree to the terms and condition of usage and
 * furthermore agree, not to share information, source codes, technologies, credentials and addresses
 * of any kind.
 * 
 *  
 * Mit der Übernahme dieser Software akzeptieren Sie die zwischen Ihnen und dem Herausgeber
 * festgehaltenen Bedingungen und wahren Stillschweigen über die Ihnen zugänglich gemachten
 * Informationen, Quellcodes, Technologien, Zugangsdaten und Adressen jeglicher Art.
 * Der Bruch dieser Bedingungen kann Schadensersatzforderungen nach sich ziehen.
 * 
 * (c) 2012-2013 imva.biz, Johannes Ackermann, ja@imva.biz
 * @author Johannes Ackermann
 * 
 * 12/3/3-13/5/13
 * V 2.9.0.0
 * 
 */

class imva_oxid2cr extends oxUbase{
	
	protected $_sThisTemplate = 'imva_oxid2cr.tpl';
	
	/**
	 * parameters for debugging
	 */
	protected $_debug;
	protected $_simulation;
	
	/**
	 * Maximum amount of lines to process per call
	 */
	protected $_prfm_max_lines;
	
	
	
	/**
	 * Constructor
	 * Get and set some configuration parameters
	 */
	function __construct(){
		$oSvc = new imva_oxid2cr_service;
		
		$this->_debug = $oSvc->readImvaConfig('debug');
		$this->_simulation = $oSvc->readImvaConfig('simulation');
		$this->_prfm_max_lines = $oSvc->readImvaConfig('prfm_max_lines');
	}
	
	
	
	/**
	 * Configuration Part
	 * Contains an Array with the reqired settings: licensing, connection, Oxid params
	 */	
	private function config($sParam){
		
		$aConfigParams = array(
		'devmode'						=>	$oSvc->readImvaConfig('devmode'),
		'clre_api_key'					=>	$oSvc->readImvaConfig('clre_api_key'),
		'clre_wsdl_url'					=>	str_replace('http:','https:',$oSvc->readImvaConfig('clre_wsdl_url')),
		'clre_list_id'					=>	$oSvc->readImvaConfig('clre_list_id'),
		'clre_field_firstname'			=>	$oSvc->readImvaConfig('clre_field_firstname'),
		'clre_field_lastname'			=>	$oSvc->readImvaConfig('clre_field_lastname'),
		'clre_field_salutation'			=>	$oSvc->readImvaConfig('clre_field_salutation'),
		);
		
		if (($sParam != '') and ($aConfigParams[$sParam] != '')){
			return $aConfigParams[$sParam];
		}
		else{
			return false;
		}		
	}
	
	
	
	/**
	 * Collect Subscribers
	 * 
	 * Puts subscribers into an array.
	 * @return array
	 */
	public function collectSubscribers($sMode){
		$oRequestSubscribers = oxDb::getDB(true)->execute($this->_getSubscribers($sMode));
		
		if (($oRequestSubscribers != false and $oRequestSubscribers->recordCount() > 0)){
			
			$aSubscribers = array();
			$iCounter = 0;
						
			while ($iCounter <= $oRequestSubscribers->recordCount() - 1){
				if ($this->_debug == '1'){
					echo $iCounter.': ';
				}
				$aSubscribers[$iCounter] = array(
					'OXSAL'			=>	$oRequestSubscribers->fields['OXSAL'],
					'OXFNAME'		=>	$oRequestSubscribers->fields['OXFNAME'],
					'OXLNAME'		=>	$oRequestSubscribers->fields['OXLNAME'],
					'OXEMAIL'		=>	$oRequestSubscribers->fields['OXEMAIL'],
					'OXSUBSCRIBED'	=>	$oRequestSubscribers->fields['OXSUBSCRIBED'],
				);
				
				if ($this->_debug == '1'){
					echo $aSubscribers[$iCounter]['OXEMAIL'];
					echo '<br/>';
				}
				
				if ($this->_debug == '1'){
					echo 'Sending subscriber to CR<br />';
				}
				$this->_sendToCr($sMode,$aSubscribers[$iCounter]['OXFNAME'],$aSubscribers[$iCounter]['OXLNAME'],$aSubscribers[$iCounter]['OXEMAIL'],$aSubscribers[$iCounter]['OXSAL'],$aSubscribers[$iCounter]['OXSUBSCRIBED']);

				if ($this->_debug == '1'){
					echo 'Updating subscribers dataset<br />';
				}
				
				$this->_updateSentUser($aSubscribers[$iCounter]['OXEMAIL']);
				
				$oRequestSubscribers->moveNext();
				$iCounter++;
			}
						
			unset($iCounter);
			return $aSubscribers;
		}
		else{
			return false;
		}
		
		$this->_imva_action_logger(collectSubscribers,'','','','',$sMode);
	}
	
	/**
	 * Put cancellers into an array
	 */
	private function _collectOxidCancellers(){
		$oRequestCancellers = oxDb::getDB(true)->execute($this->_getCancellersFromDb());
		
		if (($oRequestCancellers != false and $oRequestCancellers->recordCount() > 0)){
			
			$aSubscribers = array();
			$iCounter = 0;
						
			while ($iCounter <= $oRequestCancellers->recordCount() - 1){
				if ($this->_debug == '1'){
					echo $iCounter.': ';
				}
				$aCancellers[$iCounter] = array(
					'OXSAL'			=>	$oRequestCancellers->fields['OXSAL'],
					'OXFNAME'		=>	$oRequestCancellers->fields['OXFNAME'],
					'OXLNAME'		=>	$oRequestCancellers->fields['OXLNAME'],
					'OXEMAIL'		=>	$oRequestCancellers->fields['OXEMAIL'],
					'OXSUBSCRIBED'	=>	$oRequestCancellers->fields['OXSUBSCRIBED'],
				);
				
				if ($this->_debug == '1'){
					echo $aCancellers[$iCounter]['OXEMAIL'];
					echo '<br/>';
				}
				
				if ($this->_debug == '1'){
					echo 'Sending canceller to CR<br />';
				}
				$this->_cancelAccnt($aCancellers[$iCounter]['OXEMAIL']);

				if ($this->_debug == '1'){
					echo 'Updating subscribers dataset<br />';
				}
				
				$this->_updateSentUser($aCancellers[$iCounter]['OXEMAIL']);
				
				$oRequestCancellers->moveNext();
				$iCounter++;
			}
						
			unset($iCounter);
			return $aCancellers;
		}
		else{
			return false;
		}
		
		$this->_imva_action_logger(collectOxidCancellers,'','','','','default');
	}
	
	
	
	/**
	 * SQL Statements Block
	 * 
	 * Set up database
	 */
	private function _setupDb(){
		//create table imva_oxid2cr_log
		$sSqlRequest = "CREATE TABLE IF NOT EXISTS imva_oxidmodules (
			  mod_name varchar(128) NOT NULL,
			  action varchar(128) NOT NULL DEFAULT 'unknown',
			  data1 varchar(255) NOT NULL,
			  data2 varchar(255) NOT NULL,
			  data3 varchar(255) NOT NULL,
			  data4 varchar(255) NOT NULL,
			  param varchar(255) NOT NULL,
			  timestamp timestamp NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='imva.biz-Module für Oxid';";
		if ($this->_debug == '1'){
			echo $sSqlRequest.'--<br />';
		}		
		oxDb::getDB(true)->execute($sSqlRequest);
		
		//set up imva_oxid2cr_sent
		$sSqlRequest = "ALTER TABLE oxnewssubscribed ADD imva_oxid2cr_sent INT( 1 ) NOT NULL DEFAULT 0";
		if ($this->_debug == '1'){
			echo $sSqlRequest.'--<br />';
		}		
		oxDb::getDB(true)->execute($sSqlRequest);
		
		//set up imva_oxid2cr_cancelled
		$sSqlRequest = "ALTER TABLE oxnewssubscribed ADD imva_oxid2cr_cancelled INT( 1 ) NOT NULL DEFAULT 0";
		if ($this->_debug == '1'){
			echo $sSqlRequest.'--<br />';
		}		
		oxDb::getDB(true)->execute($sSqlRequest);
	}
	
	
	
	/**
	 * Uninstall
	 */
	private function _removeDb(){
		$sSqlRequest = "ALTER TABLE oxnewssubscribed DROP imva_oxid2cr_sent";
		oxDb::getDB(true)->execute($sSqlRequest);
		$sSqlRequest = "ALTER TABLE oxnewssubscribed DROP imva_oxid2cr_cancelled";
		oxDb::getDB(true)->execute($sSqlRequest);
	}
	
	
	
	/**
	 * Create SQL Request to mark sent users in db
	 * @param string $sMail
	 * @return string
	 */
	private function _buildUserUpdater($sMail){
		$sSqlRequest = "UPDATE oxnewssubscribed ";
		$sSqlRequest .= "SET imva_oxid2cr_sent = 1 ";
		$sSqlRequest .= "WHERE OXEMAIL = '".$sMail."' ";
		$sSqlRequest .= "AND imva_oxid2cr_sent = 0 ";
		$sSqlRequest .= "LIMIT 1";
		
		if ($this->_debug == '1'){
			echo $sSqlRequest;
		}
		
		return $sSqlRequest;
	}
	
	
	
	/**
	 * Update sent users 
	 */
	 private function _updateSentUser($sMail){
		if ($this->_debug == '1'){
			echo 'The Users Mail: '.$sMail.'--<br />';
		}
		oxDb::getDB(true)->execute($this->_buildUserUpdater($sMail));
	}
	
	
	
	/**
	 * Fetch subscribers from db
	 */
	private function _buildSqlRequest(){
		$sSqlRequest = "SELECT OXSAL, OXFNAME, OXLNAME, OXEMAIL FROM ";
		$sSqlRequest .= "oxnewssubscribed WHERE OXDBOPTIN = 1 and OXEMAILFAILED = 0 ";
		$sSqlRequest .= "and OXID != '".$this->config('oxid_adminid')."' ";
		$sSqlRequest .= "and imva_oxid2cr_sent = 0 ";
		$sSqlRequest .= "and imva_oxid2cr_cancelled = 0 ";
		if ($this->_prfm_max_lines){$sSqlRequest .= "LIMIT ".$this->_prfm_max_lines." ";}
		
		if ($this->_debug == '1'){
			echo $sSqlRequest;
		}
		
		return $sSqlRequest;
	}
	
	
	
	/**
	 * Get subscribers SQL statement
	 * 
	 * @return string
	 */
	private function _getSubscribers($sMode){
		$sSqlRequest = "SELECT OXSAL, OXFNAME, OXLNAME, OXEMAIL FROM ";
		$sSqlRequest .= "oxnewssubscribed WHERE OXDBOPTIN = 1 and OXEMAILFAILED = 0 ";
		$sSqlRequest .= "and OXID != '".$this->config('oxid_adminid')."' ";
		
		if ($sMode == 'add'){
			$sSqlRequest .= "and imva_oxid2cr_sent = 0 ";
			if ($this->_prfm_max_lines){$sSqlRequest .= "LIMIT ".$this->_prfm_max_lines." ";}
		}
		
		if ($sMode == 'update'){
			$sSqlRequest .= "and imva_oxid2cr_sent = 1 ";
		}
		
		if ($this->_debug == '1'){
			echo $sSqlRequest;
		}
		
		return $sSqlRequest;
	}
	
	
	
	/**
	 * Get cancellers
	 * @return string
	 */
	private function _getCancellersFromDb(){
		$sSqlRequest = "SELECT OXEMAIL FROM ";
		//$sSqlRequest .= "oxnewssubscribed WHERE OXDBOPTIN = 0 AND OXEMAILFAILED = 0 ";
		$sSqlRequest .= "oxnewssubscribed ";
		$sSqlRequest .= "WHERE imva_oxid2cr_cancelled = 1 ";
		$sSqlRequest .= "AND imva_oxid2cr_sent = 0 ";
		$sSqlRequest .= "AND OXID != '".$this->config('oxid_adminid')."' ";
		if ($this->_prfm_max_lines){$sSqlRequest .= "LIMIT ".$this->_prfm_max_lines." ";}
		
		if ($this->_debug == '1'){
			echo $sSqlRequest;
		}
		
		return $sSqlRequest;
	}
	

	
	/**
	 * Unlock transferred users in order to enable for re-upload
	 * @return string
	 */
	private function _buildUserUnlocker(){
		$sSqlRequest = "UPDATE oxnewssubscribed ";
		$sSqlRequest .= "SET imva_oxid2cr_sent = 0 ";
		$sSqlRequest .= "WHERE imva_oxid2cr_sent = 1";
		
		if ($this->_debug == '1'){
			echo $sSqlRequest;
		}
		
		return $sSqlRequest;
	}	
	
	
	
	/**
	 * Get amount of open subscribers
	 */
	public function getOpenSubscribers(){
		$sSqlRequest = "SELECT COUNT(*) FROM oxnewssubscribed WHERE imva_oxid2cr_sent = 0 AND imva_oxid2cr_cancelled = 0 AND OXDBOPTIN = 1 and OXEMAILFAILED = 0 AND OXID != '".$this->config('oxid_adminid')."'";
		$oReq = oxDb::getDB(true)->execute($sSqlRequest);
		return $oReq->fields['COUNT(*)'];
	}
	
	
	
	public function getTransferredSubscribers(){
		$sSqlRequest = "SELECT COUNT(*) FROM oxnewssubscribed WHERE imva_oxid2cr_sent = 1 AND OXDBOPTIN = 1 and OXEMAILFAILED = 0";
		$oReq = oxDb::getDB(true)->execute($sSqlRequest);
		return $oReq->fields['COUNT(*)'];
	}
	
	
	
	public function getAmountOfCancellers(){
		if (!$this->_isDemoLicense()){
			$sSqlRequest = "SELECT COUNT(*) FROM oxnewssubscribed WHERE imva_oxid2cr_sent = 0 AND imva_oxid2cr_cancelled = 1";
			$oReq = oxDb::getDB(true)->execute($sSqlRequest);
			return $oReq->fields['COUNT(*)'];
		}
		else{
			return false;
		}
	}
	
	
	
	public function countRows(){
		if (($this->getAction == 'unlockAll') and ($oConfig->getParameter('imva_frm_chk') == 1) and ($this->imva_auth() == true)){
			return $this->getTransferredSubscribers();
		}
		elseif (($this->getAction == 'send2cr') and ($oConfig->getParameter('imva_frm_chk') == 1) and ($this->imva_auth() == true)){
			return $this->_prfm_max_lines;
		}
		else{
			return $this->_prfm_max_lines;
		}
	}
	
	
	
	private function _imva_action_logger($action,$d1,$d2,$d3,$d4,$p){
		$sSqlRequest = "INSERT INTO imva_oxidmodules (mod_name, action, data1, data2, data3, data4, param, timestamp) VALUES ('imva_oxid2cr3', '".$action."', '".$d1."', '".$d2."', '".$d3."', '".$d4."', '".$p."', CURRENT_TIMESTAMP)";
		oxDb::getDB(true)->execute($sSqlRequest);
	}
	
	
	
	//Filters
	private function filterUserdata($sSalutation){
		switch ($sSalutation){
			case 'MR':
				return 'm';
				break;
			case 'Herr':
				return 'm';
				break;
			case 'MRS':
				return 'f';
				break;
			case 'MS':
				return 'f';
				break;
			case 'Frau':
				return 'f';
				break;
			default:
				return 'n';
		}
	}
	
	
	
	/**
	 * Slide on the Soap:
	 * 
	 * Add Subscribers to CleverReach
	 */
	private function _sendToCr($sMode,$sForename,$sLastname,$sEmail,$sSalutation,$sSubscDate){
		$oSoap = new SoapClient($this->config('clre_wsdl_url'));		
		
		//Retrieve available receiver lists
		$sCrReply = $oSoap->groupGetList($this->config('clre_api_key'));
		
		if ($this->_debug == '1'){
			if ($sCrReply->status == 'SUCCESS'){
				var_dump($sCrReply->data);
			}
			else{
				var_dump($sCrReply->message);
			}
		}
		
		//user data
		$aUserdata = array(
		     'email' => $sEmail,
		     'registered' => time(),
		     'activated' => time(),
		     'source' => "Oxid eShop via imva_oxid2cr3",
		     'attributes' => array(
		         0 => array('key' => 'firstname', 'value' => $sForename),
		         1 => array('key' => 'lastname', 'value' => $sLastname),
		         2 => array('key' => 'salutation', 'value' => $sSalutation),
		     ),
		);

		if ($this->_simulation == '0'){
			if ($sMode == 'add'){
				$sCrReply = $oSoap->receiverAdd($this->config('clre_api_key'),$this->config('clre_list_id'),$aUserdata);
				$sCrReply = $oSoap->receiverUpdate($this->config('clre_api_key'),$this->config('clre_list_id'),$aUserdata);
			}
			elseif ($sMode == 'update'){
				$sCrReply = $oSoap->receiverUpdate($this->config('clre_api_key'),$this->config('clre_list_id'),$aUserdata);
			}
			/*elseif ($sMode == 'disable'){
				$sCrReply = $oSoap->receiverSetInactive($this->config('clre_api_key'),$this->config('clre_list_id'),$aUserdata);
			}*/
		}
		
		$this->_imva_action_logger(sendToCr,'','','','',$sMode);
		
		//clean up
		unset($aUserdata,$sCrReply,$oSoap);
	}
	
	
	
	/**
	 * Send cancelled subscriptions to CR
	 */
	private function _cancelAccnt($sEmail){
		$oSoap = new SoapClient($this->config('clre_wsdl_url'));		
		
		//Retrieve available receiver lists
		$sCrReply = $oSoap->groupGetList($this->config('clre_api_key'));
		
		if ($this->_debug == '1'){
			if ($sCrReply->status == 'SUCCESS'){
				var_dump($sCrReply->data);
			}
			else{
				var_dump($sCrReply->message);
			}
		}
		
		//user data
		$aUserdata = array(
		     'email' => $sEmail,
		     'registered' => time(),
		     'activated' => time(),
		     'source' => 'Oxid eShop via imva_oxid2cr3',
		);

		if ($this->_simulation == '0'){
			$sCrReply = $oSoap->receiverSetInactive($this->config('clre_api_key'),$this->config('clre_list_id'),$aUserdata['email']);
		}
		
		$this->_imva_action_logger('cancelAccount',$aUserdata['email'],'','','','disable');
		unset($aUserdata,$sCrReply,$oSoap,$theUser);
	}
	
	
	
	/**
	 * GUI Helpers // Actions
	 */
	
	
	
	/**
	 * action getter
	 * 
	 * @return string
	 */
	public function getAction(){
		$oConfig = $this->getConfig();
		$sAction = $oConfig->getParameter('action');
		if ($sAction){
			return $sAction;
		}
		else{
			return false;
		}
	}
	
	
	
	/**
	 * action caller
	 * 
	 * @return string
	 */
	private function _executeAction(){
		$sAction = $this->getAction();
		if ($sAction and $this->imva_auth()){
		switch($sAction){
			case 'send2cr':
				$this->collectSubscribers('add');
				$this->_imva_action_logger($sAction,'','','','','');
				break;
			case 'cancelcr2ox':
				$this->_imva_action_logger($sAction,'','','','','');
				break;
			case 'cancelox2cr':
				$this->_collectOxidCancellers();
				$this->_imva_action_logger($sAction,'','','','','');
				break;
			case 'updateSent':
				$this->collectSubscribers('update');
				$this->_imva_action_logger($sAction,'','','','','');
				break;
			case 'unlockAll':
				$this->_unlockAllUsers();
				$this->_imva_action_logger($sAction,'','','','','');
				break;
			case 'activate':
				$this->_activate();
				break;
			case 'phpinfo':
				$this->_phpinfo();
				break;
			case 'setup':
				$this->_setupDb();
				$this->_imva_action_logger($sAction,'','','','','');
				break;
			case 'uninstall':
				$this->_removeDb();
				$this->_imva_action_logger($sAction,'','','','','');
				break;
			default:
				return false;
		}
		}
	}
	
	
	
	/**
	 * function imva_auth
	 * 
	 * Checks, if user has authenticated by unlock secret
	 * @return boolean
	 */
	public function imva_auth(){
		$oConfig = $this->getConfig();
		if ($oConfig->getParameter('imva_auth_key') == $this->config('internal_unlock_secret')){
			return true;
		}
		else{
			return false;
		}
	}

	

	private function _unlockAllUsers(){
		oxDb::getDB(true)->execute($this->_buildUserUnlocker());
	}
	
	
	
	/**
	 * ... and now: pass it over to the template.
	 * We're done here.
	 * 
	 * @return string
	 */	
	public function render(){
		parent::render();
		
		$oSvc = new imva_oxid2cr_service;
		$this->_aViewData['oSvc'] = $oSvc;
		
		
		$this->_aViewData['starttime'] = time();
		
		$oConfig = $this->getConfig();
		$this->_aViewData['affected_rows'] = 2;
		
		// Operation parameters
		if ($oConfig->getParameter('debug') != ''){
			$this->_debug = $oConfig->getParameter('debug');
		}
		if ($oConfig->getParameter('simulation') != ''){
			$this->_simulation = $oConfig->getParameter('simulation');
		}
		if ($oConfig->getParameter('tr_lmt') != ''){
			$this->_prfm_max_lines = $oConfig->getParameter('tr_lmt');
		}
		
		if ($oConfig->getParameter('client') != ''){
			$this->_aViewData['client'] = $oConfig->getParameter('client');
		}
		
		if ($oConfig->getParameter('action') != ''){
			$this->_aViewData['int_action'] = $this->getAction();
		}
		
		// Attachable Parameters for hyperlinks
		if ($this->imva_auth()){
			$this->_aViewData['int_authtl'] = '&amp;imva_auth_key='.$this->config('internal_unlock_secret').'&amp;imva_frm_chk=1&amp;client=user';
			if ($this->_debug){$this->_aViewData['int_authtl'] .= '&amp;debug='.$this->_debug;}
			if ($this->_simulation){$this->_aViewData['int_authtl'] .= '&amp;simulation='.$this->_simulation;}
		}
		else{
			$this->_aViewData['int_authtl'] = '';
		}
			

		
		$this->_executeAction();
		
		//auth+form successful
		if (($oConfig->getParameter('imva_frm_chk') == 1) and ($this->imva_auth())){
			$this->_aViewData['int_frm_state'] = 'success';
			$this->_aViewData['affected_rows'] = $this->countRows();

			if ($this->getAction() == 'send2cr'){
				//$imva_oViewConf = oxConfig::getInstance()->getActiveView();
				$imva_oViewConf = oxConfig::getInstance();
				
				$sBuildCjURL = $imva_oViewConf->getConfigParam('sSSLShopURL');
				$sBuildCjURL .= '?cl='.$imva_oViewConf->getActiveView()->getClassName();
				$sBuildCjURL .= '&amp;action='.$this->getAction();
				$sBuildCjURL .= '&amp;imva_auth_key='.htmlentities($this->config('internal_unlock_secret'));
				$sBuildCjURL .= '&amp;imva_frm_chk=1';
				//$sBuildCjURL .= '&amp;client=machine';
				
				$this->_aViewData['cronjob_url'] = $sBuildCjURL;
			}
			elseif ($this->getAction() == 'uninstall'){
				//nothing
			}
			else{
				//nothing else
			}
			
		}
		//auth failed
		elseif (($oConfig->getParameter('imva_frm_chk') == 1) and ($this->imva_auth() == false)){
			$this->_aViewData['int_frm_state'] = 'fail';
			$this->_aViewData['affected_rows'] = $this->countRows();
		}
		//nothing happened
		else{
			$this->_aViewData['int_frm_state'] = 'empty';
		}
	
		$this->_aViewData['endtime'] = time();			
		$this->_aViewData['duration'] = $this->_aViewData['endtime'] - $this->_aViewData['starttime'];
		
		return $this->_sThisTemplate;
	}
}
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
 * 12/3/3-13/5/14
 * V 2.9.2.10
 * 
 */

class imva_oxid2cr_service extends oxBase
{
	
	public $blMission;
	protected $_oSupport;
	
	
	
	/**
	 * __construct
	 * Sets Config and Service
	 *
	 * @return null
	 */
	public function __construct(){
		parent::__construct();
		$this->_oConfig = $this->getConfig();
	}
	
	
	
	/**
	 * _getBasics
	 * Some bsaic information about this module. Hard-coded by choice.
	 * 
	 * @return string
	 */
	function _getBasics($sInfo)
	{
		$aBasics = array(
				'version'	=>	'2.9.2.10',
				'build'		=>	'130514',
				'edition'	=>	'open',		
		);
		
		if (!$sInfo)
			return false;
		return $aBasics[$sInfo];
	}
	
	
	
	/**
	 * Read config data from imva_config
	 * 
	 * @return string
	 */
	function readImvaConfig($sParam = null)
	{
		if ($sParam)
		{
			$sSqlRequest = 'SELECT value FROM imva_config WHERE module_name = "imva_oxid2cr3" AND param = "'.$sParam.'"';
			return oxDb::getDb(true)->getone($sSqlRequest);
		}
		else{
			return false;
		}
	}
	
	
	
	/**
	 * getVersion
	 *
	 * @return string
	 */
	public function getVersion()
	{
		$sReturn = $this->_getBasics('version').' '.
			'<i>'.$this->_getBasics('edition').'</i> '.
			'build '.$this->_getBasics('build');
		
		if ($this->_getBasics('edition') == 'open'){
			$sReturn .= '<br />This module is free. You can <a href="http://imva.biz/blog/2013/05/oxid-modul-adapter-fur-cleverreach-wird-quelloffen/" target="_blank">support the developers by flattr</a>';
		}
		
		return $sReturn;
	}
	
	

	/**
	 * isInstalled
	 * Tries to find out if the db has been set up.
	 * 
	 * @return boolean
	 */
	public function isInstalled(){
		if ($this->readImvaConfig('clre_wsdl_url')){
			return true;
		}
		else{
			return false;
		}
	}
	


	/**
	 * Get subscribers SQL statement
	 *
	 * @return string
	 */
	private function _getSubscribers($sMode){
		$sSqlRequest = "SELECT OXSAL, OXFNAME, OXLNAME, OXEMAIL FROM ";
		$sSqlRequest .= "oxnewssubscribed WHERE OXDBOPTIN = 1 AND OXEMAILFAILED = 0 ";
		
		//add
		if ($sMode == 'add'){
			$sSqlRequest .= "and imva_oxid2cr_sent = 0 ";
			if ($this->readImvaConfig('prfm_max_lines')){
				$sSqlRequest .= "LIMIT ".$this->readImvaConfig('prfm_max_lines')." ";
			}
		}
		
		//Update
		if ($sMode == 'update'){
			$sSqlRequest .= "and imva_oxid2cr_sent = 1 ";
		}
	
		//debugger
		if ($this->readImvaConfig('debug') == '1'){
			echo '_getSubscribers: ';
			echo $sSqlRequest;
			echo '--<br />';
		}
	
		//echo '<h1>'.$sSqlRequest.'</h1>';
		return $sSqlRequest;
	}
	
	
	
	/**
	 * get Cancellers
	 */
	private function _getCancellersFromDb(){
		$sSqlRequest = "SELECT OXEMAIL FROM ";
		//$sSqlRequest .= "oxnewssubscribed WHERE OXDBOPTIN = 0 AND OXEMAILFAILED = 0 ";
		$sSqlRequest .= "oxnewssubscribed ";
		$sSqlRequest .= "WHERE imva_oxid2cr_cancelled = 1 ";
		$sSqlRequest .= "AND imva_oxid2cr_sent = 0 ";
		if ($this->readImvaConfig('prfm_max_lines')){$sSqlRequest .= "LIMIT ".$this->_prfm_max_lines." ";}
	
		if ($this->readImvaConfig('debug') == '1'){
			echo '_getCancellersFromDb';
			echo $sSqlRequest;
			echo '--<br />';
		}
	
		return $sSqlRequest;
	}
	
	
	
	/**
	 * Unlock all subscriptions in order to allow re-upload
	 * 
	 * @return string
	 */
	private function _buildUserUnlocker(){
		$sSqlRequest = "UPDATE oxnewssubscribed ";
		$sSqlRequest .= "SET imva_oxid2cr_sent = 0 ";
		$sSqlRequest .= "WHERE imva_oxid2cr_sent = 1";
	
		if ($this->readImvaConfig('debug') == '1'){
			echo '_buildUserUnlocker';
			echo $sSqlRequest;
			echo '--<br />';
		}
	
		return $sSqlRequest;
	}
	
	
	
	/**
	 * activateSupport
	 * 
	 * 
	 */
	public function activateSupport()
	{
		if (!$this->_oSupport){
			$this->_oSupport = new imva_oxid2cr_support;
		}
		
		return $this->_oSupport->activate();
	}
	
	
	
	// Get numbers for statistcs //////////////////////////
	
	/**
	 * getOpenSubscribers()
	 * @return int
	 */
	public function getOpenSubscribers(){
		if ($this->isInstalled()){
			$sSqlRequest = "SELECT COUNT(*) FROM oxnewssubscribed WHERE imva_oxid2cr_sent = 0 AND imva_oxid2cr_cancelled = 0 AND OXDBOPTIN = 1 and OXEMAILFAILED = 0";
			$oReq = oxDb::getDb(true)->execute($sSqlRequest);
			//return $oReq->fields['COUNT(*)'];
			return $oReq->fields[0];
		}
		else{
			return false;
		}
	}
	
	
	
	/**
	 * getTransferredSubscribers()
	 * @return int
	 */
	public function getTransferredSubscribers(){
		if ($this->isInstalled()){
			$sSqlRequest = "SELECT COUNT(*) FROM oxnewssubscribed WHERE imva_oxid2cr_sent = 1 AND OXDBOPTIN = 1 and OXEMAILFAILED = 0";
			$oReq = oxDb::getDb(true)->execute($sSqlRequest);
			return $oReq->fields[0];
		}
		else{
			return false;
		}
	}
	
	
	
	/**
	 * getAmountOfCancellers()
	 * @return int
	 */
	public function getAmountOfCancellers(){
		if ($this->isInstalled()){
			$sSqlRequest = "SELECT COUNT(*) FROM oxnewssubscribed WHERE imva_oxid2cr_sent = 0 AND imva_oxid2cr_cancelled = 1";
			$oReq = oxDb::getDb(true)->execute($sSqlRequest);
			return $oReq->fields[0];
		}
		else{
			return false;
		}
	}
	
	
	
	/**
	 * action getter
	 *
	 * @return string
	 */
	public function getAction(){
		if ($this->_oConfig->getParameter('action') || $this->_oConfig->getParameter('action') != ''){
			return $this->_oConfig->getParameter('action');
		}
		else{
			return false;
		}
	}
	
	
	
	/**
	 * logger
	 * Writes actions to db
	 *
	 * @return null
	 */
	public function log($action,$d1 = '',$d2 = '',$d3 = '',$d4 = '',$p = ''){
		$sSqlRequest = "INSERT INTO imva_oxidmodules (mod_name, action, data1, data2, data3, data4, param, timestamp) VALUES ('imva_oxid2cr3', '".$action."', '".$d1."', '".$d2."', '".$d3."', '".$d4."', '".$p."', CURRENT_TIMESTAMP)";
		oxDb::getDb(true)->execute($sSqlRequest);
	}
	
	
	
	/**
	 * Slide on the Soap:
	 *
	 * Add Subscribers to CleverReach
	 * Requires working connection to the CR service.
	 *
	 * @return null
	 */
	private function _sendToCr($sMode,$sForename,$sLastname,$sEmail,$sSalutation,$sSubscDate){
		if ($this->readImvaConfig('simulation') == '0'){
			$oSoap = new SoapClient($this->readImvaConfig('clre_wsdl_url'));
			
			//Retrieve available receiver lists
			$sCrReply = $oSoap->groupGetList($this->readImvaConfig('clre_api_key'));
		
			if ($sCrReply->status == 'SUCCESS'){
				$this->blMission = true;
				if ($this->readImvaConfig('debug') == '1'){
					echo 'Connection State is SUCCESS';
					var_dump($sCrReply->data);
				}
			}
			else{
				$this->blMission = false;
				if ($this->readImvaConfig('debug') == '1'){
					echo 'Connection State is FAILURE';
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
			
			
			if ($sMode == 'add'){
				$oSoap->receiverAdd($this->readImvaConfig('clre_api_key'),$this->readImvaConfig('clre_list_id'),$aUserdata);
				$oSoap->receiverUpdate($this->readImvaConfig('clre_api_key'),$this->readImvaConfig('clre_list_id'),$aUserdata);
			}
			elseif ($sMode == 'update'){
				$oSoap->receiverUpdate($this->readImvaConfig('clre_api_key'),$this->readImvaConfig('clre_list_id'),$aUserdata);
			}
			//elseif ($sMode == 'disable'){
			//$sCrReply = $oSoap->receiverSetInactive($this->readImvaConfig('clre_api_key'),$this->readImvaConfig('clre_list_id'),$aUserdata);
			//}
		
			$this->log('sendToCr','','','','',$sMode);
		
			//clean up
			unset($aUserdata,$sCrReply,$oSoap);
		}
		$this->blMission = true;
	}
	
	
	
	/**
	 * Send cancelled subscriptions to CR
	 * Set it to "disabled", do not delete data!
	 */
	private function _cancelAccnt($sEmail){
		if ($this->readImvaConfig('simulation') == '0'){
			$oSoap = new SoapClient($this->readImvaConfig('clre_wsdl_url'));
		
			//Retrieve available receiver lists
			$sCrReply = $oSoap->groupGetList($this->readImvaConfig('clre_api_key'));
		
			if ($sCrReply->status == 'SUCCESS'){
				$this->blMission = true;
				if ($this->readImvaConfig('debug') == '1'){
					echo 'Connection State is SUCCESS';
					var_dump($sCrReply->data);
				}
			}
			else{
				$this->blMission = false;
				if ($this->readImvaConfig('debug') == '1'){
					echo 'Connection State is FAILURE';
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
		
			$oSoap->receiverSetInactive($this->readImvaConfig('clre_api_key'),$this->readImvaConfig('clre_list_id'),$aUserdata['email']);
			
			$this->log('cancelAccount',$aUserdata['email'],'','','','disable');
			
			//Clean up
			unset($aUserdata,$sCrReply,$oSoap,$theUser);
		}
	}
	
	
	
	/**
	 * Collect Subscribers
	 *
	 * Puts subscribers into an array.
	 * @return array
	 */
	public function collectSubscribers($sMode)
	{
		$aRequestSubscribers = oxDb::getDb(true)->getAll($this->_getSubscribers($sMode)); //subscribers array
		$oRequestSubscribers = oxDb::getDb(true)->execute($this->_getSubscribers($sMode)); //subscribers reques object
				
		if ($this->readImvaConfig('debug') == '1'){
			echo '<pre>';
			var_dump($aRequestSubscribers);
			echo '</pre>';
			echo $oRequestSubscribers->recordCount();
		}
		
		if (($oRequestSubscribers != false && $oRequestSubscribers->recordCount() > 0)){
				
			$aSubscribers = array();
			$iCounter = 0;
	
			while ($iCounter <= $oRequestSubscribers->recordCount() - 1){
				
				if ($this->readImvaConfig('debug') == '1'){
					echo $iCounter.': ';
				}
				$aSubscribers[$iCounter] = array(
						'OXSAL'			=>	$aRequestSubscribers[0][0],
						'OXFNAME'		=>	$aRequestSubscribers[0][1],
						'OXLNAME'		=>	$aRequestSubscribers[0][2],
						'OXEMAIL'		=>	$aRequestSubscribers[0][3],
						'OXSUBSCRIBED'	=>	$aRequestSubscribers[0][4],
				);
	
				if ($this->readImvaConfig('debug') == '1'){
					var_dump($aSubscribers);
					echo '<hr />';
					echo $aSubscribers[$iCounter]['OXEMAIL'];
					echo '<br/>';
				}
	
				if ($this->readImvaConfig('debug') == '1'){
					echo 'aSubscribers:<br />';
					print_r($aSubscribers);
					echo ' --aSubscribers<br />';
				}
				
				if ($this->readImvaConfig('debug') == '1'){
					echo 'Updating subscribers dataset<br />';
				}
	
				// update subscription
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
	
		$this->log('collectSubscribers','','','','',$sMode);
	}
	
	
	
	/**
	 * Collect cancellers
	 * Put cancellers into an array
	 * 
	 * @return array
	 */
	public function collectOxidCancellers(){
		$aRequestCancellers = oxDb::getDb(true)->getAll($this->_getCancellersFromDb());
		$oRequestCancellers = oxDb::getDb(true)->execute($this->_getCancellersFromDb());
	
		if (($oRequestCancellers != false and $oRequestCancellers->recordCount() > 0)){
				
			$aSubscribers = array();
			$iCounter = 0;
	
			while ($iCounter <= $oRequestCancellers->recordCount() - 1){
				if ($this->readImvaConfig('debug') == '1'){
					echo $iCounter.': ';
				}
				$aCancellers[$iCounter] = array(
						'OXSAL'			=>	$aRequestCancellers[0][0],
						'OXFNAME'		=>	$aRequestCancellers[0][1],
						'OXLNAME'		=>	$aRequestCancellers[0][2],
						'OXEMAIL'		=>	$aRequestCancellers[0][3],
						'OXSUBSCRIBED'	=>	$aRequestCancellers[0][4],
				);
	
				if ($this->readImvaConfig('debug') == '1'){
					echo $aCancellers[$iCounter]['OXEMAIL'];
					echo '<br/>';
				}
	
				if ($this->readImvaConfig('debug') == '1'){
					echo 'Sending canceller to CR<br />';
				}
				//$this->_sendToCr($sMode,$aCancellers[$iCounter]['OXFNAME'],$aCancellers[$iCounter]['OXLNAME'],$aCancellers[$iCounter]['OXEMAIL'],$aCancellers[$iCounter]['OXSAL'],$aCancellers[$iCounter]['OXSUBSCRIBED']);
				$this->_cancelAccnt($aCancellers[$iCounter]['OXEMAIL']);
	
				if ($this->readImvaConfig('debug') == '1'){
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
	
		$this->log('collectOxidCancellers','','','','','default');
	}
	
	
	
	/**
	 * Build SQL to et "sent" flag to user
	 * 
	 * @param string
	 * @return null
	 */	
	private function _buildUserUpdater($sMail){
		$sSqlRequest = "UPDATE oxnewssubscribed ";
		$sSqlRequest .= "SET imva_oxid2cr_sent = 1 ";
		$sSqlRequest .= "WHERE OXEMAIL = '".$sMail."' ";
		$sSqlRequest .= "AND imva_oxid2cr_sent = 0 ";
		$sSqlRequest .= "LIMIT 1";
	
		if ($this->readImvaConfig('debug') == '1'){
			echo $sSqlRequest;
		}
	
		return $sSqlRequest;
	}
	
	
	
	/**
	 * _updateSentUser
	 * 
	 * @param string
	 * @return null
	 */
	private function _updateSentUser($sMail){
		if ($this->readImvaConfig('debug') == '1'){
			echo '_updateSentUser '.$sMail.'--<br />';
		}
		oxDb::getDb(true)->execute($this->_buildUserUpdater($sMail));
	}
	
	
	
	/**
	 * Reset all
	 * 
	 * @return null
	 */
	public function resetAllSubscriptions(){
		oxDb::getDb(true)->execute($this->_buildUserUnlocker());
		$this->blMission = true;
	}
	
	
	
	/**
	 * marktoCancel
	 * Set a "cancel this subscriber" flag
	 */
	private function _marktoCancel($sEmail){
		$sSqlRequest = "UPDATE oxnewssubscribed ";
		$sSqlRequest .= "SET imva_oxid2cr_cancelled = 1 ";
		$sSqlRequest .= "WHERE OXEMAIL = '".$sEmail."'";
		oxDb::getDB(true)->execute($sSqlRequest);
	
		$this->_unlockForTransfer($sMail);
	}
	
	
	
	/**
	 * marktoSend
	 * Set a "send this subscriber" flag
	 */
	private function _marktoSend($sEmail){
		$sSqlRequest = "UPDATE oxnewssubscribed ";
		$sSqlRequest .= "SET imva_oxid2cr_cancelled = 0 ";
		$sSqlRequest .= "WHERE OXEMAIL = '".$sEmail."'";
		oxDb::getDB(true)->execute($sSqlRequest);
	
		$this->_unlockForTransfer($sMail);
	}
	
	

	/**
	 * _unlockForTransfer
	 */
	private function _unlockForTransfer($sMail){
		$sSqlRequest = "UPDATE oxnewssubscribed ";
		$sSqlRequest .= "SET imva_oxid2cr_sent = 0 ";
		$sSqlRequest .= "WHERE OXEMAIL = '".$sMail."'";
		oxDb::getDB(true)->execute($sSqlRequest);
	}
	
	
	
	/**
	 * enableSubscription
	 */
	public function enableSubscription($sEmail){
		$this->_marktoSend($sEmail);
		
		$oSoap = new SoapClient($this->readImvaConfig('clre_wsdl_url'));
		$oSoap->receiverSetActive($this->readImvaConfig('clre_api_key'),$this->readImvaConfig('clre_list_id'),$sEmail);
	}
	
	
	
	/**
	 * disableSubscription
	 */
	public function disableSubscription($sEmail){
		$this->_marktoCancel($sEmail);
		
		$oSoap = new SoapClient($this->readImvaConfig('clre_wsdl_url'));
		$oSoap->receiverSetInactive($this->readImvaConfig('clre_api_key'),$this->readImvaConfig('clre_list_id'),$sEmail);
	}
	
	
	
	/**
	 * That's all, Folks!
	 */
}
?>
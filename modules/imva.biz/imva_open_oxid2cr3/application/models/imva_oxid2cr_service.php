<?php

/**
 * imva.biz "Oxid2CR 3" CleverReach Connector (Open Source Edition)
 * 
 * 
 * 
 * For redistribution in the provicer's network only.
 *
 * Weitergabe außerhalb des Anbieternetzwerkes verboten.
 *
 *
 *
 * This software is intellectual property of imva.biz respectively of its author and is protected
 * by copyright law. This software product is provided "as it is" with no guarantee.
 *
 * You are free to use this software and to modify it in order to fit your requirements.
 *
 * Any modification, copying, redistribution, transmission outsitde of the provider's platforms
 * is a violation of the license agreement and will be prosecuted by civil and criminal law.
 *
 * By applying and using this software product, you agree to the terms and conditions of use.
 *
 *
 *
 * Diese Software ist geistiges Eigentum von imva.biz respektive ihres Autors und ist durch das
 * Urheberrecht geschützt. Diese Software wird ohne irgendwelche Garantien und "wie sie ist"
 * angeboten.
 *
 * Sie sind berechtigt, diese Software frei zu nutzen und auf Ihre Bedürfnisse anzupassen.
 *
 * Jegliche Modifikation, Vervielfältigung, Redistribution, Übertragung zum Zwecke der
 * Weiterentwicklung außerhalb der Netzwerke des Anbieters ist untersagt und stellt einen Verstoß
 * gegen die Lizenzvereinbarung dar.
 *
 * Mit der Übernahme dieser Software akzeptieren Sie die zwischen Ihnen und dem Herausgeber
 * festgehaltenen Bedingungen. Der Bruch dieser Bedingungen kann Schadensersatzforderungen nach
 * sich ziehen.
 *
 *
 *
 * (EULA-13/7-OS)
 * 
 * 
 *
 * (c) 2012-2013 imva.biz, Johannes Ackermann, ja@imva.biz
 * @author Johannes Ackermann
 * 
 * 12/3/3-13/8/13
 * V 2.9.5
 * 
 */

class imva_oxid2cr_service extends imva_oxid2cr_service_parent
{
	
	public $blMission;
	protected $_oSupport;
	public $sModuleId = 'imva_open_oxid2cr3';
	
	

	/**
	 * isInstalled
	 * Tries to find out if the database has been set up.
	 * 
	 * @return boolean
	 */
	public function isInstalled(){
		if ($this->readImvaConfig($this->sModuleId,'clre_wsdl_url')){
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
			if ($this->readImvaConfig($this->sModuleId,'prfm_max_lines')){
				$sSqlRequest .= "LIMIT ".$this->readImvaConfig($this->sModuleId,'prfm_max_lines')." ";
			}
		}
		
		//Update
		if ($sMode == 'update'){
			$sSqlRequest .= "and imva_oxid2cr_sent = 1 ";
		}
	
		//debugger
		if ($this->readImvaConfig($this->sModuleId,'debug') == '1'){
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
		if ($this->readImvaConfig($this->sModuleId,'prfm_max_lines')){$sSqlRequest .= "LIMIT ".$this->_prfm_max_lines." ";}
	
		if ($this->readImvaConfig($this->sModuleId,'debug') == '1'){
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
	
		if ($this->readImvaConfig($this->sModuleId,'debug') == '1'){
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
	 * Slide on the Soap:
	 *
	 * Add Subscribers to CleverReach
	 * Requires working connection to the CR service.
	 *
	 * @return null
	 */
	private function _sendToCr($sMode,$sForename,$sLastname,$sEmail,$sSalutation,$sSubscDate){
		if ($this->readImvaConfig($this->sModuleId,'simulation') == '0'){
			$oSoap = new SoapClient($this->readImvaConfig($this->sModuleId,'clre_wsdl_url'));
			
			//Retrieve available receiver lists
			$sCrReply = $oSoap->groupGetList($this->readImvaConfig($this->sModuleId,'clre_api_key'));
		
			if ($sCrReply->status == 'SUCCESS'){
				$this->blMission = true;
				if ($this->readImvaConfig($this->sModuleId,'debug') == '1'){
					echo 'Connection State is SUCCESS';
					var_dump($sCrReply->data);
				}
			}
			else{
				$this->blMission = false;
				if ($this->readImvaConfig($this->sModuleId,'debug') == '1'){
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
				$oSoap->receiverAdd($this->readImvaConfig($this->sModuleId,'clre_api_key'),$this->readImvaConfig($this->sModuleId,'clre_list_id'),$aUserdata);
				$oSoap->receiverUpdate($this->readImvaConfig($this->sModuleId,'clre_api_key'),$this->readImvaConfig($this->sModuleId,'clre_list_id'),$aUserdata);
			}
			elseif ($sMode == 'update'){
				$oSoap->receiverUpdate($this->readImvaConfig($this->sModuleId,'clre_api_key'),$this->readImvaConfig($this->sModuleId,'clre_list_id'),$aUserdata);
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
		if ($this->readImvaConfig($this->sModuleId,'simulation') == '0'){
			$oSoap = new SoapClient($this->readImvaConfig($this->sModuleId,'clre_wsdl_url'));
		
			//Retrieve available receiver lists
			$sCrReply = $oSoap->groupGetList($this->readImvaConfig($this->sModuleId,'clre_api_key'));
		
			if ($sCrReply->status == 'SUCCESS'){
				$this->blMission = true;
				if ($this->readImvaConfig($this->sModuleId,'debug') == '1'){
					echo 'Connection State is SUCCESS';
					var_dump($sCrReply->data);
				}
			}
			else{
				$this->blMission = false;
				if ($this->readImvaConfig($this->sModuleId,'debug') == '1'){
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
		
			$oSoap->receiverSetInactive($this->readImvaConfig($this->sModuleId,'clre_api_key'),$this->readImvaConfig($this->sModuleId,'clre_list_id'),$aUserdata['email']);
			
			$this->log($this->sModuleId,'cancelAccount',$aUserdata['email'],'','','','disable');
			
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
				
		if ($this->readImvaConfig($this->sModuleId,'debug') == '1'){
			echo '<pre>';
			var_dump($aRequestSubscribers);
			echo '</pre>';
			echo $oRequestSubscribers->recordCount();
		}
		
		if (($oRequestSubscribers != false && $oRequestSubscribers->recordCount() > 0)){
				
			$aSubscribers = array();
			$iCounter = 0;
	
			while ($iCounter <= $oRequestSubscribers->recordCount() - 1){
				
				if ($this->readImvaConfig($this->sModuleId,'debug') == '1'){
					echo $iCounter.': ';
				}
				$aSubscribers[$iCounter] = array(
						'OXSAL'			=>	$aRequestSubscribers[0][0],
						'OXFNAME'		=>	$aRequestSubscribers[0][1],
						'OXLNAME'		=>	$aRequestSubscribers[0][2],
						'OXEMAIL'		=>	$aRequestSubscribers[0][3],
						'OXSUBSCRIBED'	=>	$aRequestSubscribers[0][4],
				);
	
				if ($this->readImvaConfig($this->sModuleId,'debug') == '1'){
					var_dump($aSubscribers);
					echo '<hr />';
					echo $aSubscribers[$iCounter]['OXEMAIL'];
					echo '<br/>';
					
					echo 'aSubscribers:<br />';
					print_r($aSubscribers);
					echo ' --aSubscribers<br />';
					
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
	
		$this->log($this->sModuleId,'collectSubscribers','','','','',$sMode);
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
				if ($this->readImvaConfig($this->sModuleId,'debug') == '1'){
					echo $iCounter.': ';
				}
				$aCancellers[$iCounter] = array(
						'OXSAL'			=>	$aRequestCancellers[0][0],
						'OXFNAME'		=>	$aRequestCancellers[0][1],
						'OXLNAME'		=>	$aRequestCancellers[0][2],
						'OXEMAIL'		=>	$aRequestCancellers[0][3],
						'OXSUBSCRIBED'	=>	$aRequestCancellers[0][4],
				);
	
				if ($this->readImvaConfig($this->sModuleId,'debug') == '1'){
					echo $aCancellers[$iCounter]['OXEMAIL'];
					echo '<br/>';
					
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
	
		$this->log($this->sModuleId,'collectOxidCancellers','','','','','default');
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
	
		if ($this->readImvaConfig($this->sModuleId,'debug') == '1'){
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
		if ($this->readImvaConfig($this->sModuleId,'debug') == '1'){
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
		
		$oSoap = new SoapClient($this->readImvaConfig($this->sModuleId,'clre_wsdl_url'));
		$oSoap->receiverSetActive($this->readImvaConfig($this->sModuleId,'clre_api_key'),$this->readImvaConfig($this->sModuleId,'clre_list_id'),$sEmail);
	}
	
	
	
	/**
	 * disableSubscription
	 */
	public function disableSubscription($sEmail){
		$this->_marktoCancel($sEmail);
		
		$oSoap = new SoapClient($this->readImvaConfig($this->sModuleId,'clre_wsdl_url'));
		$oSoap->receiverSetInactive($this->readImvaConfig($this->sModuleId,'clre_api_key'),$this->readImvaConfig($this->sModuleId,'clre_list_id'),$sEmail);
	}
	
	
	
	/**
	 * That's all, Folks!
	 */
}
?>
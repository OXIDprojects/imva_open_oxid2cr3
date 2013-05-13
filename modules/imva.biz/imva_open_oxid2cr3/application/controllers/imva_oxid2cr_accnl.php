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

class imva_oxid2cr_accnl extends imva_oxid2cr_accnl_parent{
	
	private function config($sParam){
		
		$oShopConfig = oxConfig::getInstance(); //->getConfigParam($sConfigParam)
		$aImvaConfig = $oShopConfig->getConfigParam('imva_oxid2cr');
		
		$aConfigParams = array(
		'devmode'						=>	'0',	//1 = do not send data to cr
		'clre_api_key'					=>	$aImvaConfig['clre_api_key'],	//CR API Key
		'clre_wsdl_url'					=>	str_replace('http:','https:',$aImvaConfig['clre_wsdl_url']),	//CR WSDL URL
		'clre_list_id'					=>	$aImvaConfig['clre_list_id'],	//CR List ID
		'clre_field_firstname'			=>	$aImvaConfig['clre_field_firsname'],
		'clre_field_lastname'			=>	$aImvaConfig['clre_field_lastname'],
		'clre_field_salutation'			=>	$aImvaConfig['clre_field_salutation'],
		);
		
		if (($sParam != '') and ($aConfigParams[$sParam] != '')){
			return $aConfigParams[$sParam];
		}
		else{
			//print_r('IMVA_CL_OXID2CR_FNC_CONFIG:_'.$sParam.'<br />');
			return false;
		}		
	}
	
	public function getParam($param){
		return $this->config($param);
	}
	
	private function _getNLstate(){
		$oConfig = $this->getConfig();
		$theState = $oConfig->getParameter('status');
		if ($theState != ''){
			return $theState;
		}
		else{
			return false;
		}
	}
	
	private function _unlockForTransfer($sMail){
		$sSqlRequest = "UPDATE oxnewssubscribed ";
		$sSqlRequest .= "SET imva_oxid2cr_sent = 0 ";
		$sSqlRequest .= "WHERE OXEMAIL = '".$sMail."'";
		oxDb::getDB(true)->execute($sSqlRequest);
	}
	
	private function _getUseraddr(){
		$oUser = $this->getUser();
		return $oUser->oxuser__oxusername->value;
	}
	
	private function _marktoCancel(){
		$sSqlRequest = "UPDATE oxnewssubscribed ";
		$sSqlRequest .= "SET imva_oxid2cr_cancelled = 1 ";
		$sSqlRequest .= "WHERE OXEMAIL = '".$this->_getUseraddr()."'";
		oxDb::getDB(true)->execute($sSqlRequest);
		
		$this->_unlockForTransfer($this->_getUseraddr());
	}
	
	private function _marktoSend(){
		$sSqlRequest = "UPDATE oxnewssubscribed ";
		$sSqlRequest .= "SET imva_oxid2cr_cancelled = 0 ";
		$sSqlRequest .= "WHERE OXEMAIL = '".$this->_getUseraddr()."'";
		oxDb::getDB(true)->execute($sSqlRequest);
		
		$this->_unlockForTransfer($this->_getUseraddr());
	}
	
	public function render(){
		$sReturn = parent::render();
			
		if ($this->_getNLstate() == 0){
			$this->_marktoCancel();
			$this->_disable();
		}
		elseif ($this->_getNLstate() == 1){
			$this->_marktoSend();
			$this->_enable();
		}			
		return $sReturn;
	}
	
	/**
	 * function _enable. For use in account_newsletter only.
	 * @backup
	 * ACCNL
	 */
	private function _enable(){
		if ($this->licenseCheck()){
			$oSoap = new SoapClient($this->config('clre_wsdl_url'));
			$sCrReply = $oSoap->receiverSetActive($this->config('clre_api_key'),$this->config('clre_list_id'),$this->_getUseraddr());
		}		
	}
	
	/**
	 * function _disable. For use in account_newsletter only.
	 * @backup
	 * ACCNL
	 */
	private function _disable(){
		if ($this->licenseCheck()){
			$oSoap = new SoapClient($this->config('clre_wsdl_url'));
			$sCrReply = $oSoap->receiverSetInactive($this->config('clre_api_key'),$this->config('clre_list_id'),$this->_getUseraddr());
		}
	}
}
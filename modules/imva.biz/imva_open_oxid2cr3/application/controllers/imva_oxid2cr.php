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
 * V 2.9.2.9
 * 
 */

class imva_oxid2cr extends oxUbase{
	
protected $_sThisTemplate = 'imva_oxid2cr.tpl';
	
	
	
	/**
	 * Services and providers
	 */
	protected $_oSvc;
	protected static $_oConfig;
	
	
	
	/**
	 * __construct
	 * Loads Config and imva_oxid2cr2 Service
	 * 
	 * @return null
	 */
	public function __construct(){
		parent::__construct();
		$this->_oSvc = new imva_oxid2cr_service();
		$this->_oConfig = $this->getConfig();
	}
	
	
	
	/**
	 * render()
	 * @return array
	 */
	public function render()
	{
		parent::render();
		
		$this->_aViewData['oSvc'] = $this->_oSvc;
		$this->_aViewData['client'] = $this->_getUser();
		
		
		/**
		 * Action handler
		 */
		if ($this->_aViewData['action'] == 'send'){
			$this->_oSvc->collectSubscribers('add');
		}
		elseif ($this->_aViewData['action'] == 'update'){
			$this->_oSvc->collectSubscribers('update');
		}
		elseif ($this->_aViewData['action'] == 'cancel'){
			$this->_oSvc->collectOxidCancellers();
		}
		elseif ($this->_aViewData['action'] == 'unlock'){
			$this->_oSvc->resetAllSubscriptions();
		}
		
		/**
		 * Client?
		 */
		if ($this->_aViewData['client'] == 'user'){
		}
		else{
		}
		return $this->_sThisTemplate;		
	}
	
	
	
	/**
	 * User validation below /////////////////////////
	 */
	
	
	
	/**
	 * _getUser
	 * returns the accessing user
	 * 
	 * @return string
	 */
	private function _getUser()
	{
		if ($this->_getAuthState()){
			return $this->_oConfig->getRequestParameter('client');
		}
		else{
			return false;
		}
	}
	
	
	
	/**
	 * _getAuthState
	 *
	 * @return boolean
	 */
	private function _getAuthState()
	{
		if ($this->_oConfig->getRequestParameter('imva_auth_key') == $this->_oSvc->readImvaConfig('secret_key')){
			return true;
		}
		else{
			return false;
		}
	}
	
	
	
	/**
	 * _frmChk
	 * Request from a hidden check box to determine if data have been sent via form
	 *
	 * @return boolean
	 */
	private function _frmChk()
	{
		if ($this->_oConfig->getRequestParameter('imva_frm_chk') == 1){
			return true;
		}
		else{
			return false;
		}
	}
	
	
	
	/**
	 * getAuth
	 */
	public function getAuth()
	{
		if ($this->_getAuthState() && $this->_frmChk()){
			return true;
		}
		else{
			return false;
		}
	}
}
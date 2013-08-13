<?php

/**
 * IMVA Oxid2CR 3 (Open Source Edition)
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
 * (EULA-13/7)
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

class imva_oxid2cr extends oxUbase{
	
	
	
	/**
	 * Services and providers
	 */
	protected $_sThisTemplate = 'imva_oxid2cr.tpl';			// Template
	public $oSvc = null;									// Imva Service
	public $sModuleId = 'imva_open_oxid2cr3';
	public $sClient = null;									// Client Name
	
	
	
	/**
	 * __construct
	 * Loads Config and imva_oxid2cr2 Service
	 * 
	 * @return null
	 */
	public function __construct(){
		parent::__construct();
		
		// Prepare imva.biz Module Service
		$this->oSvc = oxNew('imva_service');
		$this->oSvc->init(20130813);
		
		$this->sClient = $this->oSvc->req('client');
	}
	
	
	
	/**
	 * render()
	 * @return array
	 */
	public function render()
	{
		parent::render();
		
		
		
		// Action handler
		$sAction = $this->oSvc->getAction();
		if ($sAction == 'send'){
			$this->oSvc->collectSubscribers('add');
		}
		elseif ($sAction == 'update'){
			$this->oSvc->collectSubscribers('update');
		}
		elseif ($sAction == 'cancel'){
			$this->oSvc->collectOxidCancellers();
		}
		elseif ($sAction == 'unlock'){
			$this->oSvc->resetAllSubscriptions();
		}
		
		
		// Template
		return $this->_sThisTemplate;		
	}
	
	
	
	/**
	 * User validation below /////////////////////////
	 */
	
	
	
	/**
	 * _getAuthState
	 *
	 * @return boolean
	 */
	private function _getAuthState()
	{
		if ($this->oSvc->req('imva_auth_key') == $this->oSvc->readImvaConfig($this->sModuleId,'secret_key')){
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
		if ($this->oSvc->req('imva_frm_chk') == 1){
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
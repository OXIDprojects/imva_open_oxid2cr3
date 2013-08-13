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
 * 12/3/3-13/5/14
 * V 2.9.2.9
 * 
 */

class imva_oxid2cr_accnl extends imva_oxid2cr_accnl_parent
{
	
	
	
	/**
	 * Services and providers
	 */
	protected $_oSvc;
	protected static $_oConfig;
	
	
	
	public function __construct()
	{
		parent::__construct();
		$this->_oSvc = new imva_oxid2cr_service();
		$this->_oConfig = $this->getConfig();
	}
	
	
	
	/**
	 * render
	 * Called on page generation
	 * 
	 * @return template
	 */
	public function render()
	{
		$sReturn = parent::render();
		
		// form?
		if ($this->_getNLstate() == 0){;
			$this->_oSvc->disableSubscriber($this->_getUseraddr());
		}
		elseif ($this->_getNLstate() == 1){
			$this->_oSvc->enableSubscriber($this->_getUseraddr());
		}
		
		return $sReturn;
	}
	
	
	
	/**
	 * _getNLstate
	 * returns the value of the "status" field
	 * 
	 * @return string
	 */
	private function _getNLstate(){
		$theState = $this->_oConfig->getParameter('status');
		if ($theState != ''){
			return $theState;
		}
		else{
			return false;
		}
	}
	
	
	
	private function _getUseraddr(){
		$oUser = $this->getUser();
		return $oUser->oxuser__oxusername->value;
	}
}
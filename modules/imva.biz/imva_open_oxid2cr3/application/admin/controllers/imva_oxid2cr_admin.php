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
 * (EULA-13/7-CS)
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

class imva_oxid2cr_admin extends oxAdminView
{
	
	protected $_sThisTemplate = 'imva_oxid2cr_admin.tpl';	// Template
	public $oSvc = null;									// Imva Service
	
	
	
	/**
	 * __construct
	 * Preparation.
	 */
	public function __construct()
	{
		parent::__construct();

		// Prepare imva.biz Module Service
		$this->oSvc = oxNew('imva_service');
		$this->oSvc->init(20130813);
	}
	
	
	
	/**
	 * Render
	 * @see oxAdminView::render()
	 */
	function render()
	{
		parent::render();
		
		// Action handler
		if ($this->oSvc->getAction() == 'setup'){
			$this->_setupDb();
		}
		elseif ($this->oSvc->getAction() == 'uninstall'){
			$this->_removeDb();
		}

		elseif ($this->oSvc->getAction() == 'unlock'){
			$this->oSvc->resetAllSubscriptions();
		}
		
		return $this->_sThisTemplate;
	}
	
	
	
	/**
	 * Fetch form input and store to db
	 */
	public function imva_store(){
		$aImvaEdit = $this->oSvc->req('imva_edit');
		
		$aKeys = array_keys($aImvaEdit);
		$iCntr = 0;
		
		foreach ($aImvaEdit as $sTheLine){
			$this->_imva_memorize($aKeys[$iCntr],$sTheLine);
			$iCntr++;
		}
	}
	
	
	
	/**
	 * Write config data to imva_config where module_name is imva_oxid2cr3
	 *
	 * @param string, string
	 * @return null
	 */
	private function _imva_memorize($sParam,$sValue)
	{
		if ($sParam && $sValue)
		{
			$sSqlRequest = 'UPDATE  imva_config SET  value = "'.$sValue.'" WHERE module_name = "'.$this->oSvc->sModuleId.'" AND param = "'.$sParam.'"';
			return oxDb::getDB(true)->execute($sSqlRequest);
		}
		else{
			return false;
		}
	}
	
	
	
	/**
	 * Get URLs for cronjobs
	 */
	public function getActionUrl($sAction = ''){
		$sReturn = $this->getViewConfig()->getHomeLink();
		$sReturn .= 'cl=imva_oxid2cr&client=machine';
		if ($sAction){$sReturn .= '&action='.$sAction;}
		$sReturn .= '&imva_auth_key='.$this->oSvc->readImvaConfig($this->oSvc->sModuleId,'secret_key');
		$sReturn .= '&imva_frm_chk=1';
		return $sReturn;
	}
	
	
	
	// Database setup /////////////////////////
	
	/**
	 * Install has been moved to the Setup Routine.
	 * 
	 * @param null
	 * @return null
	 */
	private function _setupDb()
	{
		setupImvaOxid2Cr::onActivate();
	}
	
	
	
	/**
	 * Remove...
	 */
	private function _removeDb(){
		$this->oSvc->log($this->oSvc->sModuleId,'_removeDb','','','','');
		
		$sSqlRequest = 'DELETE FROM imva_config WHERE module_name = "'.$this->oSvc->sModuleId.'"';
		oxDb::getDB(true)->execute($sSqlRequest);
		
		$sSqlRequest = "ALTER TABLE oxnewssubscribed DROP imva_oxid2cr_sent";
		oxDb::getDB(true)->execute($sSqlRequest);
		
		$sSqlRequest = "ALTER TABLE oxnewssubscribed DROP imva_oxid2cr_cancelled";
		oxDb::getDB(true)->execute($sSqlRequest);
	}
}

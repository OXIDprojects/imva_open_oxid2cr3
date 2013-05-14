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

class imva_oxid2cr_admin extends oxAdminView
{
	protected $_sThisTemplate = 'imva_oxid2cr_admin.tpl';
	protected static $_oSvc;
	protected static $_oConfig;
	
	
	
	/**
	 * __construct
	 * Preparation.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->_oSvc = new imva_oxid2cr_service;
		$this->_oConfig = $this->getConfig();
	}
	
	
	
	/**
	 * Render
	 * @see oxAdminView::render()
	 */
	function render()
	{
		parent::render();
		
		// Action handler
		if ($this->_oSvc->getAction() == 'setup'){
			$this->_setupDb();
		}
		elseif ($this->_oSvc->getAction() == 'uninstall'){
			$this->_removeDb();
		}

		elseif ($this->_oSvc->getAction() == 'unlock'){
			$this->_oSvc->resetAllSubscriptions();
		}
		
		$this->_aViewData['oSvc'] = $this->_oSvc;
		
		return $this->_sThisTemplate;
	}
	
	
	
	/**
	 * Fetch form input and store to db
	 */
	public function imva_store(){
		$aImvaEdit = $this->_oConfig->getRequestParameter('imva_edit');
		
		$aKeys = array_keys($aImvaEdit);
		$iCntr = 0;
		
		foreach ($aImvaEdit as $sTheLine){
			$this->_imva_memorize($aKeys[$iCntr],$sTheLine);
			$iCntr++;
		}
	}
	
	
	
	/**
	 * Write config data to imva_config where module_name is imva_oxid2cr
	 *
	 * @return null
	 */
	private function _imva_memorize($sParam,$sValue)
	{
		$this->_oSvc->log('store');
		
		if ($sParam && $sValue)
		{
			$sSqlRequest = 'UPDATE  imva_config SET  value = "'.$sValue.'" WHERE module_name = "imva_oxid2cr3" AND param = "'.$sParam.'"';
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
		$sReturn .= '&imva_auth_key='.$this->_oSvc->readImvaConfig('secret_key');
		$sReturn .= '&imva_frm_chk=1';
		return $sReturn;
	}
	
	
	
	/**
	 * _generateSecretKey
	 * On db setup, this function generates a secret key to be used for authentication. Perfect for lazy users. ;-)
	 *
	 * @return string
	 */
	private function _generateSecretKey($iLength)
	{
		srand ((double)microtime()*1000000); 
		$rndA = rand(); 
		return substr(md5($rndA),0,$iLength);
	}
	
	
	
	// Database setup /////////////////////////
	
	/**
	 * Create tables
	 */
	private function _setupDb()
	{
		$this->_oSvc->log('setup');
		
		//create config table		
		$sSqlRequest = "CREATE TABLE IF NOT EXISTS imva_config (
  			oxid int(4) NOT NULL AUTO_INCREMENT,
  			module_name varchar(16) COLLATE latin1_general_ci DEFAULT NULL,
  			param varchar(32) COLLATE latin1_general_ci NOT NULL,
  			value varchar(64) COLLATE latin1_general_ci DEFAULT NULL,
  			changed timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  			PRIMARY KEY (oxid)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=12 ;";
		oxDb::getDB(true)->execute($sSqlRequest);
		
		//fill config data (defaults)
		$sSqlRequest = "INSERT INTO `imva_config` (`oxid`, `module_name`, `param`, `value`, `changed`) VALUES
			(NULL, 'imva_oxid2cr3', 'clre_api_key', 'enter_cr_api_key_here', CURRENT_TIMESTAMP),
			(NULL, 'imva_oxid2cr3', 'clre_wsdl_url', 'http://api.cleverreach.com/soap/interface_v5.0.php?wsdl', CURRENT_TIMESTAMP),
			(NULL, 'imva_oxid2cr3', 'clre_list_id', '1234', CURRENT_TIMESTAMP),
			(NULL, 'imva_oxid2cr3', 'clre_field_firstname', 'firstname', CURRENT_TIMESTAMP),
			(NULL, 'imva_oxid2cr3', 'clre_field_lastname', 'lastname', CURRENT_TIMESTAMP),
			(NULL, 'imva_oxid2cr3', 'clre_field_salutation', 'salutation', CURRENT_TIMESTAMP),
			(NULL, 'imva_oxid2cr3', 'simulation', '0', CURRENT_TIMESTAMP),
			(NULL, 'imva_oxid2cr3', 'secret_key', '".$this->_generateSecretKey(32)."', CURRENT_TIMESTAMP),
			(NULL, 'imva_oxid2cr3', 'prfm_max_lines', '2', CURRENT_TIMESTAMP),
			(NULL, 'imva_oxid2cr3', 'debug', '0', CURRENT_TIMESTAMP) ;";
		oxDb::getDB(true)->execute($sSqlRequest);
		
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
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='imva_oxid2cr3_5';";
		if ($this->_oSvc->readImvaConfig('debug') == '1'){
			echo $sSqlRequest.'--<br />';
		}
		oxDb::getDB(true)->execute($sSqlRequest);
	
		//set up imva_oxid2cr_sent
		$sSqlRequest = "ALTER TABLE oxnewssubscribed ADD imva_oxid2cr_sent INT( 1 ) NOT NULL DEFAULT 0";
		if ($this->_oSvc->readImvaConfig('debug') == '1'){
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
	 * Remove...
	 */
	private function _removeDb(){
		$this->_oSvc->log('remove');
		
		$sSqlRequest = 'DELETE FROM imva_config WHERE module_name = "imva_oxid2cr3"';
		oxDb::getDB(true)->execute($sSqlRequest);
		
		$sSqlRequest = "ALTER TABLE oxnewssubscribed DROP imva_oxid2cr_sent";
		oxDb::getDB(true)->execute($sSqlRequest);
		
		$sSqlRequest = "ALTER TABLE oxnewssubscribed DROP imva_oxid2cr_cancelled";
		oxDb::getDB(true)->execute($sSqlRequest);
	}
}

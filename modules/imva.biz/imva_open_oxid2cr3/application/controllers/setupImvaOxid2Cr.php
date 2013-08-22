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
 * 12/8/2-13/8/22
 * V 2.9.5.1
 *
 */

class setupImvaOxid2Cr extends oxUbase
{
	/**
	 * Create tables
	 */
	static function activate()
	{
		$sModuleId = 'imva_open_oxid2cr3';
		$oSvc = oxNew('imva_service');
		$oSvc->init(20130813);
		$this->oSvc->log($sModuleId,'setup','','','','','');
	
		//create config table
		$sSqlRequest = "CREATE TABLE IF NOT EXISTS imva_config (
  			oxid int(4) NOT NULL AUTO_INCREMENT,
  			module_name varchar(32) COLLATE latin1_general_ci DEFAULT NULL,
  			param varchar(32) COLLATE latin1_general_ci NOT NULL,
  			value varchar(64) COLLATE latin1_general_ci DEFAULT NULL,
  			changed timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  			PRIMARY KEY (oxid)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=12 ;";
		oxDb::getDB(true)->execute($sSqlRequest);
	
		//fill config data (defaults)
		$sSqlRequest = "INSERT INTO `imva_config` (`oxid`, `module_name`, `param`, `value`, `changed`) VALUES
			(NULL, '".$sModuleId."', 'clre_api_key', 'enter_cr_api_key_here', CURRENT_TIMESTAMP),
			(NULL, '".$sModuleId."', 'clre_wsdl_url', 'http://api.cleverreach.com/soap/interface_v5.0.php?wsdl', CURRENT_TIMESTAMP),
			(NULL, '".$sModuleId."', 'clre_list_id', '1234', CURRENT_TIMESTAMP),
			(NULL, '".$sModuleId."', 'clre_field_firstname', 'firstname', CURRENT_TIMESTAMP),
			(NULL, '".$sModuleId."', 'clre_field_lastname', 'lastname', CURRENT_TIMESTAMP),
			(NULL, '".$sModuleId."', 'clre_field_salutation', 'salutation', CURRENT_TIMESTAMP),
			(NULL, '".$sModuleId."', 'simulation', '0', CURRENT_TIMESTAMP),
			(NULL, '".$sModuleId."', 'secret_key', '".$oSvc->generateSecretKey(32)."', CURRENT_TIMESTAMP),
			(NULL, '".$sModuleId."', 'prfm_max_lines', '2', CURRENT_TIMESTAMP),
			(NULL, '".$sModuleId."', 'debug', '0', CURRENT_TIMESTAMP) ;";
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
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='".$sModuleId."';";
		
		oxDb::getDB(true)->execute($sSqlRequest);
	
		//set up imva_oxid2cr_sent
		$sSqlRequest = "ALTER TABLE oxnewssubscribed ADD imva_oxid2cr_sent INT( 1 ) NOT NULL DEFAULT 0";		
		oxDb::getDB(true)->execute($sSqlRequest);
	
		//set up imva_oxid2cr_cancelled
		$sSqlRequest = "ALTER TABLE oxnewssubscribed ADD imva_oxid2cr_cancelled INT( 1 ) NOT NULL DEFAULT 0";
		oxDb::getDB(true)->execute($sSqlRequest);
	}
}
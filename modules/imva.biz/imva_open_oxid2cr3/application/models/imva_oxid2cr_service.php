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

class imva_oxid2cr_service extends oxBase
{
	/**
	 * render
	 * @deprecated
	 * 
	 */
	function render()
	{
		parent::render();
		return parent;
	}
	
	/**
	 * _getBasics
	 * 
	 * thinking about cleaning this up...
	 * @return string
	 */
	function _getBasics($sInfo)
	{
		switch ($sInfo){
			case 'version':
				return '2.1';
				break;
			case 'build':
				return '130513';
				break;
			case 'edition':
				return 'open';
				break;
			default:
				return '';
		}
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
			return oxDb::getDB(true)->getone($sSqlRequest);
		}
		else{
			return false;
		}
	}
	
	/**
	 * Database setup
	 * 
	 * @return nothing. Really.
	 */
	function setupImvaConfigTable()
	{
		$sSqlRequest = "<SQL statement GOES HERE>";
		oxDb::getDB(true)->execute($sSqlRequest);
	}
	
	/**
	 * getVersion
	 *
	 * @return string
	 */
	public function getVersion()
	{
		return $this->_getBasics('version').' '.
			'<i>'.$this->_getBasics('edition').'</i> '.
			'build '.$this->_getBasics('build');
	}
	

	/**
	 * isInstalled
	 * 
	 * @return boolean
	 */
	public function isInstalled(){
		$sSqlRequest = "SELECT COUNT(*) FROM oxnewssubscribed WHERE imva_oxid2cr_sent = 0";
		$oReq = oxDb::getDB(true)->execute($sSqlRequest);
		
		if ($oReq->fields['COUNT(*)'] > 0){
			return true;
		}
		else{
			return false;
		}
		
		unset($oReq,$sSqlRequest);
	}
}
?>
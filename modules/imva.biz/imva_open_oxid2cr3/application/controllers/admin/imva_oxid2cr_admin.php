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

class imva_oxid2cr_admin extends oxAdminView
{
	protected $_sThisTemplate = 'imva_oxid2cr_admin.tpl';
	
	function render()
	{
		parent::render();
		
		$oSvc = new imva_oxid2cr_service;
		$this->_aViewData['oSvc'] = $oSvc;
		
		return $this->_sThisTemplate;
	}
	
	
	
	/**
	 * Write config data from imva_config
	 *
	 * @return string
	 */
	function readImvaConfig($sParam,$sValue)
	{
		if ($sParam && $sValue)
		{
			$sSqlRequest = 'UPDATE  imva_config SET  value = "'.$sValue.'" WHERE module_name = imva_oxid2cr3 AND param = "'.$sParam.'"';
			return oxDb::getDB(true)->execute($sSqlRequest);
		}
		else{
			return false;
		}
	}
	
}

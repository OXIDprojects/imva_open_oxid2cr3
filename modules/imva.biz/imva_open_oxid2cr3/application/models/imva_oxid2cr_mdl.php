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

class imva_oxid2cr_mdl extends oxBase
{
	
	
	
	/**
	 * Initiates Obejct Structure
	 * @param $aParams
	 */
	public function __construct($aParams = null)
	{
		parent::__construct();
		$this->init('imva_config');
	}
	
	protected $_sClassName = 'asdf';
	protected $_sCoreTable = 'imva_config';
	
	public function getValue($blForceCoreTable = null)
	{
		$sRequest = '';
		$sTable = $this->getViewName($blForceCoreTable);
	
		$sRequest = " $sTable.value = 1 ";
	
		return $sRequest;
	}
}
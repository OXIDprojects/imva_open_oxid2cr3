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
	

	
	/**
	 * Render.
	 * Uses functions of service class models/imva_oxid2cr_service to determine whether user subscribed to NL or not and
	 * if available and allowed provices functions to subscribe.
	 */
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
}
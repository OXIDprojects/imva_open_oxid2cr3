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

$sMetadataVersion = '1.1';

/**
 * Module information
 */
$aModule = @array(
	'id'			=> 'imva_open_oxid2cr3',
	'title'			=> '<img src="../modules/imva.biz/imva_services/out/src/imva-Logo-12.png" alt=".iI" title="imva.biz" /> Adapter für CleverReach | CleverReach connector',
	'description'	=> array(
		'en'	=>	'<p>imva.biz CleverReach connector -- open source edition</p><p>Transfer newsletter subscriptions from your online shop to CleverReach the easy way -- with <i>CleverReach connector</i> by imva.biz. This connector also updates cancelled and updated subscriptions.</p>',
		'de'	=>	'<p>imva.biz Adapter für CleverReach -- quelloffene Ausgabe</p><p>Mit dem <i>Adapter für CleverReach</i> von imva.biz übertragen Sie Newsletter-Abonnenten aus Ihrem Shop sicher und einfach an CleverReach. Die Schnittstelle berücksichtigt auch aktualisierte Kundendaten und Abo-Kündigungen.<br />
					<i>Dieses Modul ben&ouml;tigt die frei erh&auml;tliche Erweiterung
					<a href="http://imva.biz/oxid/module/module_services" style="color:#06c; font-weight:bold;">imva.biz Module Services</a>.</i></p>',
	),
	'thumbnail'		=> 'out/src/imva_oxid2cr-logo.png',
	'version'		=> '2.9.5',
	'author'		=> 'Johannes Ackermann',
	'url'			=> 'http://imva.biz',
	'email' 		=> 'imva@imva.biz',
	'extend'		=> array(
		'account_newsletter'		=>	'imva.biz/imva_open_oxid2cr3/application/controllers/imva_oxid2cr_accnl',
      	'imva_service'				=>	'imva.biz/imva_open_oxid2cr3/application/models/imva_oxid2cr_service',
	),
	'files' => array(
		'setupImvaOxid2Cr'			=>	'imva.biz/imva_open_oxid2cr3/application/controllers/setupImvaOxid2Cr.php',
		'imva_oxid2cr'				=>	'imva.biz/imva_open_oxid2cr3/application/controllers/imva_oxid2cr.php',
      	'imva_oxid2cr_admin'		=>	'imva.biz/imva_open_oxid2cr3/application/admin/controllers/imva_oxid2cr_admin.php',
      	'imva_oxid2cr_support'		=>	'imva.biz/imva_open_oxid2cr3/application/models/imva_oxid2cr_support.php',
	),
	'templates'	=>	array(
		'imva_oxid2cr.tpl'			=>	'imva.biz/imva_open_oxid2cr3/application/views/imva_oxid2cr.tpl',
        'imva_oxid2cr_admin.tpl'	=>	'imva.biz/imva_open_oxid2cr3/application/admin/views/imva_oxid2cr_admin.tpl',
	),
	'blocks'	=>	array(
		array(
			'template' => 'imva_oxid2cr_admin.tpl',
			'block'    => 'imva_header',
			'file'     => 'out/blocks/imva_header.tpl'
		),
		array(
			'template' => 'imva_oxid2cr_admin.tpl',
			'block'    => 'imva_footer',
			'file'     => 'out/blocks/imva_footer.tpl'
		),
		array(
			'template' => 'imva_oxid2cr.tpl',
			'block'    => 'imva_header',
			'file'     => 'out/blocks/imva_header.tpl'
		),
		array(
			'template' => 'imva_oxid2cr.tpl',
			'block'    => 'imva_footer',
			'file'     => 'out/blocks/imva_footer.tpl'
		),
	),
	/*
	'events'       => array(
			'onActivate'   => 'setupImvaOxid2Cr::onActivate',
			'onDeactivate' => 'setupImvaOxid2Cr::onDeactivate',
	),
	*/
);
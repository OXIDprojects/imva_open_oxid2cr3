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

$sMetadataVersion = '1.1';

/**
 * Module information
 */
$aModule = array(
	'id'			=> 'imva_open_oxid2cr3',
	'title'			=> array(
		'en'	=>	'connector for cr',
		'de'	=>	'Adapter für CleverReach',
	),
	'description'	=> array(
		'en'	=>	'<p>imva.biz CleverReach connector -- open source edition</p><p>Transfer newsletter subscriptions from your online shop to CleverReach the easy way -- with <i>CleverReach connector</i> by imva.biz. This connector also updates cancelled and updated subscriptions.</p>',
		'de'	=>	'<p>imva.biz Adapter für CleverReach -- quelloffene Ausgabe</p><p>Mit dem <i>Adapter für CleverReach</i> von imva.biz übertragen Sie Newsletter-Abonnenten aus Ihrem Shop sicher und einfach an CleverReach. Die Schnittstelle berücksichtigt auch aktualisierte Kundendaten und Abo-Kündigungen.</p>',
	),
	'thumbnail'		=> 'out/src/imva_oxid2cr-logo.png',
	'version'		=> '2.9.2.9',
	'author'		=> 'Johannes Ackermann',
	'url'			=> 'http://imva.biz',
	'email' 		=> 'imva@imva.biz',
	'extend'		=> array(
		'account_newsletter'		=>	'imva.biz/imva_open_oxid2cr3/application/controllers/imva_oxid2cr_accnl',
	),
	'files' => array(
		'imva_oxid2cr'				=>	'imva.biz/imva_open_oxid2cr3/application/controllers/imva_oxid2cr.php',
      	'imva_oxid2cr_admin'		=>	'imva.biz/imva_open_oxid2cr3/application/controllers/admin/imva_oxid2cr_admin.php',
      	'imva_oxid2cr_support'		=>	'imva.biz/imva_open_oxid2cr3/application/models/imva_oxid2cr_support.php',
      	'imva_oxid2cr_service'		=>	'imva.biz/imva_open_oxid2cr3/application/models/imva_oxid2cr_service.php',
	),
	'templates'	=>	array(
		'imva_oxid2cr.tpl'			=>	'imva.biz/imva_open_oxid2cr3/application/views/imva_oxid2cr.tpl',
        'imva_oxid2cr_admin.tpl'	=>	'imva.biz/imva_open_oxid2cr3/application/views/admin/imva_oxid2cr_admin.tpl',
	),
);
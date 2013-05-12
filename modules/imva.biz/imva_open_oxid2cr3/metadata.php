<?php
/**
 * http://imva.biz
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
	'version'		=> '2.9.0.0',
	'author'		=> 'Johannes Ackermann',
	'url'			=> 'http://imva.biz',
	'email' 		=> 'imva@imva.biz',
	'extend'		=> array(
		'account_newsletter'		=>	'imva_open_oxid2cr3/application/controllers/imva_oxid2cr_accnl',
	),
	'files' => array(
		'imva_oxid2cr'				=>	'imva_open_oxid2cr3/application/controllers/imva_oxid2cr.php',
      	'imva_oxid2cr_admin'		=>	'imva_open_oxid2cr3/application/controllers/admin/imva_oxid2cr_admin.php',
      	'imva_oxid2cr_service'		=>	'imva_open_oxid2cr3/application/models/imva_oxid2cr_service.php',
	),
	'templates'	=>	array(
		'imva_oxid2cr.tpl'			=>	'imva_open_oxid2cr3/application/views/imva_oxid2cr.tpl',
        'imva_oxid2cr_admin.tpl'	=>	'imva_open_oxid2cr3/application/views/admin/imva_oxid2cr_admin.tpl',
	),
);
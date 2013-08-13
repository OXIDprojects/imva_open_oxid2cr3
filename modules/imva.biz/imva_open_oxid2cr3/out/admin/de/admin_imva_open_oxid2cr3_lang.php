<?php

/**
 * IMVA Module Services: Main
 *
 *
 *
 * For redistribution in the provicer's network only.
 *
 * Weitergabe au&szlig;erhalb des Anbieternetzwerkes verboten.
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
 * Urheberrecht gesch&uuml;tzt. Diese Software wird ohne irgendwelche Garantien und "wie sie ist"
 * angeboten.
 *
 * Sie sind berechtigt, diese Software frei zu nutzen und auf Ihre Bed&uuml;rfnisse anzupassen.
 *
 * Jegliche Modifikation, Vervielf&auml;ltigung, Redistribution, &uuml;bertragung zum Zwecke der
 * Weiterentwicklung au&szlig;erhalb der Netzwerke des Anbieters ist untersagt und stellt einen Versto&szlig;
 * gegen die Lizenzvereinbarung dar.
 *
 * Mit der &uuml;bernahme dieser Software akzeptieren Sie die zwischen Ihnen und dem Herausgeber
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

$sLangName  = "Deutsch";
$aLang = array(
		'charset'						=>	'UTF-8',
		'imva_oxid2cr'					=>	'Adapter f&uuml;r CleverReach',
		'IMVA_OXID2CR_TITLE'			=>	'Adapter f&uuml;r CleverReach',
		
		'IMVA_OXID2CR_GOTO'				=>	'Gehe zu',
		
		//Install
		'IMVA_OXID2CR_INSTALL_MSG'		=>	'Die Datenbank muss vor der Verwendung dieses Moduls erweitert werden, um ben&ouml;tigte Angaben speichern zu k&ouml;nnen.',
		'IMVA_OXID2CR_INSTALL_NOW'		=>	'Datenbanktabellen einrichten',
		'IMVA_OXID2CR_SETUP_INSTALLING'	=>	'Die Installation wurde ausgef&uuml;hrt.',
		
		//Stats
		'IMVA_OXID2CR_STATS'			=>	'Statistik',
		'IMVA_OXID2CR_OPENSUBSCRIBERS'	=>	'Noch zu &uuml;bertragende Abonnenten',
		'IMVA_OXID2CR_TRANSFERREDSUBSCIBERS'=>'&uuml;bermittelte Abonnements',
		'IMVA_OXID2CR_CANCELLERS'		=>	'Zu k&uuml;ndigende Abonnements',
		'IMVA_OXID2CR_UNLOCKSUBSCR'		=>	'Alle Abonnements entsperren',
		'IMVA_OXID2CR_UNLOCK_HELP'		=>	'Setzt die &uuml;bertragungszust&auml;nde aller Abonnements zur&uuml;ck, um eine erneute &uuml;bertragung an den Dienst zu erm&ouml;glichen.',
		
		//urls
		'IMVA_OXID2CR_GETTINGSTARTED'	=>	'Adapter verwenden',
		'IMVA_OXID2CR_CRONJOBS'			=>	'Sie k&ouml;nnen die folgenden URLs verwenden, um Cronjobs einzurichten und die Schnittstelle auszul&ouml;sen. Klicken Sie auf die Beschreibung, um den kompletten URL zu markieren.',
		'IMVA_OPEN_OXID2CR3_PINGBOX'	=>	'Wenn Sie keine M&ouml;glichkeit haben, k&ouml;nnen Sie den Dienst',
		'IMVA_OPEN_OXID2CR3_PINGBOX2'	=>	'nutzen',
		
		//Settings
		'IMVA_OXID2CR_CONFIG'			=>	'Konfigurationseinstellungen',
		'CR_SETTINGS'					=>	'Verbindungseinstellungen',
		'CR_SET_HELP'					=>	'&ouml;ffnen Sie in CleverReach den Bereich <i>API</i> und generieren Sie dort Ihre Zugangsdaten.',
		'IMVA_OXID2CR_OPENCRAPI'		=>	'Zum Dienst',
		'CR_SET_API_KEY'				=>	'API-Key',
		'CR_SET_URL'					=>	'WSDL-URL',
		'CR_SET_URL_HLP'				=>	'Der URL kann nicht frei bearbeitet werden, da die Schnittstelle auf eine bestimmte Version des Dienstes ausgelegt ist.',
		'CR_SET_LISTID'					=>	'ID der Empf&auml;ngerliste',
		
		'IMVA_SECURITY'					=>	'Sicherheit und Leistung',
		'IMVA_SECRET_KEY_HINT'			=>	'Der <i>Secret Key</i> ist eine geheime Zeichenfolge, die der Schnittstelle &uuml;bergeben werden
											muss, um Transaktionen auszuf&uuml;hren. Er wird ben&ouml;tigt, um die Schnittstelle zu aktivieren,
											vorher ist aus Sicherheitsgr&uuml;nden keine Transaktion m&ouml;glich.',
		'IMVA_SECRET_KEY'				=>	'Secret Key',
		'IMVA_LINESPERTA'				=>	'Transaktionen pro Lauf',
		'LINESPERTA_HLP'				=>	'Abonnenten, die pro Transaktion &uuml;bertragen werden. Wecher Wert hier sinnvoll ist, h&auml;ngt auch von der Skriptlaufzeit Ihres Servers ab. Wir empfehlen einen Wert von h&ouml;chstens 10.',
		
		'CR_FIELDS'						=>	'Felder',
		'CR_FIELDS_HELP'				=>	'Wie hei&szlig;en die Felder in der CleverReach-Liste, die mit den vorhandenen Feldern in der Shop-Datenbank abgeglichen werden sollen?',
		'CR_SET_FLD_FIRSTN'				=>	'Vorname',
		'CR_SET_FLD_LASTN'				=>	'Nachname',
		'CR_SET_FLD_SAL'				=>	'Anrede',
		
		'IMVA_OXID2CR_STORE'			=>	'Speichern',
		
		//URLs generieren
		'IMVA_OXID2CR_SENDSUBSCR'		=>	'Abonnenten &uuml;bertragen',
		'IMVA_OXID2CR_UPDATESUBSCR'		=>	'Abonnenten aktualisieren',
		'IMVA_OXID2CR_CANCELSUBSCR'		=>	'Abonnements k&uuml;ndigen',
		
		//Uninstall :-(
		'IMVA_OXID2CR_UNINSTALL'		=>	'Datenbanktabellen entfernen',
		'IMVA_OXID2CR_UNINSTALL_REALLY'	=>	'Dadurch gehen vorhandene Informationen &uuml;ber Moduleinstellungen und Zust&auml;nde von Abonnements verloren.
											Im Falle einer Neuinstallation muss die Schnittstelle von vorn mit der &uuml;bertragung beginnen.',
		
		//View only
		'IMVA_OXID2CR_INSTALL_GOTOADMIN'=>	'&ouml;ffnen Sie im Shop-Admin das Men&uuml; &quot;Kundeninformationen&quot;&rarr;&quot;Adapter f&uuml;r CleverReach&quot; und f&uuml;hren Sie die Datenbankinstallation durch.',
		'IMVA_OXID2CR_PERFORMING'		=>	'Folgende Aktion wurde durchgef&uuml;hrt',
		'IMVA_OXID2CR_FAILURE'			=>	'Folgende Aktion schlug fehl',
);
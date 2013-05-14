<?php
$sLangName  = "Deutsch";
$aLang = array(
		'charset'						=>	'UTF-8',
		'imva_oxid2cr'					=>	'Adapter f�r CleverReach',
		'IMVA_OXID2CR_TITLE'			=>	'Adapter f�r CleverReach',
		
		'IMVA_OXID2CR_GOTO'				=>	'Gehe zu',
		
		//Install
		'IMVA_OXID2CR_INSTALL_MSG'		=>	'Die Datenbank muss vor der Verwendung dieses Moduls erweitert werden, um ben�tigte Angaben speichern zu k�nnen.',
		'IMVA_OXID2CR_INSTALL_NOW'		=>	'Datenbanktabellen einrichten',
		'IMVA_OXID2CR_SETUP_INSTALLING'	=>	'Die Installation wurde ausgef�hrt.',
		
		//Stats
		'IMVA_OXID2CR_STATS'			=>	'Statistik',
		'IMVA_OXID2CR_OPENSUBSCRIBERS'	=>	'Noch zu �bertragende Abonnenten',
		'IMVA_OXID2CR_TRANSFERREDSUBSCIBERS'=>'�bermittelte Abonnements',
		'IMVA_OXID2CR_CANCELLERS'		=>	'Zu k�ndigende Abonnements',
		'IMVA_OXID2CR_UNLOCKSUBSCR'		=>	'Alle Abonnements entsperren',
		'IMVA_OXID2CR_UNLOCK_HELP'		=>	'Setzt die �bertragungszust�nde aller Abonnements zur�ck, um eine erneute �bertragung an den Dienst zu erm�glichen.',
		
		//urls
		'IMVA_OXID2CR_GETTINGSTARTED'	=>	'Adapter verwenden',
		'IMVA_OXID2CR_CRONJOBS'			=>	'Sie k�nnen die folgenden URLs verwenden, um Cronjobs einzurichten und die Schnittstelle auszul�sen. Klicken Sie auf die Beschreibung, um den kompletten URL zu markieren.',
		
		//Settings
		'IMVA_OXID2CR_CONFIG'			=>	'Konfigurationseinstellungen',
		'CR_SETTINGS'					=>	'Verbindungseinstellungen',
		'CR_SET_HELP'					=>	'�ffnen Sie in CleverReach den Bereich <i>API</i> und generieren Sie dort Ihre Zugangsdaten.',
		'IMVA_OXID2CR_OPENCRAPI'		=>	'Zum Dienst',
		'CR_SET_API_KEY'				=>	'API-Key',
		'CR_SET_URL'					=>	'WSDL-URL',
		'CR_SET_URL_HLP'				=>	'Der URL kann nicht frei bearbeitet werden, da die Schnittstelle auf eine bestimmte Version des Dienstes ausgelegt ist.',
		'CR_SET_LISTID'					=>	'ID der Empf�ngerliste',
		
		'IMVA_SECURITY'					=>	'Sicherheit und Leistung',
		'IMVA_SECRET_KEY_HINT'			=>	'Der <i>Secret Key</i> ist eine geheime Zeichenfolge, die der Schnittstelle �bergeben werden
											muss, um Transaktionen auszuf�hren. Er wird ben�tigt, um die Schnittstelle zu aktivieren,
											vorher ist aus Sicherheitsgr�nden keine Transaktion m�glich.',
		'IMVA_SECRET_KEY'				=>	'Secret Key',
		'IMVA_LINESPERTA'				=>	'Transaktionen pro Lauf',
		'LINESPERTA_HLP'				=>	'Abonnenten, die pro Transaktion �bertragen werden. Wecher Wert hier sinnvoll ist, h�ngt auch von der Skriptlaufzeit Ihres Servers ab. Wir empfehlen einen Wert von h�chstens 10.',
		
		'CR_FIELDS'						=>	'Felder',
		'CR_FIELDS_HELP'				=>	'Wie hei�en die Felder in der CleverReach-Liste, die mit den vorhandenen Feldern in der Shop-Datenbank abgeglichen werden sollen?',
		'CR_SET_FLD_FIRSTN'				=>	'Vorname',
		'CR_SET_FLD_LASTN'				=>	'Nachname',
		'CR_SET_FLD_SAL'				=>	'Anrede',
		
		'IMVA_OXID2CR_STORE'			=>	'Speichern',
		
		//URLs generieren
		'IMVA_OXID2CR_SENDSUBSCR'		=>	'Abonnenten �bertragen',
		'IMVA_OXID2CR_UPDATESUBSCR'		=>	'Abonnenten aktualisieren',
		'IMVA_OXID2CR_CANCELSUBSCR'		=>	'Abonnements k�ndigen',
		
		//Uninstall :-(
		'IMVA_OXID2CR_UNINSTALL'		=>	'Datenbanktabellen entfernen',
		'IMVA_OXID2CR_UNINSTALL_REALLY'	=>	'Dadurch gehen vorhandene Informationen �ber Moduleinstellungen und Zust�nde von Abonnements verloren.
											Im Falle einer Neuinstallation muss die Schnittstelle von vorn mit der �bertragung beginnen.',
		
		//View only
		'IMVA_OXID2CR_INSTALL_GOTOADMIN'=>	'�ffnen Sie im Shop-Admin das Men� &quot;Kundeninformationen&quot;&rarr;&quot;Adapter f�r CleverReach&quot; und f�hren Sie die Datenbankinstallation durch.',
		'IMVA_OXID2CR_PERFORMING'		=>	'Folgende Aktion wurde durchgef�hrt',
		'IMVA_OXID2CR_FAILURE'			=>	'Folgende Aktion schlug fehl',
);
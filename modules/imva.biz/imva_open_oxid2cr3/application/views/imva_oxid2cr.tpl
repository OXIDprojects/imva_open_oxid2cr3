[{if $client == 'user'}]
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
	<title>[{oxmultilang ident='IMVA_OXID2CR_TITLE'}] - imva.biz ([{$int_version}])</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="publisher" content="imva.biz" />
	<meta name="author" content="imva.biz" />
	<meta name="copyright" content="[{"Y"|date}]" />
	<meta name="robots" content="nofollow" />
	<link rel="stylesheet" type="text/css" href="http://src.imva.biz/css/style.css" />
	<link rel="stylesheet" type="text/css" href="http://src.imva.biz/css/fonts/default.css" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<style>
		body{
			margin:20px;
			color:#333;
			font-size:0.8em;
			padding:0;
			background-color:#eaeaea;
		}
		div.content{
			background:#fff url(http://img.verlag.imva.biz/imva.biz-logo/imva-Logo-90.png) no-repeat bottom right;
			min-height:100px;
			padding:4px;
			padding-right:100px;
			border:8px solid #fff;
		}
		h1,h2{
			font-size:1.2em;
			font-weight:bold;
			color:#000;
			border-bottom:1px solid #808080;
		}
		h3{
			font-size:1.1em;
			font-weight:bold;
			color:#111;
			border-bottom:1px solid #999;
		}
		ul li{
			line-height:1.6em;
		}
		span.success{
			color:green;
			font-weight:bold;
		}
		a.btn, a.btn:link{
			color:#333;
			border:2px solid #900;
			padding:3px;
			background:#fff;
		}
		a.btn:visited{
			border:2px solid #900;
			padding:3px;
			background:#fff;
		}
		a.btn:hover{
			border:2px solid #cd1103;
			text-decoration:none;
		}
		form input.run{
			color:#333;
			border:2px solid green;
			padding:3px;
			background:#fff;			
			font-family:'Verdana',sans-serif;
		}
		a, a:link{
			color:#0a08b4;
			text-decoration:none;
		}
		a:visited{
			color:#0a08b4;
		}
		a:hover{
			border-bottom:1px solid #0a590a;
		}
		a:active{
			border-bottom:1px solid #cd1103;
			background:#eaeaea;
		}
		input.imva_oxid2cr_forautomatics{
			background:#eaeaea;
			color:#333;
			font-size:0.9em;
			width:300px;
		}
	</style>
</head>
<body>
<div><h1>[{oxmultilang ident='IMVA_OXID2CR_TITLE'}] - imva.biz</h1></div>

<div class="content">

	[{if !$oSvc->isInstalled()}]
		<div class="msg err">[{oxmultilang ident='IMVA_OXID2CR_INSTALL_MSG'}]</span><br />
		[{oxmultilang ident='IMVA_OXID2CR_INSTALL_GOTOADMIN'}]</div>
	[{/if}]

[{if $oView->imva_auth()}]
	[{if $int_frm_state == 'success'}]
		
		[{if $int_action == 'send2cr'}]
		[{elseif $int_action == 'setup'}]
			<p><span class="success">[{oxmultilang ident='IMVA_OXID2CR_SETUP_INSTALLING'}]</span><br />
			[{oxmultilang ident='IMVA_OXID2CR_SETUP_INSTALLING2'}] <a href="[{$oViewConf->getSslSelfLink()}]cl=imva_oxid2cr2[{$int_authtl}]" rel="nofollow">[{oxmultilang ident='IMVA_OXID2CR_NAV_BACK'}]</a></p>
		[{elseif $int_action == 'uninstall'}]	
			<p><span class="success">[{oxmultilang ident='IMVA_OXID2CR_UNINSTALL3'}]</span></p>
			<p>[{oxmultilang ident='IMVA_OXID2CR_UNINSTALL4'}]</p>
		[{/if}]
		<p><span class="success">[{oxmultilang ident='IMVA_OXID2CR_SUCCESS'}].</span> [{oxmultilang ident='IMVA_OXID2CR_AFFECTED_ROWS'}]: [{$affected_rows}]. <a href="[{$oViewConf->getSslSelfLink()}]cl=imva_oxid2cr2[{$int_authtl}]" rel="nofollow">[{oxmultilang ident='IMVA_OXID2CR_NAV_BACK'}]</a></p>
		
	[{elseif $int_frm_state == 'fail'}]
		<p><span class="fail">[{oxmultilang ident='IMVA_OXID2CR_FAILURE'}].</span> <a href="[{$oViewConf->getSslSelfLink()}]cl=imva_oxid2cr2[{$int_authtl}]" rel="nofollow">[{oxmultilang ident='IMVA_OXID2CR_NAV_BACK'}]</a></p>
	[{/if}]
	
	[{if $int_action}]
		[{if $int_action == 'send2cr'}]<h3>[{oxmultilang ident='IMVA_OXID2CR_TRANSFER2CR'}]</h3>
		[{*elseif $int_action == 'cancelcr2ox'}]<h3>[{oxmultilang ident='IMVA_OXID2CR_CANCEL_CR2OX'}]</h3><p>[{oxmultilang ident='IMVA_OXID2CR_CANCEL_CR2OX_EXPL'}]</p>*}]
		[{elseif $int_action == 'cancelox2cr'}]<h3>[{oxmultilang ident='IMVA_OXID2CR_CANCEL_OX2CR'}]</h3><p>[{oxmultilang ident='IMVA_OXID2CR_CANCEL_OX2CR_EXPL'}]</p>
		[{elseif $int_action == 'updateSent'}]<h3>[{oxmultilang ident='IMVA_OXID2CR_UPDATESENT'}]</h3><p>[{oxmultilang ident='IMVA_OXID2CR_UPDATESENT_EXPL'}]</p>
		[{elseif $int_action == 'unlockAll'}]<h3>[{oxmultilang ident='IMVA_OXID2CR_UNLOCKALL'}]</h3><p>[{oxmultilang ident='IMVA_OXID2CR_UNLOCKALL_EXPL'}]</p>
		[{elseif $int_action == 'uninstall'}]<h3>[{oxmultilang ident='IMVA_OXID2CR_UNINSTALL2'}]</h3><p>[{oxmultilang ident='IMVA_OXID2CR_UNINSTALL2_EXPL'}]</p>
		[{/if}]
		
		[{*<p>[{oxmultilang ident='IMVA_OXID2CR_READYTOSTART'}]</p>
		<form action="[{$oViewConf->getSslSelfLink()}]" method="get"> 
		<input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]" />
		<input type="hidden" name="client" value="user" />
		<input type="hidden" name="action" value="[{$int_action}]" />
		<input type="password" name="imva_auth_key" />
		<input type="hidden" name="imva_frm_chk" value="1" />
		<input type="submit" value="[{oxmultilang ident='IMVA_OXID2CR_NAV_RUN'}]" class="run" />
		</form>
		<p><a href="[{$oViewConf->getSslSelfLink()}]cl=imva_oxid2cr2[{$int_authtl}]" class="btn">[{oxmultilang ident='IMVA_OXID2CR_NAV_CANCEL'}]</a>*}]
	[{else}]
		[{*if $allowed_action == 'notallowed'}]
			<p><span class="fail">[{oxmultilang ident='IMVA_OXID2CR_NOTUNDERSTOOD'}].</span> <a href="[{$oViewConf->getSslSelfLink()}]cl=imva_oxid2cr2" rel="nofollow">[{oxmultilang ident='IMVA_OXID2CR_NAV_BACK'}]</a></p>
		[{/if*}]
		<h2>[{oxmultilang ident='IMVA_OXID2CR_SELECT_ACTION_H'}]</h2>
		<p>[{oxmultilang ident='IMVA_OXID2CR_SELECT_ACTION'}]</p>
		<ul>
		<li><a href="[{$oViewConf->getSslSelfLink()}]cl=imva_oxid2cr2&amp;action=send2cr[{$int_authtl}]" rel="nofollow">[{oxmultilang ident='IMVA_OXID2CR_TRANSFER2CR'}]</a> ([{oxmultilang ident='IMVA_OXID2CR_YETOPEN'}]: [{$oView->getOpenSubscribers()}])</li>
		[{*<li><a href="[{$oViewConf->getSslSelfLink()}]cl=imva_oxid2cr2&amp;action=cancelcr2ox[{$int_authtl}]" rel="nofollow">[{oxmultilang ident='IMVA_OXID2CR_CANCEL_CR2OX'}]</a></li>*}]
		<li><a href="[{$oViewConf->getSslSelfLink()}]cl=imva_oxid2cr2&amp;action=cancelox2cr[{$int_authtl}]" rel="nofollow">[{oxmultilang ident='IMVA_OXID2CR_CANCEL_OX2CR'}]</a> ([{oxmultilang ident='IMVA_OXID2CR_UPDATEABLE'}]: [{$oView->getAmountOfCancellers()}])</li>
		[{if $oView->getTransferredSubscribers() > 0}]
			<li><a href="[{$oViewConf->getSslSelfLink()}]cl=imva_oxid2cr2&amp;action=updateSent[{$int_authtl}]" rel="nofollow">[{oxmultilang ident='IMVA_OXID2CR_UPDATESENT'}]</a>
			([{oxmultilang ident='IMVA_OXID2CR_UPDATEABLE'}]: [{$oView->getTransferredSubscribers()}])</li>
		[{/if}]
		</ul>
		
		<h2>[{oxmultilang ident='IMVA_OXID2CR_SELECT_ACTION_MORE'}]</h2>
		<ul>
		<li><a href="[{$oViewConf->getSslSelfLink()}]cl=imva_oxid2cr2&amp;action=unlockAll[{$int_authtl}]" rel="nofollow">[{oxmultilang ident='IMVA_OXID2CR_UNLOCKALL'}]</a> ([{oxmultilang ident='IMVA_OXID2CR_ALREADYSENT'}]: [{$oView->getTransferredSubscribers()}])</li>
		</ul>
		[{*<hr />
		<p>[{oxmultilang ident='IMVA_OXID2CR_ABOUTGUI'}]</p>*}]
	[{/if}]
[{/if}]
</div>

<hr />
<small>&copy; 2012-[{"Y"|date}] <a href="http://imva.biz?ref=oxid2cr" target="blank">imva.biz</a> |
Version [{$oSvc->getVersion()}]</small>

</body></html>
[{/if}]
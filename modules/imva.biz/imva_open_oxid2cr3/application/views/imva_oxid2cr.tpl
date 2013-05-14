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
	</style>
</head>
<body>
<div><h1>[{oxmultilang ident='IMVA_OXID2CR_TITLE'}] - imva.biz</h1></div>

<div class="content">

	[{if !$oSvc->isInstalled()}]
		<div class="msg err">[{oxmultilang ident='IMVA_OXID2CR_INSTALL_MSG'}]</span><br />
		[{oxmultilang ident='IMVA_OXID2CR_INSTALL_GOTOADMIN'}]</div>
	[{/if}]
	
	[{if $oSvc->getAction()}]
		[{if $oSvc->blMission}]	
			<div class="msg suc">[{oxmultilang ident='IMVA_OXID2CR_PERFORMING'}]: [{$oSvc->getAction()}]</div>
		[{else}]
			<div class="msg err">[{oxmultilang ident='IMVA_OXID2CR_FAILURE'}]: [{$oSvc->getAction()}]</div>
		[{/if}]
	[{/if}]
</div>

<hr />
<small>&copy; 2012-[{"Y"|date}] <a href="http://imva.biz?ref=oxid2cr" target="blank">imva.biz</a> |
Version [{$oSvc->getVersion()}]</small>

</body></html>[{/if}]
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
	<title>[{oxmultilang ident='IMVA_OXID2CR_TITLE'}] - imva.biz ([{$int_version}])</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="publisher" content="imva.biz" />
	<meta name="author" content="imva.biz" />
	<meta name="copyright" content="2012-[{"Y"|date}]" />
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
		input.imva_oxid2cr_forautomatics{
			background:#eaeaea;
			color:#333;
			font-size:0.9em;
			width:300px;
		}
		fieldset{
			margin:0 0 12px 0;
		}
		fieldset legend{
			color:#369;
			font-style:italic;
			font-weight:bold;
		}
	</style>
</head>

<body>

<div class="content">

	[{if !$oSvc->isInstalled()}]
		<div class="msg err">[{oxmultilang ident='IMVA_OXID2CR_INSTALL_MSG'}] 
		<a href="[{$oViewConf->getSelfLink()}]cl=imva_oxid2cr_admin&amp;action=setup[{$int_authtl}]"
		rel="nofollow">[{oxmultilang ident='IMVA_OXID2CR_INSTALL_NOW'}]</a>.
		</div>
	[{/if}]
	
	<span>[{oxmultilang ident='IMVA_OXID2CR_GOTO'}]:</span>
	<ul>
		<li><a href="#configure">[{oxmultilang ident='IMVA_OXID2CR_CONFIG'}]</a></li>
		<li><a href="#gettingstarted">[{oxmultilang ident='IMVA_OXID2CR_GETTINGSTARTED'}]</a></li>
	</ul>
	
	
	<h2><a id="configure">[{oxmultilang ident='IMVA_OXID2CR_CONFIG'}]</a></h2>

	<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
		[{$oViewConf->getHiddenSid()}]
		<input type="hidden" name="oxid" value="[{ $oxid }]" />
		<input type="hidden" name="oxidCopy" value="[{ $oxid }]" />
		<input type="hidden" name="cl" value="admin_location_main" />
		<input type="hidden" name="language" value="[{ $actlang }]" />
	</form>

	<form action="[{$oViewConf->getSelfLink()}]" method="post"
		name="imva_oxid2cr_adm_store" id="imva_oxid2cr_adm_store"
		enctype="multipart/form-data">
		
		[{$oViewConf->getHiddenSid()}]
		<input type="hidden" name="cl" value="imva_oxid2cr_admin" />
		<input type="hidden" name="fnc" value="" />
		<input type="hidden" name="oxid" value="[{ $oxid }]" />
		<input type="hidden" name="voxid" value="[{ $oxid }]" />
		<input type="hidden" name="oxparentid" value="[{ $oxparentid }]" />
		<input type="hidden" name="editval[oxtraininglocations__oxid]" value="[{ $oxid }]" />
		<input type="hidden" name="language" value="[{ $actlang }]" />
		
		<fieldset>
			<legend>[{oxmultilang ident='CR_SETTINGS'}]</legend>
			
			<div class="msg">[{oxmultilang ident='CR_SET_HELP'}]</div>
			
			<label class="l wt_150" for="clre_api_key">[{oxmultilang ident='CR_SET_API_KEY'}]:</label>
			<input class="wt_250" type="text" id="clre_api_key" name="clre_api_key"
				value="[{$oSvc->readImvaConfig('clre_api_key')}]" />
			<div class="clear" />
			
			<label class="l wt_150" for="clre_wsdl_url">[{oxmultilang ident='CR_SET_URL'}]:</label>
			<input class="wt_250" type="text" id="clre_wsdl_url" name="clre_wsdl_url"
				value="[{$oSvc->readImvaConfig('clre_wsdl_url')}]"
				disabled="disabled" />
			<span><a title="[{oxmultilang ident='CR_SET_URL_HLP'}]">[?]</a></span>
			<div class="clear" />
			
			<label class="l wt_150" for="clre_list_id">[{oxmultilang ident='CR_SET_LISTID'}]:</label>
			<input class="wt_150" type="text" id="clre_list_id" name="clre_list_id"
				value="[{$oSvc->readImvaConfig('clre_list_id')}]" />
			<div class="clear" />
		</fieldset>
		
		<fieldset>
			<legend>[{oxmultilang ident='IMVA_SECURITY'}]</legend>
			
			<div class="msg">[{oxmultilang ident='IMVA_SECRET_KEY_HINT'}]</div>
			
			<label class="l wt_150" for="secret_key">[{oxmultilang ident='IMVA_SECRET_KEY'}]:</label>
			<input class="wt_250" type="text" id="secret_key" name="secret_key"
				value="[{$oSvc->readImvaConfig('secret_key')}]" />
			<div class="clear" />
			
			<label class="l wt_150" for="prfm_max_lines">[{oxmultilang ident='IMVA_LINESPERTA'}]:</label>			
			<select type="select" id="prfm_max_lines" name="prfm_max_lines">
				[{assign var="iIndex" value="10"}]
				
				[{foreach from=$iIndex key=key item=value}]
					[{counter print=false assign=countAg1}]
					<option value="[{$countAg1}]"[{if ($oSvc->readImvaConfig('oxid2cr_secret_key') == $countAg1)}] selected="selected"[{/if}]>[{$countAg1}]</option>
				[{/foreach}]
			</select>
			<span><a title="[{oxmultilang ident='LINESPERTA_HLP'}]">[?]</a></span>
			<div class="clear" />
			
			[{*
			<input class="wt_250" type="text" id="prfm_max_lines" name="prfm_max_lines"
				value="[{$oSvc->readImvaConfig('prfm_max_lines')}]" />*}]
			<div class="clear" />
		</fieldset>
		
		<fieldset>
			<legend>[{oxmultilang ident='CR_FIELDS'}]</legend>
			
			<div class="msg">[{oxmultilang ident='CR_FIELDS_HELP'}]</div>
			
			<label class="l wt_150" for="clre_field_firstname">[{oxmultilang ident='CR_SET_FLD_FIRSTN'}]:</label>
			<input class="wt_150" type="text" id="clre_field_firstname" name="clre_field_firstname"
				value="[{$oSvc->readImvaConfig('clre_field_firstname')}]" />
			<div class="clear" />
			
			<label class="l wt_150" for="clre_field_lastname">[{oxmultilang ident='CR_SET_FLD_LASTN'}]:</label>
			<input class="wt_150" type="text" id="clre_field_lastname" name="clre_field_lastname"
				value="[{$oSvc->readImvaConfig('clre_field_lastname')}]" />
			<div class="clear" />
			
			<label class="l wt_150" for="clre_field_salutation">[{oxmultilang ident='CR_SET_FLD_SAL'}]:</label>
			<input class="wt_150" type="text" id="clre_field_salutation" name="clre_field_salutation"
				value="[{$oSvc->readImvaConfig('clre_field_salutation')}]" />
			<div class="clear" />
		</fieldset>
	
	</form>
	
	<h2><a id="gettingstarted">[{oxmultilang ident='IMVA_OXID2CR_GETTINGSTARTED'}]</a></h2>
	<p>....</p>

</div>

<hr />
<small>&copy; 2012-[{"Y"|date}] <a href="http://imva.biz?ref=oxid2cr" target="blank">imva.biz</a> |
Version [{$oSvc->getVersion()}]</small>

</body></html>
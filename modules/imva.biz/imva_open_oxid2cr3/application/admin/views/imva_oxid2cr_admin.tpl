[{assign var="sModuleId" value=$oView->oSvc->sModuleId}]

[{block name='imva_header'}][{/block}]
[{if !$oView->oSvc->isInstalled()}]
		<div class="msg err">[{oxmultilang ident='IMVA_OXID2CR_INSTALL_MSG'}] 
		<a href="[{$oViewConf->getSelfLink()}]cl=imva_oxid2cr_admin&amp;action=setup"
		rel="nofollow">[{oxmultilang ident='IMVA_OXID2CR_INSTALL_NOW'}]</a>.
		</div>
		
[{else}]
	
	<div class="r"><div class="l">
		<span>[{oxmultilang ident='IMVA_OXID2CR_GOTO'}]:</span>
		<ul>
			<li><a href="#stats">[{oxmultilang ident='IMVA_OXID2CR_STATS'}]</a></li>
			<li><a href="#gettingstarted">[{oxmultilang ident='IMVA_OXID2CR_GETTINGSTARTED'}]</a></li>
			<li><a href="#configure">[{oxmultilang ident='IMVA_OXID2CR_CONFIG'}]</a></li>
		</ul>
	</div></div>
	
	
	
	[{if $oView->oSvc->getAction()}]
		[{if $oView->oSvc->blMission}]	
			<div class="msg suc">[{oxmultilang ident='IMVA_OXID2CR_PERFORMING'}]: [{$oView->oSvc->getAction()}]</div>
		[{else}]
			<div class="msg err">[{oxmultilang ident='IMVA_OXID2CR_FAILURE'}]: [{$oView->oSvc->getAction()}]</div>
		[{/if}]
	[{/if}]
	

	
	<h2><a id="configure">[{oxmultilang ident='IMVA_OXID2CR_STATS'}]</a></h2>
	<ul>
		<li>[{oxmultilang ident='IMVA_OXID2CR_OPENSUBSCRIBERS'}]: [{$oView->oSvc->getOpenSubscribers()}]</li>
		<li>[{oxmultilang ident='IMVA_OXID2CR_TRANSFERREDSUBSCIBERS'}]: [{$oView->oSvc->getTransferredSubscribers()}]</li>
		<li>[{oxmultilang ident='IMVA_OXID2CR_CANCELLERS'}]: [{$oView->oSvc->getAmountOfCancellers()}]</li>
	</ul>
	
	<form action="[{$oViewConf->getSelfLink()}]" method="post"
		name="imva_oxid2cr_adm_unlock" id="imva_oxid2cr_adm_unlock">
		
		[{$oViewConf->getHiddenSid()}]
		<input type="hidden" name="cl" value="imva_oxid2cr_admin" />
		<input type="hidden" name="action" value="unlock" />
		<input type="submit" value="[{oxmultilang ident='IMVA_OXID2CR_UNLOCKSUBSCR'}]"
			title="[{oxmultilang ident='IMVA_OXID2CR_UNLOCKSUBSCR'}]" />
	</form>
	
		
	
	<h2><a id="gettingstarted">[{oxmultilang ident='IMVA_OXID2CR_GETTINGSTARTED'}]</a></h2>
	
	<fieldset>
		<div class="msg">[{oxmultilang ident='IMVA_OXID2CR_CRONJOBS'}]
			[{oxmultilang ident='IMVA_OPEN_OXID2CR3_PINGBOX'}]
			<a href="http://pingbox.imva.biz">PINGBOX.imva.biz</a>
			[{oxmultilang ident='IMVA_OPEN_OXID2CR3_PINGBOX2'}]
		</div>
	
		<label class="l wt_200" for="url_send">[{oxmultilang ident='IMVA_OXID2CR_SENDSUBSCR'}]:</label>
		<input class="wt_250" type="text" id="url_send" value="[{$oView->getActionUrl('send')}]" readonly="readonly" />
		<div class="clear" />
		
		<label class="l wt_200" for="url_update">[{oxmultilang ident='IMVA_OXID2CR_UPDATESUBSCR'}]:</label>
		<input class="wt_250" type="text" id="url_update" value="[{$oView->getActionUrl('update')}]" readonly="readonly" />
		<div class="clear" />
		
		<label class="l wt_200" for="url_cancel">[{oxmultilang ident='IMVA_OXID2CR_CANCELSUBSCR'}]:</label>
		<input class="wt_250" type="text" id="url_cancel" value="[{$oView->getActionUrl('cancel')}]" readonly="readonly" />
		<div class="clear" />
	</fieldset>
	
	
	
	<h2><a id="configure">[{oxmultilang ident='IMVA_OXID2CR_CONFIG'}]</a></h2>

	<form action="[{$oViewConf->getSelfLink()}]" method="post"
		name="imva_oxid2cr_adm_store" id="imva_oxid2cr_adm_store"
		enctype="multipart/form-data">
		
		[{$oViewConf->getHiddenSid()}]
		<input type="hidden" name="cl" value="imva_oxid2cr_admin" />
		<input type="hidden" name="fnc" value="imva_store" />
		<input type="hidden" name="language" value="[{$actlang}]" />
		
		<fieldset>
			<legend>[{oxmultilang ident='CR_SETTINGS'}]</legend>
			
			<div class="msg">[{oxmultilang ident='CR_SET_HELP'}] <a href="https://eu.cleverreach.com/admin/account_interfaces.php?do=tab_api" target="_blank">[{oxmultilang ident='IMVA_OXID2CR_OPENCRAPI'}]</a></div>
			
			<label class="l wt_150" for="clre_api_key">[{oxmultilang ident='CR_SET_API_KEY'}]:</label>
			<input class="wt_250" type="text" id="clre_api_key" name="imva_edit[clre_api_key]"
				value="[{$oView->oSvc->readImvaConfig($sModuleId,'clre_api_key')}]" />
			<div class="clear" />
			
			<label class="l wt_150" for="clre_wsdl_url">[{oxmultilang ident='CR_SET_URL'}]:</label>
			<input class="wt_250" type="text" id="clre_wsdl_url" name="imva_edit[clre_wsdl_url]"
				value="[{$oView->oSvc->readImvaConfig($sModuleId,'clre_wsdl_url')}]"
				readonly="readonly" />
			<span><a title="[{oxmultilang ident='CR_SET_URL_HLP'}]">[?]</a></span>
			<div class="clear" />
			
			<label class="l wt_150" for="clre_list_id">[{oxmultilang ident='CR_SET_LISTID'}]:</label>
			<input class="wt_150" type="text" id="clre_list_id" name="imva_edit[clre_list_id]"
				value="[{$oView->oSvc->readImvaConfig($sModuleId,'clre_list_id')}]" />
			<div class="clear" />
		</fieldset>
		
		<fieldset>
			<legend>[{oxmultilang ident='IMVA_SECURITY'}]</legend>
			
			<div class="msg">[{oxmultilang ident='IMVA_SECRET_KEY_HINT'}]</div>
			
			<label class="l wt_150" for="secret_key">[{oxmultilang ident='IMVA_SECRET_KEY'}]:</label>
			<input class="wt_250" type="text" id="secret_key" name="imva_edit[secret_key]"
				value="[{$oView->oSvc->readImvaConfig($sModuleId,'secret_key')}]" />
			<div class="clear" />
			
			<label class="l wt_150" for="prfm_max_lines">[{oxmultilang ident='IMVA_LINESPERTA'}]:</label>			
			<select type="select" id="prfm_max_lines" name="imva_edit[prfm_max_lines]">
				[{assign var="iIndex" value="10"}]
				
				<option value="1"[{if ($oView->oSvc->readImvaConfig($sModuleId,'prfm_max_lines') == 1)}] selected="selected"[{/if}]>1</option>
				<option value="2"[{if ($oView->oSvc->readImvaConfig($sModuleId,'prfm_max_lines') == 2)}] selected="selected"[{/if}]>2</option>
				<option value="5"[{if ($oView->oSvc->readImvaConfig($sModuleId,'prfm_max_lines') == 5)}] selected="selected"[{/if}]>5</option>
				<option value="10"[{if ($oView->oSvc->readImvaConfig($sModuleId,'prfm_max_lines') == 10)}] selected="selected"[{/if}]>10</option>
				<option value="20"[{if ($oView->oSvc->readImvaConfig($sModuleId,'prfm_max_lines') == 20)}] selected="selected"[{/if}]>20</option>
				
			</select>
			<span><a title="[{oxmultilang ident='LINESPERTA_HLP'}]">[?]</a></span>
			<div class="clear" />
		</fieldset>
		
		<fieldset>
			<legend>[{oxmultilang ident='CR_FIELDS'}]</legend>
			
			<div class="msg">[{oxmultilang ident='CR_FIELDS_HELP'}]</div>
			
			<label class="l wt_150" for="clre_field_firstname">[{oxmultilang ident='CR_SET_FLD_FIRSTN'}]:</label>
			<input class="wt_150" type="text" id="clre_field_firstname" name="imva_edit[clre_field_firstname]"
				value="[{$oView->oSvc->readImvaConfig($sModuleId,'clre_field_firstname')}]" />
			<div class="clear" />
			
			<label class="l wt_150" for="clre_field_lastname">[{oxmultilang ident='CR_SET_FLD_LASTN'}]:</label>
			<input class="wt_150" type="text" id="clre_field_lastname" name="imva_edit[clre_field_lastname]"
				value="[{$oView->oSvc->readImvaConfig($sModuleId,'clre_field_lastname')}]" />
			<div class="clear" />
			
			<label class="l wt_150" for="clre_field_salutation">[{oxmultilang ident='CR_SET_FLD_SAL'}]:</label>
			<input class="wt_150" type="text" id="clre_field_salutation" name="imva_edit[clre_field_salutation]"
				value="[{$oView->oSvc->readImvaConfig($sModuleId,'clre_field_salutation')}]" />
			<div class="clear" />
		</fieldset>
		
		<input type="submit" value="[{oxmultilang ident='IMVA_OXID2CR_STORE'}]" />
	
	</form>
[{/if}]
</div>
[{block name='imva_footer'}][{/block}]
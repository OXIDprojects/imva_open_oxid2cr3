[{if $oView->sClient == 'user'}]
	[{block name='imva_header'}][{/block}]
	
	[{if !$oView->oSvc->isInstalled()}]
		<div class="msg err">[{oxmultilang ident='IMVA_OXID2CR_INSTALL_MSG'}]</span><br />
		[{oxmultilang ident='IMVA_OXID2CR_INSTALL_GOTOADMIN'}]</div>
	[{/if}]
	
	[{if $oView->oSvc->getAction()}]
		[{if $oView->oSvc->blMission}]	
			<div class="msg suc">[{oxmultilang ident='IMVA_OXID2CR_PERFORMING'}]: [{$oView->oSvc->getAction()}]</div>
		[{else}]
			<div class="msg err">[{oxmultilang ident='IMVA_OXID2CR_FAILURE'}]: [{$oView->oSvc->getAction()}]</div>
		[{/if}]
	[{/if}]
	
	[{block name='imva_footer'}][{/block}]
[{/if}]
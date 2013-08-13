</div>
<hr />
<small>&copy; 2012-[{"Y"|date}] <a href="http://imva.biz?ref=oxid2cr" target="blank">imva.biz</a> |
Version [{$oView->oSvc->getModuleVersion('imva_open_oxid2cr3')}]
<br />This module is free. You can <a href="http://imva.biz/blog/2013/05/oxid-modul-adapter-fur-cleverreach-wird-quelloffen/" target="_blank">support the developers by flattr</a>

[{*if $oView->oSvc->isInstalled()}]
	| <a href="[{$oViewConf->getSelfLink()}]cl=imva_oxid2cr_admin&amp;action=uninstall"
	rel="nofollow">[{oxmultilang ident='IMVA_OXID2CR_UNINSTALL'}]</a>
[{/if*}]</small>

</body></html>
<?php if (defined("RS_TPL")) {?>
	<div class=portlet>
		<h2><?php $this->attr_id ?></h2>
		<?php $this->startLoop("allSects"); ?>	
			<table align=center width=60% border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>
			<caption><?php $this->Title ?></caption>
			
			<?php $this->CountMod ?>
			<?php $this->ResOut ?> 
			</table><br>
		<?php $this->endLoop(); ?>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
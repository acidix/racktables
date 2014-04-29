<?php if (defined("RS_TPL")) {?>
	<?php if($this->is('Rules_empty', TRUE)){ ?> <div class=portlet><h2><?php $this->Title; ?></h2>
			<?php } else { ?>
				<div class=portlet><h2><?php $this->Title; ?></h2>
				<table class=cooltable align=center border=0 cellpadding=5 cellspacing=0>
				<tr><th>sequence</th><th>regexp</th><th>role</th><th>VLAN IDs</th><th>comment</th></tr>
				<?php $this->ItemRows ?>
				</table>
			<?php } ?>		
			</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
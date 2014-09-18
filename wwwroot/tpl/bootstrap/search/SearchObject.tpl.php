<?php if (defined("RS_TPL")) {?>
	<tr class=row_<?php $this->get("rowOrder"); ?> valign=top>
	<td> <?php $this->get("objImage") ?> </td><td class=tdleft>
	<?php if ($this->is("ObjectsByAttr",true)) { ?>
		<?php $this->startLoop("Objects_Attr"); ?>
			<div class="callout callout-info"><?php $this->get("Attr_Name"); ?> matched</div>
		<?php $this->endLoop(); ?>
	<?php } ?>
		
	<?php if ($this->is("ObjectsBySticker",true)) { ?>
		<div class="callout callout-info">
			<table class="table table-condensed">
				<?php $this->startLoop("Objects_Sticker"); ?>
					<tr><th width='50%' class=sticker><?php $this->get("Name");?>:</th>
					<td class=sticker><?php $this->get("AttrValue"); ?></td></tr>
				<?php $this->endLoop(); ?>
			</table>
		</div>
	<?php } ?>

	<?php if ($this->is("ObjectsByPort",true)) { ?>
		<div class="callout callout-info">
			<table class="table table-condensed">
				<?php $this->startLoop("Objects_Port"); ?>
				<tr><td><?php $this->get("Href"); ?></td>
					<td><?php $this->get("Text"); ?></td></tr>
				<?php $this->endLoop(); ?>
			</table>
		</div>				
	<?php } ?>

	<?php if ($this->is("ObjectsByIface",true)) { ?>
		<?php $this->startLoop("LogTableData"); ?>
			<div class="callout callout-info">interface <?php $this->get("Ifname"); ?></div>
		<?php $this->endLoop(); ?>
	<?php } ?>

		<!-- <?php $this->get("ObjectsByNAT");?> -->
	<?php if ($this->is("ObjectsByNAT",true)) { ?>
		<?php $this->startLoop("Objects_NAT"); ?>
			<div class="callout callout-info"><?php $this->get("Comment"); ?></div>
		<?php $this->endLoop(); ?>		
	<?php } ?>

	<?php if ($this->is("ObjectsByCableID",true)) { ?>
		<?php $this->startLoop("Objects_CableID"); ?>
			<div class="callout callout-info">link cable ID: <?php $this->get("CableID"); ?></div>
		<?php $this->endLoop(); ?>
	<?php } ?>	
	</td></tr>	
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
<?php if (defined("RS_TPL")) {?>

	<?php 	$this->addRequirement("Header","HeaderJsInclude",array("path"=>"js/slb_editor.js"));
		 	$this->addRequirement("Header","HeaderJsInclude",array("path"=>"js/jquery.thumbhover.js"));?>

	<?php if($this->is("showTriplets", true)){?>
		<div class=portlet>
			<h2> VS group instances ( <?php $this->countTriplets ?> ) </h2>

			<table cellspacing=0 cellpadding=5 align=center class=widetable><tr><th></th>"
			<?php $this->startLoop("headersArray") ?>
				<th> <?php $this->header ?> </th>
			<?php $this->endLoop() ?>
			
			<th>Ports</th>
			<th>VIPs</th>
			</tr>
	<?php } ?>
	<?php $this->AllTriplets ?>
	
	<?php if($this->is("showTriplets", true)){?>
		</table>
		</div>
	<?php } ?>

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
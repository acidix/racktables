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

	<?php $this->startLoop("allTripletOutArray") ?>

		<tr valign=top class='row_<?php $this->order ?> triplet-row'>
		<td><a href="#" onclick="slb_config_preview(event <?php $this->slb_object_id ?>, <?php $this->slb_vs_id ?>, <?php $this->slb_rspool_id ?>); return false"> <?php $this->getH("PrintImageHref", array('Zoom', 'config preview'));?> </a></td>
		
		<?php $this->startLoop("cellOutputArray") ?>
			<td <?php $this->span_html ?> class=tdleft>
			<?php $this->slb_cell ?>
		<?php $this->endLoop() ?>	

		<td class=tdleft><ul class='<?php $this->class ?>'>
		<?php $this->startLoop("portOutputArray"); ?>	
			<li class="<?php $this->rowClass ?>" >
			<?php $this->formatedVSPort ?> 
			<?php $this->popupSLBConfig ?> 
			<?php $this->tripletForm ?> 
			</li>
		<?php $this->endLoop(); ?> 
		</ul></td>

		<td class=tdleft><ul class='$class'>
		<?php $this->startLoop("vipAllOutput"); ?>	
			<li class='<?php $this->li_class ?> '>
			<?php $this->formated_VISP ?> 

			<?php if ($this->is("rowIsTrue",true)) { ?>
		        <span class="<?php $this->prioClass ?> "><?php $this->rowPrio ?> </span>
			<?php } ?> 
			<?php $this->popupSLBConfig ?> 
			<?php $this->tripletForm ?> 
		<?php $this->endLoop(); ?> 
		</ul></td>

		<?php if ($this->is("editable",true)) { ?>
			<td valign=middle>
			<?php $this->getH("PrintOpFormIntro", $this->formIntroPara); ?> 
			<?php $this->getH("PrintImageHref", 'DELETE', 'Remove triplet', TRUE); ?> 
			</form></td>
		<?php } ?> 
		
	<?php $this->endLoop() ?>

	<?php if($this->is("showTriplets", true)){?>
		</table>
		</div>
	<?php } ?>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
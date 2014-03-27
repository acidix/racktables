<?php if (defined("RS_TPL")) {?>
	<div class=portlet>
		<h2></h2>
		<?php $this->getH("PrintOpFormIntro", array('update')); ?>
		<table border=0 cellspacing=0 cellpadding=3 align=center>
		<tr><td>&nbsp;</td><th colspan=2><h2>Attributes</h2></th></tr>
		<tr><td>&nbsp;</td><th class=tdright>Type:</th><td class=tdleft>
		<?php $this->selectedObj ?>
		</td></tr>
		<tr><td>&nbsp;</td><th class=tdright>Common name:</th><td class=tdleft><input type=text name=object_name value='<?php $this->object_name ?>'></td></tr>
		<tr><td>&nbsp;</td><th class=tdright>Visible label:</th><td class=tdleft><input type=text name=object_label value='<?php $this->object_label ?>'></td></tr>
		<tr><td>&nbsp;</td><th class=tdright>Asset tag:</th><td class=tdleft><input type=text name=object_asset_no value='<?php $this->object_asset_no ?>'></td></tr>
		<?php if ($this->is("haveParent",true)) { ?>
		<?php $this->startLoop("allParents"); ?>	
			<tr><td>&nbsp;</td>
			<th class=tdright><?php $this->label ?></th><td class=tdleft>
			<?php $this->mkA ?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php $this->parentsOpLink ?>
			</td></tr>
		<?php $this->endLoop(); ?> 
			<tr><td>&nbsp;</td>
			<th class=tdright>Select container:</th><td class=tdleft>
			<span onclick='window.open("<?php $this->hrefHelper ?>", "findlink", "height=700, width=400, location=no, menubar=no, 
				resizable=yes, scrollbars=yes, status=no, titlebar=no, toolbar=no");'>
				<?php $this->imageSelCont ?>
			</span></td></tr>
		<?php } ?> 
		<?php if ($this->is("areValues",true)) { ?>
			<?php $this->startLoop("allObjVals"); ?>	
				<input type=hidden name=<?php $this->i ?>_attr_id value=<?php $this->id ?>>
				<tr><td>
				<?php $this->value_link ?>
				</td>
				<th class=sticker><?php $this->name ?>
				<?php if (!$this->is("dateFormatTime", null)) { ?>
					(<?php $this->dateFormatTime ?>)
				<?php } ?> 	
				:</th><td class=tdleft>
				<?php if ($this->is('type','string')) { ?>
					<input type=text name=<?php $this->i ?>_value value='<?php $this->value ?>'>
				<?php } ?> 
				<?php if ($this->is('type','dict')) { ?>
					<?php $this->niftyStr ?>
				<?php } ?>
				<?php if ($this->is('type', 'date')) { ?>
				 	<input type=text name=<?php $this->i ?>_value value='<?php $this->date_value ?>'>
				<?php } ?>  		
			<?php $this->endLoop(); ?>
			</td></tr>
		<?php } ?> 
		<input type=hidden name=num_attrs value=<?php $this->i ?>>
		<tr><td>&nbsp;</td><th class=tdright>Has problems:</th><td class=tdleft><input type=checkbox name=object_has_problems
		<?php if ($this->is("hasProblems",treu)) { ?>
			 checked
		<?php } ?> 
		></td></tr>
		<tr><td>&nbsp;</td><th class=tdright>Actions:</th><td class=tdleft>
		<?php $this->deleteObjLink ?>&nbsp;<?php $this->addObjLink ?>
		</td></tr>
		<tr><td colspan=3><b>Comment:</b><br><textarea name=object_comment rows=10 cols=80><?php $this->object_comment ?></textarea></td></tr>
		<tr><th class=submit colspan=3>
		<?php $this->getH("PrintImageHref", array('SAVE', 'Save changes', TRUE)); ?>
		</form></th></tr></table>
	</div>
	<table border=0 width=100%><tr><td>
	<div class=portlet>
		<h2>history</h2>
		<?php $this->objectHistoryMod ?>
	</div>
	</td></tr></table>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
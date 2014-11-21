<?php if (defined("RS_TPL")) {?>
<div class="box box-info" style="position: relative; overflow-x: auto">
	<div class="box-header">
	    <h4 class="box-title">Attributes</h4>
	</div>
	<div class="box-body" style="position: relative">
		<?php $this->getH("PrintOpFormIntro", array('update')); ?>
		<div class="row edit_row"><div class="col-sm-6 tdright header">Type:</div><div class="col-sm-6 tdleft"><?php $this->PrintOptSel ?></div></div>
		<br> 
		<div class="row edit_row"><div class="col-sm-6 tdright header">Common name:</div><div class="col-sm-6 tdleft"><input type=text name=object_name value='<?php $this->object_name ?>'></div></div>
		<div class="row edit_row"><div class="col-sm-6 tdright header">Visible label:</div><div class="col-sm-6 tdleft"><input type=text name=object_label value='<?php $this->object_label ?>'></div></div>
		<div class="row edit_row"><div class="col-sm-6 tdright header">sset tag:</div><div class="col-sm-6 tdleft"><input type=text name=object_asset_no value='<?php $this->object_asset_no ?>'></div></div>
		<div class="row edit_row"><div class="col-sm-6 tdright header">Tags:</div><div class="col-sm-6 tdleft"><?php $this->TagsPicker ?></div></div>
		<br>
		<?php if ($this->is("haveParent",true)) { ?>
		<?php $this->startLoop("allParents"); ?>	
			<div class="row edit_row"><div class="col-sm-6 tdright"><?php $this->label ?></div><div class="col-sm-6 tdleft">
			<?php $this->mkA ?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php $this->parentsOpLink ?>
			</div></div>
		<?php $this->endLoop(); ?> 
			<div class="row edit_row"><div class="col-sm-6 tdright">Select container:</div><div class="col-sm-6 tdleft">
			<span onclick='window.open("?module=popup&helper=objlist&object_id=<?php $this->ObjID ?>", "findlink", "height=700, width=400, location=no, menubar=no, resizable=yes, scrollbars=yes, status=no, titlebar=no, toolbar=no");'>
			<?php $this->getH("PrintImageHref", array('attach', 'Select a container')); ?>
			</span></div></div>
		<?php } ?> 
		<?php if ($this->is("areValues",true)) { ?>	
			<?php $this->value_link ?>
	
			<?php while ($this->loop('AllObjValues')) : ?>
				<input type=hidden name=<?php $this->i ?>_attr_id value=<?php $this->id ?>>
				<div class="row edit_row"><div class="col-sm-6 tdright sticker"><?php $this->name ?>
				<?php if ($this->is("dateFormatTime")) { ?>
					(<?php $this->dateFormatTime ?>)
				<?php } ?>:</div><div class="col-sm-6 tdleft">
				<?php if ($this->is('type','string') || $this->is('type','float') ||
						  $this->is('type','uint') ) { ?>
					<input type=text name=<?php $this->i ?>_value value='<?php $this->value ?>'>
				<?php } ?> 
				<?php if ($this->is('type','dict')) { ?>
					<?php $this->niftyStr ?>
				<?php } ?>
				<?php if ($this->is('type', 'date')) { ?>
				 	<input type=text name=<?php $this->i ?>_value value='<?php $this->date_value ?>'>
				<?php } ?>
				</div></div>
			<?php endwhile ?>
		<?php } ?> 
		<input type=hidden name=num_attrs value=<?php $this->i ?>>
		<div class="row edit_row"><div class="col-sm-6 tdright">Has problems:</div><div class="col-sm-6 tdleft"><input type=checkbox name=object_has_problems
		<?php if ($this->is("hasProblems",true)) { ?>
			 checked
		<?php } ?> 
		></div></div>
		<div class="row edit_row"><div class="col-sm-6 tdright">Actions:</div><div class="col-sm-6 tdleft">
		<?php $this->deleteObjLink ?>&nbsp;<?php $this->resObjLink ?>
		</div></div>
		<div class="row edit_row"><div class="col-sm-6 tdright">Comment:</div><div class="col-sm-6 tdleft"><textarea name=object_comment rows=10 cols=80><?php $this->Obj_comment ?></textarea></div></div>
		<div class="row edit_row" align="center">
		<?php $this->getH("PrintImageHref", array('SAVE', 'Save changes', TRUE)); ?>
		</div></form>
	</div>

	<div class="box " style="position: relative; overflow-x: auto">
		<div class="box-header">
		    <h4 class="box-title">history</h4>
		</div>
		<div class="box-body" style="position: relative">
		<?php $this->objectHistoryMod ?>
		</div>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
<?php if (defined("RS_TPL")) {?>
<div class="box box-primary">
	<div class="box-body">
	
	<div class="row edit_row"><div class="col-sm-4"></div><div class="col-sm-4 header tdright">Parent</div><div class="col-sm-4 header tdleft">Child</div></div>
	<?php if($this->is("AddTop", true)) : ?>
		<?php $this->getH('PrintOpFormIntro', 'add'); ?>
		<div class="row edit_row">
			<div class="col-sm-4"><button class="btn btn-primary btn-sm" title="Add pair" name="submit"><span class="glyphicon glyphicon-plus"></span></button></div>
			<div class="col-sm-4 tdright"><?php $this->Parent; ?></div>
			<div class="col-sm-4 tdleft"><?php $this->Child; ?></div>
		</div>
		</form>
	<?php endif ?>
	
	<?php $this->startLoop('Looparray'); ?>
		<div class="row edit_row">
			<div class="col-sm-4"><a class="btn btn-danger btn-sm" href="?module=redirect&amp;op=del&amp;parent_objtype_id=<?php $this->Parent_Id ?>&amp;child_objtype_id=<?php $this->Child_Id ?>&amp;page=parentmap&amp;tab=edit" title="Remove pair">
				<span class="glyphicon glyphicon-minus"></span>
			</a></div>
			<div class="col-sm-4 tdright"><?php $this->Parentname; ?></div>
			<div class="col-sm-4 tdleft"><?php $this->Childname; ?></div>
		</div>
	<?php $this->endLoop(); ?>
	
	<?php if($this->is("AddTop", false)) : ?>
		<?php $this->getH('PrintOpFormIntro', 'add'); ?>
		<div class="row edit_row">
			<div class="col-sm-4"><button class="btn btn-primary btn-sm" title="Add pair" name="submit"><span class="glyphicon glyphicon-plus"></span></button></div>
			<div class="col-sm-4 tdright"><?php $this->Parent; ?></div>
			<div class="col-sm-4 tdleft"><?php $this->Child; ?></div>
		</div>
		</form>
	<?php endif ?>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
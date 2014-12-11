<?php if (defined("RS_TPL")) {?>
<div class="box box-primary">
	<div class="box-body">
	<table class="table table-striped">
	<thead>
		<tr><th>&nbsp;</th><th>Parent</th><th>Child</th></tr>
	</thead>
	<tbody>
		<?php if($this->is("AddTop", true)) : ?>
			<?php $this->getH('PrintOpFormIntro', 'add'); ?>
			<tr>
				<td><button class="btn btn-primary btn-sm" title="Add pair" name="submit"><span class="glyphicon glyphicon-plus"></span></button></td>
				<td class="tdright"><?php $this->Parent; ?></td>
				<td class="tdleft"><?php $this->Child; ?></td>
			</tr>
			</form>
		<?php endif ?>
		
		<?php while( $this->Loop('Looparray') ) { ?>
			<tr>
				<td>
				<?php $this->getH('GetOpLink', array(array ('op' => 'del', 'parent_objtype_id' => $this->_Parent_Id, 'child_objtype_id' => $this->_Child_Id), '<span class="glyphicon glyphicon-minus"></span>', '', 'Remove pair', 'btn btn-danger btn-sm')); ?>
				</td>
				<td class="tdright"><?php $this->Parentname; ?></td>
				<td class="tdleft"><?php $this->Childname; ?></td>
			</tr>
		<?php } ?>
		
		<?php if($this->is("AddTop", false)) : ?>
			<?php $this->getH('PrintOpFormIntro', 'add'); ?>
			<tr>
				<td><button class="btn btn-primary btn-sm" title="Add pair" name="submit"><span class="glyphicon glyphicon-plus"></span></button></td>
				<td class="tdright"><?php $this->Parent; ?></td>
				<td class="tdleft"><?php $this->Child; ?></td>
			</tr>
			</form>
		<?php endif ?>
	</tbody>
	</table>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
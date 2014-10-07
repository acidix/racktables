<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Put a name here!</h3>
	</div>
	<div class="box-content no-padding">
		<table class="table table-striped">
			<thead>
				<th>Amount</th><th>End 1</th><th>Cable type</th><th>End 2</th><th>Length</th><th>Description</th><th>&nbsp;</th>
			</thead>
			<tbody>
				<?php $this->AddNewTop ?>
				<?php while($this->refLoop('AllHeaps')) { ?>
					<?php $this->getH("PrintOpFormIntro", array('upd', array ('id' => $this->_HeapId))); ?>
					<tr>
						<td><?php $this->HeapAmount ?></td>
						<td><?php $this->EndCon1_Select ?></td>
						<td><?php $this->PCType_Select ?></td>
						<td><?php $this->EndCon2_Select ?></td>
						<td><input type=text size=6 name=length value='<?php $this->HeapLength ?>'></td>
						<td><input type=text size=48 name=description value="<?php $this->HeapString ?>"></td>
						<td><?php $this->getH("PrintImageHref", array('save', 'Save changes', TRUE)); ?>
							<div class="btn-group">
								<button name="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span></button>
								<?php $this->getH("GetOpLink", array(array ('op' => 'del', 'id' => $this->_HeapId), '<span class="glyphicon glyphicon-remove"></span>', '', 'remove this item', 'btn btn-danger')); ?>					
							</div>
						</td>
					</tr>
					</form>
				<?php } ?>
				<?php $this->AddNewBottom ?>
			</tbody>
		</table>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
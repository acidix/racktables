<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Put a name here!</h3>
	</div>
	<div class="box-content no-padding">
		<table class="table table-striped">
			<thead>
				<tr><th>&nbsp;</th><th>Amount</th><th>End 1</th><th>Cable type</th><th>End 2</th><th>Length</th><th>Description</th><th>&nbsp;</th></tr>
			</thead>
			<tbody>
				<?php while($this->refLoop('AllHeaps')) { ?>
					<?php $this->getH("PrintOpFormIntro", array('set', array ('id' => $this->_HeapId))); ?>
					<tr>
						<td><input type=text size=7 name=amount value='<?php $this->HeapAmount ?>'></td>
						<td><?php $this->getH("GetOpLink", array(array ('op' => 'inc', 'id' => $this->_HeapId), '', 'add', 'replenish')); ?></td>
						<td><?php $this->EndCon1_String ?></td>
						<td><?php $this->PCType_String ?></td>
						<td><?php $this->EndCon2_String ?></td>
						<td><?php $this->HeapLength ?></td>
						<td><?php $this->HeapString ?></td>
						<td>
							<div class="btn-group">
								<button name="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span></button>
								<?php if ($this->_HeapAmount > 0) { ?>
									<?php $this->getH('GetOpLink', array(array ('op' => 'dec', 'id' => $this->_HeapId), '<span class="glyphicon glyphicon-remove"></span>', '', 'consume', 'btn btn-danger')); ?>
								<?php } else { ?>
									<a href="#" class="btn btn-danger btn-disabled"><span class="glyphicon glyphicon-remove"></span></a>
								<?php } ?> 
							</div>
						</td>
					</tr>
					</form>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
	</div>
	<div class="box-body">
		<table class="table table-striped">
			<thead>
				<tr><th>&nbsp;</th><th>Amount</th><th>&nbsp;</th><th>End 1</th><th>Cable type</th><th>End 2</th><th>Length</th><th>Description</th><th>&nbsp;</th></tr>
			</thead>
			<tbody>
				<?php while($this->refLoop('AllHeaps')) { ?>
					<?php $this->getH("PrintOpFormIntro", array('set', array ('id' => $this->_HeapId))); ?>
					<tr>
						<td>
							<?php if ($this->_HeapAmount > 0) { ?>
								<a href="?module=redirect&amp;op=dec&amp;id=<?php  $this->HeapId ?>&amp;page=cables&amp;tab=amount" title="consume">
							   <i class="fa fa-fw fa-minus"></i></a>
							<?php } else { ?>
								<a style="color: grey">
								<i class="fa fa-fw fa-minus"></i></a>
							<?php } ?>
						</td>
						<td><input type=text size=7 name=amount value='<?php $this->HeapAmount ?>'></td>
						<td>
								<a href="?module=redirect&amp;op=inc&amp;id=<?php  $this->HeapId ?>&amp;page=cables&amp;tab=amount"  title="replenish">
								<i class="fa fa-fw fa-plus"></i> </a>
						</td>
						<td><?php $this->EndCon1_String ?></td>
						<td><?php $this->PCType_String ?></td>
						<td><?php $this->EndCon2_String ?></td>
						<td><?php $this->HeapLength ?></td>
						<td><?php $this->HeapString ?></td>
						<td>
							<button name="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span></button>
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

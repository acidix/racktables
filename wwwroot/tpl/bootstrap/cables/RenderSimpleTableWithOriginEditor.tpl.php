<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-body">
		<table class="table">
			<thead>
				<tr><th>Origin</th><th><?php $this->ColHeader ?></th></tr>
			</thead>
			<tbody>
				<?php if($this->is('NewTop')) { ?>
					<?php $this->getH('PrintOpFormIntro', array('add')); ?>
					<tr>
						<td>&nbsp;</td>
						<td><input type=text size=<?php $this->ColumnWidth ?> name=<?php $this->ColumnValue ?> tabindex=100></td>
						<td><button class="btn btn-primary btn-sm" title="Create new" name="submit"><span class="glyphicon glyphicon-plus"></span></button></td>
					</tr>
					</form>
				<?php } ?>
				<?php while($this->refLoop('AllRows')) { ?>
					<tr>
					<?php if ($this->is('OriginIsDefault', true)) { ?>
						<td><span class="glyphicon glyphicon-home"></span></td>
							<td>&nbsp;</td>
						<td><?php $this->RowValueWidth ?></td>
						<td>&nbsp;</td>
					<?php } else { ?>
						<?php $this->getH('PrintOpFormIntro', array('upd', array ($this->_Key => $this->_ColumnKey))); ?>
						<td><span style="color: red" class="glyphicon glyphicon-heart"></span></td>
						<td><?php $this->getH('GetOpLink', array(array ('op' => 'del', $this->_Key => $this->_ColumnKey), '<span class="glyphicon glyphicon-minus"></span>', '', 'Remove', 'btn btn-danger btn-sm')); ?></td>
						<td><input type=text size=<?php $this->Width ?> name=<?php $this->Value ?> value='<?php $this->RowValueWidth ?>'></td>
						<td><button class="btn btn-success btn-sm" title="Save changes" name="submit"><span class="glyphicon glyphicon-ok"></span></button></td>
						</form>
					<?php } ?> 
					</tr>
				<?php } ?>
				<?php if(!$this->is('NewTop')) { ?>
					<?php $this->getH('PrintOpFormIntro', array('add')); ?>
					<tr>
						<td>&nbsp;</td>
						<td><input type=text size=<?php $this->ColumnWidth ?> name=<?php $this->ColumnValue ?> tabindex=100></td>
						<td><button class="btn btn-primary btn-sm" title="Create new" name="submit"><span class="glyphicon glyphicon-plus"></span></button></td>
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
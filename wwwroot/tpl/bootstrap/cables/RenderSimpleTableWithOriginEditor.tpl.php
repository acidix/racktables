<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">TITLE HERE</h3>
	</div>
	<div class="box-content no-padding">
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
						<td class=tdleft><button class="btn btn-primary" name="submit"><span class="glyphicon glyphicon-ok"></span></button></td>
					</tr>
					</form>
				<?php } ?>
				<?php while($this->refLoop('AllRows')) { ?>
					<tr>
					<?php if ($this->is('OriginIsDefault', true)) { ?>
						<td><?php $this->getH('PrintImageHref', array('computer', 'default')); ?></td>
						<td>&nbsp;</td>
						<td><?php $this->RowValueWidth ?></td>
						<td>&nbsp;</td>
					<?php } else { ?>
						<td><?php $this->getH('PrintOpFormIntro', array('upd', array ($this->_Key => $this->_ColumnKey))); ?>
						<?php $this->getH("PrintImageHref", array('favorite', 'custom')); ?></td>
						<td><?php $this->getH('GetOpLink', array(array ('op' => 'del', $this->_Key => $this->_ColumnKey), '', 'destroy', 'remove')); ?></td>
						<td><input type=text size=<?php $this->Width ?> name=<?php $this->Value ?> value='<?php $this->RowValueWidth ?>'></td>
						<td><?php $this->getH('PrintImageHref', array('save', 'Save changes', TRUE)); ?></td>
						</form>
					<?php } ?> 
					</tr>
				<?php } ?>
				<?php if(!$this->is('NewTop')) { ?>
					<?php $this->getH('PrintOpFormIntro', array('add')); ?>
					<tr>
						<td>&nbsp;</td>
						<td><input type=text size=<?php $this->ColumnWidth ?> name=<?php $this->ColumnValue ?> tabindex=100></td>
						<td class=tdleft><button class="btn btn-primary" name="submit"><span class="glyphicon glyphicon-ok"></span></button></td>
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
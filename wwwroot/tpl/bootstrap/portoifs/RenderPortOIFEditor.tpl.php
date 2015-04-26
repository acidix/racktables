<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Port OIF Editor</h3>
	</div>
	<div class="box-body">
		<table class="table table-striped">
			<thead>
				<tr><th>Origin</th><th>Key</th><th>Refcnt</th><th>&nbsp;</th><th>Outer Interface</th><th>&nbsp;</th></tr>
			</thead>
			<tbody>
				<?php if($this->is('NewTop')) : ?>
					<?php $this->getH("PrintOpFormIntro", array('add')); ?>
						<tr>
							<td><button class="btn btn-primary" style="margin-left: 13px" title="Create new" name="submit"><span class="glyphicon glyphicon-plus"></span></button></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td><input type=text size=48 name=oif_name tabindex=100></td>
							<td>&nbsp;</td>
						</tr>
					</form>
				<?php endif ?>
				<?php while($this->loop('AllOptions')) : ?>
					<tr>
						<?php if ($this->is('SmallOif')) { ?>
							<td><span class="glyphicon glyphicon-home"></span></td>
							<td><?php $this->NiftyS ?></td>
							<td><?php $this->Oif_Id ?></td>
							<td>&nbsp;</td>
							<td><?php $this->NiftyString ?></td>
							<td>&nbsp;</td>
						<?php } else { ?>
							<?php $this->UpdOpFormInto ?>
							<td><span style="color: red" class="glyphicon glyphicon-heart"></span></td>
							<td><?php $this->Oif_Id ?></td>
							<?php if ($this->is('Refcnt')) { ?>
								<td class=tdright><?php $this->Refcnt ?></td>#
								<td class=tdleft><button class="btn btn-danger btn-sm disabled"><span class="glyphicon glyphicon-minus"></span></button></td>
							<?php } else { ?>
								<td>&nbsp;</td>
								<td><?php $this->getH('GetOpLink', array(array ('op' => 'del', 'id' => $this->_Oif_Id), '<span class="glyphicon glyphicon-minus"></span>', '', 'Destroy', 'btn btn-danger btn-sm')); ?></td>
							<?php } ?>
								<td><input type=text size=48 name=oif_name value="<?php $this->NiftyString ?>"></td>
								<td><button class="btn btn-success btn-sm" title="Save changes" name="submit"><span class="glyphicon glyphicon-ok"></span></button></td>
							</form>
						<?php } ?>
					</tr>
				<?php endwhile ?>
				<?php if(!$this->is('NewTop')) : ?>
					<?php $this->getH("PrintOpFormIntro", array('add')); ?>
						<tr>
							<td><button class="btn btn-primary" style="margin-left: 13px" title="Create new" name="submit"><span class="glyphicon glyphicon-plus"></span></button></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td><input type=text size=48 name=oif_name tabindex=100></td>
							<td>&nbsp;</td>
						</tr>
					</form>
				<?php endif ?>
			</tbody>
		</table>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>

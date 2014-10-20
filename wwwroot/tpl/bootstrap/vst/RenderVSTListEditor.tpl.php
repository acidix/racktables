<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">VST List Editor</h3>
	</div>
	<div class="box-content no-padding">
		<table class="table">
			<thead>
				<tr><th>description</th><th>Actions</th></tr>
			</thead>
			<tbody>
				<?php if($this->is("AddTop", true)) { ?>
					<?php $this->getH('PrintOpFormIntro', 'add'); ?>
					<tr>
						<td><input type=text size=48 name=vst_descr tabindex=101></td>
						<td><button class="btn btn-primary" name="submit"><span class="glyphicon glyphicon-plus"></span></button></td>
					</tr>
					</form>
				<?php } ?>
				<?php while($this->Loop("VstList")) { ?>
					<?php $this->getH('PrintOpFormIntro', array('upd', array ('vst_id' => $this->_Vst_id))); ?>
					<tr>
						<td><input name=vst_descr type=text size=48 value="<?php $this->NiftyString; ?>" class="form-control"></td>
						<td>
							<div class="btn btn-group">
								<button class="btn btn-success" name="submit"><span class="glyphicon glyphicon-ok"></span></button>
								<?php if($this->is('Switchc_Set', TRUE)) { ?>
									<a href="#" class="btn btn-danger disabled"><span class="glyphicon glyphicon-remove"></span></a>
								<?php } else { ?>
									<?php $this->getH('GetOpLink', array(array ('op' => 'del', 'vst_id' => $this->_Vst_Id), '<span class="glyphicon glyphicon-remove"></span>', '', 'delete template', 'btn btn-danger')); ?>
								<?php } ?>
							</div>
						</td>
					</tr>
					</form>
				<?php } ?>
				<?php if(!$this->is("AddTop", true)) { ?>
					<?php $this->getH('PrintOpFormIntro', 'add'); ?>
					<tr>
						<td><input type=text size=48 name=vst_descr tabindex=101></td>
						<td><button class="btn btn-primary" name="submit"><span class="glyphicon glyphicon-plus"></span></button></td>
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
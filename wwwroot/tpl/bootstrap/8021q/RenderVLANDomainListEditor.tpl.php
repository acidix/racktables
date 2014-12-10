<?php if (defined("RS_TPL")) {?>
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title">VLAN domain list</h3>
	</div>
	<div class="box-body">
		<table class="table">
			<thead>
				<tr><th>&nbsp;</th><th>description</th><th>&nbsp;</th></tr>
			</thead>
			<tbody>
				<?php if ($this->is("isAddNew", true)) { ?>
					<?php $this->getH("PrintOpFormIntro", array('add')); ?>
					<tr>
						<td><input type=text size=48 name=vdom_descr tabindex=102 class="form-control"></td>
						<td><button class="btn btn-primary" style="margin-left: 13px" title="Create domain" name="submit"><span class="glyphicon glyphicon-plus"></span></button></td>
					</tr>
					</form> 
				<?php } ?>
				<?php while($this->loop("allDomainStats")) { ?>	
					<?php $this->getH('PrintOpFormIntro', array('upd', array ('vdom_id' => $this->_Id))); ?>
					<tr>
						<td style="vertical-align: middle"><input name=vdom_descr type=text size=48 value="<?php $this->NiftyStr; ?>" class="form-control"></td>
						<td>
							<div class="btn btn-group" style="box-shadow: none;">
								<button class="btn btn-success" name="submit"><span class="glyphicon glyphicon-ok"></span></button>
								<?php if($this->is('ImageNoDestroy')) { ?>
									<a href="#" class="btn btn-danger disabled"><span class="glyphicon glyphicon-remove"></span></a>
								<?php } else { ?>
									<?php $this->getH('GetOpLink', array(array ('op' => 'del', 'vdom_id' => $this->_Id), '<span class="glyphicon glyphicon-remove"></span>', '', 'Delete domain', 'btn btn-danger')); ?>
								<?php } ?>
							</div>
						</td>
					</tr></form>
				<?php } ?>
				<?php if (!$this->is("isAddNew", true)) { ?>
					<?php $this->getH("PrintOpFormIntro", array('add')); ?>
					<tr>
						<td>
							<button submit class="btn btn-primary" title="Create domain" tabindex="104"><span class="glyphicon glyphicon-plus"></span></button>
						</td>
						<td>
							<input type=text size=48 name=vdom_descr tabindex=102>
						</td>
						<td>
							<button submit class="btn btn-primary" title="Create domain" tabindex="104"><span class="glyphicon glyphicon-plus"></span></button>
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
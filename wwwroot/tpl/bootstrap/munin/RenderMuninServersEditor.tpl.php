<?php if (defined("RS_TPL")) {?>
<div class="box box-primary">
	<div class="box-body">
	<table class=table>
		<tr><th>&nbsp;</th><th>base URL</th><th>graph(s)</th><th>&nbsp;</th></tr>
		<?php if($this->is("AddTop", true)) : ?>
			<?php $this->getH("PrintOpFormIntro", array('add')); ?>
				<tr>
					<td>&nbsp;</td>
					<td><input type=text size=48 name=base_url tabindex=101></td>
					<td>&nbsp;</td>
					<td><button class="btn btn-primary" name="submit" title="Add a new server" tabindex="112"><span class="glyphicon glyphicon-plus"></span></button></td>
				</tr></form>

			<?php endif ?>

		<?php while ($this->loop("allMuninServers")) { ?>
			<tr><?php $this->FormIntro ?><td>
			<?php if (!$this->is("NumGraphs", 0)) { ?>
				<button class="btn btn-danger btn-sm disabled"><span class="glyphicon glyphicon-minus"></span></button>
			<?php } else { ?>
				<?php $this->getH('GetOpLink', array(array ('op' => 'del', 'id' => $this->get("Id", true)), '<span class="glyphicon glyphicon-minus"></span>', '', 'Delete this server', 'btn btn-danger btn-sm')); ?>
			<?php } ?> 
			</td>
			<td><input type=text size=48 name=base_url value="<?php $this->SpecialCharSrv ?>"></td>
			<td class=tdright><?php $this->NumGraphs ?></td>
			<td><button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-ok"></span></button></td></form>
			</tr>
		<?php } ?> 
		<?php if($this->is("AddTop", false)) : ?>
		<?php $this->getH("PrintOpFormIntro", array('add')); ?>
			<tr>
				<td>&nbsp;</td>
				<td><input type=text size=48 name=base_url tabindex=101></td>
				<td>&nbsp;</td>
				<td><button class="btn btn-primary" name="submit" title="add a new server" tabindex="112"><span class="glyphicon glyphicon-plus"></span></button></td>
			</tr></form>

		<?php endif ?>
	</table>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">VLAN domain list</h3>
	</div>
	<div class="box-content no-padding">
		<table class="table">
			<thead>
				<tr><th>&nbsp;</th><th>description</th><th>&nbsp;</th></tr>
			</thead>
			<tbody>
				<?php if ($this->is("isAddNew", true)) { ?>
					<?php $this->getH("PrintOpFormIntro", array('add')); ?>
					<tr>
						<td>
							<?php $this->getH("PrintImageHREF", array( 'create', 'create domain', TRUE, 104)); ?> 
						</td>
						<td>
							<input type=text size=48 name=vdom_descr tabindex=102>
						</td>
						<td>
							<?php $this->getH("PrintImageHREF", array( 'create', 'create domain', TRUE, 103)); ?>
						</td>
					</tr>
					</form> 
				<?php } ?>
				<?php while($this->loop("allDomainStats")) { ?>	
					<?php $this->formIntro ?> 
					<tr><td>
						<?php $this->imageNoDestroy ?> 	
						<?php $this->linkDestroy ?> 
					</td><td><input name=vdom_descr type=text size=48 value=<?php $this->niftyStr ?>> 
					</td><td>
						<?php $this->imageUpdate ?> 
					</td></tr></form>
				<?php } ?>
				<?php if (!$this->is("isAddNew", true)) { ?>
					<?php $this->getH("PrintOpFormIntro", array('add')); ?>
					<tr>
						<td>
							<?php $this->getH("PrintImageHREF", array( 'create', 'create domain', TRUE, 104)); ?> 
						</td>
						<td>
							<input type=text size=48 name=vdom_descr tabindex=102>
						</td>
						<td>
							<?php $this->getH("PrintImageHREF", array( 'create', 'create domain', TRUE, 103)); ?>
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
<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Port OIF Editor</h3>
	</div>
	<div class="box-content no-padding">
		<table class="table table-striped">
			<thead>
				<tr><th>Origin</th><th>Key</th><th>Refcnt</th><th>&nbsp;</th><th>Outer Interface</th><th>&nbsp;</th></tr>	
			</thead>
			<tbody>
				<?php if($this->is('NewTop')) : ?>
					<?php $this->getH("PrintOpFormIntro", array('add')); ?>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><?php $this->getH("PrintImageHref", array('create', 'create new', TRUE, 110)); ?></td>
						<td><input type=text size=48 name=oif_name tabindex=100></td>
						<td><?php $this->getH("PrintImageHref", array('create', 'create new', TRUE, 110)); ?></td>
					</tr>
					</form>
				<?php endif ?>
				<?php while($this->loop('AllOptions')) : ?>	
					<tr>
						<?php if ($this->is('SmallOif')) { ?>
							<td><?php $this->ComputerImg ?></td>
							<td><?php $this->NiftyS ?></td>
							<td><?php $this->Oif_Id ?></td>
							<td>&nbsp;</td>
							<td><?php $this->NiftyString ?></td>
							<td>&nbsp;</td>
						<?php } else { ?>
							<?php $this->UpdOpFormInto ?>
							<td><?php $this->FavImg ?></td>
							<td><?php $this->Oif_Id ?></td>
							<?php if ($this->is('Refcnt')) { ?>
								<td class=tdright><?php $this->Refcnt ?></td>#
								<td class=tdleft><?php $this->NoDestroyImg ?></td>
							<?php } else { ?>
								<td>&nbsp;</td>
								<td><?php $this->DestroyLink ?></td>
							<?php } ?> 
								<td><input type=text size=48 name=oif_name value="<?php $this->NiftyString ?>"></td>
								<td><?php $this->SaveImg ?></td>
							</form>
						<?php } ?> 
					</tr>
				<?php endwhile ?> 
				<?php if(!$this->is('NewTop')) : ?>
					<?php $this->getH("PrintOpFormIntro", array('add')); ?>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td><?php $this->getH("PrintImageHref", array('create', 'create new', TRUE, 110)); ?></td>
							<td><input type=text size=48 name=oif_name tabindex=100></td>
							<td><?php $this->getH("PrintImageHref", array('create', 'create new', TRUE, 110)); ?></td>
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
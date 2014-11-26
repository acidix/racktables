<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">WDM wideband receivers</h3>
	</div>
	<div class="box-content no-padding">
		<table class="table">
			<thead>
				<tr><th>&nbsp;</th><th>enable</th><th>disable</th></tr>
			</thead>
			<tbody>
				<?php while($this->loop('WDMPacks')) : ?> 
					<tr class=row_<?php $this->Order; ?>><td class=tdleft><?php $this->Title; ?></td><td>
						<?php $this->getH('GetOpLink', array( array ('op' => 'addPack', 'standard' => $this->_Codename), '', 'add')); ?>
					</td><td>
						<?php $this->getH('GetOpLink', array( array ('op' => 'delPack', 'standard' => $this->_Codename), '', 'delete')); ?>
					</td></tr>
				<?php endwhile ?>
			</tbody>
		</table>
	</div>
</div>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">interface by interface</h3>
	</div>
	<div class="box-content no-padding">
		<table class="table table-striped">
			<thead>
				<tr><th>&nbsp;</th><th>From Interface</th><th>To Interface</th></tr>
			</thead>
			<tbody>
				<?php if($this->is('NewTop')) : ?>
					<?php $this->getH('PrintOpFormIntro', 'add'); ?>
						<tr><th class=tdleft>
							<?php $this->getH('PrintImageHref', array('add', 'add pair', TRUE)); ?>
						</th><th class=tdleft>
							<?php $this->CreateNewType1; ?>
						</th><th class=tdleft>
							<?php $this->CreateNewType2; ?>
						</th></tr>
					</form>
				<?php endif ?>
				<?php while($this->refLoop('Interfaces')) : ?> 				
					<tr><td>
						<?php $this->getH('GetOpLink', array(array ('op' => 'del', 'type1' => $this->_Type1, 'type2' => $this->_Type2), '', 'delete', 'remove pair')); ?>
					</td><td class=tdleft><?php $this->Type1name; ?></td><td class=tdleft><?php $this->Type2name; ?></td></tr>
				<?php endwhile ?>
				<?php if(!$this->is('NewTop')) : ?>
					<?php $this->getH('PrintOpFormIntro', 'add'); ?>
					<tr><th class=tdleft>
						<?php $this->getH('PrintImageHref', array('add', 'add pair', TRUE)); ?>
					</th><th class=tdleft>
						<?php $this->CreateNewType1; ?>
					</th><th class=tdleft>
						<?php $this->CreateNewType2; ?>
					</th></tr></form>
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
<?php if (defined("RS_TPL")) {?>
<h2><?php $this->getH('NiftyString', array($this->_VstDescription, 30)) ?></h2>
<div class="row">
	<div class="col-md-6">
		<?php $this->EntitySummary ?>
		<?php $this->VstRules ?>
	</div>
	<div class="col-md-6">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">orders ( <?php echo count($this->_Switches); ?> )</h3>
			</div>
			<div class="box-content no-padding">
				<table class="table">
					<tbody>
						<?php if($this->is('EmptySwitches', true)) {?>
							<tr><td>No orders.</td></tr>
						<?php } else { ?>
						<?php while($this->loop('Order_id_array')) { ?>
							<tr><td>
								<?php $this->Render_cell; ?>
							</td></tr>
						<?php } } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
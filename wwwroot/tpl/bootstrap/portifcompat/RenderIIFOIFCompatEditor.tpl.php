<?php if (defined("RS_TPL")) {?>
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title">WDM standard by interface</h3>
	</div>
	<div class="box-body">
		<table class="table table-striped">
			<tbody>
				<?php while($this->loop("AllWDMPacks")) : ?>
					<tr><th colspan=3 style="text-align: center;"><?php $this->PackInfo ?></th></tr>
					<?php $this->IifCont ?>
				<?php endwhile ?>
			</tbody>
	</table>
	</div>
</div>

<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title">interface by interface</h3>
	</div>
	<div class="box-body">
		<?php $this->TwoColumnCompatTableEditor ?>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>

<?php if (defined("RS_TPL")) { ?>
	<div class="row">
		<div class="col-md-6">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Old allocation</h3>
				</div>
				<div class="box-body no-padding">
					<?php $this->OldAlloc; ?>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">New allocation</h3>
				</div>
				<div class="box-body no-padding">
					<?php $this->NewAlloc; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title">Rackspace allocation history</h3>
				</div>
				<div class="box-body no-padding">
					<table class=table>
						<tbody>
						<tr><th>timestamp</th><th>author</th><th>object</th><th>comment</th></tr>
						<?php $this->HistoryRows; ?>
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
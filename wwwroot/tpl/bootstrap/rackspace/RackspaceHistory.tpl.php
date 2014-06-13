<?php if (defined("RS_TPL")) {?>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
  				<div class="panel-heading"><h4>Old allocation</h4></div>
  				<div class="panel-body">
    				<?php $this->OldAlloc; ?>
 				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
  				<div class="panel-heading"><h4>New allocation</h4></div>
  				<div class="panel-body">
    				<?php $this->NewAlloc; ?>
 				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
  				<div class="panel-heading"><h4>Rackspace allocation history</h4></div>
    			<table border=0 cellpadding=5 cellspacing=0 align=center class="table table-striped">
    				<tr><th>timestamp</th><th>author</th><th>object</th><th>comment</th></tr>
					<?php $this->HistoryRows; ?>
				</table>
			</div>
		</div>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
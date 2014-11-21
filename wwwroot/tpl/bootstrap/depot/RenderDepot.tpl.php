<?php if (defined("RS_TPL")) { ?>
<div class='row'>
	<div class='col-md-12'>
		<div class="box box-primary" style="position: relative;">
			<div class="box-header">
				<h3 class="box-title">Objects</h3>
				<div class='box-tools pull-right'>
					<button class="btn btn-default" type=button style="margin: 10px;" onclick="showAddDialog();"><span class="glyphicon glyphicon-plus"></span></button>
				</div>
			</div>
			<div class="box-body">
				<table id="object_table" class="table table-bordered table-striped datatable">
					<thead>
						<tr><th>Common name</th><th>Visible label</th><th>Asset tag</th><th>Row/Rack or Container</th></tr>
					</thead>
					<tbody>
						<?php $this->startLoop("AllObjects"); ?>	
							<tr><!-- class='<?php $this->Problem ?>' -->
								<td>
									<?php $this->Mka ?> 
									<?php $this->RenderedTags ?>
								</td>
								<td>
									<?php $this->Label ?>
								</td>
								<td>
									<?php $this->Asset_no ?>
								</td>
								<td>
									<?php $this->Places ?>
								</td>
							</tr>
						<?php $this->endLoop(); ?>
					</tbody>
					<tfoot>
						<tr><th>Common name</th><th>Visible label</th><th>Asset tag</th><th>Row/Rack or Container</th></tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<div class='col-md-2'>
	</div>
</div>
<div class="row">
	<div class='col-md-12'>
		<div class="box box-primary terminal-box collapsed-box" style="position: relative;">
			<div class="box-header">
				<h3 class="box-title">Rackcode</h3>
				<div class="box-tools pull-right">
                <button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
			</div>
			<div class="box-body" style="display: none;">
				<div class="row">
					<form method=get>
				    <div class='rackcode-console col-sm-12'> 
				    	<textarea onchange="showConsoleBtns('#rackcodeconsol')" onkeyup="showConsoleBtns('#rackcodeconsole')" id='rackcodeconsole' name="cfe"></textarea>
				    </div>
				    	<input type="hidden" name="page" value="depot">
				    	<input type="hidden" name="tab" value="default">
				    	<div class='rackcode-console-btn-overlay'>
				    		<input class='rackcode-console-btn' type="submit" value="Submit" name="submit"></input>
				    		<button class='rackcode-console-btn' onclick="$('#rackcodeconsole').val('');">Reset</button>
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- DATA TABES SCRIPT -->
<script src="./js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="./js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<!-- DATA Tables CSS -->
<link href="./css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
   //  $(function() {
   //  	tagsDataTable('#object_table');
   //  });
</script>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
<?php if (defined("RS_TPL")) { ?>
<div class='row'>
	<div class='col-md-12'>
		<div class="box box-primary" style="position: relative;">
			<div class="box-header">
				<h3 class="box-title">Objects</h3>
				<div class='box-tools pull-right'>
					<?php $this->CellFilterPortlet; ?>
				</div>
			</div>
			<div class="box-body">
				<table id="object_table" class="table table-bordered table-striped">
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
		<div class="box box-primary terminal-box" style="position: relative;">
			<div class="box-header">
				<h3 class="box-title">Rackcode</h3>
				<div class="box-tools pull-right">
                <button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
			</div>
			<div class="box-body">
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
     $(function() {
     	// Add tags to autocomplete
	 	// has to be done before tags are hidden
     	
     	var taglist = [];
     	var possTags = $('#object_table > tbody > tr > td > small > a');
     	for (var i = 0; i < possTags.length; i++) {
     		// No duplicates
     		if($.inArray(possTags[i].innerHTML, taglist) === -1) taglist.push(possTags[i].innerHTML);
     	};
     	
        var datatab = $("#object_table").dataTable();
        
	 	$('#object_table_filter > label > input[type="text"]').autocomplete({
     		source: taglist,
     		select: function( event, ui ) {
     			datatab.fnFilter(ui.item.value);
     		}
     	}).keydown(function(e){
			if (e.keyCode === 13){
				$('#object_table_filter > label > input[type="text"]').trigger('submit');
			}
		});
     });
</script>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
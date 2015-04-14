<?php if (defined("RS_TPL")) {?>
<?php $this->EmptyResults; ?>
<?php if($this->is('hasResults')) { ?>
	<div class="box box-info" style="position: relative; overflow-x: auto">
		<div class="box-header">
		    <h3 class="box-title">Networks
		    	<small class="tag_small"><a style="font-size: 14px;" class="tag_small_a_inv"><?php $this->NetCount; ?></a></small>
			</h3>
			<div class="pull-right">
				<button class="btn btn-default btn-no-border" style="margin: 10px;" onclick="loadNewtab(getOwnPage() + '&tab=newrange');"><span class="glyphicon glyphicon-plus"></span></button>
				<!-- Reset filters -->
				<form method=get style="display: inline">
					<input type=hidden name=page value=<?php $this->PageNo; ?>>
					<input type=hidden name=tab value=<?php $this->TabNo; ?>>
					<input type=hidden name='cft[]' value=''>
					<input type=hidden name='cfp[]' value=''>
					<input type=hidden name='nft[]' value=''>
					<input type=hidden name='nfp[]' value=''>
					<input type=hidden name='cfe' value=''>
					<?php $this->HiddenParamsReset; ?>
					<button class="btn btn-default btn-sm btn-no-border" title="reset filter" style="margin: 10px;" onclick="resetDataTable()"><span class="glyphicon glyphicon-repeat"></span></button>
				</form>
				<button class="btn btn-default btn-no-border" style="margin: 10px;" onclick="loadNewtab(getOwnPage() + '&tab=manage', true);"><span class="glyphicon glyphicon-edit"></span></button>
			</div>
		</div>
		<div class="box-body" style="position: relative">
			<table class="table table-bordered table-striped datatable" id='ipspaceTable'>
				<thead><tr><th>prefix</th><th>name/tags</th><th>capacity</th>
				<?php if($this->is('AddRouted')) { ?>
						<th>routed by</th>
					<?php } ?>
					</tr></thead>
				<tbody>
					<?php $this->IPRecords; ?>
				</tbody>
			</table>
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
								<form method=get style="display: inline">
									<input type=hidden name=page value=<?php $this->PageNo; ?>>
									<input type=hidden name=tab value=<?php $this->TabNo; ?>>
									<input type=hidden name='cft[]' value=''>
									<input type=hidden name='cfp[]' value=''>
									<input type=hidden name='nft[]' value=''>
									<input type=hidden name='nfp[]' value=''>
									<input type=hidden name='cfe' value=''>
									<?php $this->HiddenParamsReset; ?>
									<button class='rackcode-console-btn'>Reset</button>
								</form>
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
	tagsDataTable('#ipspaceTable');
});
</script>

<?php } ?>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php } ?>

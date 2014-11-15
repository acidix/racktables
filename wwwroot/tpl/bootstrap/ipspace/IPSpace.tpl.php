<?php if (defined("RS_TPL")) {?>
<?php $this->EmptyResults; ?>
<?php if($this->is('hasResults')) { ?>
	<div class="box box-info" style="position: relative; overflow-x: auto">
		<div class="box-header">
		    <h3 class="box-title">Networks <small class="tag_small"><a style="font-size: 14px;" class="tag_small_a_inv"><?php $this->NetCount; ?></a></small></h3>
		    <small>
			<?php 	if($this->is('CollapseExpandOptions','allnone')) { ?>
				auto-collapsing at threshold <?php $this->TreeThreshold; ?> (<!-- All --><a href='<?php $this->ExpandAll; ?>'>expand&nbsp;all</a><!-- EndAll --> / 
					<!-- None --><a href='<?php $this->CollapseAll; ?>'>collapse&nbsp;all</a><!-- EndNone -->)
			<?php 	} 
			 		elseif($this->is('CollapseExpandOptions','all')) { ?>
				expanding all (<!-- Auto --><a href='<?php $this->CollapseAuto; ?>'>auto-collapse</a><!-- EndAuto --> / 
					<!-- None --><a href='<?php $this->CollapseAll; ?>'>collapse&nbsp;all</a><!-- EndNone -->)
			<?php 	} 
					elseif($this->is('CollapseExpandOptions','none')) { ?>
				collapsing all (
					<!-- All --><a href='<?php $this->ExpandAll; ?>'>expand&nbsp;all</a><!-- EndAll --> / 
					<!-- Auto --><a href='<?php $this->CollapseAuto; ?>'>auto-collapse</a><!-- EndAuto -->)
			<?php 	} else { ?>
				expanding <?php $this->ExpandIP; ?>/<?php $this->ExpandMask; ?> (<!-- Auto --><a href='<?php $this->CollapseAuto; ?>'>auto-collapse</a><!-- EndAuto --> / 
					<!-- All --><a href='<?php $this->ExpandAll; ?>'>expand&nbsp;all</a><!-- EndAll --> / 
					<!-- None --><a href='<?php $this->CollapseAll; ?>'>collapse&nbsp;all</a><!-- EndNone -->)
			<?php }	 ?>
			</small>
			<div class="pull-right"><button class="btn btn-default" type=button style="margin: 10px;" onclick="showAddDialog();"><span class="glyphicon glyphicon-plus"></span></button>
			<button class="btn btn-default" type=button style="margin: 10px;" onclick="showRemoveDialog();"><span class="glyphicon glyphicon-minus"></span></button></div>
		</div>
		<div class="box-body" style="position: relative">
			<table class="table table-bordered table-striped" id="ipspaceTable">
				<thead><tr><th>prefix</th><th>name/tags</th><th>capacity</th>
				<?php if($this->is('AddRouted')) { ?>
						<th>routed by</th>
					<?php } ?>
					</tr></thead>
				<tbody>
					<?php $this->IPRecords; ?>
				</tbody>
			</table>
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
<?php } ?>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php } ?>
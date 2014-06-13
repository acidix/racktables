<?php if (defined("RS_TPL")) { ?>
<div class="row">
	<div class="col-md-12">
	<!-- Button trigger modal -->
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#cellFilterModal">
  Filter
</button>
	<div class="panel panel-primary">
		<div class="panel-heading">Objects</div>
		<table class="table table-striped">
			<tr><th>Common name</th><th>Visible label</th><th>Asset tag</th><th>Row/Rack or Container</th></tr>
			<?php if($this->is("NoObjects")) { ?>
				<tr class="warning"><td colspan="4">No objects exist</td></tr>
			<?php } else { ?>
				<?php $this->startLoop("allObjects"); ?>	
						<tr class='row_<?php $this->order ?> tdleft' valign=top><td> <?php $this->mka ?> 
						<?php $this->RenderedTags ?>
						</td><td> <?php $this->label ?> </td>
						<td><?php $this->asset_no ?> </td>
						<td> <?php $this->places ?> </td>
						</tr>
				<?php $this->endLoop(); ?> 
			<?php } ?>
		</table>
	</div>
	</div>
</div>	
	

<!-- Modal -->
<div class="modal fade" id="cellFilterModal" tabindex="-1" role="dialog" aria-labelledby="cellFilterLabel" aria-hidden="true">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h4 class="modal-title" id="cellFilterLabel">Tag filters</h4>
      		</div>
      		<div class="modal-body">
      			<?php $this->CellFilterPortlet; ?>
      		</div>
    	</div>
  	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
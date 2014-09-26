<?php if (defined("RS_TPL")) {?>
	<div class="row">
		<div class="col-md-6">
			<?php 
				$this->EntitySummary;
				$this->FilesPortlet;
      			$this->LocComment;
			?>
		</div>
		<div class="col-md-6">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">
						Rows (<?php $this->CountRows; ?>)
					</h3>
				</div>
				<div class="box-content no-padding">
					<table class="table table-striped">
						<tbody>
							<?php while($this->loop('Rows')) { ?>
								<tr>
									<td align="center">
										<?php $this->Link; ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">
						Child Locations (<?php $this->CountLocation; ?>)
					</h3>
				</div>
				<div class="box-content no-padding">
					<table class="table table-striped">
						<tbody>
							<?php while($this->loop('Looparray2')) { ?>
								<tr>
									<td align="center">
										<?php $this->LcationLink; ?>
									</td>
								</tr>
							<?php } ?>
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
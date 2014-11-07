<?php if (defined("RS_TPL")) {?>
	<div class="box box-info" style="position: relative; overflow-x: auto">
		<div class="box-header"><h3 class="box-title"><?php $this->IP; ?>/<?php $this->Mask; ?> <strong><?php $this->Name; ?></strong></h3></div>
		<div class="box-body" style="position: relative">
			<div class="row">
				<div class="col-md-6">
					<?php $this->Summary; ?>
					<?php if($this->is('Comment')) { ?>
					<div class=portlet>
						<h2>Comment</h2>
						<div class=commentblock><?php $this->Comment ?></div>
					</div>
					<?php } ?>
					<?php $this->Files; ?>
				</div>
			<div class="col-md-6">
				<div class="box">
					<div class="box-header"><h3 class="box-title">details</h3></div>
	 				<div class="box-body">
						<?php $this->AddressList; ?>
					</div>
					</div>
				</div>
			</div>
		</div> <!-- box body --> 
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
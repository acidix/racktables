<?php if (defined("RS_TPL")) {?>
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Log records for this object (<a href=?page=objectlog>complete list</a>)</h3>
		</div>
		<div class="box-body no-padding">
					<?php $this->getH('PrintOpFormIntro', array('add')); ?>
						<div class="row edit_row" align="center"><textarea name=logentry rows=10 cols=80 tabindex=100></textarea></div>
						<div class="row edit_row" align="center"><button class="btn btn-large btn-success"><span class="glyphicon glyphicon-ok"></span></button></div>
					</form>
				<table class="table table-bordered table-striped" align='center'>
					<tbody>
						<?php $this->Rows; ?>
					</tbody>
				</table>
		</div>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
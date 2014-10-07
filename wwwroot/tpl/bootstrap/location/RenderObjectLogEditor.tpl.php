<?php if (defined("RS_TPL")) {?>
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Log records for this object (<a href=?page=objectlog>complete list</a>)</h3>
		</div>
		<div class="box-body no-padding">
			<tbody>
				<tr>
					<?php $this->getH('PrintOpFormIntro', array('add')); ?>
						<td></td>
						<td><textarea name=logentry rows=10 cols=80 tabindex=100></textarea></td>
						<td><button class="btn btn-danger"><span class="glyphicon glyphicon-ok"></span></button></td>
					</form>
				</tr>
				<?php $this->Rows; ?>
			</tbody>
		</div>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
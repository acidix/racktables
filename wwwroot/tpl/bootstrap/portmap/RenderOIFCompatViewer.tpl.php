<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
	</div>
	<div class="box-content no-padding">
		<table class="table table-striped">
			<thead>
				<tr><th>From interface</th><th>To interface</th></tr>
			</thead>
			<tbody>
				<?php $this->startLoop('AllPortCompat'); ?>
					<tr> <td><?php $this->Type1; ?></td><td><?php $this->Type2; ?></td></tr>
				<?php $this->endLoop(); ?>
			</tbody>
		</table>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
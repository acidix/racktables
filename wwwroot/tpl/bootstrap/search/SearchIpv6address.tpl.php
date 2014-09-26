<?php if (defined("RS_TPL")) {?>
<div class="box" style="margin-top: 20px">
	<div class="box-header"><h3 align="center"><?php $this->sectionHeader ?></h3></div>
	<div class="box-body box-body table-responsive no-padding">
		<table border=0 cellpadding=5 cellspacing=0 align=center class="table table-hover">
			<tr><th>Address</th><th>Description</th></tr>
			<?php $this->AllSearchAddrs ?>
		</table>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
<?php if (defined("RS_TPL")) {?>
<div class="box box-primary">
	<div class="box-body">
	<table class="table table-striped">
	<thead>
		<tr><th>Parent</th><th>Child</th></tr>
	</thead>
	<tbody>
	<?php while( $this->Loop('Looparray') ) { ?>
		<tr><td><?php $this->Parentname; ?></td><td><?php $this->Childname; ?></td></tr>
	<?php } ?>
	</tbody>
	</table>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
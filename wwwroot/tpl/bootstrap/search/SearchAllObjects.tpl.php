<?php if (defined("RS_TPL")) {?>
<div class="box box-solid box-primary" style="margin-top: 20px">
	<div class="box-header"><h3 class='box-title'><a href='index.php?page=depot'>Objects</a></h3>
		<div class="box-tools pull-right" >
	        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
	        <button class="btn btn-primary btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
	    </div>
    </div>
	<div class="box-body box-body table-responsive no-padding">
		<table border=0 cellpadding=5 cellspacing=0 align=center class="table table-hover">
			<tr><th>What was found</th><th>Why</th></tr>
			<?php $this->foundObject ?>
		</table>
	</div>
</div>

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
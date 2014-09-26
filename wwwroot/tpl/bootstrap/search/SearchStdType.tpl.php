<?php if (defined("RS_TPL")) {?>
<div class="box" style="margin-top: 20px">
	<div class="box-header"><h3 align="center"><a href='index.php?page=<?php $this->page ?>'><?php $this->title ?></a></h3></div>
	<div class="box-body box-body table-responsive no-padding">
		<table border=0 cellpadding=5 cellspacing=0 align=center class="table table-hover">
		<?php $this->startLoop("searchLoopObjs"); ?>
			<tr class=row_<?php $this->rowOrder ?>><td class=tdleft>
			<?php $this->renderedCell ?>
			</td></tr>
		<?php $this->endLoop(); ?>
		</table>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
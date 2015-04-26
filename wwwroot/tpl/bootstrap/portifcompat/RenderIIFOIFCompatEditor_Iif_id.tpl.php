<?php if (defined("RS_TPL")) {?>
	<tr ><th><?php $this->iif_iif_id ?></th><td>
		<a href="?module=redirect&amp;op=addPack&amp;standard=<?php  $this->codename ?>&amp;iif_id=<?php  $this->iif_id ?>&amp;page=portifcompat&amp;tab=edit"  title="add">
		<i class="fa fa-fw fa-plus"></i> </a>
	</td><td>
		<a href="?module=redirect&amp;op=delPack&amp;standard=<?php  $this->codename ?>&amp;iif_id=<?php  $this->iif_id ?>&amp;page=portifcompat&amp;tab=edit"  title="delete">
		<i class="fa fa-fw fa-minus"></i></a>
	</td></tr>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>

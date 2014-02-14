<?php if (defined("RS_TPL")) {?>
	<div class=portlet>
		<h2> Manage RS list (<?php $this->poolinfoRSCount ?> )</h2>
		<?php $this->renderedRSList ?> 
	</div>
	<?php $this->renderedAddManyPortlet ?> 
	
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
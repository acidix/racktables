<?php if (defined("RS_TPL")) {?>
	
	<ul class="nav nav-tabs">
		<!-- <ul id=foldertab style='margin-bottom: 0px; padding-top: 10px;'> -->
			<?php $this->Tabs; ?>
		<!-- </ul> -->
	</ul>

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
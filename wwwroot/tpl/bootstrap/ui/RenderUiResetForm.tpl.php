<?php if (defined("RS_TPL")) {?>
	<?php $this->getH("PrintOpFormIntro", array('go')); ?> 
	This button will reset user interface configuration to its defaults (except organization name): 
	<button type=submit class="btn btn-large btn-block btn-danger">Reset</button>
	</form>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
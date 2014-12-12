<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-body" align="center">
	<?php $this->getH("PrintOpFormIntro", array('go')); ?> 
	<strong>This button will reset user interface configuration to its defaults (except organization name):</strong><br>

	<button style="max-width: 200px; margin-top: 100px" type=submit class="btn btn-large btn-block btn-danger">Reset</button>
	</form>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
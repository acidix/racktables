<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Replace existing contents</h3>
	</div>
	<div class="box-content">
		<?php $this->getH('PrintOpFormIntro',array('replaceFile', array (), TRUE)); ?>
		<input type=file size=10 name=file tabindex=100>&nbsp;
		<button name="submit" class="btn btn-large btn-primary"><span class="glyphicon glyphicon-cloud-upload"></span></button>
		</form>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
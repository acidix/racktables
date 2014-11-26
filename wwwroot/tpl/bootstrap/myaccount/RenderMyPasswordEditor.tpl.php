<?php if (defined("RS_TPL")) {?>
<div class="box box-info" style="position: relative; overflow-x: auto">
	<div class="box-header"></div>
    <div class="box-body" style="position: relative">
	<?php $this->getH('PrintOpFormIntro', 'changeMyPassword'); ?>
	
	<div class="row edit_row"><div class="col-sm-6">Current password (*):</div><div class="col-sm-6"><input type=password name=oldpassword tabindex=1></div></div>
	<div class="row edit_row"><div class="col-sm-6">New password (*):</div><div class="col-sm-6"><input type=password name=newpassword1 tabindex=2></div></div>
	<div class="row edit_row"><div class="col-sm-6">New password again (*):</div><div class="col-sm-6"><input type=password name=newpassword2 tabindex=3></div></div>
	<div class="row" align="center">
		<button type="submit" class="btn btn-success btn-sm ajax_form" targetform="#changeMyPassword" border="0" tabindex="4" title="Change">Change</button>
	</div>
	</form>
	</div>
</div>

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
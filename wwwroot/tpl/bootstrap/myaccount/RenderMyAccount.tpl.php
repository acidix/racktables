<?php if (defined("RS_TPL")) {?>
<div class="box box-info" style="position: relative; overflow-x: auto">
	<div class="box-header">
        <h3 class="box-title">Current user info</h3>
    </div>
    <div class="box-body" style="position: relative">
	<div class="row edit_row"><div class="col-sm-6 header">Login:</div><div class="col-sm-6"><?php $this->UserName; ?></div></div>
	<div class="row edit_row"><div class="col-sm-6 header">Name:</div><div class="col-sm-6"><?php $this->DisplayName; ?></div></div>
	<div class="row edit_row"><div class="col-sm-6 header">Explicit tags:</div><div class="col-sm-6"><?php $this->getH("SerializeTags", array( $this->_Serialize1)); ?></div></div>
	<div class="row edit_row"><div class="col-sm-6 header">Implicit tags:</div><div class="col-sm-6"><?php $this->getH("SerializeTags", array( $this->_Serialize2)); ?></div></div>
	<div class="row edit_row"><div class="col-sm-6 header">Automatic tags:</div><div class="col-sm-6"><?php $this->getH("SerializeTags", array( $this->_Serialize3)); ?></div></div>
	</div>
</div>

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
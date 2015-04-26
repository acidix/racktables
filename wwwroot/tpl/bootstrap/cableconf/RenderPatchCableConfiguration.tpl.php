<?php if (defined("RS_TPL")) {?>
<div class="row">
<div class="col-md-6">
<div class="box">
	<div class="box-header">
		<h2  class="box-title">Connectors</h2>
	</div>
	<div class="box-body">
	<?php $this->ConnectorViewer ?>
	</div>
</div></div>

<div class="col-md-6">
<div class="box">
	<div class="box-header">
		<h2 class="box-title">Connector compatibility</h2>
	</div>
	<div class="box-body">
		<?php $this->CompViewr ?>
	</div>
</div></div>
</div>

<div class="row">
<div class="col-md-6">
<div class="box">
	<div class="box-header">
		<h2  class="box-title">Cable types</h2>
	</div>
	<div class="box-body">
		<?php $this->TypeViewer ?>
	</div>
</div>
</div>

<div class="col-md-6">
<div class="box">
	<div class="box-header">
		<h2  class="box-title">Cable types and port outer interfaces</h2>
	</div>
	<div class="box-body">
		<?php $this->InterfacesViewer ?>
	</div>
</div>
</div>
</div>

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>

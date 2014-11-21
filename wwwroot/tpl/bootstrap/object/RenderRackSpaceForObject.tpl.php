<?php if (defined("RS_TPL")) {?>
<div class="box box-info" style="position: relative; overflow-x: auto">
	<div class="box-body" style="position: relative">
	<div class="row">
		<div class="col-md-4">
		<div class="box" style="position: relative; overflow-x: auto">
			<div class="box-header"><h3 class="box-title">Racks</h3></div>
			<div class="box-body" style="position: relative" align="center">			
				<?php if ($this->is("isShowAllAndMatching", true)) { ?>
					<p>(filtered by <span class='filter-text'><?php $this->filter_text ?></span>, <a href='<?php $this->href_show_all ?>'>show all</a>)</p>
				<?php } ?> 
				<?php $this->getH("PrintOpFormIntro", array('updateObjectAllocation')); ?>
				<?php $this->RackMultiSet ?>
				<br><br>
			</div>
		</div>
		</div>
		<div class="col-md-4">
		<div class="box" style="position: relative; overflow-x: auto">
			<div class="box-header"><h3 class="box-title">Comment (for Rackspace History)</h3></div>
			<div class="box-body" style="position: relative;" align="center">
				<textarea name=comment rows=10 cols=40></textarea><br><br>
				<button type=submit class="btn btn-large btn-success" name="got_atoms">Save</button>
				<br><br>
			</div>
		</div>
		</div>
		<div class="col-md-4">
		<div class="box" style="position: relative; overflow-x: auto">
			<div class="box-header"><h3 class="box-title">Working copy</h3></div>
			<div class="box-body" style="position: relative" align="center">
				<?php $this->jquery_code ?>
				<?php $this->addRequirement("Header","HeaderJsInclude",array("path"=>"js/racktables.js")); ?>
				<?php $this->addRequirement("Header","HeaderJsInclude",array("path"=>"js/bulkselector.js")); ?>
				<table border=0 cellspacing=10 align=center><tr>
				<?php $this->startLoop("allWorkingData"); ?>	
					<td valign=top>
					<center>
					<h2><?php $this->name ?></h2>
					<table class="rack table-bordered" id=selectableRack border=0 cellspacing=0 cellpadding=1>
					<tr><th width='10%'>&nbsp;</th>
					<th width='20%'><a href='javascript:;' onclick=\"toggleColumnOfAtoms('<?php $this->rack_id ?>', '0', <?php $this->height ?>)\">Front</a></th>
					<th width='50%'><a href='javascript:;' onclick=\"toggleColumnOfAtoms('<?php $this->rack_id ?>', '1', <?php $this->height ?>)\">Interior</a></th>
					<th width='20%'><a href='javascript:;' onclick=\"toggleColumnOfAtoms('<?php $this->rack_id ?>', '2', <?php $this->height ?>)\">Back</a></th></tr>
					<?php $this->AtomGrid ?>
					<tr><th width='10%'>&nbsp;</th>
					<th width='20%'><a href='javascript:;' onclick=\"toggleColumnOfAtoms('<?php $this->rack_id ?>', '0', <?php $this->height ?>)\">Front</a></th>
					<th width='50%'><a href='javascript:;' onclick=\"toggleColumnOfAtoms('<?php $this->rack_id ?>', '1', <?php $this->height ?>)\">Interior</a></th>
					<th width='20%'><a href='javascript:;' onclick=\"toggleColumnOfAtoms('<?php $this->rack_id ?>', '2', <?php $this->height ?>)\">Back</a></th></tr>
					</table>
					<br>
					<label for=zerou_<?php $this->rack_id ?>>Zero-U:</label> <input type=checkbox <?php $this->checked ?> name=zerou_<?php $this->rack_id ?> id=zerou_<?php $this->rack_id ?>>
					<br><br>
					<input type='button' onclick='uncheckAll();' value='Uncheck all'>
					</center></td>
				<?php $this->endLoop(); ?> 
				</tr></table>
			</div>
		</div>
		</div>
	</div>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
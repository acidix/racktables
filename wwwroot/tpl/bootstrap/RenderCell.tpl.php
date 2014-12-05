<?php if (defined("RS_TPL")) {?>

	<?php if ($this->is("typeUser",true)) { ?>
		<div class='slbcell vscell' align="center">
		<div class='row'>
			<div class='col-sm-6'><span style="font-size: 20px" class='glyphicon glyphicon glyphicon-user'></span></div>
			<div class='col-sm-6 pull-right'><?php $this->get("UserRef") ?></div>
		</div>
		<div class='row'>
		<?php if ($this->is("hasUserRealname",true)) { ?>
			<div class="col-sm-6 pull-left"><strong><?php $this->get("userRealname") ?></strong></div>
		<?php } else { ?>
			<div class="col-sm-6 pull-left">no name</div>
		<?php }?> 
		<div class="col-sm-6">
			<?php $this->get('UserTags') ?>
		</div></div>
	<?php } ?>

	<?php if ($this->is("typeFile",true)) { ?>
		<div class='slbcell vscell'>
			<div class="row"><div class="col-sm-4 header">
				<?php $this->get("fileImgSpace"); ?>
				</div><div class="col-sm-4 pull-right">
				<?php $this->get("nameAndID") ?>
				</div><div class="col-sm-4 pull-right">
				<small><?php $this->get("serializedLinks"); ?></small>
			</div></div><div class="row"><div class="col-sm-4 header">
				<?php $this->get("fileCount") ?>
				</div><div class="col-sm-4 pull-right">
				<?php if ($this->is("isolatedPerm",true)) { ?>
					<a href='?module=download&file_id=<?php $this->get("cellID") ?>'>
					<span style="font-size: 20px" class='glyphicon glyphicon-cloud-download'></span>
					</a>&nbsp;
				<?php } ?><?php $this->fileSize ?>
		</div></div></div>
	<?php } ?>

	<?php if ($this->is("typeIPV4RSPool",true)) { ?>
		<?php $this->get("ipv4ImgSpace"); ?>
	<?php } ?>

	<?php if ($this->is("typeIPNet",true)) { ?>
		<table class='slbcell vscell'><tr><td>
		<div class="pull-left" style=""><strong class='glyphicon glyphicon glyphicon-globe'></strong></div>
		</td><td><?php $this->get("mkACell"); ?><?php $this->get("renderdIPNetCap"); ?></td></tr>
		<tr><td>
		<?php if($this->is("cellName",true)) { ?>
			<strong><?php $this->get("niftyCellName"); ?></strong>
		<?php }else{ ?>
			<span class=sparenetwork>no name</span>
		<?php } ?>

		<?php $this->get("renderedVLan") ?>
		</td></tr>
		<tr><td>
		<?php $this->get("etags") ?>
		</td></tr></table>
	<?php } ?>

	<?php if ($this->is("typeRack",true)) { ?>
		<table class='slbcell vscell'><tr><td>
		<img border=0 width=<?php $this->thumbWidth ?> 
					height=<?php $this->thumbHeight ?> title='<?php $this->cellHeight ?> units' 
			src='?module=image&img=minirack&rack_id=<?php $this->get("cellID")?>'>
		</td><td>
		<?php $this->get("mkACell") ?> 
		</td></tr><tr><td>
		<?php $this->get("cellComment") ?> 
		</td></tr><tr><td>
		<?php $this->get("etags") ?> 
		</td></tr></table>
	<?php } ?>
	
	<?php if ($this->is("typeLocation",true)) { ?>	
		<table class='slbcell vscell'><tr><td>
		<div class="pull-left"><?php $this->getH("PrintImageHref","LOCATION") ?> </div>
		</td><td>
		<?php $this->mkACell ?> 
		</td></tr><tr><td>
		<?php $this->get("cellComment") ?> 
		</td></tr><tr><td>
		<?php $this->get("etags") ?> 
		</td></tr></table>
	<?php } ?>

	<?php if ($this->is("typeObject",true)) { ?>	
		<table class='slbcell vscell'><tr><td>
		<?php $this->getH("PrintImageHref","OBJECT") ?> 
		</td><td>
		<?php $this->get("mkACell") ?> 
		</td></tr><tr><td>
		<?php $this->get("etags") ?> 
		</td></tr></table>
	<?php } ?>

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php } ?>
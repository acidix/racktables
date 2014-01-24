<?php if (defined("RS_TPL")) {?>

	<?php $this->get("userImgSpace"); ?>
	<?php if ($this->is("typeUser",true)) { ?>
		<table class='slbcell vscell'><tr><td rowspan=3 width='5%'>
		</td><td> <?php $this->get("UserRef") ?> </td></tr>
				
		<?php if ($this->is("hasUserRealname",true)) { ?>
			<tr><td><strong><?php $this->get("userRealname") ?></strong></td></tr>
		<?php } else { ?>
			<tr><td class=sparenetwork>no name</td></tr>
		<?php }?>
		<td>

		</td></tr></table>
		
		<?php $this->get('userTags') ?>
	<?php } ?>

	<?php if ($this->is("typeFile",true)) { ?>
		<table class='slbcell vscell'><tr><td rowspan=3 width='5%'>
		<?php $this->get("fileImgSpace"); ?>
		</td><td>
		<?php $this->get("nameAndID") ?>
		</td><td rowspan=3 valign=top>
		<small> <?php $this->get("serializedLinks"); ?></small>
		</td></tr><tr><td>
		<?php $this->get("fileCount") ?>
		</td></tr><tr><td>
		<?php if ($this->is("isolatedPerm",true)) { ?>
			<a href='?module=download&file_id=<?php $this->get("cellID") ?>'>
			<?php $this->get("isoPermImg") ?>
			</a>&nbsp;
		<?php } ?>

	<?php } ?>

	<?php if ($this->is("typeIPV4",true)) { ?>
		<?php $this->get("ipv4ImgSpace"); ?>
	<?php } ?>

	<?php if ($this->is("typeIPV6",true)) { ?>
		<table class='slbcell vscell'><tr><td rowspan=3 width='5%'>
		<?php  $this->getH("PrintImageHref", "NET");?>
		</td><td> <?php $this->get("mkACell"); ?>
		<?php $this->get("renderdIPNetCap"); ?> </td></tr>
		<tr><td>

		<?php if($this->is("cellName",true)) { ?>
			<strong> <?php $this->get("niftyCellName"); ?> </strong>

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
		<table class='slbcell vscell'><tr><td rowspan=3 width='5%'>
		<img border=0 width=<?php $this->get("thumbWidth") ?> 
					height=<?php $this->get("thumbHeight") ?> title='<?php $this->get("cellHeight") ?> units' 
			src='?module=image&img=minirack&rack_id=<?php $this->get("cellID")?>'>
		</td><td>
		<?php $this->getH("MkA", array( 
			'<strong>' . niftyString ($this->get("cellName")) . '</strong>',
			'rack',
			$this->get("cellID")
		  )); ?>
		</td></tr><tr><td>
		<?php $this->get("cellComment") ?> 
		</td></tr><tr><td>
		<?php $this->get("etags") ?> 
		</td></tr></table>
	<?php } ?>
	
	<?php if ($this->is("typeLocation",true)) { ?>	
		<table class='slbcell vscell'><tr><td rowspan=3 width='5%'>
		<?php $this->get("imgLocation") ?> 
		</td><td>
		<?php $this->getH("MkA", array( 
			'<strong>' . niftyString ($this->get("cellName")) . '</strong>',
			'rack',
			$this->get("cellID")
		  )); ?>
		</td></tr><tr><td>
		<?php $this->get("cellComment") ?> 
		</td></tr><tr><td>
		<?php $this->get("etags") ?> 
		</td></tr></table>
	<?php } ?>

	<?php if ($this->is("typeObject",true)) { ?>	
		<table class='slbcell vscell'><tr><td rowspan=2 width='5%'>
		<?php $this->get("imgObject") ?> 
		</td><td>
		<?php $this->getH("MkA", array( 
			'<strong>' . niftyString ($this->get("cellDName")) . '</strong>',
			'rack',
			$this->get("cellID")
		  )); ?>
		</td></tr><tr><td>
		<?php $this->get("etags") ?> 
		</td></tr></table>
	<?php } ?>

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php } ?>
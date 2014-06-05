<?php if (defined("RS_TPL")) {?>
	<?php 	$this->addRequirement("Header","HeaderJsInclude",array("path"=>"js/tag-cb.js"));
		 	$this->addRequirement("Header","HeaderJsInline",array("code"=>"tag_cb.enableNegation()")); 
		 	if ($this->is('EnableSubmitOnClick')) { 
				$this->addRequirement("Header","HeaderJsInline",array("code"=>"tag_cb.enableSubmitOnClick()"));
			}  ?>
	<div class="panel panel-default collapse" id="CellFilter">
		<div class="panel-heading" data-toggle="collapse" data-target="#CellFilterContent"><h4 class="panel-title">Tag filters</h4></div>
		<form method=get>
		<div class="panel-content" id="CellFilterContent">
			<table border=0 align=center cellspacing=0>
				<?php $this->TableContent; ?>
			</table>
		</div>
		<div class="panel-footer">
			<input type=hidden name=page value=<?php $this->PageNo; ?>>
			<input type=hidden name=tab value=<?php $this->TabNo; ?>>
			<?php $this->HiddenParams; ?>
			<?php if ($this->is("EnableApply",true)) { ?>
				<button type="submit" class="btn btn-primary btn-block" name="submit">Set filter</button>
			<?php } ?>
			<?php if ($this->is("EnableApply",false)) { ?>
				<button class="btn btn-primary btn-block" disabled="disabled">Set filter</button>
			<?php }?><br />
			<?php $this->Textify; ?>
			<?php if ($this->is("EnableReset",false)) { ?>
				<button class="btn btn-default btn-block" disabled="disabled">Reset filter</button>
			<?php } ?>
			<?php if ($this->is("EnableReset",true)) { ?>
				<form method=get>
					<input type=hidden name=page value=<?php $this->PageNo; ?>>
					<input type=hidden name=tab value=<?php $this->TabNo; ?>>
					<input type=hidden name='cft[]' value=''>
					<input type=hidden name='cfp[]' value=''>
					<input type=hidden name='nft[]' value=''>
					<input type=hidden name='nfp[]' value=''>
					<input type=hidden name='cfe' value=''>
					<?php $this->HiddenParamsReset; ?>
					<button type="submit" class="btn btn-default btn-block" name="submit">Reset filter</button>
				</form>
			<?php } ?>
			</div>
		</form>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php } ?>
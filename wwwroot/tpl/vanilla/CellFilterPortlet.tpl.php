<?php if (defined("RS_TPL")) {?>
	<?php 	$this->addRequirement("Header","HeaderJsInclude","",true,array("path"=>"tpl/vanilla/js/tag-cb.js"));
			$this->addRequirement("Header","HeaderJsInline","",true,array("code"=>"tag_cb.enableNegation()")); ?>
	<div class=portlet><h2><?php $this->get("PortletTitle"); ?></h2>
		<table border=0 align=center cellspacing=0 class="tagtree">
			<form method=get>
				<?php $this->TableContent; ?>
				<tr>
					<td class="tdleft">
						<input type=hidden name=page value=<?php $this->PageNo; ?>>
						<input type=hidden name=tab value=<?php $this->TabNo; ?>>
						<?php  $this->HiddenParams; ?>
						<?php  $this->if(); ?>
							<input class="icon" type="image" border="0" title="set filter" src="?module=chrome&uri=pix/pgadmin3-viewfiltereddata.png" name="submit"></input>
						<?php $this->endIf("EnableApply",true); ?>
						<?php  $this->if(); ?>
							<img src="pix/pgadmin3-viewfiltereddata-grayscale.png" width=32 height=32 border=0>
						<?php $this->endIf("EnableApply",false); ?>
						<?php $this->Textify; ?>
					</td>
					<td class=tdright>
						<?php $this->if(); ?>
							<img src="pix/pix/pgadmin3-viewdata-grayscale.png" width=32 height=32 border=0>
						<?php $this->endIf("EnableReset",false); ?>
						<?php $this->if(); ?>
							<form method=get>
								<input type=hidden name=page value=<?php $this->PageNo; ?>>
								<input type=hidden name=tab value=<?php $this->TabNo; ?>>
								<input type=hidden name='cft[]' value=''>
								<input type=hidden name='cfp[]' value=''>
								<input type=hidden name='nft[]' value=''>
								<input type=hidden name='nfp[]' value=''>
								<input type=hidden name='cfe' value=''>
								<?php $this->HiddenParamsReset; ?>
								<input class="icon" type="image" border="0" title="reset filter" src="?module=chrome&uri=pix/pgadmin3-viewdata.png" name="submit"></input>
							</form>
						<?php $this->endIf("EnableReset",true); ?>
					</td>
				</tr>
			</form>
		</table>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php } ?>
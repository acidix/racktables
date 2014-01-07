<?php if (defined("RS_TPL")) {?>
	<?php 	$this->addRequirement("Header","HeaderJsInclude","",true,array("path"=>"tpl/vanilla/js/tag-cb.js"));
			$this->addRequirement("Header","HeaderJsInline","",true,array("code"=>"tag_cb.enableNegation()")); ?>
	<div class=portlet><h2><?php $this->get("PortletTitle"); ?></h2>
		<form method=get>
			<table border=0 align=center cellspacing=0 class="tagtree">
				<?php $this->TableContent; ?>
				<tr>
					<td class="tdleft">
						<input type=hidden name=page value=<?php $this->PageNo; ?>>
						<input type=hidden name=tab value=<?php $this->TabNo; ?>>
						<?php  $this->HiddenParams; ?>
						
			</table>
		</form>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php } ?>
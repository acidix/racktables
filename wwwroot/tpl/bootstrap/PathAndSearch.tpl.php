<?php if (defined("RS_TPL")) {?>
	<ol class='breadcrumb' style='float:right'>


		<form name=search method=get>
			<input type=hidden name=page value=search>
			<input type=hidden name=last_page value=<?php $this->PageNo; ?>>
			<input type=hidden name=last_tab value=<?php $this->TabNo; ?>>
			<label>Search:
				<input type=text name=q size=20 tabindex=1000 value='<?php $this->SearchValue; ?>'>
			</label>
		</form>

	</ol>
	<ol class='breadcrumb'>
		<?php $this->Path; ?>
	</ol>
	
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
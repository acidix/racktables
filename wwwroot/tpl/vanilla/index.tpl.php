<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<!-- Template taken from: interface.php:94 -->
<head><title><?php $this->get("page_title"); //echo getTitle ($pageno); ?></title>
	<?php $this->get("Header"); //printPageHeaders(); ?>
</head>
<body>
	<div class="maintable">
 		<div class="mainheader">
  			<div style="float: right" class=greeting><a href='index.php?page=myaccount&tab=default'><?php global $remote_displayname; echo $remote_displayname ?></a> [ <a href='?logout'>logout</a> ]</div>
 			<?php $this->get("Enterprise"); //echo getConfigVar ('enterprise') ?> RackTables <a href="http://racktables.org" title="Visit RackTables site"><?php echo CODE_VERSION ?></a><?php renderQuickLinks() ?>
 		</div>
 	<div class="menubar">
 		<div class='searchbox' style='float:right'>
			<form name=search method=get>
				<input type=hidden name=page value=search>
				<input type=hidden name=last_page value=<?php $this->PageNo; ?>>
				<input type=hidden name=last_tab value=<?php $this->TabNo; ?>>
				<label>Search:
					<input type=text name=q size=20 tabindex=1000 value='<?php $this->SearchValue; ?>'>
				</label>
			</form>
		</div>
		<?php $this->Path; ?>
	</div>
 	<div class="tabbar">
 		<div class=greynavbar>
			<ul id=foldertab style='margin-bottom: 0px; padding-top: 10px;'>
				<?php $this->Tabs; ?>
			</ul>
		</div>
	</div>
 	<div class="msgbar"><?php $this->get("Message"); //showMessageOrError(); ?></div>
 	<div class="pagebar"><?php $this->get("Payload"); //echo $payload; ?></div>
</div>
</body>
</html>
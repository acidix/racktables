<?php 
	$this->map(array('Path',0),':','');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<!-- Template taken from: interface.php:94 -->
<head><title><?php $this->PageTitle ; //echo getTitle ($pageno); ?></title>
	<script type="text/JavaScript" src="js/jquery-1.4.4.min.js"></script>
	<link rel="stylesheet" type="text/css" href="tpl/bootstrap/css/bootstrap.min.css">
	<script type="text/JavaScript" src="tpl/bootstrap/css/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="tpl/bootstrap/css/template.css">
	<?php $this->Header ; //printPageHeaders(); ?>
</head>
<body>

	<div class="maintable">
		<div class="container">
	 		<div class="row">
	 			<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	  				<div class="container-fluid">
			  			<div class="navbar-header">
					      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navbar-collapse">
					        <span class="sr-only">Toggle navigation</span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					      </button>
					      <a class="navbar-brand" href="index.php"><?php $this->Enterprise; //echo getConfigVar ('enterprise') ?></a>
					    </div>
					<!-- Collect the nav links, forms, and other content for toggling -->
					    <div class="collapse navbar-collapse" id="main-navbar-collapse">
					    <ul class="nav navbar-nav">
					      	<li class="hidden-sm"><a href="http://racktables.org" title="Visit RackTables site">RackTables <?php echo CODE_VERSION ?></a></li>
					      	<?php $this->Quicklinks_Table; ?>
					    </ul>
					    	<ul class="nav navbar-nav" style='float:right'>
					      		<li><a href='index.php?page=myaccount&tab=default'><em><?php $this->RemoteDisplayname; ?></em></a></li>
					    		<li><a href='?logout'><em>[ logout ]</a></em></li>
					    	</ul>
					    </div>
					</div>
				</nav>
	 		</div>
	 	<div class="menubar alert alert-info row" style="padding-top: 75px">
	 		<div class="alert-link" style="padding: 0 0 0 0; float: left"><?php $this->Path; ?></div>
	 			<div class='searchbox'  style="padding: 0 0 0 0; float: right">
				<form name=search method=get>
					<input type=hidden name=page value=search>
					<input type=hidden name=last_page value=<?php $this->PageNo; ?>>
					<input type=hidden name=last_tab value=<?php $this->TabNo; ?>>
					<label>Search:
						<input type=text name=q size=20 tabindex=1000 value='<?php $this->SearchValue; ?>'>
					</label>
				</form>
			</div>
		</div>
	 	<div class="tabbar row">
	 		<div class="greynavbar">
				<ul id="foldertab" style='margin-bottom: 0px; padding-top: 10px;'>
					<?php $this->Tabs; ?>
				</ul>
			</div>
		</div>
	</div>
	<div>
	 	<div class="msgbar row col-xs-12"><?php $this->Message; //showMessageOrError(); ?></div>
	 	<div class="container"><?php $this->Payload; //echo $payload; ?></div>
 	</div>
 	<?php $this->Debug; ?>
</div>
</body>
</html>
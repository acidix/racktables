<?php 
	$this->map(array('Path',0),':','');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<!-- Template taken from: interface.php:94 -->
<head><title><?php $this->PageTitle ; //echo getTitle ($pageno); ?></title>
	<link rel="stylesheet" type="text/css" href="?module=chrome&amp;uri=css/pi.css">
	<script type="text/JavaScript" src="js/jquery-1.4.4.min.js"></script>
	<?php $this->Header ; //printPageHeaders(); ?>
	<link rel="stylesheet" href='tpl/bootstrap/css/bootstrap.min.css'>
	<script type="text/javascript" src='tpl/bootstrap/js/bootstrap.min.js'></script>
</head>
<body>
	<nav class="navbar navbar-default" role="navigation">
  		<div class="container-fluid">
  			<div class="navbar-header">
  				 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
  				<a class="navbar-brand"  href="index.php"><?php $this->Enterprise; //echo getConfigVar ('enterprise') ?> RackTables <a href="http://racktables.org" title="Visit RackTables site"><?php echo CODE_VERSION ?></a></a>
 			</div>
 			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      			<ul class="nav navbar-nav">
      				<?php $this->Quicklinks_Table; ?>
      				<div style="float: right" class=greeting><a href='index.php?page=myaccount&tab=default'><?php $this->RemoteDisplayname; ?></a> [ <a href='?logout'>logout</a> ]</div>
 				</ul>
      		</div><!-- /.navbar-collapse -->
      	</div><!-- /.container-fluid -->
 	</nav>	
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
 		<div class="greynavbar">
			<ul id="foldertab" style='margin-bottom: 0px; padding-top: 10px;'>
				<?php $this->Tabs; ?>
			</ul>
		</div>
	</div>
 	<div class="msgbar"><?php $this->Message; //showMessageOrError(); ?></div>
 	<div class="pagebar"><?php $this->Payload; //echo $payload; ?></div>
</div>
</body>
</html>
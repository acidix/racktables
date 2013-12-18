<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<!-- Template taken from: interface.php:94 -->
<head><title><?php $this->get("page_title"); //echo getTitle ($pageno); ?></title>
	<!-- This is the bootstrap template -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap CSS -->
	<link href="tpl/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<!-- Sidebar stylesheet -->
	<link href="tpl/bootstrap/css/simple-sidebar.css" rel="stylesheet">

	<?php $this->get("Header"); //printPageHeaders(); ?>
</head>
<body>

	<!-- jQuery -->
	<script src="tpl/bootstrap/js/jquery-1.10.2.min.js"></script>
	<!-- Bootstrap JavaScript -->
	<script src="tpl/bootstrap/js/bootstrap.min.js"></script>		

	<div class="wrapper">

		<!-- Sidebar -->
		<div class="sidebar-wrapper" id="sideBarMenu" data-spy="affix" style="display: none;"> 
			<ul class="sidebar-nav" style="height: 100%;">
				<li><a href="#">Rackspace</a></li>
				<li><a href="#">Objects</a></li>
				<li><a href="#">IPv4 space</a></li>
				<li><a href="#">IPv6 space</a></li>
				<li><a href="#">Files</a></li>
				<li><a href="#">Reports</a></li>
				<li><a href="#">IP SLB</a></li>
				<li><a href="#">802.1Q</a></li>
				<li><a href="#">Configuration</a></li>
				<li><a href="#">Log records</a></li>
				<li><a href="#">Virtual Resources</a></li>
				<li role="presentation" class="divider"></li>
				<li><a href="#">Logout</a></li>
			</ul>
		</div>	

		<!-- Navigation bar -->
		<nav class="navbar navbar-inverse navbar-fixed-top" style="width: 100%;">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainNavbar">
						<span class="sr-only">Toggle navigation</span>					

						<span class="icon-bar"></span>
					</button>


				</div>

				<div class="collapse navbar-collapse" id="mainNavbar">

					<form class="navbar-form navbar-left" >
					<!--	<button id="showSideMenuButton" type="button" class="btn btn-navbar btn-primary" data-toggle="collapse" 
					data-target="#sideBarMenu"> -->
					<button id="showSideMenuButton" type="button" class="btn btn-navbar btn-primary">
						<span class='glyphicon glyphicon-align-justify'></span></button>	
					</form>

					<ul class="nav navbar-nav">
						<li><a class="navbar-brand" href="#"><?php $this->get("Enterprise"); ?></a>	</li>
					</ul>
					<ul class="nav navbar-nav">
						<li><a href="http://racktables.org" title="Visit RackTables site"><?php echo CODE_VERSION ?></a></li>
					</ul>
					<?php $this->get("Quicklinks_Table") ?>


				<ul class="nav navbar-nav navbar-right">
					<li><a href='index.php?page=myaccount&tab=default'><?php global $remote_displayname; echo $remote_displayname ?></a></li>
					<li><a href='?logout'> <strong>Logout</strong></a></li>
				</ul>
				<form class="navbar-form navbar-right" role="search">

					<div class="form-group">
						<input type="text" class="form-control" placeholder="">
					</div>
					<button type="submit" class="btn btn-default"><span class='glyphicon glyphicon-search'></span></button>
				</form>
				
			</div> <!-- navbar collapsable -->
		</div>
	</nav>




	<div class="container" style="margin-top: 100px; margin-bottom: 50px;">


		<div class="maintable">
			<div class="menubar"><?php $this->get("PathAndSearch"); //showPathAndSearch ($pageno, $tabno); ?></div>
			<div class="tabbar"><?php $this->get("Tabs") //showTabs ($pageno, $tabno); ?></div>
			<div class="msgbar"><?php $this->get("Message"); //showMessageOrError(); ?></div>
			<div class="pagebar"><?php $this->get("Payload"); //echo $payload; ?></div>
		</div>
	</div>
</div>

<!-- Doing Ínitalscripts here --> 
		<script type="text/javascript">
			$("#showSideMenuButton").click(function (){
				if($('#sideBarMenu').css('display') == "none"){
					$('#sideBarMenu').show();
				}else{
					$('#sideBarMenu').hide();
				}

			})
			$(".sidebar-nav").height($(document).height());
			
		</script>

</body>
</html>
<?php 	
    $this->map(['Tabs',0],"<small>|</small>","|");
	$this->mapFunction(['Path',[]],'transformPathLink');
	
	//A small function that transform static links added by the interface.php file to the list elements we need for the breadcrumbs
	function transformPathLink($old) {
		if (substr($old,0,3) != ' : ') {
			return $old;
		}
		return '<li>' . substr($old,3) . '</li>';
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php $this->PageTitle ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="./css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="./css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="./css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="./css/AdminLTE.css" rel="stylesheet" type="text/css" />
		<!-- Bootstrap Theme style -->
        <link href="./tpl/bootstrap/css/racktables-bootstrap.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="//cdn.mobify.com/modules/scooch/0.3.3/scooch.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->	

		<!-- jQuery 2.0.2 -->
        <script src="./js/jquery-2.0.2.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="./js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="./js/AdminLTE/app.js" type="text/javascript"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="./js/AdminLTE/demo.js" type="text/javascript"></script>
        <!-- Parsley for form validation -->
        <script src="./js/parsley.min.js" type="text/javascript"></script>
        <!-- Enquire for responsive media query -->
        <script src="./tpl/bootstrap/js/enquire.js" type="text/javascript"></script>
        <!-- Bootstrap theme javascript -->
        <script src="./tpl/bootstrap/js/racktables-bootstrap.js" type="text/javascript"></script>

        <link rel="stylesheet" href="//cdn.mobify.com/modules/scooch/0.3.3/scooch.min.css">

		<?php $this->Header ?>
    </head>
    
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="index.php" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <?php $this->Enterprise ?>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php $this->RemoteDisplayname ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <!-- 
                                <li class="user-header bg-light-blue">
                                    <img src="../../img/avatar3.png" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php // $this->RemoteDisplayname ?>
										<!-- TODO: Sachen hier anzeigen ->
                                        <!-- <small>Member since Nov. 2012</small> ->
                                    </p>
                                </li>
                                -->
                                <!-- Menu Body 
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>-->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="?logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
						<!--
                        <div class="pull-left image">
                            <img src="../../img/avatar3.png" class="img-circle" alt="User Image" />
                        </div>
						-->
                        <div class="pull-left info">
                            <p>Hello, <?php $this->RemoteDisplayname ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form -->
                    <form name=search method=get class="sidebar-form" data-parsley-ui-enabled="false" data-parsley-validate>
						<input type=hidden name=page value=search>
						<input type=hidden name=last_page value=<?php $this->PageNo; ?>>
						<input type=hidden name=last_tab value=<?php $this->TabNo; ?>>
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..." text="<?php $this->SearchValue; ?>" required/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    
                    <?php $this->getH('PrintSidebar'); ?>
                
                <!-- /.sidebar -->
            </aside>
            <div class="container-fluid">

                <aside class="right-side sidebar-offcanvas tabbar" style="min-height: 20px;" id="tabsidebar">
                    <!-- sidebar: style can be found in sidebar.less -->
                    <section class="sidebar">
                        <ul class="sidebar-menu"><?php $this->Tabs; ?></ul>
                        <ul class="sidebar-menu operator-list"></ul>
                       <!-- sidebar menu: : style can be found in sidebar.less -->
                    </section>   
                </aside>

                <!-- Right side column. Contains the navbar and content of the page -->
                <aside class="right-side" >
                
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
    					<?php $this->getH('PageHeadline'); ?>
    					<!--<div class="text-center"><?php $this->Tabs ?></div>-->
    					<!-- <?php //$this->getH('PageHeadline',array($this->_Headline,$this->_SubHeadline)); ?> -->
                        <ol class="breadcrumb">
    						<?php $this->Path ?>
    						<!--
                            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li><a href="#">Examples</a></li>
                            <li class="active">Blank page</li>
    						-->
                        </ol>
                    </section>

                    <!-- Main content -->
                    <section class="content">
    					<?php $this->Message ?>
    					<?php $this->Payload ?>
                    </section><!-- /.content -->
                </aside><!-- /.right-side -->
            </div>
        </div><!-- ./wrapper -->
    </body>
</html>

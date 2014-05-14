<?php

# This file is a part of RackTables, a datacenter and server room management
# framework. See accompanying file "COPYING" for the full copyright and
# licensing information.

/*
*
*  This file contains frontend functions for RackTables.
*
*/

require_once 'ajax-interface.php';
require_once 'slb-interface.php';

// Interface function's special.
$nextorder['odd'] = 'even';
$nextorder['even'] = 'odd';

// address allocation type
$aat = array
(
	'regular' => 'Connected',
	'virtual' => 'Loopback',
	'shared' => 'Shared',
	'router' => 'Router',
);
// address allocation code, IPv4 addresses and objects view
$aac = array
(
	'regular' => '',
	'virtual' => '<span class="aac">L</span>',
	'shared' => '<span class="aac">S</span>',
	'router' => '<span class="aac">R</span>',
);
// address allocation code, IPv4 networks view
$aac2 = array
(
	'regular' => '',
	'virtual' => '<strong>L:</strong>',
	'shared' => '<strong>S:</strong>',
	'router' => '<strong>R:</strong>',
);

$vtdecoder = array
(
	'ondemand' => '',
	'compulsory' => 'P',
#	'alien' => 'NT',
);

$vtoptions = array
(
	'ondemand' => 'auto',
	'compulsory' => 'permanent',
#	'alien' => 'never touch',
);

// This may be populated later onsite, report rendering function will use it.
// See the $systemreport for structure.
$localreports = array();

$CodePressMap = array
(
	'sql' => 'sql',
	'php' => 'php',
	'html' => 'htmlmixed',
	'css' => 'css',
	'js' => 'javascript',
);

$attrtypes = array
(
	'uint' => '[U] unsigned integer',
	'float' => '[F] floating point',
	'string' => '[S] string',
	'dict' => '[D] dictionary record',
	'date' => '[T] date'
);

$quick_links = NULL; // you can override this in your local.php, but first initialize it with getConfiguredQuickLinks()

function renderQuickLinks()
{
	global $quick_links;
	

	if (! isset ($quick_links))
		$quick_links = getConfiguredQuickLinks();


	$tplm = TemplateManager::getInstance();
	////$tplm->createMainModule("index");
	$mod = $tplm->generateSubmodule("Quicklinks_Table", "Quicklinks");
//	$mod = $tplm->getMainModule(); 
	//if($mod == null)
	//	return;

	$quicklinks_data =  array();
	//echo '<ul class="qlinks">';
	foreach ($quick_links as $link)
	{
		//Generating the QuickLinks Array
		$quicklinks_row_data = array();
		$quicklinks_row_data['href'] = $link['href'];
		$quicklinks_row_data['title'] = str_replace (' ', '&nbsp;', $link['title']) ;	
		$quicklinks_data[] = $quicklinks_row_data ;
		//	echo '<li><a href="' . $link['href'] . '">' . str_replace (' ', '&nbsp;', $link['title']) . '</a></li>';
	}
	$mod->addOutput("Quicklinks_Data", $quicklinks_data);
	//echo '</ul>';
	
}

function renderInterfaceHTML ($pageno, $tabno, $payload)
{
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head><title><?php echo getTitle ($pageno); ?></title>
<?php printPageHeaders(); ?>
</head>
<body>
<div class="maintable">
 <div class="mainheader">
  <div style="float: right" class=greeting><a href='index.php?page=myaccount&tab=default'><?php global $remote_displayname; echo $remote_displayname ?></a> [ <a href='?logout'>logout</a> ]</div>
 <?php echo getConfigVar ('enterprise') ?> RackTables <a href="http://racktables.org" title="Visit RackTables site"><?php echo CODE_VERSION ?></a><?php renderQuickLinks() ?>
 </div>
 <div class="menubar"><?php showPathAndSearch ($pageno, $tabno); ?></div>
 <div class="tabbar"><?php showTabs ($pageno, $tabno); ?></div>
 <div class="msgbar"><?php showMessageOrError(); ?></div>
 <div class="pagebar"><?php echo $payload; ?></div>
</div>
</body>
</html>
<?php
}

// Main menu.
// Not used with templates
function renderIndexItem ($ypageno)
{
	echo (! permitted ($ypageno)) ? "          <td>&nbsp;</td>\n" :
		"          <td>\n" .
		"            <h1><a href='" . makeHref (array ('page' => $ypageno)) . "'>" .
		getPageName ($ypageno) . "<br>\n" . getImageHREF ($ypageno) .
		"</a></h1>\n" .
		"          </td>\n";

}

function renderIndex()
{
	global $indexlayout;

	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");

	$mod = $tplm->generateSubmodule("Payload", "RenderIndex");
	$mod->setNamespace("index");

	$indexOutput = array();
	foreach ($indexlayout as $row)
	{	
		//ToDo: Findout why it's a problem to 
		$rowMod = $tplm->generateSubmodule("renderedRows","index/RenderIndexRow", $mod);
		
		$rowsCont = array();
		foreach ($row as $column)
			if ($column === NULL)
				$rowsCont[] = array('IsNull' => $tplm->generateModule('EmptyTableCell', true)->run());
			else{
				//$rowsCont[] = array("isNull" => false);
				if((!permitted ($column)))
					$rowsCont[] = array('Permitted' => $tplm->generateModule('EmptyTableCell', true)->run());
				else
				$rowsCont[] = array(
					'IndexItem' => $tplm->generateModule('IndexItemMod', true, array(
						'Href' => makeHref (array ('page' => $column)),
						'PageName' => getPageName ($column),
						'Image' => getImageHREF ($column))
						)->run());
			}
		$rowMod->setOutput("singleRowCont", $rowsCont);

		$indexOutput[] = array("renderedRows" => $rowMod);
	}
	$mod->setOutput("indexArrayOutput", $indexOutput);
/*
?>
<table border=0 cellpadding=0 cellspacing=0 width='100%'>
	<tr>
		<td>
			<div style='text-align: center; margin: 10px; '>
			<table width='100%' cellspacing=0 cellpadding=20 class=mainmenu border=0>
<?php
foreach ($indexlayout as $row)
{
	echo '<tr>';
	foreach ($row as $column)
		if ($column === NULL)
			echo '<td>&nbsp;</td>';
		else
			renderIndexItem ($column);
	echo '</tr>';
}
?>
			</table>
			</div>
		</td>
	</tr>
</table>
<?php */

}

function getRenderedAlloc ($object_id, $alloc)
{
	$ret = array
	(
		'tr_class' => '',
		'td_name_suffix' => '',
		'td_ip' => '',
		'td_network' => '',
		'td_routed_by' => '',
		'td_peers' => '',
	);
	$dottedquad = $alloc['addrinfo']['ip'];
	$ip_bin = $alloc['addrinfo']['ip_bin'];


	$hl_ip_bin = NULL;
	$tplm = TemplateManager::getInstance();

	if (isset ($_REQUEST['hl_ip']))
	{
		$hl_ip_bin = ip_parse ($_REQUEST['hl_ip']);
		//addAutoScrollScript ("ip-" . $_REQUEST['hl_ip']);
		addAutoScrollScript ("ip-" . $_REQUEST['hl_ip'], $tplm->getMainModule(), 'Payload');
	}

	$ret['tr_class'] = $alloc['addrinfo']['class'];
	if ($hl_ip_bin === $ip_bin)
		$ret['tr_class'] .= ' highlight';

	// render IP change history
	$ip_title = '';
	$ip_class = '';
	if (isset ($alloc['addrinfo']['last_log']))
	{
		$log = $alloc['addrinfo']['last_log'];
		$ip_title = "title='" .
			htmlspecialchars
			(
				$log['user'] . ', ' . formatAge ($log['time']),
				ENT_QUOTES
			) . "'";
		$ip_class = 'hover-history underline';
	}

	// render IP address td
	global $aac;
	$netinfo = spotNetworkByIP ($ip_bin);
	//$ret['td_ip'] = "<td class='tdleft'>";
	$td_ip_mod = $tplm->generateModule('RenderedAllocTdIp', true);

	if (isset ($netinfo))
	{
		$title = $dottedquad;
		if (getConfigVar ('EXT_IPV4_VIEW') != 'yes')
			$title .= '/' . $netinfo['mask'];
		
		$tplm->generateSubmodule('Info', 'RenderedAllocTdIpNetInfo', $td_ip_mod, true,
					 array( 'Dottequad' => $dottedquad,
					 		'IpClass' => $ip_class,
					 		'IpTitle' => $ip_title,
					 		'Href' => makeHref (
							array
							(
								'page' => 'ipaddress',
								'hl_object_id' => $object_id,
								'ip' => $dottedquad,
							)),
							'Title' => $title));
	
		/*$ret['td_ip'] .= "<a name='ip-$dottedquad' class='$ip_class' $ip_title href='" .
			makeHref (
				array
				(
					'page' => 'ipaddress',
					'hl_object_id' => $object_id,
					'ip' => $dottedquad,
				)
			) . "'>$title</a>"; */
	}
	else{
		$tplm->generateSubmodule('Info', 'RenderedAllocTdIpNoNetInfo', $td_ip_mod, true,
					 array( 'Dottequad' => $dottedquad,
					 		'IpClass' => $ip_class,
					 		'IpTitle' => $ip_title));
	//	$ret['td_ip'] .= "<span class='$ip_class' $ip_title>$dottedquad</span>";
	
	}

	$td_ip_mod->setOutput('Aac', $aac[$alloc['type']] );

	//$ret['td_ip'] .= $aac[$alloc['type']];
	if (strlen ($alloc['addrinfo']['name']))
		$td_ip_mod->setOutput('NiftyStr',  '(' . niftyString ($alloc['addrinfo']['name']) . ')');
	//	$ret['td_ip'] .= ' (' . niftyString ($alloc['addrinfo']['name']) . ')';
	//$ret['td_ip'] .= '</td>';
	$ret['td_ip'] = $td_ip_mod->run();

	// render network and routed_by tds
	$td_class = 'tdleft';
	if (! isset ($netinfo))
	{
		$ret['td_network'] = $tplm->generateModule('RenderedAllocNetworkNoNetinfo', true, 
							 array('TdClass' => $td_class))->run();
		//$ret['td_network'] = "<td class='$td_class sparenetwork'>N/A</td>";
		$ret['td_routed_by'] = $ret['td_network'];
	}
	else
	{
		/*$ret['td_network'] = "<td class='$td_class'>" .
			getOutputOf ('renderCell', $netinfo) . '</td>'; */
		$ret['td_network'] = $tplm->generateModule('RenderedAllocNetworkNetinfo', true, 
							 array('TdClass' => $td_class,
							 	   'InfoCell' => renderCell($netinfo)))->run(); 

		// render "routed by" td
		if ($display_routers = (getConfigVar ('IPV4_TREE_RTR_AS_CELL') == 'none'))
			$ret['td_routed_by'] = '';
		else
		{
			loadIPAddrList ($netinfo);
			$other_routers = array();
			foreach (findRouters ($netinfo['own_addrlist']) as $router)
				if ($router['id'] != $object_id)
					$other_routers[] = $router;
			if (count ($other_routers))
				$ret['td_routed_by'] = printRoutersTD($other_routers, $display_routers);
				//$ret['td_routed_by'] = getOutputOf ('printRoutersTD', $other_routers, $display_routers);
			else
				$ret['td_routed_by'] = $tplm->generateModule('RenderedAllocRoutedByOnly', true, 
										array('TdClass' => $td_class))->run();
				//$ret['td_routed_by'] = "<td class='$td_class'>&nbsp;</td>";
		}
	}

	// render peers td
	//$ret['td_peers'] = "<td class='$td_class'>";
	$td_peers_mod = $tplm->generateModule('RenderedAllocPeers', true, array('TdClass' => $td_class));
	$prefix = '';
	if ($alloc['addrinfo']['reserved'] == 'yes')
	{	
		$td_peers_mod->addOutput('Prefix', $prefix);
		$tplm->generateSubmodule('Strong', 'StrongElement', $td_peers_mod, true, array('Cont' => 'RESERVED'));
		//$ret['td_peers'] .= $prefix . '<strong>RESERVED</strong>';
		$prefix = '; ';
	}
	foreach ($alloc['addrinfo']['allocs'] as $allocpeer)
	{
		if ($allocpeer['object_id'] == $object_id)
			continue;
		$singleLocPeer = $tplm->generateSubmodule('LocPeers', 'RenderedAllocLocPeers', $td_peers_mod, true, array(
							'Prefix' => $prefix,
							'Href' 	 => makeHref (array ('page' => 'object', 'object_id' => $allocpeer['object_id'])),
							'LocPeer'=> $allocpeer['object_name']));
		//$ret['td_peers'] .= $prefix . "<a href='" . makeHref (array ('page' => 'object', 'object_id' => $allocpeer['object_id'])) . "'>";
		if (isset ($allocpeer['osif']) and strlen ($allocpeer['osif']))
			$singleLocPeer->addOutput('Osif', $allocpeer['osif'] . '@');
		//	$ret['td_peers'] .= $allocpeer['osif'] . '@';
		//$ret['td_peers'] .= $allocpeer['object_name'] . '</a>';

		$prefix = '; ';
	}
	//$ret['td_peers'] .= '</td>';
	$ret['td_peers'] = $td_peers_mod->run(); 
	return $ret;
}

function renderLocationFilterPortlet (TemplateModule $parent = null,$placeholder = "")
{
	// Recursive function used to build the location tree
	function renderLocationCheckbox (TemplateModule $tpl, $subtree, $level = 0)
	{
		$self = __FUNCTION__;

		$tplm = TemplateManager::getInstance();
		foreach ($subtree as $location_id => $location)
		{
			$checked = (! isset ($_SESSION['locationFilter']) || in_array ($location['id'], $_SESSION['locationFilter'])) ? 'checked' : '';
				
			$smod = $tplm->generateSubmodule("Locations", "LocationFilterPortletCheckbox", $tpl);
			$smod->addOutput("Name", $location["name"]);
			$smod->setOutput("Id",$location["id"]);
			$smod->setOutput("Checked",$checked);
			$smod->setOutput("LevelSpace",$level*16);
			$smod->setOutput("Level",$level);
			
			//echo "<div class=tagbox style='text-align:left; padding-left:" . ($level * 16) . "px;'>";
			//echo "<label><input type=checkbox name='location_id[]' class=${level} value='${location['id']}'${checked} onClick=checkAll(this)>${location['name']}";
			//echo '</label>';
			if ($location['kidc'])
			{
				//echo "<a id='lfa" . $location['id'] . "' onclick=\"expand('${location['id']}')\" href\"#\" > - </a>";
				//echo "<div id='lfd" . $location['id'] . "'>";
				$smod->setOutput("Kidc",true);
				$self ($smod, $location['kids'], $level + 1);
				//echo '</div>';
			}
			//echo '</div>';
		}
	}
	
	$tplm = TemplateManager::getInstance();
	
	if($parent == null ){
		$mod = $tplm->generateModule("LocationFilterPortlet");
	}
	else
		$mod = $tplm->generateSubmodule($placeholder, "LocationFilterPortlet", $parent);
	$mod->setNamespace("");
	$mod->setLock(true);
	/**addJS(<<<END
function checkAll(bx) {
	for (var tbls=document.getElementsByTagName("table"), i=tbls.length; i--;)
		if (tbls[i].id == "locationFilter") {
			var bxs=tbls[i].getElementsByTagName("input");
			var in_tree = false;
			for (var j=0; j<bxs.length; j++) {
				if(in_tree == false && bxs[j].value == bx.value)
					in_tree = true;
				else if(parseInt(bxs[j].className) <= parseInt(bx.className))
					in_tree = false;
				if (bxs[j].type=="checkbox" && in_tree == true)
					bxs[j].checked = bx.checked;
			}
		}
}

function collapseAll(bx) {
	for (var tbls=document.getElementsByTagName("table"), i=tbls.length; i--;)
		if (tbls[i].id == "locationFilter") {
			var bxs=tbls[i].getElementsByTagName("div");
			//loop through divs to hide unchecked
			for (var j=0; j<bxs.length; j++) {
				var is_checked = -1;
				var in_div=bxs[j].getElementsByTagName("input");
				//loop through input to find if any is checked
				for (var k=0; k<in_div.length; k++) {
					if(in_div[k].type="checkbox") {
						if (in_div[k].checked == true) {
							is_checked = true;
							break;
						}
						else
							is_checked = false;
					}
				}
				// nothing selected and element id is lfd, collapse it
				if (is_checked == false && !bxs[j].id.indexOf("lfd"))
					expand(bxs[j].id.substr(3));
			}
		}
}

function expand(id) {
	var divid = document.getElementById("lfd" + id);
	var iconid = document.getElementById("lfa" + id);
	if (divid.style.display == 'none') {
		divid.style.display = 'block';
		iconid.innerHTML = ' - ';
	} else {
		divid.style.display = 'none';
		iconid.innerHTML = ' + ';
	}
}
END
	,TRUE);
	startPortlet ('Location filter');
	echo <<<END
<table border=0 align=center cellspacing=0 class="tagtree" id="locationFilter">
    <form method=post>
    <input type=hidden name=page value=rackspace>
    <input type=hidden name=tab value=default>
    <input type=hidden name=changeLocationFilter value=true>
END;*/

	$locationlist = listCells ('location');
	if (count ($locationlist))
	{
		//echo "<tr><td class=tagbox style='padding-left: 0px'><label>";
		//echo "<input type=checkbox name='location'  onClick=checkAll(this)> Toggle all";
		//echo "<img src=pix/1x1t.gif onLoad=collapseAll(this)>"; // dirty hack to collapse all when page is displayed
		//echo "</label></td></tr>\n";
		//echo "<tr><td class=tagbox><hr>\n";
		$mod->addOutput("LocationsExist", true);
		renderLocationCheckbox($mod,treeFromList($locationlist));
		//echo "<hr></td></tr>\n";
		//echo '<tr><td>';
		//printImageHREF ('setfilter', 'set filter', TRUE);
		//echo "</td></tr>\n";
	}
	else
	{
		$mod->addOutput("LocationsExist", false);
		//echo "<tr><td class='tagbox sparenetwork'>(no locations exist)</td></tr>\n";
		//echo "<tr><td>";
		//printImageHREF ('setfilter gray');
		//echo "</td></tr>\n";
	}

	//echo "</form></table>\n";
	//finishPortlet ();
	if($parent == null)
		return $mod->run();
}

function renderRackspace ()
{
	// Handle the location filter
	@session_start();
	if (isset ($_REQUEST['changeLocationFilter']))
		unset ($_SESSION['locationFilter']);
	if (isset ($_REQUEST['location_id']))
		$_SESSION['locationFilter'] = $_REQUEST['location_id'];
	session_commit();
	
	//Added by AK, loading TPLM
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");

	
	$mod = $tplm->generateSubmodule("Payload", "RackspaceOverview");
	$mod->setNamespace("rackspace", true);

	//echo "<table class=objview border=0 width='100%'><tr><td class=pcleft>";

	$found_racks = array();
	$cellfilter = getCellFilter();
	if (! ($cellfilter['is_empty'] && !isset ($_SESSION['locationFilter']) && renderEmptyResults ($cellfilter, 'racks', getEntitiesCount ('rack'))))
	{
		$rows = array();
		$rackCount = 0;
		foreach (getAllRows() as $row_id => $rowInfo)
		{
			$rackList = filterCellList (listCells ('rack', $row_id), $cellfilter['expression']);
			$found_racks = array_merge ($found_racks, $rackList);
			$rows[] = array (
				'location_id' => $rowInfo['location_id'],
				'location_name' => $rowInfo['location_name'],
				'row_id' => $row_id,
				'row_name' => $rowInfo['name'],
				'racks' => $rackList
			);
			$rackCount += count($rackList);
		}

		if (! renderEmptyResults($cellfilter, 'racks', $rackCount))
		{
			// generate thumb gallery
			global $nextorder;
			$rackwidth = getRackImageWidth();
			// Zero value effectively disables the limit.
			$maxPerRow = getConfigVar ('RACKS_PER_ROW');
			$order = 'odd';
			if (count ($rows))
			{
				
				//Generate the table module instead.
				
				//echo '<table border=0 cellpadding=10 class=cooltable>';
				//echo '<tr><th class=tdleft>Location</th><th class=tdleft>Row</th><th class=tdleft>Racks</th></tr>';
				$table = $tplm->generateSubmodule("RackspaceOverviewTable", "RackspaceOverviewTable", $mod);
				$row_objects = array();
				foreach ($rows as $row)
				{
					$location_id = $row['location_id'];
					$row_id = $row['row_id'];
					$row_name = $row['row_name'];
					$rackList = $row['racks'];
					

					if (
						$location_id != '' and isset ($_SESSION['locationFilter']) and !in_array ($location_id, $_SESSION['locationFilter']) or
						empty ($rackList) and ! $cellfilter['is_empty']
					)
						continue;

					$rowo = array();
					$rowo["Order"] = $order;
					
					$rackListIdx = 0;
					//echo "<tr class=row_${order}><th class=tdleft>";
					$locationTree = '';
					while ($location_id)
					{
							$parentLocation = spotEntity ('location', $location_id);
							$locationTree = "&raquo; <a href='" .
								makeHref(array('page'=>'location', 'location_id'=>$parentLocation['id'])) .
								"${cellfilter['urlextra']}'>${parentLocation['name']}</a> " .
								$locationTree;
							$location_id = $parentLocation['parent_id'];
					}
					$locationTree = substr ($locationTree, 8);

					//echo $locationTree;
					$rowo["LocationTree"] = $locationTree;
					$rowo["HrefToRow"] = "<a href='".makeHref(array('page'=>'row', 'row_id'=>$row_id))."${cellfilter['urlextra']}'>${row_name}</a>";
					
					//echo "</th><th class=tdleft><a href='".makeHref(array('page'=>'row', 'row_id'=>$row_id))."${cellfilter['urlextra']}'>${row_name}</a></th>";
					//echo "<th class=tdleft><table border=0 cellspacing=5><tr>";
					
					if (!count ($rackList))
					{

						$rowo["RowOverview"] = "<td>(empty row)</td>";
					}
					else
					{
						$rowo["RowOverview"] = array();
						foreach ($rackList as $rack)
						{
							
							if ($rackListIdx > 0 and $maxPerRow > 0 and $rackListIdx % $maxPerRow == 0)
							{
								//$rowo["RowOverview"][] = $tplm->generateModuleg2391("RackspaceOverviewTableRacklineNew",false,array("RowOrder"=>$order,"RowName",$row_name));
								$rowo["RowOverview"][] = $tplm->generateModule("RackspaceOverviewTableRacklineNew",false,array("RowOrder"=>$order,"RowName",$row_name));
								//echo '</tr></table></th></tr>';
								//echo "<tr class=row_${order}><th class=tdleft></th><th class=tdleft>${row_name} (continued)";
								//echo "</th><th class=tdleft><table border=0 cellspacing=5><tr>";
							}
							$output = array("RackLink"=>makeHref(array('page'=>'rack', 'rack_id'=>$rack['id'])),
											"RackImageWidth"=>$rackwidth,
											"RackImageHeight"=>getRackImageHeight ($rack['height']),
											"RackId"=>$rack['id'],
											"RackName"=>$rack['name'],
											"RackHeight"=>$rack['height']
							);
							$rowo["RowOverview"][] = $tplm->generateModule("RackspaceOverviewTableRackline",false,$output);
							//echo "<td align=center valign=bottom><a href='".makeHref(array('page'=>'rack', 'rack_id'=>$rack['id']))."'>";
							//echo "<img border=0 width=${rackwidth} height=";
							//echo getRackImageHeight ($rack['height']);
							//	echo " title='${rack['height']} units'";
							//echo "src='?module=image&img=minirack&rack_id=${rack['id']}'>";
							//echo "<br>${rack['name']}</a></td>";
							$rackListIdx++;
						}
						$order = $nextorder[$order];
					//echo "</tr></tab></th></tr>\n";
					}
					$row_objects[] = $rowo;
				}
				$table->addOutput("OverviewTable", $row_objects);
				//echo "</table>\n";
				
			}
			else
			{
				$mod->setOutput("RackspaceOverviewTable", "");
				$mod->setOutput("RackspaceOverviewHeadline", "No rows found.");
				//echo "<h2>No rows found</h2>\n";
			}
		}
	}
	//echo '</td><td class=pcright width="25%">';
	renderCellFilterPortlet ($cellfilter, 'rack', $found_racks, array(), $mod, 'CellFilter');
	//echo "<br>\n";
	renderLocationFilterPortlet($mod, 'LocationFilter');
	//echo "</td></tr></table>\n";
}

function renderLocationRowForEditor ($parentmod,$subtree, $level = 0)
{
	$tplm = TemplateManager::getInstance();
	$self = __FUNCTION__;
	foreach ($subtree as $locationinfo)
	{
		$smod = $tplm->generateSubmodule("LocationList", "RackspaceLocationEditorRow", $parentmod);
		//echo "<tr><td align=left style='padding-left: " . ($locationinfo['kidc'] ? $level : ($level + 1) * 16) . "px;'>";
		if ($locationinfo['kidc'])
			$smod->addOutput("HasSublocations", true);
			//printImageHREF ('node-expanded-static');
		if (!($locationinfo['refcnt'] > 0 || $locationinfo['kidc'] > 0))
			$smod->addOutput("IsDeletable",true);
			//printImageHREF ('nodestroy');
		//else
			//echo getOpLink (array ('op' => 'deleteLocation', 'location_id' => $locationinfo['id']), '', 'destroy', 'Delete location');
			
		$smod->addOutput("LocationName", $locationinfo['name']);
		$smod->addOutput("LocationId", $locationinfo['id']);
		//echo '</td><td class=tdleft>';
		//printOpFormIntro ('updateLocation', array ('location_id' => $locationinfo['id']));
		$parent = isset ($locationinfo['parent_id']) ? $locationinfo['parent_id'] : 0;
		//echo getSelect
		//(
		//	array ( $parent => $parent ? htmlspecialchars ($locationinfo['parent_name']) : '-- NONE --'), //@XXX: How can a single element generate multiple.
		//	array ('name' => 'parent_id', 'id' => 'locationid_' . $locationinfo['id'], 'class' => 'locationlist-popup'),
		//	$parent,
		//	FALSE
		//);
		$plist = array ( $parent => $parent ? htmlspecialchars ($locationinfo['parent_name']) : '-- NONE --');
		$outarr = array();
		foreach ($plist as $key => $value) {
			$outarr[] = array("ParentListId"=>$key,"ParentListContent"=>$value,"ParentListSelected"=> ($key == $parent ? "selected" : ""));
		}
		$smod->addOutput("Parentselect",$outarr);
		//echo "</td><td class=tdleft>";
		//echo "<input type=text size=48 name=name value='${locationinfo['name']}'>";
		//echo '</td><td>' . getImageHREF ('save', 'Save changes', TRUE) . "</form></td></tr>\n";
		if ($locationinfo['kidc'])
			$self ($parentmod,$locationinfo['kids'], $level + 1);
	}
}

function renderLocationSelectTree ($selected_id = NULL, $parentmod = null)
{
	if ($parentmod != null)
	{
		$tplm = TemplateManager::getInstance();
		$locationlist = listCells ('location');
		
		
		$mod = $tplm->generateSubmodule("Options", "LocationChildren", $parentmod);
		$mod->defNamespace();
		
		$mod->addOutput('Content','-- None --');
		$mod->addOutput('Id',0);
				
		
		foreach (treeFromList ($locationlist) as $location)
		{
			$mod = $tplm->generateSubmodule("Options", "LocationChildrenBold", $parentmod);
			$mod->setNamespace('',true);
			$mod->setLock(true);
			
			if ($location['id'] == $selected_id )
				$mod->addOutput('Selected', 'selected');
			$mod->addOutput('Content',$location['name']);
			$mod->addOutput("Id", $location['id']) ;
			printLocationChildrenSelectOptions ($location, 0, $selected_id, $mod);
		}
		//echo '</select>';		
	}
	else
	{
		echo '<option value=0>-- NONE --</option>';
		$locationlist = listCells ('location');
		foreach (treeFromList ($locationlist) as $location)
		{
			echo "<option value=${location['id']} style='font-weight: bold' ";
			if ($location['id'] == $selected_id )
				echo ' selected';
		echo ">${location['name']}</option>";
				printLocationChildrenSelectOptions ($location, 0, $selected_id);
		}
		echo '</select>';		
	}

}

function renderRackspaceLocationEditor ()
{
	/** $js = <<<JSTXT
	function locationeditor_showselectbox(e) {
		$(this).load('index.php', {module: 'ajax', ac: 'get-location-select', locationid: this.id});
		$(this).unbind('mousedown', locationeditor_showselectbox);
	}
	$(document).ready(function () {
		$('select.locationlist-popup').bind('mousedown', locationeditor_showselectbox);
	});
JSTXT;

	addJS($js, TRUE	);*/
	
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload", "RackspaceLocationEditor");
	$mod->setNamespace('rackspace',true);
	
	function printNewItemTR ($placeholder,$parentmod)
	{
		$tplm = TemplateManager::getInstance();
		$mod = $tplm->generateSubmodule($placeholder, "RackspaceLocationEditorNew", $parentmod);
		renderLocationSelectTree (NULL, $mod);
		
		//printOpFormIntro ('addLocation');
		//echo '<tr><td>';
		//printImageHREF ('create', 'Add new location', TRUE);
		//echo '</td><td><select name=parent_id tabindex=100>';
		//echo '</td><td><input type=text size=48 name=name tabindex=101></td><td>';
		//printImageHREF ('create', 'Add new location', TRUE, 102);
		//echo "</td></tr></form>\n";
	}

	//startPortlet ('Locations');
	//echo "<table border=0 cellspacing=0 cellpadding=5 align=center class=widetable>\n";
	//echo "<tr><th>&nbsp;</th><th>Parent</th><th>Name</th><th>&nbsp;</th></tr>\n";
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
		printNewItemTR("NewTop",$mod);

	$locations = listCells ('location');
	renderLocationRowForEditor ($mod,treeFromList ($locations));

	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
		printNewItemTR("NewBottom",$mod);
	//echo "</table><br>\n";
	//finishPortlet();
}

function renderRackspaceRowEditor ()
{
	function printNewItemTR ($plc,$parentmod)
	{
		$tplm = TemplateManager::getInstance();
		$mod = $tplm->generateSubmodule($plc, "RackspaceRowEditorNew", $parentmod);
		renderLocationSelectTree (null,$mod);
		
		//printOpFormIntro ('addRow');
		//echo '<tr><td>';
		//printImageHREF ('create', 'Add new row', TRUE);
		//echo '</td><td><select name=location_id tabindex=100>';
		//echo '</td><td><input type=text name=name tabindex=100></td><td>';
		//printImageHREF ('create', 'Add new row', TRUE, 102);
		//echo '</td></tr></form>';
	}
	//startPortlet ('Rows');
	//echo "<table border=0 cellspacing=0 cellpadding=5 align=center class=widetable>\n";
	//echo "<tr><th>&nbsp;</th><th>Location</th><th>Name</th><th>&nbsp;</th></tr>\n";
	
	$tplm = TemplateManager::getInstance();
	
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload", "RackspaceRowEditor");
	$mod->setNamespace("rackspace",true);
	
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
		printNewItemTR ("NewTop",$mod);
	foreach (getAllRows() as $row_id => $rowInfo)
	{
		$smod = $tplm->generateSubmodule("RowList","RackspaceRowEditorRow",$mod);
		//echo '<tr><td>';
		if ($rc = $rowInfo['rackc'])
			$smod->addOutput("HasChildren", true);
			//printImageHREF ('nodestroy', "${rc} rack(s) here");
		//else
		//	echo getOpLink (array('op'=>'deleteRow', 'row_id'=>$row_id), '', 'destroy', 'Delete row');
		//printOpFormIntro ('updateRow', array ('row_id' => $row_id));
		//echo '</td><td>';
		//echo '<select name=location_id tabindex=100>';
		$smod->addOutput("RowId",$row_id);
		$smod->addOutput("RackCount",$rc);
		$smod->addOutput("RowName",$rowInfo['name']);
		renderLocationSelectTree ($rowInfo['location_id'],$smod);
		//echo "</td><td><input type=text name=name value='${rowInfo['name']}' tabindex=100></td><td>";
		//printImageHREF ('save', 'Save changes', TRUE);
		//echo "</form></td></tr>\n";
	}
	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
		printNewItemTR ("NewBottom",$mod);
	//echo "</table><br>\n";
	//finishPortlet();
}

function renderRow ($row_id)
{
	$rowInfo = getRowInfo ($row_id);
	$cellfilter = getCellFilter();
	$rackList = filterCellList (listCells ('rack', $row_id), $cellfilter['expression']);
	// Main layout starts.
	
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate('vanilla');
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule('Payload', 'Row');
	$mod->setNamespace('row',true);
	
	$mod->addOutput('RowName', $rowInfo['name']);
	
	
	//echo "<table border=0 class=objectview cellspacing=0 cellpadding=0>";

	// Left portlet with row information.
	//echo "<tr><td class=pcleft>";
	//startPortlet ($rowInfo['name']);
	//echo "<table border=0 cellspacing=0 cellpadding=3 width='100%'>\n";
	if ($rowInfo['location_id'])
	{
		$mod->addOutput('HasLocation', true);
		$mod->addOutput('LocationLink', mkA ($rowInfo['location'], 'location', $rowInfo['location_id']));
	}
		//echo "<tr><th width='50%' class=tdright>Location:</th><td class=tdleft>".mkA ($rowInfo['location'], 'location', $rowInfo['location_id'])."</td></tr>\n";
	$mod->addOutput('RackCount', $rowInfo['count']);
	$mod->addOutput('RowSum', $rowInfo['sum']);
	
	//echo "<tr><th width='50%' class=tdright>Racks:</th><td class=tdleft>${rowInfo['count']}</td></tr>\n";
	//echo "<tr><th width='50%' class=tdright>Units:</th><td class=tdleft>${rowInfo['sum']}</td></tr>\n";
	//echo "<tr><th width='50%' class=tdright>% used:</th><td class=tdleft>";
	$mod->addOutput('ProgressBar', getProgressBar(getRSUforRow ($rackList)));
	//echo "</td></tr>\n";
	//echo "</table><br>\n";
	//finishPortlet();
	renderCellFilterPortlet ($cellfilter, 'rack', $rackList, array ('row_id' => $row_id), $mod);

	$mod->addOutput('FilesPortlet', renderFilesPortlet('row',$row_id));
	//echo "</td><td class=pcright>";

	global $nextorder;
	$rackwidth = getRackImageWidth() * getConfigVar ('ROW_SCALE');
	// Maximum number of racks per row is proportionally less, but at least 1.
	$maxPerRow = max (floor (getConfigVar ('RACKS_PER_ROW') / getConfigVar ('ROW_SCALE')), 1);
	$rackListIdx = 0;
	$order = 'odd';
	//startPortlet ('Racks');
	//echo "<table border=0 cellspacing=5 align='center'><tr>";
	foreach ($rackList as $rack)
	{
		$smod = $tplm->generateSubmodule('Racks', 'RowRack', $mod);
		if ($rackListIdx % $maxPerRow == 0)
		{
			if ($rackListIdx > 0)
				$smod->addOutput('EndOfLine', true);
				//echo '</tr>';
			$smod->addOutput('NewLine', true);
			//echo '<tr>';
		}
		$class = ($rack['has_problems'] == 'yes') ? 'error' : $order;
		
		$smod->addOutput('Class', $class);
		$smod->addOutput('Link', makeHref(array('page'=>'rack', 'rack_id'=>$rack['id'])));
		$smod->addOutput('ImgWidth',$rackwidth);
		$smod->addOutput('ImgHeight', getRackImageHeight ($rack['height']) * getConfigVar ('ROW_SCALE'));
		$smod->addOutput('Id', $rack['id']);
		$smod->addOutput('Name', $rack['name']);
		
		//echo "<td align=center valign=bottom class=row_${class}><a href='".makeHref(array('page'=>'rack', 'rack_id'=>$rack['id']))."'>";
		//echo "<img border=0 width=${rackwidth} height=" . (getRackImageHeight ($rack['height']) * getConfigVar ('ROW_SCALE'));
		///echo " title='${rack['height']} units'";
		//echo "src='?module=image&img=midirack&rack_id=${rack['id']}&scale=" . getConfigVar ('ROW_SCALE') . "'>";
		//echo "<br>${rack['name']}</a></td>";
		$smod->addOutput('RowScale', getConfigVar ('ROW_SCALE'));
		$order = $nextorder[$order];
		$rackListIdx++;
	}
	//echo "</tr></table>\n";
	//finishPortlet();
	//echo "</td></tr></table>";
}

// Used by renderRack()
function printObjectDetailsForRenderRack ($object_id, $hl_obj_id = 0, $parent = null, $placeholder)
{
	// Dont use again might better use helper function
	$tplm = TemplateManager::getInstance();
	//if($parent==null)
	//	$tplm->setTemplate("vanilla");
	
	if($parent==null)	
		$mod = $tplm->generateModule("PrintObjectDetailsForRenderRack");
	else
		$mod = $tplm->generateSubmodule($placeholder, "PrintObjectDetailsForRenderRack", $parent);
	
	$mod->setNamespace("object");
	
	$objectData = spotEntity ('object', $object_id);
	if (strlen ($objectData['asset_no'])){
		$mod->addOutput("isAsset_no", true);
		$mod->addOutput("asset_no", $objectData['asset_no']);	 
		//$prefix = "<div title='${objectData['asset_no']}";
	}
	//else
	//	$prefix = "<div title='no asset tag";

	// Don't tell about label, if it matches common name.
	//$body = '';
	if ($objectData['name'] != $objectData['label'] and strlen ($objectData['label'])){
		$mod->addOutput("label", $objectData['label']);
		$mod->addOutput("isUncommon_name", true);
	}
			 
	//	$body = ", visible label is \"${objectData['label']}\"";

	// Display list of child objects, if any
	$objectChildren = getEntityRelatives ('children', 'object', $objectData['id']);
	$slotRows = $slotCols = $slotInfo = $slotData = $slotTitle = $slotClass = array ();
	if (count($objectChildren) > 0)
	{
		$mod->addOutput("areObjectChildren", true);
			 
		foreach ($objectChildren as $child)
		{
			$childNames[] = $child['name'];
			$childData = spotEntity ('object', $child['entity_id']);
			$attrData = getAttrValues ($child['entity_id']);
			$numRows = $numCols = 1;
			if (isset ($attrData[2])) // HW type
			{
				extractLayout ($attrData[2]);
				if (isset ($attrData[2]['rows']))
				{
					$numRows = $attrData[2]['rows'];
					$numCols = $attrData[2]['cols'];
				}
			}
			if (isset ($attrData['28'])) // slot number
			{
				$slot = $attrData['28']['value'];
				if (preg_match ('/\d+/', $slot, $matches))
					$slot = $matches[0];
				$slotRows[$slot] = $numRows;
				$slotCols[$slot] = $numCols;
				$slotInfo[$slot] = $child['name'];
				$slotData[$slot] = $child['entity_id'];

				$slotTitleMod = $tplm->generateModule("PrintObjectDetailsForRenderRack_SlotTitle");
				$slotTitleMod->setNamespace('object');

				if (strlen ($childData['asset_no'])){
					$slotTitleMod->setOutput('asset_no', $childData['asset_no']);	
				}
				//	$slotTitle[$slot] = "<div title='${childData['asset_no']}";
				//else
				//	$slotTitle[$slot] = "<div title='no asset tag";
				if (strlen ($childData['label']) and $childData['label'] != $child['name']){
					$slotTitleMod->setOutput('label', $childData['label']);
				}
				//	$slotTitle[$slot] .= ", visible label is \"${childData['label']}\"";
				//$slotTitle[$slot] .= "'>";
				$slotTitle[$slot] = $slotTitleMod->run();
				$slotClass[$slot] = 'state_T';
				if ($childData['has_problems'] == 'yes')
					$slotClass[$slot] = 'state_Tw';
				if ($child['entity_id'] == $hl_obj_id)
					$slotClass[$slot] = 'state_Th';
			}
		}
		natsort($childNames);
		$mod->addOutput("childNames", implode(', ', $childNames));
			 
		//$suffix = sprintf(", contains %s'>", implode(', ', $childNames));
	}
//	else
//		$suffix = "'>";
	$mod->addOutput("mkA", mkA ($objectData['dname'], 'object', $objectData['id']));
		 
//	echo "${prefix}${body}${suffix}" . mkA ($objectData['dname'], 'object', $objectData['id']) . '</div>';
	if (in_array ($objectData['objtype_id'], array (1502,1503))) // server chassis, network chassis
	{
		$objAttr = getAttrValues ($objectData['id']);
		if (isset ($objAttr[2])) // HW type
		{
			extractLayout ($objAttr[2]);
			if (isset ($objAttr[2]['rows']))
			{
				$rows = $objAttr[2]['rows'];
				$cols = $objAttr[2]['cols'];
				$layout = $objAttr[2]['layout'];

				$tablemod = $tplm->generateSubmodule("tableCont","FullWidthTable", $mod, true);
					
				//echo "<table width='100%' border='1'>";
				for ($r = 0; $r < $rows; $r++)
				{
					//echo '<tr>';
					$rowmod = $tplm->generateSubmodule("cont","StdTableRow", $tablemod, true);
					for ($c = 0; $c < $cols; $c++)
					{
						$s = ($r * $cols) + $c + 1;
						if (isset ($slotData[$s]))
						{
							if ($slotData[$s] >= 0)
							{
								for ($lr = 0; $lr < $slotRows[$s]; $lr++)
									for ($lc = 0; $lc < $slotCols[$s]; $lc++)
									{
										$skip = ($lr * $cols) + $lc;
										if ($skip > 0)
											$slotData[$s + $skip] = -1;
									}
								
								$slotDataMod = $tplm->generateSubmodule('cont',"PrintObjectDetailsForRenderRack_SlotData", $rowmod, true);
								$slotDataMod->setNamespace('object');

								//echo '<td';
								if ($slotRows[$s] > 1)
									$slotDataMod->setOutput('slotRow', $slotRows[$s]);
								//	echo " rowspan=$slotRows[$s]";
								if ($slotCols[$s] > 1)
									$slotDataMod->setOutput('slotCols', $slotCols[$s]);
								//	echo " colspan=$slotCols[$s]";
								$slotDataMod->setOutput('slotClass', $slotClass[$s]);
								$slotDataMod->setOutput('slotTitle', $slotTitle[$s]);
								//echo " class='${slotClass[$s]}'>${slotTitle[$s]}";
								if ($layout == 'V')
								{
									$tmp = substr ($slotInfo[$s], 0, 1);
									foreach (str_split (substr ($slotInfo[$s], 1)) as $letter)
										$tmp .= '<br>' . $letter;
									$slotInfo[$s] = $tmp;
								}
								$slotDataMod->setOutput('mkASlotInfo', mkA ($slotInfo[$s], 'object', $slotData[$s]));
								//echo mkA ($slotInfo[$s], 'object', $slotData[$s]);
								//echo '</div></td>';
							}
						}
						else
							$tplm->generateSubmodule("cont","ObjectFreeSolt", $rowmod, true);
						//	echo "<td class='state_F'><div title=\"Free slot\">&nbsp;</div></td>";
					}
					//echo '</tr>';
				}
				//echo '</table>';
			}
		}
	}
	if($parent==null)
		return $mod->run();
}

// This function renders rack as HTML table.
function renderRack ($rack_id, $hl_obj_id = 0, $parent = null, $placeholder = "RenderedRack")
{
	$rackData = spotEntity ('rack', $rack_id);
	amplifyCell ($rackData);
	markAllSpans ($rackData);
	if ($hl_obj_id > 0)
		highlightObject ($rackData, $hl_obj_id);
	$prev_id = getPrevIDforRack ($rackData['row_id'], $rack_id);
	$next_id = getNextIDforRack ($rackData['row_id'], $rack_id);

	$tplm = TemplateManager::getInstance();
	//if($parent==null)
	//	$tplm->setTemplate("vanilla");
	
	if($parent==null)	
		$mod = $tplm->generateModule("RenderRack");
	else
		$mod = $tplm->generateSubmodule($placeholder, "RenderRack", $parent);
	
	$mod->setNamespace("object", true);

	//echo "<center><table border=0><tr valign=middle>";
	//echo '<td><h2>' . mkA ($rackData['row_name'], 'row', $rackData['row_id']) . ' :</h2></td>';
	$mod->addOutput("mkARowName", mkA ($rackData['row_name'], 'row', $rackData['row_id']));	 
	if ($prev_id != NULL) {
		$mod->addOutput("isPrev", true);
		$mod->addOutput("mkAPrevImg", mkA (getImageHREF ('prev', 'previous rack'), 'rack', $prev_id));	 	 	 
		//echo '<td>' . mkA (getImageHREF ('prev', 'previous rack'), 'rack', $prev_id) . '</td>';
	}
	//echo '<td><h2>' . mkA ($rackData['name'], 'rack', $rackData['id']) . '</h2></td>';
	$mod->addOutput("mkAName", mkA ($rackData['name'], 'rack', $rackData['id']));	 
	if ($next_id != NULL){
		$mod->addOutput("isNext", true);
		$mod->addOutput("mkANextImg", mkA (getImageHREF ('next', 'next rack'), 'rack', $next_id));
	//	echo '<td>' . mkA (getImageHREF ('next', 'next rack'), 'rack', $next_id) . '</td>';
	}
	//echo "</h2></td></tr></table>\n";
	//echo "<table class=rack border=0 cellspacing=0 cellpadding=1>\n";
	//echo "<tr><th width='10%'>&nbsp;</th><th width='20%'>Front</th>";
	//echo "<th width='50%'>Interior</th><th width='20%'>Back</th></tr>\n";

	for ($i = $rackData['height']; $i > 0; $i--)
	{
		$singleRow = $tplm->generateSubmodule("RackLoopSpace", "RenderRack_Loop", $mod);
		$singleRow->addOutput("inverseRack", inverseRackUnit ($i, $rackData));
		//echo "<tr><th>" . inverseRackUnit ($i, $rackData) . "</th>";
		
		for ($locidx = 0; $locidx < 3; $locidx++)
		{
			if (isset ($rackData[$i][$locidx]['skipped']))
				continue;
			$state = $rackData[$i][$locidx]['state'];
			
			$singleLocId = array('state' => $state,
							'rackHL' => $rackData[$i][$locidx]['hl'],
							'colspan' => $rackData[$i][$locidx]['colspan'],
							'rowspan' => $rackData[$i][$locidx]['rowspan'],
							);
			//echo "<td class='atom state_${state}";
			//if (isset ($rackData[$i][$locidx]['hl']))
			//	echo $rackData[$i][$locidx]['hl'];
			//echo "'";
			//if (isset ($rackData[$i][$locidx]['colspan']))
			//	echo ' colspan=' . $rackData[$i][$locidx]['colspan'];
			//if (isset ($rackData[$i][$locidx]['rowspan']))
			//	echo ' rowspan=' . $rackData[$i][$locidx]['rowspan'];
			//echo ">";
			if($state == 'T')
				$singleLocId['objectDetail'] = printObjectDetailsForRenderRack ($rackData[$i][$locidx]['object_id'], $hl_obj_id);
			switch ($state)
			{
				case 'T':
			//		printObjectDetailsForRenderRack ($rackData[$i][$locidx]['object_id'], $hl_obj_id);
					break;
				case 'A':
			//		echo '<div title="This rackspace does not exist">&nbsp;</div>';
					break;
				case 'F':
			//		echo '<div title="Free rackspace">&nbsp;</div>';
					break;
				case 'U':
			//		echo '<div title="Problematic rackspace, you CAN\'T mount here">&nbsp;</div>';
					break;
				default:
					$singleLocId['defaultState'] = true;
			//		echo '<div title="No data">&nbsp;</div>';
					break;
			}

			//echo '</td>';
			$tplm->generateSubmodule('AllLocIdx','RenderRack_Loop_Location', $singleRow, false,$singleLocId);
		}
	//	echo "</tr>\n";
	}
	//echo "</table>\n";
	
	// Get a list of all of objects Zero-U mounted to this rack
	$zeroUObjects = getEntityRelatives('children', 'rack', $rack_id);
	if (count ($zeroUObjects) > 0)
	{
		$mod->addOutput("hasZeroUObj", true);
			 
		//echo "<br><table width='75%' class=rack border=0 cellspacing=0 cellpadding=1>\n";
		//echo "<tr><th>Zero-U:</th></tr>\n";
		$allZeroUObjOut = array();
		foreach ($zeroUObjects as $zeroUObject)
		{
			$state = ($zeroUObject['entity_id'] == $hl_obj_id) ? 'Th' : 'T';
			$allZeroUObjOut[] = array('state' => $state, 
				'objDetails' => printObjectDetailsForRenderRack($zeroUObject['entity_id']));
			//echo "<tr><td class='atom state_${state}'>";
			//printObjectDetailsForRenderRack($zeroUObject['entity_id']);
			//echo "</td></tr>\n";
		}
		$mod->addOutput("allZeroUObj", $allZeroUObjOut);
			 
		//echo "</table>\n";
	}
	//echo "</center>\n";

	if($parent==null)
		return $mod->run();
}

function renderRackSortForm ($row_id)
{
	//includeJQueryUI (false);
	/* $js = <<<JSTXT
	$(document).ready(
		function () {
			$("#sortRacks").sortable({
				update : function () {
					serial = $('#sortRacks').sortable('serialize');
					$.ajax({
						url: 'index.php?module=ajax&ac=upd-rack-sort-order',
						type: 'post',
						data: serial,
					});
				}
			});
		}
	);
JSTXT;
	addJS($js, true); */
	
	$tplm = TemplateManager::getInstance();
	
	$mod = $tplm->generateSubmodule('Payload', 'RowRackSortForm');
	$mod->setNamespace('row',true);
	
	//$mod->addJS('js/jquery-ui-1.8.21.min.js');

	//startPortlet ('Racks');
	//echo "<table border=0 cellspacing=0 cellpadding=5 align=center class=widetable>\n";
	//echo "<tr><th>Drag to change order</th></tr>\n";
	//echo "<tr><td><ul class='uflist' id='sortRacks'>\n";
	$arr = array();
	foreach (getRacks($row_id) as $rack_id => $rackInfo)
		$arr[] = array('RackId'=>$rack_id,'RackName'=>$rackInfo['name']);
	
	$mod->addOutput('racklist', $arr);
		//$mod->addOutput('racklist', array());
		//echo "<li id=racks_${rack_id}>${rackInfo['name']}</li>\n";
	//echo "</ul></td></tr></table>\n";
	//finishPortlet();
}

function renderNewRackForm ($row_id)
{
	$default_height = getConfigVar ('DEFAULT_RACK_HEIGHT');
	if ($default_height == 0)
		$default_height = '';
	
	$tplm = TemplateManager::getInstance();
	
	//$tplm->setTemplate('vanilla');
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule('Payload', 'NewRackForm');
	$mod->setNamespace('row',true);
	
	$mod->addOutput('DefaultHeight', $default_height);
	
	renderNewEntityTags ('rack',$mod,'Tags');
	
	/*
	startPortlet ('Add one');
	printOpFormIntro ('addRack', array ('got_data' => 'TRUE'));
	echo '<table border=0 align=center>';
	echo "<tr><th class=tdright>Name (required):</th><td class=tdleft><input type=text name=name tabindex=1></td>";
	echo "<td rowspan=4>Assign tags:<br>";
	echo renderNewEntityTags ('rack');
	echo "</td></tr>\n";
	echo "<tr><th class=tdright>Height in units (required):</th><td class=tdleft><input type=text name=height1 tabindex=2 value='${default_height}'></td></tr>\n";
	echo "<tr><th class=tdright>Asset tag:</th><td class=tdleft><input type=text name=asset_no tabindex=4></td></tr>\n";
	echo "<tr><td class=submit colspan=2>";
	printImageHREF ('CREATE', 'Add', TRUE);
	echo "</td></tr></table></form>";
	finishPortlet();

	startPortlet ('Add many');
	printOpFormIntro ('addRack', array ('got_mdata' => 'TRUE'));
	echo '<table border=0 align=center>';
	echo "<tr><th class=tdright>Height in units (*):</th><td class=tdleft><input type=text name=height2 value='${default_height}'></td>";
	echo "<td rowspan=3 valign=top>Assign tags:<br>";
	echo renderNewEntityTags ('rack');
	echo "</td></tr>\n";
	echo "<tr><th class=tdright>Rack names (required):</th><td class=tdleft><textarea name=names cols=40 rows=25></textarea></td></tr>\n";
	echo "<tr><td class=submit colspan=2>";
	printImageHREF ('CREATE', 'Add', TRUE);
	echo '</form></table>';
	finishPortlet(); */
}

function renderEditObjectForm()
{
	global $pageno;
	$object_id = getBypassValue();
	$object = spotEntity ('object', $object_id);
	$tplm = TemplateManager::getInstance();
	
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderEditObjectForm");
	$mod->setNamespace("object");

//	startPortlet ();
//	printOpFormIntro ('update');

	// static attributes
//	echo '<table border=0 cellspacing=0 cellpadding=3 align=center>';
//	echo "<tr><td>&nbsp;</td><th colspan=2><h2>Attributes</h2></th></tr>";
//	echo '<tr><td>&nbsp;</td><th class=tdright>Type:</th><td class=tdleft>';
//	printSelect (getObjectTypeChangeOptions ($object['id']), array ('name' => 'object_type_id'), $object['objtype_id']);
	$mod->setOutput('PrintOptSel', printSelect (getObjectTypeChangeOptions ($object['id']), array ('name' => 'object_type_id'), $object['objtype_id']));
//	echo '</td></tr>';
	// baseline info
	$mod->addOutput("object_name", $object['name']);
	$mod->addOutput("object_label", $object['label']);
	$mod->addOutput("object_asset_no", $object['asset_no']);	 
//	echo "<tr><td>&nbsp;</td><th class=tdright>Common name:</th><td class=tdleft><input type=text name=object_name value='${object['name']}'></td></tr>\n";
//	echo "<tr><td>&nbsp;</td><th class=tdright>Visible label:</th><td class=tdleft><input type=text name=object_label value='${object['label']}'></td></tr>\n";
//	echo "<tr><td>&nbsp;</td><th class=tdright>Asset tag:</th><td class=tdleft><input type=text name=object_asset_no value='${object['asset_no']}'></td></tr>\n";
	// parent selection
	if (objectTypeMayHaveParent ($object['objtype_id']))
	{
		$mod->addOutput("haveParent", true);
			 
		$parents = getEntityRelatives ('parents', 'object', $object_id);
		$allParentsOut = array();
		foreach ($parents as $link_id => $parent_details)
		{
			
			if (!isset($label))
				$label = count($parents) > 1 ? 'Containers:' : 'Container:';
			$allParentsOut[] = array('label' => $label, 'mkA' => mkA ($parent_details['name'], 'object', $parent_details['entity_id']),
							);
			getOpLink (array('op'=>'unlinkEntities', 'link_id'=>$link_id), '', 'cut', 'Unlink container', '', $mod, "parentsOpLink");
			//echo "<tr><td>&nbsp;</td>";
			//echo "<th class=tdright>${label}</th><td class=tdleft>";
			//echo mkA ($parent_details['name'], 'object', $parent_details['entity_id']);
			//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			//echo getOpLink (array('op'=>'unlinkEntities', 'link_id'=>$link_id), '', 'cut', 'Unlink container');
			//echo "</td></tr>\n";
			$label = '&nbsp;';
		}
		$mod->addOutput("allParents", $allParentsOut);
			 
	//	echo "<tr><td>&nbsp;</td>";
	//	echo "<th class=tdright>Select container:</th><td class=tdleft>";
	//	echo "<span";
		$helper_args = array ('object_id' => $object_id);
		$mod->addOutput('ObjID', $object_id);
		//$mod->addOutput('ParentPopupLink', makeHrefForHelper ('objlist', $helper_args));
	//	$popup_args = 'height=700, width=400, location=no, menubar=no, '.
	//		'resizable=yes, scrollbars=yes, status=no, titlebar=no, toolbar=no';
	//	echo " onclick='window.open(\"" . makeHrefForHelper ('objlist', $helper_args);
	//	echo "\",\"findlink\",\"${popup_args}\");'>";
	//	printImageHREF ('attach', 'Select a container');
	//	echo "</span></td></tr>\n";
		//printImageHREF ('attach', 'Select a container', $mod, 'ImageSelCont');

	}
	// optional attributes
	$i = 0;
	$values = getAttrValues ($object_id);
	if (count($values) > 0)
	{
		$mod->addOutput("areValues", true);
		
		foreach ($values as $record)
		{
			if (! permitted (NULL, NULL, NULL, array (
				array ('tag' => '$attr_' . $record['id']),
				array ('tag' => '$any_op'),
			)))
				continue;

			$singleVal = array('i' => $i, 'id' => $record['id'], 'name' => $record['name']);
		//	echo "<input type=hidden name=${i}_attr_id value=${record['id']}>";
		//	echo '<tr><td>';
			if (strlen ($record['value']))
				$singleVal['value_link'] = getOpLink (array('op'=>'clearSticker', 'attr_id'=>$record['id']), '', 'clear', 'Clear value', 'need-confirmation');
		//		echo getOpLink (array('op'=>'clearSticker', 'attr_id'=>$record['id']), '', 'clear', 'Clear value', 'need-confirmation');
			else
				$singleVal['value_link'] = '&nbsp;';
		//		echo '&nbsp;';
		//	echo '</td>';
		//	echo "<th class=sticker>${record['name']}";
			if ($record['type'] == 'date'){
				$singleVal['dateFormatTime'] = datetimeFormatHint (getConfigVar ('DATETIME_FORMAT'));
				//echo ' (' . datetimeFormatHint (getConfigVar ('DATETIME_FORMAT')) . ')';
			}
			//echo ':</th><td class=tdleft>';
			$singleVal['type'] = $record['type'];
			switch ($record['type'])
			{
				case 'uint':
				case 'float':
				case 'string':
					//echo "<input type=text name=${i}_value value='${record['value']}'>";
					$singleVal['value'] = $record['value'];
					break;
				case 'dict':
					$chapter = readChapter ($record['chapter_id'], 'o');
					$chapter[0] = '-- NOT SET --';
					$chapter = cookOptgroups ($chapter, $object['objtype_id'], $record['key']);
					$singleVal['niftyStr'] = printNiftySelect ($chapter, array ('name' => "${i}_value"), $record['key']);
					//printNiftySelect ($chapter, array ('name' => "${i}_value"), $record['key']);
					break;
				case 'date':
					$date_value = $record['value'] ? datetimestrFromTimestamp ($record['value']) : '';
					$singleVal['date_value'] = $date_value;
					//echo "<input type=text name=${i}_value value='${date_value}'>";
					break;
			}
			//echo "</td></tr>\n";
			$allObjMod = $tplm->generateSubmodule('AllObjValues', 'RenderEditObjectForm_ObjValues', $mod, false, $singleVal);
			$allObjMod->setNamespace('object');
			$i++;
		}
			 
	}
	$mod->addOutput("i", $i);
		 
	//echo '<input type=hidden name=num_attrs value=' . $i . ">\n";
	//echo "<tr><td>&nbsp;</td><th class=tdright>Has problems:</th><td class=tdleft><input type=checkbox name=object_has_problems";
	if ($object['has_problems'] == 'yes')
		$mod->addOutput("hasProblems", true);
			 
	//	echo ' checked';
	//echo "></td></tr>\n";
	//echo "<tr><td>&nbsp;</td><th class=tdright>Actions:</th><td class=tdleft>";
	//echo getOpLink (array ('op'=>'deleteObject', 'page'=>'depot', 'tab'=>'addmore', 'object_id'=>$object_id), '' ,'destroy', 'Delete object', 'need-confirmation');
	getOpLink (array ('op'=>'deleteObject', 'page'=>'depot', 'tab'=>'addmore', 'object_id'=>$object_id), '' 
			,'destroy', 'Delete object', 'need-confirmation', $mod, 'deleteObjLink');
	//echo "&nbsp;";
	//echo getOpLink (array ('op'=>'resetObject'), '' ,'clear', 'Reset (cleanup) object', 'need-confirmation');
	getOpLink (array ('op'=>'resetObject'), '' ,'clear', 'Reset (cleanup) object', 
		'need-confirmation', $mod, 'resObjLink');
	//echo "</td></tr>\n";
	$mod->addOutput("obj_comment", $object['comment']);
		 
	//echo "<tr><td colspan=3><b>Comment:</b><br><textarea name=object_comment rows=10 cols=80>${object['comment']}</textarea></td></tr>";

	//echo "<tr><th class=submit colspan=3>";
	//printImageHREF ('SAVE', 'Save changes', TRUE);
	//echo "</form></th></tr></table>\n";
	//finishPortlet();

	//echo '<table border=0 width=100%><tr><td>';
	//startPortlet ('history');
	//renderObjectHistory ($object_id);
	renderObjectHistory ($object_id, $mod, 'objectHistoryMod');
	//finishPortlet();
	//echo '</td></tr></table>';
}

function renderEditRackForm ($rack_id)
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate('vanilla');
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule('Payload', 'RackEditor');
	$mod->setNamespace('rack');
	
	global $pageno;
	$rack = spotEntity ('rack', $rack_id);
	amplifyCell ($rack);

	//startPortlet ('Attributes');
	//printOpFormIntro ('updateRack');
	//echo '<table border=0 align=center>';
	//echo "<tr><td>&nbsp;</td><th class=tdright>Rack row:</th><td class=tdleft>";
	foreach (getAllRows () as $row_id => $rowInfo)
	{
		$trail = getLocationTrail ($rowInfo['location_id'], FALSE);
		$rows[$row_id] = empty ($trail) ? $rowInfo['name'] : $rowInfo['name'] . ' [' . $trail . ']';
	}
	natcasesort ($rows);	
	getSelect ($rows, array ('name' => 'row_id'), $rack['row_id'], TRUE, $mod, 'RowSelect');
	//echo "</td></tr>\n";
	$mod->addOutput('Name', $rack['name']);
	$mod->addOutput('Height', $rack['height']);
	$mod->addOutput('AssetTag', $rack['asset_no']);
	//echo "<tr><td>&nbsp;</td><th class=tdright>Name (required):</th><td class=tdleft><input type=text name=name value='${rack['name']}'></td></tr>\n";
	//echo "<tr><td>&nbsp;</td><th class=tdright>Height (required):</th><td class=tdleft><input type=text name=height value='${rack['height']}'></td></tr>\n";
	//echo "<tr><td>&nbsp;</td><th class=tdright>Asset tag:</th><td class=tdleft><input type=text name=asset_no value='${rack['asset_no']}'></td></tr>\n";
	// optional attributes
	$values = getAttrValues ($rack_id);
	$num_attrs = count($values);
	$num_attrs = $num_attrs-2; // subtract for the 'height' and 'sort_order' attributes
	$mod->addOutput('NumAttrs', $num_attrs);
	//echo "<input type=hidden name=num_attrs value=${num_attrs}>\n";
	$i = 0;
	foreach ($values as $record)
	{
		// Skip the 'height' attribute as it's already displayed as a required field
		// Also skip the 'sort_order' attribute
		if ($record['id'] == 27 or $record['id'] == 29)
			continue;
		//echo "<input type=hidden name=${i}_attr_id value=${record['id']}>";
		//echo '<tr><td>';
		
		$smod = $tplm->generateSubmodule('ExtraAttrs', 'RackEditorAttrs', $mod);
		$smod->addOutput('Id', $record['id']);
		$smod->addOutput('I', $i);
		$smod->addOutput('Value', $record['value']);
		$smod->addOutput('Name', $record['name']);
		
		
		
		if (strlen ($record['value']))
			$smod->addOutput('Deletable', true);
			//echo getOpLink (array('op'=>'clearSticker', 'attr_id'=>$record['id']), '', 'clear', 'Clear value', 'need-confirmation');
		//else
		//	echo '&nbsp;';
		//echo '</td>';
		//echo "<th class=sticker>${record['name']}:</th><td class=tdleft>";
		
		if ($record['type'] == 'dict')
		{
			$chapter = readChapter ($record['chapter_id'], 'o');
			$chapter[0] = '-- NOT SET --';
			$chapter = cookOptgroups ($chapter, 1560, $record['key']);
			printNiftySelect ($chapter, array ('name' => "${i}_value"), $record['key'], false , $mod, 'DictSelect');
			$smod->addOutput('Type', 'dict');
		}
		
		/*
		switch ($record['type'])
		{
			case 'uint':
			case 'float':
			case 'string':
				//echo "<input type=text name=${i}_value value='${record['value']}'>";
				break;
			case 'dict':
				$chapter = readChapter ($record['chapter_id'], 'o');
				$chapter[0] = '-- NOT SET --';
				$chapter = cookOptgroups ($chapter, 1560, $record['key']);
				printNiftySelect ($chapter, array ('name' => "${i}_value"), $record['key']);
				break;
		}
		echo "</td></tr>\n"*/
		$i++;
	}
	//echo "<tr><td>&nbsp;</td><th class=tdright>Has problems:</th><td class=tdleft><input type=checkbox name=has_problems";
	if ($rack['has_problems'] == 'yes')
		$mod->addOutput('HasProblems', 'checked');
		//echo ' checked';
	//echo "></td></tr>\n";
	if ($rack['isDeletable'])
	{
		$mod->addOutput('Deletable', true);
		//echo "<tr><td>&nbsp;</td><th class=tdright>Actions:</th><td class=tdleft>";
		//echo getOpLink (array ('op'=>'deleteRack'), '', 'destroy', 'Delete rack', 'need-confirmation');
		//echo "&nbsp;</td></tr>\n";
	}
	$mod->addOutput("Rack_Comment", $rack['comment']);
		 
	//echo "<tr><td colspan=3><b>Comment:</b><br><textarea name=comment rows=10 cols=80>${rack['comment']}</textarea></td></tr>";
	//echo "<tr><td class=submit colspan=3>";
	//printImageHREF ('SAVE', 'Save changes', TRUE);
	//echo "</td></tr>\n";
	//echo '</form></table><br>';
	//finishPortlet();

	//startPortlet ('History');
	renderObjectHistory ($rack_id,$mod,'History');
	//finishPortlet();
}

// used by renderGridForm() and renderRackPage()
function renderRackInfoPortlet ($rackData, $parent = null, $placeholder = 'Payload')
{
	$summary = array();
	$summary['Rack row'] = mkA ($rackData['row_name'], 'row', $rackData['row_id']);
	$summary['Name'] = $rackData['name'];
	$summary['Height'] = $rackData['height'];
	
	if (strlen ($rackData['asset_no']))
		$summary['Asset tag'] = $rackData['asset_no'];
	if ($rackData['has_problems'] == 'yes')
		$summary[] = array ('<tr><td colspan=2 class=msg_error>Has problems</td></tr>');
	// Display populated attributes, but skip 'height' since it's already displayed above
	// and skip 'sort_order' because it's modified using AJAX
	foreach (getAttrValues ($rackData['id']) as $record)
		if ($record['id'] != 27 && $record['id'] != 29 && strlen ($record['value']))
			$summary['{sticker}' . $record['name']] = formatAttributeValue ($record);
	$summary['% used'] = getProgressBar (getRSUforRack ($rackData));
	$summary['Objects'] = count ($rackData['mountedObjects']);
	$summary['tags'] = '';
	if (strlen ($rackData['comment']))
		$summary['Comment'] = $rackData['comment'];
	
	$tplm = TemplateManager::getInstance();
	
	if ($parent == null)
	{
		//$tplm->setTemplate('vanilla');
		//$tplm->createMainModule();
		$parent = $tplm->getMainModule();
	}
	
	renderEntitySummary ($rackData, 'summary', $summary, $parent, $placeholder);
}

// This is a universal editor of rack design/waste.
// FIXME: switch to using printOpFormIntro()
function renderGridForm ($rack_id, $filter, $header, $submit, $state1, $state2)
{
	$rackData = spotEntity ('rack', $rack_id);
	amplifyCell ($rackData);
	$filter ($rackData);
	
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate('vanilla');
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule('Payload', 'GridForm');
	$mod->setNamespace('rack');
	
	$mod->addOutput('Header', $header);
	$mod->addOutput('Name', $rackData['name']);
	$mod->addOutput('Id', $rack_id);
	$mod->addOutput('Height', $rackData['height']);
	$mod->addOutput('Submit', $submit);
	
	// Render the result whatever it is.
	// Main layout.
	//echo "<table border=0 class=objectview cellspacing=0 cellpadding=0>";
	//echo "<tr><td colspan=2 align=center><h1>${rackData['name']}</h1></td></tr>\n";
	
	// Left column with information portlet.
	//echo "<tr><td class=pcleft height='1%' width='50%'>";
	renderRackInfoPortlet ($rackData,$mod,'InfoPortlet');
	//echo "</td>\n";
	//echo "<td class=pcright>";

	// Grid form.
	/** startPortlet ($header);
	addJS ('js/racktables.js');
	echo "<center>\n";
	echo "<table class=rack border=0 cellspacing=0 cellpadding=1>\n";
	echo "<tr><th width='10%'>&nbsp;</th>";
	echo "<th width='20%'><a href='javascript:;' onclick=\"toggleColumnOfAtoms('${rack_id}', '0', ${rackData['height']})\">Front</a></th>";
	echo "<th width='50%'><a href='javascript:;' onclick=\"toggleColumnOfAtoms('${rack_id}', '1', ${rackData['height']})\">Interior</a></th>";
	echo "<th width='20%'><a href='javascript:;' onclick=\"toggleColumnOfAtoms('${rack_id}', '2', ${rackData['height']})\">Back</a></th></tr>\n";
	printOpFormIntro ('updateRack'); */
	markupAtomGrid ($rackData, $state2);
	renderAtomGrid ($rackData, $mod, 'AtomGrid');
	/** echo "</table></center>\n";
	echo "<br><input type=submit name=do_update value='${submit}'></form><br><br>\n";
	finishPortlet();
	echo "</td></tr></table>\n"; */
}

function renderRackDesign ($rack_id)
{
	renderGridForm ($rack_id, 'applyRackDesignMask', 'Rack design', 'Set rack design', 'A', 'F');
}

function renderRackProblems ($rack_id)
{
	renderGridForm ($rack_id, 'applyRackProblemMask', 'Rack problems', 'Mark unusable atoms', 'F', 'U');
}

function renderObjectPortRow ($port, $is_highlighted, $parent = null, $placeholder = "RenderedObjectPort")
{
	$tplm = TemplateManager::getInstance();
	//if($parent==null)
	//	$tplm->setTemplate("vanilla");
	
	if($parent==null)	
		$mod = $tplm->generateModule('RenderObjectPortRow');
	else
		$mod = $tplm->generateSubmodule($placeholder, 'RenderObjectPortRow', $parent);
	
	$mod->setNamespace('object');
	
	//echo '<tr';
	if ($is_highlighted)
		$mod->addOutput('IsHighlighted', true);
			 
	//	echo ' class=highlight';
	$a_class = isEthernetPort ($port) ? 'port-menu' : '';
	//echo "><td class='tdleft' NOWRAP><a name='port-${port['id']}' class='interactive-portname nolink $a_class'>${port['name']}</a></td>";
	//echo "<td class=tdleft>${port['label']}</td>";
	//echo "<td class=tdleft>" . formatPortIIFOIF ($port) . "</td><td class=tdleft><tt>${port['l2address']}</tt></td>";
	$mod->addOutput('PortId', $port['id']);
	$mod->addOutput('AClass', $a_class);
	$mod->addOutput('PortLabel', $port['label']);
	$mod->addOutput('PortName', $port['name']);
	$mod->addOutput('PortL2address', $port['l2address']);
	$mod->addOutput('FormatedPort', formatPortIIFOIF ($port));

	if ($port['remote_object_id'])
	{
		/*echo "<td class=tdleft>" .
			formatPortLink ($port['remote_object_id'], $port['remote_object_name'], $port['remote_id'], NULL) .
			"</td>";
		echo "<td class=tdleft>" . formatLoggedSpan ($port['last_log'], $port['remote_name'], 'underline') . "</td>";
		
		echo "<td class=tdleft><span class='rsvtext $editable id-${port['id']} op-upd-reservation-cable'>${port['cableid']}</span></td>";*/
		$editable = permitted ('object', 'ports', 'editPort')
			? 'editable'
			: '';

		$mod->addOutput('FormatedPortLink', formatPortLink ($port['remote_object_id'], $port['remote_object_name'], $port['remote_id'], NULL));
		$mod->addOutput('FormatedLoggSpan', formatLoggedSpan ($port['last_log'], $port['remote_name'], 'underline'));
		$mod->addOutput('Editable', $editable);
		$mod->addOutput('PortCableId', $port['cableid']);
	}
	else
		$mod->addOutput('FormatedReservation', implode ('', formatPortReservation ($port)));
	//	echo implode ('', formatPortReservation ($port)) . '<td></td>';
	//echo "</tr>";

	if($parent==null)
		return $mod->run();
}

function renderObject ($object_id)
{
	global $nextorder, $virtual_obj_types;
	$info = spotEntity ('object', $object_id);
	amplifyCell ($info);

	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderObject");
	$mod->setNamespace("object");
		
	// Main layout starts.
	//echo "<table border=0 class=objectview cellspacing=0 cellpadding=0>";
	$mod->addOutput("infoDName", $info['dname']); 
	//echo "<tr><td colspan=2 align=center><h1>${info['dname']}</h1></td></tr>\n";
	// left column with uknown number of portlets
	//echo "<tr><td class=pcleft>";

	// display summary portlet
	$summary  = array();
	if (strlen ($info['name']))
		$summary['Common name'] = $info['name'];
	elseif (considerConfiguredConstraint ($info, 'NAMEWARN_LISTSRC'))
		$summary[] = array ('<tr><td colspan=2 class=msg_error>Common name is missing.</td></tr>');
	$summary['Object type'] = '<a href="' . makeHref (array (
		'page' => 'depot',
		'tab' => 'default',
		'cfe' => '{$typeid_' . $info['objtype_id'] . '}'
	)) . '">' .  decodeObjectType ($info['objtype_id'], 'o') . '</a>';
	if (strlen ($info['label']))
		$summary['Visible label'] = $info['label'];
	if (strlen ($info['asset_no']))
		$summary['Asset tag'] = $info['asset_no'];
	elseif (considerConfiguredConstraint ($info, 'ASSETWARN_LISTSRC'))
		$summary[] = array ('<tr><td colspan=2 class=msg_error>Asset tag is missing.</td></tr>');
	$parents = getEntityRelatives ('parents', 'object', $object_id);
	if (count ($parents))
	{
		$fmt_parents = array();
		foreach ($parents as $parent)
			$fmt_parents[] =  "<a href='".makeHref(array('page'=>$parent['page'], $parent['id_name'] => $parent['entity_id']))."'>${parent['name']}</a>";
		$summary[count($parents) > 1 ? 'Containers' : 'Container'] = implode ('<br>', $fmt_parents);
	}
	$children = getEntityRelatives ('children', 'object', $object_id);
	if (count ($children))
	{
		$fmt_children = array();
		foreach ($children as $child)
			$fmt_children[] = "<a href='".makeHref(array('page'=>$child['page'], $child['id_name']=>$child['entity_id']))."'>${child['name']}</a>";
		$summary['Contains'] = implode ('<br>', $fmt_children);
	}
	if ($info['has_problems'] == 'yes')
		$summary[] = array ('<tr><td colspan=2 class=msg_error>Has problems</td></tr>');
	foreach (getAttrValues ($object_id) as $record)
		if
		(
			strlen ($record['value']) and
			permitted (NULL, NULL, NULL, array (array ('tag' => '$attr_' . $record['id'])))
		)
			$summary['{sticker}' . $record['name']] = formatAttributeValue ($record);
	$summary[] = array (getOutputOf ('printTagTRs',
		$info,
		makeHref
		(
			array
			(
				'page'=>'depot',
				'tab'=>'default',
				'andor' => 'and',
				'cfe' => '{$typeid_' . $info['objtype_id'] . '}',
			)
		)."&"
	));
	//renderEntitySummary ($info, 'summary', $summary);
	renderEntitySummary ($info, 'summary', $summary, $mod, "infoSummary");

	if (strlen ($info['comment']))
	{
		$mod->addOutput("isComment", true);
		$mod->addOutput("comment_hrefs", string_insert_hrefs ($info['comment']));
			 	 	 
		//startPortlet ('Comment');
		//echo '<<div class=commentblock>' . string_insert_hrefs ($info['comment']) . '</div>';
		//finishPortlet ();
	}

	$logrecords = getLogRecordsForObject ($_REQUEST['object_id']);
	if (count ($logrecords))
	{
		$mod->addOutput("areLogRecords", true);
			 
		//startPortlet ('log records');
		//echo "<table cellspacing=0 cellpadding=5 align=center class=widetable width='100%'>";
		$order = 'odd';
		$allLogrecordsOut = array();
		foreach ($logrecords as $row)
		{
			$singleRecord = array('order' => $order, 'date' => $row['date'], 'user' => $row['user']);
			//echo "<tr class=row_${order} valign=top>";
			//echo '<td class=tdleft>' . $row['date'] . '<br>' . $row['user'] . '</td>';
			$singleRecord['cont'] = string_insert_hrefs (htmlspecialchars ($row['content'], ENT_NOQUOTES));
			//echo '<td class="logentry">' . string_insert_hrefs (htmlspecialchars ($row['content'], ENT_NOQUOTES)) . '</td>';
			//echo '</tr>';
			$allLogrecordsOut[] = $singleRecord;
			$order = $nextorder[$order];
		}
		$mod->addOutput("allLogrecords", $allLogrecordsOut);
		//echo '</table>';
		//finishPortlet();
	}

	switchportInfoJS ($object_id, $mod, 'switchportJS'); // load JS code to make portnames interactive
	//renderFilesPortlet ('object', $object_id);

	renderFilesPortlet ('object', $object_id, $mod, "filesPortlet");

	if (count ($info['ports']))
	{
		$mod->addOutput("isInfoPorts", true);
			 
		//startPortlet ('ports and links');
		$hl_port_id = 0;
		if (isset ($_REQUEST['hl_port_id']))
		{
			assertUIntArg ('hl_port_id');
			$hl_port_id = $_REQUEST['hl_port_id'];
			addAutoScrollScript ("port-$hl_port_id");
		}
		//echo "<table cellspacing=0 cellpadding='5' align='center' class='widetable'>";
		//echo '<tr><th class=tdleft>Local name</th><th class=tdleft>Visible label</th>';
		//echo '<th class=tdleft>Interface</th><th class=tdleft>L2 address</th>';
		//echo '<th class=tdcenter colspan=2>Remote object and port</th>';
		//echo '<th class=tdleft>Cable ID</th></tr>';
		foreach ($info['ports'] as $port)
		//	callHook ('renderObjectPortRow', $port, ($hl_port_id == $port['id']));
			callHook ('renderObjectPortRow', $port, ($hl_port_id == $port['id']), $mod, 'RenderedObjectPorts');
		if (permitted (NULL, 'ports', 'set_reserve_comment'))	
		//	addJS ('js/inplace-edit.js'<);
			$mod->addOutput("loadInplaceEdit", true);
				 
		//echo "</table><br>";
		//finishPortlet();
	}

	if (count ($info['ipv4']) + count ($info['ipv6']))
	{
		$mod->addOutput("isInfoIP", true);
			 
		//startPortlet ('IP addresses');
		//echo "<table cellspacing=0 cellpadding='5' align='center' class='widetable'>\n";
		if (getConfigVar ('EXT_IPV4_VIEW') == 'yes')
			$mod->addOutput("isExt_ipv4_view", true);		 
		//	echo "<tr><th>OS interface</th><th>IP address</th><th>network</th><th>routed by</th><th>peers</th></tr>\n";
		//else
		//	echo "<tr><th>OS interface</th><th>IP address</th><th>peers</th></tr>\n";

		// group IP allocations by interface name instead of address family
		$allocs_by_iface = array();
		foreach (array ('ipv4', 'ipv6') as $ip_v)
			foreach ($info[$ip_v] as $ip_bin => $alloc)
				$allocs_by_iface[$alloc['osif']][$ip_bin] = $alloc;

		// sort allocs array by portnames
		$allPortsOut = array();
		foreach (sortPortList ($allocs_by_iface) as $iface_name => $alloclist)
		{
			$is_first_row = TRUE;
			foreach ($alloclist as $alloc)
			{
				$rendered_alloc = callHook ('getRenderedAlloc', $object_id, $alloc);
			
				$singlePort = array('tr_class' => $rendered_alloc['tr_class']);
			//	echo "<tr class='${rendered_alloc['tr_class']}' valign=top>";

				// display iface name, same values are grouped into single cell
				if ($is_first_row)
				{
					$rowspan = count ($alloclist) > 1 ? 'rowspan="' . count ($alloclist) . '"' : '';
					$firstRowMod = $tplm->generateModule('TDLeftCell', true, array(
						'rowspan' => $rowspan,
						'cont' => $iface_name . $rendered_alloc['td_name_suffix']));
					$singlePort['FristMod'] = $firstRowMod->run();
					//echo "<td class=tdleft $rowspan>" . $iface_name . $rendered_alloc['td_name_suffix'] . "</td>";
					$is_first_row = FALSE;
				}
				$singlePort['td_ip'] = $rendered_alloc['td_ip'];
				//echo $rendered_alloc['td_ip'];
				if (getConfigVar ('EXT_IPV4_VIEW') == 'yes')
				{
					$singlePort['td_network'] = $rendered_alloc['td_network'];
					$singlePort['td_routed_by'] = $rendered_alloc['td_routed_by'];
					//echo $rendered_alloc['td_network'];
					//echo $rendered_alloc['td_routed_by'];
				}
				$singlePort['td_peers'] = $rendered_alloc['td_peers'];
				//echo $rendered_alloc['td_peers'];

				//echo "</tr>\n";
				$allPortsOut[] = $singlePort;
			}
		}
		$mod->addOutput("allPorts", $allPortsOut);
			 
	//	echo "</table><br>\n";
	//	finishPortlet();
	}

	$forwards = $info['nat4'];
	if (count($forwards['in']) or count($forwards['out']))
	{
		$mod->addOutput("isForwarding", true);
			 
		//startPortlet('NATv4');

		if (count($forwards['out']))
		{
			$mod->addOutput("isFwdOut", true);
				 
			//echo "<h3>locally performed NAT</h3>";

			//echo "<table class='widetable' cellpadding=5 cellspacing=0 border=0 align='center'>\n";
			//echo "<tr><th>Proto</th><th>Match endpoint</th><th>Translate to</th><th>Target object</th><th>Rule comment</th></tr>\n";
			$allFwdsOut = array();
			foreach ($forwards['out'] as $pf)
			{
				
				$class = 'trerror';
				$osif = '';
				if (isset ($alloclist [$pf['localip']]))
				{
					$class = $alloclist [$pf['localip']]['addrinfo']['class'];
					$osif = $alloclist [$pf['localip']]['osif'] . ': ';
				}
				//cho "<tr class='$class'>";
				//echo "<td>${pf['proto']}</td><td class=tdleft>${osif}" . getRenderedIPPortPair ($pf['localip'], $pf['localport']) . "</td>";
				//echo "<td class=tdleft>" . getRenderedIPPortPair ($pf['remoteip'], $pf['remoteport']) . "</td>";
				$singleFwd = array('class' => $class, 'proto' => $pf['proto'], 'oisf' => $osif, 
					'rendLocalIP' => getRenderedIPPortPair ($pf['localip'], $pf['localport']),
					'rendRemoteIP' => getRenderedIPPortPair ($pf['remoteip'], $pf['remoteport']));
				$address = getIPAddress (ip4_parse ($pf['remoteip']));
				//echo "<td class='description'>";
				$singleFwd['mkAs'] = '';
				if (count ($address['allocs']))
					foreach($address['allocs'] as $bond)
						$singleFwd['mkAs'] .= mkA ("${bond['object_name']}(${bond['name']})", 'object', $bond['object_id']) . ' ';
				//		echo mkA ("${bond['object_name']}(${bond['name']})", 'object', $bond['object_id']) . ' ';

				elseif (strlen ($pf['remote_addr_name'])){
					$remoteAddrNameMod = $tplm->generateModule('RoundBracketsMod', true, array('cont' => $pf['remote_addr_name']));
					$singleFwd['RemAddrName'] = $remoteAddrNameMod->run();					
					//echo '(' . $pf['remote_addr_name'] . ')';
				}
				$singleFwd['description'] = $pf['description'];
				//echo "</td><td class='description'>${pf['description']}</td></tr>";
				$allFwdsOut[] = $singleFwd;
			}
			$mod->addOutput("allOutFwds", $allFwdsOut);
				 
			//echo "</table><br><br>";
		}

		if (count($forwards['in']))
		{
			$mod->addOutput("isFwdIn", true);
			//echo "<h3>arriving NAT connections</h3>";
			//echo "<table class='widetable' cellpadding=5 cellspacing=0 border=0 align='center'>\n";
			//echo "<tr><th>Matched endpoint</th><th>Source object</th><th>Translated to</th><th>Rule comment</th></tr>\n";
			
			$allFwdsOut = array();
			foreach ($forwards['in'] as $pf)
			{
				$singleFwd = array('proto' => $pf['proto'], 'description' => $pf['description'], 
					'mkA' => mkA ($pf['object_name'], 'object', $pf['object_id']),
					'rendLocalIP' => getRenderedIPPortPair ($pf['localip'], $pf['localport']),
					'rendRemoteIP' => getRenderedIPPortPair ($pf['remoteip'], $pf['remoteport']));
				//echo "<tr>";
				//echo "<td>${pf['proto']}/" . getRenderedIPPortPair ($pf['localip'], $pf['localport']) . "</td>";
				//echo '<td class="description">' . mkA ($pf['object_name'], 'object', $pf['object_id']);
				//echo "</td><td>" . getRenderedIPPortPair ($pf['remoteip'], $pf['remoteport']) . "</td>";
				//echo "<td class='description'>${pf['description']}</td></tr>";
				$allFwdsOut[] = $singleFwd;
			}
			$mod->addOutput("allInFwds", $allFwdsOut);
			//echo "</table><br><br>";
		}
		//finishPortlet();
	}

	//renderSLBTriplets2 ($info);
	//renderSLBTriplets ($info);
	renderSLBTriplets2 ($info, FALSE, NULL, $mod, "slbTriplet2");
	renderSLBTriplets ($info, $mod, "slbTriplet");
	//echo "</td>\n";

	// After left column we have (surprise!) right column with rackspace portlet only.
	//echo "<td class=pcright>";
	if (!in_array($info['objtype_id'], $virtual_obj_types))
	{
		$mod->addOutput("isRackspacePortlet", true);
			 
		// rackspace portlet
		//startPortlet ('rackspace allocation');
		foreach (getResidentRacksData ($object_id, FALSE) as $rack_id)
			//renderRack ($rack_id, $object_id);
			renderRack ($rack_id, $object_id, $mod, "renderedRackSpace");
		//echo '<br>';
		//finishPortlet();
	}
//	echo "</td></tr>";
//	echo "</table>\n";
}

function renderRackMultiSelect ($sname, $racks, $selected, $parent = null, $placeholder = "rackMultiSelect")
{
	// Transform the given flat list into a list of groups, each representing a rack row.
	$rdata = array();
	foreach ($racks as $rack)
	{
		$trail = getLocationTrail ($rack['location_id'], FALSE);
		if(!empty ($trail))
			$row_name = $trail . ' : ' . $rack['row_name'];
		else
			$row_name = $rack['row_name'];
		$rdata[$row_name][$rack['id']] = $rack['name'];
	}
	
	$tplm = TemplateManager::getInstance();
	//$tplm->createMainModule();
	if($parent==null)	
		$mod = $tplm->generateModule("RenderRackMultiSelect");
	else
		$mod = $tplm->generateSubmodule($placeholder, "RenderRackMultiSelect", $parent);
	
	$mod->setNamespace("object");
	$mod->addOutput("sname", $sname);
	$mod->addOutput("maxselsize", getConfigVar ('MAXSELSIZE'));

	//echo "<select name=${sname} multiple size=" . getConfigVar ('MAXSELSIZE') . " onchange='getElementsByName(\"updateObjectAllocation\")[0].submit()'>\n";
	
	$row_names = array_keys ($rdata);
	natsort ($row_names);
	$allRowDataOut = array();
	foreach ($row_names as $optgroup)
	{
	//	echo "<optgroup label='${optgroup}'>";
		$singleOptGroup = array('GroupLabel' => $optgroup);
		$singleOptGroup['RackEntries'] = '';
		foreach ($rdata[$optgroup] as $rack_id => $rack_name)
		{
			$singleOptGroup['RackEntries'] .= $tplm->generateModule('StdOptionTemplate', true, 
					array(	'RackId' => $rack_id,
							'IsSelected' => ((array_search ($rack_id, $selected) === FALSE) ? '' : 'selected'),
							'RackName' => $rack_name))->run();	
		//	echo "<option value=${rack_id}";
		//	if (!(array_search ($rack_id, $selected) === FALSE))		
		//		echo ' selected';
		//	echo">${rack_name}</option>\n";
		}
		$allRowDataOut[] = $singleOptGroup;
	}

	$mod->addOutput("allRowData", $allRowDataOut);
		 
	//echo "</select>\n";
	if($parent==null)
		return $mod->run();
}

// This function renders a form for port edition.
function renderPortsForObject ($object_id)
{
	$prefs = getPortListPrefs();
	function printNewItemTR ($prefs, $parent, $placeholder)
	{
		$tplm = TemplateManager::getInstance();
		//$tplm->setTemplate("vanilla");
		//$tplm->createMainModule("index");
		
		$mod = $tplm->generateSubmodule($placeholder,"RenderPortsForObject_printNew", $parent);
		$mod->setNamespace("object");
			
	//	printOpFormIntro ('addPort');
	//	echo "<tr><td>";
	//	printImageHREF ('add', 'add a port', TRUE);
	//	echo "</td><td class='tdleft'><input type=text size=8 name=port_name tabindex=100></td>\n";
	//	echo "<td><input type=text name=port_label tabindex=101></td><td>";
		printNiftySelect (getNewPortTypeOptions(), array ('name' => 'port_type_id', 'tabindex' => 102), $prefs['selected'], false, $mod, "niftySel");
	//	echo "<td><input type=text name=port_l2address tabindex=103 size=18 maxlength=24></td>\n";
	//	echo "<td colspan=4>&nbsp;</td><td>";
	//	printImageHREF ('add', 'add a port', TRUE, 104);
	//	echo "</td></tr></form>";
	}
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderPortsForObject");
	$mod->setNamespace("object");

	if (getConfigVar('ENABLE_MULTIPORT_FORM') == 'yes' || getConfigVar('ENABLE_BULKPORT_FORM') == 'yes' )
		$mod->setOutput("isEnableMultiport", true);
			 
	//	startPortlet ('Ports and interfaces');
	//else
	//	echo '<br>';
	$object = spotEntity ('object', $object_id);
	amplifyCell ($object);
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes' && getConfigVar('ENABLE_BULKPORT_FORM') == 'yes'){
		$mod->addOutput("isAddnewTop", true);
			 
		/*echo "<table cellspacing=0 cellpadding='5' align='center' class='widetable'>\n";
		echo "<tr><th>&nbsp;</th><th class=tdleft>Local name</th><th class=tdleft>Visible label</th><th class=tdleft>Interface</th><th class=tdleft>Start Number</th>";
		echo "<th class=tdleft>Count</th><th>&nbsp;</th></tr>\n";
		printOpFormIntro ('addBulkPorts');
		echo "<tr><td>";
		printImageHREF ('add', 'add ports', TRUE);
		echo "</td><td><input type=text size=8 name=port_name tabindex=105></td>\n";
		echo "<td><input type=text name=port_label tabindex=106></td><td>";*/
		printNiftySelect (getNewPortTypeOptions(), array ('name' => 'port_type_id', 'tabindex' => 107), $prefs['selected'], false, $mod, 'niftySelAddNewT');
		/*echo "<td><input type=text name=port_numbering_start tabindex=108 size=3 maxlength=3></td>\n";
		echo "<td><input type=text name=port_numbering_count tabindex=109 size=3 maxlength=3></td>\n";
		echo "<td>&nbsp;</td><td>";
		printImageHREF ('add', 'add ports', TRUE, 110);
		echo "</td></tr></form>";
		echo "</table><br>\n";*/
	}

	//echo "<table cellspacing=0 cellpadding='5' align='center' class='widetable'>\n";
	//echo "<tr><th>&nbsp;</th><th class=tdleft>Local name</th><th class=tdleft>Visible label</th><th class=tdleft>Interface</th><th class=tdleft>L2 address</th>";
	//echo "<th class=tdcenter colspan=2>Remote object and port</th><th>Cable ID</th><th class=tdcenter>(Un)link or (un)reserve</th><th>&nbsp;</th></tr>\n";
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
		printNewItemTR ($prefs, $mod, "AddNewTopMod");
	//	printNewItemTR ($prefs);

	// clear ports link
	//echo getOpLink (array ('op'=>'deleteAll'), 'Clear port list', 'clear', '', 'need-confirmation');
	getOpLink (array ('op'=>'deleteAll'), 'Clear port list', 'clear', '', 'need-confirmation', $mod, 'clearPortLink');

	if (isset ($_REQUEST['hl_port_id']))
	{
		assertUIntArg ('hl_port_id');
		$hl_port_id = intval ($_REQUEST['hl_port_id']);
		addAutoScrollScript ("port-$hl_port_id");
	}
	switchportInfoJS ($object_id, $mod, 'switchPortJS'); // load JS code to make portnames interactive
	
	foreach ($object['ports'] as $port)
	{
		$tr_class = isset ($hl_port_id) && $hl_port_id == $port['id'] ? 'class="highlight"' : '';
		$singlePort = array('port_id' => $port['id'], 'href_process' => makeHrefProcess(array('op'=>'delPort', 'port_id'=>$port['id'])),
						'port_name' => $port['name'], 'port_label' => $port['label'], 'tr_class' => $tr_class);
		
		//printOpFormIntro ('editPort', array ('port_id' => $port['id']));
		//echo "<tr $tr_class><td><a name='port-${port['id']}' href='".makeHrefProcess(array('op'=>'delPort', 'port_id'=>$port['id']))."'>";
		//printImageHREF ('delete', 'Unlink and Delete this port');
		//echo "</a></td>\n";
		$singlePort['opFormIntro'] = printOpFormIntro ('editPort', array ('port_id' => $port['id']));
		$singlePort['deleteImg'] = printImageHREF ('delete', 'Unlink and Delete this port');
		$a_class = isEthernetPort ($port) ? 'port-menu' : '';
		//echo "<td class='tdleft' NOWRAP><input type=text name=name class='interactive-portname $a_class' value='${port['name']}' size=8></td>";
		//echo "<td><input type=text name=label value='${port['label']}'></td>";
		//echo '<td>';
		$singlePort['a_class'] = $a_class;
		if ($port['iif_id'] != 1)
			$singlePort['iif_name'] = $port['iif_name'];
		//	echo '<label>' . $port['iif_name'] . ' ';
		//printSelect (getExistingPortTypeOptions ($port['id']), array ('name' => 'port_type_id'), $port['oif_id']);
		$singlePort['printSelExType'] = printSelect (getExistingPortTypeOptions ($port['id']), array ('name' => 'port_type_id'), $port['oif_id'], false);
		//if ($port['iif_id'] != 1)
		//	echo '</label>';
		//echo '</td>';

		// 18 is enough to fit 6-byte MAC address in its longest form,
		// while 24 should be Ok for WWN
		$singlePort['l2address'] = $port['l2address'];
		//echo "<td><input type=text name=l2address value='${port['l2address']}' size=18 maxlength=24></td>\n";
		if ($port['remote_object_id'])
		{
			$singlePort['isRemoteObj'] = true;
			$singlePort['logged_span_rem_obj_id'] = formatLoggedSpan ($port['last_log'], formatPortLink ($port['remote_object_id'], $port['remote_object_name'], $port['remote_id'], NULL));
			$singlePort['logged_span_rem_name'] = formatLoggedSpan ($port['last_log'], $port['remote_name'], 'underline');
			$singlePort['cableid'] = $port['cableid']; 
			//echo "<td>" .
			//	formatLoggedSpan ($port['last_log'], formatPortLink ($port['remote_object_id'], $port['remote_object_name'], $port['remote_id'], NULL)) .
			//	"</td>";
			//echo "<td> " . formatLoggedSpan ($port['last_log'], $port['remote_name'], 'underline') .
			//	"<input type=hidden name=reservation_comment value=''></td>";
			//echo "<td><input type=text name=cable value='${port['cableid']}'></td>";
			//echo "<td class=tdcenter>";
			$singlePort['unlink_op_link'] = getOpLink (array('op'=>'unlinkPort', 'port_id'=>$port['id'], ), '', 'cut', 'Unlink this port');
			//echo getOpLink (array('op'=>'unlinkPort', 'port_id'=>$port['id'], ), '', 'cut', 'Unlink this port');
			//echo "</td>";
		}
		elseif (strlen ($port['reservation_comment']))
		{
			$singlePort['hasReservation_comment'] = true;
			$singlePort['logged_span_rem_reserved'] = formatLoggedSpan ($port['last_log'], 'Reserved:', 'strong underline');
			$singlePort['reservation_comment'] = $port['reservation_comment'];
			//echo "<td>" . formatLoggedSpan ($port['last_log'], 'Reserved:', 'strong underline') . "</td>";
			//echo "<td><input type=text name=reservation_comment value='${port['reservation_comment']}'></td>";
			//echo "<td></td>";
			//echo "<td class=tdcenter>";
			//echo getOpLink (array('op'=>'useup', 'port_id'=>$port['id']), '', 'clear', 'Use up this port');
			$singlePort['use_up_op_link'] = getOpLink (array('op'=>'useup', 'port_id'=>$port['id']), '', 'clear', 'Use up this port');
			//echo "</td>";
		}
		else
		{
			
			$in_rack = getConfigVar ('NEAREST_RACKS_CHECKBOX');
			//echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td class=tdcenter><span";
			$helper_args = array
			(
				'port' => $port['id'],
				'in_rack' => ($in_rack == "yes" ? "on" : "")
			);
			$singlePort['href_helper_portlist'] = makeHrefForHelper ('portlist', $helper_args);
			/*$popup_args = 'height=700, width=400, location=no, menubar=no, '.
				'resizable=yes, scrollbars=yes, status=no, titlebar=no, toolbar=no';
			echo " ondblclick='window.open(\"" . makeHrefForHelper ('portlist', $helper_args);
			echo "\",\"findlink\",\"${popup_args}\");'";
			// end of onclick=
			echo " onclick='window.open(\"" . makeHrefForHelper ('portlist', $helper_args);
			echo "\",\"findlink\",\"${popup_args}\");'";
			// end of onclick=
			echo '>';*/
			// end of <a>
			//printImageHREF ('plug', 'Link this port');
			$singlePort['link_img'] = printImageHREF ('plug', 'Link this port');
			//echo "</span>";
			//echo " <input type=text name=reservation_comment></td>\n";
		}
		//echo "<td>";
		$singlePort['save_img'] = printImageHREF ('save', 'Save changes', TRUE);
		//echo "</td></form></tr>\n";
		$singlePortMod = $tplm->generateSubmodule('singlePorts', 'RenderPortsForObject_SinglePort', $mod, false, $singlePort);
		$singlePortMod->setNamespace('object');
	}
	

	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
		//printNewItemTR ($prefs);
		printNewItemTR ($prefs, $mod, 'AddNewTopMod2');
	//echo "</table><br>\n";
	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes' && getConfigVar('ENABLE_BULKPORT_FORM') == 'yes'){
		$mod->addOutput("isBulkportForm", true);
		/*	 
		echo "<table cellspacing=0 cellpadding='5' align='center' class='widetable'>\n";
		echo "<tr><th>&nbsp;</th><th class=tdleft>Local name</th><th class=tdleft>Visible label</th><th class=tdleft>Interface</th><th class=tdleft>Start Number</th>";
		echo "<th class=tdleft>Count</th><th>&nbsp;</th></tr>\n";
		printOpFormIntro ('addBulkPorts');
		echo "<tr><td>";
		printImageHREF ('add', 'add ports', TRUE);
		echo "</td><td><input type=text size=8 name=port_name tabindex=105></td>\n";
		echo "<td><input type=text name=port_label tabindex=106></td><td>";
		printNiftySelect (getNewPortTypeOptions(), array ('name' => 'port_type_id', 'tabindex' => 107), $prefs['selected']);*/
		printNiftySelect (getNewPortTypeOptions(), array ('name' => 'port_type_id', 'tabindex' => 107), $prefs['selected'], false, $mod, 'bulkPortsNiftySel');
		/*echo "<td><input type=text name=port_numbering_start tabindex=108 size=3 maxlength=3></td>\n";
		echo "<td><input type=text name=port_numbering_count tabindex=109 size=3 maxlength=3></td>\n";
		echo "<td>&nbsp;</td><td>";
		printImageHREF ('add', 'add ports', TRUE, 110);
		echo "</td></tr></form>";
		echo "</table><br>\n";*/
	}
	//if (getConfigVar('ENABLE_MULTIPORT_FORM') == 'yes')
	//	finishPortlet();
	if (getConfigVar('ENABLE_MULTIPORT_FORM') == 'yes'){
		$mod->addOutput("isShowAddMultiPorts", true);
	}
	else{
		$mod->addOutput("isShowAddMultiPorts", false);
		return;
	}

	/*
	startPortlet ('Add/update multiple ports');
	printOpFormIntro ('addMultiPorts');
	echo 'Format: <select name=format tabindex=201>';
	echo '<option value=c3600asy>Cisco 3600 async: sh line | inc TTY</option>';
	echo '<option value=fiwg selected>Foundry ServerIron/FastIron WorkGroup/Edge: sh int br</option>';
	echo '<option value=fisxii>Foundry FastIron SuperX/II4000: sh int br</option>';
	echo '<option value=ssv1>SSV:&lt;interface name&gt; &lt;MAC address&gt;</option>';
	echo "</select>";
	echo 'Default port type: ';
	printNiftySelect (getNewPortTypeOptions(), array ('name' => 'port_type', 'tabindex' => 202), $prefs['selected']);*/
	printNiftySelect (getNewPortTypeOptions(), array ('name' => 'port_type', 'tabindex' => 202), $prefs['selected'], false, $mod, 'portTypeNiftySel');
	/*echo "<input type=submit value='Parse output' tabindex=204><br>\n";
	echo "<textarea name=input cols=100 rows=50 tabindex=203></textarea><br>\n";
	echo '</form>';
	finishPortlet();*/
}

function renderIPForObject ($object_id)
{
	function printNewItemTR ($default_type, $parent, $placeholder)
	{
		global $aat;
		$tplm = TemplateManager::getInstance();
		//$tplm->setTemplate("vanilla");
		
		$mod = $tplm->generateSubmodule($placeholder,"RenderIPForObject_printNew", $parent);
		$mod->setNamespace("object");
			
		/*printOpFormIntro ('add');
		echo "<tr><td>"; // left btn
		printImageHREF ('add', 'allocate', TRUE);
		echo "</td>";
		echo "<td class=tdleft><input type='text' size='10' name='bond_name' tabindex=100></td>\n"; // if-name
		echo "<td class=tdleft><input type=text name='ip' tabindex=101></td>\n"; // IP*/
		if (getConfigVar ('EXT_IPV4_VIEW') == 'yes')
			$mod->addOutput("isExt_ipv4", true);
		/*		 
		//	echo "<td colspan=2>&nbsp;</td>"; // network, routed by
		echo '<td>';
		printSelect ($aat, array ('name' => 'bond_type', 'tabindex' => 102), $default_type); // type */
		printSelect ($aat, array ('name' => 'bond_type', 'tabindex' => 102), $default_type, $mod, "bondPrintSel"); // type
		/*echo "</td><td>&nbsp;</td><td>"; // misc
		printImageHREF ('add', 'allocate', TRUE, 103); // right btn
		echo "</td></tr></form>";*/
	}
	global $aat;

	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderIPForObject");
	$mod->setNamespace("object");
		

	/*startPortlet ('Allocations');
	echo "<table cellspacing=0 cellpadding='5' align='center' class='widetable'><tr>\n";
	echo '<th>&nbsp;</th>';
	echo '<th>OS interface</th>';
	echo '<th>IP address</th>';*/
	if (getConfigVar ('EXT_IPV4_VIEW') == 'yes')
	{
		$mod->addOutput("isExt_ipv4", true);	 
	//	echo '<th>network</th>';
	//	echo '<th>routed by</th>';
	}
	/*echo '<th>type</th>';
	echo '<th>misc</th>';
	echo '<th>&nbsp</th>';
	echo '</tr>';*/

	$alloc_list = ''; // most of the output is stored here
	$used_alloc_types = array();
	foreach (getObjectIPAllocations ($object_id) as $alloc)
	{
		if (! isset ($used_alloc_types[$alloc['type']]))
			$used_alloc_types[$alloc['type']] = 0;
		$used_alloc_types[$alloc['type']]++;

		$rendered_alloc = callHook ('getRenderedAlloc', $object_id, $alloc);
		
		$alloc_elem_mod = $tplm->generateSubmodule("alloc_elems", "RenderIPForObject_Alloc_Element", $mod);
		$alloc_elem_mod->setNamespace('object');
		$alloc_elem_mod->setOutput('addrinfo_ip', $alloc['addrinfo']['ip']);
		//$alloc_list .= getOutputOf ('printOpFormIntro', 'upd', array ('ip' => $alloc['addrinfo']['ip']));
		
		//$alloc_list .= "<tr class='${rendered_alloc['tr_class']}' valign=top>";
		$alloc_elem_mod->setOutput('tr_class', $rendered_alloc['tr_class']);

		//$alloc_list .= "<td>" . getOpLink (array ('op' => 'del', 'ip' => $alloc['addrinfo']['ip']), '', 'delete', 'Delete this IP address') . "</td>";
		//$alloc_list .= "<td class=tdleft><input type='text' name='bond_name' value='${alloc['osif']}' size=10>" . $rendered_alloc['td_name_suffix'] . "</td>";
		$alloc_elem_mod->setOutput('td_name_suffix', $rendered_alloc['td_name_suffix']);
		$alloc_elem_mod->setOutput('osif', $alloc['osif']);
		$alloc_elem_mod->setOutput('td_ip', $rendered_alloc['td_ip']);
		//$alloc_list .= $rendered_alloc['td_ip'];
		if (getConfigVar ('EXT_IPV4_VIEW') == 'yes')
		{
			$alloc_elem_mod->setOutput('isExt_ipv4', true);
			$alloc_elem_mod->setOutput('td_network', $rendered_alloc['td_network']);
			$alloc_elem_mod->setOutput('td_routed_by', $rendered_alloc['td_routed_by']);
			//$alloc_list .= $rendered_alloc['td_network'];
			//$alloc_list .= $rendered_alloc['td_routed_by'];
		}
		//$alloc_list .= '<td>' . getSelect ($aat, array ('name' => 'bond_type'), $alloc['type']) . "</td>";
		printSelect($aat, array ('name' => 'bond_type'), $alloc['type'], $alloc_elem_mod, 'bond_type_mod');
		//$alloc_list .= $rendered_alloc['td_peers'];
		$alloc_elem_mod->setOutput('td_peers', $rendered_alloc['td_peers']);
		//$alloc_list .= "<td>" .getImageHREF ('save', 'Save changes', TRUE) . "</td>";

		//$alloc_list .= "</form></tr>\n";
	}
	asort ($used_alloc_types, SORT_NUMERIC);
	$most_popular_type = empty ($used_alloc_types) ? 'regular' : array_last (array_keys ($used_alloc_types));

	if ($list_on_top = (getConfigVar ('ADDNEW_AT_TOP') != 'yes'))
		$mod->addOutput("isAddNewOnTop", true);	 
		//	echo $alloc_list;
	printNewItemTR ($most_popular_type, $mod, 'printNewItemTR_mod');
	//if (! $list_on_top)
	//	echo $alloc_list;

	//echo "</table><br>\n";
	//finishPortlet();
}

// This function is deprecated. Do not rely on its internals,
// it will probably be removed in the next major relese.
// Use new showError, showWarning, showSuccess functions.
// Log array is stored in global $log_messages. Its format is simple: plain ordered array
// with values having keys 'c' (both message code and severity) and 'a' (sprintf arguments array)
function showMessageOrError ($tpl = false)
{
	global $log_messages;

	@session_start();
	if (isset ($_SESSION['log']))
	{
		$log_messages = array_merge ($_SESSION['log'], $log_messages);
		unset ($_SESSION['log']);
	}
	session_commit();

	if (empty ($log_messages))
		return;
	$msginfo = array
	(
// records 0~99 with success messages
		0 => array ('code' => 'success', 'format' => '%s'),
		5 => array ('code' => 'success', 'format' => 'added record "%s" successfully'),
		6 => array ('code' => 'success', 'format' => 'updated record "%s" successfully'),
		7 => array ('code' => 'success', 'format' => 'deleted record "%s" successfully'),
		8 => array ('code' => 'success', 'format' => 'Port %s successfully linked with %s'),
		10 => array ('code' => 'success', 'format' => 'Added %u ports, updated %u ports, encountered %u errors.'),
		21 => array ('code' => 'success', 'format' => 'Generation complete'),
		26 => array ('code' => 'success', 'format' => 'updated %u records successfully'),
		37 => array ('code' => 'success', 'format' => 'added %u records successfully'),
		38 => array ('code' => 'success', 'format' => 'removed %u records successfully'),
		43 => array ('code' => 'success', 'format' => 'Saved successfully.'),
		44 => array ('code' => 'success', 'format' => '%s failures and %s successfull changes.'),
		48 => array ('code' => 'success', 'format' => 'added a record successfully'),
		49 => array ('code' => 'success', 'format' => 'deleted a record successfully'),
		51 => array ('code' => 'success', 'format' => 'updated a record successfully'),
		57 => array ('code' => 'success', 'format' => 'Reset complete'),
		63 => array ('code' => 'success', 'format' => '%u change request(s) have been processed'),
		67 => array ('code' => 'success', 'format' => "Tag rolling done, %u objects involved"),
		71 => array ('code' => 'success', 'format' => 'File "%s" was linked successfully'),
		72 => array ('code' => 'success', 'format' => 'File was unlinked successfully'),
		82 => array ('code' => 'success', 'format' => "Bulk port creation was successful. %u ports created, %u failed"),
		87 => array ('code' => 'success', 'format' => '802.1Q recalculate: %d ports changed on %d switches'),
// records 100~199 with fatal error messages
		100 => array ('code' => 'error', 'format' => '%s'),
		109 => array ('code' => 'error', 'format' => 'failed updating a record'),
		131 => array ('code' => 'error', 'format' => 'invalid format requested'),
		141 => array ('code' => 'error', 'format' => 'Encountered %u errors, updated %u record(s)'),
		149 => array ('code' => 'error', 'format' => 'Turing test failed'),
		150 => array ('code' => 'error', 'format' => 'Can only change password under DB authentication.'),
		151 => array ('code' => 'error', 'format' => 'Old password doesn\'t match.'),
		152 => array ('code' => 'error', 'format' => 'New passwords don\'t match.'),
		154 => array ('code' => 'error', 'format' => "Verification error: %s"),
		155 => array ('code' => 'error', 'format' => 'Save failed.'),
		159 => array ('code' => 'error', 'format' => 'Permission denied moving port %s from VLAN%u to VLAN%u'),
		161 => array ('code' => 'error', 'format' => 'Endpoint not found. Please either set FQDN attribute or assign an IP address to the object.'),
		162 => array ('code' => 'error', 'format' => 'More than one IP address is assigned to this object, please configure FQDN attribute.'),
		170 => array ('code' => 'error', 'format' => 'There is no network for IP address "%s"'),
		172 => array ('code' => 'error', 'format' => 'Malformed request'),
		179 => array ('code' => 'error', 'format' => 'Expired form has been declined.'),
		188 => array ('code' => 'error', 'format' => "Fatal SNMP failure"),
		189 => array ('code' => 'error', 'format' => "Unknown OID '%s'"),
		191 => array ('code' => 'error', 'format' => "deploy was blocked due to conflicting configuration versions"),

// records 200~299 with warnings
		200 => array ('code' => 'warning', 'format' => '%s'),
		201 => array ('code' => 'warning', 'format' => 'nothing happened...'),
		206 => array ('code' => 'warning', 'format' => '%s is not empty'),
		207 => array ('code' => 'warning', 'format' => 'File upload failed, error: %s'),

// records 300~399 with notices
		300 => array ('code' => 'neutral', 'format' => '%s'),

	);
	
	$tplm = TemplateManager::getInstance();
	// Handle the arguments. Is there any better way to do it?
	foreach ($log_messages as $record)
	{
		if (!isset ($record['c']) or !isset ($msginfo[$record['c']]))
		{
			$prefix = isset ($record['c']) ? $record['c'] . ': ' : '';
			if ($tpl)
			{
				$tplm->generateSubmodule("Message","MessageNeutral",null,true,array("Message"=>"(${prefix}this message was lost)"));
			}
			else
			{ //@TODO Remove old version, use template engine instead
				echo "<div class=msg_neutral>(${prefix}this message was lost)</div>";
			}
			continue;
		}
		if (isset ($record['a']))
			switch (count ($record['a']))
			{
				case 1:
					$msgtext = sprintf
					(
						$msginfo[$record['c']]['format'],
						$record['a'][0]
					);
					break;
				case 2:
					$msgtext = sprintf
					(
						$msginfo[$record['c']]['format'],
						$record['a'][0],
						$record['a'][1]
					);
					break;
				case 3:
					$msgtext = sprintf
					(
						$msginfo[$record['c']]['format'],
						$record['a'][0],
						$record['a'][1],
						$record['a'][2]
					);
					break;
				case 4:
				default:
					$msgtext = sprintf
					(
						$msginfo[$record['c']]['format'],
						$record['a'][0],
						$record['a'][1],
						$record['a'][2],
						$record['a'][3]
					);
					break;
			}
		else
			$msgtext = $msginfo[$record['c']]['format'];
		if ($tpl)
		{
			$modname = "Message" . ucfirst($msginfo[$record['c']]['code']);
			$tplm->generateSubmodule("Message",$modname,null,true,array("Message"=>$msgtext));
		}
		else 
		{ // @TODO Remove old version, use TEmplate Engine instead
			echo '<div class=msg_' . $msginfo[$record['c']]['code'] . ">${msgtext}</div>";
		}
	}
	$log_messages = array();
}

// renders two tables: port link status and learned MAC list
function renderPortsInfo($object_id)
{
	try
	{
		if (permitted (NULL, NULL, 'get_link_status'))
			$linkStatus = queryDevice ($object_id, 'getportstatus');
		else
			showWarning ("You don't have permission to view ports link status");

		if (permitted (NULL, NULL, 'get_mac_list'))
			$macList = sortPortList (queryDevice ($object_id, 'getmaclist'));
		else
			showWarning ("You don't have permission to view learned MAC list");
	}
	catch (RTGatewayError $e)
	{
		showError ($e->getMessage());
		return;
	}

	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderPortsInfo");
	$mod->setNamespace("object");
		

	global $nextorder;
	//echo "<table width='100%'><tr>";
	if (! empty ($linkStatus))
	{
		$mod->addOutput("isLinkStatus", true);
			 
		/*echo "<td valign='top' width='50%'>";
		startPortlet('Link status');
		echo "<table width='80%' class='widetable' cellspacing=0 cellpadding='5px' align='center'><tr><th>Port<th><th>Link status<th>Link info</tr>";
		*/
		$order = 'even';
		$allLinkStatusOut = array();
		foreach ($linkStatus as $pn => $link)
		{
			switch ($link['status'])
			{
				case 'up':
					$img_filename = 'link-up.png';
					break;
				case 'down':
					$img_filename = 'link-down.png';
					break;
				case 'disabled':
					$img_filename = 'link-disabled.png';
					break;
				default:
					$img_filename = '1x1t.gif';
			}
			$singleLinkStatus = array('order' => $order, 'img_filename' => $img_filename, 'pn' => $pn,
								'linkStatus' => $link['status'] );
			//echo "<tr class='row_$order'>";
			$order = $nextorder[$order];
			/*echo '<td>' . $pn;
			echo '<td>' . '<img width=16 height=16 src="?module=chrome&uri=pix/' . $img_filename . '">';
			echo '<td>' . $link['status']; */
			$info = '';
			if (isset ($link['speed']))
				$info .= $link['speed'];
			if (isset ($link['duplex']))
			{
				if (! empty ($info))
					$info .= ', ';
				$info .= $link['duplex'];
			}
			$singleLinkStatus['info'] = $info;
			//echo '<td>' . $info;
			//echo '</tr>';
			$allLinkStatusOut[] = $singleLinkStatus;
		}
		$mod->addOutput("allLinkStatus", $allLinkStatusOut);
			 
		//echo "</table></td>";
		//finishPortlet();
	}


	if (! empty ($macList))
	{
		$mod->addOutput("hasMacList", true);
			 
		//echo "<td valign='top' width='50%'>";
		$rendered_macs = '';
		$mac_count = 0;
		//$rendered_macs .=  "<table width='80%' class='widetable' cellspacing=0 cellpadding='5px' align='center'><tr><th>MAC<th>Vlan<th>Port</tr>";
		$order = 'even';
		$allMacsOut = array();
		foreach ($macList as $pn => $list)
		{
			$order = $nextorder[$order];
			foreach ($list as $item)
			{
				++$mac_count;
				$allMacsOut[] = array('item' => $item['mac'], 'vid' => $item['vid'], 'pn' => $pn, 'order' => $order);
				/*$rendered_macs .= "<tr class='row_$order'>";
				$rendered_macs .= '<td style="font-family: monospace">' . $item['mac'];
				$rendered_macs .= '<td>' . $item['vid'];
				$rendered_macs .= '<td>' . $pn;
				$rendered_macs .= '</tr>'; */
			}
		}
		$mod->addOutput("allMacs", $allMacsOut);
			 
		//$rendered_macs .= "</table></td>";
		$mod->addOutput("macCount", $mac_count);
			 
		//startPortlet("Learned MACs ($mac_count)");
		//echo $rendered_macs;
		//finishPortlet();
	}

	//echo "</td></tr></table>";
}

/*
The following conditions must be met:
1. We can mount onto free atoms only. This means: if any record for an atom
already exists in RackSpace, it can't be used for mounting.
2. We can't unmount from 'W' atoms. Operator should review appropriate comments
and either delete them before unmounting or refuse to unmount the object.
*/
function renderRackSpaceForObject ($object_id)
{
	// Always process occupied racks plus racks chosen by user. First get racks with
	// already allocated rackspace...
	$workingRacksData = getResidentRacksData ($object_id);
	// ...and then add those chosen by user (if any).
	if (isset($_REQUEST['rackmulti']))
		foreach ($_REQUEST['rackmulti'] as $cand_id)
			if (!isset ($workingRacksData[$cand_id]))
			{
				$rackData = spotEntity ('rack', $cand_id);
				amplifyCell ($rackData);
				$workingRacksData[$cand_id] = $rackData;
			}

	// Get a list of all of this object's parents,
	// then trim the list to only include parents that are racks
	$objectParents = getEntityRelatives('parents', 'object', $object_id);
	$parentRacks = array();
	foreach ($objectParents as $parentData)
		if ($parentData['entity_type'] == 'rack')
			$parentRacks[] = $parentData['entity_id'];

	$tplm = TemplateManager::getInstance();
	
	$mod = $tplm->generateSubmodule("Payload","RenderRackSpaceForObject");
	$mod->setNamespace("object");
		

	// Main layout starts.
	//echo "<table border=0 class=objectview cellspacing=0 cellpadding=0><tr>";

	// Left portlet with rack list.
	//echo "<td class=pcleft height='1%'>";
	//startPortlet ('Racks');
	$allRacksData = listCells ('rack');

	// filter rack list to match only racks having common tags with the object (reducing $allRacksData)
	if (! isset ($_REQUEST['show_all_racks']) and getConfigVar ('FILTER_RACKLIST_BY_TAGS') == 'yes')
	{
		$matching_racks = array();
		$object = spotEntity ('object', $object_id);
		$matched_tags = array();
		foreach ($allRacksData as $rack)
			foreach ($object['etags'] as $tag)
				if (tagOnChain ($tag, $rack['etags']) or tagOnChain ($tag, $rack['itags']))
				{
					$matching_racks[$rack['id']] = $rack;
					$matched_tags[$tag['id']] = $tag;
					break;
				}
		// add current object's racks even if they dont match filter
		foreach ($workingRacksData as $rack_id => $rack)
			if (! isset ($matching_racks[$rack_id]))
				$matching_racks[$rack_id] = $rack;
		// if matching racks found, and rack list is reduced, show 'show all' link
		if (count ($matching_racks) and count ($matching_racks) != count ($allRacksData))
		{
			$filter_text = '';
			foreach ($matched_tags as $tag)
				$filter_text .= (empty ($filter_text) ? '' : ' or ') . '{' . $tag['tag'] . '}';
			$href_show_all = trim($_SERVER['REQUEST_URI'], '&');
			$href_show_all .= htmlspecialchars('&show_all_racks=1');
			$mod->addOutput("isShowAllAndMatching", true);
			$mod->addOutput("filter_text", $filter_text);
			$mod->addOutput("href_show_all", $href_show_all);
				 	 	 
			//echo "(filtered by <span class='filter-text'>$filter_text</span>, <a href='$href_show_all'>show all</a>)<p>";
			$allRacksData = $matching_racks;
		}
	}

	if (count ($allRacksData) <= getConfigVar ('RACK_PRESELECT_THRESHOLD'))
		foreach ($allRacksData as $rack)
			if (!array_key_exists ($rack['id'], $workingRacksData))
			{
				amplifyCell ($rack);
				$workingRacksData[$rack['id']] = $rack;
			}
	foreach (array_keys ($workingRacksData) as $rackId)
		applyObjectMountMask ($workingRacksData[$rackId], $object_id);
	//printOpFormIntro ('updateObjectAllocation');
	renderRackMultiSelect ('rackmulti[]', $allRacksData, array_keys ($workingRacksData), $mod, "RackMultiSet");
	//echo "<br><br>";
	//finishPortlet();
	//echo "</td>";

	// Middle portlet with comment and submit.
	//echo "<td class=pcleft>";
	//startPortlet ('Comment (for Rackspace History)');
	//echo "<textarea name=comment rows=10 cols=40></textarea><br>\n";
	//echo "<input type=submit value='Save' name=got_atoms>\n";
	//echo "<br><br>";
	//finishPortlet();
	//echo "</td>";

	// Right portlet with rendered racks. If this form submit is not final, we have to
	// reflect the former state of the grid in current form.
	//echo "<td class=pcright rowspan=2 height='1%'>";
	//startPortlet ('Working copy');
	includeJQueryUI (false, $mod, 'jquery_code');
	//addJS ('js/racktables.js');
	//addJS ('js/bulkselector.js');
	//echo '<table border=0 cellspacing=10 align=center><tr>';
	$allWorkingDataOut = array();
	foreach ($workingRacksData as $rack_id => $rackData)
	{

		// Order is important here: only original allocation is highlighted.
		highlightObject ($rackData, $object_id);
		markupAtomGrid ($rackData, 'T');
		// If we have a form processed, discard user input and show new database
		// contents.
		if (isset ($_REQUEST['rackmulti'][0])) // is an update
			mergeGridFormToRack ($rackData);

		$singleDataSet = array('name' => $rackData['name'],
							'rack_id' => $rack_id, 
							'height' => $rackData['height'],
							'AtomGrid' => renderAtomGrid ($rackData) );
		/*echo "<td valign=top>";
		echo "<center>\n<h2>${rackData['name']}</h2>\n";
		echo "<table class=rack id=selectableRack border=0 cellspacing=0 cellpadding=1>\n";
		echo "<tr><th width='10%'>&nbsp;</th>";
		echo "<th width='20%'><a href='javascript:;' onclick=\"toggleColumnOfAtoms('${rack_id}', '0', ${rackData['height']})\">Front</a></th>";
		echo "<th width='50%'><a href='javascript:;' onclick=\"toggleColumnOfAtoms('${rack_id}', '1', ${rackData['height']})\">Interior</a></th>";
		echo "<th width='20%'><a href='javascript:;' onclick=\"toggleColumnOfAtoms('${rack_id}', '2', ${rackData['height']})\">Back</a></th></tr>\n";*/
		//renderAtomGrid ($rackData);
		/*echo "<tr><th width='10%'>&nbsp;</th>";
		echo "<th width='20%'><a href='javascript:;' onclick=\"toggleColumnOfAtoms('${rack_id}', '0', ${rackData['height']})\">Front</a></th>";
		echo "<th width='50%'><a href='javascript:;' onclick=\"toggleColumnOfAtoms('${rack_id}', '1', ${rackData['height']})\">Interior</a></th>";
		echo "<th width='20%'><a href='javascript:;' onclick=\"toggleColumnOfAtoms('${rack_id}', '2', ${rackData['height']})\">Back</a></th></tr>\n";
		echo "</table>\n<br>\n";*/
		// Determine zero-u checkbox status.
		// If form has been submitted, use form data, otherwise use DB data.
		if (isset($_REQUEST['op']))
			$checked = isset($_REQUEST['zerou_'.$rack_id]) ? 'checked' : '';
		else
			$checked = in_array($rack_id, $parentRacks) ? 'checked' : '';
		$singleDataSet['checked'] = $checked;

		//echo "<label for=zerou_${rack_id}>Zero-U:</label> <input type=checkbox ${checked} name=zerou_${rack_id} id=zerou_${rack_id}>\n<br><br>\n";
		//echo "<input type='button' onclick='uncheckAll();' value='Uncheck all'>\n";
		//echo '</center></td>';
		$allWorkingDataOut[] = $singleDataSet;
	}
	$mod->addOutput("allWorkingData", $allWorkingDataOut);
		 
	//echo "</tr></table>";
	//finishPortlet();
	//echo "</td>\n";

	//echo "</form>\n";
	//echo "</tr></table>\n";
}

function renderMolecule ($mdata, $object_id)
{
	// sort data out
	$rackpack = array();
	global $loclist;
	foreach ($mdata as $rua)
	{
		$rack_id = $rua['rack_id'];
		$unit_no = $rua['unit_no'];
		$atom = $rua['atom'];
		if (!isset ($rackpack[$rack_id]))
		{
			$rackData = spotEntity ('rack', $rack_id);
			amplifyCell ($rackData);
			for ($i = $rackData['height']; $i > 0; $i--)
				for ($locidx = 0; $locidx < 3; $locidx++)
					$rackData[$i][$locidx]['state'] = 'F';
			$rackpack[$rack_id] = $rackData;
		}
		$rackpack[$rack_id][$unit_no][$loclist[$atom]]['state'] = 'T';
		$rackpack[$rack_id][$unit_no][$loclist[$atom]]['object_id'] = $object_id;
	}
	// now we have some racks to render
	foreach ($rackpack as $rackData)
	{
		markAllSpans ($rackData);
		echo "<table class=molecule cellspacing=0>\n";
		echo "<caption>${rackData['name']}</caption>\n";
		echo "<tr><th width='10%'>&nbsp;</th><th width='20%'>Front</th><th width='50%'>Interior</th><th width='20%'>Back</th></tr>\n";
		for ($i = $rackData['height']; $i > 0; $i--)
		{
			echo "<tr><th>" . inverseRackUnit ($i, $rackData) . "</th>";
			for ($locidx = 0; $locidx < 3; $locidx++)
			{
				$state = $rackData[$i][$locidx]['state'];
				echo "<td class='atom state_${state}'>&nbsp;</td>\n";
			}
			echo "</tr>\n";
		}
		echo "</table>\n";
	}
}

function renderDepot ()
{
	global $pageno, $nextorder;
	$cellfilter = getCellFilter();
	$objects = array();
	$objects_count = getEntitiesCount ('object');

	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload", "RenderDepot");
	$mod->setNamespace("depot",true);
	
	//echo "<table border=0 class=objectview>\n";
	//echo "<tr><td class=pcleft>";

	if ($objects_count == 0)
		$mod->addOutput("NoObjects", true);
		//echo '<h2>No objects exist</h2>';
	// 1st attempt: do not fetch all objects if cellfilter is empty and rendering empty result is enabled
	elseif (! ($cellfilter['is_empty'] && renderEmptyResults ($cellfilter, 'objects', $objects_count, $mod, 'Content')))
	{
		$objects = filterCellList (listCells ('object'), $cellfilter['expression']);
		// 2st attempt: do not render all fetched objects if rendering empty result is enabled
		if (! renderEmptyResults ( $cellfilter, 'objects', count($objects), $mod, 'Content'))
		{
			$mod->setOutput("countObjs", count($objects));
				 
		//	startPortlet ('Objects (' . count ($objects) . ')');
		//	echo '<br><br><table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>';
		//	echo '<tr><th>Common name</th><th>Visible label</th><th>Asset tag</th><th>Row/Rack or Container</th></tr>';
			$order = 'odd';
			# gather IDs of all objects and fetch rackspace info in one pass
			$idlist = array();
			foreach ($objects as $obj)
				$idlist[] = $obj['id'];
			$mountinfo = getMountInfo ($idlist);
			$containerinfo = getContainerInfo ($idlist);

			$objectsOutArray = array();
			foreach ($objects as $obj)
			{
				$singleObj = array("order" => $order, "mka" => mkA ("<strong>${obj['dname']}</strong>", 'object', $obj['id']) );

			//	echo "<tr class='row_${order} tdleft' valign=top><td>" . mkA ("<strong>${obj['dname']}</strong>", 'object', $obj['id']);
				if (count ($obj['etags'])){
				//		echo '<br><small>' . serializeTags ($obj['etags'], makeHref(array('page'=>$pageno, 'tab'=>'default')) . '&') . '</small>';	
					$tagsLineMod = $tplm->generateModule('ETagsLine',true, array(
						'cont' => serializeTags ($obj['etags'], makeHref(array('page'=>$pageno, 'tab'=>'default')) . '&')));
					$singleObj["RenderedTags"] = $tagsLineMod->run();
				}

				$singleObj['label']	= $obj['label'];
				$singleObj['asset_no']	= $obj['asset_no'];
			//	echo "</td><td>${obj['label']}</td>";
			//	echo "<td>${obj['asset_no']}</td>";
				$places = array();
				if (array_key_exists ($obj['id'], $containerinfo))
					foreach ($containerinfo[$obj['id']] as $ci)
						$places[] = mkA ($ci['container_name'], 'object', $ci['container_id']);
				if (array_key_exists ($obj['id'], $mountinfo))
					foreach ($mountinfo[$obj['id']] as $mi)
						$places[] = mkA ($mi['row_name'], 'row', $mi['row_id']) . '/' . mkA ($mi['rack_name'], 'rack', $mi['rack_id']);
				if (! count ($places))
					$places[] = 'Unmounted';
				$singleObj["places"] = implode (', ', $places);
			//	echo "<td>" . implode (', ', $places) . '</td>';
			//	echo '</tr>';
				$order = $nextorder[$order];
				$objectsOutArray[] = $singleObj;
			}

			$mod->setOutput("allObjects", $objectsOutArray);
				 
		//	echo '</table>';
		//	finishPortlet();
		}
	}

//	echo "</td><td class=pcright width='25%'>";
	//TODO Check not working
	renderCellFilterPortlet ($cellfilter, 'object', $objects, array(), $mod);
//	echo "</td></tr></table>\n";
}

// This function returns TRUE if the result set is too big to be rendered, and no filter is set.
// In this case it renders the describing message instead.
function renderEmptyResults($cellfilter, $entities_name, $count = NULL, $pmod = null, $placeholder = '')
{
	if (!$cellfilter['is_empty'])
		return FALSE;
	if (isset ($_REQUEST['show_all_objects']))
		return FALSE;
	$max = intval(getConfigVar('MAX_UNFILTERED_ENTITIES'));
	if (0 == $max || $count <= $max)
		return FALSE;

	$href_show_all = trim($_SERVER['REQUEST_URI'], '&');
	$href_show_all .= htmlspecialchars('&show_all_objects=1');
	
	$tplm = TemplateManager::getInstance();
	//if($pmod==null)
	//	$tplm->setTemplate("vanilla");
	
	if($pmod==null)	
		$mod = $tplm->generateModule("EmptyResults",   true);
	else
		$mod = $tplm->generateSubmodule($placeholder, "EmptyResults", $pmod, true);
	
	$suffix = isset ($count) ? " ($count)" : '';
	$mod->addOutput("Name", $entities_name);
	$mod->addOutput("Suffix", $suffix);
	$mod->addOutput("ShowAll", $href_show_all);
	//echo <<<END
//<p>Please set a filter to display the corresponging $entities_name.
//<br><a href="$href_show_all">Show all $entities_name$suffix</a>
//END;
	if($pmod==null)
		$mod->run();
	return TRUE;
}

// History viewer for history-enabled simple dictionaries.
/*
function renderObjectHistory ($object_id, $parent, $placeholder)
{
	$tplm = TemplateManager::getInstance();

	$tplm->setTemplate("vanilla");

	$mod = $tplm->generateSubmodule($placeholder, "RenderObjectHistory", $parent);
	
	$order = 'odd';
	global $nextorder;
	// echo '<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>';
	// echo '<tr><th>change time</th><th>author</th><th>name</th><th>visible label</th><th>asset no</th><th>has problems?</th><th>comment</th></tr>';
*/
function renderObjectHistory ($object_id, $parent = NULL, $placeholder = 'History')
{
	$tplm = TemplateManager::getInstance();
	
	if ($parent == null) {
		$mod = $tplm->generateModule('ObjectHistory');
	} else {
		$mod = $tplm->generateSubmodule($placeholder, 'ObjectHistory', $parent);
	}
	$mod->defNamespace();
	
	$order = 'odd';
	global $nextorder;
	echo '';
	echo '';

	$result = usePreparedSelectBlade
	(
		'SELECT ctime, user_name, name, label, asset_no, has_problems, comment FROM ObjectHistory WHERE id=? ORDER BY ctime',
		array ($object_id)
	);
/*	while ($row = $result->fetch (PDO::FETCH_NUM))
	{
		$submod = $tplm->generateSubmodule('Row', 'RowGenerator', $mod);
		$submod->setOutput('Order', $order);
		$submod->setOutput('Row', $row[0]);
		// echo "<tr class=row_${order}><td>${row[0]}</td>";
		$rowarray = array();
		for ($i = 1; $i <= 6; $i++)
			$rowarray[] = array('Content'=>$row[$i]);
		$submod->addOutput('Looparray', $rowarray);		
		// echo "<td>" . $row[$i] . "</td>";
		// echo "</tr>\n";
		$order = $nextorder[$order];
	}
	// echo "</table><br>\n";
*/	
	$output = array();
	while ($row = $result->fetch (PDO::FETCH_NUM))
	{
		$row['Order'] = $order;
		$output[] = $row;
		
		/*
		echo "<tr class=row_${order}><td>${row[0]}</td>";
		for ($i = 1; $i <= 6; $i++)
			echo "<td>" . $row[$i] . "</td>";
		echo "</tr>\n";**/
		$order = $nextorder[$order];
	}
	$mod->addOutput('History', $output);
	
	//echo "</table><br>\n";

}

function renderRackspaceHistory ()
{
	global $nextorder, $pageno, $tabno;
	$order = 'odd';
	$history = getRackspaceHistory();
	// Show the last operation by default.
	if (isset ($_REQUEST['op_id']))
		$op_id = $_REQUEST['op_id'];
	elseif (isset ($history[0]['mo_id']))
		$op_id = $history[0]['mo_id'];
	else $op_id = NULL;

	$omid = NULL;
	$nmid = NULL;
	$object_id = 1;
	if ($op_id)
		list ($omid, $nmid) = getOperationMolecules ($op_id);
	
	$tplm = TemplateManager::getInstance();
	
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RackspaceHistory");
	$mod->setNamespace("rackspace",true);
	
	// Main layout starts.
	//echo "<table border=0 class=objectview cellspacing=0 cellpadding=0>";

	// Left top portlet with old allocation.
	//echo "<tr><td class=pcleft>";
	//startPortlet ('Old allocation');
	if ($omid)
	{
		$oldMolecule = getMolecule ($omid);
		renderMolecule ($oldMolecule, $object_id);
	}
	else
		$mod->setOutput("OldAlloc","nothing");
	//finishPortlet();

	//echo '</td><td class=pcright>';

	// Right top portlet with new allocation
	//startPortlet ('New allocation');
	if ($nmid)
	{
		$newMolecule = getMolecule ($nmid);
		renderMolecule ($newMolecule, $object_id);
	}
	else
		$mod->setOutput("NewAlloc","nothing");
	//finishPortlet();

	//echo '</td></tr><tr><td colspan=2>';

	// Bottom portlet with list

	//startPortlet ('Rackspace allocation history');
	//echo "<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>\n";
	//echo "<tr><th>timestamp</th><th>author</th><th>object</th><th>comment</th></tr>\n";
	foreach ($history as $row)
	{
		$smod = $tplm->generateSubmodule("HistoryRows","RackspaceHistoryRow",$mod);
		if ($row['mo_id'] == $op_id)
			$class = 'hl';
		else
			$class = "row_${order}";
		$smod->addOutput("Class",$class);
		$smod->addOutput("Link",makeHref(array('page'=>$pageno, 'tab'=>$tabno, 'op_id'=>$row['mo_id'])));
		$smod->addOutput("Time",$row['ctime']);
		$smod->addOutput("UserName",$row['user_name']);
		$smod->addOutput("RenderedCell",renderCell (spotEntity ('object', $row['ro_id'])));
		$smod->addOutput("Comment",$row['comment']);
		//echo "<tr class=${class}><td><a href='".makeHref(array('page'=>$pageno, 'tab'=>$tabno, 'op_id'=>$row['mo_id']))."'>${row['ctime']}</a></td>";
		//echo "<td>${row['user_name']}</td><td>";
		//renderCell (spotEntity ('object', $row['ro_id']));
		//echo '</td><td>' . niftyString ($row['comment'], 0) . '</td></tr>';
		$order = $nextorder[$order];
	}
	//echo "</table>\n";
	//finishPortlet();

	//echo '</td></tr></table>';
}

function renderIPSpaceRecords ($tree, $baseurl, $target = 0, $level = 1, $parent, $placeholder)
{
	$self = __FUNCTION__;
	
	$tplm = TemplateManager::getInstance();
	
	$knight = (getConfigVar ('IPV4_ENABLE_KNIGHT') == 'yes');

	// scroll page to the highlighted item
	if ($target && isset ($_REQUEST['hl_net']))
		addAutoScrollScript ("net-$target");

	foreach ($tree as $item)
	{
		if ($display_routers = (getConfigVar ('IPV4_TREE_RTR_AS_CELL') != 'none'))
			loadIPAddrList ($item); // necessary to compute router list and address counter

		if (isset ($item['id']))
		{
			$mod = $tplm->generateSubmodule($placeholder, 'IPSpaceRecord', $parent);
			$mod->setNamespace('ipspace');
				
			$decor = array ('indent' => $level);
			if ($item['symbol'] == 'node-collapsed')
				$decor['symbolurl'] = "${baseurl}&eid=${item['id']}&hl_net=1";
			elseif ($item['symbol'] == 'node-expanded')
				$decor['symbolurl'] = $baseurl . ($item['parent_id'] ? "&eid=${item['parent_id']}&hl_net=1" : '');
			$tr_class = '';
			if ($target == $item['id'] && isset ($_REQUEST['hl_net']))
			{
				$decor['tdclass'] = ' highlight';
				//$tr_class = $decor['tdclass'];
				$mod->addOutput('Highlight', 'highlight');
			}
			//echo "<tr valign=top class=\"$tr_class\">";
			printIPNetInfoTDs ($item, $decor, $mod, 'ItemInfo');

			// capacity and usage
			//echo "<td class=tdcenter>";
			$mod->addOutput('Capacity', getRenderedIPNetCapacity ($item));
			//echo "</td>";

			if ($display_routers)
				printRoutersTD (findRouters ($item['own_addrlist']), getConfigVar ('IPV4_TREE_RTR_AS_CELL'), $mod, 'Routers');
			//echo "</tr>";
			if ($item['symbol'] == 'node-expanded' or $item['symbol'] == 'node-expanded-static')
				$self ($item['kids'], $baseurl, $target, $level + 1, $parent, $placeholder);
		}
		else
		{
			// non-allocated (spare) IP range
			//echo "<tr valign=top>";
			$mod = $tplm->generateSubmodule($placeholder, 'IPSpaceRecordNoAlloc', $parent);
			$mod->setNamespace('ipspace');
			
			printIPNetInfoTDs ($item, array ('indent' => $level, 'knight' => $knight, 'tdclass' => 'sparenetwork'), $mod, 'IPnetInfo');

			// capacity and usage
			//echo "<td class=tdcenter>";
			$mod->addOutput('IPNetCapacity', getRenderedIPNetCapacity ($item));
			//echo "</td>";
			if ($display_routers)
				$mod->addOutput('hasRouterCell', $display_routers);
				//echo "<td></td>";
			//echo "</tr>";
		}
	}
}

function renderIPSpace()
{
	global $pageno, $tabno;
	$realm = ($pageno == 'ipv4space' ? 'ipv4net' : 'ipv6net');
	$cellfilter = getCellFilter();
	
	$tplm = TemplateManager::getInstance();
	$mod = $tplm->generateSubmodule('Payload', 'IPSpace');
	$mod->setNamespace('ipspace');

	// expand request can take either natural values or "ALL". Zero means no expanding.
	$eid = isset ($_REQUEST['eid']) ? $_REQUEST['eid'] : 0;

	//echo "<table border=0 class=objectview>\n";
	//echo "<tr><td class=pcleft>";

	$netlist = array();
	if (! ($cellfilter['is_empty'] && ! $eid && renderEmptyResults($cellfilter, 'IP nets', getEntitiesCount ($realm), $mod, 'EmptyResults')))
	{
		$top = NULL;
		foreach (listCells ($realm) as $net)
		{
			if (isset ($top) and IPNetContains ($top, $net))
				;
			elseif (! count ($cellfilter['expression']) or judgeCell ($net, $cellfilter['expression']))
				$top = $net;
			else
				continue;
			$netlist[$net['id']] = $net;
		}
		$netcount = count ($netlist);
		$tree = prepareIPTree ($netlist, $eid);

		if (! renderEmptyResults($cellfilter, 'IP nets', count($tree),$mod,'EmptyResults'))
		{
			$mod->addOutput('hasResults', true);
			$mod->addOutput("NetCount", $netcount);
				 
			//startPortlet ("networks (${netcount})");
			//echo '<h4>';
			//$all = "<a href='".makeHref(array('page'=>$pageno, 'tab'=>$tabno, 'eid'=>'ALL')) .
			//		$cellfilter['urlextra'] . "'>expand&nbsp;all</a>";
			//$none = "<a href='".makeHref(array('page'=>$pageno, 'tab'=>$tabno, 'eid'=>'NONE')) .
			//		$cellfilter['urlextra'] . "'>collapse&nbsp;all</a>";
			//$auto = "<a href='".makeHref(array('page'=>$pageno, 'tab'=>$tabno)) .
			//	$cellfilter['urlextra'] . "'>auto-collapse</a>";
			$mod->addOutput("TreeThreshold", getConfigVar ('TREE_THRESHOLD'));
			$mod->addOutput('ExpandAll', makeHref(array('page'=>$pageno, 'tab'=>$tabno, 'eid'=>'ALL')) . $cellfilter['urlextra']);
			$mod->addOutput('CollapseAll', makeHref(array('page'=>$pageno, 'tab'=>$tabno, 'eid'=>'NONE')) .	$cellfilter['urlextra']);
			$mod->addOutput('CollapseAuto', makeHref(array('page'=>$pageno, 'tab'=>$tabno)) . $cellfilter['urlextra']);
			
			if ($eid === 0)
				$mod->addOutput('CollapseExpandOptions', 'allnone');

				//echo 'auto-collapsing at threshold ' . getConfigVar ('TREE_THRESHOLD') . " ($all / $none)";
			elseif ($eid === 'ALL')
				$mod->addOutput('CollapseExpandOptions', 'all');
			//	echo "expanding all ($auto / $none)";
			elseif ($eid === 'NONE')
				$mod->addOutput('CollapseExpandOptions', 'none');
				//echo "collapsing all ($all / $auto)";
			else
			{
				$netinfo = spotEntity ($realm, $eid);
				$mod->addOutput('ExpandIP', $netinfo['ip']);
				$mod->addOutput('ExpandMask', $netinfo['mask']);
				//echo "expanding ${netinfo['ip']}/${netinfo['mask']} ($auto / $all / $none)";
			}
			
			//echo "</h4><table class='widetable' border=0 cellpadding=5 cellspacing=0 align='center'>\n";
			//echo "<tr><th>prefix</th><th>name/tags</th><th>capacity</th>";
			if (getConfigVar ('IPV4_TREE_RTR_AS_CELL') != 'none')
				$mod->addOutput('AddRouted', true);
				//echo "<th>routed by</th>";
			//echo "</tr>\n";
			$baseurl = makeHref(array('page'=>$pageno, 'tab'=>$tabno)) . $cellfilter['urlextra'];
			renderIPSpaceRecords ($tree, $baseurl, $eid, 1, $mod, 'IPRecords');
			//echo "</table>\n";
			//finishPortlet();
		}
	}

	//echo '</td><td class=pcright>';
	renderCellFilterPortlet ($cellfilter, $realm, $netlist, array(), $mod, 'CellFilter');
	//echo "</td></tr></table>\n";
}

function renderIPSpaceEditor()
{
	global $pageno;
	$realm = ($pageno == 'ipv4space' ? 'ipv4net' : 'ipv6net');
	$net_page = $realm; // 'ipv4net', 'ipv6net'
	$addrspaceList = listCells ($realm);

	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderIPSpaceEditor");
	$mod->setNamespace("ipspace");
	
	$mod->addOutput("countAddrspaceList", count ($addrspaceList));
			 	
	//startPortlet ('Manage existing (' . count ($addrspaceList) . ')');
	if (count ($addrspaceList))
	{

		$mod->addOutput("hasAddrspaceList", true);
			 
		//echo "<table class='widetable' border=0 cellpadding=5 cellspacing=0 align='center'>\n";
		//echo "<tr><th>&nbsp;</th><th>prefix</th><th>name</th><th>capacity</th></tr>";
		$allNetinfoOut = array();
		foreach ($addrspaceList as $netinfo)
		{
	//		echo "<tr valign=top><td>";
			$singleNetinfo = array( 'mkAIpmask' => mkA ("${netinfo['ip']}/${netinfo['mask']}", $net_page, $netinfo['id']),
									'name' => niftyString ($netinfo['name']));
			if (! isIPNetworkEmpty ($netinfo))
	//			printImageHREF ('nodestroy', 'There are ' . count ($netinfo['addrlist']) . ' allocations inside');
				$singleNetinfo['destroyItem'] = printImageHREF ('nodestroy', 'There are ' . count ($netinfo['addrlist']) . ' allocations inside');
			else
				$singleNetinfo['destroyItem'] = getOpLink (array	('op' => 'del', 'id' => $netinfo['id']), '', 'destroy', 'Delete this prefix');
	//			echo getOpLink (array	('op' => 'del', 'id' => $netinfo['id']), '', 'destroy', 'Delete this prefix');
	//		echo '</td><td class=tdleft>' . mkA ("${netinfo['ip']}/${netinfo['mask']}", $net_page, $netinfo['id']) . '</td>';
	//		echo '<td class=tdleft>' . niftyString ($netinfo['name']);
			if (count ($netinfo['etags'])){
				$etagsMod = $tplm->generateModule('ETagsLine', true, array('cont' => serializeTags ($netinfo['etags'])));
				$singleNetinfo['RendTags'] = $etagsMod->run();
			}
	//			echo '<br><small>' . serializeTags ($netinfo['etags']) . '</small>';
	//		echo '</td><td>';
			$singleNetinfo['ipnetCap'] = getRenderedIPNetCapacity ($netinfo);
	//		echo getRenderedIPNetCapacity ($netinfo);
	//		echo '</tr>';
			$allNetinfoOut[] = $singleNetinfo;
		}
		$mod->addOutput("allNetinfo", $allNetinfoOut);
			 
	//	echo "</table>";
	//	finishPortlet();
	}

}

function renderIPNewNetForm ()
{
	global $pageno;
	if ($pageno == 'ipv6space')
	{
		$realm = 'ipv6net';
		$regexp = '^[a-fA-F0-9:]*:[a-fA-F0-9:\.]*/\d{1,3}$';
	}
	else
	{
		$realm = 'ipv4net';
		$regexp = '^(\d{1,3}\.){3}\d{1,3}/\d{1,2}$';
	}
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderIPNewNetForm");
	$mod->setNamespace("ipspace");
		

	// IP prefix validator
	//addJS ('js/live_validation.js');
	$regexp = addslashes ($regexp);
	$mod->addOutput("regexp", $regexp);
	/*	 
	addJS (<<<END
$(document).ready(function () {
	$('form#add' input[name="range"]).attr('match', '$regexp');
	Validate.init();
});
END
	, TRUE);

	startPortlet ('Add new');
	echo '<table border=0 cellpadding=10 align=center>';
	printOpFormIntro ('add');*/
	// tags column
	//echo '<tr><td rowspan=5><h3>assign tags</h3>';
	//echo renderNewEntityTags ($realm);
	renderNewEntityTags ($realm, $mod, 'rendNewEntityTags');
	//echo '</td>';
	// inputs column
	$prefix_value = empty ($_REQUEST['set-prefix']) ? '' : $_REQUEST['set-prefix'];
	$mod->addOutput("prefix_value", $prefix_value);	 
	//echo "<th class=tdright>prefix</th><td class=tdleft><input type=text name='range' size=36 class='live-validate' tabindex=1 value='${prefix_value}'></td>";
	//echo '<tr><th class=tdright>VLAN</th><td class=tdleft>';
	getOptionTree ('vlan_ck', getAllVLANOptions(), array ('select_class' => 'vertical', 'tabindex' => 2), $mod, 'optionTree');
	//echo getOptionTree ('vlan_ck', getAllVLANOptions(), array ('select_class' => 'vertical', 'tabindex' => 2)) . '</td></tr>';
	//echo "<tr><th class=tdright>name</th><td class=tdleft><input type=text name='name' size='20' tabindex=3></td></tr>";
	//echo '<tr><td class=tdright><input type=checkbox name="is_connected" id="is_connected" tabindex=4></td>';
	//echo '<th class=tdleft><label for="is_connected">reserve subnet-router anycast address</label></th></tr>';
	//echo "<tr><td colspan=2>";
	//printImageHREF ('CREATE', 'Add a new network', TRUE, 5);
	//echo '</td></tr>';
	//echo "</form></table><br><br>\n";
	//finishPortlet();
}

function getRenderedIPNetBacktrace ($range)
{
	if (getConfigVar ('EXT_IPV4_VIEW') != 'yes')
		return array();

	$v = ($range['realm'] == 'ipv4net') ? 4 : 6;
	$space = "ipv${v}space"; // ipv4space, ipv6space
	$tag = "\$ip${v}netid_"; // $ip4netid_, $ip6netid_

	$ret = array();
	// Build a backtrace from all parent networks.
	$clen = $range['mask'];
	$backtrace = array();
	$backtrace['&rarr;'] = $range;
	$key = '';
	
	$tplm = TemplateManager::getInstance();
	while (NULL !== ($upperid = getIPAddressNetworkId ($range['ip_bin'], $clen)))
	{
		$upperinfo = spotEntity ($range['realm'], $upperid);
		$clen = $upperinfo['mask'];
		$key .= '&uarr;';
		$backtrace[$key] = $upperinfo;
	}
	foreach (array_reverse ($backtrace) as $arrow => $ainfo)
	{
		$mod = $tplm->generateModule('IPNetBacktraceLink',true,array('Title'=>$arrow));
		//$link = '<a href="' . 
		$mod->addOutput('Link', makeHref(array (
			'page' => $space,
			'tab' => 'default',
			'clear-cf' => '',
			'cfe' => '{' . $tag . $ainfo['id'] . '}',
			'hl_net' => 1,
			'eid' => $range['id'])));
		//)) //. '" title="View IP tree with this net as root">' . $arrow . '</a>';
		$ret[] = array ($mod->run(), renderCell($ainfo)); //getOutputOf ('renderCell', $ainfo));
	}
	return $ret;
}

function renderIPNetwork ($id)
{
	$tplm = TemplateManager::getInstance();
	
	$mod = $tplm->generateSubmodule('Payload', 'IPNetwork');
	$mod->setNamespace('ipnetwork');
	
	global $pageno;
	$realm = $pageno; // 'ipv4net', 'ipv6net'
	$range = spotEntity ($realm, $id);
	loadIPAddrList ($range);
	//echo "<table border=0 class=objectview cellspacing=0 cellpadding=0>";
	//echo "<tr><td colspan=2 align=center><h1>${range['ip']}/${range['mask']}</h1><h2>";
	//echo htmlspecialchars ($range['name'], ENT_QUOTES, 'UTF-8') . "</h2></td></tr>\n";
	
	$mod->addOutput('IP', $range['ip']);
	$mod->addOutput('Mask', $range['mask']);
	$mod->addOutput('Name', htmlspecialchars ($range['name'], ENT_QUOTES, 'UTF-8'));
	
	//echo "<table border=0 class=objectview cellspacing=0 cellpadding=0>";
	//echo "<tr><td colspan=2 align=center><h1>${range['ip']}/${range['mask']}</h1><h2>";
	//echo htmlspecialchars ($range['name'], ENT_QUOTES, 'UTF-8') . "</h2></td></tr>\n";

	//echo "<tr><td class=pcleft width='50%'>";
	//echo "<tr><td class=pcleft width='50%'>";

	// render summary portlet
	$summary = array();
	$summary['%% used'] = getRenderedIPNetCapacity ($range);
	$summary = getRenderedIPNetBacktrace ($range) + $summary;
	if ($realm == 'ipv4net')
	{
		$summary[] = array ('Netmask:', ip4_format ($range['mask_bin']));
		$summary[] = array ('Netmask:', "0x" . strtoupper (implode ('', unpack ('H*', $range['mask_bin']))));
		$summary['Wildcard bits'] = ip4_format ( ~ $range['mask_bin']);
	}

	$reuse_domain = considerConfiguredConstraint ($range, '8021Q_MULTILINK_LISTSRC');
	$domainclass = array();
	foreach (array_count_values (reduceSubarraysToColumn ($range['8021q'], 'domain_id')) as $domain_id => $vlan_count)
		$domainclass[$domain_id] = $vlan_count == 1 ? '' : ($reuse_domain ? '{trwarning}' : '{trerror}');
	foreach ($range['8021q'] as $item)
		$summary[] = array ($domainclass[$item['domain_id']] . 'VLAN:', formatVLANAsHyperlink (getVLANInfo ($item['domain_id'] . '-' . $item['vlan_id'])));
	if (getConfigVar ('EXT_IPV4_VIEW') == 'yes' and count ($routers = findRouters ($range['addrlist'])))
	{
		$summary['Routed by'] = '';
		foreach ($routers as $rtr)
			$summary['Routed by'] .= renderRouterCell($rtr['ip_bin'], $rtr['iface'], spotEntity ('object', $rtr['id']));
	}
	$summary['tags'] = '';
	//renderEntitySummary ($range, 'summary', $summary);
	renderEntitySummary ($range, 'summary', $summary, $mod, 'Summary');

	if (strlen ($range['comment']))
	{
		$mod->addOutput('Comment', string_insert_hrefs (htmlspecialchars ($range['comment'], ENT_QUOTES, 'UTF-8')));
		//startPortlet ('Comment');
		//echo '<div class=commentblock>' . string_insert_hrefs (htmlspecialchars ($range['comment'], ENT_QUOTES, 'UTF-8')) . '</div>';
		//finishPortlet ();
	}

	$mod->addOutput('Files', renderFilesPortlet ($realm, $id));
	//echo "</td>\n";

	//echo "<td class=pcright>";
	//startPortlet ('details');
	renderIPNetworkAddresses ($range, $mod, 'AddressList');
	//finishPortlet();
	//echo "</td></tr></table>\n";
}

// Used solely by renderSeparator
function renderEmptyIPv6 ($ip_bin, $hl_ip, $parent, $placeholder)
{
	$tplm = TemplateManager::getInstance();
	
	$mod = $tplm->generateSubmodule($placeholder, 'IPv6Separator', $parent, true);
	$class = '';
	if ($ip_bin === $hl_ip)
		$class .= 'highlight';
	$mod->addOutput('Highlight', $class);
	$mod->addOutput('FMT', ip6_format ($ip_bin));
	//$fmt = ip6_format ($ip_bin);
	//echo "<tr class='$class'><td><a name='ip-$fmt' href='" . makeHref (array ('page' => 'ipaddress', 'ip' => $fmt)) . "'>" . $fmt;
	$mod->addOutput('Link',makeHref (array ('page' => 'ipaddress', 'ip' => $fmt)));
	$editable = permitted ('ipaddress', 'properties', 'editAddress')
		? 'editable'
		: '';
	$mod->addOutput('Editable', $editable);
	//echo "</a></td><td><span class='rsvtext $editable id-$fmt op-upd-ip-name'></span></td>";
	//echo "<td><span class='rsvtext $editable id-$fmt op-upd-ip-comment'></span></td><td>&nbsp;</td></tr>\n";
}

// Renders empty table line to shrink empty IPv6 address ranges.
// If the range consists of single address, renders the address instead of empty line.
// Renders address $hl_ip inside the range.
// Used solely by renderIPv6NetworkAddresses
function renderSeparator ($first, $last, $hl_ip, $parent, $placeholder)
{
	$self = __FUNCTION__;
	if (strcmp ($first, $last) > 0)
		return;
	if ($first == $last)
		renderEmptyIPv6 ($first, $hl_ip);
	elseif (isset ($hl_ip) && strcmp ($hl_ip, $first) >= 0 && strcmp ($hl_ip, $last) <= 0)
	{ // $hl_ip is inside the range $first - $last
		$self ($first, ip_prev ($hl_ip), $hl_ip);
		renderEmptyIPv6 ($hl_ip, $hl_ip);
		$self (ip_next ($hl_ip), $last, $hl_ip);
	}
	else
	{
		$tplm = TemplateManager::getInstance();
		$mod = $tplm->generateSubmodule($placeholder, 'IPv6SeparatorPlain', $parent, true);

	}
		//echo "<tr><td colspan=4 class=tdleft></td></tr>\n";
}

// calculates page number that contains given $ip (used by renderIPv6NetworkAddresses)
function getPageNumOfIPv6 ($list, $ip_bin, $maxperpage)
{
	if (intval ($maxperpage) <= 0 || count ($list) <= $maxperpage)
		return 0;
	$keys = array_keys ($list);
	for ($i = 1; $i <= count ($keys); $i++)
		if (strcmp ($keys[$i-1], $ip_bin) >= 0)
			return intval ($i / $maxperpage);
	return intval (count ($list) / $maxperpage);
}

function renderIPNetworkAddresses ($range, $parent, $placeholder)
{
	switch (strlen ($range['ip_bin']))
	{
		case 4:  return renderIPv4NetworkAddresses ($range, $parent, $placeholder);
		case 16: return renderIPv6NetworkAddresses ($range, $parent, $placeholder);
		default: throw new InvalidArgException ("range['ip_bin']", $range['ip_bin']);
	}
}

function renderIPv4NetworkAddresses ($range, $parent, $placeholder)
{
	global $pageno, $tabno, $aac2;
	$startip = ip4_bin2int ($range['ip_bin']);
	$endip = ip4_bin2int (ip_last ($range));
	
	$tplm = TemplateManager::getInstance();
	
	$mod = $tplm->generateSubmodule($placeholder, 'IPNetworkAddresses', $parent);
	$mod->setNamespace('ipnetwork',true);

	if (isset ($_REQUEST['hl_ip']))
	{
		$hl_ip = ip4_bin2int (ip4_parse ($_REQUEST['hl_ip']));
		$mod->addOutput('AutoScroll', $hl_ip);
		//addAutoScrollScript ('ip-' . $_REQUEST['hl_ip']); // scroll page to highlighted ip
	}

	// pager
	$maxperpage = getConfigVar ('IPV4_ADDRS_PER_PAGE');
	$address_count = $endip - $startip + 1;
	$page = 0;
	$rendered_pager = '';
	if ($address_count > $maxperpage && $maxperpage > 0)
	{
		$page = isset ($_REQUEST['pg']) ? $_REQUEST['pg'] : (isset ($hl_ip) ? intval (($hl_ip - $startip) / $maxperpage) : 0);
		if ($numpages = ceil ($address_count / $maxperpage))
		{
			$mod->addOutput('HasPagination', true);
			$mod->addOutput('StartIP', ip4_format (ip4_int2bin ($startip)));
			$mod->addOutput('EndIP', ip4_format (ip4_int2bin ($endip)));
			//echo '<h3>' . ip4_format (ip4_int2bin ($startip)) . ' ~ ' . ip4_format (ip4_int2bin ($endip)) . '</h3>';
			$pagesarray = array();
			$smod = $tplm->generateSubmodule('Pager', 'IPNetworkAddressesPager', $mod);
			for ($i = 0; $i < $numpages; $i++)
				if ($i == $page)
				{
					$pagesarray[] = array(
						'B' => '<b>',
						'BEnd' => '</b>',
						'i' => $i,
						'Link' => makeHref (array ('page' => $pageno, 'tab' => $tabno, 'id' => $netinfo['id'], 'pg' => $i))
					);
				}
					//$rendered_pager .= "<b>$i</b> ";
				else
				{	
					$pagesarray[] = array(
						'i' => $i,
						'Link' => makeHref (array ('page' => $pageno, 'tab' => $tabno, 'id' => $netinfo['id'], 'pg' => $i))
					);
				}
			$smod->addOutput('Pages', $pagesarray);
		}
		$startip = $startip + $page * $maxperpage;
		$endip = min ($startip + $maxperpage - 1, $endip);
	}

	//echo $rendered_pager;
	//echo "<table class='widetable' border=0 cellspacing=0 cellpadding=5 align='center' width='100%'>\n";
	//echo "<tr><th>Address</th><th>Name</th><th>Comment</th><th>Allocation</th></tr>\n";

	markupIPAddrList ($range['addrlist']);
	for ($ip = $startip; $ip <= $endip; $ip++)
	{
		$ip_bin = ip4_int2bin ($ip);
		$dottedquad = ip4_format ($ip_bin);
		$tr_class = (isset ($hl_ip) && $hl_ip == $ip ? 'highlight' : '');
		if (isset ($range['addrlist'][$ip_bin]))
			$addr = $range['addrlist'][$ip_bin];
		else
		{
			$editable = permitted ('ipaddress', 'properties', 'editAddress')
			? 'editable'
					: '';
			
			$smod = $tplm->generateSubmodule('IPList', 'IPNetworkAddressEmpty',$mod);
			$smod->setNamespace('ipnetwork',true);
			$smod->addOutput('Link', makeHref(array('page'=>'ipaddress', 'ip' => $dottedquad)));
			$smod->addOutput('IP', $dottedquad);
			$smod->addOutput('Editable', $editable);
			$smod->addOutput('TrClass', $tr_class);
			continue;
			/**echo "<tr class='tdleft $tr_class'><td class=tdleft><a name='ip-$dottedquad' href='" . makeHref(array('page'=>'ipaddress', 'ip' => $dottedquad)) . "'>$dottedquad</a></td>";
			$editable = permitted ('ipaddress', 'properties', 'editAddress')
				? 'editable'
				: '';
			echo "<td><span class='rsvtext $editable id-$dottedquad op-upd-ip-name'></span></td>";
			echo "<td><span class='rsvtext $editable id-$dottedquad op-upd-ip-comment'></span></td><td></td></tr>\n";
			continue;*/
		}
		// render IP change history
		$title = '';
		$history_class = '';
		
		$smod = $tplm->generateSubmodule('IPList', 'IPNetworkAddress', $mod);
		$smod->setNamespace('ipnetwork');
		
		if (isset ($addr['last_log']))
		{
			$smod->addOutput('Title', htmlspecialchars ($addr['last_log']['user'] . ', ' . formatAge ($addr['last_log']['time']) , ENT_QUOTES));
			$smod->addOutput('Class', 'hover-history underline');
			//$title = ' title="' . htmlspecialchars ($addr['last_log']['user'] . ', ' . formatAge ($addr['last_log']['time']) , ENT_QUOTES) . '"';
			//$history_class = 'hover-history underline';
		}
		$tr_class .= ' ' . $addr['class'];$smod->addOutput('RowClas', $tr_class);
		$smod->addOutput('DottedQuad', $dottedquad);
		$smod->addOutput('Link', makeHref(array('page'=>'ipaddress', 'ip'=>$addr['ip'])));
		$smod->addOutput('IP', $addr['ip']);
		//echo "<tr class='tdleft $tr_class'>";
		//echo "<td><a class='$history_class' $title name='ip-$dottedquad' href='".makeHref(array('page'=>'ipaddress', 'ip'=>$addr['ip']))."'>${addr['ip']}</a></td>";
		$editable =
			(empty ($addr['allocs']) || !empty ($addr['name']) || !empty ($addr['comment']))
			&& permitted ('ipaddress', 'properties', 'editAddress')
			? 'editable'
			: '';
		
		
		$smod->addOutput('Editable', $editable);
		$smod->addOutput('Name', $addr['name']);
		$smod->addOutput('Comment', $addr['comment']);
		
		//echo "<td><span class='rsvtext $editable id-$dottedquad op-upd-ip-name'>${addr['name']}</span></td>";
		//echo "<td><span class='rsvtext $editable id-$dottedquad op-upd-ip-comment'>${addr['comment']}</span></td>";
		//echo "<td>";
		//$delim = '';
		if ( $addr['reserved'] == 'yes')
		{
			
			$smod->addOutput('Reserved', true);
			//echo "<strong>RESERVED</strong> ";
			//$delim = '; ';
		}
		$outarr = array();
		foreach ($addr['allocs'] as $ref)
		{
			
			$name = $ref['name'] . (!strlen ($ref['name']) ? '' : '@') . $ref['object_name'];
			$outarr[] = array(
				'Type'=>$aac2[$ref['type']],
				'Link'=>makeHref(array('page'=>'object', 'object_id'=>$ref['object_id'], 'tab' => 'default', 'hl_ip'=>$addr['ip'])),
				'Name'=>$name	
			);
			/**echo $delim . $aac2[$ref['type']];
			echo "<a href='".makeHref(array('page'=>'object', 'object_id'=>$ref['object_id'], 'tab' => 'default', 'hl_ip'=>$addr['ip']))."'>";
			echo $ref['name'] . (!strlen ($ref['name']) ? '' : '@');
			echo "${ref['object_name']}</a>";
			$delim = '; '; */
		}
		
		if (count($outarr)>0)
		{
			$smod->addOutput('Allocs', $outarr);
		}
		//if ($delim != '')
		//	$delim = '<br>';
		
		$outarr = array();
		foreach ($addr['vslist'] as $vs_id)
		{
			$vs = spotEntity ('ipv4vs', $vs_id);
			
			$outarr[] = array('Link'=>mkA ("${vs['name']}:${vs['vport']}/${vs['proto']}", 'ipv4vs', $vs['id']));
			//echo $delim . mkA ("${vs['name']}:${vs['vport']}/${vs['proto']}", 'ipv4vs', $vs['id']) . '&rarr;';
			//$delim = '<br>';
		}
		if (count($outarr)>0)
		{
			$smod->addOutput('VSList', $outarr);
		}

		$outarr = array();
		foreach ($addr['vsglist'] as $vs_id)
		{
			$vs = spotEntity ('ipvs', $vs_id);
			
			$outarr[] = array('Link'=>mkA ($vs['name'], 'ipvs', $vs['id']));
			//echo $delim . mkA ($vs['name'], 'ipvs', $vs['id']) . '&rarr;';
			//$delim = '<br>';
		}
		if (count($outarr)>0)
		{
			$smod->addOutput('VSGList', $outarr);
		}

		$outarr = array();
		foreach ($addr['rsplist'] as $rsp_id)
		{
			$rsp = spotEntity ('ipv4rspool', $rsp_id);
			
			$outarr[] = array('Link'=>mkA ($rsp['name'], 'ipv4rspool', $rsp['id']));
			//echo "${delim}&rarr;" . mkA ($rsp['name'], 'ipv4rspool', $rsp['id']);
			//$delim = '<br>';
		}
		
		if (count($outarr)>0)
		{
			$smod->addOutput('RSPList', $outarr);
		}
		//echo "</td></tr>\n";
	}
	// end of iteration
	if (permitted (NULL, NULL, 'set_reserve_comment'))
		
		$mod->addOutput('UserHasEditPerm', true);
		//addJS ('js/inplace-edit.js');

	
	//echo "</table>";
	//if (! empty ($rendered_pager))
		//echo '<p>' . $rendered_pager . '</p>';
}

function renderIPv6NetworkAddresses ($netinfo, $parent, $placeholder)
{
	$tplm = TemplateManager::getInstance();
	
	$mod = $tplm->generateSubmodule($placeholder, 'IPv6NetworkAddresses', $parent);
	$mod->setNamespace('ipnetwork');
	
	
	global $pageno, $tabno, $aac2;
	//echo "<table class='widetable' border=0 cellspacing=0 cellpadding=5 align='center' width='100%'>\n";
	//echo "<tr><th>Address</th><th>Name</th><th>Comment</th><th>Allocation</th></tr>\n";

	$hl_ip = NULL;
	if (isset ($_REQUEST['hl_ip']))
	{
		$hl_ip = ip6_parse ($_REQUEST['hl_ip']);
		$mod->addOutput('AutoScroll', ip6_format($hl_ip));
		//addAutoScrollScript ('ip-' . ip6_format ($hl_ip));
	}

	$addresses = $netinfo['addrlist'];
	ksort ($addresses);
	markupIPAddrList ($addresses);

	// pager
	$maxperpage = getConfigVar ('IPV4_ADDRS_PER_PAGE');
	if (count ($addresses) > $maxperpage && $maxperpage > 0)
	{
		$mod->addOutput('HasPagination', true);
		$page = isset ($_REQUEST['pg']) ? $_REQUEST['pg'] : (isset ($hl_ip) ? getPageNumOfIPv6 ($addresses, $hl_ip, $maxperpage) : 0);
		$numpages = ceil (count ($addresses) / $maxperpage);
		$mod->addOutput('NumPages', $numpages);
		//echo "<center><h3>$numpages pages:</h3>";
		$pagesarray = array();
		for ($i=0; $i<$numpages; $i++)
		{
			if ($i == $page)
			{
				$pagesarray[] = array(
						'B' => '<b>',
						'BEnd' => '</b>',
						'I' => $i,
						'Link' => makeHref (array ('page' => $pageno, 'tab' => $tabno, 'id' => $netinfo['id'], 'pg' => $i))
				);
			}
			//$rendered_pager .= "<b>$i</b> ";
			else
			{
				$pagesarray[] = array(
						'I' => $i,
						'Link' => makeHref (array ('page' => $pageno, 'tab' => $tabno, 'id' => $netinfo['id'], 'pg' => $i))
				);
			}
			$mod->addOutput('Pages', $pagesarray);
			/*
			if ($i == $page)
				echo "<b>$i</b> ";
			else
				echo "<a href='" . makeHref (array ('page' => $pageno, 'tab' => $tabno, 'id' => $netinfo['id'], 'pg' => $i)) . "'>$i</a> "; */
		}
		//echo "</center>";
	}

	$i = 0;
	$interruped = FALSE;
	$prev_ip = ip_prev ($netinfo['ip_bin']);
	foreach ($addresses as $ip_bin => $addr)
	{
		if (isset ($page))
		{
			++$i;
			if ($i <= $maxperpage * $page)
				continue;
			elseif ($i > $maxperpage * ($page + 1))
			{
				$interruped = TRUE;
				break;
			}
		}

		if ($ip_bin != ip_next ($prev_ip))
			renderSeparator (ip_next ($prev_ip), ip_prev ($ip_bin), $hl_ip, $mod, 'IPList');
		$prev_ip = $ip_bin;

		$smod = $tplm->generateSubmodule('IPList', 'IPv6NetworkAddress', $mod);
		$smod->setNamespace('ipnetwork');
	
		// render IP change history
		$title = '';
		$history_class = '';
		if (isset ($addr['last_log']))
		{
			//$title = ' title="' . htmlspecialchars ($addr['last_log']['user'] . ', ' . formatAge ($addr['last_log']['time']) , ENT_QUOTES) . '"';
			$title = htmlspecialchars ($addr['last_log']['user'] . ', ' . formatAge ($addr['last_log']['time']) , ENT_QUOTES);
			$history_class = 'hover-history underline';
		}
		
		$smod->addOutput('Title', $title);
		$smod->addOutput('RowClass', $addr['class']);
		$smod->addOutput('Highlighted', ($hl_ip === $ip_bin ? 'highlight' : ''));
		$smod->addOutput('Class', $history_class);
		
		//$tr_class = $addr['class'] . ' tdleft' . ($hl_ip === $ip_bin ? ' highlight' : '');

		$smod->addOutput('Link', makeHref (array ('page' => 'ipaddress', 'ip' => $addr['ip'])));
		$smod->addOutput('IP', $addr['ip']);
		
		//echo "<tr class='$tr_class'>";
		//echo "<td><a class='$history_class' $title name='ip-${addr['ip']}' href='" . makeHref (array ('page' => 'ipaddress', 'ip' => $addr['ip'])) . "'>${addr['ip']}</a></td>";
		$editable =
			(empty ($addr['allocs']) || !empty ($addr['name'])
			&& permitted ('ipaddress', 'properties', 'editAddress')
			? 'editable'
			: '');
		$smod->addOutput('Editable', $editable);
		$smod->addOutput('Name', $addr['name']);
		$smod->addOutput('Comment', $addr['comment']);
		
		//echo "<td><span class='rsvtext $editable id-${addr['ip']} op-upd-ip-name'>${addr['name']}</span></td>";
		//echo "<td><span class='rsvtext $editable id-${addr['ip']} op-upd-ip-comment'>${addr['comment']}</span></td><td>";
		//$delim = '';
		if ( $addr['reserved'] == 'yes')
		{
			$smod->addOutput('Reserved', true);
			//echo "<strong>RESERVED</strong> ";
			//$delim = '; ';
		}
		
		$outarr = array();
		foreach ($addr['allocs'] as $ref)
		{
			
			$name = $ref['name'] . (!strlen ($ref['name']) ? '' : '@') . $ref['object_name'];
			$outarr[] = array(
				'Type'=>$aac2[$ref['type']],
				'Link'=>makeHref(array('page'=>'object', 'object_id'=>$ref['object_id'], 'tab' => 'default', 'hl_ip'=>$addr['ip'])),
				'Name'=>$name	
			);
			/**echo $delim . $aac2[$ref['type']];
			echo "<a href='".makeHref(array('page'=>'object', 'object_id'=>$ref['object_id'], 'tab' => 'default', 'hl_ip'=>$addr['ip']))."'>";
			echo $ref['name'] . (!strlen ($ref['name']) ? '' : '@');
			echo "${ref['object_name']}</a>";
			$delim = '; '; */
		}
		
		if (count($outarr)>0)
		{
			$smod->addOutput('Allocs', $outarr);
		}
		//if ($delim != '')
		//	$delim = '<br>';
		
		$outarr = array();
		foreach ($addr['vslist'] as $vs_id)
		{
			$vs = spotEntity ('ipv4vs', $vs_id);
			
			$outarr[] = array('Link'=>mkA ("${vs['name']}:${vs['vport']}/${vs['proto']}", 'ipv4vs', $vs['id']));
			//echo $delim . mkA ("${vs['name']}:${vs['vport']}/${vs['proto']}", 'ipv4vs', $vs['id']) . '&rarr;';
			//$delim = '<br>';
		}
		if (count($outarr)>0)
		{
			$smod->addOutput('VSList', $outarr);
		}
		
		$outarr = array();
		foreach ($addr['vsglist'] as $vs_id)
		{
			$vs = spotEntity ('ipvs', $vs_id);
			
			$outarr[] = array('Link'=>mkA ($vs['name'], 'ipvs', $vs['id']));
			//echo $delim . mkA ($vs['name'], 'ipvs', $vs['id']) . '&rarr;';
			//$delim = '<br>';
		}
		if (count($outarr)>0)
		{
			$smod->addOutput('VSGList', $outarr);
		}
		
		$outarr = array();
		foreach ($addr['rsplist'] as $rsp_id)
		{
			$rsp = spotEntity ('ipv4rspool', $rsp_id);
			
			$outarr[] = array('Link'=>mkA ($rsp['name'], 'ipv4rspool', $rsp['id']));
			//echo "${delim}&rarr;" . mkA ($rsp['name'], 'ipv4rspool', $rsp['id']);
			//$delim = '<br>';
		}
		
		if (count($outarr)>0)
		{
			$smod->addOutput('RSPList', $outarr);
		}
		//echo "</td></tr>\n";
	}
	if (! $interruped)
		renderSeparator (ip_next ($prev_ip), ip_last ($netinfo), $hl_ip, $mod, 'IPList');
	if (isset ($page))
	{ // bottom pager
		$mod->addOutput('BottomPager', true);
		//echo "<tr><td colspan=3>";
		if ($page > 0)
			$mod->addOutput('BottomPagerPrevLink', makeHref (array ('page' => $pageno, 'tab' => $tabno, 'id' => $netinfo['id'], 'pg' => $page - 1)));
			//echo "<a href='" . makeHref (array ('page' => $pageno, 'tab' => $tabno, 'id' => $netinfo['id'], 'pg' => $page - 1)) . "'><< prev</a> ";
		if ($page < $numpages - 1)
			$mod->addOutput('BottomPagerNextLink', makeHref (array ('page' => $pageno, 'tab' => $tabno, 'id' => $netinfo['id'], 'pg' => $page + 1)));
			//echo "<a href='" . makeHref (array ('page' => $pageno, 'tab' => $tabno, 'id' => $netinfo['id'], 'pg' => $page + 1)) . "'>next >></a> ";
		//echo "</td></tr>";
	}
	//echo "</table>";
	if (permitted (NULL, NULL, 'set_reserve_comment'))
		$mod->addOutput('UserHasEditPerm', true);
		//addJS ('js/inplace-edit.js');
}

function renderIPNetworkProperties ($id)
{
	global $pageno;
	$netdata = spotEntity ($pageno, $id);
	
	$tplm = TemplateManager::getInstance();
	
	$mod = $tplm->generateSubmodule('Payload', 'IPNetworkProperties');
	$mod->setNamespace('ipnetwork',true);
	
	$mod->addOutput('IP', $netdata['ip']);
	$mod->addOutput('Mask', $netdata['mask']);
	$mod->addOutput('Name', htmlspecialchars ($netdata['name'], ENT_QUOTES, 'UTF-8'));
	$mod->addOutput('Comment', htmlspecialchars ($netdata['comment'], ENT_QUOTES, 'UTF-8'));
	
	/*
	echo "<center><h1>${netdata['ip']}/${netdata['mask']}</h1></center>\n";
	echo "<table border=0 cellpadding=10 cellpadding=1 align='center'>\n";
	printOpFormIntro ('editRange');
	echo '<tr><td class=tdright><label for=nameinput>Name:</label></td>';
	echo "<td class=tdleft><input type=text name=name id=nameinput size=80 maxlength=255 value='";
	echo htmlspecialchars ($netdata['name'], ENT_QUOTES, 'UTF-8') . "'></tr>";
	echo '<tr><td class=tdright><label for=commentinput>Comment:</label></td>';
	echo "<td class=tdleft><textarea name=comment id=commentinput cols=80 rows=25>\n";
	echo htmlspecialchars ($netdata['comment'], ENT_QUOTES, 'UTF-8') . "</textarea></tr>";
	echo "<tr><td colspan=2 class=tdcenter>";
	printImageHREF ('SAVE', 'Save changes', TRUE);
	echo "</td></form></tr></table>\n";

	echo '<center>';*/
	if (! isIPNetworkEmpty ($netdata))
	{
		$mod->addOutput('NotEmpty', true);
		$mod->addOutput('AllocCount', count($netdata['addrlist']));
	}	
		//echo getOpLink (NULL, 'delete this prefix', 'nodestroy', 'There are ' . count ($netdata['addrlist']) . ' allocations inside');
	{
		$mod->addOutput('NotEmpty', false);
		$mod->addOutput('ID', $id);
	}
		//echo getOpLink (array('op'=>'del','id'=>$id), 'delete this prefix', 'destroy');
	//echo '</center>';
}

function renderIPAddress ($ip_bin)
{
	$tplm = TemplateManager::getInstance();
	$tplm->setTemplate('vanilla');
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule('Payload', 'IPAddress');
	$mod->setNamespace('ipaddress');
	
	global $aat, $nextorder;
	$address = getIPAddress ($ip_bin);
	//echo "<table border=0 class=objectview cellspacing=0 cellpadding=0>";
	//echo "<tr><td colspan=2 align=center><h1>${address['ip']}</h1></td></tr>\n";
	$mod->addOutput('IP', $address['ip']);
		 
	//echo "<tr><td class=pcleft>";

	$summary = array();
	if (strlen ($address['name']))
		$summary['Name'] = $address['name'];
	if (strlen ($address['comment']))
		$summary['Comment'] = $address['comment'];
	$summary['Reserved'] = $address['reserved'];
	$summary['Allocations'] = count ($address['allocs']);
	if (isset ($address['outpf']))
		$summary['Originated NAT connections'] = count ($address['outpf']);
	if (isset ($address['inpf']))
		$summary['Arriving NAT connections'] = count ($address['inpf']);
	renderEntitySummary ($address, 'summary', $summary, $mod, 'EntitySummary');

	// render SLB portlet
	if (! empty ($address['vslist']) or ! empty ($address['vsglist']) or ! empty ($address['rsplist']))
	{
		//startPortlet ("");
		if (! empty ($address['vsglist']))
		{
			//printf ("<h2>virtual service groups (%d):</h2>", count ($address['vsglist']));
			$mod->addOutput('VSGListCount', count ($address['vsglist']));				 
			foreach ($address['vsglist'] as $vsg_id)
				renderSLBEntityCell (spotEntity ('ipvs', $vsg_id), FALSE, $mod, 'SLBPortlet1');
		}

		if (! empty ($address['vslist']))
		{
			//printf ("<h2>virtual services (%d):</h2>", count ($address['vslist']));
			$mod->addOutput('VSListCount', count ($address['vslist']));				 
			foreach ($address['vslist'] as $vs_id)
				renderSLBEntityCell (spotEntity ('ipv4vs', $vs_id), FALSE, $mod, 'SLBPortlet2');
		}

		if (! empty ($address['rsplist']))
		{
			//printf ("<h2>RS pools (%d):</h2>", count ($address['rsplist']));
			$mod->addOutput('RSPListCount', count ($address['rsplist']));				 
			foreach ($address['rsplist'] as $rsp_id)
				renderSLBEntityCell (spotEntity ('ipv4rspool', $rsp_id), FALSE, $mod, 'SLBPortlet3');
		}
		//finishPortlet();
	}
	//echo "</td>\n";

	//echo "<td class=pcright>";
	if (isset ($address['class']) and ! empty ($address['allocs']))
	{
		//startPortlet ('allocations');
		//echo "<table class='widetable' cellpadding=5 cellspacing=0 border=0 align='center' width='100%'>\n";
		//echo "<tr><th>object</th><th>OS interface</th><th>allocation type</th></tr>\n";
		// render all allocation records for this address the same way
		$out = array();
		foreach ($address['allocs'] as $bond)
		{
			$out[] = array(
					'AddrClass'=>$address['class'],
					'Highlight'=>((($_REQUEST['hl_object_id']) and $_REQUEST['hl_object_id'] == $bond['object_id']) ? 'hightlight' : ''),
					'Link'=>makeHref(array ('page' => 'object', 'object_id' => $bond['object_id'], 'tab' => 'default', 'hl_ip' => $address['ip'])),
					'ObjName'=>$bond['object_name'],
					'Name'=>$bond['name'],
					'Type'=>$aat[$bond['type']]
			);
			//$tr_class = "${address['class']} tdleft";
			//if (isset ($_REQUEST['hl_object_id']) and $_REQUEST['hl_object_id'] == $bond['object_id'])
			//	$tr_class .= ' highlight';
			//echo "<tr class='$tr_class'>" .
			//	"<td><a href='" . makeHref (array ('page' => 'object', 'object_id' => $bond['object_id'], 'tab' => 'default', 'hl_ip' => $address['ip'])) . "'>${bond['object_name']}</td>" .
			//	"<td>${bond['name']}</td>" .
			//	"<td><strong>" . $aat[$bond['type']] . "</strong></td>" .
			//	"</tr>\n";
		}
		$mod->addOutput('Allocations',$out);
		//echo "</table><br><br>";
		//finishPortlet();
	}

	if (! empty ($address['rsplist']))
	{
		//startPortlet ("RS pools:");
		$out = array();
		foreach ($address['rsplist'] as $rsp_id)
		{
			$out[] = array('Pool'=>renderSLBEntityCell (spotEntity ('ipv4rspool', $rsp_id)));
			//renderSLBEntityCell (spotEntity ('ipv4rspool', $rsp_id),$mod,'RSPools');
			//echo '<br>';
		}
		$mod->addOutput('RSPools', $out);
		//finishPortlet();
	}

	if (! empty ($address['vsglist']))
		foreach ($address['vsglist'] as $vsg_id)
			renderSLBTriplets2 (spotEntity ('ipvs', $vsg_id), FALSE, $ip_bin, $mod, 'VSGList');

	if (! empty ($address['vslist']))
		renderSLBTriplets ($address, $mod, 'VSList');

	foreach (array ('outpf' => 'departing NAT rules', 'inpf' => 'arriving NAT rules') as $key => $title)
		if (! empty ($address[$key]))
		{
			$placeholder = ($key == 'outpf' ? 'NATDeparting' : 'NATArriving');
			//startPortlet ($title);
			//cho "<table class='widetable' cellpadding=5 cellspacing=0 border=0 align='center' width='100%'>\n";
			//echo "<tr><th>proto</th><th>from</th><th>to</th><th>comment</th></tr>\n";
			foreach ($address[$key] as $rule)
			{
				$smod = $tplm->generateSubmodule($placeholder, 'IPAddressNATRule', $mod);
				$smod->addOutput('Proto', $rule['proto']);
				$smod->addOutput('FromIp', $rule['localip']);
				$smod->addOutput('FromPort', $rule['localport']);
				$smod->addOutput('FromLink', makeHref (array ('page' => 'ipaddress',  'tab'=>'default', 'ip' => $rule['localip'])));
				$smod->addOutput('ToIp', $rule['remoteip']);
				$smod->addOutput('ToPort', $rule['remoteport']);
				$smod->addOutput('ToLink', makeHref (array ('page' => 'ipaddress',  'tab'=>'default', 'ip' => $rule['remoteip'])));
				$smod->addOutput('Description', $rule['description']);
				
				/** if ($rule['localport'])
				echo "<tr>";
				echo "<td>" . $rule['proto'] . "</td>";
				echo "<td>" . getRenderedIPPortPair ($rule['localip'], $rule['localport']) . "</td>";
				echo "<td>" . getRenderedIPPortPair ($rule['remoteip'], $rule['remoteport']) . "</td>";
				echo "<td>" . $rule['description'] . "</td></tr>";
				echo "</tr>"; */
			}
			//echo "</table>";
			//finishPortlet();
		}

	//echo "</td></tr>";
	//echo "</table>\n";
}

function renderIPAddressProperties ($ip_bin)
{
	$address = getIPAddress ($ip_bin);
	
	$tplm = TemplateManager::getInstance();
	$tplm->setTemplate('vanilla');
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule('Payload', 'IPAddressProperties');
	$mod->setNamespace('ipaddress',true);
	$mod->setLock();
	
	$mod->addOutput('Name', $address['name']);
	$mod->addOutput('Comment', $address['Comment']);
	$mod->addOutput('Checked', ($address['reserved']=='yes') ? 'checked' : '');
	$mod->addOutput('Ip', $address['ip']);
	
	//echo "<center><h1>${address['ip']}</h1></center>\n";

	/**startPortlet ('update');
	echo "<table border=0 cellpadding=10 cellpadding=1 align='center'>\n";
	printOpFormIntro ('editAddress');
	echo '<tr><td class=tdright><label for=id_name>Name:</label></td>';
	echo "<td class=tdleft><input type=text name=name id=id_name size=20 value='${address['name']}'></tr>";
	echo '<tr><td class=tdright><label for=id_comment>Comment:</label></td>';
	echo "<td class=tdleft><input type=text name=comment id=id_comment size=20 value='${address['comment']}'></tr>";
	echo '<td class=tdright><label for=id_reserved>Reserved:</label></td>';
	echo "<td class=tdleft><input type=checkbox name=reserved id=id_reserved size=20 ";
	echo ($address['reserved']=='yes') ? 'checked' : '';
	echo "></tr><tr><td class=tdleft>";
	printImageHREF ('SAVE', 'Save changes', TRUE);
	echo "</td></form><td class=tdright>";*/
	if (!strlen ($address['name']) and $address['reserved'] == 'no')
		$mod->addOutput('Undeletable', true);
	//else
	//{
		//printOpFormIntro ('editAddress', array ('name' => '', 'reserved' => '', 'comment' => ''));
		//printImageHREF ('CLEAR', 'Release', TRUE);
		//echo "</form>";
	//}
	//echo "</td></tr></table>\n";
	//finishPortlet();
}

function renderIPAddressAllocations ($ip_bin)
{
	function printNewItemTR ($parent,$placeholder)
	{
		global $aat;
		
		$tplm = TemplateManager::getInstance();
		
		$mod = $tplm->generateSubmodule($placeholder, 'IPAddressAllocationNew', $parent);
		$mod->addOutput('Select', getSelect(getNarrowObjectList ('IPV4OBJ_LISTSRC'), array ('name' => 'object_id', 'tabindex' => 100)));
		$mod->addOutput('TypeSelect', getSelect ($aat, array ('name' => 'bond_type', 'tabindex' => 102, 'regular')));
		
		/*
		printOpFormIntro ('add');
		echo "<tr><td>";
		printImageHREF ('add', 'allocate', TRUE);
		echo "</td><td>";
		printSelect (getNarrowObjectList ('IPV4OBJ_LISTSRC'), array ('name' => 'object_id', 'tabindex' => 100));
		echo "</td><td><input type=text tabindex=101 name=bond_name size=10></td><td>";
		printSelect ($aat, array ('name' => 'bond_type', 'tabindex' => 102, 'regular'));
		echo "</td><td>";
		printImageHREF ('add', 'allocate', TRUE, 103);
		echo "</td></form></tr>";*/
	}
	global $aat;

	$address = getIPAddress ($ip_bin);
	
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate('vanilla');
	//$tplm->createMainModule('index');
	
	$mod = $tplm->generateSubmodule('Payload', 'IPAddressAllocation');
	$mod->setNamespace('ipaddress',true);
	$mod->setLock();
	
	$mod->addOutput('Ip', $address['ip']);
	//echo "<center><h1>${address['ip']}</h1></center>\n";
	//echo "<table class='widetable' cellpadding=5 cellspacing=0 border=0 align='center'>\n";
	//echo "<tr><th>&nbsp;</th><th>object</th><th>OS interface</th><th>allocation type</th><th>&nbsp;</th></tr>\n";

	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
		printNewItemTR($mod,'NewTop');
	if (isset ($address['class']))
	{
		$class = $address['class'];
		$mod->addOutput('Class', $class);
		if ($address['reserved'] == 'yes')
			$mod->addOutput('Reserved', true);
			//echo "<tr class='${class}'><td colspan=3>&nbsp;</td><td class=tdleft><strong>RESERVED</strong></td><td>&nbsp;</td></tr>";
		foreach ($address['allocs'] as $bond)
		{
			$smod = $tplm->generateSubmodule('List', 'IPAddressAllocationElement', $mod);
			$smod->addOutput('Class', $class);
			$smod->addOutput('ObjectId', $bond['object_id']);
			$smod->addOutput('ObjectName', $bond['object_name']);
			$smod->addOutput('BondName', $bond['name']);
			$smod->addOutput('Link', makeHref (array ('page' => 'object', 'object_id' => $bond['object_id'], 'hl_ip' => $address['ip'])));
			$smod->addOutput('TypeSelect', getSelect($aat, array ('name' => 'bond_type'), $bond['type']));
			/**echo "<tr class='$class'>";
			printOpFormIntro ('upd', array ('object_id' => $bond['object_id']));
			echo "<td>" . getOpLink (array ('op' => 'del', 'object_id' => $bond['object_id'] ), '', 'delete', 'Unallocate address') . "</td>";
			echo "<td><a href='" . makeHref (array ('page' => 'object', 'object_id' => $bond['object_id'], 'hl_ip' => $address['ip'])) . "'>${bond['object_name']}</td>";
			echo "<td><input type='text' name='bond_name' value='${bond['name']}' size=10></td><td>";
			printSelect ($aat, array ('name' => 'bond_type'), $bond['type']);
			echo "</td><td>";
			printImageHREF ('save', 'Save changes', TRUE);
			echo "</td></form></tr>\n";*/
		}
	}
	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
		printNewItemTR($mod,'NewBottom');
	//echo "</table><br><br>";
}

function renderNATv4ForObject ($object_id)
{
	function printNewItemTR ($alloclist, $parent, $placeholder)
	{
		$tplm = TemplateManager::getInstance();
				
		$mod = $tplm->generateSubmodule($placeholder,"RenderNATv4ForObject_printNew", $parent);
		$mod->setNamespace("object");
			
		//printOpFormIntro ('addNATv4Rule');
		//echo "<tr align='center'><td>";
		//printImageHREF ('add', 'Add new NAT rule', TRUE);
		//echo '</td><td>';
		//printSelect (array ('TCP' => 'TCP', 'UDP' => 'UDP'), array ('name' => 'proto'));
		printSelect (array ('TCP' => 'TCP', 'UDP' => 'UDP'), array ('name' => 'proto'), NULL, $mod, 'printTcpUdpSel');
		//echo "<select name='localip' tabindex=1>";

		$allAllocOut = array();
		foreach ($alloclist as $ip_bin => $alloc)
		{
			$ip = $alloc['addrinfo']['ip'];
			$name = (!isset ($alloc['addrinfo']['name']) or !strlen ($alloc['addrinfo']['name'])) ? '' : (' (' . niftyString ($alloc['addrinfo']['name']) . ')');
			$osif = (!isset ($alloc['osif']) or !strlen ($alloc['osif'])) ? '' : ($alloc['osif'] . ': ');
			//echo "<option value='${ip}'>${osif}${ip}${name}</option>";
			$allAllocOut[] = array('ip' => $ip, 'osif' => $osif, 'name' => $name);
		}
		$mod->addOutput("allAlloc", $allAllocOut);
		
		//echo "</select>:<input type='text' name='localport' size='4' tabindex=2></td>";
		//echo "<td><input type='text' name='remoteip' id='remoteip' size='10' tabindex=3>";
		$mod->addOutput("hrefForHelper", makeHrefForHelper ('inet4list'));
			 
		/*echo "<a href='javascript:;' onclick='window.open(\"" . makeHrefForHelper ('inet4list');
		echo "\", \"findobjectip\", \"height=700, width=400, location=no, menubar=no, resizable=yes, scrollbars=no, status=no, titlebar=no, toolbar=no\");'>";
		printImageHREF ('find', 'Find object');
		echo "</a>";
		echo ":<input type='text' name='remoteport' size='4' tabindex=4></td><td></td>";
		echo "<td colspan=1><input type='text' name='description' size='20' tabindex=5></td><td>";
		printImageHREF ('add', 'Add new NAT rule', TRUE, 6);
		echo "</td></tr></form>";*/	
	}

	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderNATv4ForObject");
	$mod->setNamespace("object");
		
	$focus = spotEntity ('object', $object_id);
	amplifyCell ($focus);
	/*echo "<center><h2>locally performed NAT</h2></center>";

	echo "<table class='widetable' cellpadding=5 cellspacing=0 border=0 align='center'>\n";
	echo "<tr><th></th><th>Match endpoint</th><th>Translate to</th><th>Target object</th><th>Comment</th><th>&nbsp;</th></tr>\n";
	*/
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
		printNewItemTR ($focus['ipv4'], $mod, 'printNewItemTop_mod');
	//	printNewItemTR ($focus['ipv4']);
	foreach ($focus['nat4']['out'] as $pf)
	{
		$class = 'trerror';
		$osif = '';
		$localip_bin = ip4_parse ($pf['localip']);
		if (isset ($focus['ipv4'][$localip_bin]))
		{
			$class = $focus['ipv4'][$localip_bin]['addrinfo']['class'];
			$osif = $focus['ipv4'][$localip_bin]['osif'] . ': ';
		}

		$singlePort = array('class' => $class, 'proto' => $pf['proto'], 'osif' => $osif);
		$singlePort['opLink'] = getOpLink  (
			array (
				'op'=>'delNATv4Rule',
				'localip'=>$pf['localip'],
				'localport'=>$pf['localport'],
				'remoteip'=>$pf['remoteip'],
				'remoteport'=>$pf['remoteport'],
				'proto'=>$pf['proto'],
			), '', 'delete', 'Delete NAT rule'
		);
		/*echo "<tr class='$class'>";
		echo "<td>" . getOpLink  (
			array (
				'op'=>'delNATv4Rule',
				'localip'=>$pf['localip'],
				'localport'=>$pf['localport'],
				'remoteip'=>$pf['remoteip'],
				'remoteport'=>$pf['remoteport'],
				'proto'=>$pf['proto'],
			), '', 'delete', 'Delete NAT rule'
		) . "</td>";
		echo "<td>${pf['proto']}/${osif}" . getRenderedIPPortPair ($pf['localip'], $pf['localport']);*/
		getRenderedIPPortPair ($pf['localip'], $pf['localport'], $mod, 'portpair_local_mod');
		if (strlen ($pf['local_addr_name']))
			$singlePort['local_addr_name'] = $pf['local_addr_name'];
		//	echo ' (' . $pf['local_addr_name'] . ')';
		//echo "</td>";
		//echo "<td>" . getRenderedIPPortPair ($pf['remoteip'], $pf['remoteport']) . "</td>";
		getRenderedIPPortPair ($pf['remoteip'], $pf['remoteport'],$mod, 'portpair_remote_mod');

		$address = getIPAddress (ip4_parse ($pf['remoteip']));
		$singlePort['mkAList'] = '';
		//echo "<td class='description'>";
		if (count ($address['allocs']))
			foreach ($address['allocs'] as $bond)
				$singlePort['mkAList'] .= mkA ("${bond['object_name']}(${bond['name']})", 'object', $bond['object_id']) . ' ';
		//		echo mkA ("${bond['object_name']}(${bond['name']})", 'object', $bond['object_id']) . ' ';
		elseif (strlen ($pf['remote_addr_name']))
			$singlePort['remote_addr_name'] = $pf['remote_addr_name'];
		//	echo '(' . $pf['remote_addr_name'] . ')';
		$singlePort['opFormIntro'] = 
		printOpFormIntro
		(
			'updNATv4Rule',
			array
			(
				'localip' => $pf['localip'],
				'localport' => $pf['localport'],
				'remoteip' => $pf['remoteip'],
				'remoteport' => $pf['remoteport'],
				'proto' => $pf['proto']
			)
		);
		//echo "</td><td class='description'>";
		//echo "<input type='text' name='description' value='${pf['description']}'></td><td>";
		//printImageHREF ('save', 'Save changes', TRUE);
		$singlePort['saveImg'] = printImageHREF ('save', 'Save changes', TRUE);
		//echo "</td></form></tr>";
		$singlePort['description'] = $pf['description'];

		//Using loop array style paramter for output
		$tplm->generateSubmodule('AllNatv4Ports','RenderNATv4ForObject_NATv4Port', $mod, false, $singlePort);
	}
		 
	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
		printNewItemTR ($focus['ipv4'], $mod, 'printNewItemBottom_mod');
	//	printNewItemTR ($focus['ipv4']);

	//echo "</table><br><br>";
	if (!count ($focus['nat4']))
		return;
	$mod->addOutput("hasFocusNat4", true);
		 
	/*echo "<center><h2>arriving NAT connections</h2></center>";
	echo "<table class='widetable' cellpadding=5 cellspacing=0 border=0 align='center'>\n";
	echo "<tr><th></th><th>Source</th><th>Source objects</th><th>Target</th><th>Description</th></tr>\n";*/

	$allNatv4FocusOut = array();
	foreach ($focus['nat4']['in'] as $pf)
	{
		$singleFocus = array('proto' => $pf['proto'], 'description' => $pf['description']);
		$singleFocus['opLink'] = getOpLink (
			array(
				'op'=>'delNATv4Rule',
				'localip'=>$pf['localip'],
				'localport'=>$pf['localport'],
				'remoteip'=>$pf['remoteip'],
				'remoteport'=>$pf['remoteport'],
				'proto'=>$pf['proto'],
			), '', 'delete', 'Delete NAT rule');
		$singleFocus['mkA'] = mkA ($pf['object_name'], 'object', $pf['object_id']);
		getRenderedIPPortPair ($pf['localip'], $pf['localport'], $mod, 'focus_portpair_local_mod');
		getRenderedIPPortPair ($pf['remoteip'], $pf['remoteport'], $mod, 'focus_portpair_remote_mod');
		/*echo "<tr><td>" . getOpLink (
			array(
				'op'=>'delNATv4Rule',
				'localip'=>$pf['localip'],
				'localport'=>$pf['localport'],
				'remoteip'=>$pf['remoteip'],
				'remoteport'=>$pf['remoteport'],
				'proto'=>$pf['proto'],
			), '', 'delete', 'Delete NAT rule'
		) . "</td>";
		echo "<td>${pf['proto']}/" . getRenderedIPPortPair ($pf['localip'], $pf['localport']) . "</td>";
		echo '<td class="description">' . mkA ($pf['object_name'], 'object', $pf['object_id']);
		echo "</td><td>" . getRenderedIPPortPair ($pf['remoteip'], $pf['remoteport']) . "</td>";
		echo "<td class='description'>${pf['description']}</td></tr>";*/
		$allNatv4FocusOut[] = $singleFocus;
	}
	$mod->addOutput("allNatv4Focus", $allNatv4FocusOut);
		 
	//echo "</table><br><br>";
}

function renderAddMultipleObjectsForm ()
{
	$typelist = readChapter (CHAP_OBJTYPE, 'o');
	$typelist[0] = 'select type...';
	$typelist = cookOptgroups ($typelist);
	$max = getConfigVar ('MASSCOUNT');
	$tabindex = 100;

	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule('index');

	$mod = $tplm->generateSubmodule("Payload","AddMultipleObjects");
	$mod->setNamespace("depot");

	// exclude location-related object types
	global $location_obj_types;
	foreach ($typelist['other'] as $key => $value)
		if ($key > 0 && in_array($key, $location_obj_types))
			unset($typelist['other'][$key]);

//	startPortlet ('Distinct types, same tags');
	$mod->setOutput("formIntro", printOpFormIntro ('addObjects'));
//	printOpFormIntro ('addObjects');
//	echo '<table border=0 align=center>';
//	echo "<tr><th>Object type</th><th>Common name</th><th>Visible label</th>";
//	echo "<th>Asset tag</th><th>Tags</th></tr>\n";
	$objectListOutput = array();
	for ($i = 0; $i < $max; $i++)
	{
		$singleEntry = array();
	//	echo '<tr><td>';
		// Don't employ DEFAULT_OBJECT_TYPE to avoid creating ghost records for pre-selected empty rows.
		//printNiftySelect ($typelist, array ('name' => "${i}_object_type_id", 'tabindex' => $tabindex), 0);
		$singleEntry['niftySelect'] = printNiftySelect ($typelist, array ('name' => "${i}_object_type_id", 'tabindex' => $tabindex), 0);
 		//echo '</td>';
 		$singleEntry['i'] = $i;
 		$singleEntry['tabindex'] = $tabindex;
 		
		//echo "<td><input type=text size=30 name=${i}_object_name tabindex=${tabindex}></td>";
		//echo "<td><input type=text size=30 name=${i}_object_label tabindex=${tabindex}></td>";
		//echo "<td><input type=text size=20 name=${i}_object_asset_no tabindex=${tabindex}></td>";
		if ($i == 0)
		{
			$singleEntry['max'] = $max;
			$singleEntry['renderedEnityTags'] = renderNewEntityTags ('object');
		//	echo "<td valign=top rowspan=${max}>";
		//	renderNewEntityTags ('object');
		//	echo "</td>\n";
		}
		else
			$singleEntry['renderedEnityTags'] = "";
		
		//echo "</tr>\n";
		$tabindex++;
		$objectListOutput[] = $singleEntry;
	}
	$mod->setOutput("objectListData", $objectListOutput);
		 
//	echo "<tr><td class=submit colspan=5><input type=submit name=got_fast_data value='Go!'></td></tr>\n";
//	echo "</form></table>\n";
//	finishPortlet();

//	startPortlet ('Same type, same tags');
	$mod->setOutput("formIntroLotOfObjects", printOpFormIntro ('addLotOfObjects'));
//	printOpFormIntro ('addLotOfObjects');
//	echo "<table border=0 align=center><tr><th>names</th><th>type</th></tr>";
//	echo "<tr><td rowspan=3><textarea name=namelist cols=40 rows=25>\n";
//	echo "</textarea></td><td valign=top>";

	printNiftySelect ($typelist, array ('name' => 'global_type_id'), getConfigVar ('DEFAULT_OBJECT_TYPE'), false, $mod, "sameTypeSameTagSelect");
//	printNiftySelect ($typelist, array ('name' => 'global_type_id'), getConfigVar ('DEFAULT_OBJECT_TYPE'));
//	echo "</td></tr>";
//	echo "<tr><th>Tags</th></tr>";
//	echo "<tr><td valign=top>";
		 
	$mod->setOutput("renderedEnityTag", renderNewEntityTags ('object'));	 
//	renderNewEntityTags('object', $mod, 'renderedEnityTag');

//	renderNewEntityTags ('object');
//	echo "</td></tr>";
//	echo "<tr><td colspan=2><input type=submit name=got_very_fast_data value='Go!'></td></tr></table>\n";
//	echo "</form>\n";
//	finishPortlet();
}

function searchHandler()
{
	//Handles the search strings and genererats a result website

	$terms = trim ($_REQUEST['q']);
	if (!strlen ($terms))
		throw new InvalidRequestArgException('q', $_REQUEST['q'], 'Search string cannot be empty.');
	renderSearchResults ($terms, searchEntitiesByText ($terms));
}

function renderSearchResults ($terms, $summary)
{
	//Changed for template engine 
	//Initalising
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	// calculate the number of found objects
	

	$nhits = 0;
	foreach ($summary as $realm => $list)
		$nhits += count ($list);

	if ($nhits == 0)
	{
		//echo "<center><h2>Nothing found for '${terms}'</h2></center>";
		$params = array("Terms" => $terms );
		$mod = $tplm->generateSubmodule("Payload", "NoSearchItemFound", null, true, $params);
		return;
	}
	elseif ($nhits == 1)
	{
		foreach ($summary as $realm => $record)
		{
			if (is_array ($record))
				$record = array_shift ($record);
			break;
		}
		$url = buildSearchRedirectURL ($realm, $record);
		if (isset ($url))
			redirectUser ($url);
	}
	global $nextorder;
	$order = 'odd';

	$mod = $tplm->generateSubmodule("Payload", "SearchMain");
	$mod->setNamespace("search",true);
	$mod->setOutput("NHITS", $nhits);
	$mod->setOutput("TERMS", $terms);
	//echo "<center><h2>${nhits} result(s) found for '${terms}'</h2></center>";

	foreach ($summary as $where => $what)
		switch ($where)
		{
			case 'object':

				//startPortlet ("<a href='index.php?page=depot'>Objects</a>");
				//echo '<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>';
				//echo '<tr><th>what</th><th>why</th></tr>';
				$allObjects = $tplm->generateSubmodule("FoundItems", "SearchAllObjects", $mod);

				
				foreach ($what as $obj)
				{
					$foundObject = $tplm->generateSubmodule("foundObject", "SearchObject", $allObjects);
			//		echo "<tr class=row_${order} valign=top><td>";
					$object = spotEntity ('object', $obj['id']);
					
			//		echo "</td><td class=tdleft>";
		
					$foundObject->setOutput("objImage", renderCell($object));
					$foundObject->setOutput("rowOrder", $order);

					if (isset ($obj['by_attr']))
					{
						// only explain non-obvious reasons for listing
						
						$outArray = array();
						$foundObject->setOutput('ObjectsByAttr', true);

					//	echo '<ul>';
						foreach ($obj['by_attr'] as $attr_name)
							if ($attr_name != 'name')
								$outArray[] = array("Attr_Name" => $attr_name);
					//			echo "<li>${attr_name} matched</li>";
					//	echo '</ul>';

						
						$foundObject->setOutput("Objects_Attr", $outArray);
					}


					if (isset ($obj['by_sticker']))
					{
						$outArray = array();
						$foundObject->setOutput('ObjectsBySticker', true);

						//echo '<table>';
						$aval = getAttrValues ($obj['id']);
						foreach ($obj['by_sticker'] as $attr_id)
						{
							$record = $aval[$attr_id];
							$outArray[] = array('Name' => $record['name'],
												 'AttrValue' => formatAttributeValue ($record));
							//echo "<tr><th width='50%' class=sticker>${record['name']:</th>";
							//echo "<td class=sticker>" . formatAttributeValue ($record) . "</td></tr>";
						}
						//echo '</table>';
						$foundObject->setOutput("Objects_Sticker", $outArray);
					}


					if (isset ($obj['by_port']))
					{
						$outArray = array();
						$foundObject->setOutput('ObjectsByPort', true);

						//echo '<table>';
						amplifyCell ($object);
						foreach ($obj['by_port'] as $port_id => $text)

							foreach ($object['ports'] as $port)
								if ($port['id'] == $port_id)
								{
									$port_href = '<a href="' . makeHref (array
									(
										'page' => 'object',
										'object_id' => $object['id'],
										'hl_port_id' => $port_id
									)) . '">port ' . $port['name'] . '</a>';
									$outArray[] = array('Href' =>  $port_href,
														'Text' => $text );
								//	echo "<tr><td>${port_href}:</td>";
								//	echo "<td class=tdleft>${text}</td></tr>";
									break; // next reason
								}
						//echo '</table>';
						$foundObject->setOutput("Objects_Port", $outArray);
					}


					if (isset ($obj['by_iface']))
					{
						$outArray = array();
						$foundObject->setOutput('ObjectsByIface', true);

					//	echo '<ul>';
						foreach ($obj['by_iface'] as $ifname)
							$outArray[] = array( 'Ifname' => $ifname);
					//		echo "<li>interface ${ifname}</li>";
					//	echo '</ul>';
						$foundObject->setOutput("Objects_Iface", $outArray);
					}

					if (isset ($obj['by_nat']))
					{
						$outArray = array();
						$foundObject->setOutput('ObjectsByNAT', true);

					//	echo '<ul>';
						foreach ($obj['by_nat'] as $comment)
							$outArray[] = array('Comment' => $comment);
					//		echo "<li>NAT rule: ${comment}</li>";
					//	echo '</ul>';
						$foundObject->setOutput("Objects_NAT", $outArray);
					}

					if (isset ($obj['by_cableid']))
					{
						$outArray = array();
						$foundObject->setOutput('ObjectsByCableID', true);

						//echo '<ul>';
						foreach ($obj['by_cableid'] as $cableid)
							$outArray[] = array('CableID' => $cableid);
						//	echo "<li>link cable ID: ${cableid}</li>";
						//echo '</ul>';
						$foundObject->setOutput("Objects_CableID", $outArray);
					}
					//echo "</td></tr>";
					$order = $nextorder[$order];
				}
				//echo '</table>';
				//finishPortlet();
				break;

			case 'ipv4net':
			case 'ipv6net':

				$foundIPVNet = $tplm->generateSubmodule("FoundItems", "SearchIpv6net", $mod);

				if ($where == 'ipv4net')
				{
					$foundIPVNet->setOutput("IpvSpace", "ipv4space");
					$foundIPVNet->setOutput("IpvSpaceName", "IPv4 networks");
					//startPortlet ("<a href='index.php?page=ipv4space'>IPv4 networks</a>");
				}
				elseif ($where == 'ipv6net')
				{
					$foundIPVNet->setOutput("IpvSpace", "ipv6space");
					$foundIPVNet->setOutput("IpvSpaceName", "IPv6 networks");
					//startPortlet ("<a href='index.php?page=ipv6space'>IPv6 networks</a>");
				}	
				//echo '<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>';
				$ipvOutArray = array();

				foreach ($what as $cell)
				{
					//$ipvOutArray['order'] = $order;
					$ipvOutArray[] = array('rowOrder' => $order,
										   'rendCell' => renderCell($cell));
	//				echo "<tr class=row_${order} valign=top><td>";
							
//TODO: Change renderCell to  renderCell ($cell);
	//				renderCell($cell);
	//				echo "</td></tr>\n";
					$order = $nextorder[$order];
				}

				$foundIPVNet->setOutput("IPVNetObjs",$ipvOutArray);
	//			echo '</table>';
	//			finishPortlet();
				break;
			case 'ipv4addressbydescr':
			case 'ipv6addressbydescr':
				$foundIPVAddress = $tplm->generateSubmodule("FoundItems", "SearchIpv6address", $mod);

				if ($where == 'ipv4addressbydescr')
					$foundIPVAddress->setOutput("sectionHeader", 'IPv4 addresses');
	//				startPortlet ('IPv4 addresses');
				elseif ($where == 'ipv6addressbydescr')
					$foundIPVAddress->setOutput("sectionHeader", 'IPv6 addresses');
	//				startPortlet ('IPv6 addresses');
	//			echo '<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>';
				// FIXME: address, parent network, routers (if extended view is enabled)
	//			echo '<tr><th>Address</th><th>Description</th></tr>';
				foreach ($what as $addr)
				{
	//				echo "<tr class=row_${order}><td class=tdleft>";
					$fmt = ip_format ($addr['ip']);
					$parentnet = getIPAddressNetworkId ($addr['ip']);

					$singleAddr = array( 'rowOrder' => $order,
											'rowLink' => makeHref (array ( 'page' => strlen ($addr['ip']) == 16 ? 'ipv6net' : 'ipv4net',
																	'id' => $parentnet,
																	'tab' => 'default',
																	'hl_ip' => $fmt)),
											'rowFmt' => $fmt,
											'rowAddr' => $addr['name'],
											'parentNetSet' => $parentnet !== NULL);
	//				if ($parentnet !== NULL)

	//					echo "<a href='" . makeHref (array (
	//							'page' => strlen ($addr['ip']) == 16 ? 'ipv6net' : 'ipv4net',
	//							'id' => $parentnet,
	//							'tab' => 'default',
	//							'hl_ip' => $fmt,
	//						)) . "'>${fmt}</a></td>";
	//				else
	//					echo "<a href='index.php?page=ipaddress&tab=default&ip=${fmt}'>${fmt}</a></td>";
	//				echo "<td class=tdleft>${addr['name']}</td></tr>";
					$tplm->generateSubmodule('AllSearchAddrs','SearchIpv6address_Object', $foundIPVAddress, false, $singleAddr);
					$order = $nextorder[$order];

				}
	//			echo '</table>';
	//			finishPortlet();
				

				break;
			case 'ipv4rspool':
				$foundIPVSpool = $tplm->generateSubmodule("FoundItems", "SearchStdType", $mod);
				$foundIPVSpool->setOutput("page", "ipv4slb&tab=rspools");
				$foundIPVSpool->setOutput("title", "RS pools");
				
	//			startPortlet ("<a href='index.php?page=ipv4slb&tab=rspools'>RS pools</a>");
	//			echo '<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>';
				$ipvOutArray = array();
				foreach ($what as $cell)
				{
					$ipvOutArray[] = array( 'rowOrder' => $order,
											'renderedCell' => renderCell ($cell));
	//				echo "<tr class=row_${order}><td class=tdleft>";
	//				renderCell ($cell);
	//				echo "</td></tr>";
					$order = $nextorder[$order];
				}
				$foundIPVSpool->setOutput("searchLoopObjs", $ipvOutArray);
	//			echo '</table>';
	//			finishPortlet();

				break;
			case 'ipvs':
				$foundIPVS = $tplm->generateSubmodule("FoundItems", "SearchStdType", $mod);
				$foundIPVS->setOutput("page", "ipv4slb&tab=vs");
				$foundIPVS->setOutput("title", "VS groups");
				
	//			startPortlet ("<a href='index.php?page=ipv4slb&tab=vs'>VS groups</a>");
	//			echo '<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>';
				$ipvOutArray = array();
				foreach ($what as $cell)
				{
					$ipvOutArray[] = array( 'rowOrder' => $order,
											'renderedCell' => renderCell ($cell));
	//				echo "<tr class=row_${order}><td class=tdleft>";
	//				renderCell ($cell);
	//				echo "</td></tr>";
					$order = $nextorder[$order];
				}

	//			echo '</table>';
	//			finishPortlet();
				$foundIPVS->setOutput("searchLoopObjs", $ipvOutArray);
				break;
			case 'ipv4vs':
				$foundIP4vs = $tplm->generateSubmodule("FoundItems", "SearchStdType", $mod);
				$foundIP4vs->setOutput("page", "ipv4slb&tab=default");
				$foundIP4vs->setOutput("title", "Virtual services");

	//			startPortlet ("<a href='index.php?page=ipv4slb&tab=default'>Virtual services</a>");
	//			echo '<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>';
				$ipvOutArray = array();
				foreach ($what as $cell)
				{
					$ipvOutArray[] = array( 'rowOrder' => $order,
											'renderedCell' => renderCell ($cell));
	//				echo "<tr class=row_${order}><td class=tdleft>";
	//				renderCell ($cell);
	//				echo "</td></tr>";
					$order = $nextorder[$order];
				}
	//			echo '</table>';
	//			finishPortlet();
				$foundIP4vs->setOutput("searchLoopObjs", $ipvOutArray);
				break;
			case 'user':
				$foundUser = $tplm->generateSubmodule("FoundItems", "SearchStdType", $mod);
				$foundUser->setOutput("page", "userlist");
				$foundUser->setOutput("title", "Users");

	//			startPortlet ("<a href='index.php?page=userlist'>Users</a>");
	//			echo '<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>';
				$userOutArray = array();
				foreach ($what as $item)
				{
					$userOutArray[] = array( 'rowOrder' => $order,
											'renderedCell' => renderCell ($item));
	//				echo "<tr class=row_${order}><td class=tdleft>";
	//				renderCell ($item);
	//				echo "</td></tr>";
					$order = $nextorder[$order];
				}
	//			echo '</table>';
	//			finishPortlet();
				$foundUser->setOutput("searchLoopObjs", $userOutArray);
				break;
			case 'file':
				$foundFile = $tplm->generateSubmodule("FoundItems", "SearchStdType", $mod);
				$foundFile->setOutput("page", "files");
				$foundFile->setOutput("title", "Files");

	//			startPortlet ("<a href='index.php?page=files'>Files</a>");
	//			echo '<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>';
				$fileOutArray = array();
				foreach ($what as $cell)
				{
					$fileOutArray[] = array( 'rowOrder' => $order,
											'renderedCell' => renderCell ($cell));
	//				echo "<tr class=row_${order}><td class=tdleft>";
	//				renderCell ($item);
	//				echo "</td></tr>";
					$order = $nextorder[$order];
				}
	//			echo '</table>';
	//			finishPortlet();

				$foundFile->setOutput("searchLoopObjs", $fileOutArray);
				break;
			case 'rack':
				$foundRack = $tplm->generateSubmodule("FoundItems", "SearchStdType", $mod);
				$foundRack->setOutput("page", "rackspace");
				$foundRack->setOutput("title", "Racks");

	//			startPortlet ("<a href='index.php?page=rackspace'>Racks</a>");
	//			echo '<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>';
				$rackOutArray = array();
				foreach ($what as $cell)
				{
					$rackOutArray[] = array( 'rowOrder' => $order,
											'renderedCell' => renderCell ($cell));
	//				echo "<tr class=row_${order}><td class=tdleft>";
	//				renderCell ($cell);
	//				echo "</td></tr>";
					$order = $nextorder[$order];
				}
	//			echo '</table>';
	//			finishPortlet();

				$foundRack->setOutput("searchLoopObjs", $rackOutArray);
				break;
			case 'row':
				$foundRow = $tplm->generateSubmodule("FoundItems", "SearchStdType", $mod);
				$foundRow->setOutput("page", "rackspace");
				$foundRow->setOutput("title", "Rack rows");

	//			startPortlet ("<a href='index.php?page=rackspace'>Rack rows</a>");
	//			echo '<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>';
				$rowOutArray = array();
				foreach ($what as $cell)
				{
					$rowOutArray[] = array( 'rowOrder' => $order,
											'renderedCell' => mkCellA ($cell));
	//				echo "<tr class=row_${order}><td class=tdleft>";
	//				mkCellA ($cell);
	//				echo "</td></tr>";
					$order = $nextorder[$order];
				}
	//			echo '</table>';
	//			finishPortlet();

				$foundRow->setOutput("searchLoopObjs", $rowOutArray);
				break;
			case 'location':
				$foundLoc = $tplm->generateSubmodule("FoundItems", "SearchStdType", $mod);
				$foundLoc->setOutput("page", "rackspace");
				$foundLoc->setOutput("title", "Locations");

	//			startPortlet ("<a href='index.php?page=rackspace'>Locations</a>");
	//			echo '<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>';
				$locOutArray = array();
				foreach ($what as $cell)
				{
					$locOutArray[] = array( 'rowOrder' => $order,
											'renderedCell' => renderCell ($cell));
	//				echo "<tr class=row_${order}><td class=tdleft>";
	//				renderCell ($cell);
	//				echo "</td></tr>";
					$order = $nextorder[$order];
				}
	//			echo '</table>';
	//			finishPortlet();
				
				$foundLoc->setOutput("searchLoopObjs", $locOutArray);
				break;
			case 'vlan':
				$foundVLan = $tplm->generateSubmodule("FoundItems", "SearchStdType", $mod);
				$foundVLan->setOutput("page", "8021q");
				$foundVLan->setOutput("title", "VLANs");

	//			startPortlet ("<a href='index.php?page=8021q'>VLANs</a>");
	//			echo '<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>';
				$vlanOutArray = array();
				foreach ($what as $vlan)
				{
					$vlanOutArray[] = array( 'rowOrder' => $order,
											'renderedCell' => formatVLANAsHyperlink (getVLANInfo ($vlan['id'])) ."");

	//				echo "<tr class=row_${order}><td class=tdleft>";
	//				echo formatVLANAsHyperlink (getVLANInfo ($vlan['id'])) . "</td></tr>";
	//				echo "</td></tr>";
					$order = $nextorder[$order];
				}
	//			echo '</table>';
	//			finishPortlet();
				
				$foundVLan->setOutput("searchLoopObjs", $vlanOutArray);
				break;
			default: // you can use that in your plugins to add some non-standard search results
	//			startPortlet($where);
	//			echo $what;
	//			finishPortlet();
				$mod->setOutput("whatCont", $what);
		}
}

// This function prints a table of checkboxes to aid the user in toggling mount atoms
// from one state to another. The first argument is rack data as
// produced by amplifyCell(), the second is the value used for the 'unckecked' state
// and the third is the value used for 'checked' state.
// Usage contexts:
// for mounting an object:             printAtomGrid ($data, 'F', 'T')
// for changing rack design:           printAtomGrid ($data, 'A', 'F')
// for adding rack problem:            printAtomGrid ($data, 'F', 'U')
// for adding object problem:          printAtomGrid ($data, 'T', 'W')

function renderAtomGrid ($data, $parent = null, $placeholder = 'AtomGrid')
{
	$rack_id = $data['id'];
	
	$tplm = TemplateManager::getInstance();
	//addJS ('js/racktables.js');
	if($parent == null)
		$output = '';

	for ($unit_no = $data['height']; $unit_no > 0; $unit_no--)
	{
		if($parent == null)
			$trow = $tplm->generateModule('GridRow');
		else
			$trow = $tplm->generateSubmodule($placeholder, 'GridRow', $parent);
		
		$trow->setNamespace("");
		$trow->addOutput('RackId', $rack_id);
		$trow->addOutput('UnitNo', $unit_no);
		$trow->addOutput('Inversed', inverseRackUnit ($unit_no, $data));
		
		//echo "<tr><th><a href='javascript:;' onclick=\"toggleRowOfAtoms('${rack_id}','${unit_no}')\">" . inverseRackUnit ($unit_no, $data) . "</a></th>";
		for ($locidx = 0; $locidx < 3; $locidx++)
		{
			$name = "atom_${rack_id}_${unit_no}_${locidx}";
			$state = $data[$unit_no][$locidx]['state'];
			
			$tatom = $tplm->generateSubmodule('Atoms', 'GridElement', $trow);
			$tatom->setNamespace("");
			$tatom->addOutput('State', $state);
			$tatom->addOutput('Name', $name);

			//echo "<td class='atom state_${state}";
			if (isset ($data[$unit_no][$locidx]['hl']))
				$tatom->addOutput('Hl', $data[$unit_no][$locidx]['hl']);
				//echo $data[$unit_no][$locidx]['hl'];
			//echo "'>";
			if (!($data[$unit_no][$locidx]['enabled'] === TRUE))
				$tatom->addOutput('Disabled', true);
				//echo "<input type=checkbox id=${name} disabled>";
			else
				$tatom->addOutput('Checked', $data[$unit_no][$locidx]['checked']);
				//echo "<input type=checkbox" . $data[$unit_no][$locidx]['checked'] . " name=${name} id=${name}>";
			//echo '</td>';
		}
		if($parent == null)
			$output .= $trow->run();
		//echo "</tr>\n";
	}
	if($parent == null)
		return $output;
}

function renderCellList ($realm = NULL, $title = 'items', $do_amplify = FALSE, $celllist = NULL, $parent = NULL, $placeholder = "CellList")
{
	if ($realm === NULL)
	{
		global $pageno;
		$realm = $pageno;
	}
	global $nextorder;
	$order = 'odd';
	$cellfilter = getCellFilter();
	if (! isset ($celllist))
		$celllist = listCells ($realm);
	$celllist = filterCellList ($celllist, $cellfilter['expression']);
	
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");	
	if($parent === NULL){	
		$mod = $tplm->generateModule("CellList");
	}
	else{
		$mod = $tplm->generateSubmodule($placeholder, "CellList", $parent);
	}
	
	$mod->setNamespace("",true);
	$mod->setLock();

	//echo "<table border=0 class=objectview>\n";
	//echo "<tr><td class=pcleft>";

	if ($realm != 'file' || ! renderEmptyResults ($cellfilter, 'files', count($celllist), $mod, "EmptyResults "))
	{
		if ($do_amplify)
			array_walk ($celllist, 'amplifyCell');
		//$mod->setOutput("EmptyResults", "");
		//startPortlet ($title . ' (' . count ($celllist) . ')');
		//echo "<table class=cooltable border=0 cellpadding=5 cellspacing=0 align=center>\n"
		$mod->addOutput("Title", $title);
		$mod->addOutput("CellCount", count($celllist));
		$cells = array();
		foreach ($celllist as $cell)
		{
			$singleCell = array();
			$singleCell["Order"] = $order;
			$singleCell["CellContent"] = renderCell($cell);
			//echo "<tr class=row_${order}><td>";
			//renderCell ($cell);
			//echo "</td></tr>\n";
			$order = $nextorder[$order];
			$cells[] = $singleCell;
		}
		$mod->addOutput("CellListContent", $cells);
		
		//echo '</table>';
		//finishPortlet();
	}
//	else {

//	}
	//echo '</td><td class=pcright>';
	renderCellFilterPortlet ($cellfilter, $realm, $celllist, array(), $mod );
	//echo "</td></tr></table>\n"; */
	if($parent == null)
		return $mod->run();
}

function renderUserList ()
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");	
	$main = $tplm->getMainModule();

	renderCellList ('user', 'User accounts',FALSE, NULL, $main, 'Payload');
}

function renderUserListEditor ()
{
	function printNewItemTR ($parent,$placeholder)
	{
		$tplm = TemplateManager::getInstance();
		$smod2 = $tplm->generateSubmodule($placeholder, "UserListEditorNew", $parent);
		$smod2->setNamespace('userlist');
		//startPortlet ('Add new');
		//printOpFormIntro ('createUser');
		//echo '<table cellspacing=0 cellpadding=5 align=center>';
		//echo '<tr><th>&nbsp;</th><th>&nbsp;</th><th>Assign tags</th></tr>';
		//echo '<tr><th class=tdright>Username</th><td class=tdleft><input type=text size=64 name=username tabindex=100></td>';
		//echo '<td rowspan=4>';
		renderNewEntityTags ('user', $smod2, "RenderedNewEntityTags");

		//echo '</td></tr>';
		//echo '<tr><th class=tdright>Real name</th><td class=tdleft><input type=text size=64 name=realname tabindex=101></td></tr>';
		//echo '<tr><th class=tdright>Password</th><td class=tdleft><input type=password size=64 name=password tabindex=102></td></tr>';
		//echo '<tr><td colspan=2>';
		//printImageHREF ('CREATE', 'Add new account', TRUE, 103);
		//echo '</td></tr>';
		//echo '</table></form>';
		//finishPortlet();
	}
	$tplm = TemplateManager::getInstance();
	
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule();
	
	$mod = $tplm->generateSubmodule("Payload", "UserListEditor");
	$mod->setNamespace("userlist");
	
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
		printNewitemTR($mod,"AddNewTop");
		//printNewItemTR();
	$accounts = listCells ('user');
	//startPortlet ('Manage existing (' . count ($accounts) . ')');
	$mod->addOutput("Count", count($accounts));
	//echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
	//echo '<tr><th>Username</th><th>Real name</th><th>Password</th><th>&nbsp;</th></tr>';
	foreach ($accounts as $account)
	{
		$smod = $tplm->generateSubmodule("Users", "UserListEditorRow", $mod);
		$smod->setNamespace('userlist');
		$smod->addOutput("UserId", $account['user_id']);
		$smod->addOutput("Name", $account['user_name']);
		$smod->addOutput("RealName", $account['user_realname']);
		$smod->addOutput("PwHash", $user['user_password_hash']);
		
		//printOpFormIntro ('updateUser', array ('user_id' => $account['user_id']));
		//echo "<tr><td><input type=text name=username value='${account['user_name']}' size=16></td>";
		//echo "<td><input type=text name=realname value='${account['user_realname']}' size=24></td>";
		//echo "<td><input type=password name=password value='${account['user_password_hash']}' size=40></td><td>";
		//printImageHREF ('save', 'Save changes', TRUE);
		//echo '</td></form></tr>';
	}
	//echo '</table><br>';
	//finishPortlet();
	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
		printNewitemTR($mod,"AddNewBottom");
		//printNewItemTR();
}

function renderOIFCompatViewer()
{
	$tplm = TemplateManager::getInstance();
	
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule();
	
	$mod = $tplm->generateSubmodule("Payload", "RenderOIFCompatViewer");
	$mod->setNamespace("portmap",true);

	global $nextorder;
	$order = 'odd';
	$last_left_oif_id = NULL;
	// echo '<br><table class=cooltable border=0 cellpadding=5 cellspacing=0 align=center>';
	// echo '<tr><th>From interface</th><th>To interface</th></tr>';
	$allPortCompatOut = array();
	foreach (getPortOIFCompat() as $pair)
	{
		if ($last_left_oif_id != $pair['type1'])
		{
			$order = $nextorder[$order];
			$last_left_oif_id = $pair['type1'];
		}
		$allPortCompatOut[] = array(	'Order' => $order,
										'Type1' => $pair['type1name'],
										'Type2' => $pair['type2name']);

		// echo "<tr class=row_${order}><td>${pair['type1name']}</td><td>${pair['type2name']}</td></tr>";
	}
	$mod->addOutput("AllPortCompat", $allPortCompatOut);
		 
	// echo '</table>';
}

function renderOIFCompatEditor()
{
	$tplm = TemplateManager::getInstance();
	
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule();
	
	$mod = $tplm->generateSubmodule("Payload", "RenderOIFCompatEditor");
	$mod->setNamespace("portmap",true);


	function printNewitemTR($placeholder, $mod)
	{
		$tplm = TemplateManager::getInstance();
	
		//$tplm->setTemplate("vanilla");
		//$tplm->createMainModule();
		$submod = $tplm->generateSubmodule($placeholder, 'RenderOIFCompatEditor_PrintNewItem', $mod);
		$submod->setNamespace("portmap",true);
		// printOpFormIntro ('add');
		// echo '<tr><th class=tdleft>';
		// printImageHREF ('add', 'add pair', TRUE);
		// echo '</th><th class=tdleft>';
		$submod->addOutput('Type1', getSelect (readChapter (CHAP_PORTTYPE), array ('name' => 'type1')));
		$submod->addOutput('Type2', getSelect (readChapter (CHAP_PORTTYPE), array ('name' => 'type2')));
		// echo '</th><th class=tdleft>';
		// printSelect (readChapter (CHAP_PORTTYPE), array ('name' => 'type2'));
		// echo '</th></tr></form>';
	}

	global $nextorder, $wdm_packs;

	// startPortlet ('WDM wideband receivers');
	// echo '<table border=0 align=center cellspacing=0 cellpadding=5>';
	// echo '<tr><th>&nbsp;</th><th>enable</th><th>disable</th></tr>';
	$order = 'odd';
	foreach ($wdm_packs as $codename => $packinfo)
	{
		$mod->addOutput('Looparray', array(
											'Order' => $order,
											'Title' => $packinfo['title'],
											'Codename' => $codename)); //@XXX XXX XXX No helpers within old loops
		// echo "<tr class=row_${order}><td class=tdleft>" . $packinfo['title'] . '</td><td>';
		// echo getOpLink (array ('op' => 'addPack', 'standard' => $codename), '', 'add');
		// echo '</td><td>';
		// echo getOpLink (array ('op' => 'delPack', 'standard' => $codename), '', 'delete');
		// echo '</td></tr>';
		$order = $nextorder[$order];
	}
	// echo '</table>';
	// finishPortlet();

	startPortlet ('interface by interface');
	$last_left_oif_id = NULL;
	// echo '<br><table class=cooltable align=center border=0 cellpadding=5 cellspacing=0>';
	// echo '<tr><th>&nbsp;</th><th>From Interface</th><th>To Interface</th></tr>';
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
		printNewitemTR('Newtop', $mod);
	foreach (getPortOIFCompat() as $pair)
	{
		if ($last_left_oif_id != $pair['type1'])
		{
			$order = $nextorder[$order];
			$last_left_oif_id = $pair['type1'];
		}
		$mod->addOutput('Looparray2', array(
											'Order' => $order,
											'Type1' => $pair['type1'],
											'Type2' => $pair['type2'],
											'Type1name' => $pair['type1name'],
											'Type2name' => $pair['type2name']));

		// echo "<tr class=row_${order}><td>";
		// echo getOpLink (array ('op' => 'del', 'type1' => $pair['type1'], 'type2' => $pair['type2']), '', 'delete', 'remove pair');
		// echo "</td><td class=tdleft>${pair['type1name']}</td><td class=tdleft>${pair['type2name']}</td></tr>";
	}
	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
		printNewitemTR('Newbottom');
	// echo '</table>';
	// finishPortlet();
}

function renderObjectParentCompatViewer()
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule();
	
	$mod = $tplm->generateSubmodule("Payload", "RenderObjectParentCompatViewer");
	$mod->setNamespace("parentmap",true);

	global $nextorder;
	$order = 'odd';
	$last_left_parent_id = NULL;
	// echo '<br><table class=cooltable border=0 cellpadding=5 cellspacing=0 align=center>';
	// echo '<tr><th>Parent</th><th>Child</th></tr>';
	foreach (getObjectParentCompat() as $pair)
	{
		if ($last_left_parent_id != $pair['parent_objtype_id'])
		{
			$order = $nextorder[$order];
			$last_left_parent_id = $pair['parent_objtype_id'];
		}

		$mod->addOutput('Looparray', array(
											'Order' => $order,
											'Parentname' => $pair['parent_name'],
											'Childname' => $pair['child_name']));
		// echo "<tr class=row_${order}><td>${pair['parent_name']}</td><td>${pair['child_name']}</td></tr>\n";
	}
	// echo '</table>';
}

function renderObjectParentCompatEditor()
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule();
	
	$mod = $tplm->generateSubmodule("Payload", "RenderObjectCompatEditor");
	$mod->setNamespace("parentmap");

	function printNewitemTR($placeholder, $mod)
	{
		$tplm = TemplateManager::getInstance();

		$submod = $tplm->generateSubmodule($placeholder, 'RenderObjectParentCompatEditor_PrintNewItem', $mod);
		$submod->setNamespace("parentmap");
		// printOpFormIntro ('add');
		// echo '<tr><th class=tdleft>';
		// printImageHREF ('add', 'add pair', TRUE);
		// echo '</th><th class=tdleft>';
		$chapter = readChapter (CHAP_OBJTYPE);
		// remove rack, row, location
		unset ($chapter['1560'], $chapter['1561'], $chapter['1562']);
		$submod->setOutput('Parent', getSelect ($chapter,array ('name' => 'parent_objtype_id'), NULL));
		$submod->setOutput('Child', getSelect ($chapter,array ('name' => 'child_objtype_id'), NULL));

		// printSelect ($chapter, array ('name' => 'parent_objtype_id'));
		// echo '</th><th class=tdleft>';
		// printSelect ($chapter, array ('name' => 'child_objtype_id'));
		// echo "</th></tr></form>\n";
	}

	global $nextorder;
	$last_left_parent_id = NULL;
	$order = 'odd';
	// echo '<br><table class=cooltable align=center border=0 cellpadding=5 cellspacing=0>';
	// echo '<tr><th>&nbsp;</th><th>Parent</th><th>Child</th></tr>';
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
		printNewitemTR('Newtop', $mod);

	foreach (getObjectParentCompat() as $pair)
	{
		if ($last_left_parent_id != $pair['parent_objtype_id'])
		{
			$order = $nextorder[$order];
			$last_left_parent_id = $pair['parent_objtype_id'];
		}
		$mod->addOutput('Looparray', array(
											'Order' => $order,
											'Parentname' => $pair['parent_name'],
											'Childname' => $pair['child_name'],
											'Image' => ($pair['count'] > 0 ? 
												getImageHREF ('nodelete', $pair['count'] . ' relationship(s) stored'): 
												getOpLink (array ('op' => 'del', 'parent_objtype_id' => $pair['parent_objtype_id'], 
												'child_objtype_id' => $pair['child_objtype_id']), '', 'delete', 'remove pair'))));
		// echo "<tr class=row_${order}><td>";
		
		// TODO: generate Submodule for this Loop instead of an Looparray (Template_Engine_Issue) 


		// if ($pair['count'] > 0)
		// 	printImageHREF ('nodelete', $pair['count'] . ' relationship(s) stored');
		// else
		// 	echo getOpLink (array ('op' => 'del', 'parent_objtype_id' => $pair['parent_objtype_id'], 'child_objtype_id' => $pair['child_objtype_id']), '', 'delete', 'remove pair');
		// echo "</td><td class=tdleft>${pair['parent_name']}</td><td class=tdleft>${pair['child_name']}</td></tr>\n";
	}
	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
		printNewitemTR('Newbottom', $mod);
	// echo '</table>';
}

// Find direct sub-pages and dump as a list.
// FIXME: assume all config kids to have static titles at the moment,
// but use some proper abstract function later.
function renderConfigMainpage ()
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule();
	
	$mod = $tplm->generateSubmodule("Payload", "RenderConfigMainPage");
	$mod->setNamespace("config",true);

	global $pageno, $page;
	// echo '<ul>';
	$allPagesOut = array();
	foreach ($page as $cpageno => $cpage)
	{
		if (isset ($cpage['parent']) and $cpage['parent'] == $pageno  && permitted($cpageno))
			$allPagesOut[] = array(	'Cpageno' => $cpageno, 
									'Title' => $cpage['title']);
		// 	echo "<li><a href='index.php?page=${cpageno}'>" . $cpage['title'] . "</li>\n";
	}
	$mod->addOutput("allPages", $allPagesOut);	 
	// echo '</ul>';
}

function renderLocationPage ($location_id)
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule();
	
	$mod = $tplm->generateSubmodule("Payload", "RenderLocationPage");
	$mod->setNamespace("location",true);

	$locationData = spotEntity ('location', $location_id);
	amplifyCell ($locationData);
	// echo "<table border=0 class=objectview cellspacing=0 cellpadding=0><tr>";

	// // Left column with information.
	// echo "<td class=pcleft>";
	$summary = array();
	$summary['Name'] = $locationData['name'];
	if (! empty ($locationData['parent_id']))
		$summary['Parent location'] = mkA ($locationData['parent_name'], 'location', $locationData['parent_id']);
	$summary['Child locations'] = count($locationData['locations']);
	$summary['Rows'] = count($locationData['rows']);
	if ($locationData['has_problems'] == 'yes')
		$summary[] = array ('<tr><td colspan=2 class=msg_error>Has problems</td></tr>');
	foreach (getAttrValues ($locationData['id']) as $record)
		if
		(
			$record['value'] != '' and
			permitted (NULL, NULL, NULL, array (array ('tag' => '$attr_' . $record['id'])))
		)
			$summary['{sticker}' . $record['name']] = formatAttributeValue ($record);
	$summary['tags'] = '';
	if (strlen ($locationData['comment']))
		$summary['Comment'] = $locationData['comment'];
	$mod->addOutput('Renderentitysummary', renderEntitySummary ($locationData, 'Summary', $summary, $mod));
	$mod->addOutput('Renderfilesportlet', renderFilesPortlet ('location', $location_id));
	// echo '</td>';

	// Right column with list of rows and child locations
	// echo '<td class=pcright>';
	// $mod->addOutput('Count', count ($locationData['rows']));
	// startPortlet ('Rows ('. count ($locationData['rows']) . ')');
	// echo "<table border=0 cellspacing=0 cellpadding=5 align=center>\n";
	$helperarray = array();
	foreach ($locationData['rows'] as $row_id => $name)
		$helperarray[] = array('Link'=> mkA ($name, 'row', $row_id));
	
	if(count($helperarray)>0) {
		$mod->addOutput('Rows', $helperarray);
	}
		
		// echo '<tr><td>' . mkA ($name, 'row', $row_id) . '</td></tr>';
	// echo "</table>\n";
	// finishPortlet();
	$mod->addOutput('Countlocations', count ($locationData['locations']));
	// startPortlet ('Child Locations (' . count ($locationData['locations']) . ')');
	// echo "<table border=0 cellspacing=0 cellpadding=5 align=center>\n";
	$helperarray = array();
	foreach ($locationData['locations'] as $location_id => $name)
		$helperarray[] = array('LocationLink' => mkA($name, 'location', $location_id) );

	if(count($helperarray) > 0 ) {
	$mod->addOutput('ChildLocations', $helperarray);	
	}	// echo '<tr><td>' . mkA ($name, 'location', $location_id) . '</td></tr>';
	// echo "</table>\n";
	// finishPortlet();
	// echo '</td>';
	// echo '</tr></table>';
}

function renderEditLocationForm ($location_id)
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule();
	
	$mod = $tplm->generateSubmodule("Payload", "RenderEditLocationForm");
	$mod->setNamespace("location",true);


	global $pageno;
	$location = spotEntity ('location', $location_id);
	amplifyCell ($location);


	// startPortlet ('Attributes');
	// printOpFormIntro ('updateLocation');
	// echo '<table border=0 align=center>';
	// echo "<tr><td>&nbsp;</td><th class=tdright>Parent location:</th><td class=tdleft>";
	$locations = array ();
	$locations[0] = '-- NOT SET --';
	foreach (listCells ('location') as $id => $locationInfo)
		$locations[$id] = $locationInfo['name'];
	natcasesort($locations);
	
	$mod->addOutput('Getselect', getSelect ($locations, array ('name' => 'parent_id'), $location['parent_id']));
	$mod->addOutput('Locationname', $location['name']);
	// echo "</td></tr>\n";
	// echo "<tr><td>&nbsp;</td><th class=tdright>Name (required):</th><td class=tdleft><input type=text name=name value='${location['name']}'></td></tr>\n";
	// optional attributes
	$values = getAttrValues ($location_id);
	$num_attrs = count($values);
	$mod->addOutput('Num_attrs', $num_attrs);
	// echo "<input type=hidden name=num_attrs value=${num_attrs}>\n";
	$i = 0;
	foreach ($values as $record)
	{
		$submod = $tplm->generateSubmodule('Loopcontent', 'Loop', $mod);

		$submod->addOutput('Record_Id', $record['id']);
		$submod->addOutput('Index', $i);

		// echo "<input type=hidden name=${i}_attr_id value=${record['id']}>";
		// echo '<tr><td>';
		if (strlen ($record['value']))
			$submod->addOutput('Value', TRUE);
			// echo getOpLink (array ('op'=>'clearSticker', 'attr_id'=>$record['id']), '', 'clear', 'Clear value', 'need-confirmation');
		// else
		// 	echo '&nbsp;';
		// echo '</td>';
		$submod->addOutput('Record_Name', $record['name']);
		// echo "<th class=sticker>${record['name']}:</th><td class=tdleft>";
		$submod->setOutput('Record_Value', $record['value']);
		switch ($record['type'])
		{
			case 'uint':
			case 'float':
			case 'string':
				$submod->addOutput('Switch_Option', 'ONE');
				// echo "<input type=text name=${i}_value value='${record['value']}'>";
				break;
			case 'dict':
				$submod->addOutput('Switch_Option', 'TWO');
				$chapter = readChapter ($record['chapter_id'], 'o');
				$chapter[0] = '-- NOT SET --';
				$chapter = cookOptgroups ($chapter, 1562, $record['key']);
				$submod->addOutput('Nifty_Select', getNiftySelect( $chapter, array ('name' => "${i}_value"), $record['key']));
				// printNiftySelect ($chapter, array ('name' => "${i}_value"), $record['key']);
				break;
		}
		// echo "</td></tr>\n";
		$i++;
	}
	// echo "<tr><td>&nbsp;</td><th class=tdright>Has problems:</th><td class=tdleft><input type=checkbox name=has_problems";
	if ($location['has_problems'] == 'yes')
		$mod->setOutput('Has_Problems', TRUE);
		// echo ' checked';
	// echo "></td></tr>\n";
	if (count ($location['locations']) == 0 and count ($location['rows']) == 0)
	{
		$mod->setOutput('Empty_Locations', TRUE);
		// echo "<tr><td>&nbsp;</td><th class=tdright>Actions:</th><td class=tdleft>";
		// echo getOpLink (array('op'=>'deleteLocation'), '', 'destroy', 'Delete location', 'need-confirmation');
		// echo "&nbsp;</td></tr>\n";
	}

	$mod->addOutput('Location_Comment', $location['comment']);

	// echo "<tr><td colspan=3><b>Comment:</b><br><textarea name=comment rows=10 cols=80>${location['comment']}</textarea></td></tr>";
	// echo "<tr><td class=submit colspan=3>";
	// printImageHREF ('SAVE', 'Save changes', TRUE);
	// echo "</td></tr>\n";
	// echo '</form></table><br>';
	// finishPortlet();

	// startPortlet ('History');
	renderObjectHistory ($location_id, $mod, 'Objecthistory');
	// finishPortlet();
}

function renderRackPage ($rack_id)
{
	$rackData = spotEntity ('rack', $rack_id);
	amplifyCell ($rackData);
	$tplm = TemplateManager::getInstance();
	
	$mod = $tplm->generateSubmodule("Payload", "RenderRackPage");
	
	$mod->setNamespace("rack");
	
	//echo "<table border=0 class=objectview cellspacing=0 cellpadding=0><tr>";

	// Left column with information.
	//echo "<td class=pcleft>";
	renderRackInfoPortlet ($rackData, $mod, "InfoPortlet");
	renderFilesPortlet ('rack', $rack_id, $mod, "FilesPortlet");
	//echo '</td>';

	// Right column with rendered rack.
	//echo '<td class=pcright>';
	//startPortlet ('Rack diagram');
	renderRack ($rack_id, 0, $mod, "RenderedRack");
	//finishPortlet();
	//echo '</td>';

	//echo '</tr></table>';
}

function renderDictionary ()
{
	$tplm = TemplateManager::getInstance();
	
	//$tplm->setTemplate('vanilla');
	//$tplm->createMainModule();
	
	$mod = $tplm->generateSubmodule('Payload', 'DictList');
	
	$mod->setNamespace('dict');
	

	//echo '<ul>';
	foreach (getChapterList() as $chapter_no => $chapter)
		$mod->addOutput('Dictlist', array('Link'=>mkA($chapter['name'], 'chapter', $chapter_no),'Records'=>$chapter['wordc']));
	
		//echo '<li>' . mkA ($chapter['name'], 'chapter', $chapter_no) . " (${chapter['wordc']} records)</li>";
	//echo '</ul>';
}

function renderChapter ($tgt_chapter_no)
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate('vanilla');
	//$tplm->createMainModule();
	$mod = $tplm->generateSubmodule('Payload', 'Chapter');
	$mod->setNamespace('chapter', true);
	global $nextorder;
	$words = readChapter ($tgt_chapter_no, 'a');
	$wc = count ($words);
	$mod->addOutput('recordCount', $wc);  
	
	
	//if (!$wc)
	//{
	//	echo "<center><h2>(no records)</h2></center>";
	//	return;
	//}
	$refcnt = getChapterRefc ($tgt_chapter_no, array_keys ($words));
	$attrs = getChapterAttributes($tgt_chapter_no);
	//echo "<br><table class=cooltable border=0 cellpadding=5 cellspacing=0 align=center>\n";
	//echo "<tr><th colspan=4>${wc} record(s)</th></tr>\n";
	//echo "<tr><th>Origin</th><th>Key</th><th>Refcnt</th><th>Word</th></tr>\n";
	$order = 'odd';
	foreach ($words as $key => $value)
	{
		$submod = $tplm->generateSubmodule('tableContent', 'ChapterRow', $mod);
		$submod->addOutput('order', $order);
		//echo "<tr class=row_${order}><td>";
		
		//getImageHREF ($key < 50000 ? 'computer' : 'favorite');
		$submod->addOutput('ImageType', $key < 50000 ? 'computer' : 'favorite');
		//echo "</td><td>${key}</td><td>";
		$submod->addOutput('key', $key);
		$submod->addOutput('refcnt', $refcnt[$key]);
		if ($refcnt[$key])
		{
			$cfe = '';
			foreach ($attrs as $attr_id)
			{
				if (! empty($cfe))
					$cfe .= ' or ';
					
				$cfe .= '{$attr_' . $attr_id . '_' . $key . '}';
			}

			if (! empty($cfe))
			{
				$href = makeHref
				(
					array
					(
						'page'=>'depot',
						'tab'=>'default',
						'andor' => 'and',
						'cfe' => $cfe
					)
				);
				
				$submod->setOutput('cfe', true);
				$submod->addOutput('href', $href);
				
				//echo '<a href="' . $href . '">' . $refcnt[$key] . '</a>';
			}
		
				//echo $refcnt[$key];
		}
		//echo "</td><td>${value}</td></tr>\n";
		$order = $nextorder[$order];
	}
	//echo "</table>\n<br>";
}

function renderChapterEditor ($tgt_chapter_no)
{
	global $nextorder;
	function printNewItemTR ($parent, $placeholder)
	{
		$tplm = TemplateManager::getInstance();
		$smod = $tplm->generateSubmodule($placeholder, 'RenderChapterEditor_PrintNewItem', $parent);
		//$mod->addOutput('OpForm', $this->getH('PrintOpFormIntro', 'add'));
		
		//printOpFormIntro ('add');
		//echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td>';
		
		//printImageHREF ('add', 'Add new', TRUE);
		//echo "</td>";
		//echo "<td class=tdleft><input type=text name=dict_value size=64 tabindex=100></td><td>";
		//printImageHREF ('add', 'Add new', TRUE, 101);
		//echo '</td></tr></form>';
	}
	
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate('vanilla');
	//$tplm->createMainModule();
	$mod = $tplm->generateSubmodule('Payload', 'ChapterEditor');
	$mod->setNamespace('chapter', true);
	

	
	
	//echo "<br><table class=cooltable border=0 cellpadding=5 cellspacing=0 align=center>\n";
	$words = readChapter ($tgt_chapter_no);
	
	
	$refcnt = getChapterRefc ($tgt_chapter_no, array_keys ($words));
	$order = 'odd';
	//echo "<tr><th>Origin</th><th>Key</th><th>&nbsp;</th><th>Word</th><th>&nbsp;</th></tr>\n";
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
		printNewItemTR($mod,"NewTop");
	foreach ($words as $key => $value)
	{
			$submod = $tplm->generateSubmodule('merge', 'CreateChapterRow', $mod);
		echo $key;
			//echo "<tr class=row_${order}><td>";
		$order = $nextorder[$order];
		$submod->addOutput('order', $order);
		$submod->addOutput('key', $key);
		$submod->addOutput('value', $value);
		$submod->addOutput('refcnt', $refcnt[$key]);
		// Show plain row for stock records, render a form for user's ones.
		if ($key < 50000)
		{
			$submod->addOutput('lowkey', true);
		//	printImageHREF ('computer');
		//	echo "</td><td>${key}</td><td>&nbsp;</td><td>${value}</td><td>&nbsp;</td></tr>";
			continue;
		}
		//printOpFormIntro ('upd', array ('dict_key' => $key));
		//printImageHREF ('favorite');
		//echo "</td><td>${key}</td><td>";
		// Prevent deleting words currently used somewhere.
		//if ($refcnt[$key])
		//	printImageHREF ('nodelete', 'referenced ' . $refcnt[$key] . ' time(s)');
		//else
		//	echo getOpLink (array('op'=>'del', 'dict_key'=>$key), '', 'delete', 'Delete word');
		//echo '</td>';
		//echo "<td class=tdleft><input type=text name=dict_value size=64 value='${value}'></td><td>";
		//printImageHREF ('save', 'Save changes', TRUE);
		//echo "</td></tr></form>";
		
		
	}
	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
		printNewItemTR($mod, "NewBottom");
	//echo "</table>\n";
}

// We don't allow to rename/delete a sticky chapter and we don't allow
// to delete a non-empty chapter.
function renderChaptersEditor ()
{
	function printNewItemTR ($parent,$placeholder)
	{
		$tplm = TemplateManager::getInstance();
		
		$mod = $tplm->generateSubmodule($placeholder, 'DictEditorNew', $parent);
		$mod->setNamespace('dict');
		/**printOpFormIntro ('add');
		echo '<tr><td>';
		printImageHREF ('create', 'Add new', TRUE);
		echo "</td><td><input type=text name=chapter_name tabindex=100></td><td>&nbsp;</td><td>";
		printImageHREF ('create', 'Add new', TRUE, 101);
		echo '</td></tr></form>'; */
	}
	$dict = getChapterList();
	foreach (array_keys ($dict) as $chapter_no)
		$dict[$chapter_no]['mapped'] = FALSE;
	foreach (getAttrMap() as $attrinfo)
		if ($attrinfo['type'] == 'dict')
			foreach ($attrinfo['application'] as $app)
				$dict[$app['chapter_no']]['mapped'] = TRUE;
		
	$tplm = TemplateManager::getInstance();
	
	$mod = $tplm->generateSubmodule('Payload', 'DictEditor');
	$mod->setNamespace('dict');
	$mod->setLock();
	
	
	//echo "<table cellspacing=0 cellpadding=5 align=center class=widetable>\n";
	//echo '<tr><th>&nbsp;</th><th>Chapter name</th><th>Words</th><th>&nbsp;</th></tr>';
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
		printNewItemTR($mod,'NewTop');
	foreach ($dict as $chapter_id => $chapter)
	{
		$wordcount = $chapter['wordc'];
		$sticky = $chapter['sticky'] == 'yes';
		
		$submod = $tplm->generateSubmodule('DictList','DictEditorElement', $mod);
		$submod->setNamespace('dict');
		//printOpFormIntro ('upd', array ('chapter_no' => $chapter_id));
		//echo '<tr>';
		//echo '<td>';
		if ($sticky)
			$submod->setOutput('NoDestroyMessage', 'system chapter');
			//printImageHREF ('nodestroy', 'system chapter');
		elseif ($wordcount > 0)
			$submod->setOutput('NoDestroyMessage', 'contains ' . $wordcount . ' word(s)');
			//printImageHREF ('nodestroy', 'contains ' . $wordcount . ' word(s)');
		elseif ($chapter['mapped'])
			$submod->setOutput('NoDestroyMessage', 'used in attribute map');
			//printImageHREF ('nodestroy', 'used in attribute map');
		else
			$submod->setOutput('NoDestroyMessage', '');
			//echo getOpLink (array('op'=>'del', 'chapter_no'=>$chapter_id), '', 'destroy', 'Remove chapter');
		//echo '</td>';
		
		$submod->addOutput('Name', $chapter['name']);
		$submod->addOutput('ChapterId', $chapter_id);
		$submod->addOutput('Disabled', ($sticky ? ' disabled' : ''));
		$submod->addOutput('Sticky', $sticky);
		$submod->addOutput('Wordcount', $wordcount);
		
		//echo "<td><input type=text name=chapter_name value='${chapter['name']}'" . ($sticky ? ' disabled' : '') . "></td>";
		//echo "<td class=tdleft>${wordcount}</td><td>";
		//if ($sticky)
		//	echo '&nbsp;';
		//else
		//	printImageHREF ('save', 'Save changes', TRUE);
		//echo '</td></tr>';
		//echo '</form>';
	}
	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
		printNewItemTR($mod,'NewBottom');
	//echo "</table>\n";
}

function renderAttributes ()
{
	
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate('vanilla');
	//$tplm->createMainModule();
	$mod = $tplm->generateSubmodule('Payload', 'RenderAttributes');
	$mod->setNamespace('attrs', true);
	
	
	
	global $nextorder, $attrtypes;
	//startPortlet ('Optional attributes');
	//echo "<table class=cooltable border=0 cellpadding=5 cellspacing=0 align=center>";
	//echo "<tr><th class=tdleft>Attribute name</th><th class=tdleft>Attribute type</th><th class=tdleft>Applies to</th></tr>";
	$order = 'odd';
	$allAttrsOut = array();
	foreach (getAttrMap() as $attr)
	{
		$singleAttr =  array(
							'Order' => $order, 
							'Name'  => $attr['name'],
							'Type'  => $attrtypes[$attr['type']]
							);
		//echo "<tr class=row_${order}>";
		//echo "<td class=tdleft>${attr['name']}</td>";
		//echo "<td class=tdleft>" . $attrtypes[$attr['type']] . "</td>";
		//echo '<td class=tdleft>';
		if (count ($attr['application']) == 0)
			$singleAttr['ApplicationSet'] = '&nbsp;';
			//echo '&nbsp;';
		else{
			$allAppAttrsOut = array();
			foreach ($attr['application'] as $app){
				$singleAppAttr = array('ObjType' => decodeObjectType ($app['objtype_id'], 'a'), 'Chapter_name' => $app['chapter_name']);
				
				//Could be done in a inmemory template in need of change
				if ($attr['type'] == 'dict')
					$singleAppAttr['DictCont'] = " (values from '${app['chapter_name']}')";
				//echo decodeObjectType ($app['objtype_id'], 'a') . " (values from '${app['chapter_name']}')<br>";
				//else
					//echo decodeObjectType ($app['objtype_id'], 'a') . '<br>';
			 	$allAppAttrsOut[] = $singleAppAttr;
			 }
			 $applicationArrayMod = $tplm->generateModule('RenderAttributes_Loop', false, array('AllAppAttrs' => $allAppAttrsOut));
			 $applicationArrayMod->setNamespace('attrs');
			 $singleAttr['AllAppAttrsMod'] = $applicationArrayMod->run();		 	 
		}
		//echo '</td></tr>';
		$allAttrsOut[] = $singleAttr;
		$order = $nextorder[$order];
	}
	$mod->addOutput("AllAttrs", $allAttrsOut);
		 
	//echo "</table><br>\n";
	//finishPortlet();
}

function renderEditAttributesForm ()
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate('vanilla');
	//$tplm->createMainModule();
	$mod = $tplm->generateSubmodule('Payload', 'RenderEditAttributesForm');
	$mod->setNamespace('attrs', true);
	
	function printNewItemTR ($placeholder, $mod)
	{
		$tplm = TemplateManager::getInstance();
		$submod = $tplm->generateSubmodule($placeholder, 'RenderEditAttrMapForm_PrintNewItem', $mod);
		$submod->setNamespace('attrs', true);
		//printOpFormIntro ('add');
		//echo '<tr><td>';
		//printImageHREF ('create', 'Create attribute', TRUE);
		//echo "</td><td><input type=text tabindex=100 name=attr_name></td><td>";
		global $attrtypes;
		$submod->addOutput('GetSelect', getSelect($attrtypes, array ('name' => 'attr_type', 'tabindex' => 101), NULL));
		//echo '</td><td>';
		//printImageHREF ('add', 'Create attribute', TRUE, 102);
		//echo '</td></tr></form>';
	}
	//startPortlet ('Optional attributes');
	//echo "<table cellspacing=0 cellpadding=5 align=center class=widetable>\n";
	//echo '<tr><th>&nbsp;</th><th>Name</th><th>Type</th><th>&nbsp;</th></tr>';
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
		printNewItemTR('NewTop', $mod);
	$allAttrMapsOut = array();
	foreach (getAttrMap() as $attr)
	{
		$singleAttrMap = array( 'Name' => $attr['name'], 
				  				'Type' =>$attr['type'],
				  				'OpFormIntro' => printOpFormIntro ('upd', array ('attr_id' => $attr['id'])));
		
		//printOpFormIntro ('upd', array ('attr_id' => $attr['id']));
		//echo '<tr><td>';
		if($attr['id'] < 10000)
			$singleAttrMap['DestroyImg'] = printImageHREF ('nodestroy', 'system attribute');
			//printImageHREF ('nodestroy', 'system attribute');
		elseif (count ($attr['application']))
			$singleAttrMap['DestroyImg'] = printImageHREF ('nodestroy', count ($attr['application']) . ' reference(s) in attribute map');
			//printImageHREF ('nodestroy', count ($attr['application']) . ' reference(s) in attribute map');
		else
			$singleAttrMap['DestroyImg'] = getOpLink (array('op'=>'del', 'attr_id'=>$attr['id']), '', 'destroy', 'Remove attribute');
			//echo getOpLink (array('op'=>'del', 'attr_id'=>$attr['id']), '', 'destroy', 'Remove attribute');
		//echo "</td><td><input type=text name=attr_name value='${attr['name']}'></td>";
		//echo "<td class=tdleft>${attr['type']}</td><td>";
		$singleAttrMap['SaveImg'] = printImageHREF ('save', 'Save changes', TRUE);
		//printImageHREF ('save', 'Save changes', TRUE);
		//echo '</td></tr>';
		//echo '</form>';
		$allAttrMapsOut[] = $singleAttrMap;
	}
	$mod->addOutput("AllAttrMaps", $allAttrMapsOut);
		 
	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
		printNewItemTR('NewBottom', $mod);
	//echo "</table>\n";
	//finishPortlet();
}

function renderEditAttrMapForm ()
{

	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate('vanilla');
	//$tplm->createMainModule();
	$mod = $tplm->generateSubmodule('Payload', 'RenderEditAttrMapForm');
	$mod->setNamespace('attrs', true);


	function printNewItemTR ($placeholder, $mod, $attrMap)
	{
		$tplm = TemplateManager::getInstance();
		$submod = $tplm->generateSubmodule($placeholder, 'RenderEditAttrMapForm_PrintNewItemTR', $mod);
		$submod->setNamespace('attrs', true);
		//printOpFormIntro ('add');
		//echo '<tr><td colspan=2 class=tdleft>';
		//echo '<select name=attr_id tabindex=100>';
		$shortType['uint'] = 'U';
		$shortType['float'] = 'F';
		$shortType['string'] = 'S';
		$shortType['dict'] = 'D';
		$shortType['date'] = 'T';
		$allAttrMapsOut = array();
		//TODO ???
		foreach ($attrMap as $attr)
			$allAttrMapsOut[] = array('Id' => $attr['id'], 'Shorttype' => $shortType[$attr['type']], 'Name' => $attr['name']);
		$submod->addOutput("AllAttrMaps", $allAttrMapsOut);
			 
			// echo "<option value=${attr['id']}>[" . $shortType[$attr['type']] . "] ${attr['name']}</option>";
		// echo "</select></td><td class=tdleft>";
		// printImageHREF ('add', '', TRUE);
		// echo ' ';
		$objtypes = readChapter (CHAP_OBJTYPE, 'o');
		unset ($objtypes[1561]); // attributes may not be assigned to rows yet
		$groupList = cookOptgroups ($objtypes);
		$submod->addOutput('Getselect', getSelect ($groupList['other'], array ('name' => 'objtype_id', 'tabindex' => 101), NULL));	

		// printNiftySelect (cookOptgroups ($objtypes), array ('name' => 'objtype_id', 'tabindex' => 101));
		// echo ' <select name=chapter_no tabindex=102><option value=0>-- dictionary chapter for [D] attributes --</option>';
		$allChaptersOut = array();
		foreach (getChapterList() as $chapter)
		{ 
			if ($chapter['sticky'] != 'yes')
				$allChaptersOut[] = array('Id' => $chapter['id'], 'Name' => $chapter['name']);
			// if ($chapter['sticky'] != 'yes')
				//echo "<option value='${chapter['id']}'>${chapter['name']}</option>";
		$submod->setOutput('AllChapters', $allChaptersOut);
		}
					
		// echo '</select></td></tr></form>';
	}
	global $attrtypes, $nextorder;
	$order = 'odd';
	$attrMap = getAttrMap();
	// startPortlet ('Attribute map');
	// echo "<table class=cooltable border=0 cellpadding=5 cellspacing=0 align=center>";
	// echo '<tr><th class=tdleft>Attribute name</th><th class=tdleft>Attribute type</th><th class=tdleft>Applies to</th></tr>';
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
		printNewItemTR ('NewTop', $mod, $attrMap);


	foreach ($attrMap as $attr)
	{
		$submod = $tplm->generateSubmodule('AttributeRows', 'AttributeRow', $mod);

		if (!count ($attr['application'])){
			continue;
		}
		

		// echo "<tr class=row_${order}><td class=tdleft>${attr['name']}</td>";
		// echo "<td class=tdleft>" . $attrtypes[$attr['type']] . "</td><td colspan=2 class=tdleft>";

		$submod->addOutput('AttrTypes', $attrtypes[$attr['type']]);						
		$submod->addOutput('Name', $attr['name']);
		$submod->addOutput('Order', $order);

		foreach ($attr['application'] as $app)
		{
			$singleAttrApp = $tplm->generateSubmodule('AllAttrApps', 'RenderEditAttrMapForm_AttrApp', $submod, false,
													  array('Sticky' => $app['sticky'],
													  		'RefCnt' => $app['refcnt'],
													  		'Id' => $attr['id'],
													  		'ObjId' => $app['objtype_id'],
													  		'Type' => $attr['type'],
													  		'ChapterName' => $app['chapter_name'],
													  		'DecObj' => decodeObjectType ($app['objtype_id'], 'o')));

			//if ($app['sticky'] == 'yes')
				// printImageHREF ('nodelete', 'system mapping');
			
			// elseif ($app['refcnt'])
				// printImageHREF ('nodelete', $app['refcnt'] . ' value(s) stored for objects');
			// else
			// 	echo getOpLink (array('op'=>'del', 'attr_id'=>$attr['id'], 'objtype_id'=>$app['objtype_id']), '', 'delete', 'Remove mapping');
			//echo ' ';
			// if ($attr['type'] == 'dict')
			// 	echo decodeObjectType ($app['objtype_id'], 'o') . " (values from '${app['chapter_name']}')<br>";
			// else
			// 	echo decodeObjectType ($app['objtype_id'], 'o') . '<br>';
		}
		// echo "</td></tr>";
		$order = $nextorder[$order];
	}
	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
		printNewItemTR ('NewBottom', $mod, $attrMap);
	// echo "</table>\n";
	// finishPortlet();
}

function renderSystemReports ()
{
	$tmp = array
	(
		array
		(
			'title' => 'Dictionary/objects',
			'type' => 'counters',
			'func' => 'getDictStats'
		),
		array
		(
			'title' => 'Rackspace',
			'type' => 'counters',
			'func' => 'getRackspaceStats'
		),
		array
		(
			'title' => 'Files',
			'type' => 'counters',
			'func' => 'getFileStats'
		),
		array
		(
			'title' => 'Tags top list',
			'type' => 'custom',
			'func' => 'renderTagStats'
		),
	);
	renderReports ($tmp);
}

function renderLocalReports ()
{
	global $localreports;
	renderReports ($localreports);
}

function renderRackCodeReports ()
{
	$tmp = array
	(
		array
		(
			'title' => 'Stats',
			'type' => 'counters',
			'func' => 'getRackCodeStats'
		),
		array
		(
			'title' => 'Warnings',
			'type' => 'messages',
			'func' => 'getRackCodeWarnings'
		),
	);
	renderReports ($tmp);
}

function renderIPv4Reports ()
{
	$tmp = array
	(
		array
		(
			'title' => 'Stats',
			'type' => 'counters',
			'func' => 'getIPv4Stats'
		),
	);
	renderReports ($tmp);
}

function renderIPv6Reports ()
{
	$tmp = array
	(
		array
		(
			'title' => 'Stats',
			'type' => 'counters',
			'func' => 'getIPv6Stats'
		),
	);
	renderReports ($tmp);
}

function renderPortsReport ()
{
	$tmp = array();
	foreach (getPortIIFOptions() as $iif_id => $iif_name)
		if (count (getPortIIFStats (array ($iif_id))))
			$tmp[] = array
			(
				'title' => $iif_name,
				'type' => 'meters',
				'func' => 'getPortIIFStats',
				'args' => array ($iif_id),
			);
	renderReports ($tmp);
}

function render8021QReport ()
{

	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	////$tplm->createMainModule("index");
	
	if (!count ($domains = getVLANDomainOptions()))
	{	
		$mod = $tplm->generateSubmodule("Payload","NoVLANConfig", true);
	//	echo '<center><h3>(no VLAN configuration exists)</h3></center>';
		return;
	}
	$mod = $tplm->generateSubmodule("Payload","Render8021QReport");
	$mod->setNamespace("reports");

	$vlanstats = array();
	for ($i = VLAN_MIN_ID; $i <= VLAN_MAX_ID; $i++)
		$vlanstats[$i] = array();
	$header = '<tr><th>&nbsp;</th>';
	foreach ($domains as $domain_id => $domain_name)
	{
		foreach (getDomainVLANList ($domain_id) as $vlan_id => $vlan_info)
			$vlanstats[$vlan_id][$domain_id] = $vlan_info;
		$header .= '<th>' . mkA ($domain_name, 'vlandomain', $domain_id) . '</th>';
	}
	$header .= '</tr>';
	$output = $available = array();
	for ($i = VLAN_MIN_ID; $i <= VLAN_MAX_ID; $i++)
		if (!count ($vlanstats[$i]))
			$available[] = $i;
		else
			$output[$i] = FALSE;
	foreach (listToRanges ($available) as $span)
	{
		if ($span['to'] - $span['from'] < 4)
			for ($i = $span['from']; $i <= $span['to']; $i++)
				$output[$i] = FALSE;
		else
		{
			$output[$span['from']] = TRUE;
			$output[$span['to']] = FALSE;
		}
	}
	ksort ($output, SORT_NUMERIC);
	$header_delay = 0;
	
//	startPortlet ('VLAN existence per domain');
//	echo '<table border=1 cellspacing=0 cellpadding=5 align=center class=rackspace>';
	$outputArray = array();
	foreach ($output as $vlan_id => $tbc)
	{
		$singleElemOut = array();
		if (--$header_delay <= 0)
		{
			$singleElemOut['Header'] = $header;
			//echo $header;
			$header_delay = 25;
		}
		else
			$singleElemOut['Header'] = '';

		$singleElemOut['CountStats'] = (count ($vlanstats[$vlan_id]) ? 'T' : 'F');
		$singleElemOut['VlanId'] = $vlan_id;
	//	echo '<tr class="state_' . (count ($vlanstats[$vlan_id]) ? 'T' : 'F');
	//	echo '"><th class=tdright>' . $vlan_id . '</th>';
		$singleElemOut['Domains'] = '';
		foreach (array_keys ($domains) as $domain_id)
		{
				
			$singleCell = $tplm->generateModule("StdCenterTableCell", true);
			//echo '<td class=tdcenter>';
			if (array_key_exists ($domain_id, $vlanstats[$vlan_id]))
				$singleCell->setOutput("Cont", mkA ('&exist;', 'vlan', "${domain_id}-${vlan_id}"));
			//	echo mkA ('&exist;', 'vlan', "${domain_id}-${vlan_id}");
			else
				$singleCell->setOutput("Cont", '&nbsp;');
			//	echo '&nbsp;';
			//echo '</td>';
			$singleElemOut['Domains'] = $singleElemOut['Domains'] . $singleCell->run();
		}
	//	echo '</tr>';
		if ($tbc){
			$singleElemOut['TbcLine'] = $tplm->generateModule('TbcLineMod',true, array('CountDomains' => count ($domains)))->run();

		//	echo '<tr class="state_A"><th>...</th><td colspan=' . count ($domains) . '>&nbsp;</td></tr>';
		}
		$outputArray[] = $singleElemOut;
	}
	$mod->setOutput("OutputArr", $outputArray); 
//	echo '</table>';
//	finishPortlet();
}

function renderReports ($what)
{
	if (!count ($what))
		return;
	//echo "<table align=center>\n";
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderReports");
	$mod->setNamespace("reports");
	
	$itemContArr = array();
	foreach ($what as $item)
	{
		$singleItemArr = array('Title' => $item['title']);
		$singleItemArr['Cont'] = '';
	//	echo "<tr><th colspan=2><h3>${item['title']}</h3></th></tr>\n";
		switch ($item['type'])
		{
			case 'counters':
				if (array_key_exists ('args', $item))
					$data = $item['func'] ($item['args']);
				else
					$data = $item['func'] ();
				foreach ($data as $header => $data){
					$singleMod = $tplm->generateModule("ReportsCounter", true);
					$singleMod->setOutput("Header", $header);
					$singleMod->setOutput("Data", $data);
					$singleItemArr['Cont'] .= $singleMod->run();
	//				echo "<tr><td class=tdright>${header}:</td><td class=tdleft>${data}</td></tr>\n";
				}
				break;
			case 'messages':
				if (array_key_exists ('args', $item))
					$data = $item['func'] ($item['args']);
				else
					$data = $item['func'] ();

				foreach ($data as $msg){
					$singleMod = $tplm->generateModule("ReportsMessages", true);
					$singleMod->setOutput("Class", $msg['class']);
					$singleMod->setOutput("Header", $msg['header']);
					$singleMod->setOutput("Text", $msg['text']);
					
					$singleItemArr['Cont'] .= $singleMod->run();
	//				echo "<tr class='msg_${msg['class']}'><td class=tdright>${msg['header']}:</td><td class=tdleft>${msg['text']}</td></tr>\n";
				}
				break;
			case 'meters':
				if (array_key_exists ('args', $item))
					$data = $item['func'] ($item['args']);
				else
					$data = $item['func'] ();
				foreach ($data as $meter)
				{
					$singleMod = $tplm->generateModule("ReportsMeters", true);
					$singleMod->setOutput("Title", $meter['title']);
					$singleMod->setOutput("ProgressBar", getProgressBar ($meter['max'] ? $meter['current'] / $meter['max'] : 0));
					$singleMod->setOutput("IsMax", ($meter['max'] ? $meter['current'] . '/' . $meter['max'] : '0'));
					$singleItemArr['Cont'] .= $singleMod->run();

	//				echo "<tr><td class=tdright>${meter['title']}:</td><td class=tdcenter>";
	//				renderProgressBar ($meter['max'] ? $meter['current'] / $meter['max'] : 0);
	//				echo '<br><small>' . ($meter['max'] ? $meter['current'] . '/' . $meter['max'] : '0') . '</small></td></tr>';
				}
				break;
			case 'custom':
				$singleMod = $tplm->generateModule("ReportsCustom", true);
				$singleMod->setOutput("ItemCont", "" . $item['func']());
				$singleItemArr['Cont'] .= $singleMod->run();
			//	echo "<tr><td colspan=2>";
			//	$item['func']();
			//	echo "</td></tr>\n";
				break;
			default:
				throw new InvalidArgException ('type', $item['type']);
		}
		$itemContArr[] = $singleItemArr;
		//echo "<tr><td colspan=2><hr></td></tr>\n";
	}
	$mod->setOutput("ItemContent", $itemContArr);
		 
	//echo "</table>\n";
}

function renderTagStats ()
{

	$tplm = TemplateManager::getInstance();
	$mod = $tplm->generateModule("RenderTagStats");
	
	global $taglist;
	//echo '<table border=1><tr><th>tag</th><th>total</th><th>objects</th><th>IPv4 nets</th><th>IPv6 nets</th>';
	//echo '<th>racks</th><th>IPv4 VS</th><th>IPv4 RS pools</th><th>users</th><th>files</th></tr>';
	$pagebyrealm = array
	(
		'file' => 'files&tab=default',
		'ipv4net' => 'ipv4space&tab=default',
		'ipv6net' => 'ipv6space&tab=default',
		'ipv4vs' => 'ipv4slb&tab=default',
		'ipv4rspool' => 'ipv4slb&tab=rspools',
		'object' => 'depot&tab=default',
		'rack' => 'rackspace&tab=default',
		'user' => 'userlist&tab=default'
	);
	$allTagsOut = array();
	foreach (getTagChart (getConfigVar ('TAGS_TOPLIST_SIZE')) as $taginfo)
	{
		$singleTag = array('taginfo' => $taginfo['tag'], 'taginfoRefcnt' => $taginfo['refcnt']['total']);
		//echo "<tr><td>${taginfo['tag']}</td><td>" . $taginfo['refcnt']['total'] . "</td>";
		$singleTag['realms'] = '';

		foreach (array ('object', 'ipv4net', 'ipv6net', 'rack', 'ipv4vs', 'ipv4rspool', 'user', 'file') as $realm)
		{			
			$realmMod = $tplm->generateModule('StdTableCell', true);
			//echo '<td>';

			if (!isset ($taginfo['refcnt'][$realm]))
				$realmMod->setOutput('cont', '&nbsp;');
			//	echo '&nbsp;';
			else
			{	
				$realmLinkMod = $tplm->generateSubmodule('cont', 'RenderTagStatsALink', $realmMod, true, array('Pagerealm' => $pagebyrealm[$realm], 
					'TaginfoID' => $taginfo['id'], 'Taginfo' => $taginfo['refcnt'][$realm]));
				//$realmMod->setOutput('cont', $realmLinkMod->run());
				//echo "<a href='index.php?page=" . $pagebyrealm[$realm] . "&cft[]=${taginfo['id']}'>";
				//echo $taginfo['refcnt'][$realm] . '</a>';
			}
			$singleTag['realms'] .= $realmMod->run();
			//echo '</td>';
		}
		//echo '</tr>';
		$allTagsOut[] = $singleTag;
	}
	$mod->setOutput("allTags", $allTagsOut);

	return $mod->run();		 
	//echo '</table>';
}

function dragon ()
{
	startPortlet ('Here be dragons');
?>
<div class=dragon><pre><font color="#00ff33	">
                 \||/
                 |  <font color="#ff0000">@</font>___oo
       /\  /\   / (__<font color=yellow>,,,,</font>|
      ) /^\) ^\/ _)
      )   /^\/   _)
      )   _ /  / _)
  /\  )/\/ ||  | )_)
 &lt;  &gt;      |(<font color=white>,,</font>) )__)
  ||      /    \)___)\
  | \____(      )___) )___
   \______(_______<font color=white>;;;</font> __<font color=white>;;;</font>

</font></pre></div>
<?php
	finishPortlet();
}

// $v is a $configCache item
// prints HTML-formatted varname and description
function renderConfigVarName ($v)
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	
	$mod = $tplm->generateModule("RenderConfigVarName",   true);
	
	$mod->addOutput("vname", $v['varname']);
	$mod->addOutput("desAndIsDefined",  $v['description'] . ($v['is_userdefined'] == 'yes' ? '' : ' (system-wide)'));	 
	
	return $mod->run();
	//echo '<span class="varname">' . $v['varname'] . '</span>';
	//echo '<p class="vardescr">' . $v['description'] . ($v['is_userdefined'] == 'yes' ? '' : ' (system-wide)') . '</p>';
}

function renderUIConfig ()
{
	global $nextorder;
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	
	//$tplm->createMainModule();
	$mod = $tplm->generateSubmodule("Payload","RenderUiConfig");
	$mod->setNamespace("ui");

	//startPortlet ('Current configuration');
	//echo '<table class=cooltable border=0 cellpadding=5 cellspacing=0 align=center width="70%">';
	//echo '<tr><th class=tdleft>Option</th><th class=tdleft>Value</th></tr>';
	$order = 'odd';

	$allLoadConfigCacheOut = array();
	foreach (loadConfigCache() as $v)
	{
		if ($v['is_hidden'] != 'no')
			continue;
		$singleCache = array('order' => $order, 'varvalue' => $v['varvalue']);
		//echo "<tr class=row_${order}>";
		//echo "<td nowrap valign=top class=tdright>";
		$singleCache['renderedConfigVarName'] = renderConfigVarName ($v);
		//renderConfigVarName ($v);
		//echo '</td>';
		//echo "<td valign=top class=tdleft>${v['varvalue']}</td></tr>";
		$order = $nextorder[$order];
		$allLoadConfigCacheOut[] = $singleCache;
	}
	$mod->addOutput("allLoadConfigCache", $allLoadConfigCacheOut);
		 
	//echo "</table>\n";
	//finishPortlet();
}

function renderSNMPPortFinder ($object_id)
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");

	if (!extension_loaded ('snmp'))
	{
		$mod = $tplm->generateSubmodule("Payload","RenderSNMPPortFinder_NoExt", null, true);
		//echo "<div class=msg_error>The PHP SNMP extension is not loaded.  Cannot continue.</div>";
		return;
	}
	
	$mod = $tplm->generateSubmodule("Payload","RenderSNMPPortFinder");
	$mod->setNamespace("object");
		
	$snmpcomm = getConfigVar('DEFAULT_SNMP_COMMUNITY');
	if (empty($snmpcomm))
		$snmpcomm = 'public';

	/*startPortlet ('SNMPv1');
	printOpFormIntro ('querySNMPData', array ('ver' => 1));
	echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
	echo '<tr><th class=tdright><label for=communityv1>Community: </label></th>';
	echo "<td class=tdleft><input type=text name=community id=communityv1 value='${snmpcomm}'></td></tr>";
	echo '<tr><td colspan=2><input type=submit value="Try now"></td></tr>';
	echo '</table></form>';
	finishPortlet();

	startPortlet ('SNMPv2c');
	printOpFormIntro ('querySNMPData', array ('ver' => 2));
	echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
	echo '<tr><th class=tdright><label for=communityv2>Community: </label></th>';
	echo "<td class=tdleft><input type=text name=community id=communityv2 value='${snmpcomm}'></td></tr>";
	echo '<tr><td colspan=2><input type=submit value="Try now"></td></tr>';
	echo '</table></form>';
	finishPortlet();

	startPortlet ('SNMPv3');
	printOpFormIntro ('querySNMPData', array ('ver' => 3));*/
	$mod->addOutput("snmpcomm", $snmpcomm);
	/*	 
?>
	<table cellspacing=0 cellpadding=5 align=center class=widetable>
	<tr>
		<th class=tdright><label for=sec_name>Security User:</label></th>
		<td class=tdleft><input type=text id=sec_name name=sec_name value='<?php echo $snmpcomm;?>'></td>
	</tr>
	<tr>
		<th class=tdright><label for="sec_level">Security Level:</label></th>
		<td class=tdleft><select id="sec_level" name="sec_level">
			<option value="noAuthNoPriv" selected="selected">noAuth and no Priv</option>
			<option value="authNoPriv" >auth without Priv</option>
			<option value="authPriv" >auth with Priv</option>
		</select></td>
	</tr>
	<tr>
		<th class=tdright><label for="auth_protocol_1">Auth Type:</label></th>
		<td class=tdleft>
		<input id=auth_protocol_1 name=auth_protocol type=radio value=md5 />
		<label for=auth_protocol_1>MD5</label>
		<input id=auth_protocol_2 name=auth_protocol type=radio value=sha />
		<label for=auth_protocol_2>SHA</label>
		</td>
	</tr>
	<tr>
		<th class=tdright><label for=auth_passphrase>Auth Key:</label></th>
		<td class=tdleft><input type=text id=auth_passphrase name=auth_passphrase></td>
	</tr>
	<tr>
		<th class=tdright><label for=priv_protocol_1>Priv Type:</label></th>
		<td class=tdleft>
		<input id=priv_protocol_1 name=priv_protocol type=radio value=DES />
		<label for=priv_protocol_1>DES</label>
		<input id=priv_protocol_2 name=priv_protocol type=radio value=AES />
		<label for=priv_protocol_2>AES</label>
		</td>
	</tr>
	<tr>
		<th class=tdright><label for=priv_passphrase>Priv Key</label></th>
		<td class=tdleft><input type=text id=priv_passphrase name=priv_passphrase></td>
	</tr>
	<tr><td colspan=2><input type=submit value="Try now"></td></tr>
	</table>
?<php
	echo '</form>';
	finishPortlet();
	*/
}

function renderUIResetForm()
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderUiResetForm");
	$mod->setNamespace("ui");	
//	printOpFormIntro ('go');
//	echo "This button will reset user interface configuration to its defaults (except organization name): ";
//	echo "<input type=submit value='proceed'>";
//	echo "</form>";
}

function renderLivePTR ($id)
{
	if (isset($_REQUEST['pg']))
		$page = $_REQUEST['pg'];
	else
		$page=0;
	global $pageno, $tabno;
	$maxperpage = getConfigVar ('IPV4_ADDRS_PER_PAGE');
	$range = spotEntity ('ipv4net', $id);
	loadIPAddrList ($range);
	
	$tplm = TemplateManager::getInstance();
	
	$mod = $tplm->generateSubmodule('Payload', 'PTR');
	$mod->setNamespace('ipnetwork',true);
		
	$mod->addOutput('IP', $range['ip']);
	$mod->addOutput('Mask', $range['mask']);
	$mod->addOutput('Name', $range['name']);
	
	//echo "<center><h1>${range['ip']}/${range['mask']}</h1><h2>${range['name']}</h2></center>\n";

	//echo "<table class=objview border=0 width='100%'><tr><td class=pcleft>";
	//startPortlet ('current records');
	$startip = ip4_bin2int ($range['ip_bin']);
	$endip = ip4_bin2int (ip_last ($range));
	$numpages = 0;
	if ($endip - $startip > $maxperpage)
	{
		$numpages = ($endip - $startip) / $maxperpage;
		$startip = $startip + $page * $maxperpage;
		$endip = $startip + $maxperpage - 1;
	}
	//echo "<center>";
	if ($numpages)
	{
		$mod->addOutput('Paged', true);
		$mod->addOutput('StartIP', ip4_format (ip4_int2bin ($startip)));
		$mod->addOutput('EndIP', ip4_format (ip4_int2bin ($endip)));
	}
	//	echo '<h3>' . ip4_format (ip4_int2bin ($startip)) . ' ~ ' . ip4_format (ip4_int2bin ($endip)) . '</h3>';
	for ($i=0; $i<$numpages; $i++)
	{
		if ($i == $page)
		{
			$smod = $tplm->generateSubmodule('Pages', 'IPNetworkAddressesPager');
			$smod->addOutput('B', '<b>');
			// TODO: fix redundant placholder name B
			$smod->addOutput('B', '</b>');  
			$smod->addOutput('I', $i);
			$smod->addOutput('Link', makeHref(array('page'=>$pageno, 'tab'=>$tabno, 'id'=>$id, 'pg'=>$i)));
		}
		//$rendered_pager .= "<b>$i</b> ";
		else
		{
			$smod = $tplm->generateSubmodule('Pages', 'IPNetworkAddressesPager');
			$smod->addOutput('I', $i);
			$smod->addOutput('Link', makeHref(array('page'=>$pageno, 'tab'=>$tabno, 'id'=>$id, 'pg'=>$i)));
		}
	}
	//	if ($i == $page)
	//		echo "<b>$i</b> ";
	//	else
	//		echo "<a href='".makeHref(array('page'=>$pageno, 'tab'=>$tabno, 'id'=>$id, 'pg'=>$i))."'>$i</a> ";
	//echo "</center>";
	
	// FIXME: address counter could be calculated incorrectly in some cases
	$mod->addOutput('AddrCount', ($endip - $startip + 1));
	//printOpFormIntro ('importPTRData', array ('addrcount' => ($endip - $startip + 1)));

	//echo "<table class='widetable' border=0 cellspacing=0 cellpadding=5 align='center'>\n";
	//echo "<tr><th>address</th><th>current name</th><th>DNS data</th><th>import</th></tr>\n";
	$idx = 1;
	$box_counter = 1;
	$cnt_match = $cnt_mismatch = $cnt_missing = 0;
	for ($ip = $startip; $ip <= $endip; $ip++)
	{
		// Find the (optional) DB name and the (optional) DNS record, then
		// compare values and produce a table row depending on the result.
		$ip_bin = ip4_int2bin ($ip);
		$addr = isset ($range['addrlist'][$ip_bin]) ? $range['addrlist'][$ip_bin] : array ('name' => '', 'reserved' => 'no');
		$straddr = ip4_format ($ip_bin);
		$ptrname = gethostbyaddr ($straddr);
		if ($ptrname == $straddr)
			$ptrname = '';
		
		$smod = $tplm->generateSubmodule('IPList', 'PTRAddress', $mod);
		
		$smod->addOutput('IDx', $idx);
		$smod->addOutput('StrAddr', $straddr);
		$smod->addOutput('PtrName', $ptrname);
		$smod->addOutput('Reserved', $addr['reserved']);
		
		//echo "<input type=hidden name=addr_${idx} value=${straddr}>\n";
		//echo "<input type=hidden name=descr_${idx} value=${ptrname}>\n";
		//echo "<input type=hidden name=rsvd_${idx} value=${addr['reserved']}>\n";
		//echo '<tr';
		$print_cbox = FALSE;
		// Ignore network and broadcast addresses
		if (($ip == $startip && $addr['name'] == 'network') || ($ip == $endip && $addr['name'] == 'broadcast'))
			$smod->setOutput('CSSClass', 'trbusy');
			//echo ' class=trbusy';
		if ($addr['name'] == $ptrname)
		{
			if (strlen ($ptrname))
			{
				$smod->setOutput('CSSClass', 'trok');
				$cnt_match++;
			}
		}
		elseif (!strlen ($addr['name']) or !strlen ($ptrname))
		{
			$smod->setOutput('CSSClass', 'trwarning');
			//echo ' class=trwarning';
			$print_cbox = TRUE;
			$cnt_missing++;
		}
		else
		{
			$smod->setOutput('CSSClass', 'trerror');
			//echo ' class=trerror';
			$print_cbox = TRUE;
			$cnt_mismatch++;
		}
		//echo "><td class='tdleft";
		if (isset ($range['addrlist'][$ip_bin]['class']) and strlen ($range['addrlist'][$ip_bin]['class']))
			$smod->addOutput('CSSTDClass', $range['addrlist'][$ip_bin]['class']);
			//echo ' ' . $range['addrlist'][$ip_bin]['class'];
		$smod->addOutput('Link', mkA ($straddr, 'ipaddress', $straddr));
		//echo "'>" . mkA ($straddr, 'ipaddress', $straddr) . '</td>';
		$smod->addOutput('Name', $addr['name']);
		//echo "<td class=tdleft>${addr['name']}</td><td class=tdleft>${ptrname}</td><td>";
		if ($print_cbox)
		{
			$smod->addOutput('BoxCounter', $box_counter++);
		}
			//echo "<input type=checkbox name=import_${idx} tabindex=${idx} id=atom_1_" . $box_counter++ . "_1>";
		//else
		//	echo '&nbsp;';
		//echo "</td></tr>\n";
		$idx++;
	}
	//echo "<tr><td colspan=3 align=center><input type=submit value='Import selected records'></td><td>";
	//addJS ('js/racktables.js');
	if(--$box_counter) 
	{
		$mod->addOutput('BoxCounter', $box_counter);
	}
	//echo --$box_counter ? "<a href='javascript:;' onclick=\"toggleColumnOfAtoms(1, 1, ${box_counter})\">(toggle selection)</a>" : '&nbsp;';
	//echo "</td></tr>";
	//echo "</table>";
	//echo "</form>";
	//finishPortlet();

	//echo "</td><td class=pcright>";
	
	$mod->addOutput('Match', $cnt_match);
	$mod->addOutput('Missing', $cnt_missing);
	if ($cnt_mismatch)
		$mod->addOutput('MisMatch', $cnt_mismatch);
	/** startPortlet ('stats');
	echo "<table border=0 width='100%' cellspacing=0 cellpadding=2>";
	echo "<tr class=trok><th class=tdright>Exact matches:</th><td class=tdleft>${cnt_match}</td></tr>\n";
	echo "<tr class=trwarning><th class=tdright>Missing from DB/DNS:</th><td class=tdleft>${cnt_missing}</td></tr>\n";
	if ($cnt_mismatch)
		echo "<tr class=trerror><th class=tdright>Mismatches:</th><td class=tdleft>${cnt_mismatch}</td></tr>\n";
	echo "</table>\n";
	finishPortlet();

	echo "</td></tr></table>\n"; */
}

function renderAutoPortsForm ($object_id)
{
	$info = spotEntity ('object', $object_id);
	$ptlist = readChapter (CHAP_PORTTYPE, 'a');
	
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderAutoPortsForm");
	$mod->setNamespace("object");

	/*echo "<table class='widetable' border=0 cellspacing=0 cellpadding=5 align='center'>\n";
	echo "<caption>The following ports can be quickly added:</caption>";
	echo "<tr><th>type</th><th>name</th></tr>";*/
	$allAutoPortsOut = array();
	foreach (getAutoPorts ($info['objtype_id']) as $autoport)
		$allAutoPortsOut[] = array('type' => $ptlist[$autoport['type']], 'name' => $autoport['name']);
		//echo "<tr><td>" . $ptlist[$autoport['type']] . "</td><td>${autoport['name']}</td></tr>";
	$mod->addOutput("allAutoPorts", $allAutoPortsOut);
		 
	/*printOpFormIntro ('generate');
	echo "<tr><td colspan=2 align=center>";
	echo "<input type=submit value='Generate'>";
	echo "</td></tr>";
	echo "</table></form>";*/
}

function renderTagRowForViewer ($taginfo, $level = 0, $parent, $placeholder = 'TagList')
{
	$self = __FUNCTION__;
	
	$tplm = TemplateManager::getInstance();
	
	$mod = $tplm->generateSubmodule("TagList", "TagtreeElement", $parent);
	$mod->setNamespace("tagtree",true);
	$mod->setLock();
	
	$statsdecoder = array
	(
		'total' => ' total records linked',
		'object' => ' object(s)',
		'rack' => ' rack(s)',
		'file' => ' file(s)',
		'user' => ' user account(s)',
		'ipv6net' => ' IPv6 network(s)',
		'ipv4net' => ' IPv4 network(s)',
		'ipv4vs' => ' IPv4 virtual service(s)',
		'ipv4rspool' => ' IPv4 real server pool(s)',
		'vst' => ' VLAN switch template(s)',
	);
	if (!count ($taginfo['kids']))
		$level++; // Shift instead of placing a spacer. This won't impact any nested nodes.
	$refc = $taginfo['refcnt']['total'];
	$trclass = $taginfo['is_assignable'] == 'yes' ? '' : ($taginfo['kidc'] ? ' class=trnull' : ' class=trwarning');
	
	if ($taginfo['is_assignable'] == 'yes')
		$mod->addOutput('Assignable', true);
	else 
		$mod->addOutput('Assignable', false);
	
	if ($taginfo['kidc'])
		$mod->addOutput('HasChildren', true);
	else
		$mod->addOutput('HasChildren', false);
	
	
	//echo "<tr${trclass}><td align=left style='padding-left: " . ($level * 16) . "px;'>";
	//if (count ($taginfo['kids']))
		//printImageHREF ('node-expanded-static');
	$stats = array ("tag ID = ${taginfo['id']}");
	if ($taginfo['refcnt']['total'])
		foreach ($taginfo['refcnt'] as $article => $count)
			if (array_key_exists ($article, $statsdecoder))
				$stats[] = $count . $statsdecoder[$article];
	$mod->addOutput('Stats', implode(', ', $stats));
	$mod->addOutput('SpanClass', getTagClassName($taginfo['id']));
	$mod->addOutput('Tag', $taginfo['tag']);
	$mod->addOutput('Refc', $refc ? $refc : '');
	$mod->addOutput('Level', $level * 16);

	//echo '<span title="' . implode (', ', $stats) . '" class="' . getTagClassName ($taginfo['id']) . '">' . $taginfo['tag'];
	//echo ($refc ? " <i>(${refc})</i>" : '') . '</span></td></tr>';
	foreach ($taginfo['kids'] as $kid)
		$self ($kid, $level + 1, $mod);
}

function renderTagRowForEditor ($taginfo, $level = 0, $parent, $placeholder)
{
	$self = __FUNCTION__;
	global $taglist;
	
	$tplm = TemplateManager::getInstance();
	
	$mod = $tplm->generateSubmodule($placeholder, 'TagtreeEditorElement', $parent);
	$mod->setNamespace('tagtree');

	if (!count ($taginfo['kids']))
		$level++; // Idem
	
	$mod->addOutput('Assignable', $taginfo['is_assignable'] == 'yes' ? true : false);
	$mod->addOutput('AssignableInfo', $taginfo['is_assignable']);
	$mod->addOutput('hasChildren', $taginfo['kidc'] ? true : false);
	$mod->addOutput('hasReferences', ($taginfo['refcnt']['total'] > 0 || $taginfo['kidc']));
	$mod->setOutput('Level', $level);
	//$trclass = $taginfo['is_assignable'] == 'yes' ? '' : ($taginfo['kidc'] ? ' class=trnull' : ' class=trwarning');
	//echo "<tr${trclass}><td align=left style='padding-left: " . ($level * 16) . "px;'>";
	//if ($taginfo['kidc'])
	//	printImageHREF ('node-expanded-static');
	//if ($taginfo['refcnt']['total'] > 0 or $taginfo['kidc'])
	//	printImageHREF ('nodestroy', $taginfo['refcnt']['total'] . ' references, ' . $taginfo['kidc'] . ' sub-tags');
	//else
	//	echo getOpLink (array ('op' => 'destroyTag', 'tag_id' => $taginfo['id']), '', 'destroy', 'Delete tag');
	//echo '</td><td>';
	//printOpFormIntro ('updateTag', array ('tag_id' => $taginfo['id']));
	//echo "<input type=text size=48 name=tag_name ";
	
	$mod->addOutput('ID', $taginfo['id']);
	$mod->addOutput('Tag', $taginfo['tag']);
	$mod->addOutput('References', $taginfo['refcnt']['total']);
	$mod->addOutput('Subtags', $taginfo['kidc']);
	
	//echo "value='${taginfo['tag']}'></td><td class=tdleft>";
	//if ($taginfo['refcnt']['total'])
	//	printSelect (array ('yes' => 'yes'), array ('name' => 'is_assignable')); # locked
	//else
	//	printSelect (array ('yes' => 'yes', 'no' => 'no'), array ('name' => 'is_assignable'), $taginfo['is_assignable']);
	//echo '</td><td class=tdleft>';
	$parent_id = $taginfo['parent_id'] ? $taginfo['parent_id'] : 0;
	$parent_name = $taginfo['parent_id'] ? htmlspecialchars ($taglist[$taginfo['parent_id']]['tag']) : '-- NONE --';
	$mod->addOutput('ParentSelect', getSelect
	(
		array ($parent_id => $parent_name),
		array ('name' => 'parent_id', 'id' => 'tagid_' . $taginfo['id'], 'class' => 'taglist-popup'),
		$taginfo['parent_id'],
		FALSE
	));

	//echo '</td><td>' . getImageHREF ('save', 'Save changes', TRUE) . '</form></td></tr>';
	foreach ($taginfo['kids'] as $kid)
		$self ($kid, $level + 1, $mod, 'SubLeafs');
}

function renderTagTree ()
{
	global $tagtree;
	//echo '<center><table>';
	$tplm = TemplateManager::getInstance();
	
	//@TODO Remove after global initialization is finished
	//$tplm->setTemplate('vanilla');
	//$tplm->createMainModule();
	
	$mod = $tplm->generateSubmodule('Payload', 'TagtreeConfig');
	$mod->setNamespace('tagtree',true);
	
	foreach ($tagtree as $taginfo)
		renderTagRowForViewer ($taginfo, 0, $mod);
	//echo '</table></center>';
}

function renderTagTreeEditor ()
{
	/*addJS
	(
function tageditor_showselectbox(e) {
	$(this).load('index.php', {module: 'ajax', ac: 'get-tag-select', tagid: this.id});
	$(this).unbind('mousedown', tageditor_showselectbox);
}
$(document).ready(function () {
	$('select.taglist-popup').bind('mousedown', tageditor_showselectbox);
});
END
		, TRUE
	);*/
	function printNewItemTR ($options, $parent, $placeholder)
	{
		global $taglist;
		$tplm = TemplateManager::getInstance();
		
		$mod = $tplm->generateSubmodule($placeholder, 'TagtreeEditorNew', $parent);
		$mod->setNamespace('tagtree');
		$mod->setOutput('Options', $options);
		//printOpFormIntro ('createTag');
		//echo '<tr>';
		//echo '<td align=left style="padding-left: 16px;">' . getImageHREF ('create', 'Create tag', TRUE) . '</td>';
		//echo '<td><input type=text size=48 name=tag_name tabindex=100></td>';
		//echo '<td class=tdleft>' . getSelect (array ('yes' => 'yes', 'no' => 'no'), array ('name' => 'is_assignable', 'tabindex' => 105), 'yes') . '</td>';
		//echo '<td>' . getSelect ($options, array ('name' => 'parent_id', 'tabindex' => 110)) . '</td>';
		//echo '<td>' . getImageHREF ('create', 'Create tag', TRUE, 120) . '</td>';
		//echo '</tr></form>';
	}
	global $taglist, $tagtree;

	$options = array (0 => '-- NONE --');
	foreach ($taglist as $taginfo)
		$options[$taginfo['id']] = htmlspecialchars ($taginfo['tag']);

	$tplm = TemplateManager::getInstance();
	
	$mod = $tplm->generateSubmodule('Payload', 'TagtreeEditor');
	$mod->setNamespace('tagtree');

	$otags = getOrphanedTags();
	if (count ($otags))
	{
		//startPortlet ('fallen leaves');
		//echo "<table cellspacing=0 cellpadding=5 align=center class=widetable>\n";
		//echo '<tr class=trerror><th>tag name</th><th>parent tag</th><th>&nbsp;</th></tr>';
		foreach ($otags as $taginfo)
		{
			$smod = $tplm->generateSubmodule('OTags', 'TagtreeEdiorOrphaned', $mod);
			$smod->setNamespace('tagtree');
			$smod->addOutput('Name', $taginfo['tag']);
			$smod->addOutput('ID', $taginfo['id']);
			$smod->addOutput('Select', getSelect ($options, array ('name' => 'parent_id'), $taglist[$taginfo['id']]['parent_id']));
			
			//printOpFormIntro ('updateTag', array ('tag_id' => $taginfo['id'], 'tag_name' => $taginfo['tag']));
			//echo '<tr>';
			//echo '<td>' . $taginfo['tag'] . '</td>';
			//echo '<td>' . getSelect ($options, array ('name' => 'parent_id'), $taglist[$taginfo['id']]['parent_id']) . '</td>';
			//echo '<td>' . getImageHREF ('save', 'Save changes', TRUE) . '</td>';
			//echo '</tr></form>';
		}
		//echo '</table>';
		//finishPortlet();
	}

	//startPortlet ('tag tree');
	//echo "<table cellspacing=0 cellpadding=5 align=center class=widetable>\n";
	//echo '<tr><th>&nbsp;</th><th>tag name</th><th>assignable</th><th>parent tag</th><th>&nbsp;</th></tr>';
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
		printNewItemTR ($options, $mod, 'NewTop');
	else
		printNewItemTR ($options, $mod, 'NewBottom');
	
	foreach ($tagtree as $taginfo)
		renderTagRowForEditor ($taginfo, 0, $mod, 'Taglist');
	//if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
	//	printNewItemTR ($options);
	//echo '</table>';
	//finishPortlet();
}

# Return a list of items representing tags with checkboxes.
function buildTagCheckboxRows ($inputname, $preselect, $neg_preselect, $taginfo, $refcnt_realm = '', $level = 0)
{
	static $is_first_time = TRUE;
	$inverted = tagOnChain ($taginfo, $neg_preselect);
	$selected = tagOnChain ($taginfo, $preselect);
	$ret = array
	(
		'tr_class' => ($level == 0 && $taginfo['id'] > 0 && ! $is_first_time) ? 'separator' : '',
		'td_class' => 'tagbox',
		'level' => $level,
		# calculate HTML classnames for separators feature
		'input_class' => $level ? 'tag-cb' : 'tag-cb root',
		'input_value' => $taginfo['id'],
		'text_tagname' => $taginfo['tag'],
	);
	$is_first_time = FALSE;
	$prepared_inputname = $inputname;
	if ($inverted)
	{
		$ret['td_class'] .= ' inverted';
		$prepared_inputname = preg_replace ('/^cf/', 'nf', $prepared_inputname);
	}
	$ret['input_name'] = $prepared_inputname;
	if ($selected)
	{
		$ret['td_class'] .= $inverted ? ' selected-inverted' : ' selected';
		$ret['input_extraattrs'] = 'checked';
	}
	if (array_key_exists ('is_assignable', $taginfo) and $taginfo['is_assignable'] == 'no')
	{
		$ret['input_extraattrs'] = 'disabled';
		$ret['tr_class'] .= (array_key_exists ('kidc', $taginfo) and $taginfo['kidc'] == 0) ? ' trwarning' : ' trnull';
	}
	if (strlen ($refcnt_realm) and isset ($taginfo['refcnt'][$refcnt_realm]))
		$ret['text_refcnt'] = $taginfo['refcnt'][$refcnt_realm];
	$ret = array ($ret);
	if (array_key_exists ('kids', $taginfo))
		foreach ($taginfo['kids'] as $kid)
			$ret = array_merge ($ret, call_user_func (__FUNCTION__, $inputname, $preselect, $neg_preselect, $kid, $refcnt_realm, $level + 1));
	return $ret;
}

# generate HTML from the data produced by the above function
function printTagCheckboxTable ($input_name, $preselect, $neg_preselect, $taglist, $realm = '', TemplateModule $addto = null, $placeholder = "tagCheckbox")
{
	$tplm = TemplateManager::getInstance();
	foreach ($taglist as $taginfo)
		foreach (buildTagCheckboxRows ($input_name, $preselect, $neg_preselect, $taginfo, $realm) as $row)
		{
			
			$tag_class = isset ($taginfo['id']) && isset ($taginfo['refcnt']) ? getTagClassName ($row['input_value']) : '';
			
				if ($addto != null){
					if($placeholder == "")
						$tagobj = $tplm->generateSubmodule("checkbox", "TagTreeCell", $addto);
					else
						$tagobj = $tplm->generateSubmodule($placeholder, "TagTreeCell", $addto);	
					}else{
						$tagobj = $tplm->generateModule("TagTreeCell");
					}
					$tagobj->setNamespace("",true);
					$tagobj->setLock();
					$tagobj->setOutput("TrClass", 		$row['tr_class']);
					$tagobj->setOutput("TdClass", 		$row['td_class']);
					$tagobj->setOutput("LevelPx", 		$row['level'] * 16);
					$tagobj->setOutput("InputClass",	$row['input_class']);
					$tagobj->setOutput("InputName",		$row['input_name']);
					$tagobj->setOutput("InputValue",	$row['input_value']);
					if (array_key_exists ('input_extraattrs', $row))
					{
						$tagobj->setOutput("ExtraAttrs", ' ' . $row['input_extraattrs']);
					}
					else
					{
						$tagobj->setOutput("ExtraAttrs","");
					}
					$tagobj->setOutput("TagClass",		$tag_class);
					$tagobj->setOutput("TagName", 		$row['text_tagname']);
					
					if (array_key_exists ('text_refcnt', $row))
					{
						$tagobj->setOutput("isRefCnt", 	true);
						$tagobj->setOutput("RefCnt", 	$row['text_refcnt']);
					}
				}
				
				if($addto == null){
					return $tagobj->run();
				}
				//	$tag_class = isset ($taginfo['id']) && isset ($taginfo['refcnt']) ? getTagClassName ($row['input_value']) : '';
				/*	echo "<tr class='${row['tr_class']}'><td class='${row['td_class']}' style='padding-left: " . ($row['level'] * 16) . "px;'>";
					echo "<label><input type=checkbox class='${row['input_class']}' name='${row['input_name']}[]' value='${row['input_value']}'";
					if (array_key_exists ('input_extraattrs', $row))
						echo ' ' . $row['input_extraattrs'];
					echo '> <span class="' . $tag_class . '">' . $row['text_tagname'] . '</span>';
					if (array_key_exists ('text_refcnt', $row))
						echo " <i>(${row['text_refcnt']})</i>";
					echo '</label></td></tr>'; */
	
}

function renderEntityTagsPortlet ($title, $tags, $preselect, $realm, TemplateModule $parent = null, $placeholder = "RenderedEntityTagsPortlet")
{
	$tplm = TemplateManager::getInstance();
	//if($parent==null)
	//	$tplm->setTemplate("vanilla");

	if($parent==null)	
		$mod = $tplm->generateModule("RenderEntityTagsPortlet");
	else
		$mod = $tplm->generateSubmodule($placeholder, "RenderEntityTagsPortlet", $parent);
 
	$mod->setOutput("title", $title);		 
//	startPortlet ($title);
//	echo  '<a class="toggleTreeMode" style="display:none" href="#"></a>';
//	echo '<table border=0 cellspacing=0 cellpadding=3 align=center class="tagtree">';
//	printOpFormIntro ('saveTags');
//	printTagCheckboxTable ('taglist', $preselect, array(), $tags, $realm);
	printTagCheckboxTable('taglist', $preselect, array(), $tags, $realm, $mod, "TagCheckbox");
//	echo '<tr><td class=tdleft>';
//	printImageHREF ('SAVE', 'Save changes', TRUE);
//	echo "</form></td><td class=tdright>";
	if (!count ($preselect))
		$mod->setOutput("preSelect", false);		 
//		printImageHREF ('CLEAR gray');
//	else
//	{
//		printOpFormIntro ('saveTags', array ('taglist[]' => ''));
//		printImageHREF ('CLEAR', 'Reset all tags', TRUE);
//		echo '</form>';
//	}
//	echo '</td></tr></table>';
//	finishPortlet();

	if($parent==null)
		return $mod->run();
}

function renderEntityTags ($entity_id)
{
	global $tagtree, $taglist, $target_given_tags, $pageno, $etype_by_pageno;
	
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	$mod = $tplm->generateSubmodule("Payload", "RenderEntityTags");
		
//	echo '<table border=0 width="100%"><tr>';

	if (count ($taglist) > getConfigVar ('TAGS_QUICKLIST_THRESHOLD'))
	{
		$minilist = getTagChart (getConfigVar ('TAGS_QUICKLIST_SIZE'), $etype_by_pageno[$pageno], $target_given_tags);
		// It could happen, that none of existing tags have been used in the current realm.
		if (count ($minilist))
		{
			$js_code = "tag_cb.setTagShortList ({";
			$is_first = TRUE;
			foreach ($minilist as $tag)
			{
				if (! $is_first)
					$js_code .= ",";
				$is_first = FALSE;
				$js_code .= "\n\t${tag['id']} : 1";
			}
			$js_code .= "\n});\n$(document).ready(tag_cb.compactTreeMode);";
			//addJS ('js/tag-cb.js');
			//addJS ($js_code, TRUE);
			$mod->setOutput("JsCode", $js_code);
				 
		}
	}

	// do not do anything about empty tree, trigger function ought to work this out
	//echo '<td class=pcright>';
	//renderEntityTagsPortlet ('Tag tree', $tagtree, $target_given_tags, $etype_by_pageno[$pageno], $mod);
	//echo '</td>';
	renderEntityTagsPortlet ('Tag tree', $tagtree, $target_given_tags, $etype_by_pageno[$pageno], $mod, "RenderedEnityTags");
	//echo '</tr></table>';
}

// This one is going to replace the tag filter.
function renderCellFilterPortlet ($preselect, $realm, $cell_list = array(), $bypass_params = array(), $parent = null, $parentplaceholder = "CellFilterPortlet")
{
	//addJS ('js/tag-cb.js');
	//addJS ('tag_cb.enableNegation()', TRUE);

	global $pageno, $tabno, $taglist, $tagtree;
	$filterc =
	(
		count ($preselect['tagidlist']) +
		count ($preselect['pnamelist']) +
		(mb_strlen ($preselect['extratext']) ? 1 : 0)
	);
	$title = $filterc ? "Tag filters (${filterc})" : 'Tag filters';

	$tplm = TemplateManager::getInstance();

	if($parent == null){
		//$tplm->createMainModule();
		$mod = $tplm->generateModule("CellFilterPortlet");
	}
	else
		$mod = $tplm->generateSubmodule($parentplaceholder, "CellFilterPortlet", $parent);
	//startPortlet ($title);
	$mod->setNamespace("");
	$mod->setLock(true);
	
	$mod->setOutput("PortletTitle", $title);
	
	//echo "<form method=get>\n";
	//echo '<table border=0 align=center cellspacing=0 class="tagtree">';
	//$ruler = "<tr><td colspan=2 class=tagbox><hr></td></tr>\n"; 
	//$hr = '';
	$rulerfirst = true;
	// "reset filter" button only gets active when a filter is applied
	$enable_reset = FALSE;
	// "apply filter" button only gets active when there are checkbox/textarea inputs on the roster
	$enable_apply = FALSE;
	// and/or block
	if (getConfigVar ('FILTER_SUGGEST_ANDOR') == 'yes' or strlen ($preselect['andor']))
	{
		
		//echo $hr;
		if (!$rulerfirst)
		{
			$tplm->generateSubmodule("TableContent", "CellFilterSpacer", $mod, true);
		}
		else
			$rulerfirst = false;
		$andormod = $tplm->generateSubmodule("TableContent", "CellFilterAndOr",$mod);

		//$hr = $ruler;
		$andor = strlen ($preselect['andor']) ? $preselect['andor'] : getConfigVar ('FILTER_DEFAULT_ANDOR');
		//echo '<tr>';
		$cells = array();
		foreach (array ('and', 'or') as $boolop)
		{
			//$class = 'tagbox' . ($andor == $boolop ? ' selected' : '');
			$arr = array();
			$arr["Selected"] = ($andor == $boolop ? 'selected' : '');
			$arr["Boolop"] = $boolop;
			$arr["Checked"] = ($andor == $boolop ? 'checked' : '');
			$cells[] = $arr;
			//$checked = $andor == $boolop ? ' checked' : '';
			//echo "<td class='${class}'><label><input type=radio name=andor value=${boolop}";
			//echo $checked . ">${boolop}</input></label></td>";
		}
		$andormod->addOutput("AndOr", $cells);
	}

	$negated_chain = array();
	foreach ($preselect['negatedlist'] as $key)
		$negated_chain[] = array ('id' => $key);
	// tags block
	if (getConfigVar ('FILTER_SUGGEST_TAGS') == 'yes' or count ($preselect['tagidlist']))
	{
		if (count ($preselect['tagidlist']))
			$enable_reset = TRUE;
		//echo $hr;
		//$hr = $ruler;
		if (!$rulerfirst)
		{
			$tplm->generateSubmodule("TableContent", "CellFilterSpacer", $mod, true);
		}
		else
			$rulerfirst = false;
		// Show a tree of tags, pre-select according to currently requested list filter.
		$objectivetags = getShrinkedTagTree($cell_list, $realm, $preselect);
		if (!count ($objectivetags))
			$tplm->generateSubmodule("TableContent", "CellFilterNoTags", $mod, true);
			//echo "<tr><td colspan=2 class='tagbox sparenetwork'>(nothing is tagged yet)</td></tr>";
		else
		{
			$enable_apply = TRUE;
			printTagCheckboxTable ('cft', buildTagChainFromIds ($preselect['tagidlist']), $negated_chain, $objectivetags, $realm, $mod, "TableContent");
		}

		//if (getConfigVar('SHRINK_TAG_TREE_ON_CLICK') == 'yes')
			//addJS ('tag_cb.enableSubmitOnClick()', TRUE);
	}
	// predicates block
	if (getConfigVar ('FILTER_SUGGEST_PREDICATES') == 'yes' or count ($preselect['pnamelist']))
	{
		if (count ($preselect['pnamelist']))
			$enable_reset = TRUE;
		//echo $hr;

		//$hr = $ruler;
		if (!$rulerfirst)
		{
			$tplm->generateSubmodule("TableContent", "CellFilterSpacer", $mod, true);
		}
		else
			$rulerfirst = false;
		global $pTable;
		$myPredicates = array();
		$psieve = getConfigVar ('FILTER_PREDICATE_SIEVE');
		// Repack matching predicates in a way, which tagOnChain() understands.
		foreach (array_keys ($pTable) as $pname)
			if (preg_match ("/${psieve}/", $pname))
				$myPredicates[] = array ('id' => $pname, 'tag' => $pname);
		if (!count ($myPredicates))
			$tplm->generateSubmodule("TableContent", "CellFilterNoPredicates", $mod, true);
			//echo "<tr><td colspan=2 class='tagbox sparenetwork'>(no predicates to show)</td></tr>";
		else
		{
			$enable_apply = TRUE;
			// Repack preselect likewise.
			$myPreselect = array();
			foreach ($preselect['pnamelist'] as $pname)
				$myPreselect[] = array ('id' => $pname);
			printTagCheckboxTable ('cfp', $myPreselect, $negated_chain, $myPredicates, '',  $mod, "TableContent");
		}
	}
	// extra code
	$enable_textify = FALSE;
	if (getConfigVar ('FILTER_SUGGEST_EXTRA') == 'yes' or strlen ($preselect['extratext']))
	{
		$enable_textify = !empty ($preselect['text']) || !empty($preselect['extratext']);
		$enable_apply = TRUE;
		if (strlen ($preselect['extratext']))
			$enable_reset = TRUE;
		//echo $hr;
		//$hr = $ruler;
		if (!$rulerfirst)
		{
			$tplm->generateSubmodule("TableContent", "CellFilterSpacer", $mod, true);
			$rulerfirst = false;
		}
		$class = isset ($preselect['extraclass']) ? 'class=' . $preselect['extraclass'] : '';
		$tplm->generateSubmodule("TableContent", "CellFilterExtraText", $mod, true, array("Class"=>$class,"Extratext"=>$preselect["extratext"]));
		//echo "<tr><td colspan=2><textarea name=cfe ${class}>\n" . $preselect['extratext'];
		//echo "</textarea></td></tr>\n";
	}
	// submit block //@TODO rausfinden warum das funktioniert.
	{
		//echo $hr;
		//$hr = $ruler;
		if (!$rulerfirst)
		{
			$tplm->generateSubmodule("TableContent", "CellFilterSpacer", $mod, true);
			$rulerfirst = false;
		}
		//echo '<tr><td class=tdleft>';
		// "apply"
		//echo "<input type=hidden name=page value=${pageno}>\n";
		//echo "<input type=hidden name=tab value=${tabno}>\n";
		$bypass_out = '';
		foreach ($bypass_params as $bypass_name => $bypass_value)
			$bypass_out .= '<input type=hidden name="' . htmlspecialchars ($bypass_name, ENT_QUOTES) . '" value="' . htmlspecialchars ($bypass_value, ENT_QUOTES) . '">' . "\n";
		$mod->addOutput("HiddenParams", $bypass_out);
		// FIXME: The user will be able to "submit" the empty form even without a "submit"
		// input. To make things consistent, it is necessary to avoid pritning both <FORM>
		// and "and/or" radio-buttons, when enable_apply isn't TRUE.
		if (!$enable_apply)
			//printImageHREF ('setfilter gray');	
			$mod->setOutput("EnableApply", false); 
		else
			//printImageHREF ('setfilter', 'set filter', TRUE);
			$mod->setOutput("EnableApply", true);
		//echo '</form>';
		if ($enable_textify)
		{
			$text = empty ($preselect['text']) || empty ($preselect['extratext'])
				? $preselect['text']
				: '(' . $preselect['text'] . ')';
			$text .= !empty ($preselect['extratext']) && !empty ($preselect['text'])
				? ' ' . $preselect['andor'] . ' '
				: '';
			$text .= empty ($preselect['text']) || empty ($preselect['extratext'])
				? $preselect['extratext']
				: '(' . $preselect['extratext'] . ')';
			$text = addslashes ($text);
			$submod = $tplm->generateSubmodule("Textify", "CellFilterPortletTextify", $mod);
			$submod->setOutput("Text",$text);
			//echo " <a href=\"#\" onclick=\"textifyCellFilter(this, '$text'); return false\">";
			//printImageHREF ('COPY', 'Make text expression from current filter');
			//echo '</a>';
			/*$js = <<<END

function textifyCellFilter(target, text)
{
	var portlet = $(target).closest ('.portlet');
	portlet.find ('textarea[name="cfe"]').html (text);
	portlet.find ('input[type="checkbox"]').attr('checked', '');
	portlet.find ('input[type="radio"][value="and"]').attr('checked','true');
}
END;
			addJS ($js, TRUE);
			*/

		}
		//echo '</td><td class=tdright>';
		// "reset"
		if (!$enable_reset)
			//printImageHREF ('resetfilter gray');
			$mod->setOutput("EnableReset",false);
		else
		{
			//echo "<form method=get>\n";
			//echo "<input type=hidden name=page value=${pageno}>\n";
			//echo "<input type=hidden name=tab value=${tabno}>\n";
			//echo "<input type=hidden name='cft[]' value=''>\n";
			//echo "<input type=hidden name='cfp[]' value=''>\n";
			//echo "<input type=hidden name='nft[]' value=''>\n";
			//echo "<input type=hidden name='nfp[]' value=''>\n";
			//echo "<input type=hidden name='cfe' value=''>\n";
			$mod->setOutput("EnableReset",true);
			$bypass_out = '';
			foreach ($bypass_params as $bypass_name => $bypass_value)
				$bypass_out .= '<input type=hidden name="' . htmlspecialchars ($bypass_name, ENT_QUOTES) . '" value="' . htmlspecialchars ($bypass_value, ENT_QUOTES) . '">' . "\n";
			$mod->setOutput("HiddenParamsReset",$bypass_out);
			//printImageHREF ('resetfilter', 'reset filter', TRUE);
			//echo '</form>';
		}
		//echo '</td></tr>';
	}
	//echo '</table>';
	//finishPortlet();

	if($parent == null)
		return $mod->run();
}

// Dump all tags in a single SELECT element.
function renderNewEntityTags ($for_realm = '', $parent = null , $placeholder = "RenderedNewEntityTags")
{
	$tplm = TemplateManager::getInstance();

	global $taglist, $tagtree;
	if (!count ($taglist))
	{
		if($parent != null){
			$mod = $tplm->generateSubmodule($placeholder, "RenderNewEntityTags_empty", $parent,  true);
		}
		else{
			$mod = $tplm->generateModule("RenderNewEntityTags_empty",  true);
			return $mod->run();
		}
		return;
	}
	

//	echo '<div class=tagselector><table border=0 align=center cellspacing=0 class="tagtree">';
	if($parent == null){
		$mod = $tplm->generateModule("RenderNewEntityTags");	
	}
	else
		$mod = $tplm->generateSubmodule($placeholder, "RenderNewEntityTags", $parent);

	$mod->setNamespace('',true);
	$mod->setLock(true);
 	printTagCheckboxTable ('taglist', array(), array(), $tagtree, $for_realm, $mod, "checkbox");
//	printTagCheckboxTable ('taglist', array(), array(), $tagtree, $for_realm);
//	echo '</table></div>';
	
	if($parent == null)
		return $mod->run();
}

function renderTagRollerForRow ($row_id)
{
	$a = rand (1, 20);
	$b = rand (1, 20);
	$sum = $a + $b;
	
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate('vanilla');
	//$tplm->createMainModule();
	
	$mod = $tplm->generateSubmodule('Payload', 'TagRoller');
	$mod->setNamespace('row',true);
	$mod->addOutput('a', $a);
	$mod->addOutput('b', $b);
	$mod->addOutput('sum', $sum);
	
	renderNewEntityTags('',$mod,'Tags');

/**	printOpFormIntro ('rollTags', array ('realsum' => $sum));
	echo "<table border=1 align=center>";
	echo "<tr><td colspan=2>This special tool allows assigning tags to physical contents (racks <strong>and all contained objects</strong>) of the current ";
	echo "rack row.<br>The tag(s) selected below will be ";
	echo "appended to already assigned tag(s) of each particular entity. </td></tr>";
	echo "<tr><th>Tags</th><td>";
	echo renderNewEntityTags();
	echo "</td></tr>";
	echo "<tr><th>Control question: the sum of ${a} and ${b}</th><td><input type=text name=sum></td></tr>";
	echo "<tr><td colspan=2 align=center><input type=submit value='Go!'></td></tr>";
	echo "</table></form>"; */
}

function renderRackCodeViewer ()
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderRackCodeViewer");
	$mod->setNamespace("perms");
		
	$text = loadScript ('RackCode');
	//echo '<table width="100%" border=0>';
	$lineno = 1;
	$allLinesOut = array();
	foreach (explode ("\n", $text) as $line)
	{
		$singleLine =  array('lineno' => $lineno, 'line' => $line);
		//echo "<tr><td class=tdright><a name=line${lineno}>${lineno}</a></td>";
		//echo "<td class=tdleft>${line}</td></tr>";
		$lineno++;
		$allLinesOut[] = $singleLine;
	}
	$mod->addOutput("allLines", $allLinesOut);
		 
}

function renderRackCodeEditor ()
{
	//addJS ('js/codemirror/codemirror.js');
	//addJS ('js/codemirror/rackcode.js');
	//addCSS ('js/codemirror/codemirror.css');
	
	/*addJS (<<<ENDJAVASCRIPT
function verify()
{
	$.ajax({
		type: "POST",
		url: "index.php",
		data: {'module': 'ajax', 'ac': 'verifyCode', 'code': $("#RCTA").text()},
		success: function (data)
		{
			arr = data.split("\\n");
			if (arr[0] == "ACK")
			{
				$("#SaveChanges")[0].disabled = "";
				$("#ShowMessage")[0].innerHTML = "Code verification OK, don't forget to save the code";
				$("#ShowMessage")[0].className = "msg_success";
			}
			else
			{
				$("#SaveChanges")[0].disabled = "disabled";
				$("#ShowMessage")[0].innerHTML = arr[1];
				$("#ShowMessage")[0].className = "msg_warning";
			}
		}
	});
}

$(document).ready(function() {
	$("#SaveChanges")[0].disabled = "disabled";
	$("#ShowMessage")[0].innerHTML = "";
	$("#ShowMessage")[0].className = "";

	var rackCodeMirror = CodeMirror.fromTextArea(document.getElementById("RCTA"),{
		mode:'rackcode',
		lineNumbers:true });
	rackCodeMirror.on("change",function(cm,cmChangeObject){
		$("#RCTA").text(cm.getValue());
    });
});
ENDJAVASCRIPT
	, TRUE); */
	$jsRawCode = <<<ENDJAVASCRIPT
function verify()
{
	$.ajax({
		type: "POST",
		url: "index.php",
		data: {'module': 'ajax', 'ac': 'verifyCode', 'code': $("#RCTA").text()},
		success: function (data)
		{
			arr = data.split("\\n");
			if (arr[0] == "ACK")
			{
				$("#SaveChanges")[0].disabled = "";
				$("#ShowMessage")[0].innerHTML = "Code verification OK, don't forget to save the code";
				$("#ShowMessage")[0].className = "msg_success";
			}
			else
			{
				$("#SaveChanges")[0].disabled = "disabled";
				$("#ShowMessage")[0].innerHTML = arr[1];
				$("#ShowMessage")[0].className = "msg_warning";
			}
		}
	});
}

$(document).ready(function() {
	$("#SaveChanges")[0].disabled = "disabled";
	$("#ShowMessage")[0].innerHTML = "";
	$("#ShowMessage")[0].className = "";

	var rackCodeMirror = CodeMirror.fromTextArea(document.getElementById("RCTA"),{
		mode:'rackcode',
		lineNumbers:true });
	rackCodeMirror.on("change",function(cm,cmChangeObject){
		$("#RCTA").text(cm.getValue());
    });
});
ENDJAVASCRIPT;
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderRackCodeEditor");
	$mod->setNamespace("perms");
	$mod->setOutput("jsRawCode", $jsRawCode);

	$text = loadScript ('RackCode');
	//printOpFormIntro ('saveRackCode');
//	echo '<table style="width:100%;border:1px;" border=0 align=center>';
//	echo "<tr><td><textarea rows=40 cols=100 name=rackcode id=RCTA class='codepress rackcode'>";
	$mod->addOutput("text", $text);
//	echo $text . "</textarea></td></tr>\n";
//	echo "<tr><td align=center>";
//	echo '<div id="ShowMessage"></div>';
//	echo "<input type='button' value='Verify' onclick='verify();'>";

//	echo "<input type='submit' value='Save' disabled='disabled' id='SaveChanges' onclick='$(RCTA).toggleEditor();'>";
//	printImageHREF ('SAVE', 'Save changes', TRUE);
//	echo "</td></tr>";
//	echo '</table>';
//	echo "</form>";
}

function renderUser ($user_id)
{
	$userinfo = spotEntity ('user', $user_id);

	$summary = array();
	$summary['Account name'] = $userinfo['user_name'];
	$summary['Real name'] = $userinfo['user_realname'];
	$summary['tags'] = '';
	
	$tplm = TemplateManager::getInstance();
	//$main = $tplm->createMainModule();
	
	
	renderEntitySummary ($userinfo, 'summary', $summary, $tplm->getMainModule(), 'Payload');

	//$tplm->generateSubmodule('Payload', renderFilesPortlet('user', $user_id));
}

function renderMyPasswordEditor ()
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	$mod = $tplm->generateSubmodule("Payload", "RenderMyPasswordEditor");
	$mod->setNamespace("myaccount");

	// printOpFormIntro ('changeMyPassword');
	// echo '<table border=0 align=center>';
	// echo "<tr><th class=tdright>Current password (*):</th><td><input type=password name=oldpassword tabindex=1></td></tr>";
	// echo "<tr><th class=tdright>New password (*):</th><td><input type=password name=newpassword1 tabindex=2></td></tr>";
	// echo "<tr><th class=tdright>New password again (*):</th><td><input type=password name=newpassword2 tabindex=3></td></tr>";
	// echo "<tr><td colspan=2 align=center><input type=submit value='Change' tabindex=4></td></tr>";
	// echo '</table></form>';
}

function renderConfigEditor ()
{
	global $pageno;
	$per_user = ($pageno == 'myaccount');
	global $configCache;

	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule();
	
	$mod = $tplm->generateSubmodule("Payload", "RenderConfigEditor");
	
	$mod->setNamespace("myaccount");
	
	
	// startPortlet ('Current configuration');
	// echo "<table cellspacing=0 cellpadding=5 align=center class=widetable width='50%'>\n";
	// echo "<tr><th class=tdleft>Option</th>";
	// echo "<th class=tdleft>Value</th></tr>";
	// printOpFormIntro ('upd');



	$i = 0;
	$allConfigsPerUser = array();
	foreach ($per_user ? $configCache : loadConfigCache() as $v)
	{
		if ($v['is_hidden'] != 'no')
		 	continue;
		if ($per_user && $v['is_userdefined'] != 'yes')
			continue;

		$singleConfig = array(			
								'RenderConfig' => renderConfigVarName ($v),
								'HtmlSpecialChars' => htmlspecialchars ($v['varvalue'], ENT_QUOTES),
								'VarName' => $v['varname'],
								'Index' => $i
								);
		// echo "<input type=hidden name=${i}_varname value='${v['varname']}'>";
		// echo '<tr><td class="tdright">';
		// echo renderConfigVarName ($v);
		// echo '</td>';
		// echo "<td class=\"tdleft\"><input type=text name=${i}_varvalue value='" . htmlspecialchars ($v['varvalue'], ENT_QUOTES) . "' size=24></td>";
		// echo '<td class="tdleft">';
		if ($per_user && $v['is_altered'] == 'yes')
			$singleConfig['OpLink'] = getOpLink (array('op'=>'reset', 'varname'=>$v['varname']), 'reset');
		else
			$singleConfig['OpLink'] = '';
		// 	echo getOpLink (array('op'=>'reset', 'varname'=>$v['varname']), 'reset');
		// echo '</td>';
		// echo "</tr>\n";
		$i++;
		$allConfigsPerUser[] = $singleConfig;
	}
	$mod->addOutput('LoopArray', $allConfigsPerUser);
	$mod->addOutput("Index", $i);
		 
	// echo "<input type=hidden name=num_vars value=${i}>\n";
	// echo "<tr><td colspan=3>";
	// printImageHREF ('SAVE', 'Save changes', TRUE);
	// echo "</td></tr>";
	// echo "</form>";
	// finishPortlet();
}

function renderMyAccount ()
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	$mod = $tplm->generateSubmodule("Payload", "RenderMyAccount");
	$mod->setNamespace("myaccount", true);
		

	
	global $remote_username, $remote_displayname, $expl_tags, $impl_tags, $auto_tags;
	
	$mod->setOutput('UserName', $remote_username);
	$mod->setOutput('DisplayName', $remote_displayname);
	$mod->setOutput('Serialize1', getExplicitTagsOnly ($expl_tags));
	$mod->setOutput('Serialize2', $impl_tags);
	$mod->setOutput('Serialize3', $auto_tags);

	

	// startPortlet ('Current user info');
	// echo '<div style="text-align: left; display: inline-block;">';
	// echo "<table>";
	// echo "<tr><th>Login:</th><td>${remote_username}</td></tr>\n";
	// echo "<tr><th>Name:</th><td>${remote_displayname}</td></tr>\n";
	// echo "<tr><th>Explicit tags:</th><td>" . serializeTags (getExplicitTagsOnly ($expl_tags)) . "</td></tr>\n";
	// echo "<tr><th>Implicit tags:</th><td>" . serializeTags ($impl_tags) . "</td></tr>\n";
	// echo "<tr><th>Automatic tags:</th><td>" . serializeTags ($auto_tags) . "</td></tr>\n";
	// echo '</table></div>';
}

function renderMyQuickLinks ()
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	$mod = $tplm->generateSubmodule("Payload", "RenderMyQuickLinks");
	$mod->setNamespace("myaccount");

	global $indexlayout, $page;
	// startPortlet ('Items to display in page header');
	// echo '<div style="text-align: left; display: inline-block;">';
	// printOpFormIntro ('save');
	// echo '<ul class="qlinks-form">';
	$active_items = explode (',', getConfigVar ('QUICK_LINK_PAGES'));
	$rowarray = array();
	foreach ($indexlayout as $row)
		foreach ($row as $ypageno)
		{
			$checked_state = in_array ($ypageno, $active_items) ? 'checked' : '';
			$rowarray[] = array('PageName' => getPageName ($ypageno), 'PageNo' => $ypageno, 'CheckedState' =>  $checked_state );
			// echo "<li><label><input type='checkbox' name='page_list[]' value='$ypageno' $checked_state>" . getPageName ($ypageno) . "</label></li>\n";
		}
	$mod->setOutput('LoopArray', $rowarray);	
	// echo '</ul>';
	// printImageHREF ('SAVE', 'Save changes', TRUE);
	// echo '</form></div>';
	// finishPortlet();
}

function renderFileSummary ($file, $parent = null, $placeholder = 'FileSummary')
{
	$tplm = TemplateManager::getInstance();
	$mod = $tplm->generateModule('FileSummaryDownloadLink',true);
	$mod->addOutput('Id', $file['id']);
	
	$summary = array();
	$summary['Type'] = $file['type'];
	$summary['Size'] =
	(
		isolatedPermission ('file', 'download', $file) ?
		(
			$mod->run()
		) : ''
	) . formatFileSize ($file['size']);
	$summary['Created'] = $file['ctime'];
	$summary['Modified'] = $file['mtime'];
	$summary['Accessed'] = $file['atime'];
	$summary['tags'] = '';
	if (strlen ($file['comment']))
	{
		$mod = $tplm->generateModule('FileSummaryComment',true);
		$mod->addOutput('Comment', string_insert_hrefs (htmlspecialchars ($file['comment'])));
		$summary['Comment'] = $mod->run();
	}
	renderEntitySummary ($file, 'summary', $summary, $parent, $placeholder);
}

function renderFileLinks ($links, $parent, $placeholder)
{
	$tplm = TemplateManager::getInstance();
	$mod = $tplm->generateSubmodule($placeholder, 'FileLinks', $parent);
	$mod->setNamespace('file');
	$mod->addOutput("Count", count ($links));
		 
	//startPortlet ('Links (' . count ($links) . ')');
	//echo "<table cellspacing=0 cellpadding='5' align='center' class='widetable'>\n";
	
	//$outarr = array();
	
	foreach ($links as $link)
	{
		$cell = spotEntity ($link['entity_type'], $link['entity_id']);
		//echo '<tr><td class=tdleft>';
		switch ($link['entity_type'])
		{
			case 'user':
			case 'ipv4net':
			case 'rack':
			case 'ipvs':
			case 'ipv4vs':
			case 'ipv4rspool':
			case 'object':
				$tplm->generateSubmodule('Links','StdTableRowClass',$mod,true, array('Content'=>renderCell ($cell), 'Class' => 'tdleft'));
				break;
			default:
				$tplm->generateSubmodule('Links', 'FileLinksObjLink', $mod, true, array('Name'=>formatRealmName ($link['entity_type']),'Link'=>mkCellA ($cell)));
				//$outarr[] = array('Content'=> formatRealmName ($link['entity_type']) . ': ' . mkCellA ($cell)); //@TODO Check mkCellA usage
				break;
		}
		//echo '</td></tr>';
	}
	//$mod->addOutput('Links', $outarr);
	//echo "</table><br>\n";
	//finishPortlet();
}

function renderFilePreview ($pcode)
{
	startPortlet ('preview');
	echo $pcode;
	finishPortlet();
}

// File-related functions
function renderFile ($file_id)
{
	global $nextorder, $aac;
	$file = spotEntity ('file', $file_id);
	
	$tplm = TemplateManager::getInstance();
	
	$mod = $tplm->generateSubmodule('Payload', 'File');
	$mod->setNamespace('file');
	
	$mod->addOutput('Name', htmlspecialchars ($file['name']));
	
	//echo "<table border=0 class=objectview cellspacing=0 cellpadding=0>";
	//echo "<tr><td colspan=2 align=center><h1>" . htmlspecialchars ($file['name']) . "</h1></td></tr>\n";
	//echo "<tr><td class=pcleft>";

	callHook ('renderFileSummary', $file, $mod, 'FileSummary');

	$links = getFileLinks ($file_id);
	if (count ($links))
		callHook ('renderFileLinks', $links, $mod, 'FileLinks');

	//echo "</td>";

	if (isolatedPermission ('file', 'download', $file)) //and '' != ($pcode = getFilePreviewCode ($file)))
	{
		getFilePreviewCode ($file,$mod,'FilePreview');
		//echo "<td class=pcright>";
		//callHook ('renderFilePreview', $pcode);
		//echo "</td>";
	}

	//echo "</tr></table>\n";
}

function renderFileReuploader ()
{
	$tplm = TemplateManager::getInstance();
	$mod = $tplm->generateSubmodule('Payload', 'FileReuploader');
	$mod->setNamespace('file');
	
	/*
	startPortlet ('Replace existing contents');
	printOpFormIntro ('replaceFile', array (), TRUE);
	echo "<input type=file size=10 name=file tabindex=100>&nbsp;\n";
	printImageHREF ('srenderFileBrowserave', 'Save changes', TRUE, 101);
	echo "</form>\n";
	finishPortlet();*/
}

function renderFileDownloader ($file_id)
{
	$tplm = TemplateManager::getInstance();
	$mod = $tplm->generateSubmodule('Payload', 'FileDownloader');
	$mod->setNamespace('file');
	$mod->addOutput('Id', $file_id);
	
	/*
	echo "<br><center><a target='_blank' href='?module=download&file_id=${file_id}&asattach=1'>";
	printImageHREF ('DOWNLOAD');
	echo '</a></center>';*/
}

function renderFileProperties ($file_id)
{
	$file = spotEntity ('file', $file_id);
	
	$tplm = TemplateManageR::getInstance();
	
	$mod = $tplm->generateSubmodule('Payload', 'FileProperties');
	$mod->setNamespace('file');
	
	$mod->addOutput('Type', htmlspecialchars ($file['type']));
	$mod->addOutput('Name', htmlspecialchars ($file['name']));
	$mod->addOutput('Comment', htmlspecialchars ($file['comment']));
	$mod->addOutput('Id', $file_id);
	/** echo '<table border=0 align=center>';
	printOpFormIntro ('updateFile');
	echo "<tr><th class=tdright>MIME-type:</th><td class=tdleft><input tabindex=101 type=text name=file_type value='";
	echo htmlspecialchars ($file['type']) . "'></td></tr>";
	echo "<tr><th class=tdright>Filename:</th><td class=tdleft><input tabindex=102 type=text name=file_name value='";
	echo htmlspecialchars ($file['name']) . "'></td></tr>\n";
	echo "<tr><th class=tdright>Comment:</th><td class=tdleft><textarea tabindex=103 name=file_comment rows=10 cols=80>\n";
	echo htmlspecialchars ($file['comment']) . "</textarea></td></tr>\n";
	echo "<tr><th class=tdright>Actions:</th><td class=tdleft>";
	echo getOpLink (array ('op'=>'deleteFile', 'page'=>'files', 'tab'=>'manage', 'file_id'=>$file_id), '', 'destroy', 'Delete file', 'need-confirmation');
	echo '</td></tr>';
	echo "<tr><th class=submit colspan=2>";
	printImageHREF ('SAVE', 'Save changes', TRUE, 102);
	echo '</th></tr></form></table>'; */
}

function renderFileBrowser ()
{
	$tplm = TemplateManageR::getInstance();

	renderCellList ('file', 'Files', TRUE, NULL, $tplm->getMainModule(), 'Payload');
}

// Like renderFileBrowser(), but with the option to delete files
function renderFileManager ()
{
	// Used for uploading a parentless file
	function printNewItemTR ($parent, $placeholder)
	{
		$tplm = TemplateManager::getInstance();
		
		$mod = $tplm->generateSubmodule($placeholder, 'FileManagerNew', $parent);
		$mod->setNamespace('files');

		renderNewEntityTags ('file',$mod,'Tags');
		
		/** startPortlet ('Upload new');
		printOpFormIntro ('addFile', array (), TRUE);
		echo "<table border=0 cellspacing=0 cellpadding='5' align='center'>";
		echo '<tr><th colspan=2>Comment</th><th>Assign tags</th></tr>';
		echo '<tr><td valign=top colspan=2><textarea tabindex=101 name=comment rows=10 cols=80></textarea></td>';
		echo '<td rowspan=2>'; */
		/** echo '</td></tr>';
		echo "<tr><td class=tdleft><label>File: <input type='file' size='10' name='file' tabindex=100></label></td><td class=tdcenter>";
		printImageHREF ('CREATE', 'Upload file', TRUE, 102);
		echo '</td></tr>';
		echo "</table></form><br>";
		finishPortlet(); */
	}
	
	$tplm = TemplateManager::getInstance();
	//$tplm->createMainModule();
	////$tplm->setTemplate("vanilla");

	$mod = $tplm->generateSubmodule('Payload', 'FileManager');
	$mod->setNamespace('files');
	
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
		printNewItemTR($mod,'NewTop');
	else
		printNewItemTR($mod,'NewBottom');
	
	if (count ($files = listCells ('file')))
	{
		$mod->addOutput('Count', count($files));
		//startPortlet ('Manage existing (' . count ($files) . ')');
		global $nextorder;
		$order = 'odd';
		//echo '<table cellpadding=5 cellspacing=0 align=center class=cooltable>';
		//echo '<tr><th>File</th><th>Unlink</th><th>Destroy</th></tr>';
		foreach ($files as $file)
		{
			$smod = $tplm->generateSubmodule('Content', 'FileManagerRow', $mod);
			$smod->setNamespace('files');

			$smod->addOutput('Count',count ($file['links']));
			$smod->addOutput('Order',$order);
			
			//printf("<tr class=row_%s valign=top><td class=tdleft>", $order);
			$smod->addOutput('Cell', renderCell ($file));
			//	 renderCell ($file);
			// Don't load links data earlier to enable special processing.
			amplifyCell ($file);
			//echo '</td><td class=tdleft>';
			$smod->addOutput('Links', serializeFileLinks ($file['links'], TRUE));
			$smod->setOutput('Count',count ($file['links']));
			$smod->setOutput('Id', $file['id']);
			
			//echo serializeFileLinks ($file['links'], TRUE);
			//echo '</td><td class=tdcenter valign=middle>';
			if (!count ($file['links']))
				$smod->addOutput('Deletable', true);
			/**	printImageHREF ('NODESTROY', 'References (' . count ($file['links']) . ')');
			else
				echo getOpLink (array('op'=>'deleteFile', 'file_id'=>$file['id']), '', 'DESTROY', 'Delete file', 'need-confirmation');
			echo "</td></tr>";*/
			$order = $nextorder[$order];
		}
		//echo '</table>';
		//finishPortlet();
	}

	//if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
		//printNewItemTR();
}

function renderFilesPortlet ($entity_type = NULL, $entity_id = 0, $parent = null, $placeholder = "FilesPortlet")
{
	$files = getFilesOfEntity ($entity_type, $entity_id);
	if (count ($files))
	{
		$tplm = TemplateManager::getInstance();
		//$tplm->setTemplate("vanilla");
	
		if($parent == null)
			$mod = $tplm->generateModule("RenderFilesPortlet",  false);
		else
			$mod = $tplm->generateSubmodule($placeholder, "RenderFilesPortlet", $parent, false);

//		startPortlet ('files (' . count ($files) . ')');
		$mod->setOutput("countFiles", count($files));
			 
//		echo "<table cellspacing=0 cellpadding='5' align='center' class='widetable'>\n";
//		echo "<tr><th>File</th><th>Comment</th></tr>\n";
		$filesOutArray = array();
		foreach ($files as $file)
		{
			$fileArray = array();
//			echo "<tr valign=top><td class=tdleft>";
			// That's a bit of overkill and ought to be justified after
			// getFilesOfEntity() returns a standard cell list.
			$file = spotEntity ('file', $file['id']);
//			renderCell($file);			
			$fileArray["fileCell"] = renderCell ($file);
			$fileArray["comment"] = $file["comment"];
//			echo "</td><td class=tdleft>${file['comment']}</td></tr>";
			if (isolatedPermission ('file', 'download', $file) and '' != ($pcode = getFilePreviewCode ($file))){
				$pCodeMod = $tplm->generateModule('PCodeLine', true, array('pcode' => $pcode));
				$fileArray["pcode"] = $pCodeMod->run();
			}
//				echo "<tr><td colspan=2>${pcode}</td></tr>\n";

			$filesOutArray[] = $fileArray;
		}
		$mod->setOutput("filesOutArray", $filesOutArray);
			 
//		echo "</table><br>\n";
//		finishPortlet();
		if($parent == null)
			return $mod->run();
	}
}

function renderFilesForEntity ($entity_id)
{
	global $pageno, $etype_by_pageno;
	// Now derive entity_type from pageno.
	$entity_type = $etype_by_pageno[$pageno];
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderFilesForEntity");

/*	startPortlet ('Upload and link new');
	echo "<table border=0 cellspacing=0 cellpadding='5' align='center' class='widetable'>\n";
	echo "<tr><th>File</th><th>Comment</th><th></th></tr>\n";
	printOpFormIntro ('addFile', array (), TRUE);
	echo "<tr>";
	echo "<td class=tdleft><input type='file' size='10' name='file' tabindex=100></td>\n";
	echo "<td class=tdleft><textarea tabindex=101 name=comment rows=10 cols=80></textarea></td><td>\n";
	printImageHREF ('CREATE', 'Upload file', TRUE, 120);
	echo "</td></tr></form>";
	echo "</table><br>\n";
	finishPortlet();*/

	$files = getAllUnlinkedFiles ($entity_type, $entity_id);
	if (count ($files))
	{	
		$mod->setOutput("ShowFiles", true);
		$mod->setOutput("CountFiles", count ($files));
		$mod->setOutput("PrintedSelect", printSelect ($files, array ('name' => 'file_id')));
			 	 	 	 	 	 	 
	/*	startPortlet ('Link existing (' . count ($files) . ')');
		printOpFormIntro ('linkFile');
		echo "<table border=0 cellspacing=0 cellpadding='5' align='center'>\n";
		echo '<tr><td class=tdleft>';
		printSelect ($files, array ('name' => 'file_id'));
		echo '</td><td class=tdleft>';
		printImageHREF ('ATTACH', 'Link file', TRUE);
		echo '</td></tr></table>';
		echo "</form>\n";
		finishPortlet();*/
	}

	$filelist = getFilesOfEntity ($entity_type, $entity_id);
	if (count ($filelist))
	{
		$mod->setOutput("ShowFileList", true);
		$mod->setOutput("CountFileList", count ($filelist));

	/*	startPortlet ('Manage linked (' . count ($filelist) . ')');
		echo "<table border=0 cellspacing=0 cellpadding='5' align='center' class='widetable'>\n";
		echo "<tr><th>File</th><th>Comment</th><th>Unlink</th></tr>\n";*/
		$fileListOutArray = array();
		foreach ($filelist as $file_id => $file)
		{
			$fileOutArray = array();
//			echo "<tr valign=top><td class=tdleft>";
//			renderCell (spotEntity ('file', $file_id));
			$fileOutArray['FileCell'] = renderCell (spotEntity ('file', $file_id));
			$fileOutArray['Comment'] = $file['comment'];
			
//			echo "</td><td class=tdleft>${file['comment']}</td><td class=tdcenter>";
			$fileOutArray['OpLink'] = getOpLink (array('op'=>'unlinkFile', 'link_id'=>$file['link_id']), '', 'CUT', 'Unlink file');
//			echo getOpLink (array('op'=>'unlinkFile', 'link_id'=>$file['link_id']), '', 'CUT', 'Unlink file');
//			echo "</td></tr>\n";
			$fileListOutArray[] = $fileOutArray;
		}
		$mod->setOutput("FilelistsOutput", $fileListOutArray);
			 
//		echo "</table><br>\n";
//		finishPortlet();
	}
}


// Iterate over what findRouters() returned and output some text suitable for a TD element.
function printRoutersTD ($rlist, $as_cell = 'yes', $parent = null, $placeholder = 'RoutersTD')
{
	$rtrclass = 'tdleft';
	foreach ($rlist as $rtr)
	{
		$tmp = getIPAddress ($rtr['ip_bin']);
		if ($tmp['class'] == 'trerror')
		{
			$rtrclass = 'tdleft trerror';
			break;
		}
	}
	$tplm = TemplateManager::getInstance();
	
	if($parent == null)
		$mod = $tplm->generateModule('IPSpaceRecordRouter');
	else
		$mod = $tplm->generateSubmodule($placeholder, 'IPSpaceRecordRouter', $parent);
	
	$mod->setNamespace("ipspace");
	$mod->addOutput("TRClass", $rtrclass);
		 

	if ($as_cell == 'yes')
	{
		$mod->setOutput('printCell', true);
	}
	//echo "<td class='${rtrclass}'>";
	//$pfx = '';
	$outarr = array();
	foreach ($rlist as $rtr)
	{
		$rinfo = spotEntity ('object', $rtr['id']);
		if ($as_cell == 'yes')
			$outarr[] = array('Cell'=>renderRouterCell ($rtr['ip_bin'], $rtr['iface'], $rinfo));
		else
			$outarr[] = array('Link'=>makeHref (array ('page' => 'object', 'object_id' => $rtr['id'], 'tab' => 'default', 'hl_ip' => ip_format ($rtr['ip_bin']))), 'Name'=>$rinfo['dname']);
			//echo $pfx . '<a href="' . makeHref (array ('page' => 'object', 'object_id' => $rtr['id'], 'tab' => 'default', 'hl_ip' => ip_format ($rtr['ip_bin']))) . '">' . $rinfo['dname'] . '</a>';
		//$pfx = "<br>\n";
	}
	$mod->addOutput('RouterList', $outarr);
	//echo '</td>';

	if($parent == null)
		return $mod->run();
}

// Same as for routers, but produce two TD cells to lay the content out better.
function printIPNetInfoTDs ($netinfo, $decor = array(), $parent, $placeholder)
{
	$ip_ver = strlen ($netinfo['ip_bin']) == 16 ? 6 : 4;
	$formatted = $netinfo['ip'] . "/" . $netinfo['mask'];
	if ($netinfo['symbol'] == 'spacer')
	{
		$decor['indent']++;
		$netinfo['symbol'] = '';
	}
	
	$tplm = TemplateManager::getInstance();
	
	$mod = $tplm->generateSubmodule($placeholder, 'IPSpaceRecordInfo', $parent);
	$mod->setNamespace("ipspace");
	//echo '<td class="tdleft';
	if (array_key_exists ('tdclass', $decor))
		$mod->addOutput('TDClass', $decor['tdclass']);
		//echo ' ' . $decor['tdclass'];
	$mod->addOutput('Indent', $decor['indent'] * 16);
	
	//echo '" style="padding-left: ' . ($decor['indent'] * 16) . 'px;">';
	if (strlen ($netinfo['symbol']))
	{
		if (array_key_exists ('symbolurl', $decor))
			$mod->addOutput('SymbolLikn', $decor['symbolurl']);
			//echo "<a href='${decor['symbolurl']}'>";
		//printImageHREF ($netinfo['symbol']);
		$mod->addOutput('Symbol', $netinfo['symbol']);
		//if (array_key_exists ('symbolurl', $decor))
		//	echo '</a>';
	}
	
	if (isset ($netinfo['id']))
		$mod->addOutput('ID', $netinfo['id']);
	
	$mod->addOutput('IPVersion', $ip_ver);
		//echo "<a name='net-${netinfo['id']}' href='index.php?page=ipv${ip_ver}net&id=${netinfo['id']}'>";
	$mod->addOutput('Formatted', $formatted);
	//echo $formatted;
	//if (isset ($netinfo['id']))
	//	echo '</a>';
	if (getConfigVar ('IPV4_TREE_SHOW_VLAN') == 'yes' and ! empty ($netinfo['8021q']))
	{
		//echo '<br>';
		$mod->addOutput('VLAN', renderNetVLAN ($netinfo));
	}
	//echo '</td><td class="tdleft';
	if (array_key_exists ('tdclass', $decor))
		$mod->addOutput('TDClass', $decor['tdclass']);
		//echo ' ' . $decor['tdclass'];
	//echo '">';
	if (!isset ($netinfo['id']))
	{
		printImageHREF ('dragons', 'Here be dragons.');
		if ($decor['knight'])
		{
			$mod->addOutput('KnightLink', makeHref (array
				(
					'page' => "ipv${ip_ver}space",
					'tab' => 'newrange',
					'set-prefix' => $formatted,
				)));

			//echo '<a href="' . makeHref (array
			//(
			//	'page' => "ipv${ip_ver}space",
			//	'tab' => 'newrange',
			//	'set-prefix' => $formatted,
			//)) . '">';
			//printImageHREF ('knight', 'create network here');
			//echo '</a>';
		}
	}
	else
	{
		$mod->addOutput('Name', $netinfo['name']);
		//echo niftyString ($netinfo['name']);
		if (count ($netinfo['etags']))
			serializeTags ($netinfo['etags'], "index.php?page=ipv${ip_ver}space&tab=default&", $mod, 'Tags');
			//echo '<br><small>' . serializeTags ($netinfo['etags'], "index.php?page=ipv${ip_ver}space&tab=default&") . '</small>';
	}
	//echo "</td>";
}

function renderCell ($cell)
{

	//Use TemplateEngine
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");		

	$mod = $tplm->generateModule("RenderCell");
	
	switch ($cell['realm'])
	{
	case 'user':
		$mod->setOutput("typeUser", true);

		//echo "<table class='slbcell vscell'><tr><td rowspan=3 width='5%'>";
		
		//echo '</td><td>' . mkA ($cell['user_name'], 'user', $cell['user_id']) . '</td></tr>';
		$mod->setOutput('UserRef', mkA ($cell['user_name'], 'user', $cell['user_id']) );

		if (strlen ($cell['user_realname'])){
			$mod->setOutput("hasUserRealname", true);
		//	echo "<tr><td><strong>" . niftyString ($cell['user_realname']) . "</strong></td></tr>";
			$mod->setOutput("userRealname", niftyString($cell['user_realname']));
		}
		else{
			$mod->setOutput("hasUserRealname", false);
			//echo "<tr><td class=sparenetwork>no name</td></tr>";
		}

	//	echo '<td>';
		if (!isset ($cell['etags']))
			$cell['etags'] = getExplicitTagsOnly (loadEntityTags ('user', $cell['user_id']));
		//echo count ($cell['etags']) ? ("<small>" . serializeTags ($cell['etags']) . "</small>") : '&nbsp;';
		if(count ($cell['etags'])){
			$smallMod = $tplm->generateSubmodule('UserTags', 'SmallElement', $mod, true);
			serializeTags($cell['etags'], '', $smallMod, 'Cont');
		}
		else{
			$mod->setOutput('UserTags', '&nbsp;');
		}

		//$mod->setOutput("userTags", count ($cell['etags']) ? ("<small>" . serializeTags ($cell['etags']) . "</small>") : '&nbsp;' );
		//echo "</td></tr></table>";*/
		break;

	case 'file':

		$mod->setOutput("typeFile", true);
		//echo "<table class='slbcell vscell'><tr><td rowspan=3 width='5%'>		";
		switch ($cell['type'])
		{
			case 'text/plain':
				$mod->setOutput("fileImgSpace", printImageHREF ('text file'));
				break;
			case 'image/jpeg':
			case 'image/png':
			case 'image/gif':
				$mod->setOutput("fileImgSpace", printImageHREF ('image file'));
				break;
			default:
				$mod->setOutput("fileImgSpace", printImageHREF ('empty file'));
				break;
		}
		//echo "</td><td>";
		//echo mkA ('<strong>' . niftyString ($cell['name']) . '</strong>', 'file', $cell['id']);
		$mod->setOutput("nameAndID", mkA ('<strong>' . niftyString ($cell['name']) . '</strong>', 'file', $cell['id']) );

		//echo "</td><td rowspan=3 valign=top>";
		
		if (isset ($cell['links']) and count ($cell['links']))
			$mod->setOutput("serializedLinks", serializeFileLinks ($cell['links']));
		//	printf ("<small>%s</small>", serializeFileLinks ($cell['links']));
		

	//	echo "</td></tr><tr><td>";
	//	echo count ($cell['etags']) ? ("<small>" . serializeTags ($cell['etags']) . "</small>") : '&nbsp;';
		$mod->setOutput("fileCount", count ($cell['etags']) ? ("<small>" . serializeTags ($cell['etags']) . "</small>") : '&nbsp;');
	//	echo '</td></tr><tr><td>';
		if (isolatedPermission ('file', 'download', $cell))
		{
			// FIXME: reuse renderFileDownloader()
			$mod->setOutput("isolatedPerm", true);
			$mod->setOutput("cellID", $cell['id']);
		//	echo "<a href='?module=download&file_id=${cell['id']}'>";
			
			$mod->setOutput("isoPermImg", printImageHREF ('download', 'Download file'));
		//	echo '</a>&nbsp;';
		}
	//	echo formatFileSize ($cell['size']);
		$mod->setOutput("fileSize", formatFileSize ($cell['size']));
	//	echo "</td></tr></table>";
		break;



	case 'ipv4vs':
	case 'ipvs':
	case 'ipv4rspool':
		$mod->setOutput("typeIPV4RSPool", true);
		$mod->setOutput("ipv4ImgSpace", renderSLBEntityCell ($cell));
		break;
	case 'ipv4net':
	case 'ipv6net':

		$mod->setOutput("typeIPNet", true);

	//	echo "<table class='slbcell vscell'><tr><td rowspan=3 width='5%'>";
		//printImageHREF ('NET');
		$mod->setOutput("mkACell",mkA ("${cell['ip']}/${cell['mask']}", $cell['realm'], $cell['id']) );
		//echo '</td><td>' . mkA ("${cell['ip']}/${cell['mask']}", $cell['realm'], $cell['id']);
		//echo getRenderedIPNetCapacity ($cell);
		//echo '</td></tr>';
		$mod->setOutput("renderdIPNetCap",getRenderedIPNetCapacity ($cell) );
		//echo "<tr><td>";


		if (strlen ($cell['name'])){
			$mod->setOutput("cellName",true );
			$mod->setOutput("niftyCellName", niftyString ($cell['name']) );
		//	echo "<strong>" . niftyString ($cell['name']) . "</strong>";
		}
//			else
//				echo "<span class=sparenetwork>no name</span>";
		
		// render VLAN
//		renderNetVLAN ($cell);
		$mod->setOutput("renderedVLan",renderNetVLAN ($cell) );
//		echo "</td></tr>";
//		echo '<tr><td>';
		$mod->setOutput("etags", count ($cell['etags']) ? ("<small>" . serializeTags ($cell['etags']) . "</small>") : '&nbsp;');
//		echo count ($cell['etags']) ? ("<small>" . serializeTags ($cell['etags']) . "</small>") : '&nbsp;';
//		echo "</td></tr></table>";
		break;
		
	case 'rack':
		$mod->setOutput("typeRack", true);
		
		//echo "<table class='slbcell vscell'><tr><td rowspan=3 width='5%'>";
		$thumbwidth = getRackImageWidth();
		$thumbheight = getRackImageHeight ($cell['height']);

		$mod->setOutput("thumbWidth", $thumbwidth);
		$mod->setOutput("thumbHeight", $thumbheight);
		$mod->setOutput("cellHeight", $cell['height']);
		$mod->setOutput("cellID", $cell['id']);
		$mod->setOutput("cellName", $cell['name']);
		$mod->setOutput("cellComment", niftyString ($cell['comment']));
		$mod->setOutput("mkACell",mkA ('<strong>' . niftyString ($cell['name']) . '</strong>', 'rack', $cell['id']) );
		$mod->setOutput("etags", count ($cell['etags']) ? ("<small>" . serializeTags ($cell['etags']) . "</small>") : '&nbsp;');
	

//			echo "<img border=0 width=${thumbwidth} height=${thumbheight} title='${cell['height']} units' ";
//			echo "src='?module=image&img=minirack&rack_id=${cell['id']}'>";
//			echo "</td><td>";
//			echo mkA ('<strong>' . niftyString ($cell['name']) . '</strong>', 'rack', $cell['id']);
//			echo "</td></tr><tr><td>";
//			echo niftyString ($cell['comment']);
//			echo "</td></tr><tr><td>";
//			echo count ($cell['etags']) ? ("<small>" . serializeTags ($cell['etags']) . "</small>") : '&nbsp;';
//			echo "</td></tr></table>";
		break;
	case 'location':
		$mod->setOutput("typeLocation", true);

		$mod->setOutput("cellName", $cell['name']);
		$mod->setOutput("cellID", $cell['id']);
		$mod->setOutput("cellComment", niftyString ($cell['comment']));
		$mod->setOutput("mkACell",mkA ('<strong>' . niftyString ($cell['name']) . '</strong>', 'location', $cell['id']) );
		$mod->setOutput("etags", count ($cell['etags']) ? ("<small>" . serializeTags ($cell['etags']) . "</small>") : '&nbsp;');

//			echo "<table class='slbcell vscell'><tr><td rowspan=3 width='5%'>";
//			printImageHREF ('LOCATION');
//			echo "</td><td>";
//			echo mkA ('<strong>' . niftyString ($cell['name']) . '</strong>', 'location', $cell['id']);
//			echo "</td></tr><tr><td>";
//			echo niftyString ($cell['comment']);
//			echo "</td></tr><tr><td>";
//			echo count ($cell['etags']) ? ("<small>" . serializeTags ($cell['etags']) . "</small>") : '&nbsp;';
//			echo "</td></tr></table>";
		break;
	case 'object':
		$mod->setOutput("typeObject", true);

		$mod->setOutput("cellDName", $cell['dname']);
		$mod->setOutput("cellID", $cell['id']);
		$mod->setOutput("mkACell",mkA ('<strong>' . niftyString ($cell['dname']) . '</strong>', 'object', $cell['id']) );
		$mod->setOutput("etags", count ($cell['etags']) ? ("<small>" . serializeTags ($cell['etags']) . "</small>") : '&nbsp;');
//		$mod->setOutput("testtest", mkA ('<strong>' . niftyString ($cell['name']) . '</strong>', 'object', $cell['id']));		
//			echo "<table class='slbcell vscell'><tr><td rowspan=2 width='5%'>";
//			printImageHREF ('OBJECT');
//			echo '</td><td>';
//			echo mkA ('<strong>' . niftyString ($cell['dname']) . '</strong>', 'object', $cell['id']);
//			echo '</td></tr><tr><td>';
//			echo count ($cell['etags']) ? ("<small>" . serializeTags ($cell['etags']) . "</small>") : '&nbsp;';
//			echo "</td></tr></table>";
		break;
	default:
		throw new InvalidArgException ('realm', $cell['realm']);
	}

	return $mod->run();
}

function renderRouterCell ($ip_bin, $ifname, $cell, $parent = null, $placeholder = '')
{
	$dottedquad = ip_format ($ip_bin);
	
	$tplm = TemplateManager::getInstance();
	
	if ($parent === null)
		$mod = $tplm->generateModule('RouterCell');
	else
		$mod = $tplm->generateSubmodule($placeholder, 'RouterCell', $parent);
	
	$mod->setNamespace('ipnetwork');
	//$mod->setLock();
	
	$mod->addOutput('IP', $dottedquad);
	
	if (strlen( $ifname))
		$mod->addOutput('ifname', '@' . $ifname);
	
	$mod->addOutput('Name', $cell['dname']);
	$mod->addOutput('Id', $cell['id']);
	
	if (count($cell['etags']))
		serializeTags ($cell['etags'], '', $mod, 'Tags');
	
	/*
	echo "<table class=slbcell><tr><td rowspan=3>${dottedquad}";
	if (strlen ($ifname))
		echo '@' . $ifname;
	echo "</td>";
	echo "<td><a href='index.php?page=object&object_id=${cell['id']}&hl_ip=${dottedquad}'><strong>${cell['dname']}</strong></a></td>";
	echo "</td></tr><tr><td>";
	printImageHREF ('router');
	echo "</td></tr><tr><td>";
	if (count ($cell['etags']))
		echo '<small>' . serializeTags ($cell['etags']) . '</small>';
	echo "</td></tr></table>";*/
	
	if ($parent === null) { 
		return $mod->run(); 
	}
}

// Return HTML code necessary to show a preview of the file give. Return an empty string,
// if a preview cannot be shown
function getFilePreviewCode ($file, $parent, $mod)
{
	$tplm = TemplateManager::getInstance();
	
	$ret = '';
	switch ($file['type'])
	{
		// "These types will be automatically detected if your build of PHP supports them: JPEG, PNG, GIF, WBMP, and GD2."
		case 'image/jpeg':
		case 'image/png':
		case 'image/gif':
			$file = getFile ($file['id']);
			$image = imagecreatefromstring ($file['contents']);
			$width = imagesx ($image);
			$height = imagesy ($image);
			
			
			if ($width < getConfigVar ('PREVIEW_IMAGE_MAXPXS') and $height < getConfigVar ('PREVIEW_IMAGE_MAXPXS'))
				$resampled = FALSE;
			else
			{
				$ratio = getConfigVar ('PREVIEW_IMAGE_MAXPXS') / max ($width, $height);
				$width = $width * $ratio;
				$height = $height * $ratio;
				$resampled = TRUE;
			}
			

			$mod = $tplm->generateSubmodule($placeholder, 'FilePreviewImage', $parent);
			$mod->addOutput('Height', $height);
			$mod->addOutput('Width', $width);
			$mod->addOutput('Id', $file['id']);
			$mod->addOutput('Resampled', $resampled);
			
			/*
			if ($resampled)
				$ret .= "<a href='?module=download&file_id=${file['id']}&asattach=no'>";
			$ret .= "<img width=${width} height=${height} src='?module=image&img=preview&file_id=${file['id']}'>";
			if ($resampled)
				$ret .= '</a><br>(click to zoom)';*/
			break;
		case 'text/plain':
			if ($file['size'] < getConfigVar ('PREVIEW_TEXT_MAXCHARS'))
			{
				$file = getFile ($file['id']);
				
				$mod = $tplm->generateSubmodule($placeholder, 'FilePreviewText', $parent);
				$mod->addOutput('Rows', getConfigVar ('PREVIEW_TEXT_ROWS'));
				$mod->addOutput('Cols', getConfigVar ('PREVIEW_TEXT_COLS'));
				$mod->addOutput('Content', $file['contents']);
				
				/*
				$ret .= '<textarea readonly rows=' . getConfigVar ('PREVIEW_TEXT_ROWS');
				$ret .= ' cols=' . getConfigVar ('PREVIEW_TEXT_COLS') . '>';
				$ret .= htmlspecialchars ($file['contents']);
				$ret .= '</textarea>';
				*/
			}
			break;
		default:
			break;
	}
	return $ret;
}

function renderTextEditor ($file_id)
{
	global $CodePressMap;
	$fullInfo = getFile ($file_id);
	//printOpFormIntro ('updateFileText', array ('mtime_copy' => $fullInfo['mtime']));
	preg_match('/.+\.([^.]*)$/', $fullInfo['name'], $matches); # get file extension
	if (isset ($matches[1]) && isset ($CodePressMap[$matches[1]]))
		$syntax = $CodePressMap[$matches[1]];
	else
		$syntax = "text";
	
	$tplm = TemplateManager::getInstance();
	
	$mod = $tplm->generateSubmodule('Payload', 'TextEditor');
	$mod->addOutput('MTime', $fullInfo['mtime']);
	$mod->addOutput('Content', htmlspecialchars ($fullInfo['contents']));
	$mod->addOutput('Syntax', $syntax);
	
	/**echo '<table border=0 align=center>';
	addJS ('js/codepress/codepress.js');
	echo "<tr><td><textarea rows=45 cols=180 id=file_text name=file_text tabindex=101 class='codepress " . $syntax . "'>\n";
	echo htmlspecialchars ($fullInfo['contents']) . '</textarea></td></tr>';
	echo "<tr><td class=submit><input type=submit value='Save' onclick='$(file_text).toggleEditor();'>";
	echo "</td></tr>\n</table></form>\n";*/
}

function showPathAndSearch ($pageno, $tabno, $tpl = false)
{
	// This function returns array of page numbers leading to the target page
	// plus page number of target page itself. The first element is the target
	// page number and the last element is the index page number.
	function getPath ($targetno)
	{
		$self = __FUNCTION__;
		global $page;
		$path = array();
		$page_name = preg_replace ('/:.*/', '', $targetno);
		// Recursion breaks at first parentless page.
		if ($page_name == 'ipaddress')
		{
			// case ipaddress is a universal v4/v6 page, it has two parents and requires special handling
			$ip_bin = ip_parse ($_REQUEST['ip']);
			$parent = (strlen ($ip_bin) == 16 ? 'ipv6net' : 'ipv4net');
			$path = $self ($parent);
			$path[] = $targetno;
		}
		elseif (!isset ($page[$page_name]['parent']))
			$path = array ($targetno);
		else
		{
			$path = $self ($page[$page_name]['parent']);
			$path[] = $targetno;
		}
		return $path;
	}
	global $page, $tab;
	// Path.
	if ($tpl)
	{
	////New Version
	$path = getPath ($pageno);
	$items = array();
	
	$tplm = TemplateManager::getInstance();
	$mod = $tplm->getMainModule();
	foreach (array_reverse ($path) as $no)
	{
		if (preg_match ('/(.*):(.*)/', $no, $m) && isset ($tab[$m[1]][$m[2]]))
			$title = array
			(
				'name' => $tab[$m[1]][$m[2]],
				'params' => array('page' => $m[1], 'tab' => $m[2]),
			);
		elseif (isset ($page[$no]['title']))
			$title = array
			(
				'name' => $page[$no]['title'],
				'params' => array()
			);
		else
			$title = callHook ('dynamic_title_decoder', $no);
		//$item = "<a href='index.php?";
		$item = $tplm->generateModule("PathLink", true);
		
		if (! isset ($title['params']['page']))
			$title['params']['page'] = $no;
		if (! isset ($title['params']['tab']))
			$title['params']['tab'] = 'default';
		$is_first = TRUE;
		$anchor_tail = '';
		$params = '';
		foreach ($title['params'] as $param_name => $param_value)
		{
			if ($param_name == '#')
			{
				$anchor_tail = '#' . $param_value;
				continue;
			}
			$params .= ($is_first ? '' : '&') . "${param_name}=${param_value}";
			$is_first = FALSE;
		}
		//$item .= $anchor_tail;
		//$item .= "'>" . $title['name'] . "</a>";
		$item->addOutput("Params", $params);
		$item->addOutput("AnchorTail", $anchor_tail);
		$item->addOutput("Name", $title['name']);
		
		$items[] = $item;

		// location bread crumbs insert for Rows and Racks
		if ($no == 'row')
		{
			$trail = getLocationTrail ($title['params']['location_id']);
			if(!empty ($trail))
				$items[] = $trail;
		}
		if($no == 'location')
		{
			// overwrite the bread crumb for current location with whole path
			$items[count ($items)-1] = getLocationTrail ($title['params']['location_id']);
		}
	}
	// Search form.
	//echo "<div class='searchbox' style='float:right'>";
	//echo "<form name=search method=get>";
	//echo '<input type=hidden name=page value=search>';
	//echo "<input type=hidden name=last_page value=$pageno>";
	//echo "<input type=hidden name=last_tab value=$tabno>";
	// This input will be the first, if we don't add ports or addresses.
	//echo "<label>Search:<input type=text name=q size=20 tabindex=1000 value='".(isset ($_REQUEST['q']) ? htmlspecialchars ($_REQUEST['q'], ENT_QUOTES) : '')."'></label></form></div>";
	$mod->addOutput("PageNo", $pageno);
	$mod->addOutput("TabNo", $tabno);
	$mod->addOutput("SearchValue", (isset ($_REQUEST['q']) ? htmlspecialchars ($_REQUEST['q'], ENT_QUOTES) : '')) ;
	$mod->addOutput("Path", array_reverse($items));
	// Path (breadcrumbs)
	//echo implode(' : ', array_reverse ($items));
	}
	else
	{
	///////Old Version
	//@TODO Remove Old Version change to template engine
		$path = getPath ($pageno);
		$items = array();
		
		foreach (array_reverse ($path) as $no)
		{
			if (preg_match ('/(.*):(.*)/', $no, $m) && isset ($tab[$m[1]][$m[2]]))
			$title = array
		(
				'name' => $tab[$m[1]][$m[2]],
				'params' => array('page' => $m[1], 'tab' => $m[2]),
		);
	elseif (isset ($page[$no]['title']))
	$title = array
	(
			'name' => $page[$no]['title'],
			'params' => array()
	);
	else
		$title = callHook ('dynamic_title_decoder', $no);
	
	$item = "<a href='index.php?";
	
	

	if (! isset ($title['params']['page']))
		$title['params']['page'] = $no;
	if (! isset ($title['params']['tab']))
		$title['params']['tab'] = 'default';
		$is_first = TRUE;
		$anchor_tail = '';
		$params = '';
		foreach ($title['params'] as $param_name => $param_value)
		{
				if ($param_name == '#')
			{
				$anchor_tail = '#' . $param_value;
				continue;
			}
			$params .= ($is_first ? '' : '&') . "${param_name}=${param_value}";
			$is_first = FALSE;
	}
	$item .= $anchor_tail;
	$item .= "'>" . $title['name'] . "</a>";
	
	$items[] = $item;
	
	// location bread crumbs insert for Rows and Racks
	if ($no == 'row')
	{
		$trail = getLocationTrail ($title['params']['location_id']);
		if(!empty ($trail))
			$items[] = $trail;
	}
	if($no == 'location')
	{
		// overwrite the bread crumb for current location with whole path
			$items[count ($items)-1] = getLocationTrail ($title['params']['location_id']);
		}
	}
	// Search form.
	echo "<div class='searchbox' style='float:right'>";
	echo "<form name=search method=get>";
	echo '<input type=hidden name=page value=search>';
	echo "<input type=hidden name=last_page value=$pageno>";
	echo "<input type=hidden name=last_tab value=$tabno>";
	// This input will be the first, if we don't add ports or addresses.
	echo "<label>Search:<input type=text name=q size=20 tabindex=1000 value='".(isset ($_REQUEST['q']) ? htmlspecialchars ($_REQUEST['q'], ENT_QUOTES) : '')."'></label></form></div>";
	
	// Path (breadcrumbs)
	echo implode(' : ', array_reverse ($items));
	}
}

function getTitle ($pageno)
{
	global $page;
	if (isset ($page[$pageno]['title']))
		return $page[$pageno]['title'];
	$tmp = callHook ('dynamic_title_decoder', $pageno);
	return $tmp['name'];
}

function showTabs ($pageno, $tabno,$tpl = false)
{
	global $tab, $page, $trigger;
	if (!isset ($tab[$pageno]['default']))
		return;
	
	if($tpl)
	{
	$tplm = TemplateManager::getInstance();
	$mod = $tplm->getMainModule();
	
	//echo "<div class=greynavbar><ul id=foldertab style='margin-bottom: 0px; padding-top: 10px;'>";
	foreach ($tab[$pageno] as $tabidx => $tabtitle)
	{
		// Hide forbidden tabs.
		if (!permitted ($pageno, $tabidx))
		{
			continue;
		}
		// Dynamic tabs should only be shown in certain cases (trigger exists and returns true).
		if (!isset ($trigger[$pageno][$tabidx]))
			$tabclass = 'TabInactive';
		elseif (strlen ($tabclass = call_user_func ($trigger[$pageno][$tabidx])))
		{
			switch ($tabclass)
			{
				case 'std': $tabclass = "TabInactive";
				case 'attn': $tabclass = "TabAttention";
				default: $tabclass = "TabInactive";
			}
		}
		else
		{
			continue;
		}
		
		if ($tabidx == $tabno)
			$tabclass = 'TabActive'; // override any class for an active selection
		//echo "<li><a class=${tabclass}";
		//echo " href='index.php?page=${pageno}&tab=${tabidx}";
		$args = array();
		fillBypassValues ($pageno, $args);
		$extraargs = "";
		foreach ($args as $param_name => $param_value)
			$extraargs.= "&" . urlencode ($param_name) . '=' . urlencode ($param_value);
		$params = array("Page"=>$pageno,
						"Tab"=>$tabidx,
						"Args"=>$extraargs,
						"Title"=>$tabtitle);
		$tplm->generateSubmodule("Tabs", $tabclass, $mod, true, $params);
		//echo "'>${tabtitle}</a></li>\n";
	}
	//echo "</ul></div>";
	}
	else
	{ ////Old version
		//@TODO Remove Old version, change to TemplateEngine
		echo "<div class=greynavbar><ul id=foldertab style='margin-bottom: 0px; padding-top: 10px;'>";
		foreach ($tab[$pageno] as $tabidx => $tabtitle)
		{
			// Hide forbidden tabs.
			if (!permitted ($pageno, $tabidx))
				continue;
			// Dynamic tabs should only be shown in certain cases (trigger exists and returns true).
			if (!isset ($trigger[$pageno][$tabidx]))
				$tabclass = 'std';
			elseif (!strlen ($tabclass = call_user_func ($trigger[$pageno][$tabidx])))
			continue;
			if ($tabidx == $tabno)
				$tabclass = 'current'; // override any class for an active selection
			echo "<li><a class=${tabclass}";
			echo " href='index.php?page=${pageno}&tab=${tabidx}";
			$args = array();
			fillBypassValues ($pageno, $args);
			foreach ($args as $param_name => $param_value)
				echo "&" . urlencode ($param_name) . '=' . urlencode ($param_value);
		
				echo "'>${tabtitle}</a></li>\n";
		}
				echo "</ul></div>";
	}
}

// Arg is path page number, which can be different from the primary page number,
// for example title for 'ipv4net' can be requested to build navigation path for
// both IPv4 network and IPv4 address. Another such page number is 'row', which
// fires for both row and its racks. Use pageno for decision in such cases.
function dynamic_title_decoder ($path_position)
{
	global $sic, $page_by_realm;
	static $net_id;
	try {
	switch ($path_position)
	{
	case 'index':
		return array
		(
			'name' => '/' . getConfigVar ('enterprise'),
			'params' => array()
		);
	case 'chapter':
		$chapter_no = assertUIntArg ('chapter_no');
		$chapters = getChapterList();
		$chapter_name = isset ($chapters[$chapter_no]) ? $chapters[$chapter_no]['name'] : 'N/A';
		return array
		(
			'name' => "Chapter '${chapter_name}'",
			'params' => array ('chapter_no' => $chapter_no)
		);
	case 'user':
		$userinfo = spotEntity ('user', assertUIntArg ('user_id'));
		return array
		(
			'name' => "Local user '" . $userinfo['user_name'] . "'",
			'params' => array ('user_id' => $userinfo['user_id'])
		);
	case 'ipv4rspool':
		$pool_info = spotEntity ('ipv4rspool', assertUIntArg ('pool_id'));
		return array
		(
			'name' => !strlen ($pool_info['name']) ? 'ANONYMOUS' : $pool_info['name'],
			'params' => array ('pool_id' => $pool_info['id'])
		);
	case 'ipv4vs':
		$vs_info = spotEntity ('ipv4vs', assertUIntArg ('vs_id'));
		return array
		(
			'name' => $vs_info['dname'],
			'params' => array ('vs_id' => $vs_info['id'])
		);
	case 'ipvs':
		$vs_info = spotEntity ('ipvs', assertUIntArg ('vs_id'));
		return array
		(
			'name' => $vs_info['name'],
			'params' => array ('vs_id' => $vs_info['id'])
		);
	case 'object':
		$object = spotEntity ('object', assertUIntArg ('object_id'));
		return array
		(
			'name' => $object['dname'],
			'params' => array ('object_id' => $object['id'])
		);
	case 'location':
		$location = spotEntity ('location', assertUIntArg ('location_id'));
		return array
		(
			'name' => $location['name'],
			'params' => array ('location_id' => $location['id'])
		);
	case 'row':
		global $pageno;
		switch ($pageno)
		{
		case 'rack':
			$rack = spotEntity ('rack', assertUIntArg ('rack_id'));
			return array
			(
				'name' => $rack['row_name'],
				'params' => array ('row_id' => $rack['row_id'], 'location_id' => $rack['location_id'])
			);
		case 'row':
			$row_info = getRowInfo (assertUIntArg ('row_id'));
			return array
			(
				'name' => $row_info['name'],
				'params' => array ('row_id' => $row_info['id'], 'location_id' => $row_info['location_id'])
			);
		default:
			break;
		}
	case 'rack':
		$rack_info = spotEntity ('rack', assertUIntArg ('rack_id'));
		return array
		(
			'name' => $rack_info['name'],
			'params' => array ('rack_id' => $rack_info['id'])
		);
	case 'search':
		if (isset ($_REQUEST['q']))
			return array
			(
				'name' => "search results for '${_REQUEST['q']}'",
				'params' => array ('q' => $_REQUEST['q'])
			);
		else
			return array
			(
				'name' => 'search results',
				'params' => array()
			);
	case 'file':
		$file = spotEntity ('file', assertUIntArg ('file_id'));
		return array
		(
			'name' => niftyString ($file['name'], 30, FALSE),
			'params' => array ('file_id' => $_REQUEST['file_id'])
		);
	case 'ipaddress':
		$address = getIPAddress (ip_parse ($_REQUEST['ip']));
		return array
		(
			'name' => niftyString ($address['ip'] . ($address['name'] != '' ? ' (' . $address['name'] . ')' : ''), 50, FALSE),
			'params' => array ('ip' => $address['ip'])
		);
	case 'ipv4net':
	case 'ipv6net':
        global $pageno;
        switch ($pageno)
		{
			case 'ipaddress':
				$net = spotNetworkByIP (ip_parse ($_REQUEST['ip']));
				$ret = array
				(
					'name' => $net['ip'] . '/' . $net['mask'],
					'params' => array
					(
						'id' => $net['id'],
						'page' => $net['realm'], // 'ipv4net', 'ipv6net'
						'hl_ip' => $_REQUEST['ip'],
					)
				);
				return ($ret);
			default:
				$net = spotEntity ($path_position, assertUIntArg ('id'));
				return array
				(
					'name' => $net['ip'] . '/' . $net['mask'],
					'params' => array ('id' => $net['id'])
				);
		}
		break;
	case 'ipv4space':
	case 'ipv6space':
		global $pageno;
        switch ($pageno)
		{
			case 'ipaddress':
				$net_id = getIPAddressNetworkId (ip_parse ($_REQUEST['ip']));
				break;
			case 'ipv4net':
			case 'ipv6net':
				$net_id = $_REQUEST['id'];
				break;
			default:
				$net_id = NULL;
		}
		$params = array();
		if (isset ($net_id))
			$params = array ('eid' => $net_id, 'hl_net' => 1, 'clear-cf' => '');
		unset ($net_id);
		$ip_ver = preg_replace ('/[^\d]*/', '', $path_position);
		return array
		(
			'name' => "IPv$ip_ver space",
			'params' => $params,
		);
	case 'vlandomain':
		global $pageno;
		switch ($pageno)
		{
		case 'vlandomain':
			$vdom_id = $_REQUEST['vdom_id'];
			break;
		case 'vlan':
			list ($vdom_id, $dummy) = decodeVLANCK ($_REQUEST['vlan_ck']);
			break;
		default:
			break;
		}
		$vdlist = getVLANDomainOptions();
		if (!array_key_exists ($vdom_id, $vdlist))
			throw new EntityNotFoundException ('VLAN domain', $vdom_id);
		return array
		(
			'name' => niftyString ("domain '" . $vdlist[$vdom_id] . "'", 20, FALSE),
			'params' => array ('vdom_id' => $vdom_id)
		);
	case 'vlan':
		return array
		(
			'name' => formatVLANAsPlainText (getVLANInfo ($sic['vlan_ck'])),
			'params' => array ('vlan_ck' => $sic['vlan_ck'])
		);
	case 'vst':
		$vst = spotEntity ('vst', $sic['vst_id']);
		return array
		(
			'name' => niftyString ("template '" . $vst['description'] . "'", 50, FALSE),
			'params' => array ('vst_id' => $sic['vst_id'])
		);
	case 'dqueue':
		global $dqtitle;
		return array
		(
			'name' => 'queue "' . $dqtitle[$sic['dqcode']] . '"',
			'params' => array ('qcode' => $sic['dqcode'])
		);
	default:
		break;
	}

	// default behaviour is throwing an exception
	throw new RackTablesError ('dynamic_title decoding error', RackTablesError::INTERNAL);
	} // end-of try block
	catch (RackTablesError $e)
	{
		return array
		(
			'name' => __FUNCTION__ . '() failure',
			'params' => array()
		);
	}
}

function renderIIFOIFCompat()
{
	global $nextorder;
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderIIFOIFCompat");
	$mod->setNamespace("portifcompat");
		
	//echo '<br><table class=cooltable align=center border=0 cellpadding=5 cellspacing=0>';
	//echo '<tr><th class=tdleft>inner interface</th><th></th><th class=tdleft>outer interface</th><th></th></tr>';
	$last_iif_id = 0;
	$order = 'even';
	$allRecordsOut = array();
	foreach (getPortInterfaceCompat() as $record)
	{
		if ($last_iif_id != $record['iif_id'])
		{
			$order = $nextorder[$order];
			$last_iif_id = $record['iif_id'];
		}
		$singleRecord = array('Order' => $order, 'IifName' => $record['iif_name'], 'IifId' => $record['iif_id'],
						'OifName' => $record['oif_name'], 'OifId' => $record['oif_id']);
		//echo "<tr class=row_${order}><td class=tdleft>${record['iif_name']}</td><td>${record['iif_id']}</td><td class=tdleft>${record['oif_name']}</td><td>${record['oif_id']}</td></tr>";
		$allRecordsOut[] = $singleRecord;
	}
	$mod->addOutput("AllRecords", $allRecordsOut);
		 
	//echo '</table>';
}

function renderIIFOIFCompatEditor()
{
	function printNewitemTR($parent, $placeholder)
	{
		$tplm = TemplateManager::getInstance();
		//$tplm->setTemplate("vanilla");
		
		$mod = $tplm->generateSubmodule($placeholder,"RenderIIFOIFCompatEditor_PrintNew", $parent);
		$mod->setNamespace("portifcompat");
		
		printSelect (getPortIIFOptions(), array ('name' => 'iif_id'), NULL, $mod, "iifOptions");
		printSelect (readChapter (CHAP_PORTTYPE), array ('name' => 'oif_id'), NULL, $mod, "chapter"); 
		//printOpFormIntro ('add');
		//echo '<tr><th class=tdleft>';
		//printImageHREF ('add', 'add pair', TRUE);
		//echo '</th><th class=tdleft>';
		//printSelect (getPortIIFOptions(), array ('name' => 'iif_id'));
		//echo '</th><th class=tdleft>';
		//printSelect (readChapter (CHAP_PORTTYPE), array ('name' => 'oif_id'));
		//echo '</th></tr></form>';
	}
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderIIFOIFCompatEditor");
	$mod->setNamespace("portifcompat");
	
	//startPortlet ('WDM standard by interface');
	$iif = getPortIIFOptions();
	global $nextorder, $wdm_packs;
	$order = 'odd';
	//echo '<table border=0 align=center cellspacing=0 cellpadding=5>';
	$allWDM_PacksOut = array();
	foreach ($wdm_packs as $codename => $packinfo)
	{
		$singlePack = array('PackInfo' => $packinfo['title']);
		//echo "<tr><th>&nbsp;</th><th colspan=2>${packinfo['title']}</th></tr>";
		$singlePack['IifCont'] = '';
		foreach ($packinfo['iif_ids'] as $iif_id)
		{
			$iif_id_mod = $tplm->generateModule("RenderIIFOIFCompatEditor_Iif_id");
			$iif_id_mod->setNamespace("portifcompat");
			
			$iif_id_mod->addOutput('order', $order);
			$iif_id_mod->addOutput('iif_iif_id', $iif[$iif_id]);
			$iif_id_mod->addOutput('codename', $codename);
			$iif_id_mod->addOutput('iif_id', $iif_id);

			//echo "<tr class=row_${order}><th class=tdleft>" . $iif[$iif_id] . '</th><td>';
			//echo getOpLink (array ('op' => 'addPack', 'standard' => $codename, 'iif_id' => $iif_id), '', 'add');
			//echo '</td><td>';
			//echo getOpLink (array ('op' => 'delPack', 'standard' => $codename, 'iif_id' => $iif_id), '', 'delete');
			//echo '</td></tr>';
			$singlePack['IifCont'] .= $iif_id_mod->run();
			$order = $nextorder[$order];
		}
		$allWDM_PacksOut[] = $singlePack;
	}
	$mod->addOutput("AllWDMPacks", $allWDM_PacksOut);
			 
	//echo '</table>';
	//finishPortlet();

	//startPortlet ('interface by interface');
	global $nextorder;
	$last_iif_id = 0;
	$order = 'even';
	//echo '<br><table class=cooltable align=center border=0 cellpadding=5 cellspacing=0>';
	//echo '<tr><th>&nbsp;</th><th class=tdleft>inner interface</th><th class=tdleft>outer interface</th></tr>';
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
	//	printNewitemTR();
		printNewitemTR( $mod, "AddNewTop");
	$allInterfacesOut = array();
	foreach (getPortInterfaceCompat() as $record)
	{
		if ($last_iif_id != $record['iif_id'])
		{
			$order = $nextorder[$order];
			$last_iif_id = $record['iif_id'];
		}
		$singleInterface = array('Order' => $order);
		//echo "<tr class=row_${order}><td>";
		$singleInterface['OpLink'] = getOpLink (array ('op' => 'del', 'iif_id' => $record['iif_id'], 'oif_id' => $record['oif_id']), '', 'delete', 'remove pair');
		//echo getOpLink (array ('op' => 'del', 'iif_id' => $record['iif_id'], 'oif_id' => $record['oif_id']), '', 'delete', 'remove pair');
		$singleInterface['IifName'] = $record['iif_name'];
		$singleInterface['OifName'] = $record['oif_name'];
		//echo "</td><td class=tdleft>${record['iif_name']}</td><td class=tdleft>${record['oif_name']}</td></tr>";
		$allInterfacesOut[] = $singleInterface;
	}
	$mod->addOutput("AllInterfaces", $allInterfacesOut);	 
	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
		printNewitemTR($mod, "AddNewBottom");
	//	printNewitemTR();
	//echo '</table>';
	//finishPortlet();
}

function render8021QOrderForm ($some_id)
{
	function printNewItemTR ()
	{
		$all_vswitches = getVLANSwitches();
		global $pageno;
		$hintcodes = array ('prev_vdid' => 'DEFAULT_VDOM_ID', 'prev_vstid' => 'DEFAULT_VST_ID', 'prev_objid' => NULL);
		$focus = array();
		foreach ($hintcodes as $hint_code => $option_name)
		if (array_key_exists ($hint_code, $_REQUEST))
		{
			assertUIntArg ($hint_code);
			$focus[$hint_code] = $_REQUEST[$hint_code];
		}
		elseif ($option_name != NULL)
			$focus[$hint_code] = getConfigVar ($option_name);
		else
			$focus[$hint_code] = NULL;
		
		$tplm = TemplateManager::getInstance();
		//$tplm->setTemplate("vanilla");
		
		$mod = $tplm->generateModule("Render8021QOrderForm_PrintNew");
		$mod->setNamespace("vlandomain");
		
		//printOpFormIntro ('add');
		//echo '<tr>';
		if ($pageno != 'object')
		{
			$mod->setOutput("isNoObject", true);	 
			//echo '<td>';
			// hide any object that is already in the table
			$options = array();
			foreach (getNarrowObjectList ('VLANSWITCH_LISTSRC') as $object_id => $object_dname)
				if (!in_array ($object_id, $all_vswitches))
				{
					$ctx = getContext();
					spreadContext (spotEntity ('object', $object_id));
					$decision = permitted (NULL, NULL, 'del');
					restoreContext ($ctx);
					if ($decision)
						$options[$object_id] = $object_dname;
				}
			$mod->addOutput("selected", getSelect ($options, array ('name' => 'object_id', 'tabindex' => 101, 'size' => getConfigVar ('MAXSELSIZE')), $focus['prev_objid'])); 
			//printSelect ($options, array ('name' => 'object_id', 'tabindex' => 101, 'size' => getConfigVar ('MAXSELSIZE')), $focus['prev_objid']);
			//echo '</td>';
		}
		if ($pageno != 'vlandomain'){
			$mod->setOutput("isNoVLANDomain", true);
			$mod->addOutput("getVLDSelect", getSelect (getVLANDomainOptions(), array ('name' => 'vdom_id', 'tabindex' => 102, 'size' => getConfigVar ('MAXSELSIZE')), $focus['prev_vdid']));	 
			//echo '<td>' . getSelect (getVLANDomainOptions(), array ('name' => 'vdom_id', 'tabindex' => 102, 'size' => getConfigVar ('MAXSELSIZE')), $focus['prev_vdid']) . '</td>';
		}
		if ($pageno != 'vst')
		{
			$mod->setOutput("isNoVST", true);
				 
			$options = array();
			foreach (listCells ('vst') as $nominee)
			{
				$ctx = getContext();
				spreadContext ($nominee);
				$decision = permitted (NULL, NULL, 'add');
				restoreContext ($ctx);
				if ($decision)
					$options[$nominee['id']] = niftyString ($nominee['description'], 30, FALSE);
			}
			$mod->addOutput("getVSTSelect", getSelect ($options, array ('name' => 'vst_id', 'tabindex' => 103, 'size' => getConfigVar ('MAXSELSIZE')), $focus['prev_vstid']));
			//echo '<td>' . getSelect ($options, array ('name' => 'vst_id', 'tabindex' => 103, 'size' => getConfigVar ('MAXSELSIZE')), $focus['prev_vstid']) . '</td>';
		}
		//echo '<td>' . getImageHREF ('Attach', 'set', TRUE, 104) . '</td></tr></form>';
		return $mod->run();
	}

	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","Render8021QOrderForm");
	$mod->setNamespace("vlandomain");
		
	global $pageno;
	$minuslines = array(); // indexed by object_id, which is unique
	switch ($pageno)
	{
	case 'object':
		if (NULL !== $vswitch = getVLANSwitchInfo ($some_id))
			$minuslines[$some_id] = array
			(
				'vdom_id' => $vswitch['domain_id'],
				'vst_id' => $vswitch['template_id'],
			);
		break;
	case 'vlandomain':
		$vlandomain = getVLANDomain ($some_id);
		foreach ($vlandomain['switchlist'] as $vswitch)
			$minuslines[$vswitch['object_id']] = array
			(
				'vdom_id' => $some_id,
				'vst_id' => $vswitch['template_id'],
			);
		break;
	case 'vst':
		$vst = spotEntity ('vst', $some_id);
		amplifyCell ($vst);
		foreach ($vst['switches'] as $vswitch)
			$minuslines[$vswitch['object_id']] = array
			(
				'vdom_id' => $vswitch['domain_id'],
				'vst_id' => $some_id,
			);
		break;
	default:
		throw new InvalidArgException ('pageno', $pageno, 'this function only works for a fixed set of values');
	}

	//echo "<br><table border=0 cellspacing=0 cellpadding=5 align=center>";
	//echo '<tr>';
	if ($pageno != 'object'){
		$mod->setOutput("isNoObject", true);
		//echo '<th>switch</th>';
	}
	if ($pageno != 'vlandomain'){
		$mod->setOutput("isNoVLANDomain", true);
		//echo '<th>domain</th>';
	}
	if ($pageno != 'vst'){
		$mod->setOutput("isNoVST", true);
		//echo '<th>template</th>';
	}
	//echo '<th>&nbsp;</th></tr>';
	// object_id is a UNIQUE in VLANSwitch table, so there is no sense
	// in a "plus" row on the form, when there is already a "minus" one
	if
	(
		getConfigVar ('ADDNEW_AT_TOP') == 'yes' and
		($pageno != 'object' or !count ($minuslines))
	)
		$mod->addOutput("AddNewTop", printNewItemTR());
	//	printNewItemTR();
	$vdomlist = getVLANDomainOptions();
	$vstlist = getVSTOptions();
	
	foreach ($minuslines as $item_object_id => $item)
	{
		$ctx = getContext();
		
		if ($pageno != 'object')
			spreadContext (spotEntity ('object', $item_object_id));
		if ($pageno != 'vst')
			spreadContext (spotEntity ('vst', $item['vst_id']));
		if (! permitted (NULL, NULL, 'del'))
			$cutblock = getImageHREF ('Cut gray', 'permission denied');
		else
		{
			$args = array
			(
				'op' => 'del',
				'object_id' => $item_object_id,
				# Extra args below are only necessary for redirect and permission
				# check to work, actual deletion uses object_id only.
				'vdom_id' => $item['vdom_id'],
				'vst_id' => $item['vst_id'],
			);
			$cutblock = getOpLink ($args, '', 'Cut', 'unbind');
		}
		restoreContext ($ctx);
		$singleMinusLine = array('cutblock' => $cutblock);
		//echo '<tr>';

		if ($pageno != 'object')
		{
			$singleMinusLine['isNoObject'] = true;
			$object = spotEntity ('object', $item_object_id);
			$singleMinusLine['objMkA'] = mkA ($object['dname'], 'object', $object['id']);
			//echo '<td>' . mkA ($object['dname'], 'object', $object['id']) . '</td>';
		}
		if ($pageno != 'vlandomain'){
			$singleMinusLine['isNoVLANDomain'] = true;
			$singleMinusLine['vlanDMkA'] = mkA ($vdomlist[$item['vdom_id']], 'vlandomain', $item['vdom_id']);
			//echo '<td>' . mkA ($vdomlist[$item['vdom_id']], 'vlandomain', $item['vdom_id']) . '</td>';
		}
		if ($pageno != 'vst'){
			$singleMinusLine['isNoVST'] = true;
			$singleMinusLine['vstMkA'] = mkA ($vstlist[$item['vst_id']], 'vst', $item['vst_id']);
			//echo '<td>' . mkA ($vstlist[$item['vst_id']], 'vst', $item['vst_id']) . '</td>';
		}
		
		$singleLine = $tplm->generateSubmodule('AllMinusLines', 'Render8021QOrderForm_MinusLine', $mod, false ,$singleMinusLine);
		$singleLine->setNamespace('vlandomain');
		//echo "<td>${cutblock}</td></tr>";
	}
	

	if
	(
		getConfigVar ('ADDNEW_AT_TOP') != 'yes' and
		($pageno != 'object' or !count ($minuslines))
	)
		$mod->addOutput("AddNewBottom", printNewItemTR());
	//	printNewItemTR();
	//echo '</table>';
}

function render8021QStatus ()
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","Render8021QStatus");
	$mod->setNamespace("8021q");
		

	global $dqtitle;
	//echo '<table border=0 class=objectview cellspacing=0 cellpadding=0>';
	//echo '<tr valign=top><td class=pcleft width="40%">';
	if (!count ($vdlist = getVLANDomainStats()))
		$mod->setOutput("areVLANDomains", true);		 
	//	startPortlet ('no VLAN domains');
	else
	{
		$mod->setOutput("countVDList", count ($vdlist));	 
	//	startPortlet ('VLAN domains (' . count ($vdlist) . ')');
	//	echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
	//	echo '<tr><th>description</th><th>VLANs</th><th>switches</th><th>';
	//	echo getImageHREF ('net') . '</th><th>ports</th></tr>';
		$stats = array();
		$columns = array ('vlanc', 'switchc', 'ipv4netc', 'portc');
		foreach ($columns as $cname)
			$stats[$cname] = 0;

		$allVDListOut = array();
		foreach ($vdlist as $vdom_id => $dominfo)
		{
			$singleDomInfo = array();
			foreach ($columns as $cname)
				$stats[$cname] += $dominfo[$cname];
			$singleDomInfo['mkA'] = mkA (niftyString ($dominfo['description']), 'vlandomain', $vdom_id);
		//	echo '<tr align=left><td>' . mkA (niftyString ($dominfo['description']), 'vlandomain', $vdom_id) . '</td>';
			$singleDomInfo['columnOut'] = ''; 
			foreach ($columns as $cname){
				$columnMod = $tplm->generateModule("StdTableCell", true, array('cont' => $dominfo[$cname]));
				$singleDomInfo['columnOut'] .= $columnMod->run(); 
			}
			$allVDListOut[] = $singleDomInfo;
		//		echo '<td>' . $dominfo[$cname] . '</td>';
		//	echo '</tr>';
		}
		$mod->setOutput("vdListOut", $allVDListOut);
			 
		if (count ($vdlist) > 1)
		{
			$mod->setOutput("isVDList", true);				 
			//echo '<tr align=left><td>total:</td>';
			$allColumsOut = array();
			foreach ($columns as $cname)
				$allColumsOut[] = array('cName' => $stats[$cname]);
			//	echo '<td>' . $stats[$cname] . '</td>';
			//echo '</tr>';
		}
		$mod->setOutput("TotalColumnOut", $allColumsOut);
	//	echo '</table>';
	}
//	finishPortlet();

//	echo '</td><td class=pcleft width="40%">';

	if (!count ($vstlist = listCells ('vst')))
		$mod->setOutput("areVSTCells", true);		 
	//	startPortlet ('no switch templates');
	else
	{	
		$mod->setOutput("countVSTList", count ($vstlist));	 
		//startPortlet ('switch templates (' . count ($vstlist) . ')');
		//echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
		//echo '<tr><th>description</th><th>rules</th><th>switches</th></tr>';
		$vstlistOut = array();
		foreach ($vstlist as $vst_id => $vst_info)
		{
			$singleVST_ID = array('mkA' =>  mkA (niftyString ($vst_info['description']), 'vst', $vst_id), 'areTags' => count ($vst_info['etags']));
			//echo '<tr align=left valign=top><td>';
			//echo mkA (niftyString ($vst_info['description']), 'vst', $vst_id);
			if (count ($vst_info['etags'])){
				$etagsMod = $tplm->generateModule('ETagsLine', true, array('cont' => serializeTags ($vst_info['etags'])));
				$singleVST_ID['serializedTags'] = $etagsMod->run();
			//	$singleVST_ID['serializedTags'] = serializeTags ($vst_info['etags']);
			}
			//	echo '<br><small>' . serializeTags ($vst_info['etags']) . '</small>';
			//echo '</td>';
			$singleVST_ID['rulec'] = $vst_info['rulec'];
			$singleVST_ID['switchc'] = $vst_info['switchc'];
			//echo "<td>${vst_info['rulec']}</td><td>${vst_info['switchc']}</td></tr>";
			$vstlistOut[] = $singleVST_ID;
		}
		$mod->setOutput("vstListOut", $vstlistOut);		 
		//echo '</table>';
	}
	//finishPortlet();

	//echo '</td><td class=pcright>';

	//startPortlet ('deploy queues');
	$total = 0;
	//echo '<table border=0 cellspacing=0 cellpadding=3 width="100%">';
	
	$allDeployQueuesOut = array();
	foreach (get8021QDeployQueues() as $qcode => $qitems)
	{
		$allDeployQueuesOut[] = array('mkA' => mkA ($dqtitle[$qcode], 'dqueue', $qcode), 'countItems' => count ($qitems));
	//	echo '<tr><th width="50%" class=tdright><' . mkA ($dqtitle[$qcode], 'dqueue', $qcode) . ':</th>';
	//	echo '<td class=tdleft>' . count ($qitems) . '</td></tr>';

		$total += count ($qitems);
	}
	$mod->setOutput("allDeployQueues", $allDeployQueuesOut);
		 
	//echo '<tr><th width="50%" class=tdright>Total:</th>';
	//echo '<td class=tdleft>' . $total . '</td></tr>';
	$mod->setOutput("total", $total);
		 
	//echo '</table>';
	//finishPortlet();
	//echo '</td></tr></table>';
}

function renderVLANDomainListEditor ()
{
	function printNewItemTR ()
	{
		$tplm = TemplateManager::getInstance();
		//$tplm->setTemplate("vanilla");
		
		$mod = $tplm->generateModule("RenderVLANDomainListEditor_printNewItemTR");
		$mod->setNamespace("8021q");
		return $mod->run();
		//printOpFormIntro ('add');
		//echo '<tr><td>';
		//printImageHREF ('create', 'create domain', TRUE, 104);
		//echo '</td><td>';
		//echo '<input type=text size=48 name=vdom_descr tabindex=102>';
		//echo '</td><td>';
		//printImageHREF ('create', 'create domain', TRUE, 103);
		//echo '</td></tr></form>';
	}
	
	//echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
	//echo '<tr><th>&nbsp;</th><th>description</th><th>&nbsp</th></tr>';
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderVLANDomainListEditor");
	$mod->setNamespace("8021q");
		
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes'){
		$mod->addOutput("isAddNew", true);
		$mod->addOutput("printNewItem", printNewItemTR());
	}
	//	printNewItemTR();
	$allDomainStatsOut = array();
	foreach (getVLANDomainStats() as $vdom_id => $dominfo)
	{
		$singleDomainStat = array('formIntro' => printOpFormIntro ('upd', array ('vdom_id' => $vdom_id)));
		//printOpFormIntro ('upd', array ('vdom_id' => $vdom_id));
		//echo '<tr><td>';
		if ($dominfo['switchc'] or $dominfo['vlanc'] > 1){
			$singleDomainStat['imageNoDestroy'] = printImageHREF ('nodestroy', 'domain used elsewhere');
		//	printImageHREF ('nodestroy', 'domain used elsewhere');
		}
		else{
			$singleDomainStat['linkDestroy'] = getOpLink (array ('op' => 'del', 'vdom_id' => $vdom_id), '', 'destroy', 'delete domain');
			//	echo getOpLink (array ('op' => 'del', 'vdom_id' => $vdom_id), '', 'destroy', 'delete domain');
		}

			//echo '</td><td><input name=vdom_descr type=text size=48 value="';
		$singleDomainStat['niftyStr'] = niftyString ($dominfo['description'], 0);
		//echo niftyString ($dominfo['description'], 0) . '">';
		//echo '</td><td>';
		$singleDomainStat['imageUpdate'] = printImageHREF ('save', 'update description', TRUE);
		//printImageHREF ('save', 'update description', TRUE);
		//echo '</td></tr></form>';
		$allDomainStatsOut[] = $singleDomainStat;
	}

	$mod->addOutput("allDomainStats", $allDomainStatsOut);

	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes'){
		$mod->addOutput("isAddNew", true);
		$mod->addOutput("printNewItem", printNewItemTR());
	}
	
		 
	//	printNewItemTR();
	//echo '</table>';
}

function renderVLANDomain ($vdom_id)
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderVLANDomain");
	$mod->setNamespace("vlandomain");
		
	global $nextorder;
	$mydomain = getVLANDomain ($vdom_id);
	$mod->addOutput("niftyStr", niftyString ($mydomain['description']));
		 
	//echo '<table border=0 class=objectview cellspacing=0 cellpadding=0>';
	//echo '<tr><td colspan=2 align=center><h1>' . niftyString ($mydomain['description']);
	//echo '</h1></td></tr>';
	//echo "<tr><td class=pcleft width='50%'>";
	if (!count ($mydomain['switchlist']))
		$mod->addOutput("areDomains", false);	 
		//startPortlet ('no orders');
	else
	{
		//startPortlet ('orders (' . count ($mydomain['switchlist']) . ')');
		$mod->addOutput("countDomains", count ($mydomain['switchlist']));	 
		//echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
		//echo '<tr><th>switch</th><th>template</th><th>status</th></tr>';
		$order = 'odd';
		$vstlist = getVSTOptions();
		global $dqtitle;
		$allDomainSwitchOut = array();
		foreach ($mydomain['switchlist'] as $switchinfo)
		{
			$singleDomain = array('order' => $order, 'renderedCell' => renderCell (spotEntity ('object', $switchinfo['object_id'])) );
			//echo "<tr class=row_${order}><td>";
			//renderCell (spotEntity ('object', $switchinfo['object_id']));
			//echo '</td><td class=tdleft>';
			$singleDomain['vstlist'] = $vstlist[$switchinfo['template_id']];
			//echo $vstlist[$switchinfo['template_id']];
			//echo '</td><td>';
			//$qcode = detectVLANSwitchQueue (getVLANSwitchInfo ($switchinfo['object_id']));
			//printImageHREF ("DQUEUE ${qcode}", $dqtitle[$qcode]);
			$singleDomain['imageHREF'] = printImageHREF ("DQUEUE ${qcode}", $dqtitle[$qcode]);
			//echo '</td></tr>';
			$order = $nextorder[$order];
			$allDomainSwitchOut[] = $singleDomain;
		}
		$mod->addOutput("allDomainSwitch", $allDomainSwitchOut);	 
		//echo '</table>';
	}
	//finishPortlet();

	//echo '</td><td class=pcright>';

	if (!count ($myvlans = getDomainVLANs ($vdom_id)))
		$mod->addOutput("areVLANDomains", false);	 
	//	startPortlet ('no VLANs');
	else
	{
		//startPortlet ('VLANs (' . count ($myvlans) . ')');
		$mod->addOutput("countMyVLANs", count ($myvlans));	 
		$order = 'odd';
		global $vtdecoder;
		//echo '<table class=cooltable align=center border=0 cellpadding=5 cellspacing=0>';
		//echo '<tr><th>VLAN ID</th><th>propagation</th><th>';
		//printImageHREF ('net', 'IPv4 networks linked');
		//echo '</th><th>ports</th><th>description</th></tr>';
		$allMyVLANsOut = array();
		foreach ($myvlans as $vlan_id => $vlan_info)
		{
			$singleMyVLANs = array('order' => $order, 'mkA' => mkA ($vlan_id, 'vlan', "${vdom_id}-${vlan_id}"));
			//echo "<tr class=row_${order}>";
			//echo '<td class=tdright>' . mkA ($vlan_id, 'vlan', "${vdom_id}-${vlan_id}") . '</td>';
			$singleMyVLANs['vtdecoder'] = $vtdecoder[$vlan_info['vlan_type']];
			//echo '<td>' . $vtdecoder[$vlan_info['vlan_type']] . '</td>';
			$singleMyVLANs['infoNetc']  = ($vlan_info['netc'] ? $vlan_info['netc'] : '&nbsp;');
			$singleMyVLANs['infoPortc'] = ($vlan_info['portc'] ? $vlan_info['portc'] : '&nbsp;');
			//echo '<td class=tdright>' . ($vlan_info['netc'] ? $vlan_info['netc'] : '&nbsp;') . '</td>';
			//echo '<td class=tdright>' . ($vlan_info['portc'] ? $vlan_info['portc'] : '&nbsp;') . '</td>';
			$singleMyVLANs['infoDescr'] = $vlan_info['vlan_descr'];
			//echo "<td class=tdleft>${vlan_info['vlan_descr']}</td></tr>";
			$allMyVLANsOut[] = $singleMyVLANs;
			$order = $nextorder[$order];
		}
		$mod->addOutput("allMyVLANs", $allMyVLANsOut); 
		//echo '</table>';
	}
	//finishPortlet();
	//echo '</td></tr></table>';
}

function renderVLANDomainVLANList ($vdom_id)
{
	function printNewItemTR ($parent, $placeholder)
	{
		$tplm = TemplateManager::getInstance();
		//$tplm->setTemplate("vanilla");
			
		global $vtoptions;

		$mod = $tplm->generateSubmodule($placeholder, "RenderVLANDomainVLANList_printNew", $parent, false, array('Vtoptions' => $vtoptions,
						"PrintSel" => printSelect ($vtoptions, array ('name' => 'vlan_type', 'tabindex' => 102), 'ondemand')));
		$mod->setNamespace("vlandomain");
/**		printOpFormIntro ('add');
		echo '<tr><td>';
		printImageHREF ('create', 'add VLAN', TRUE, 110);
		echo '</td><td>';
		echo '<input type=text name=vlan_id size=4 tabindex=101>';
		echo '</td><td>';
		printSelect ($vtoptions, array ('name' => 'vlan_type', 'tabindex' => 102), 'ondemand');
		echo '</td><td>';
		echo '<input type=text size=48 name=vlan_descr tabindex=103>';
		echo '</td><td>';
		printImageHREF ('create', 'add VLAN', TRUE, 110);
		echo '</td></tr></form>'; */
		
	}
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderVLANDomainVLANList");
	$mod->setNamespace("vlandomain");
	
	//echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
	//echo '<tr><th>&nbsp;</th><th>ID</th><th>propagation</th><th>description</th><th>&nbsp;</th></tr>';
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
		printNewItemTR($mod, "AddNewTop");		 
	//	printNewItemTR();
	
	global $vtoptions;
	$allDomainVLANsOut = array();
	foreach (getDomainVLANs ($vdom_id) as $vlan_id => $vlan_info)
	{
		$singleDomainVLAN = array('opIntro' => printOpFormIntro ('upd', array ('vlan_id' => $vlan_id)));
		//printOpFormIntro ('upd', array ('vlan_id' => $vlan_id));
		//echo '<tr><td>';
		if ($vlan_info['portc'] or $vlan_id == VLAN_DFL_ID)
			$singleDomainVLAN['portc'] = printImageHREF ('nodestroy', $vlan_info['portc'] . ' ports configured');
		//	printImageHREF ('nodestroy', $vlan_info['portc'] . ' ports configured');
		else
			$singleDomainVLAN['portc'] = getOpLink (array ('op' => 'del', 'vlan_id' => $vlan_id), '', 'destroy', 'delete VLAN');
		//	echo getOpLink (array ('op' => 'del', 'vlan_id' => $vlan_id), '', 'destroy', 'delete VLAN');
		$singleDomainVLAN['vlan_id'] = $vlan_id;
		//echo '</td><td class=tdright><tt>' . $vlan_id . '</tt></td><td>';
		//printSelect ($vtoptions, array ('name' => 'vlan_type'), $vlan_info['vlan_type']);
		$singleDomainVLAN['printSel'] = printSelect ($vtoptions, array ('name' => 'vlan_type'), $vlan_info['vlan_type']);
		//echo '</td><td>';
		$singleDomainVLAN['htmlSpecialChr'] = htmlspecialchars ($vlan_info['vlan_descr']);
		//echo '<input name=vlan_descr type=text size=48 value="' . htmlspecialchars ($vlan_info['vlan_descr']) . '">';
		//echo '</td><td>';
		//printImageHREF ('save', 'update description', TRUE);
		//echo '</td></tr></form>';
		$singleDomainVLAN['saveImg'] = printImageHREF ('save', 'update description', TRUE);
		$allDomainVLANsOut[] = $singleDomainVLAN;
	}
	$mod->addOutput("allDomainVLANs", $allDomainVLANsOut);
		 
	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
		printNewItemTR($mod, "AddNewBottom");
//		printNewItemTR();
//	echo '</table>';
}

function get8021QPortTrClass ($port, $domain_vlans, $desired_mode = NULL)
{
	if (isset ($desired_mode) && $desired_mode != $port['mode'])
		return 'trwarning';
	if (count (array_diff ($port['allowed'], array_keys ($domain_vlans))))
		return 'trwarning';
	return 'trbusy';
}

// Show a list of 802.1Q-eligible ports in any way, but when one of
// them is selected as current, also display a form for its setup.
function renderObject8021QPorts ($object_id)
{
	global $pageno, $tabno, $sic;
	$vswitch = getVLANSwitchInfo ($object_id);
	$vdom = getVLANDomain ($vswitch['domain_id']);
	$req_port_name = array_key_exists ('port_name', $sic) ? $sic['port_name'] : '';
	$desired_config = apply8021QOrder ($vswitch, getStored8021QConfig ($object_id, 'desired'));
	$cached_config = getStored8021QConfig ($object_id, 'cached');
	$desired_config = sortPortList	($desired_config);
	$uplinks = filter8021QChangeRequests ($vdom['vlanlist'], $desired_config, produceUplinkPorts ($vdom['vlanlist'], $desired_config, $vswitch['object_id']));
	
	$tplm = TemplateManager::getInstance();
	$mod = $tplm->generateSubmodule('Payload', 'RenderObject8021QPorts');

	$mod->setNamespace('object');

//	echo '<table border=0 width="100%"><tr valign=top><td class=tdleft width="50%">';
	// port list
//	echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
//	echo '<tr><th>port</th><th>interface</th><th>link</th><th width="25%">last&nbsp;saved&nbsp;config</th>';
//	echo $req_port_name == '' ? '<th width="25%">new&nbsp;config</th></tr>' : '<th>(zooming)</th></tr>';
	$req_port_name == '' ? '<th width="25%">new&nbsp;config</th></tr>' : '<th>(zooming)</th></tr>';
	
	$mod->addOutput("Vswitch", $vswitch['mutex_rev']);
	
	if ($req_port_name != ''){
		$mod->addOutput('IsReqPortName', true);
	}
			 
	//	printOpFormIntro ('save8021QConfig', array ('mutex_rev' => $vswitch['mutex_rev'], 'form_mode' => 'save'));
	$object = spotEntity ('object', $object_id);
	amplifyCell ($object);
	$sockets = array();
	if (isset ($_REQUEST['hl_port_id']))
	{
		assertUIntArg ('hl_port_id');
		$hl_port_id = intval ($_REQUEST['hl_port_id']);
		$hl_port_name = NULL;
		addAutoScrollScript ("port-$hl_port_id", $mod, 'JSScripts');
	}
	foreach ($object['ports'] as $port)
		if (mb_strlen ($port['name']) and array_key_exists ($port['name'], $desired_config))
		{
			if (isset ($hl_port_id) and $hl_port_id == $port['id'])
				$hl_port_name = $port['name'];
			$socket = array ('interface' => formatPortIIFOIF ($port));
			if ($port['remote_object_id'])
				$socket['link'] = formatLoggedSpan ($port['last_log'], formatLinkedPort ($port));
			elseif (strlen ($port['reservation_comment']))
				$socket['link'] = formatLoggedSpan ($port['last_truelog'], 'Rsv:', 'strong underline') . ' ' .
				formatLoggedSpan ($port['last_log'], $port['reservation_comment']);
			else
				$socket['link'] = '&nbsp;';
			$sockets[$port['name']][] = $socket;
		}
	unset ($object);
	$nports = 0; // count only access ports
	switchportInfoJS ($object_id, $mod, 'JSScripts'); // load JS code to make portnames interactive

	foreach ($desired_config as $port_name => $port)
	{

		$text_left = formatVLANPackDiff ($cached_config[$port_name], $port);
		// decide on row class
		switch ($port['vst_role'])
		{
		case 'none':
			if ($port['mode'] == 'none')
				continue 2; // early miss
			$text_right = '&nbsp;';
			$trclass = 'trerror'; // stuck ghost port
			break;
		case 'downlink':
			$text_right = '(downlink)';
			$trclass = get8021QPortTrClass ($port, $vdom['vlanlist'], 'trunk');
			break;
		case 'uplink':
			$text_right = '(uplink)';
			$trclass = same8021QConfigs ($port, $uplinks[$port_name]) ? 'trbusy' : 'trwarning';
			break;
		case 'trunk':
			$text_right = getTrunkPortCursorCode ($object_id, $port_name, $req_port_name);
			$trclass = get8021QPortTrClass ($port, $vdom['vlanlist'], 'trunk');
			break;
		case 'access':
			$text_right = getAccessPortControlCode ($req_port_name, $vdom, $port_name, $port, $nports);
			$trclass = get8021QPortTrClass ($port, $vdom['vlanlist'], 'access');
			break;
		case 'anymode':
			$text_right = getAccessPortControlCode ($req_port_name, $vdom, $port_name, $port, $nports);
			$text_right .= '&nbsp;';
			$text_right .= getTrunkPortCursorCode ($object_id, $port_name, $req_port_name);
			$trclass = get8021QPortTrClass ($port, $vdom['vlanlist'], NULL);
			break;
		default:
			throw new InvalidArgException ('vst_role', $port['vst_role']);
		}

		$rowMod = $tplm->generateSubmodule('PortRows', 'RenderObject8021QPorts_Row', $mod);
		$rowMod->setNamespace('object');
		$rowMod->addOutput('TextRight', $text_right);
		$rowMod->addOutput('TextLeft', $text_left);
		$rowMod->addOutput('TextClass', $trclass);
		$rowMod->addOutput('PortName', $port_name);


		if (!checkPortRole ($vswitch, $port_name, $port))
			$rowMod->addOutput('HasErrors', true);
				 
		//	$trclass = 'trerror';

		if (!array_key_exists ($port_name, $sockets))
		{	
			$rowMod->addOutput('NoSocketColumns', true);
			//$socket_columns = '<td>&nbsp;</td><td>&nbsp;</td>';
			//$td_extra = '';
		}
		else
		{
			$td_extra = count ($sockets[$port_name]) > 1 ? (' rowspan=' . count ($sockets[$port_name])) : '';
			$rowMod->addOutput("TdExtra", $td_extra);
				 
			//$socket_columns = '';
			foreach ($sockets[$port_name][0] as $tmp)
				$tplm->generateSubmodule('SocketColumns', 'StdTableCell', $rowMod, true, array('cont' => $tmp));
				//$socket_columns .= '<td>' . $tmp . '</td>';
		}
		//$anchor = '';
		//$tdclass = '';
		if (isset ($hl_port_name) and $hl_port_name == $port_name)
		{
			$rowMod->addOutput('HasPortName', true);
		//	$tdclass .= 'class="border_highlight"';
		//	$anchor = "name='port-$hl_port_id'";
			$rowMod->addOutput('PortId', $hl_port_id);
		}
		
		//echo "<tr class='${trclass}' valign=top><td${td_extra} ${tdclass} NOWRAP><a class='interactive-portname port-menu nolink' $anchor>${port_name}</a></td>" . $socket_columns;
		//echo "<td${td_extra}>${text_left}</td><td class=tdright nowrap${td_extra}>${text_right}</td></tr>";
		if (!array_key_exists ($port_name, $sockets))
			continue;
		$first_socket = TRUE;
		foreach ($sockets[$port_name] as $socket)
			if ($first_socket)
				$first_socket = FALSE;
			else
			{	
				$socketRowMod = $tplm->generateSubmodule('SocketRows', 'StdTableRowClass', $rowMod, true, array('Class' => $trclass));
				//echo "<tr class=${trclass} valign=top>";
				foreach ($socket as $tmp)
					$tplm->generateSubmodule('Cont', 'StdTableCell', $socketRowMod, true, array('cont' => $tmp));
				//	echo '<td>' . $tmp . '</td>';
				//echo '</tr>';
			}
	}
	//echo '<tr><td colspan=5 class=tdcenter><ul class="btns-8021q-sync">';
	if ($req_port_name == '' and $nports)
	{	
		$mod->addOutput("IsToSave", true);
		$mod->addOutput("Nports", $nports);
			 	 	 
		//echo "<input type=hidden name=nports value=${nports}>";
		//echo '<li>' . getImageHREF ('SAVE', 'save configuration', TRUE, 100) . '</li>';
	}
	//echo '</form>';
	if (permitted (NULL, NULL, NULL, array (array ('tag' => '$op_recalc8021Q'))))
		$mod->addOutput("RecalcPerm", true);
			 
	//	echo '<li>' . getOpLink (array ('op' => 'exec8021QRecalc'), '', 'RECALC', 'Recalculate uplinks and downlinks') . '</li>';
	//echo '</ul></td></tr></table>';
	//if ($req_port_name == '');
	//	echo '</form>';
	//echo '</td>';
	// configuration of currently selected port, if any
	if (!array_key_exists ($req_port_name, $desired_config))
	{
		$mod->addOutput('HasPortOpt', true);
			 
		//echo '<td>';
		$port_options = array();
		foreach ($desired_config as $pn => $portinfo)
			if (editable8021QPort ($portinfo))
				$port_options[$pn] = same8021QConfigs ($desired_config[$pn], $cached_config[$pn]) ?
					$pn : "${pn} (*)";
		if (count ($port_options) < 2)
			$mod->addOutput('SinglePort', true);
		//	echo '&nbsp;';
		else
		{
			$mod->addOutput("PortOpt", $port_options);
			$mod->addOutput("MaxSelSize", getConfigVar ('MAXSELSIZE'));

			/*startPortlet ('port duplicator');
			echo '<table border=0 align=center>';
			printOpFormIntro ('save8021QConfig', array ('mutex_rev' => $vswitch['mutex_rev'], 'form_mode' => 'duplicate'));
			echo '<tr><td>' . getSelect ($port_options, array ('name' => 'from_port')) . '</td></tr>';
			echo '<tr><td>&darr; &darr; &darr;</td></tr>';
			echo '<tr><td>' . getSelect ($port_options, array ('name' => 'to_ports[]', 'size' => getConfigVar ('MAXSELSIZE'), 'multiple' => 1)) . '</td></tr>';
			echo '<tr><td>' . getImageHREF ('COPY', 'duplicate', TRUE) . '</td></tr>';
			echo '</form></table>';
			finishPortlet();*/
		}
		//echo '</td>';
	}
	else
		renderTrunkPortControls
		(
			$vswitch,
			$vdom,
			$req_port_name,
			$desired_config[$req_port_name],
			$mod,
			'TrunkPortlets'
		);
//	echo '</tr></table>';
}

// Return the text to place into control column of VLAN ports list
// and modify $nports, when this text was a series of INPUTs.
function getAccessPortControlCode ($req_port_name, $vdom, $port_name, $port, &$nports)
{
	static $permissions_cache = array();
	// don't render a form for access ports, when a trunk port is zoomed
	if ($req_port_name != '')
		return '&nbsp;';
	if
	(
		array_key_exists ($port['native'], $vdom['vlanlist']) and
		$vdom['vlanlist'][$port['native']]['vlan_type'] == 'alien'
	)
		return formatVLANAsLabel ($vdom['vlanlist'][$port['native']]);

	static $vlanpermissions = array();
	if (!array_key_exists ($port['native'], $vlanpermissions))
	{
		$vlanpermissions[$port['native']] = array();
		foreach (array_keys ($vdom['vlanlist']) as $to)
		{
			$from_key = 'from_' . $port['native'];
			$to_key = 'to_' . $to;
			if (isset ($permissions_cache[$from_key]))
				$allowed_from = $permissions_cache[$from_key];
			else
				$allowed_from = $permissions_cache[$from_key] = permitted (NULL, NULL, 'save8021QConfig', array (array ('tag' => '$fromvlan_' . $port['native']), array ('tag' => '$vlan_' . $port['native'])));
			if ($allowed_from)
			{
				if (isset ($permissions_cache[$to_key]))
					$allowed_to = $permissions_cache[$to_key];
				else
					$allowed_to = $permissions_cache[$to_key] = permitted (NULL, NULL, 'save8021QConfig', array (array ('tag' => '$tovlan_' . $to), array ('tag' => '$vlan_' . $to)));

				if ($allowed_to)
					$vlanpermissions[$port['native']][] = $to;
			}
		}
	}
	$ret = "<input type=hidden name=pn_${nports} value=${port_name}>";
	$ret .= "<input type=hidden name=pm_${nports} value=access>";
	$options = array();
	// Offer only options that are listed in domain and fit into VST.
	// Never offer immune VLANs regardless of VST filter for this port.
	// Also exclude current VLAN from the options, unless current port
	// mode is "trunk" (in this case it should be possible to set VST-
	// approved mode without changing native VLAN ID).
	foreach ($vdom['vlanlist'] as $vlan_id => $vlan_info)
		if
		(
			($vlan_id != $port['native'] or $port['mode'] == 'trunk') and
			$vlan_info['vlan_type'] != 'alien' and
			in_array ($vlan_id, $vlanpermissions[$port['native']]) and
			matchVLANFilter ($vlan_id, $port['wrt_vlans'])
		)
			$options[$vlan_id] = formatVLANAsOption ($vlan_info);
	ksort ($options);
	$options['same'] = '-- no change --';
	$ret .= getSelect ($options, array ('name' => "pnv_${nports}"), 'same');
	$nports++;
	return $ret;
}

function getTrunkPortCursorCode ($object_id, $port_name, $req_port_name)
{
	global $pageno, $tabno;
	$linkparams = array
	(
		'page' => $pageno,
		'tab' => $tabno,
		'object_id' => $object_id,
	);
	if ($port_name == $req_port_name)
	{
		$imagename = 'Zooming';
		$imagetext = 'zoom out';
	}
	else
	{
		$imagename = 'Zoom';
		$imagetext = 'zoom in';
		$linkparams['port_name'] = $port_name;
	}
	return "<a href='" . makeHref ($linkparams) . "'>"  .
		getImageHREF ($imagename, $imagetext) . '</a>';
}

function renderTrunkPortControls ($vswitch, $vdom, $port_name, $vlanport, $parent = null, $placeholder = 'Payload')
{
	$tplm = TemplateManager::getInstance();
	
	if($parent==null)	
		$mod = $tplm->generateSubmodule($placeholder,'RenderTrunkPortControls');
	else
		$mod = $tplm->generateSubmodule($placeholder, 'RenderTrunkPortControls', $parent);
	
	$mod->setNamespace('object');
	
	if($parent==null)
		return $mod->run();
	if (!count ($vdom['vlanlist']))
	{
		$mod->addOutput('NoList', true);
			 
		//echo '<td colspan=2>(configured VLAN domain is empty)</td>';
		return;
	}
	$formextra = array
	(
		'mutex_rev' => $vswitch['mutex_rev'],
		'nports' => 1,
		'pn_0' => $port_name,
		'pm_0' => 'trunk',
		'form_mode' => 'save',
	);
	$mod->addOutput('Save8021QConfig', printOpFormIntro ('save8021QConfig', $formextra));
		 
/*	printOpFormIntro ('save8021QConfig', $formextra);
	echo '<td width="35%">';
	echo '<table border=0 cellspacing=0 cellpadding=3 align=center>';
	echo '<tr><th colspan=2>allowed</th></tr>';*/
	// Present all VLANs of the domain and all currently configured VLANs
	// (regardless if these sets intersect or not).
	$allowed_options = array();
	foreach ($vdom['vlanlist'] as $vlan_id => $vlan_info)
		$allowed_options[$vlan_id] = array
		(
			'vlan_type' => $vlan_info['vlan_type'],
			'text' => formatVLANAsLabel ($vlan_info),
		);
	foreach ($vlanport['allowed'] as $vlan_id)
		if (!array_key_exists ($vlan_id, $allowed_options))
			$allowed_options[$vlan_id] = array
			(
				'vlan_type' => 'none',
				'text' => "unlisted VLAN ${vlan_id}",
			);
	ksort ($allowed_options);
	$allAllowedOptionsOut = array();
	foreach ($allowed_options as $vlan_id => $option)
	{
		$selected = '';
		$class = 'tagbox';
		if (in_array ($vlan_id, $vlanport['allowed']))
		{
			$selected = ' checked';
			$class .= ' selected';
		}
		// A real relation to an alien VLANs is shown for a
		// particular port, but it cannot be changed by user.
		if ($option['vlan_type'] == 'alien')
			$selected .= ' disabled';
		//echo "<tr><td nowrap colspan=2 class='${class}'>";
		//echo "<label><input type=checkbox name='pav_0[]' value='${vlan_id}'${selected}> ";
		//echo $option['text'] . "</label></td></tr>";
		$allAllowedOptionsOut[] = array('Class' => $class, 
			'Vlan_Id' => $vlan_id, 
			'Selected' => $selected,
			'OptionTxt' => $option['text']);
	}
	$mod->setOutput('AllowedOptions', $allAllowedOptionsOut);
		 
	/*echo '</table>';
	echo '</td><td width="35%">';
	// rightmost table also contains form buttons
	echo '<table border=0 cellspacing=0 cellpadding=3 align=center>';
	echo '<tr><th colspan=2>native</th></tr>';*/
	//if (!count ($vlanport['allowed']))
	//	echo '<tr><td colspan=2>(no allowed VLANs for this port)</td></tr>';
	//else
	if (count ($vlanport['allowed']))
	{	
		$mod->addOutput('Vlan_Port_Allowed', true);
			 
		$native_options = array (0 => array ('vlan_type' => 'none', 'text' => '-- NONE --'));
		foreach ($vlanport['allowed'] as $vlan_id)
			$native_options[$vlan_id] = array_key_exists ($vlan_id, $vdom['vlanlist']) ? array
				(
					'vlan_type' => $vdom['vlanlist'][$vlan_id]['vlan_type'],
					'text' => formatVLANAsLabel ($vdom['vlanlist'][$vlan_id]),
				) : array
				(
					'vlan_type' => 'none',
					'text' => "unlisted VLAN ${vlan_id}",
				);
		
		$allNativeOptOut = array();
		foreach ($native_options as $vlan_id => $option)
		{
			$selected = '';
			$class = 'tagbox';
			if ($vlan_id == $vlanport['native'])
			{
				$selected = ' checked';
				$class .= ' selected';
			}
			// When one or more alien VLANs are present on port's list of allowed VLANs,
			// they are shown among radio options, but disabled, so that the user cannot
			// break traffic of these VLANs. In addition to that, when port's native VLAN
			// is set to one of these alien VLANs, the whole group of radio buttons is
			// disabled. These measures make it harder for the system to break a VLAN
			// that is explicitly protected from it.
			if
			(
				$native_options[$vlanport['native']]['vlan_type'] == 'alien' or
				$option['vlan_type'] == 'alien'
			)
				$selected .= ' disabled';
			//echo "<tr><td nowrap colspan=2 class='${class}'>";
			//echo "<label><input type=radio name='pnv_0' value='${vlan_id}'${selected}> ";
			//echo $option['text'] . "</label></td></tr>";
			$allNativeOptOut[] = array('Class' => $class, 
				'Vlan_Id' => $vlan_id, 
				'Selected' => $selected,
				'OptionTxt' => $option['text']);
		}
		$mod->addOutput('NativeOpts', $allNativeOptOut);		 
	}
	/*echo '<tr><td class=tdleft>';
	printImageHREF ('SAVE', 'Save changes', TRUE);
	echo '</form></td><td class=tdright>';*/
	/*if (!count ($vlanport['allowed']))

		printImageHREF ('CLEAR gray');
	else
	{
		printOpFormIntro ('save8021QConfig', $formextra);
		printImageHREF ('CLEAR', 'Unassign all VLANs', TRUE);
		echo '</form>';
	}
	echo '</td></tr></table>';
	echo '</td>';*/
}

function renderVLANInfo ($vlan_ck)
{
	global $vtoptions, $nextorder;
	$vlan = getVLANInfo ($vlan_ck);

	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderVLANInfo");
	$mod->setNamespace("vlan");
		
	//echo '<table border=0 class=objectview cellspacing=0 cellpadding=0>';
	//echo '<tr><td colspan=2 align=center><h1>' . formatVLANAsRichText ($vlan) . '</h1></td></tr>';
	$mod->addOutput("formatVlanTxt", formatVLANAsRichText ($vlan));
	//echo "<tr><td class=pcleft width='50%'>";
	//startPortlet ('summary');
	//echo "<table border=0 cellspacing=0 cellpadding=3 width='100%'>";
	//echo "<tr><th width='50%' class=tdright>Domain:</th><td class=tdleft>";
	
	//echo niftyString ($vlan['domain_descr'], 0) . '</td></tr>';
	$mod->addOutput("niftyStr_domain_descr", niftyString ($vlan['domain_descr'], 0));
	$mod->addOutput("vlan_id", $vlan['vlan_id'] );	 
	//echo "<tr><th width='50%' class=tdright>VLAN ID:</th><td class=tdleft>${vlan['vlan_id']}</td></tr>";
	if (strlen ($vlan['vlan_descr'])){
		$mod->addOutput("isVlan_Descr", true);
		$mod->addOutput("niftyStr_vlan_descr", niftyString ($vlan['vlan_descr'], 0));
		//echo "<tr><th width='50%' class=tdright>Description:</th><td class=tdleft>" .
		//	niftyString ($vlan['vlan_descr'], 0) . "</td></tr>";
	}
	$mod->addOutput("vtoptions", $vtoptions[$vlan['vlan_prop']]);
	//echo "<tr><th width='50%' class=tdright>Propagation:</th><td class=tdleft>" . $vtoptions[$vlan['vlan_prop']] . "</td></tr>";
	$others = getSearchResultByField
	(
		'VLANDescription',
		array ('domain_id'),
		'vlan_id',
		$vlan['vlan_id'],
		'domain_id',
		1
	);
	$allOthersOut = array();
	foreach ($others as $other)
		if ($other['domain_id'] != $vlan['domain_id'])
			$allOthersOut[] = array('vlanHyperlinks' => formatVLANAsHyperlink (getVLANInfo ("${other['domain_id']}-${vlan['vlan_id']}")) );
		//	echo '<tr><th class=tdright>Counterpart:</th><td class=tdleft>' .
		//		formatVLANAsHyperlink (getVLANInfo ("${other['domain_id']}-${vlan['vlan_id']}")) .
		//		'</td></tr>';
	$mod->addOutput("allOthers", $allOthersOut);	 
	//echo '</table>';
	//finishPortlet();

	if (0 == count ($vlan['ipv4nets']) + count ($vlan['ipv6nets'])){
		$mod->addOutput("noNetworks", true);
	//	startPortlet ('no networks');
	}
	else
	{
		$mod->addOutput("overallCount", (count ($vlan['ipv4nets']) + count ($vlan['ipv6nets'])));
		//startPortlet ('networks (' . (count ($vlan['ipv4nets']) + count ($vlan['ipv6nets'])) . ')');
		$order = 'odd';
		//echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
		//echo '<tr><th>';
		//printImageHREF ('net');
		//echo '</th><th>';
		//printImageHREF ('text');
		//echo '</th></tr>';
		$allNetsOut = array();
		foreach (array ('ipv4net', 'ipv6net') as $nettype)
		foreach ($vlan[$nettype . 's'] as $netid)
		{
			$net = spotEntity ($nettype, $netid);
			#echo "<tr class=row_${order}><td>";
			$allNetsOut[] = array('renderedCell' => renderCell ($net),
							'niftyStr' => (mb_strlen ($net['comment']) ? niftyString ($net['comment']) : '&nbsp;'));
			//echo '<tr><td>';
			//renderCell ($net);
			//echo '</td><td>' . (mb_strlen ($net['comment']) ? niftyString ($net['comment']) : '&nbsp;');
			//echo '</td></tr>';
			
			$order = $nextorder[$order];
		}
		$mod->addOutput("allNets", $allNetsOut);
		//echo '</table>';
	}
	//finishPortlet();

	$confports = getVLANConfiguredPorts ($vlan_ck);

	// get non-switch device list
	$foreign_devices = array();
	foreach ($confports as $switch_id => $portlist)
	{
		$object = spotEntity ('object', $switch_id);
		foreach ($portlist as $port_name)
			if ($portinfo = getPortinfoByName ($object, $port_name))
				if ($portinfo['linked'] && ! isset ($confports[$portinfo['remote_object_id']]))
					$foreign_devices[$portinfo['remote_object_id']][] = $portinfo;
	}
	if (! empty ($foreign_devices))
	{
		$mod->addOutput("nonSwitchDev", true);
			 
		//startPortlet ("Non-switch devices");
		//echo "<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>";
		//echo '<tr><th>device</th><th>ports</th></tr>';
		$order = 'odd';
		$allForgDevOut = array();
		foreach ($foreign_devices as $cell_id => $ports)
		{
			
			//echo "<tr class=row_${order} valign=top><td>";
			$cell = spotEntity ('object', $cell_id);
			//renderCell ($cell);
			$singleDev = array('order' => $order, 'rendCell' => renderCell ($cell), 'ports' => '');
			//echo "</td><td><ul>";
			foreach ($ports as $portinfo){
			//	echo "<li>" . formatPortLink ($portinfo['remote_object_id'], NULL, $portinfo['remote_id'], $portinfo['remote_name']) . ' &mdash; ' . formatPort ($portinfo) . "</li>";
				$singPort = $tplm->generateModule("StdListElem", true, array('cont' =>
					formatPortLink ($portinfo['remote_object_id'], NULL, $portinfo['remote_id'], $portinfo['remote_name']) . ' &mdash; ' . formatPort ($portinfo)))	;
				$singleDev['ports'] .= $singPort->run();
			}	
			$allForgDev[] = $singleDev;
			//echo "</ul></td></tr>";
			$order = $nextorder[$order];
			
		}
		$mod->addOutput("allForgDev", $allForgDevOut);
		//echo '</table>';
		//finishPortlet();
	}

	//echo '</td><td class=pcright>';
	if (!count ($confports)){
		$mod->addOutput("noPorts", true);
	//	startPortlet ('no ports');
	}
	else
	{
		$mod->addOutput("countPorts", count ($confports));

		//startPortlet ('Switch ports (' . count ($confports) . ')');
		global $nextorder;
		$order = 'odd';
		//echo '<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>';
		//echo '<tr><th>switch</th><th>ports</th></tr>';
		$allConfportsOut = array();
		foreach ($confports as $switch_id => $portlist)
		{
			usort_portlist ($portlist);
			$singlePort = array('order' => $order);
			//echo "<tr class=row_${order} valign=top><td>";
			$object = spotEntity ('object', $switch_id);
			//renderCell ($object);
			$singlePort['rendCell'] = renderCell ($object);
			//echo '</td><td class=tdleft><ul>';
			$singlePort['portlist'] = '';
			foreach ($portlist as $port_name)
			{
				$singlePortlistElem = $tplm->generateModule("StdListElem", true);
				//echo '<li>';
				if ($portinfo = getPortinfoByName ($object, $port_name))
					$singlePortlistElem->setOutput('cont', formatPortLink ($object['id'], NULL, $portinfo['id'], $portinfo['name']));
				//	echo formatPortLink ($object['id'], NULL, $portinfo['id'], $portinfo['name']);
				else
					$singlePortlistElem->setOutput('cont', $port_name);
				//	echo $port_name;
				$singlePort['portlist'] .= $singlePortlistElem->run();
				//echo '</li>';
			}
			//echo '</ul></td></tr>';
			$allConfportsOut[] = $singlePort;
			$order = $nextorder[$order];
		}
		$mod->addOutput("allConfports", $allConfportsOut);
			 
		//echo '</table>';
	}
	//finishPortlet();
	//echo '</td></tr></table>';
}

function renderVLANIPLinks ($some_id)
{
	function printNewItemTR ($sname, $options, $extra = array())
	{
		$tplm = TemplateManager::getInstance();
		//$tplm->setTemplate("vanilla");
		
		$mod = $tplm->generateModule("RenderVLANIPLinks_printNewItem", false, array('extra' => $extra));
		$mod->setNamespace("vlan");
		
		if (!count ($options))
			return;
		$mod->addOutput("OptionTree", getOptionTree ($sname, $options, array ('tabindex' => 101)));
			 
	//	printOpFormIntro ('bind', $extra);
	//	echo '<tr><td>' . getOptionTree ($sname, $options, array ('tabindex' => 101));
	//	echo '</td><td>' . getImageHREF ('ATTACH', 'bind', TRUE, 102) . '</td></tr></form>';
		return $mod->run();
	}
	global $pageno, $tabno;
	
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderVLANIPLinks");
	$mod->setNamespace("vlan");
		
	//echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
	//echo '<tr>';

	// fill $minuslines, $plusoptions, $select_name
	$minuslines = array();
	$plusoptions = array();
	$extra = array();
	switch ($pageno)
	{
	case 'vlan':
		$mod->addOutput("IsVLAN", true);
			 
		$ip_ver = $tabno == 'ipv6' ? 'ipv6' : 'ipv4';
		//echo '<th>' . getImageHREF ('net') . '</th>';
		$vlan = getVLANInfo ($some_id);
		$domainclass = array ($vlan['domain_id'] => 'trbusy');
		foreach ($vlan[$ip_ver . "nets"] as $net_id)
			$minuslines[] = array
			(
				'net_id' => $net_id,
				'domain_id' => $vlan['domain_id'],
				'vlan_id' => $vlan['vlan_id'],
			);
		// Any VLAN can link to any network that isn't yet linked to current domain.
		// get free IP nets
		$netlist_func  = $ip_ver == 'ipv6' ? 'getVLANIPv6Options' : 'getVLANIPv4Options';
		foreach ($netlist_func ($vlan['domain_id']) as $net_id)
		{
			$netinfo = spotEntity ($ip_ver . 'net', $net_id);
			if (considerConfiguredConstraint ($netinfo, 'VLANIPV4NET_LISTSRC'))
				$plusoptions['other'][$net_id] =
					$netinfo['ip'] . '/' . $netinfo['mask'] . ' ' . $netinfo['name'];
		}
		$select_name = 'id';
		$extra = array ('vlan_ck' => $vlan['domain_id'] . '-' . $vlan['vlan_id']);
		break;
	case 'ipv4net':
	case 'ipv6net':
		$mod->addOutput("IsIpv6Net", true);

		//echo '<th>VLAN</th>';
		$netinfo = spotEntity ($pageno, $some_id);
		$reuse_domain = considerConfiguredConstraint ($netinfo, '8021Q_MULTILINK_LISTSRC');
		# For each of the domains linked to the network produce class name based on
		# number of VLANs linked and the current "reuse" setting.
		$domainclass = array();
		foreach (array_count_values (reduceSubarraysToColumn ($netinfo['8021q'], 'domain_id')) as $domain_id => $vlan_count)
			$domainclass[$domain_id] = $vlan_count == 1 ? 'trbusy' : ($reuse_domain ? 'trwarning' : 'trerror');
		# Depending on the setting and the currently linked VLANs reduce the list of new
		# options by either particular VLANs or whole domains.
		$except = array();
		foreach ($netinfo['8021q'] as $item)
		{
			if ($reuse_domain)
				$except[$item['domain_id']][] = $item['vlan_id'];
			elseif (! array_key_exists ($item['domain_id'], $except))
				$except[$item['domain_id']] = range (VLAN_MIN_ID, VLAN_MAX_ID);
			$minuslines[] = array
			(
				'net_id' => $netinfo['id'],
				'domain_id' => $item['domain_id'],
				'vlan_id' => $item['vlan_id'],
			);
		}
		$plusoptions = getAllVLANOptions ($except);
		$select_name = 'vlan_ck';
		$extra = array ('id' => $netinfo['id']);
		break;
	}
	//echo '<th>&nbsp;</th></tr>';
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
		$mod->addOutput("AddNewTop", printNewItemTR ($select_name, $plusoptions, $extra));
	//	printNewItemTR ($select_name, $plusoptions, $extra);
	$allMinuslinesOut = array();
	foreach ($minuslines as $item)
	{
		$singleMinusLine = array('domainclass' => $domainclass[$item['domain_id']]);
		//echo '<tr class=' . $domainclass[$item['domain_id']] . '><td>';
		switch ($pageno)
		{
		case 'vlan':
			$singleMinusLine['RenderedCell'] = renderCell (spotEntity ($ip_ver . 'net', $item['net_id']));
			//renderCell (spotEntity ($ip_ver . 'net', $item['net_id']));
			break;
		case 'ipv4net':
		case 'ipv6net':
			$vlaninfo = getVLANInfo ($item['domain_id'] . '-' . $item['vlan_id']);
			$singleMinusLine['VlanRichTxt'] = formatVLANAsRichText ($vlaninfo);
			//echo formatVLANAsRichText ($vlaninfo);
			break;
		}
		//echo '</td><td>';
		//echo getOpLink (array ('id' => $some_id, 'op' => 'unbind', 'id' => $item['net_id'], 'vlan_ck' => $item['domain_id'] . '-' . $item['vlan_id']), '', 'Cut', 'unbind');
		$singleMinusLine['OpLink'] = getOpLink (array ('id' => $some_id, 'op' => 'unbind', 'id' => $item['net_id'], 
			'vlan_ck' => $item['domain_id'] . '-' . $item['vlan_id']), '', 'Cut', 'unbind');
		//echo '</td></tr>';
		$allMinuslinesOut[] = $singleMinusLine;
	}
	$mod->addOutput("AllMinusLines", $allMinuslinesOut);
		 
	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
		$mod->addOutput("AddNewBottom", printNewItemTR ($select_name, $plusoptions, $extra));
	//	printNewItemTR ($select_name, $plusoptions, $extra);
	//echo '</table>';
}

function renderObject8021QSync ($object_id)
{
	$vswitch = getVLANSwitchInfo ($object_id);
	$object = spotEntity ('object', $object_id);
	amplifyCell ($object);
	$maxdecisions = 0;
	$D = getStored8021QConfig ($vswitch['object_id'], 'desired');
	$C = getStored8021QConfig ($vswitch['object_id'], 'cached');
	try
	{
		$R = getRunning8021QConfig ($object_id);
		$plan = apply8021QOrder ($vswitch, get8021QSyncOptions ($vswitch, $D, $C, $R['portdata']));
		foreach ($plan as $port)
			if
			(
				$port['status'] == 'delete_conflict' or
				$port['status'] == 'merge_conflict' or
				$port['status'] == 'add_conflict' or
				$port['status'] == 'martian_conflict'
			)
				$maxdecisions++;
	}
	catch (RTGatewayError $re)
	{
		$error = $re->getMessage();
		$R = NULL;
	}

	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderObject8021QSync");
	$mod->setNamespace("object", TRUE);	

	// echo '<table border=0 class=objectview cellspacing=0 cellpadding=0>';
	// echo '<tr><td class=pcleft width="50%">';
	// startPortlet ('schedule');
	renderObject8021QSyncSchedule ($object, $vswitch, $maxdecisions, 'Sync_Schedule', $mod);
	// finishPortlet();
	// startPortlet ('preview legend');
	// echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
	// echo '<tr><th>status</th><th width="50%">color code</th></tr>';
	// echo '<tr><td class=tdright>with template role:</td><td class=trbusy>&nbsp;</td></tr>';
	// echo '<tr><td class=tdright>without template role:</td><td>&nbsp;</td></tr>';
	// echo '<tr><td class=tdright>new data:</td><td class=trok>&nbsp;</td></tr>';
	// echo '<tr><td class=tdright>warnings in new data:</td><td class=trwarning>&nbsp;</td></tr>';
	// echo '<tr><td class=tdright>fatal errors in new data:</td><td class=trerror>&nbsp;</td></tr>';
	// echo '<tr><td class=tdright>deleted data:</td><td class=trnull>&nbsp;</td></tr>';
	// echo '</table>';
	// finishPortlet();
	if (considerConfiguredConstraint ($object, '8021Q_EXTSYNC_LISTSRC'))
	{	$mod->setOutput('Considerconfiguratedconstraint', TRUE);
		// startPortlet ('add/remove 802.1Q ports');
		renderObject8021QSyncPorts ($object, $D, 'Sync_Ports', $mod);
		// finishPortlet();
	}
	// echo '</td><td class=pcright>';
	// startPortlet ('sync plan live preview');
	if ($R !== NULL){
		$mod->setOutput('R_Set', TRUE);
		renderObject8021QSyncPreview ($object, $vswitch, $plan, $C, $R, $maxdecisions, 'Sync_Preview', $mod);
	}
	else{
		$mod->setOutput('Error', $error);
		// echo "<p class=row_error>gateway error: ${error}</p>";
	}
	// finishPortlet();
	// echo '</td></tr></table>';
}

function renderObject8021QSyncSchedule ($object, $vswitch, $maxdecisions, $placeholder, $parent)
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule($placeholder , "RenderObject8021QSyncSchedule", $parent);

	// echo '<table border=0 cellspacing=0 cellpadding=3 align=center>';
	// FIXME: sort rows newest event last
	$rows = array();
	if (! considerConfiguredConstraint ($object, 'SYNC_802Q_LISTSRC'))
		$rows['auto sync'] = '<span class="trerror">disabled by operator</span>';
	$rows['last local change'] = datetimestrFromTimestamp ($vswitch['last_change']) . ' (' . formatAge ($vswitch['last_change']) . ')';
	$rows['device out of sync'] = $vswitch['out_of_sync'];
	if ($vswitch['out_of_sync'] == 'no')
	{
		$push_duration = $vswitch['last_push_finished'] - $vswitch['last_push_started'];
		$rows['last sync session with device'] = datetimestrFromTimestamp ($vswitch['last_push_started']) . ' (' . formatAge ($vswitch['last_push_started']) .
			', ' . ($push_duration < 0 ?  'interrupted' : "lasted ${push_duration}s") . ')';
	}
	if ($vswitch['last_errno'])
		$rows['failed'] = datetimestrFromTimestamp ($vswitch['last_error_ts']) . ' (' . strerror8021Q ($vswitch['last_errno']) . ')';

	if (NULL !== $new_rows = callHook ('alter8021qSyncSummaryItems', $rows))
		$rows = $new_rows;

		$rowgen = array();
	foreach ($rows as $th => $td){
		$rowgen[] = array('Th' => $th, 'Td' => $td);
		// echo "<tr><th width='50%' class=tdright>${th}:</th><td class=tdleft colspan=2>${td}</td></tr>";
	}
	$mod->setOutput('Looparray', $rowgen);

	// echo '<tr><th class=tdright>run now:</th><td class=tdcenter>';
	// printOpFormIntro ('exec8021QPull');
	// echo getImageHREF ('prev', 'pull remote changes in', TRUE, 101) . '</form></td><td class=tdcenter>';
	if ($maxdecisions){
		$mod->setOutput('Maxdecision', TRUE);
		// echo getImageHREF ('COMMIT gray', 'cannot push due to version conflict(s)');
	}
	// else
	// {
	// 	printOpFormIntro ('exec8021QPush');
	// 	echo getImageHREF ('COMMIT', 'push local changes out', TRUE, 102) . '</form>';
	// }
	// echo '</td></tr>';
	// echo '</table>';
}

function renderObject8021QSyncPreview ($object, $vswitch, $plan, $C, $R, $maxdecisions, $placeholder, $parent)
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule($placeholder , "RenderObject8021QSyncPreview", $parent);
	$mod->setNamespace('object');
	if (isset ($_REQUEST['hl_port_id']))
	{
		$mod->setOutput('Port_Id', $hl_port_id);
		assertUIntArg ('hl_port_id');
		$hl_port_id = intval ($_REQUEST['hl_port_id']);
		$hl_port_name = NULL;

		$mod->setOutput('Port_Id', $hl_port_id);
		// addAutoScrollScript ("port-$hl_port_id");

		foreach ($object['ports'] as $port)
			if (mb_strlen ($port['name']) && $port['id'] == $hl_port_id)
			{
				$hl_port_name = $port['name'];
				break;
			}
		unset ($object);
	}

	switchportInfoJS ($vswitch['object_id'], $mod); // load JS code to make portnames interactive
	// initialize one of three popups: we've got data already
	$mod->addOutput('Port_Config', addslashes (json_encode (formatPortConfigHints ($vswitch['object_id'], $R))));
	
// 	addJS (<<<END
// $(document).ready(function(){
// 	var confData = $.parseJSON('$port_config');
// 	applyConfData(confData);
// 	var menuItem = $('.context-menu-item.itemname-conf');
// 	menuItem.addClass($.contextMenu.disabledItemClassName);
// 	setItemIcon(menuItem[0], 'ok');
// });
// END
	// , TRUE);
	// echo '<table cellspacing=0 cellpadding=5 align=center class=widetable width="100%">';
	if ($maxdecisions){
		$mod->setOutput('Maxdecisions', TRUE);
		// echo '<tr><th colspan=2>&nbsp;</th><th colspan=3>discard</th><th>&nbsp;</th></tr>';
	}
	// echo '<tr valign=top><th>port</th><th width="40%">last&nbsp;saved&nbsp;version</th>';
	if ($maxdecisions)
	{
		// addJS ('js/racktables.js');
		// printOpFormIntro ('resolve8021QConflicts', array ('mutex_rev' => $vswitch['mutex_rev']));
		$position = array();
		foreach (array ('left', 'asis', 'right') as $pos){
			$position[] = array('Position' => $pos, 'Maxdecision' => $maxdecisions);
			// echo "<th class=tdcenter><input type=radio name=column_radio value=${pos} " .
			// 	"onclick=\"checkColumnOfRadios('i_', ${maxdecisions}, '_${pos}')\"></th>";
		}
		$mod->addOutput('Looparray2', $positions);
	}
	// echo '<th width="40%">running&nbsp;version</th></tr>';
	$rownum = 0;
	$plan = sortPortList ($plan);
	$domvlans = array_keys (getDomainVLANList ($vswitch['domain_id']));
	$default_port = array
	(
		'mode' => 'access',
		'allowed' => array (VLAN_DFL_ID),
		'native' => VLAN_DFL_ID,
	);
	foreach ($plan as $port_name => $item)
	{
		$smod = $tplm->generateSubmodule('Loop', 'LoopMod' , $mod);
		$trclass = $left_extra = $right_extra = $left_text = $right_text = '';
		$radio_attrs = array();
		switch ($item['status'])
		{
		case 'ok_to_delete':
			$left_text = serializeVLANPack ($item['left']);
			$right_text = 'none';
			$left_extra = ' trnull';
			$right_extra = ' trok'; // no confirmation is necessary
			break;
		case 'delete_conflict':
			$trclass = 'trbusy';
			$left_extra = ' trerror'; // can be fixed on request
			$right_extra = ' trnull';
			$left_text = formatVLANPackDiff ($item['lastseen'], $item['left']);
			$right_text = '&nbsp;';
			$radio_attrs = array ('left' => '', 'asis' => ' checked', 'right' => ' disabled');
			// dummy setting to suppress warnings in resolve8021QConflicts()
			$item['right'] = $default_port;
			break;
		case 'add_conflict':
			$trclass = 'trbusy';
			$right_extra = ' trerror';
			$left_text = '&nbsp;';
			$right_text = serializeVLANPack ($item['right']);
			break;
		case 'ok_to_add':
			$trclass = 'trbusy';
			$right_extra = ' trok';
			$left_text = '&nbsp;';
			$right_text = serializeVLANPack ($item['right']);
			break;
		case 'ok_to_merge':
			$trclass = 'trbusy';
			$left_extra = ' trok';
			$right_extra = ' trok';
			// fall through
		case 'in_sync':
			$trclass = 'trbusy';
			$left_text = $right_text = serializeVLANPack ($item['both']);
			break;
		case 'ok_to_pull':
			// at least one of the sides is not in the default state
			$trclass = 'trbusy';
			$right_extra = ' trok';
			$left_text = serializeVLANPack ($item['left']);
			$right_text = serializeVLANPack ($item['right']);
			break;
		case 'ok_to_push':
			$trclass = ' trbusy';
			$left_extra = ' trok';
			$left_text = formatVLANPackDiff ($C[$port_name], $item['left']);
			$right_text = serializeVLANPack ($item['right']);
			break;
		case 'merge_conflict':
			$trclass = 'trbusy';
			$left_extra = ' trerror';
			$right_extra = ' trerror';
			$left_text = formatVLANPackDiff ($C[$port_name], $item['left']);
			$right_text = serializeVLANPack ($item['right']);
			// enable, but consider each option independently
			// Don't accept running VLANs not in domain, and
			// don't offer anything, that VST will deny.
			// Consider domain and template constraints.
			$radio_attrs = array ('left' => '', 'asis' => ' checked', 'right' => '');
			if
			(
				!acceptable8021QConfig ($item['right']) or
				count (array_diff ($item['right']['allowed'], $domvlans)) or
				!goodModeForVSTRole ($item['right']['mode'], $item['vst_role'])
			)
				$radio_attrs['left'] = ' disabled';
			break;
		case 'ok_to_push_with_merge':
			$trclass = 'trbusy';
			$left_extra = ' trok';
			$right_extra = ' trwarning';
			$left_text = formatVLANPackDiff ($C[$port_name], $item['left']);
			$right_text = serializeVLANPack ($item['right']);
			break;
		case 'none':
			$left_text = '&nbsp;';
			$right_text = '&nbsp;';
			break;
		case 'martian_conflict':
			if ($item['right']['mode'] == 'none')
				$right_text = '&nbsp;';
			else
			{
				$right_text = serializeVLANPack ($item['right']);
				$right_extra = ' trerror';
			}
			if ($item['left']['mode'] == 'none')
				$left_text = '&nbsp;';
			else
			{
				$left_text = serializeVLANPack ($item['left']);
				$left_extra = ' trerror';
				$radio_attrs = array ('left' => '', 'asis' => ' checked', 'right' => ' disabled');
				// idem, see above
				$item['right'] = $default_port;
			}
			break;
		default:
			$trclass = 'trerror';
			$left_text = $right_text = 'internal rendering error';
			break;
		}

		$anchor = '';
		$td_class = '';
		if (isset ($hl_port_name) and $hl_port_name == $port_name)
		{
			$anchor = "name='port-$hl_port_id'";
			$td_class = ' border_highlight';
		}
		$smod->addOutput('Trclass', $trclass);
		$smod->addOutput('Tdclass', $td_class);
		$smod->addOutput('Port_Name', $port_name);
		$smod->addOutput('Left_Extra', $left_extra);
		$smod->addOutput('Left_Text', $left_text);
		$smod->addOutput('Right_Extra', $right_extra);
		$smod->addOutput('Right_Text', $right_text);
		// echo "<tr class='${trclass}'><td class='tdleft${td_class}' NOWRAP><a class='interactive-portname port-menu nolink' $anchor>${port_name}</a></td>";
		if (!count ($radio_attrs))
		{
			$smod->addOutput('Empty_Radioattrs', TRUE);
			// echo "<td class='tdleft${left_extra}'>${left_text}</td>";
			if ($maxdecisions)
				$smod->addOutput('Maxdecisions', TRUE);
				// echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
			// echo "<td class='tdleft${right_extra}'>${right_text}</td>";
		}
		else
		{
			// echo "<td class='tdleft${left_extra}'><label for=i_${rownum}_left>${left_text}</label></td>";
			$tdloop = array();
			foreach ($radio_attrs as $pos => $attrs){
				$tdloop[] = array(  'Rownum' => $rownum,
									'Position' => $pos, 
									'Attrs' => $attrs);
				// echo "<td><input id=i_${rownum}_${pos} name=i_${rownum} type=radio value=${pos}${attrs}></td>";
			}
			$smod->addOutput('Looparray', $tdloop); 
			// echo "<td class='tdleft${right_extra}'><label for=i_${rownum}_right>${right_text}</label></td>";
		}
		// echo '</tr>';
		if (count ($radio_attrs))
		{	
			$smod->addOutput('Item_Mode', $item['right']['mode']);
			$smod->addOutput('Item_Native', $item['right']['native']);			
			// echo "<input type=hidden name=rm_${rownum} value=" . $item['right']['mode'] . '>';
			// echo "<input type=hidden name=rn_${rownum} value=" . $item['right']['native'] . '>';
			$input = array();
			foreach ($item['right']['allowed'] as $a){
				$input[] = array('Rownum' => $rownum,
								 'A' => $a);
				// echo "<input type=hidden name=ra_${rownum}[] value=${a}>";
			}
			$smod->addOutput('Looparray2', $input);
			$smod->addOutput('Html', htmlspecialchars ($port_name));
			// echo "<input type=hidden name=pn_${rownum} value='" . htmlspecialchars ($port_name) . "'>";
		}
		$rownum += count ($radio_attrs) ? 1 : 0;
	}
	if ($rownum) // normally should be equal to $maxdecisions
	{
		$mod->addOutput('Rownum_Set', TRUE);
		// echo "<input type=hidden name=nrows value=${rownum}>";
		// echo '<tr><td colspan=2>&nbsp;</td><td colspan=3 align=center class=tdcenter>';
		// printImageHREF ('UNLOCK', 'resolve conflicts', TRUE);
		// echo '</td><td>&nbsp;</td></tr>';
	}
	// echo '</table>';
	// echo '</form>';
}

function renderObject8021QSyncPorts ($object, $D, $placeholder, $parent)
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	
	$mod = $tplm->generateSubmodule($placeholder ,"RenderObject8021QSyncPorts", $parent);

	$allethports = array();
	foreach (array_filter ($object['ports'], 'isEthernetPort') as $port)
		$allethports[$port['name']] = formatPortIIFOIF ($port);
	$enabled = array();
	# OPTIONSs for existing 802.1Q ports
	foreach (sortPortList ($D) as $portname => $portconfig)
		$enabled["disable ${portname}"] = "${portname} ("
			. (array_key_exists ($portname, $allethports) ? $allethports[$portname] : 'N/A')
			. ') ' . serializeVLANPack ($portconfig);
	# OPTIONs for potential 802.1Q ports
	$disabled = array();
	foreach (sortPortList ($allethports) as $portname => $iifoif)
		if (! array_key_exists ("disable ${portname}", $enabled))
			$disabled["enable ${portname}"] = "${portname} (${iifoif})";
	// printOpFormIntro ('updPortList');
	// echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
	// echo '<tr><td>';
		$mod->setOutput('Nifty_Select', getNiftySelect (array ('select ports to disable 802.1Q' => $enabled, 'select ports to enable 802.1Q' => $disabled),
								 array ('name' => 'ports[]', 'multiple' => 1, 'size' => getConfigVar ('MAXSELSIZE')),
								  NULL));
	// printNiftySelect
	// (
	// 	array ('select ports to disable 802.1Q' => $enabled, 'select ports to enable 802.1Q' => $disabled),
	// 	array ('name' => 'ports[]', 'multiple' => 1, 'size' => getConfigVar ('MAXSELSIZE'))
	// );
	// echo '</td></tr>';
	// echo '<tr><td>' . getImageHREF ('RECALC', 'process changes', TRUE) . '</td></tr>';
	// echo '</table></form>';
}

function renderVSTListEditor()
{
	$tplm  =TemplateManager::getInstance();
	$tplm->setTemplate('vanilla');
	//$tplm->createMainModule();
	$mod = $tplm->generateSubmodule('Payload', 'RenderVSTListEditor');
	$mod->setNamespace('vst', TRUE);
	
	function printNewItemTR ($placeholder, $parent)
	{
		$tplm  =TemplateManager::getInstance();
		$tplm->setTemplate('vanilla');
		//$tplm->createMainModule();	
		$submod = $tplm->generateSubmodule($placeholder, 'RenderVSTListEditor_PrintNewItem', $parent);
		
		//printOpFormIntro ('add');
		//echo '<tr>';
		//echo '<td>' . getImageHREF ('create', 'create template', TRUE, 104) . '</td>';
		//echo '<td><input type=text size=48 name=vst_descr tabindex=101></td>';
		//echo '<td>' . getImageHREF ('create', 'create template', TRUE, 103) . '</td>';
		//echo '</tr></form>';
	}
	//echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
	//echo '<tr><th>&nbsp;</th><th>description</th><th>&nbsp</th></tr>';
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
		printNewItemTR('NewTop', $mod);
		//printNewItemTR();
	foreach (listCells ('vst') as $vst_id => $vst_info)
	{	
		$submod = $tplm->generateSubmodule('Merge', 'RenderVSTListEditor_CreateRow', $mod);
		$submod->setOutput('Vst_id', $vst_id);
		//printOpFormIntro ('upd', array ('vst_id' => $vst_id));
		//echo '<tr><td>';
		if ($vst_info['switchc'])
			$submod->setOutput('Switchc_set', TRUE);
			//printImageHREF ('nodestroy', 'template used elsewhere');
		//else
			//echo getOpLink (array ('op' => 'del', 'vst_id' => $vst_id), '', 'destroy', 'delete template');
		//echo '</td>';
		$submod->setOutput('NiftyString', niftyString ($vst_info['description'], 0));
		//echo '<td><input name=vst_descr type=text size=48 value="' . niftyString ($vst_info['description'], 0) . '"></td>';
		$submod->setOutput('Imagehref', getImageHREF ('save', 'update template', TRUE));
		//echo '<td>' . getImageHREF ('save', 'update template', TRUE) . '</td>';
		//echo '</tr></form>';
	}
	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
		printNewItemTR('NewBottom', $mod);
	//echo '</table>';
}

function renderVSTRules ($rules, $title = NULL, $parent = null, $placeholder = 'Payload')
{
	
	$tplm = TemplateManager::getInstance();
	$tplm->setTemplate('vanilla');
	//$tplm->createMainModule();
	if($parent == null)
		$mod = $tplm->generateSubmodule($placeholder, 'RenderVSTRules');
	else
		$mod = $tplm->generateSubmodule($placeholder, 'RenderVSTRules', $parent);
	$mod->setNamespace('vst', TRUE);
	
	if (!count ($rules)){
		$mod->addOutput('Rules_empty', TRUE);
		$mod->addOutput('Title', isset($title)? $title: 'no rules');	
	//startPortlet (isset ($title) ? $title : 'no rules');
	}
		else
	{
		global $port_role_options, $nextorder;
		$mod->addOutput('Title', isset($title)? $title: 'rules (' . count ($rules) . ')');	
		//startPortlet (isset ($title) ? $title : 'rules (' . count ($rules) . ')');
		//echo '<table class=cooltable align=center border=0 cellpadding=5 cellspacing=0>';
		//echo '<tr><th>sequence</th><th>regexp</th><th>role</th><th>VLAN IDs</th><th>comment</th></tr>';
		$order = 'odd';
		foreach ($rules as $item)
		{
			
			$submod = $tplm->generateSubmodule('ItemRows' ,'RenderVSTRules_CreateItemRow' ,$mod,false,
				 array('Order' => $order, 
				 	'Rule_no' => $item['rule_no'], 
				 	'Port_pcre' => $item['port_pcre'], 
				 	'Port_role' => $port_role_options[$item['port_role']], 
				 	'Wrt_vlans' => $item['wrt_vlans'], 
				 	'Description' => $item['description']));
			$submod->setNamespace('vst');
			//echo "<tr class=row_${order} align=left>";
			//echo "<td>${item['rule_no']}</td>";
			//echo "<td nowrap><tt>${item['port_pcre']}</tt></td>";
			//echo '<td nowrap>' . $port_role_options[$item['port_role']] . '</td>';
			//echo "<td>${item['wrt_vlans']}</td>";
			//echo "<td>${item['description']}</td>";
			//echo '</tr>';
			$order = $nextorder[$order];
		}
		//echo '</table>';
	}
	//finishPortlet();
}

 function renderVST ($vst_id)
{
	$tplm = TemplateManager::getInstance();
	$tplm->setTemplate('vanilla');
	//$tplm->createMainModule();
	$mod = $tplm->generateSubmodule('Payload', 'RenderVST');
	$mod->setNamespace('vst', true);
	
	$vst = spotEntity ('vst', $vst_id);
	amplifyCell ($vst);
	$mod->addOutput('Vst', $vst);
	$mod->addOutput('VstDescription', $vst['description']);
	$mod->addOutput('Switches', $vst['switches']);
	//echo '<table border=0 class=objectview cellspacing=0 cellpadding=0>';
	//echo '<tr><td colspan=2 align=center><h1>' . niftyString ($vst['description'], 0) . '</h1><h2>';
	//echo "<tr><td class=pcleft width='50%'>";

	renderEntitySummary ($vst, 'summary', array ('tags' => ''), $mod, 'EntitySummary');

	renderVSTRules ($vst['rules'], null, $mod, 'VstRules');
	//echo '</td><td class=pcright>';
	if (!count ($vst['switches']))
		$mod->addOutput('EmptySwitches', true);
	else
	{
			global $nextorder;
		//startPortlet ('orders (' . count ($vst['switches']) . ')');
	//	echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
		$order = 'odd';
		$arr = array();
		foreach (array_keys ($vst['switches']) as $object_id)
		{
			$arr[] = array('Render_cell' => renderCell (spotEntity ('object', $object_id)), 'Order' => $order);
			//echo "<tr class=row_${order}><td>";
			//renderCell (spotEntity ('object', $object_id));
			//echo '</td></tr>';
			$order = $nextorder[$order];
		}
		$mod->addOutput('Order_id_array',$arr);
		//echo '</table>';
	}
	//finishPortlet();
	//echo '</td></tr></table>';
 } 

function renderVSTRulesEditor ($vst_id)
{
	$vst = spotEntity ('vst', $vst_id);
	amplifyCell ($vst);
	if ($vst['rulec'])
		$source_options = array();
	else
	{
		$source_options = array();
		foreach (listCells ('vst') as $vst_id => $vst_info)
			if ($vst_info['rulec'])
				$source_options[$vst_id] = niftyString ('(' . $vst_info['rulec'] . ') ' . $vst_info['description']);
	}
	//addJS ('js/vst_editor.js');
	
	$tplm = TemplateManager::getInstance();
	$tplm->setTemplate('vanilla');
	//$tplm->createMainModule();
	$mod = $tplm->generateSubmodule('Payload', 'VstRulesEditor');
	$mod->setNamespace('vst',true);
	$mod->setLock();
	$mod->addOutput('Nifty', niftyString ($vst['description']));
	
	//echo '<center><h1>' . niftyString ($vst['description']) . '</h1></center>';
	
	if (count ($source_options))
	{
		$mod->addOutput('Count', true);
		//startPortlet ('clone another template');
		//printOpFormIntro ('clone');
		$mod->addOutput('VstMutexRev', $vst['mutex_rev']);
		//echo '<input type=hidden name="mutex_rev" value="' . $vst['mutex_rev'] . '">';
		//echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
		$mod->addOutput('AccessSelectClone', getSelect ($source_options, array ('name' => 'from_id')));
		//echo '<tr><td>' . getSelect ($source_options, array ('name' => 'from_id')) . '</td>';
		//echo '<td>' . getImageHREF ('COPY', 'copy from selected', TRUE) . '</td></tr></table></form>';
		//finishPortlet();
		//startPortlet ('add rules one by one');
	}
	//printOpFormIntro ('upd');
	//echo '<table cellspacing=0 cellpadding=5 align=center class="widetable template-rules">';
	//echo '<tr><th></th><th>sequence</th><th>regexp</th><th>role</th>';
	//echo '<th>VLAN IDs</th><th>comment</th><th><a href="#" class="vst-add-rule initial">' . getImageHREF ('add', 'Add rule') . '</a></th></tr>';
	global $port_role_options;
	//$mod->addOutput('Port_role_options', $port_role_options);
	
  /*$row_html  = '<td><a href="#" class="vst-del-rule">' . getImageHREF ('destroy', 'delete rule') . '</a></td>'; //<img width="16" height="16" border="0" title="delete rule" src="?module=chrome&uri=pix/tango-list-remove.png">
	$row_html .= '<td><input type=text name=rule_no value="%s" size=3></td>';
	$row_html .= '<td><input type=text name=port_pcre value="%s"></td>';
	$row_html .= '<td>%s</td>';
	$row_html .= '<td><input type=text name=wrt_vlans value="%s"></td>';
	$row_html .= '<td><input type=text name=description value="%s"></td>';
	$row_html .= '<td><a href="#" class="vst-add-rule">' . getImageHREF ('add', 'Duplicate rule') . '</a></td>';  //<img width="16" height="16" border="0" title="Duplicate rule" src="?module=chrome&uri=pix/tango-list-add.png"> */
	$mod->addOutput('AccessSelect',  getSelect ($port_role_options, array ('name' => 'port_role'), 'anymode'));
	//addJS ("var new_vst_row = '" . addslashes (sprintf ($row_html, '', '', getSelect ($port_role_options, array ('name' => 'port_role'), 'anymode'), '', '')) . "';", TRUE);
	@session_start();
	
	$arr = array();
	foreach (isset ($_SESSION['vst_edited']) ? $_SESSION['vst_edited'] : $vst['rules'] as $item)
	{
		$arr[] = array('RuleNo' => $item['rule_no'], 'PortPCRE' => htmlspecialchars($item['port_pcre'], ENT_QUOTES), 'AccessSelectSingle' => getSelect ($port_role_options, array ('name' => 'port_role'), $item['port_role']), 'WRTVlans' => $item['wrt_vlans'], 'Description' => $item['description']);
		/*$mod->setOutput('Rule_no', $item['rule_no']);
		$mod->setOutput('Port_pcre', $item['port_pcre']);
		$mod->setOutput('Getselect', getSelect ($port_role_options, array ('name' => 'port_role'), $item['port_role']));   
		$mod->setOutput('Wrt_vlans', $item['wrt_vlans']);
		$mod->setOutput('Description', $item['description']);*/
		
	//	printf ('<tr>' . $row_html . '</tr>', $item['rule_no'], htmlspecialchars ($item['port_pcre'], ENT_QUOTES),  getSelect ($port_role_options, array ('name' => 'port_role'), $item['port_role']), $item['wrt_vlans'], $item['description']);
	};
	$mod->addOutput('ItemArray',$arr);
	$mod->addOutput('MutexRev', $vst['mutex_rev']);
	//echo '</table>';
	//echo '<input type=hidden name="template_json">';
	//echo '<input type=hidden name="mutex_rev" value="' . $vst['mutex_rev'] . '">';
	//echo '<center>' . getImageHref ('SAVE', 'Save template', TRUE) . '</center>';
	//echo '</form>';
	if (isset ($_SESSION['vst_edited']))
	{
		// draw current template
		renderVSTRules ($vst['rules'], 'currently saved tamplate', $mod, 'VstRules');
		unset ($_SESSION['vst_edited']);
	}
	session_commit();

	if (count ($source_options))
		$mod->addOutput('CountSourceOption', TRUE);
}

function renderDeployQueue()
{
	global $nextorder, $dqtitle;
	$order = 'odd';
	$dqcode = getBypassValue();
	$allq = get8021QDeployQueues();

	$tplm = TemplateManager::getInstance();
	////$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
		
	
	foreach ($allq as $qcode => $data)
		if ($dqcode == $qcode)
		{
			$mod = $tplm->generateSubmodule("Payload","DeployQueue");
			$mod->setNamespace("", true);

		//	echo "<h2 align=center>Queue '" . $dqtitle[$qcode] . "' (" . count ($data) . ")</h2>";
			$mod->setOutput("dqTitle",$dqtitle[$qcode]);
			$mod->setOutput("countData", count ($data));

			if (! count ($data)){
				$mod->setOutput("continue", true);
				continue;
			}
			$mod->setOutput("continue", false);
		//	echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
		//	echo '<tr><th>switch</th><th>changed</th><th>';
			$dataArr =array();
			foreach ($data as $item)
			{
			//	echo "<tr class=row_${order}><td>";
			//	renderCell (spotEntity ('object', $item['object_id']));
			//	echo "</td><td>" . formatAge ($item['last_change']) . "</td></tr>";
				$dataArr[] = array("order" => $order, "renderedCell" => renderCell (spotEntity ('object', $item['object_id'])), 
					"formatedAge" => formatAge ($item['last_change']));

				$order = $nextorder[$order];
			}
			$mod->setOutput("dataArr", $dataArr);
		//	echo '</table>';
		}
}

function renderDiscoveredNeighbors ($object_id)
{
	global $tabno;

	$opcode_by_tabno = array
	(
		'livecdp' => 'getcdpstatus',
		'livelldp' => 'getlldpstatus',
	);
	try
	{
		$neighbors = queryDevice ($object_id, $opcode_by_tabno[$tabno]);
		$neighbors = sortPortList ($neighbors);
	}
	catch (RTGatewayError $e)
	{
		showError ($e->getMessage());
		return;
	}
	$mydevice = spotEntity ('object', $object_id);
	amplifyCell ($mydevice);

	// reindex by port name
	$myports = array();
	foreach ($mydevice['ports'] as $port)
		if (mb_strlen ($port['name']))
			$myports[$port['name']][] = $port;

	// scroll to selected port
	if (isset ($_REQUEST['hl_port_id']))
	{
		assertUIntArg('hl_port_id');
		$hl_port_id = intval ($_REQUEST['hl_port_id']);
		addAutoScrollScript ("port-$hl_port_id");
	}

	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderDiscoveredNeighbors");
	$mod->setNamespace("object");
		
	//switchportInfoJS($object_id); // load JS code to make portnames interactive
	switchportInfoJS($object_id, $mod, 'switchPortScripts'); // load JS code to make portnames interactive
	//printOpFormIntro ('importDPData');
	//echo '<br><table cellspacing=0 cellpadding=5 align=center class=widetable>';
	//echo '<tr><th colspan=2>local port</th><th></th><th>remote device</th><th colspan=2>remote port</th><th><input type="checkbox" checked id="cb-toggle"></th></tr>';
	$inputno = 0;
	foreach ($neighbors as $local_port => $remote_list)
	{
		$initial_row = TRUE; // if port has multiple neighbors, the first table row is initial
		// array of local ports with the name specified by DP
		$local_ports = isset($myports[$local_port]) ? $myports[$local_port] : array();
		foreach ($remote_list as $dp_neighbor) // step over DP neighbors
		{
			$error_message = NULL;
			$link_matches = FALSE;
			$portinfo_local = NULL;
			$portinfo_remote = NULL;
			$variants = array();

			do { // once-cyle fake loop used only to break out of it
				if (! empty($local_ports))
					$portinfo_local = $local_ports[0];

				// find remote object by DP information
				$dp_remote_object_id = searchByMgmtHostname ($dp_neighbor['device']);
				if (! $dp_remote_object_id)
					$dp_remote_object_id = lookupEntityByString ('object', $dp_neighbor['device']);
				if (! $dp_remote_object_id)
				{
					$error_message = "No such neighbor <i>${dp_neighbor['device']}</i>";
					break;
				}
				$dp_remote_object = spotEntity ('object', $dp_remote_object_id);
				amplifyCell($dp_remote_object);
				$dp_neighbor['port'] = shortenIfName ($dp_neighbor['port'], NULL, $dp_remote_object['id']);

				// get list of ports that have name matching CDP portname
				$remote_ports = array(); // list of remote (by DP info) ports
				foreach ($dp_remote_object['ports'] as $port)
					if ($port['name'] == $dp_neighbor['port'])
					{
						$portinfo_remote = $port;
						$remote_ports[] = $port;
					}

				// check if ports with such names exist on devices
				if (empty ($local_ports))
				{
					$error_message = "No such local port <i>$local_port</i>";
					break;
				}
				if (empty ($remote_ports))
				{
					$error_message = "No such port on "
						. formatPortLink ($dp_remote_object['id'], $dp_remote_object['name'], NULL, NULL);
					break;
				}

				// determine match or mismatch of local link
				foreach ($local_ports as $portinfo_local)
					if ($portinfo_local['remote_id'])
					{
						if
						(
							$portinfo_local['remote_object_id'] == $dp_remote_object_id
							and $portinfo_local['remote_name'] == $dp_neighbor['port']
						)
						{
							// set $portinfo_remote to corresponding remote port
							foreach ($remote_ports as $portinfo_remote)
								if ($portinfo_remote['id'] == $portinfo_local['remote_id'])
									break;
							$link_matches = TRUE;
							unset ($error_message);
						}
						elseif ($portinfo_local['remote_object_id'] != $dp_remote_object_id)
							$error_message = "Remote device mismatch - port linked to "
								. formatLinkedPort ($portinfo_local);
						else // ($portinfo_local['remote_name'] != $dp_neighbor['port'])
							$error_message = "Remote port mismatch - port linked to "
								. formatPortLink ($portinfo_local['remote_object_id'], NULL, $portinfo_local['remote_id'], $portinfo_local['remote_name']);;
						break 2;
					}

				// no local links found, try to search for remote links
				foreach ($remote_ports as $portinfo_remote)
					if ($portinfo_remote['remote_id'])
					{
						$remote_link_html = formatLinkedPort ($portinfo_remote);
						$remote_port_html = formatPortLink ($portinfo_remote['object_id'], NULL, $portinfo_remote['id'], $portinfo_remote['name']);
						$error_message = "Remote port $remote_port_html is already linked to $remote_link_html";
						break 2;
					}

				// no links found on both sides, search for a compatible port pair
				$port_types = array();
				foreach (array ('left' => $local_ports, 'right' => $remote_ports) as $side => $port_list)
					foreach ($port_list as $portinfo)
					{
						$tmp_types = ($portinfo['iif_id'] == 1) ?
							array ($portinfo['oif_id'] => $portinfo['oif_name']) :
							getExistingPortTypeOptions ($portinfo['id']);
						foreach ($tmp_types as $oif_id => $oif_name)
							$port_types[$side][$oif_id][] = array ('id' => $oif_id, 'name' => $oif_name, 'portinfo' => $portinfo);
					}

				foreach ($port_types['left'] as $left_id => $left)
				foreach ($port_types['right'] as $right_id => $right)
					if (arePortTypesCompatible ($left_id, $right_id))
						foreach ($left as $left_port)
						foreach ($right as $right_port)
							$variants[] = array ('left' => $left_port, 'right' => $right_port);
				if (! count ($variants)) // no compatible ports found
					$error_message = "Incompatible port types";
			} while (FALSE); // do {

			$tr_class = $link_matches ? 'trok' : (isset ($error_message) ? 'trerror' : 'trwarning');
			$singleNeighbor = array('tr_class' => $tr_class);

			//echo "<tr class=\"$tr_class\">";
			if ($initial_row)
			{
				$count = count ($remote_list);
				$td_class = '';

				$singleNeighbor['isInitialRow'] = true;

				if (isset ($hl_port_id) and $hl_port_id == $portinfo_local['id'])
					$singleNeighbor['td_class'] = "class='border_highlight'";
				//	$td_class = "class='border_highlight'";
				/*echo "<td rowspan=\"$count\" $td_class NOWRAP>" .
					($portinfo_local ?
						formatPortLink ($mydevice['id'], NULL, $portinfo_local['id'], $portinfo_local['name'], 'interactive-portname port-menu') :
						"<a class='interactive-portname port-menu nolink'>$local_port</a>"
					) .
					($count > 1 ? "<br> ($count neighbors)" : '') .
					'</td>';*/
				if($portinfo_local)
					formatPortLink ($mydevice['id'], NULL, $portinfo_local['id'], $portinfo_local['name'], 'interactive-portname port-menu', $mod, 'id_port_link_local');
				else
					$singlePort['localport'] = $localport;

				$initial_row = FALSE;
			}
			//echo "<td>" . ($portinfo_local ?  formatPortIIFOIF ($portinfo_local) : '&nbsp') . "</td>";
			//echo "<td>" . formatIfTypeVariants ($variants, "ports_${inputno}") . "</td>";
			$singleNeighbor['portIIFOIFLocal'] = ($portinfo_local ?  formatPortIIFOIF ($portinfo_local) : '&nbsp');
			formatIfTypeVariants ($variants, "ports_${inputno}", $mod, "ifTypeVariants");
			$singleNeighbor['device'] = $dp_neighbor['device'];
			if($portinfo_remote)
				formatPortLink ($dp_remote_object_id, NULL, $portinfo_remote['id'], $portinfo_remote['name'], $mod, 'id_port_link_remote');
			else
				$singlePort['port'] = $dp_neighbor['port'];
			$singleNeighbor['portIIFOIFRemote'] = ($portinfo_remote ?  formatPortIIFOIF ($portinfo_remote) : '&nbsp');
			//echo "<td>${dp_neighbor['device']}</td>";
			//echo "<td>" . ($portinfo_remote ? formatPortLink ($dp_remote_object_id, NULL, $portinfo_remote['id'], $portinfo_remote['name']) : $dp_neighbor['port'] ) . "</td>";
			//echo "<td>" . ($portinfo_remote ?  formatPortIIFOIF ($portinfo_remote) : '&nbsp') . "</td>";
			//echo "<td>";
			if (! empty ($variants))
			{
				$singleNeighbor['inputno'] = $inputno;
				//echo "<input type=checkbox name=do_${inputno} class='cb-makelink'>";
				$inputno++;
			}
			//echo "</td>";

			if (isset ($error_message))
				$singleNeighbor['error_message'] = $error_message;
			//	echo "<td style=\"background-color: white; border-top: none\">$error_message</td>";
			//echo "</tr>";

			//Using array generated for possible array
			$tplm->generateSubmodule('AllNeighbors','RenderDiscoveredNeighbors_NeighborsMod', $mod, false, $singleNeighbor);
		}
	}
		 

	if ($inputno)
	{
		$mod->addOutput("inputno", $inputno);
			 
	//	echo "<input type=hidden name=nports value=${inputno}>";
	//	echo '<tr><td colspan=7 align=center>' . getImageHREF ('CREATE', 'import selected', TRUE) . '</td></tr>';
	}
	//echo '</table></form>';
/*
	addJS (<<<END
$(document).ready(function () {
	$('#cb-toggle').click(function (event) {
		var list = $('.cb-makelink');
		for (var i in list) {
			var cb = list[i];
			cb.checked = event.target.checked;
		}
	}).triggerHandler('click');
});
END
		, TRUE
	);*/
}

// $variants is an array of items like this:
// array (
//	'left' => array ('id' => oif_id, 'name' => oif_name, 'portinfo' => $port_info),
//	'left' => array ('id' => oif_id, 'name' => oif_name, 'portinfo' => $port_info),
// )
function formatIfTypeVariants ($variants, $select_name, $parent = null, $placeholder = "ifTypeVariants" )
{
	if (empty ($variants))
		return;
	static $oif_usage_stat = NULL;
	$select = array();
	$creating_transceivers = FALSE;
	$most_used_count = 0;
	$selected_key = NULL;
	$multiple_left = FALSE;
	$multiple_right = FALSE;

	$seen_ports = array();
	foreach ($variants as $item)
	{
		if (isset ($seen_ports['left']) && $item['left']['portinfo']['id'] != $seen_ports['left'])
			$multiple_left = TRUE;
		if (isset ($seen_ports['right']) && $item['right']['portinfo']['id'] != $seen_ports['right'])
			$multiple_right = TRUE;
		$seen_ports['left'] = $item['left']['portinfo']['id'];
		$seen_ports['right'] = $item['right']['portinfo']['id'];
	}

	if (! isset ($oif_usage_stat))
		$oif_usage_stat = getPortTypeUsageStatistics();

	foreach ($variants as $item)
	{
		// format text label for selectbox item
		$left_text = ($multiple_left ? $item['left']['portinfo']['iif_name'] . '/' : '') . $item['left']['name'];
		$right_text = ($multiple_right ? $item['right']['portinfo']['iif_name'] . '/' : '') . $item['right']['name'];
		$text = $left_text;
		if ($left_text != $right_text && strlen ($right_text))
		{
			if (strlen ($text))
				$text .= " | ";
			$text .= $right_text;
		}

		// fill the $params: port ids and port types
		$params = array
		(
			'a_id' => $item['left']['portinfo']['id'],
			'b_id' => $item['right']['portinfo']['id'],
		);
		$popularity_count = 0;
		foreach (array ('left' => 'a', 'right' => 'b') as $side => $letter)
		{
			$params[$letter . '_oif'] = $item[$side]['id'];
			$type_key = $item[$side]['portinfo']['iif_id'] . '-' . $item[$side]['id'];
			if (isset ($oif_usage_stat[$type_key]))
				$popularity_count += $oif_usage_stat[$type_key];
		}

		$key = ''; // key sample: a_id:id,a_oif:id,b_id:id,b_oif:id
		foreach ($params as $i => $j)
			$key .= "$i:$j,";
		$key = trim($key, ",");
		$select[$key] = (count ($variants) == 1 ? '' : $text); // empty string if there is simple single variant
		$weights[$key] = $popularity_count;
	}
	arsort ($weights, SORT_NUMERIC);
	$sorted_select = array();
	foreach (array_keys ($weights) as $key)
		$sorted_select[$key] = $select[$key];
	if($parent == null)
		return getSelect ($sorted_select, array('name' => $select_name));
	else	
		getSelect ($sorted_select, array('name' => $select_name), NULL, TRUE, $parent, $placeholder);
}

function formatAttributeValue ($record)
{
	if ('date' == $record['type'])
		return datetimestrFromTimestamp ($record['value']);

	if (! isset ($record['key'])) // if record is a dictionary value, generate href with autotag in cfe
	{
		if ($record['id'] == 3) // FQDN attribute
			foreach (getMgmtProtosConfig() as $proto => $filter)
				try
				{
					if (considerGivenConstraint (NULL, $filter))
					{
						$blank = (preg_match ('/^https?$/', $proto) ? 'target=_blank' : '');
						return "<a $blank title='Open $proto session' class='mgmt-link' href='" . $proto . '://' . $record['a_value'] . "'>${record['a_value']}</a>";
					}
				}
				catch (RackTablesError $e)
				{
					// syntax error in $filter
					continue;
				}
		return isset ($record['href']) ? "<a href=\"".$record['href']."\">${record['a_value']}</a>" : $record['a_value'];
	}

	$href = makeHref
	(
		array
		(
			'page'=>'depot',
			'tab'=>'default',
			'andor' => 'and',
			'cfe' => '{$attr_' . $record['id'] . '_' . $record['key'] . '}',
		)
	);
	$result = "<a href='$href'>" . $record['a_value'] . "</a>";
	if (isset ($record['href']))
		$result .= "&nbsp;<a class='img-link' href='${record['href']}'>" . getImageHREF ('html', 'vendor&apos;s info page') . "</a>";
	return $result;
}

function addAutoScrollScript ($anchor_name, $parent = null, $placeholder = "autoScrollScript")
{
	$tplm = TemplateManager::getInstance();
	//if($parent==null)
	//	$tplm->setTemplate("vanilla");
	
	if($parent==null)	
		$mod = $tplm->generateModule("AddAutoScrollScript");
	else
		$mod = $tplm->generateSubmodule($placeholder, "AddAutoScrollScript", $parent);
	
	$mod->setNamespace("");
	$mod->setOutput('AnchorName', $anchor_name);
	if($parent==null)
		return $mod->run();
/*
	addJS (<<<END
$(document).ready(function() {
	var anchor = document.getElementsByName('$anchor_name')[0];
	if (anchor)
		anchor.scrollIntoView(false);
});
END
	, TRUE);*/
}

//
// Display object level logs
//
function renderObjectLogEditor ()
{
	$tplm = TemplateManager::getInstance();
	$tplm->setTemplate('vanilla');
	//$main = //$tplm->createMainModule();
		
	$mod = $tplm->generateSubmodule('Payload', 'RenderObjectLogEditor');
	$mod->setNamespace('location',true);

	global $nextorder;


	$mod->addOutput('Image_Href', getImageHREF ('CREATE', 'add record', TRUE, 101));

	// echo "<center><h2>Log records for this object (<a href=?page=objectlog>complete list</a>)</h2></center>";
	// printOpFormIntro ('add');
	// echo "<table with=80% align=center border=0 cellpadding=5 cellspacing=0 align=center class=cooltable><tr valign=top class=row_odd>";
	// echo '<td class=tdcenter>' . getImageHREF ('CREATE', 'add record', TRUE, 101) . '</td>';
	// echo '<td><textarea name=logentry rows=10 cols=80 tabindex=100></textarea></td>';
	// echo '<td class=tdcenter>' . getImageHREF ('CREATE', 'add record', TRUE, 101) . '</td>' ;
	// echo '</tr></form>';
/*
	
	$tplm = TemplateManager::getInstance();
	
	if ($parent == NULL)
	{
		$tplm->setTemplate('vanilla');
		$tplm->createMainModule();
	}
	
	$mod = $tplm->generateSubmodule($placeholder, 'ObjectLogEditor', $parent);
	$mod->setNamespace('objectlog',true);
	
	/**echo "<center><h2>Log records for this object (<a href=?page=objectlog>complete list</a>)</h2></center>";
	//printOpFormIntro ('add');
	echo "<table with=80% align=center border=0 cellpadding=5 cellspacing=0 align=center class=cooltable><tr valign=top class=row_odd>";
	echo '<td class=tdcenter>' . getImageHREF ('CREATE', 'add record', TRUE, 101) . '</td>';
	echo '<td><textarea name=logentry rows=10 cols=80 tabindex=100></textarea></td>';
	echo '<td class=tdcenter>' . getImageHREF ('CREATE', 'add record', TRUE, 101) . '</td>' ;
	echo '</tr></form>';
*/
	$order = 'even';
	foreach (getLogRecordsForObject (getBypassValue()) as $row)
	{

		$submod = $tplm->generateSubmodule('Rows', 'RowGenerator', $mod);
		$submod->setOutput('Order', $order);
		$submod->setOutput('Date', $row['date']);
		$submod->setOutput('User', $row['user']);
		$submod->setOutput('Hrefs', string_insert_hrefs (htmlspecialchars ($row['content'], ENT_NOQUOTES)));
		$submod->setOutput('Id', $row['id']);
		// echo "<tr class=row_${order} valign=top>";
		// echo '<td class=tdleft>' . $row['date'] . '<br>' . $row['user'] . '</td>';
		// echo '<td class="logentry">' . string_insert_hrefs (htmlspecialchars ($row['content'], ENT_NOQUOTES)) . '</td>';
		// echo "<td class=tdleft>";
		// echo getOpLink (array('op'=>'del', 'log_id'=>$row['id']), '', 'DESTROY', 'Delete log entry');
		// echo "</td></tr>\n";
		$order = $nextorder[$order];
	}
	// echo '</table>';
/*		$smod = $tplm->generateSubmodule('Elements', 'ObjectLogEditorElement', $mod);
		$smod->addOutput('Date', $row['date']);
		$smod->addOutput('User', $row['user']);
		$smod->addOutput('Id', $row['id']);
		$smod->addOutput('Order', $order);
		$smod->addOutput('Content', string_insert_hrefs(htmlspecialchars ($row['content'], ENT_NOQUOTES)));
		/**echo "<tr class=row_${order} valign=top>";
		echo '<td class=tdleft>' . $row['date'] . '<br>' . $row['user'] . '</td>';
		echo '<td class="logentry">' . string_insert_hrefs (htmlspecialchars ($row['content'], ENT_NOQUOTES)) . '</td>';
		echo "<td class=tdleft>";
		echo getOpLink (array('op'=>'del', 'log_id'=>$row['id']), '', 'DESTROY', 'Delete log entry');
		echo "</td></tr>\n";
		$order = $nextorder[$order];
	}
	/**echo '</table>';*/


}

//
// Display form and All log entries
//
function allObjectLogs ()
{
	$tplm = TemplateManager::getInstance();
	////$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");

	$logs = getLogRecords ();


	if (count($logs) > 0)
	{
		$mod = $tplm->generateSubmodule("Payload", "AllObjectLogs");
		$mod->setNamespace("objectlog",true);

		global $nextorder;
		//echo "<br><table width='80%' align=center border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>";
		//echo '<tr valign=top><th class=tdleft>Object</th><th class=tdleft>Date/user</th>';
		//echo '<th class=tdcenter>' . getImageHREF ('text') . '</th></tr>';
		

		$order = 'odd';

		$log_data_array = array();

		foreach ($logs as $row)
		{
			$row_data = array('order' => $order);
			// Link to a different page if the object is a Rack
			if ($row['objtype_id'] == 1560)
			{
				$text = $row['name'];
				$entity = 'rack';
			}
			else
			{
				$object = spotEntity ('object', $row['object_id']);
				$text = $object['dname'];
				$entity = 'object';
			}

			$row_data["Object_id"] = mkA ($text, $entity, $row['object_id'], 'log');
			$row_data["Date"] = $row['date'];
			$row_data["User"] = $row['user'];
			$row_data["Logentry"] = string_insert_hrefs (htmlspecialchars ($row['content'], ENT_NOQUOTES));

			//echo "<tr class=row_${order} valign=top>";
			//echo '<td class=tdleft>' . mkA ($text, $entity, $row['object_id'], 'log') . '</td>';
			//echo '<td class=tdleft>' . $row['date'] . '<br>' . $row['user'] . '</td>';
			//echo '<td class="logentry">' . string_insert_hrefs (htmlspecialchars ($row['content'], ENT_NOQUOTES)) . '</td>';
			//echo "</tr>\n";
			$order = $nextorder[$order];
			
			$log_data_array[] = $row_data;
		}
		
		$mod->setOutput("IMAGE_HREF", getImageHREF('text'));
		$mod->addOutput("LogTableData", $log_data_array);
		//echo '</table>';
	}
	else
		$tplm->generateSubmodule("Payload", "NoObjectLogFound", null, true);
	//	echo '<center><h2>No logs exist</h2></center>';

}

function renderGlobalLogEditor()
{
	echo "<table with='80%' align=center border=0 cellpadding=5 cellspacing=0 align=center class=cooltable><tr valign=top>";
	printOpFormIntro ('add');
	echo '<th align=left>Name: ' . getSelect (getNarrowObjectList(), array ('name' => 'object_id')) . '</th>';
	echo "<tr><td align=left><table with=100% border=0 cellpadding=0 cellspacing=0><tr><td colspan=2><textarea name=logentry rows=3 cols=80></textarea></td></tr>";
	echo '<tr><td align=left></td><td align=right>' . getImageHREF ('CREATE', 'add record', TRUE) . '</td>';
	echo '</tr></table></td></tr>';
	echo '</form>';
	echo '</table>';
}

function renderVirtualResourcesSummary ()
{
	global $pageno, $nextorder;
	$tplm = TemplateManager::getInstance();
	////$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderVirtualResourcesSummary");
	$mod->setNamespace("", true);
		
	//echo "<table border=0 class=objectview>\n";
	//echo "<tr><td class=pcleft>";

	$clusters = getVMClusterSummary ();
	//startPortlet ('Clusters (' . count ($clusters) . ')');
	$mod->setOutput("countClusters", count($clusters));
		 
	if (count($clusters) > 0)
	{
		$mod->setOutput("areClusters", true);
			 
		echo "<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>\n";
		echo "<tr><th>Cluster</th><th>Hypervisors</th><th>Resource Pools</th><th>Cluster VMs</th><th>RP VMs</th><th>Total VMs</th></tr>\n";
		$order = 'odd';
		$clustersArr = array();
		foreach ($clusters as $cluster)
		{
			$total_vms = $cluster['cluster_vms'] + $cluster['resource_pool_vms'];
		//	echo "<tr class=row_${order} valign=top>";
		//	echo '<td class="tdleft">' . mkA ("<strong>${cluster['name']}</strong>", 'object', $cluster['id']) . '</td>';
		//	echo "<td class='tdleft'>${cluster['hypervisors']}</td>";
		//	echo "<td class='tdleft'>${cluster['resource_pools']}</td>";
		//	echo "<td class='tdleft'>${cluster['cluster_vms']}</td>";
		//	echo "<td class='tdleft'>${cluster['resource_pool_vms']}</td>";
		//	echo "<td class='tdleft'>$total_vms</td>";
		//	echo "</tr>\n";
			
			$clustersArr[] = array("order" => $order, "mka" => mkA ("<strong>${cluster['name']}</strong>", 'object', $cluster['id']),
								   "clusterHypervisors" => $cluster['hypervisors'], "clusterResPools" => $cluster['resource_pools'],
								   "clusterVM" => $cluster['cluster_vms'], "clusterResPoolVMs" => $cluster['resource_pool_vms'], 
								   "totalVMs" => $total_vms);
			$order = $nextorder[$order];
		}
		$mod->setOutput("clusterArray", $clustersArr);
			 
	//	echo "</table>\n";
	}
	//else
	//	echo '<b>No clusters exist</b>';
	//finishPortlet();

//	echo "</td><td class=pcright>";

	$pools = getVMResourcePoolSummary ();
	//startPortlet ('Resource Pools (' . count ($pools) . ')');
	$mod->setOutput("countResPools", count($pools));
		 
	if (count($pools) > 0)
	{
		$mod->setOutput("areResPools", true);
			 
	//	echo "<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>\n";
	//	echo "<tr><th>Pool</th><th>Cluster</th><th>VMs</th></tr>\n";
		$order = 'odd';
		$poolsArr = array();
		foreach ($pools as $pool)
		{
			$singPool = array("order" => $order, "mka" => mkA ("<strong>${pool['name']}</strong>", 'object', $pool['id']),
						  "poolVMs" => $pool['VMs']);
			//echo "<tr class=row_${order} valign=top>";
			//echo '<td class="tdleft">' . mkA ("<strong>${pool['name']}</strong>", 'object', $pool['id']) . '</td>';
			//echo '<td class="tdleft">';
			if ($pool['cluster_id'])
				$singPool['clusterID'] = mkA ("<strong>${pool['cluster_name']}</strong>", 'object', $pool['cluster_id']);
			//	echo mkA ("<strong>${pool['cluster_name']}</strong>", 'object', $pool['cluster_id']);
			//echo '</td>';
			//echo "<td class='tdleft'>${pool['VMs']}</td>";
			//echo "</tr>\n";
			$poolsArr[] = $singPool;
			$order = $nextorder[$order];

		}
		$mod->setOutput("poolsArray", $poolsArr);
			 
	//	echo "</table>\n";
	}
//	else
//		echo '<b>No pools exist</b>';
//	finishPortlet();

	//echo "</td></tr><tr><td class=pcleft>";

	$hypervisors = getVMHypervisorSummary ();
//	startPortlet ('Hypervisors (' . count ($hypervisors) . ')');
	$mod->setOutput("hypervisorCount", count($hypervisors));
		 
	if (count($hypervisors) > 0)
	{
		$mod->setOutput("areHypervisors", true);
			 
	//	echo "<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>\n";
	//	echo "<tr><th>Hypervisor</th><th>Cluster</th><th>VMs</th></tr>\n";
		$order = 'odd';
		$hypersArr = array();
		foreach ($hypervisors as $hypervisor)
		{
			$singHyper = array("order" => $order, "mka" => mkA ("<strong>${hypervisor['name']}</strong>", 'object', $hypervisor['id']),
						  "hyperVMs" => $hypervisor['VMs']);
		//	echo "<tr class=row_${order} valign=top>";
		//	echo '<td class="tdleft">' . mkA ("<strong>${hypervisor['name']}</strong>", 'object', $hypervisor['id']) . '</td>';
		//	echo '<td class="tdleft">';
			if ($hypervisor['cluster_id'])
				$singHyper['hyperID'] = mkA ("<strong>${hypervisor['cluster_name']}</strong>", 'object', $hypervisor['cluster_id']);
		//		echo mkA ("<strong>${hypervisor['cluster_name']}</strong>", 'object', $hypervisor['cluster_id']);
		//	echo '</td>';
		//	echo "<td class='tdleft'>${hypervisor['VMs']}</td>";
		//	echo "</tr>\n";
			$hypersArr[] = $singHyper;
			$order = $nextorder[$order];
		}
		$mod->setOutput("hypersArray", $hypersArr);
			 
	//	echo "</table>\n";
	}
//	else
//		echo '<b>No hypervisors exist</b>';
//	finishPortlet();

	//echo "</td><td class=pcright>";

	$switches = getVMSwitchSummary ();
//	startPortlet ('Virtual Switches (' . count ($switches) . ')');
	$mod->setOutput("countSwitches", count($switches));
		 
	if (count($switches) > 0)
	{
		$mod->setOutput("areSwitches", true);
			 
	//	echo "<table border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>\n";
	//	echo "<tr><th>Name</th></tr>\n";
		$order = 'odd';
		$switchesArr = array();
		foreach ($switches as $switch)
		{
		//	echo "<tr class=row_${order} valign=top>";
		//	echo '<td class="tdleft">' . mkA ("<strong>${switch['name']}</strong>", 'object', $switch['id']) . '</td>';
		//	echo "</tr>\n";
			$switchesArr[] = array("order" => $order, "mka" => mkA ("<strong>${switch['name']}</strong>", 'object', $switch['id']));
			$order = $nextorder[$order];
		}
		$mod->setOutput("switchesArray", $switchesArr);
			 
	//	echo "</table>\n";
	}
//	else
//		echo '<b>No virtual switches exist</b>';
//	finishPortlet();

//	echo "</td></tr></table>\n";
}

function switchportInfoJS($object_id, $parent = null, $placeholder = "switchportinfoJS")
{
	$available_ops = array
	(
		'link' => array ('op' => 'get_link_status', 'gw' => 'getportstatus'),
		'conf' => array ('op' => 'get_port_conf', 'gw' => 'get8021q'),
		'mac' =>  array ('op' => 'get_mac_list', 'gw' => 'getmaclist'),
	);
	$breed = detectDeviceBreed ($object_id);
	$allowed_ops = array();
	foreach ($available_ops as $prefix => $data)
		if
		(
			permitted ('object', 'liveports', $data['op']) and
			validBreedFunction ($breed, $data['gw'])
		)
			$allowed_ops[] = $prefix;

	// make JS array with allowed items
	$list = '';
	foreach ($allowed_ops as $item)
		$list .= "'" . addslashes ($item) . "', ";
	$list = trim ($list, ", ");

	$tplm = TemplateManager::getInstance();
	//if($parent==null)
		//$tplm->setTemplate("vanilla");
	
	if($parent==null)	
		$mod = $tplm->generateModule("SwitchPortInfoJS");
	else
		$mod = $tplm->generateSubmodule($placeholder, "SwitchPortInfoJS", $parent);
	
	$mod->setNamespace("");
	$mod->setOutput('List', $list);
	/*addJS ('js/jquery.thumbhover.js');
	addCSS ('css/jquery.contextmenu.css');
	addJS ('js/jquery.contextmenu.js');
	addJS ("enabled_elements = [ $list ];", TRUE);
	addJS ('js/portinfo.js');
	*/
	if($parent==null)
		return $mod->run();
}

// Formats VLAN packs: if they are different, the old appears stroken, and the new appears below it
// If comparing the two sets seems being complicated for human, this function generates a diff between old and new packs
function formatVLANPackDiff ($old, $current)
{
	$ret = '';
	$new_pack = serializeVLANPack ($current);
	$new_size = substr_count ($new_pack, ',');
	if (! same8021QConfigs ($old, $current))
	{
		$old_pack = serializeVLANPack ($old);
		$old_size = substr_count ($old_pack, ',');
		$ret .= '<s>' . $old_pack . '</s><br>';
		// make diff
		$added = groupIntsToRanges (array_diff ($current['allowed'], $old['allowed']));
		$removed = groupIntsToRanges (array_diff ($old['allowed'], $current['allowed']));
		if ($old['mode'] == $current['mode'] && $current['mode'] == 'trunk')
		{
			if (! empty ($added))
				$ret .= '<span class="vlan-diff diff-add">+ ' . implode (', ', $added) . '</span><br>';
			if (! empty ($removed))
				$ret .= '<span class="vlan-diff diff-rem">- ' . implode (', ', $removed) . '</span><br>';
		}
	}
	$ret .= $new_pack;
	return $ret;
}

function renderIPAddressLog ($ip_bin)
{
	/**startPortlet ('Log messages');
	echo '<table class="widetable" cellspacing="0" cellpadding="5" align="center" width="50%"><tr>';
	echo '<th>Date &uarr;</th>';
	echo '<th>User</th>';
	echo '<th>Log message</th>';
	echo '</tr>';*/
	
	$tplm = TemplateManager::getInstance();
	$tplm->setTemplate('vanilla');
	//$tplm->createMainModule();
	
	$mod = $tplm->generateSubmodule('Payload', 'IPAddressLog');
	$mod->setNamespace('ipaddress',true);
	$mod->setLock();
	
	$odd = FALSE;
	$out = array();
	foreach (array_reverse (fetchIPLogEntry ($ip_bin)) as $line)
	{
		$tr_class = $odd ? 'row_odd' : 'row_even';
		$out[] = array('Class'=>$tr_class,'Date'=>$line['date'],'User'=>$line['user'],'Message'=>$line['message']);
		/*
		echo "<tr class='$tr_class'>";
		echo '<td>' . $line['date'] . '</td>';
		echo '<td>' . $line['user'] . '</td>';
		echo '<td>' . $line['message'] . '</td>';
		echo '</tr>';*/
		$odd = !$odd;
	}
	$mod->addOutput('Messages', $out);
	
	//echo '</table>';
	//finishPortlet();
}

function renderObjectCactiGraphs ($object_id)
{
	function printNewItemTR ($options, $placeholder)
	{
		$smod = $tplm->generateSubmodule($placeholder, 'PrintNewItem', $mod);
		$smod->addOutput('Getselect', getSelect ($options, array ('name' => 'server_id')));
		// echo "<table cellspacing=\"0\" align=\"center\" width=\"50%\">";
		// echo "<tr><td>&nbsp;</td><th>Server</th><th>Graph ID</th><th>Caption</th><td>&nbsp;</td></tr>\n";
		// printOpFormIntro ('add');
		// echo "<tr><td>";
		// printImageHREF ('Attach', 'Link new graph', TRUE);
		// echo '</td><td>' . getSelect ($options, array ('name' => 'server_id'));
		// echo "</td><td><input type=text name=graph_id tabindex=100></td><td><input type=text name=caption tabindex=101></td><td>";
		// printImageHREF ('Attach', 'Link new graph', TRUE, 101);
		// echo "</td></tr></form>";
		// echo "</table>";
		// echo "<br/><br/>";

	}	

	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderObjectCactiGraphs");
	$mod->setNamespace("object", TRUE);



	if (!extension_loaded ('curl'))
		throw new RackTablesError ("The PHP cURL extension is not loaded.", RackTablesError::MISCONFIGURED);

	$servers = getCactiServers();
	$options = array();
	foreach ($servers as $server)
		$options[$server['id']] = "${server['id']}: ${server['base_url']}";
	// startPortlet ('Cacti Graphs');
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes' && permitted('object','cacti','add'))
		printNewItemTR ($options, 'NewTop');
	// echo "<table cellspacing=\"0\" cellpadding=\"10\" align=\"center\" width=\"50%\">";
	foreach (getCactiGraphsForObject ($object_id) as $graph_id => $graph)
	{
		$submod = $tplm->generateSubmodule('RowsTR', 'RowTR', $mod);
		// $munin_url = $servers[$graph['server_id']]['base_url'];
		$submod->addOutput('Cacti_Url', $servers[$graph['server_id']]['base_url']);
		$submod->addOutput('Graph_Id', $graph_id);
		$submod->addOutput('Object_Id', $object_id);
		$submod->addOutput('Server_Id', $graph['server_id']);
		$submod->addOutput('Caption', $graph['caption']);



		// $cacti_url = $servers[$graph['server_id']]['base_url'];
		// $text = "(graph ${graph_id} on server ${graph['server_id']})";
		// echo "<tr><td>";
		// echo "<a href='${cacti_url}/graph.php?action=view&local_graph_id=${graph_id}&rra_id=all' target='_blank'>";
		// echo "<img src='index.php?module=image&img=cactigraph&object_id=${object_id}&server_id=${graph['server_id']}&graph_id=${graph_id}' alt='${text}' title='${text}'></a></td><td>";
		if(permitted('object','cacti','del'))
			$submod->setOutput('Permitted', TRUE);
			// echo getOpLink (array ('op' => 'del', 'server_id' => $graph['server_id'], 'graph_id' => $graph_id), '', 'Cut', 'Unlink graph', 'need-confirmation');
		// echo "&nbsp; &nbsp;${graph['caption']}";
		// echo "</td></tr>";
	}
	echo '</table>';
	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes' && permitted('object','cacti','add'))
		printNewItemTR ($options, 'NewBottom');
	// finishPortlet ();
}

function renderObjectMuninGraphs ($object_id)
{
	function printNewItem ($options, $placeholder)
	{
		$smod = $tplm->generateSubmodule($placeholder, 'PrintNewItem', $mod);
		$smod->addOutput('Getselect', getSelect ($options, array ('name' => 'server_id')));
		// echo "<table cellspacing=\"0\" align=\"center\" width=\"50%\">";
		// echo "<tr><td>&nbsp;</td><th>Server</th><th>Graph</th><th>Caption</th><td>&nbsp;</td></tr>\n";
		// printOpFormIntro ('add');
		// echo "<tr><td>";
		// printImageHREF ('Attach', 'Link new graph', TRUE);
		// echo '</td><td>' . getSelect ($options, array ('name' => 'server_id'));
		// echo "</td><td><input type=text name=graph tabindex=100></td><td><input type=text name=caption tabindex=101></td><td>";
		// printImageHREF ('Attach', 'Link new graph', TRUE, 101);
		// echo "</td></tr></form>";
		// echo "</table>";
		// echo "<br/><br/>";
	}


	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderObjectMuninGraphs");
	$mod->setNamespace("object", TRUE);

	if (!extension_loaded ('curl'))
		throw new RackTablesError ("The PHP cURL extension is not loaded.", RackTablesError::MISCONFIGURED);

	$servers = getMuninServers();
	$options = array();
	foreach ($servers as $server)
		$options[$server['id']] = "${server['id']}: ${server['base_url']}";
	// startPortlet ('Munin Graphs');
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
		printNewItem ($options, 'NewTop');
	// echo "<table cellspacing=\"0\" cellpadding=\"10\" align=\"center\" width=\"50%\">";

	$object = spotEntity ('object', $object_id);
	list ($host, $domain) = preg_split ("/\./", $object['dname'], 2);

	foreach (getMuninGraphsForObject ($object_id) as $graph_name => $graph)
	{
		$submod = $tplm->generateSubmodule('Rows', 'Row', $mod);
		// $munin_url = $servers[$graph['server_id']]['base_url'];
		$submod->addOutput('Munin_Url', $servers[$graph['server_id']]['base_url']);
		$submod->addOutput('Domain', $domain);
		$submod->addOutput('Dname', $object['dname']);
		$submod->addOutput('Graph_Name', $graph_name);
		$submod->addOutput('Object_Id', $object_id);
		$submod->addOutput('Server_Id', $graph['server_id']);
		$submod->addOutput('Caption', $graph['caption']);

		// $text = "(graph ${graph_name} on server ${graph['server_id']})";
		// echo "<tr><td>";
		// echo "<a href='${munin_url}/${domain}/${object['dname']}/${graph_name}.html' target='_blank'>";
		// echo "<img src='index.php?module=image&img=muningraph&object_id=${object_id}&server_id=${graph['server_id']}&graph=${graph_name}' alt='${text}' title='${text}'></a></td>";
		// echo "<td>";
		// echo getOpLink (array ('op' => 'del', 'server_id' => $graph['server_id'], 'graph' => $graph_name), '', 'Cut', 'Unlink graph', 'need-confirmation');
		// echo "&nbsp; &nbsp;${graph['caption']}";
		// echo "</td></tr>";
	}
	// echo '</table>';
	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
		printNewItem ($options, 'NewBottom');
	// finishPortlet ();
}

function renderEditVlan ($vlan_ck)
{
	global $vtoptions;
	$vlan = getVLANInfo ($vlan_ck);

	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderEditVlan");
	$mod->setNamespace("vlan");
		

	//startPortlet ('Modify');
	//printOpFormIntro ('upd');
	// static attributes
	//echo '<table border=0 cellspacing=0 cellpadding=2 align=center>';
	//echo '<tr><th class=tdright>Name:</th><td class=tdleft>' .
	//	"<input type=text size=40 name=vlan_descr value='${vlan['vlan_descr']}'>" .
	//	'</td></tr>';
	$mod->addOutput("vlan_descr", $vlan['vlan_descr']);
		 
	//echo '<tr><th class=tdright>Type:</th><td class=tdleft>' .
	//	getSelect ($vtoptions, array ('name' => 'vlan_type', 'tabindex' => 102), $vlan['vlan_prop']) .
	//	'</td></tr>';
	$mod->addOutput("vtoptions", $vtoptions);
	$mod->addOutput("vlan_prop", $vlan['vlan_prop']); 
		 
	//echo '</table>';
	//echo '<p>';
	//echo '<input type="hidden" name="vdom_id" value="' . htmlspecialchars ($vlan['domain_id'], ENT_QUOTES) . '">';
	$mod->addOutput("htmlspcDomainID", htmlspecialchars ($vlan['domain_id'], ENT_QUOTES));	 
	//echo '<input type="hidden" name="vlan_id" value="' . htmlspecialchars ($vlan['vlan_id'], ENT_QUOTES) . '">';
	$mod->addOutput("htmlspcVlanID", htmlspecialchars ($vlan['vlan_id'], ENT_QUOTES));
	//printImageHREF ('SAVE', 'Update VLAN', TRUE);
	//echo '</form><p>';
	// get configured ports count
	$portc = 0;
	foreach (getVLANConfiguredPorts ($vlan_ck) as $subarray)
		$portc += count ($subarray);

	$clear_line = '';
	$delete_line = '';
	if ($portc)
	{
		$mod->addOutput("port", $portc);
		$mod->addOutput("mkaPortc", mkA ("${portc} ports", 'vlan', $vlan_ck));
		$mod->addOutput("isPortc", true);			 
	//	$clear_line .= '<p>';
	//	$clear_line .= getOpLink (array ('op' => 'clear'), 'remove', 'clear', "remove this VLAN from $portc ports") .
	//		' this VLAN from ' . mkA ("${portc} ports", 'vlan', $vlan_ck);
	}

	$reason = '';
	if ($vlan['vlan_id'] == VLAN_DFL_ID)
		$reason = "You can not delete default VLAN";
	elseif ($portc)
		$reason = "Can not delete: $portc ports configured";
	if (! empty ($reason))
		$mod->addOutput("reasonLink", getOpLink (NULL, 'delete VLAN', 'nodestroy', $reason)); 
	//	echo getOpLink (NULL, 'delete VLAN', 'nodestroy', $reason);
	else
		$mod->addOutput("reasonLink", getOpLink (array ('op' => 'del', 'vlan_ck' => $vlan_ck), 'delete VLAN', 'destroy'));
	//	echo getOpLink (array ('op' => 'del', 'vlan_ck' => $vlan_ck), 'delete VLAN', 'destroy');
	//echo $clear_line;
	//finishPortlet();
}

function renderExpirations ()
{
	global $nextorder;
	$breakdown = array();
	$breakdown[21] = array
	(
		array ('from' => -365, 'to' => 0, 'class' => 'has_problems_', 'title' => 'has expired within last year'),
		array ('from' => 0, 'to' => 30, 'class' => 'row_', 'title' => 'expires within 30 days'),
		array ('from' => 30, 'to' => 60, 'class' => 'row_', 'title' => 'expires within 60 days'),
		array ('from' => 60, 'to' => 90, 'class' => 'row_', 'title' => 'expires within 90 days'),
	);
	$breakdown[22] = $breakdown[21];
	$breakdown[24] = $breakdown[21];
	$attrmap = getAttrMap();

	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
			
	foreach ($breakdown as $attr_id => $sections)
	{	
		$mod = $tplm->generateSubmodule("Payload","RenderExpirations_main");
		$mod->setNamespace("reports");
		$mod->setOutput('AttrId', $attrmap[$attr_id]['name']);
		//startPortlet ($attrmap[$attr_id]['name']);
		$allSectsOut = array();
		foreach ($sections as $section)
		{
			$singleSectOut = array();
			$count = 1;
			$order = 'odd';
			$result = scanAttrRelativeDays ($attr_id, $section['from'], $section['to']);

		//	echo '<table align=center width=60% border=0 cellpadding=5 cellspacing=0 align=center class=cooltable>';
		//	echo "<caption>${section['title']}</caption>\n";
			$singleSectOut['Title'] = $section['title'];

			if (! count ($result))
			{
				$singleSectOut['CountMod'] = $tplm->generateModule('ExpirationsNoSection', true)->run();
			//	echo "<tr><td colspan=4>(none)</td></tr></table><br>\n";
				$allSectsOut[] = $singleSectOut;
				continue;
			}
			//echo '<tr valign=top><th align=center>Count</th><th align=center>Name</th>';
			//echo "<th align=center>Asset Tag</th><th align=center>OEM S/N 1</th><th align=center>Date Warranty <br> Expires</th></tr>\n";
			$singleSectOut['ResOut'] = '';
			foreach ($result as $row)
			{

				$res = $tplm->generateModule("RenderExpirations_result");
				$res->setNamespace("reports");


				$date_value = datetimestrFromTimestamp ($row['uint_value']);

				$object = spotEntity ('object', $row['object_id']);
				$attributes = getAttrValues ($object['id']);
				$oem_sn_1 = array_key_exists (1, $attributes) ? $attributes[1]['a_value'] : '&nbsp;';
				$res->setOutput("ClassOrder", $section['class'] . $order );
				$res->setOutput("Count", $count );	
				$res->setOutput("Mka", mkA ($object['dname'], 'object', $object['id']) );	 
				$res->setOutput("AssetNo", $object['asset_no'] );
				$res->setOutput("OemSn1", $oem_sn_1 );
				$res->setOutput("DateValue", $date_value );
			//	echo '<tr class=' . $section['class'] . $order . ' valign=top>';
			//	echo "<td>${count}</td>";
			//	echo '<td>' . mkA ($object['dname'], 'object', $object['id']) . '</td>';
			//	echo "<td>${object['asset_no']}</td>";
			//	echo "<td>${oem_sn_1}</td>";
			//	echo "<td>${date_value}</td>";
			//	echo "</tr>\n";
				

				$singleSectOut['resOut'] .= $res->run();
				$order = $nextorder[$order];
				$count++;

	
			}

			$allSectsOut[] = $singleSectOut;
			//echo "</table><br>\n";
		}
	
		$mod->setOutput("AllSects", $allSectsOut);
		//finishPortlet ();
	}
}

// returns an array with two items - each is HTML-formatted <TD> tag
function formatPortReservation ($port)
{
	$ret = array();
	$ret[] = '<td class=tdleft>' .
		(strlen ($port['reservation_comment']) ? formatLoggedSpan ($port['last_log'], 'Reserved:', 'strong underline') : '').
		'</td>';
	$editable = permitted ('object', 'ports', 'editPort')
		? 'editable'
		: '';
	$ret[] = '<td class=tdleft>' .
		formatLoggedSpan ($port['last_log'], $port['reservation_comment'], "rsvtext $editable id-${port['id']} op-upd-reservation-port") .
		'</td>';
	return $ret;
}

function renderEditUCSForm()
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule();
	$mod = $tplm->generateSubmodule("Payload", "RenderEditUCSForm");
	$mod->setNamespace("object",true);

	// startPortlet ('UCS Actions');
	// printOpFormIntro ('autoPopulateUCS');
	// echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
	// echo "<tr><th class=tdright><label for=ucs_login>Login:</label></th>";
	// echo "<td class=tdleft colspan=2><input type=text name=ucs_login id=ucs_login></td></tr>\n";
	// echo "<tr><th class=tdright><label for=ucs_password>Password:</label></th>";
	// echo "<td class=tdleft colspan=2><input type=password name=ucs_password id=ucs_password></td></tr>\n";
	// echo "<tr><th colspan=3><input type=checkbox name=use_terminal_settings id=use_terminal_settings>";
	// echo "<label for=use_terminal_settings>Use Credentials from terminal_settings()</label></th></tr>\n";
	// echo "<tr><th class=tdright>Actions:</th><td class=tdleft>";
	// printImageHREF ('DQUEUE sync_ready', 'Auto-populate UCS', TRUE);
	// echo '</td><td class=tdright>';
	// echo getOpLink (array ('op' => 'cleanupUCS'), '', 'CLEAR', 'Clean-up UCS domain', 'need-confirmation');
	// echo "</td></tr></table></form>\n";
	// finishPortlet();
}

function renderCactiConfig()
{
	$servers = getCactiServers();
	
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule();
	$mod = $tplm->generateSubmodule("Payload", "CactiConfig");
	$mod->setNamespace("cacti",true);
	$mod->setLock();
	
	$mod->addOutput("Count", count($servers));
	
	//startPortlet ('Cacti servers (' . count ($servers) . ')');
	//echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
	//echo '<tr><th>base URL</th><th>username</th><th>graph(s)</th></tr>';
	foreach ($servers as $server)
	{
		$smod = $tplm->generateSubmodule("CactiList", "CactiConfigRow", $mod);
		$smod->addOutput("BaseUrl", $server['base_url']);
		$smod->addOutput("Username", $server['username']);
		$smod->addOutput("NumGraphs", $server['num_graphs']);
		//echo '<tr align=left valign=top><td>' . niftyString ($server['base_url']) . '</td>';
		//echo "<td>${server['username']}</td><td class=tdright>${server['num_graphs']}</td></tr>";
	}
	//echo '</table>';
	//finishPortlet();
}

function renderCactiServersEditor()
{
	function printNewItemTR ($parent, $plc)
	{
		$tplm = TemplateManager::getInstance();
		$smod2 = $tplm->generateSubmodule($plc, 'CactiConfigEditorNew', $parent);
		$smod2->setNamespace('cacti');
		$smod2->setLock(true);
		
		//printOpFormIntro ('add');
		//echo '<tr>';
		//echo '<td>' . getImageHREF ('create', 'add a new server', TRUE, 112) . '</td>';
		//echo '<td><input type=text size=48 name=base_url tabindex=101></td>';
		//echo '<td><input type=text size=24 name=username tabindex=102></td>';
		//echo '<td><input type=password size=24 name=password tabindex=103></td>';
		//echo '<td>&nbsp;</td>';
		//echo '<td>' . getImageHREF ('create', 'add a new server', TRUE, 111) . '</td>';
		//echo '</tr></form>';
	}
	//echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
	//echo '<tr><th>&nbsp;</th><th>base URL</th><th>username</th><th>password</th><th>graph(s)</th><th>&nbsp;</th></tr>';
	
	$tplm = TemplateManager::getInstance();
	$tplm->setTemplate('vanilla');
	//$tplm->createMainModule();
	
	$mod = $tplm->generateSubmodule('Payload', 'CactiConfigEditor');
	$mod->setNamespace('cacti',true);
	$mod->setLock();
	
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
		printNewItemTR($mod,'AddNewTop');
	foreach (getCactiServers() as $server)
	{
		$smod = $tplm->generateSubmodule('List', 'CactiConfigEditorRow', $mod);
		//printOpFormIntro ('upd', array ('id' => $server['id']));
		$smod->addOutput('Id', $server['id']);
		//echo '<tr><td>';
		//if ($server['num_graphs'])
			//$smod->addOutput('NumGraphs', true);
			//printImageHREF ('nodestroy', 'cannot delete, graphs exist');
		//else
			
			//echo getOpLink (array ('op' => 'del', 'id' => $server['id']), '', 'destroy', 'delete this server');
		$smod->addOutput('NumGraphs', $server['num_graphs']);
		$smod->addOutput('BaseUrl', htmlspecialchars ($server['base_url'], ENT_QUOTES, 'UTF-8'));
		$smod->addOutput('Username', htmlspecialchars ($server['username'], ENT_QUOTES, 'UTF-8'));
		$smod->addOutput('Password', htmlspecialchars ($server['password'], ENT_QUOTES, 'UTF-8'));
		//echo '<td><input type=text size=48 name=base_url value="' . htmlspecialchars ($server['base_url'], ENT_QUOTES, 'UTF-8') . '"></td>';
		//echo '<td><input type=text size=24 name=username value="' . htmlspecialchars ($server['username'], ENT_QUOTES, 'UTF-8') . '"></td>';
		//echo '<td><input type=password size=24 name=password value="' . htmlspecialchars ($server['password'], ENT_QUOTES, 'UTF-8') . '"></td>';
		//echo "<td class=tdright>${server['num_graphs']}</td>";
		//echo '<td>' . getImageHREF ('save', 'update this server', TRUE) . '</td>';
		//echo '</tr></form>';
	}
	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
		printNewItemTR($mod,'AddNewBottom');
	//echo '</table>';
}

function renderMuninConfig()
{
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderMuninConfig");
	$mod->setNamespace("munin");
		
	$servers = getMuninServers();
	//startPortlet ('Munin servers (' . count ($servers) . ')');
	$mod->addOutput("ServerCount", count ($servers));
		 
	//echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
	//echo '<tr><th>base URL</th><th>graph(s)</th></tr>';
	$allServersOut = array();
	foreach ($servers as $server)
	{
		$allServersOut[] = array('NiftyStr' => niftyString ($server['base_url']), 'NumGraphs' => $server['num_graphs'] );
		//echo '<tr align=left valign=top><td>' . niftyString ($server['base_url']) . '</td>';
		//echo "<td class=tdright>${server['num_graphs']}</td></tr>";
	}
	$mod->addOutput("allServers", $allServersOut);
		 
	//echo '</table>';
	//finishPortlet();
}

function renderMuninServersEditor()
{
	function printNewItemTR()
	{
		$tplm = TemplateManager::getInstance();
		//$tplm->setTemplate("vanilla");
		
		$mod = $tplm->generateModule("RenderMuninServersEditor_NewItem");
		$mod->setNamespace("munin");
		
		return $mod->run();
		//printOpFormIntro ('add');
		//echo '<tr>';
		//echo '<td>' . getImageHREF ('create', 'add a new server', TRUE, 112) . '</td>';
		//echo '<td><input type=text size=48 name=base_url tabindex=101></td>';
		//echo '<td>&nbsp;</td>';
		//echo '<td>' . getImageHREF ('create', 'add a new server', TRUE, 111) . '</td>';
		//echo '</tr></form>';
	}
	$tplm = TemplateManager::getInstance();
	//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule("index");
	
	$mod = $tplm->generateSubmodule("Payload","RenderMuninServersEditor");
	$mod->setNamespace("munin");
		
	//echo '<table cellspacing=0 cellpadding=5 align=center class=widetable>';
	//echo '<tr><th>&nbsp;</th><th>base URL</th><th>graph(s)</th><th>&nbsp;</th></tr>';
	if (getConfigVar ('ADDNEW_AT_TOP') == 'yes')
	//	printNewItemTR();
		$mod->addOutput("AddNewTop", printNewItemTR());
	
	$allMuninServersOut = array();		 
	foreach (getMuninServers() as $server)
	{
		$singleServer = array(  'FormIntro' => printOpFormIntro ('upd', array ('id' => $server['id'])),
								'SpecialCharSrv' => htmlspecialchars ($server['base_url'], ENT_QUOTES, 'UTF-8'),
								'ImageSave' => getImageHREF ('save', 'update this server', TRUE),
								'NumGraphs' => $server['num_graphs']);

	//	printOpFormIntro ('upd', array ('id' => $server['id']));
	//	echo '<tr><td>';
		if ($server['num_graphs'])
			$singleServer['DestroyImg'] = printImageHREF ('nodestroy', 'cannot delete, graphs exist');
		//	printImageHREF ('nodestroy', 'cannot delete, graphs exist');
		else
			$singleServer['DestroyImg'] = getOpLink (array ('op' => 'del', 'id' => $server['id']), '', 'destroy', 'delete this server');
		//	echo getOpLink (array ('op' => 'del', 'id' => $server['id']), '', 'destroy', 'delete this server');
		//echo '</td>';
		//echo '<td><input type=text size=48 name=base_url value="' . htmlspecialchars ($server['base_url'], ENT_QUOTES, 'UTF-8') . '"></td>';
		//echo "<td class=tdright>${server['num_graphs']}</td>";
		//echo '<td>' . getImageHREF ('save', 'update this server', TRUE) . '</td>';
		//echo '</tr></form>';
		$allMinuslinesOut[] = $singleServer;
	}
	$mod->addOutput("allMuninServers", $allMuninServersOut);
		 
	if (getConfigVar ('ADDNEW_AT_TOP') != 'yes')
	//	printNewItemTR();
		$mod->addOutput("AddNewBottom", printNewItemTR());
	//echo '</table>';
}

// The validity of some data cannot be guaranteed using foreign keys.
// Display any invalid rows that have crept in.
// TODO:
//    - check for IP addresses whose subnet does not exist in IPvXNetwork (X = 4 or 6)
//        - IPvXAddress, IPvXAllocation, IPvXLog, IPvXRS, IPvXVS
//    - provide links/buttons to delete invalid rows
//    - verify that the current DDL is correct for each DB element
//        - columns, indexes, foreign keys, views, character sets
function renderDataIntegrityReport ()
{
	global $nextorder;
	$violations = FALSE;

	$tplm = TemplateManager::getInstance();
	//if($parent==null)
		//$tplm->setTemplate("vanilla");
	//$tplm->createMainModule();

	$mod = $tplm->generateSubmodule("Payload", "RenderDataIntegrityReport");
	
	$mod->setNamespace("reports");

	// check 1: EntityLink rows referencing not-existent relatives
	// check 1.1: children 
	$realms = array
	(
		'location' => 'Location',
		'object' => 'RackObject',
		'rack' => 'Rack',
		'row' => 'Row'
	);
	$orphans = array ();
	foreach ($realms as $realm => $table)
	{ 
		$result = usePreparedSelectBlade
		(
			'SELECT EL.* FROM EntityLink EL ' .
			"LEFT JOIN ${table} ON EL.child_entity_id = ${table}.id " .
			"WHERE EL.child_entity_type = ? AND ${table}.id IS NULL",
			array ($realm)
		);
		$rows = $result->fetchAll (PDO::FETCH_ASSOC);
		unset ($result);
		$orphans = array_merge ($orphans, $rows);
	}

	if (count ($orphans))
	{
		$mod->setOutput("ChildrenViolation", true);
		$mod->setOutput("ChildrenCount", count ($orphans));
			 
			 
		$violations = TRUE;
		//startPortlet ('EntityLink: Missing Children (' . count ($orphans) . ')');
		//echo "<table cellpadding=5 cellspacing=0 align=center class=cooltable>\n";
		//echo "<tr><th>Parent</th><th>Child Type</th><th>Child ID</th></tr>\n";
		$order = 'odd';
		$allChildrenOrphansOut = array();
		foreach ($orphans as $orphan)
		{	
			$singleOrphanOut = array('Order' => $order, 'RealmName' => $realm_name);

			$realm_name = formatRealmName ($orphan['parent_entity_type']);
			$parent = spotEntity ($orphan['parent_entity_type'], $orphan['parent_entity_id']);
		//	echo "<tr class=row_${order}>";
		//	echo "<td>${realm_name}: ${parent['name']}</td>";
		//	echo "<td>${orphan['child_entity_type']}</td>";
		//	echo "<td>${orphan['child_entity_id']}</td>";
		//	echo "</tr>\n";
			$singleOrphanOut['ElemName'] = $parent['name'];
			$singleOrphanOut['EntityType'] = $orphan['child_entity_type'];
			$singleOrphanOut['EntityId'] = $orphan['child_entity_id'];
			
			$order = $nextorder[$order];
			$allChildrenOrphansOut[] = $singleOrphanOut;
		}
		$mod->setOutput("ChildrenOrphans", $allChildrenOrphansOut);
			 
		//echo "</table>\n";
		//finishPortLet ();
	}

	// check 1.2: parents 
	$orphans = array ();
	foreach ($realms as $realm => $table)
	{ 
		$result = usePreparedSelectBlade
		(
			'SELECT EL.* FROM EntityLink EL ' .
			"LEFT JOIN ${table} ON EL.parent_entity_id = ${table}.id " .
			"WHERE EL.parent_entity_type = ? AND ${table}.id IS NULL",
			array ($realm)
		);
		$rows = $result->fetchAll (PDO::FETCH_ASSOC);
		unset ($result);
		$orphans = array_merge ($orphans, $rows);
	}
	if (count ($orphans))
	{
		$mod->setOutput("ParentsViolation", true);
		$mod->setOutput("ParentsCount", count ($orphans));

		$violations = TRUE;
//		startPortlet ('EntityLink: Missing Parents (' . count ($orphans) . ')');
//		echo "<table cellpadding=5 cellspacing=0 align=center class=cooltable>\n";
//		echo "<tr><th>Child</th><th>Parent Type</th><th>Parent ID</th></tr>\n";
		$order = 'odd';
		$allParentsOrphansOut = array();
		foreach ($orphans as $orphan)
		{
			$singleOrphanOut = array('order' => $order, 'realm_name' => $realm_name);

			$realm_name = formatRealmName ($orphan['child_entity_type']);
			$child = spotEntity ($orphan['child_entity_type'], $orphan['child_entity_id']);
//			echo "<tr class=row_${order}>";
//			echo "<td>${realm_name}: ${child['name']}</td>";
//			echo "<td>${orphan['parent_entity_type']}</td>";
//			echo "<td>${orphan['parent_entity_id']}</td>";
//			echo "</tr>\n";

			$singleOrphanOut['elemName'] = $child['name'];
			$singleOrphanOut['entity_type'] = $orphan['parent_entity_type'];
			$singleOrphanOut['entity_id'] = $orphan['parent_entity_id'];
			
			$order = $nextorder[$order];
			$allParentsOrphansOut[] = $singleOrphanOut;
		}
//		echo "</table>\n";

//		finishPortLet ();
		$mod->setOutput("ParentOrphans", $allParentsOrphansOut);
	}

	// check 3: multiple tables referencing non-existent dictionary entries
	// check 3.1: AttributeMap
	$orphans = array ();
	$result = usePreparedSelectBlade
	(
		'SELECT AM.*, A.name AS attr_name, C.name AS chapter_name ' . 
		'FROM AttributeMap AM ' .
		'LEFT JOIN Attribute A ON AM.attr_id = A.id ' .
		'LEFT JOIN Chapter C ON AM.chapter_id = C.id ' .
		'LEFT JOIN Dictionary D ON AM.objtype_id = D.dict_key ' .
		'WHERE D.dict_key IS NULL'
	);
	$orphans = $result->fetchAll (PDO::FETCH_ASSOC);
	unset ($result);

	if (count ($orphans))
	{
		$mod->setOutput("AttrMapViolation", true);
		$mod->setOutput("AttrMapCount", count ($orphans));

		$violations = TRUE;
	//	startPortlet ('AttributeMap: Invalid Mappings (' . count ($orphans) . ')');
	//	echo "<table cellpadding=5 cellspacing=0 align=center class=cooltable>\n";
	//	echo "<tr><th>Attribute</th><th>Chapter</th><th>Object TypeID</th></tr>\n";
		$order = 'odd';
		$allAttrMapOrphansOut = array();
		foreach ($orphans as $orphan)
		{
			$singleOrphanOut = array('Order' => $order);
		//	echo "<tr class=row_${order}>";
		//	echo "<td>${orphan['attr_name']}</td>";
		//	echo "<td>${orphan['chapter_name']}</td>";
		//	echo "<td>${orphan['objtype_id']}</td>";
		//	echo "</tr>\n";
			$singleOrphanOut['AttrName'] = $orphan['attr_name'];
			$singleOrphanOut['ChapterName'] = $orphan['chapter_name'];
			$singleOrphanOut['ObjtypeId'] = $orphan['objtype_id'];
			$allAttrMapOrphansOut[] = $singleOrphanOut;
			$order = $nextorder[$order];
		}
	//	echo "</table>\n";
	//	finishPortLet ();
		$mod->setOutput("AttrMapOrphans", $allAttrMapOrphansOut);
	}

	// check 3.2: Object
	$orphans = array ();
	$result = usePreparedSelectBlade
	(
		'SELECT O.* FROM Object O ' .
		'LEFT JOIN Dictionary D ON O.objtype_id = D.dict_key ' .
		'WHERE D.dict_key IS NULL'
	);
	$orphans = $result->fetchAll (PDO::FETCH_ASSOC);
	unset ($result);
	
	if (count ($orphans))
	{
		$mod->setOutput("ObjectViolation", true);
		$mod->setOutput("ObjectCount", count ($orphans));

		$violations = TRUE;
	//	startPortlet ('Object: Invalid Types (' . count ($orphans) . ')');
	//	echo "<table cellpadding=5 cellspacing=0 align=center class=cooltable>\n";
	//	echo "<tr><th>ID</th><th>Name</th><th>Type ID</th></tr>\n";
		$order = 'odd';
		$allObjectsOut = array();
		foreach ($orphans as $orphan)
		{
			$singleOrphanOut = array('Order' => $order);
			$singleOrphanOut['Id'] = $orphan['id'];
			$singleOrphanOut['Name'] = $orphan['name'];
			$singleOrphanOut['ObjtypeId'] = $orphan['objtype_id'];
			$allObjectsOut[] = $singleOrphanOut;
	//		echo "<tr class=row_${order}>";
	//		echo "<td>${orphan['id']}</td>";
	//		echo "<td>${orphan['name']}</td>";
	//		echo "<td>${orphan['objtype_id']}</td>";
	//		echo "</tr>\n";
			$order = $nextorder[$order];
		}
	//	echo "</table>\n";
	//	finishPortLet ();
		$mod->setOutput("AllObjectsOrphans", $allObjectsOut);
	}

	// check 3.3: ObjectHistory
	$orphans = array ();
	$result = usePreparedSelectBlade
	(
		'SELECT OH.* FROM ObjectHistory OH ' .
		'LEFT JOIN Dictionary D ON OH.objtype_id = D.dict_key ' .
		'WHERE D.dict_key IS NULL'
	);
	$orphans = $result->fetchAll (PDO::FETCH_ASSOC);
	unset ($result);
	if (count ($orphans))
	{
		$mod->setOutput("ObjectHistViolation", true);
		$mod->setOutput("ObjectHistCount", count ($orphans));	
		
		$violations = TRUE;
	//	startPortlet ('ObjectHistory: Invalid Types (' . count ($orphans) . ')');
	//	echo "<table cellpadding=5 cellspacing=0 align=center class=cooltable>\n";
	//	echo "<tr><th>ID</th><th>Name</th><th>Type ID</th></tr>\n";
		$order = 'odd';
		$allObjectHistsOut = array();
		foreach ($orphans as $orphan)
		{
			$singleOrphanOut = array('Order' => $order);
			$singleOrphanOut['Id'] = $orphan['id'];
			$singleOrphanOut['Name'] = $orphan['name'];
			$singleOrphanOut['ObjtypeId'] = $orphan['objtype_id'];
			$allObjectHistsOut[] = $singleOrphanOut;
		//	echo "<tr class=row_${order}>";
		//	echo "<td>${orphan['id']}</td>";
		//	echo "<td>${orphan['name']}</td>";
		//	echo "<td>${orphan['objtype_id']}</td>";
		//	echo "</tr>\n";
			$order = $nextorder[$order];
		}
	//	echo "</table>\n";
	//	finishPortLet ();
		$mod->setOutput("AllObjectHistsOrphans", $allObjectHistsOut);
	}
	

	// check 3.4: ObjectParentCompat
	$orphans = array ();
	$result = usePreparedSelectBlade
	(
		'SELECT OPC.*, PD.dict_value AS parent_name, CD.dict_value AS child_name '.
		'FROM ObjectParentCompat OPC ' .
		'LEFT JOIN Dictionary PD ON OPC.parent_objtype_id = PD.dict_key ' .
		'LEFT JOIN Dictionary CD ON OPC.child_objtype_id = CD.dict_key ' . 
		'WHERE PD.dict_key IS NULL OR CD.dict_key IS NULL'
	);
	$orphans = $result->fetchAll (PDO::FETCH_ASSOC);
	unset ($result);
	if (count ($orphans))
	{
		$mod->setOutput("ObjectParViolation", true);
		$mod->setOutput("ObjectParCount", count ($orphans));	

		$violations = TRUE;
	//	startPortlet ('Object Container Compatibility rules: Invalid Parent or Child Type (' . count ($orphans) . ')');
	//	echo "<table cellpadding=5 cellspacing=0 align=center class=cooltable>\n";
	//	echo "<tr><th>Parent</th><th>Parent Type ID</th><th>Child</th><th>Child Type ID</th></tr>\n";
		$order = 'odd';
		$allObjectParsOut = array();
		foreach ($orphans as $orphan)
		{
			$singleOrphanOut = array('Order' => $order);
			$singleOrphanOut['ParentName'] = $orphan['parent_name'];
			$singleOrphanOut['ParentObjtypeId'] = $orphan['parent_objtype_id'];
			$singleOrphanOut['ChildName'] = $orphan['child_name'];
			$singleOrphanOut['ChildObjtypeId'] = $orphan['child_objtype_id'];
			$allObjectParsOut[] = $singleOrphanOut;
		//	echo "<tr class=row_${order}>";
		//	echo "<td>${orphan['parent_name']}</td>";
		//	echo "<td>${orphan['parent_objtype_id']}</td>";
		//	echo "<td>${orphan['child_name']}</td>";
		//	echo "<td>${orphan['child_objtype_id']}</td>";
		//	echo "</tr>\n";
			$order = $nextorder[$order];
		}
	//	echo "</table>\n";
	//	finishPortLet ();#
		$mod->setOutput("AllObjectParsOrphans", $allObjectParsOut);
	}

	// check 3.5: PortCompat
	$orphans = array ();
	$result = usePreparedSelectBlade
	(
		'SELECT PC.*, 1D.dict_value AS type1_name, 2D.dict_value AS type2_name ' .
		'FROM PortCompat PC ' .
		'LEFT JOIN Dictionary 1D ON PC.type1 = 1D.dict_key ' .
		'LEFT JOIN Dictionary 2D ON PC.type2 = 2D.dict_key ' .
		'WHERE 1D.dict_key IS NULL OR 2D.dict_key IS NULL'
	);
	$orphans = $result->fetchAll (PDO::FETCH_ASSOC);
	unset ($result);
	if (count ($orphans))
	{
		$mod->setOutput("PortCompatViolation", true);
		$mod->setOutput("PortCompatCount", count ($orphans));	

		$violations = TRUE;
	//	startPortlet ('Port Compatibility rules: Invalid From or To Type (' . count ($orphans) . ')');
	//	echo "<table cellpadding=5 cellspacing=0 align=center class=cooltable>\n";
	//	echo "<tr><th>From</th><th>From Type ID</th><th>To</th><th>To Type ID</th></tr>\n";
		$order = 'odd';
		$allPortCompsOut = array();
		foreach ($orphans as $orphan)
		{
			$singleOrphanOut = array('Order' => $order);
			$singleOrphanOut['Type1Name'] = $orphan['type1_name'];
			$singleOrphanOut['Type1'] = $orphan['type1'];
			$singleOrphanOut['Type2Name'] = $orphan['type2_name'];
			$singleOrphanOut['Type2'] = $orphan['type2'];
			$allPortCompsOut[] = $singleOrphanOut;
		//	echo "<tr class=row_${order}>";
		//	echo "<td>${orphan['type1_name']}</td>";
		//	echo "<td>${orphan['type1']}</td>";
		//	echo "<td>${orphan['type2_name']}</td>";
		//	echo "<td>${orphan['type2']}</td>";
		//	echo "</tr>\n";
			$order = $nextorder[$order];
		}
	//	echo "</table>\n";
	//	finishPortLet ();
		$mod->setOutput("AllPortCompsOrphans", $allallPortCompsOutsOut);
	}

	// check 3.6: PortInterfaceCompat
	$orphans = array ();
	$result = usePreparedSelectBlade
	(
		'SELECT PIC.*, PII.iif_name ' .
		'FROM PortInterfaceCompat PIC ' .
		'LEFT JOIN PortInnerInterface PII ON PIC.iif_id = PII.id ' .
		'LEFT JOIN Dictionary D ON PIC.oif_id = D.dict_key ' .
		'WHERE D.dict_key IS NULL'
	);
	$orphans = $result->fetchAll (PDO::FETCH_ASSOC);
	unset ($result);
	if (count ($orphans))
	{
		$mod->setOutput("PortInterViolation", true);
		$mod->setOutput("PortInterCount", count ($orphans));	

		$violations = TRUE;
	//	startPortlet ('Enabled Port Types: Invalid Outer Interface (' . count ($orphans) . ')');
	//	echo "<table cellpadding=5 cellspacing=0 align=center class=cooltable>\n";
	//	echo "<tr><th>Inner Interface</th><th>Outer Interface ID</th></tr>\n";
		$order = 'odd';
		$allPortIntersOut = array();
		foreach ($orphans as $orphan)
		{	
			$singleOrphanOut = array('Order' => $order);
			$singleOrphanOut['IifName'] = $orphan['iif_name'];
			$singleOrphanOut['OifId'] = $orphan['oif_id'];
			$allPortIntersOut[] = $singleOrphanOut;
	//		echo "<tr class=row_${order}>";
	//		echo "<td>${orphan['iif_name']}</td>";
	//		echo "<td>${orphan['oif_id']}</td>";
	//		echo "</tr>\n";
			$order = $nextorder[$order];
		}
	//	echo "</table>\n";
	//	finishPortLet ();
		$mod->setOutput("AllPortIntersOrphans", $allPortIntersOut);
	}

	// check 4: relationships that violate ObjectParentCompat Rules
	$invalids = array ();
	$result = usePreparedSelectBlade
	(
		'SELECT CO.id AS child_id, CO.objtype_id AS child_type_id, CD.dict_value AS child_type, CO.name AS child_name, ' . 
		'PO.id AS parent_id, PO.objtype_id AS parent_type_id, PD.dict_value AS parent_type, PO.name AS parent_name ' .
		'FROM Object CO ' .
		'LEFT JOIN EntityLink EL ON CO.id = EL.child_entity_id ' .
		'LEFT JOIN Object PO ON EL.parent_entity_id = PO.id ' .
		'LEFT JOIN ObjectParentCompat OPC ON PO.objtype_id = OPC.parent_objtype_id ' .
		'LEFT JOIN Dictionary PD ON PO.objtype_id = PD.dict_key ' .
		'LEFT JOIN Dictionary CD ON CO.objtype_id = CD.dict_key ' .
		"WHERE EL.parent_entity_type = 'object' AND EL.child_entity_type = 'object' " .
		'AND OPC.parent_objtype_id IS NULL'
	);
	$invalids = $result->fetchAll (PDO::FETCH_ASSOC);
	unset ($result);
	if (count ($invalids))
	{
		$mod->setOutput("ObjectParRuleViolation", true);
		$mod->setOutput("ObjectParRuleCount", count ($invalids));

		$violations = TRUE;
	//	startPortlet ('Objects: Violate Object Container Compatibility rules (' . count ($invalids) . ')');
	//	echo "<table cellpadding=5 cellspacing=0 align=center class=cooltable>\n";
	//	echo "<tr><th>Contained Obj Name</th><th>Contained Obj Type</th><th>Container Obj Name</th><th>Container Obj Type</th></tr>\n";
		$order = 'odd';
		$allObjectParRulesOut = array();
		foreach ($invalids as $invalid)
		{
			$singleOrphanOut = array('Order' => $order);
			$singleOrphanOut['ChildName'] = $invalid['child_name'];
			$singleOrphanOut['Child_type'] = $invalid['child_type'];
			$singleOrphanOut['ParentName'] = $invalid['parent_name'];
			$singleOrphanOut['ParentType'] = $invalid['parent_type'];
			$allObjectParRulesOut[] = $singleOrphanOut;
	//		echo "<tr class=row_${order}>";
	//		echo "<td>${invalid['child_name']}</td>";
	//		echo "<td>${invalid['child_type']}</td>";
	//		echo "<td>${invalid['parent_name']}</td>";
	//		echo "<td>${invalid['parent_type']}</td>";
	//		echo "</tr>\n";
			$order = $nextorder[$order];
		}
	//	echo "</table>\n";
	//	finishPortLet ();

		$mod->setOutput("AllObjectParRulesOrphans", $allObjectParRulesOut);
	}

	// check 5: Links that violate PortCompat Rules
	$invalids = array ();
	$result = usePreparedSelectBlade
	(
		'SELECT OA.id AS obja_id, OA.name AS obja_name, L.porta AS porta_id, PA.name AS porta_name, DA.dict_value AS porta_type, ' . 
		'OB.id AS objb_id, OB.name AS objb_name, L.portb AS portb_id, PB.name AS portb_name, DB.dict_value AS portb_type ' .
		'FROM Link L ' .
		'LEFT JOIN Port PA ON L.porta = PA.id ' .
		'LEFT JOIN Object OA ON PA.object_id = OA.id ' .
		'LEFT JOIN Dictionary DA ON PA.type = DA.dict_key ' .
		'LEFT JOIN Port PB ON L.portb = PB.id ' .
		'LEFT JOIN Object OB ON PB.object_id = OB.id ' .
		'LEFT JOIN Dictionary DB ON PB.type = DB.dict_key ' .
		'LEFT JOIN PortCompat PC on PA.type = PC.type1 AND PB.type = PC.type2 ' .
		'WHERE PC.type1 IS NULL OR PC.type2 IS NULL'
	);
	$invalids = $result->fetchAll (PDO::FETCH_ASSOC);
	unset ($result);
	if (count ($invalids))
	{
		$mod->setOutput("PortCompatRuleViolation", true);
		$mod->setOutput("PortCompatRuleCount", count ($invalids));

		$violations = TRUE;
	//	startPortlet ('Port Links: Violate Port Compatibility Rules (' . count ($invalids) . ')');
	//	echo "<table cellpadding=5 cellspacing=0 align=center class=cooltable>\n";
	//	echo "<tr><th>Object A</th><th>Port A Name</th><th>Port A Type</th><th>Object B</th><th>Port B Name</th><th>Port B Type</th></tr>\n";
		$order = 'odd';
		$allPortCompatRulesOut = array();
		foreach ($invalids as $invalid)
		{
			$singleOrphanOut = array('Order' => $order);
			$singleOrphanOut['ObjaName'] = $invalid['obja_name'];
			$singleOrphanOut['PortaName'] = $invalid['porta_name'];
			$singleOrphanOut['PortaType'] = $invalid['porta_type'];
			$singleOrphanOut['ObjbName'] = $invalid['objb_name'];
			$singleOrphanOut['PortbName'] = $invalid['portb_name'];
			$singleOrphanOut['PortbType'] = $invalid['portb_type'];
			
			$allPortCompatRulesOut[] = $singleOrphanOut;
	/*		echo "<tr class=row_${order}>";
			echo "<td>${invalid['obja_name']}</td>";
			echo "<td>${invalid['porta_name']}</td>";
			echo "<td>${invalid['porta_type']}</td>";
			echo "<td>${invalid['objb_name']}</td>";
			echo "<td>${invalid['portb_name']}</td>";
			echo "<td>${invalid['portb_type']}</td>";
			echo "</tr>\n";
	*/		$order = $nextorder[$order];
		}
		echo "</table>\n";
		finishPortLet ();

		$mod->setOutput("AllPortCompatRulesOrphans", $allPortCompatRulesOut);
	}

	// check 6: TagStorage rows referencing non-existent parents 
	$realms = array
	(
		'file' => array ('table' => 'File', 'column' => 'id'),
		'ipv4net' => array ('table' => 'IPv4Network', 'column' => 'id'),
		'ipv4rspool' => array ('table' => 'IPv4RSPool', 'column' => 'id'),
		'ipv4vs' => array ('table' => 'IPv4VS', 'column' => 'id'),
		'ipv6net' => array ('table' => 'IPv6Network', 'column' => 'id'),
		'ipvs' => array ('table' => 'VS', 'column' => 'id'),
		'location' => array ('table' => 'Location', 'column' => 'id'),
		'object' => array ('table' => 'RackObject', 'column' => 'id'),
		'rack' => array ('table' => 'Rack', 'column' => 'id'),
		'user' => array ('table' => 'UserAccount', 'column' => 'user_id'),
		'vst' => array ('table' => 'VLANSwitchTemplate', 'column' => 'id'),
	);
	$orphans = array ();
	foreach ($realms as $realm => $details)
	{ 
		$result = usePreparedSelectBlade
		(
			'SELECT TS.*, TT.tag FROM TagStorage TS ' .
			'LEFT JOIN TagTree TT ON TS.tag_id = TT.id ' .
			"LEFT JOIN ${details['table']} ON TS.entity_id = ${details['table']}.${details['column']} " .
			"WHERE TS.entity_realm = ? AND ${details['table']}.${details['column']} IS NULL",
			array ($realm)
		);
		$rows = $result->fetchAll (PDO::FETCH_ASSOC);
		unset ($result);
		$orphans = array_merge ($orphans, $rows);
	}
	if (count ($orphans))
	{
		$mod->setOutput("TagStorageViolation", true);
		$mod->setOutput("TagStorageCount", count ($orphans));

		$violations = TRUE;
		/*startPortlet ('TagStorage: Missing Parents (' . count ($orphans) . ')');
		echo "<table cellpadding=5 cellspacing=0 align=center class=cooltable>\n";
		echo "<tr><th>Tag</th><th>Parent Type</th><th>Parent ID</th></tr>\n";*/
		$order = 'odd';
		$allTagStoragesOut = array();

		foreach ($orphans as $orphan)
		{
			$realm_name = formatRealmName ($orphan['entity_realm']);
			$singleOrphanOut = array('Order' => $order);
			$singleOrphanOut['RealmName'] = $realm_name;
			$singleOrphanOut['Tag'] = $orphan['tag'];
			$singleOrphanOut['EntityId'] = $orphan['entity_id'];
						
			$allTagStoragesOut[] = $singleOrphanOut;
			/*echo "<tr class=row_${order}>";
			echo "<td>${orphan['tag']}</td>";
			echo "<td>${realm_name}</td>";
			echo "<td>${orphan['entity_id']}</td>";
			echo "</tr>\n";*/
			$order = $nextorder[$order];
		}
	//	echo "</table>\n";
		finishPortLet ();
		$mod->setOutput("AllTagStoragesOrphans", $allTagStoragesOut);
	}

	// check 6: FileLink rows referencing non-existent parents 
	// re-use the realms list from the TagStorage check, with a few mods
	unset ($realms['file'], $realms['vst']);
	$realms['row'] = array ('table' => 'Row', 'column' => 'id');
	$orphans = array ();
	foreach ($realms as $realm => $details)
	{ 
		$result = usePreparedSelectBlade
		(
			'SELECT FL.*, F.name FROM FileLink FL ' .
			'LEFT JOIN File F ON FL.file_id = F.id ' .
			"LEFT JOIN ${details['table']} ON FL.entity_id = ${details['table']}.${details['column']} " .
			"WHERE FL.entity_type = ? AND ${details['table']}.${details['column']} IS NULL",
			array ($realm)
		);
		$rows = $result->fetchAll (PDO::FETCH_ASSOC);
		unset ($result);
		$orphans = array_merge ($orphans, $rows);
	}
	if (count ($orphans))
	{
		$mod->setOutput("FileLinkViolation", true);
		$mod->setOutput("FileLinkCount", count ($orphans));

		$violations = TRUE;
		//startPortlet ('FileLink: Missing Parents (' . count ($orphans) . ')');
		//echo "<table cellpadding=5 cellspacing=0 align=center class=cooltable>\n";
		//echo "<tr><th>File</th><th>Parent Type</th><th>Parent ID</th></tr>\n";
		$order = 'odd';
		$allFileLinksOut = array();
		foreach ($orphans as $orphan)
		{
			$realm_name = formatRealmName ($orphan['entity_type']);
			$singleOrphanOut = array('Order' => $order);
			$singleOrphanOut['Name'] = $orphan['name'];
			$singleOrphanOut['RealmName'] = $realm_name;
			$singleOrphanOut['EntityId'] = $orphan['entity_id'];
						
			$allFileLinksOut[] = $singleOrphanOut;
	//		echo "<tr class=row_${order}>";
	//		echo "<td>${orphan['name']}</td>";
	//		echo "<td>${realm_name}</td>";
	//		echo "<td>${orphan['entity_id']}</td>";
	//		echo "</tr>\n";
			$order = $nextorder[$order];
		}
	//	echo "</table>\n";
	//	finishPortLet ();
		$mod->setOutput("AllFileLinksOrphans", $allFileLinksOut);
	}

	if (! $violations)
		$mod->setOutput("NoViolations", true);
			 
	//	echo '<h2>No integrity violations found</h2>';
}

?>

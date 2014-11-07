<?php



//This stores the callbacks
$mainpage_widgets = array();

/**
 * This functions adds one widget to the main page.
 * To create an widget its nessessary to create a function that returns
 * a template module that contains the widget to display. The creation of the
 * widget should be done independent of other widgets (even though this is not enforced)
 * and should be created by using TemplateManager->generateModule(). To keep your widget
 * independent from the bootstrap template, use setTemplate on the created module to redirect
 * it to your own folder.
 * 
 * The widgets should fit into a bootstrap column with a width of 6.
 * 
 * $order specifies wether the widget will be added at the end ('last'), or the beginning ('first') of the page. 
 * 
 * @param Function $callback
 */
function addMainpageWidget($callback,$order = 'last') {
	global $mainpage_widgets;
	if ($callback == 'first') {
		array_unshift($mainpage_widgets, $callback);
	} else {
		$mainpage_widgets[] = $callback;
	}
}

function renderRackspaceSVG() {
	// Handle the location filter
	@session_start();
	if (isset ($_REQUEST['changeLocationFilter']))
		unset ($_SESSION['locationFilter']);
	if (isset ($_REQUEST['location_id']))
		$_SESSION['locationFilter'] = $_REQUEST['location_id'];
	session_commit();

	$tplm = TemplateManager::getInstance();
	$tplm->getMainModule()->setOutput('Payload', '');

	$mod = $tplm->generateSubmodule("Payload", "renderRackspace");
	$mod->setNamespace("rackspace", true);

	$found_racks = array();
	$cellfilter = getCellFilter();
	if (! ($cellfilter['is_empty'] && !isset ($_SESSION['locationFilter']) && renderEmptyResults ($cellfilter, 'racks', getEntitiesCount ('rack'))))
	{
		$rows = array();
		$rackCount = 0;
		foreach (getAllRows() as $row_id => $rowInfo)
		{
			$rackList = applyCellFilter ('rack', $cellfilter, $row_id);
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
				$smod = $tplm->generateSubmodule('RackspaceSVG', 'renderRackspace_SVG', $mod);
				$rowy = 5;
				$maxx = 50;
				$rack_counter = 0;
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

					// 					$rowo = array();
					// 					$rowo["Order"] = $order;

					$rackListIdx = 0;
					$locationIdx = 0;
					$locationTree = '';

					while ($location_id)
					{
						if ($locationIdx == 20)
						{
							showWarning ("Warning: There is likely a circular reference in the location tree.  Investigate location ${location_id}.");
							break;
						}
						$parentLocation = spotEntity ('location', $location_id);
						$locationTree = "&raquo; <a href='" .
							makeHref(array('page'=>'location', 'location_id'=>$parentLocation['id'])) .
							"${cellfilter['urlextra']}'>${parentLocation['name']}</a> " .
							$locationTree;
						$location_id = $parentLocation['parent_id'];
						$locationIdx++;
					}
					$locationTree = substr ($locationTree, 8);
				
					$rowo = $tplm->generateSubmodule('Content', 'renderRackspace_SVGRow', $smod);
					
					$rackx = 10;
					$maxracky = 20;
			
				//@TODO Add link to row
					
				// 					$rowo["LocationTree"] = $locationTree;
				// 					$rowo["HrefToRow"] = makeHref(array('page'=>'row', 'row_id'=>$row_id));
				// 					$rowo["RowName"] = $row_name;
				// 					$rowo["CellFilterUrlExtra"] = $cellfilter['urlextra'];
		
					if (count ($rackList))
					{
						foreach ($rackList as $rack)
						{
							$racko = $tplm->generateSubmodule('Racks', 'renderRackspace_SVGRack', $rowo);
							
							//Set curent x position and current index
							$racko->addOutput('X', $rackx);
							$racko->addOutput('Y', 35);
							
							$racko->addOutput('RackName',$rack['name']);
							$racko->addOutput('RackLink', makeHref(array('page'=>'rack', 'rack_id'=>$rack['id'])));
								
							$rackData = spotEntity ('rack', $rack['id']);
							amplifyCell($rackData);
							markAllSpans($rackData);
							
							//Height is 10 Pix per HE + 10 for the border
							$racko->addOutput('Height', ($rackData['height'] * 10) + 10);
								
							$maxracky = (($rackData['height'] * 10) + 10) > $maxracky ? ($rackData['height'] * 10) + 10 : $maxracky;
								
							for ($i = $rackData['height']; $i > 0; $i--) {
								for($j = 0; $j < 3; ++$j) {
									if (isset ($rackData[$i][$j]['skipped']))
										continue;
									
									$state = $rackData[$i][$j]['state'];
									//F Frei
									//A Im Design deaktiviert
									//U Kaputt
									//T In benutzung
	
									if ($state == 'T' || $state == 'U' || $state == 'A') {
										$height =  array_key_exists('rowspan', $rackData[$i][$j]) && $rackData[$i][$j]['rowspan'] > 0 ? $rackData[$i][$j]['rowspan'] : 1 ;
										$width = array_key_exists('colspan', $rackData[$i][$j]) && $rackData[$i][$j]['colspan'] > 0 ? $rackData[$i][$j]['colspan'] : 1;
										$elo = $tplm->generateSubmodule('Elements','renderRackspace_SVGElement', $racko);
										$elo->addOutput('X', $j * 60);
										$elo->addOutput('Y', ($rackData['height'] - $i) * 10);
										$elo->addOutput('Width', $width * 60);
										$elo->addOutput('Height', $height * 10);
								 
										if ($state == 'T') {
											$elo->addOutput('Class', 'element');
											$elo->addOutput('Link', '?page=object&object_id=' . $rackData[$i][$j]['object_id']);
	
											$object = spotEntity ('object', $rackData[$i][$j]['object_id']);
	
											$elo->addOutput('Name', $object['dname']);
										} elseif ($state == 'U') {
											$elo->addOutput('Class', 'unusable');
											$elo->addOutput('Link', '#');
											$elo->addOutput('Name', '');
										} elseif ($state == 'A') {
											$elo->addOutput('Class', 'deactivated');
											$elo->addOutput('Link', '#');
											$elo->addOutput('Name', '');
										}
									}
								}
							}
							//Increase rackx to ensure that the next rack is placed right to this one
							$rackx += 200;
						}
					}
					
					$rowo->addOutput('OverallWidth', $rackx + 20);
					$rowo->addOutput('OverallHeight', $maxracky + 60);
					$rowo->addOutput('LocationName', $locationTree);
					$rowo->addOutput('RowName', $row_name);
					$rowo->addOutput('Y', $rowy + 10);
					
					if($rack_counter % 2)
						$rowo->addOutput('X', 5);
					else
						$rowo->addOutput('X', 5  + $rackx + 50);

					$rowo->addOutput('Counter', $rack_counter++);
					$rowo->addOutput('Link', makeHref(array('page'=>'row', 'row_id'=>$row_id)));

					if($rack_counter % 2 == 0)
						$rowy += ($maxracky + 100);
					
					$maxx = $maxx < $rackx + 20 ? $rackx + 20 : $maxx;
				}
				$smod->addOutput('OverallWidth', $maxx);
				$smod->addOutput('OverallHeight', $rowy + $maxracky + 40);
			}
		}
		else
		{
			$mod->setOutput("RackspaceOverviewTable", "");
			$mod->setOutput("RackspaceOverviewHeadline", "No rows found.");
		}
	}
	renderCellFilterPortlet ($cellfilter, 'rack', $found_racks, array(), $mod, 'CellFilter');
	renderLocationFilterPortlet($mod, 'LocationFilter');
}

function renderDynamicAddMultipleObjectsForm() {
	$max = getConfigVar ('MASSCOUNT');
	
	$tplm = TemplateManager::getInstance();
	$tplm->getMainModule()->setOutput('Payload', '');
	$mod = $tplm->generateSubmodule("Payload","AddMultipleObjects");
	$mod->setNamespace("depot");
	
	// exclude location-related object types
	global $location_obj_types;
	$tabindex = 100;

	$typelist = readChapter (CHAP_OBJTYPE, 'o');
    $typelist[0] = 'select type...';
    $typelist = cookOptgroups ($typelist);

	foreach ($typelist['other'] as $key => $value)
	if ($key > 0 && in_array($key, $location_obj_types))
		unset($typelist['other'][$key]);
	
	$objectListOutput = array();
	for ($i = 0; $i < $max; $i++)
	{
		$singleEntry = array();
	// Don't employ DEFAULT_OBJECT_TYPE to avoid creating ghost records for pre-selected empty rows.
		$singleEntry['i'] = $i;
		
		$singleEntry['tagsPicker'] = 'A';
		$singleEntry['NiftySelect'] = printNiftySelect ($typelist, array ('name' => "${i}_object_type_id", 'tabindex' => $tabindex), 0);
					
		$objectListOutput[] = $singleEntry;
	}
	$mod->setOutput("AddTable", $objectListOutput);
}

function addMultipleObjectsDynamic() {
	
}

function renderIPSpaceWithAddRem() {
	renderIPSpace();
	$tplm = TemplateManager::getInstance();

	// Add an add + remove dialog at the end
	$tplm->getMainModule()->addOutput('Payload', '<div class="addContainer">');
	renderIPNewNetForm();
	$tplm->getMainModule()->addOutput('Payload', '</div>');
	$tplm->getMainModule()->addOutput('Payload', '<div class="removeContainer">');
	renderIPSpaceEditor();
	$tplm->getMainModule()->addOutput('Payload', '</div>');

}

global $tabhandler;

$tabhandler['rackspace']['default'] = 'renderRackspaceSVG';
$tabhandler['depot']['addmore'] = 'renderDynamicAddMultipleObjectsForm';
$tabhandler['ipv4space']['default'] = 'renderIPSpaceWithAddRem';

?>
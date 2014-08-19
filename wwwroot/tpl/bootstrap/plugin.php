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



?>
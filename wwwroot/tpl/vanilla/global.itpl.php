<?php

/**
 * Template for: CSS inline
 * Usage: interface-lib.php (printPageHeaders())
 */
$this->setInMemoryTemplate("HeaderCssInline","<style type=\"text/css\">" . "\n" . "{{code}}" . "\n</style>\n");

/**
 * Template for: CSS include
 * Usage: interface-lib.php (printPageHeaders())
 */
$this->setInMemoryTemplate("HeaderCssInclude","<link rel=stylesheet type='text/css' href='?module=chrome&uri={{path}}' />\n");


/**
 * Template for: JS inline
 * Usage: interface-lib.php (printPageHeaders())
 */
$this->setInMemoryTemplate("HeaderJsInline",'<script type="text/javascript">' . "\n" . "{{code}}" . "\n</script>\n");

/**
 * Template for: JS include
 * Usage: interface-lib.php (printPageHeaders())
*/
$this->setInMemoryTemplate("HeaderJsInclude","<link rel=stylesheet type='text/css' href='?module=chrome&uri={{path}}' />\n");

/**
 * Template for: CellFilterPortlet in case there are no tags
 * Usage: interface.php (renderCellFilterPortlet())
 */
$this->setInMemoryTemplate("CellFilterNoTags","<tr><td colspan=2 class='tagbox sparenetwork'>(nothing is tagged yet)</td></tr>");

/**
 * Template for: CellFilterPortlet in case there are no predicates
 * Usage: interface.php (renderCellFilterPortlet())
 */
$this->setInMemoryTemplate("CellFilterNoPredicates","<tr><td colspan=2 class='tagbox sparenetwork'>(no predicates to show)</td></tr>");

/**
 * Template for: CelLFilterPortlet in case you want extra-tags.
 * Usage: interface.php (renderCellFilterPortlet())
 */
$this->setInMemoryTemplate("CellFilterExtraText","<tr><td colspan=2><textarea name=cfe {{Class}}>{{Extratext}}</textarea></td></tr>");

/**
 * Template for: Tablist, the currently active Tab
 * Usage: interface.php (showTabs)
 */
$this->setInMemoryTemplate("TabActive","<li><a class=current href='index.php?page={{Page}}&tab={{Tab}}{{Args}}'>{{Title}}</a></li>");

/**
 * Template for: Tablist, currently inactive tabs
 * Usage: interface.php (showTabs)
 */
$this->setInMemoryTemplate("TabInactive","<li><a class=std href='index.php?page={{Page}}&tab={{Tab}}{{Args}}'>{{Title}}</a></li>");

/**
 * Template for: Tablist, tabs with warnings
 * Usage: interface.php (showTabs)
 */
$this->setInMemoryTemplate("TabAttention","<li><a class=attn href='index.php?page={{Page}}&tab={{Tab}}{{Args}}'>{{Title}}</a></li>");

/**
 * Template for: Part of the path  in the PathAndSearch module
 * Usage: interface.php (showPathAndSearch)
 */
$this->setInMemoryTemplate("PathLink"," : <a href='index.php?{{Params}}{{AnchorTail}}'>{{Name}}</a>");

/**
 * Template for spacer in CellFilterPortlet
 * UsagE: interface.php (renderCellFilterPortlet)
 */
$this->setInMemoryTemplate("CellFilterSpacer","<tr><td colspan=2 class=tagbox><hr></td></tr>\n");

/**
 * Template for ObjectLogs when no log exists
 * Usage: interface.php (allObjectLogs)
**/
$this->setInMemoryTemplate("NoObjectLogFound","<center><h2>No logs exist</h2></center>");

/**
 * Template for Search when nothing was found
 * Usage: interface.php (renderSearchResults)
**/
$this->setInMemoryTemplate("NoSearchItemFound","<center><h2>Nothing found for {{Terms}}</h2></center>");


/**
 * The four error messages.
 * Usage: interface.php (showMessageOrError)
 */
$this->setInMemoryTemplate("MessageNeutral","<div class=msg_neutral'> {{Message}} </div>");
$this->setInMemoryTemplate("MessageSuccess","<div class=msg_success'> {{Message}} </div>");
$this->setInMemoryTemplate("MessageError","<div class=msg_error'> {{Message}} </div>");
$this->setInMemoryTemplate("MessageWarning","<div class=msg_warning'> {{Message}} </div>");

/**
 * Text to render when no CellList elements are available.
 * Usage: interface.php (renderEmptyResults)
 **/
$this->setInMemoryTemplate("EmptyResults","<p>Please set a filter to display the corresponging {{Name}} <br> <a href=\"{{ShowAll}}\">Show all {{Name}}{{Suffix}}</a></p>");


?>
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


$this->setInMemoryTemplate("GetImageHrefDoInput", "<input type=image name=submit class=icon src={{SrcPath}} border=0 {{TabIndex}} {{Title}}>");
$this->setInMemoryTemplate("GetImageHrefNoInput", "<img src={{SrcPath}} width={{ImgWidth}} height={{ImgHeight}} border=0 {{Title}} >");


/**
*	getRenderedIPv4NetCapacity: 
*	Usage: interface.php, interface-lib.php
*
**/
$this->setInMemoryTemplate("RenderedIPv4NetCapacityAddrc", "<img width='{{width}}' height=10 border=0 title='{{title2}}' src='?module=progressbar4&px1={{px1}}" . 
															"&px2={{px2}}&px3={{px3}}'><small class='title'>{{title}}</small>");
$this->setInMemoryTemplate("RenderedIPv4NetCapacityReturn","<div class=\"{{class}}\" id=\"{{div_id}}\"> {{textVal}}</div>");

/**
*	getRenderedIPv6NetCapacity: 
*	Usage: interface.php, interface-lib.php
*
**/
$this->setInMemoryTemplate("RenderedIPv6NetCapacity","<div class=\"{{class}}\" id=\"{{div_id}}\"> {{addrc}}{{cnt}}{{mult}}{{what}}  </div>");

/**
*	renderNetVLAN: 
*	Usage: interface.php, interface-lib.php
*
**/
$this->setInMemoryTemplate("RenderNetVLAN","<div class='vlan'><strong><small>{{noun}}</small>{{link}} </strong></div>");

/**
*	MkA: 
*	Usage: functions.php
*
**/
$this->setInMemoryTemplate("MkAInMemory","<a href='{{link}}'>{{text}}</a>");


/**
*	formatVSPort: 
*	Usage: slb2-interface.php
*
**/
$this->setInMemoryTemplate("formatVSPortInMemory"," <span title={{name}}> {{srv}} </span>");

/**
*	FormatVSIP: 
*	Usage:  slb2-interface.php
*
**/
$this->setInMemoryTemplate("FormatVSIPInMem","<a href='{{href}}'>{{fmt_ip}}</a>");

/**
*	GetSelect: 
*	Usage:  slb-interface.php
*
**/
$this->setInMemoryTemplate("GetSelectInLine","<input type=hidden name={{selectName}} id={{selectName}} value={{keyValue}}>{{value}}");

/**
*	RenderNewEntityTags: 
*	Usage:  interface.php
*
**/
$this->setInMemoryTemplate("RenderNewEntityTags_empty","No tags defined");
$this->setInMemoryTemplate("RenderNewEntityTags","<div class=tagselector><table border=0 align=center cellspacing=0 class='tagtree'>\n{{checkbox}}\n</table></div>\n");

/**
 * FileSummaryDownloadLink
 * Usage: interface.php - renderFileSummary() to display the download link.
 */
$this->setInMemoryTemplate('FileSummaryDownloadLink',"<a href='?module=download&file_id={{Id}}' src=?module=chrome&uri=pix/download.png title='Download' height=16 width=16 ><img ></a>&nbsp;");
/**
*	ReportsCounters: 
*	ReportsMesseges: 
*	ReportsCustom:
*	ReportsMeters: 
*	Usage: interface.php
*
**/
$this->setInMemoryTemplate("ReportsCounter","<tr><td class=tdright>{{header}}:</td><td class=tdleft>{{data}}</td></tr>");
$this->setInMemoryTemplate("ReportsMesseges","<tr class='msg_{{class}}><td class=tdright>{{header}}:</td><td class=tdleft>{{text}}</td></tr>");
$this->setInMemoryTemplate("ReportsCustom","<tr><td colspan=2>\n{{itemCont}}\n</td></tr>");
$this->setInMemoryTemplate("ReportsMeters","<tr><td class=tdright>{{title}:</td><td class=tdcenter>\n{{progressBar}}\n<br><small>{{isMax}}</small></td></tr>");

/**
*	GetProgressBar: 
*	Usage: interface-lib-php
*
**/
$this->setInMemoryTemplate("GetProgressBar","<img width=100 height=10 border=0 title='{{done}}%' src='{{src}}'>");


/**
*	NoVLANConfig: 
*	Usage:  interface.php
*
**/
$this->setInMemoryTemplate("NoVLANConfig","<center><h3>(no VLAN configuration exists)</h3></center>");

/**
*	StdCenterTableCell: 
*	Usage: interface.php
*
**/
$this->setInMemoryTemplate("StdCenterTableCell","<td class=tdcenter>{{cont}}</td>");

/**
*	StdTableCell: 
*	Usage: interface.php
*
**/
$this->setInMemoryTemplate("StdTableCell","<td>{{cont}}</td>");

/**
*	RenderTagStatsALink: 
*	Usage:  interface.php
*
**/
$this->setInMemoryTemplate("RenderTagStatsALink","<a href='index.php?page={{pagerealm}}&cft[]={{taginfoID}}>{{taginfo}}</a>");
 * FileSummaryComment
 * Usage: as above
 */
$this->setInMemoryTemplate('FileSummaryComment','<div class="dashed commentblock">{{Comment}}</div>');


/**
*	RenderConfigVarName: 
*	Usage:  interface.php
*
**/
$this->setInMemoryTemplate("RenderConfigVarName",'<span class="varname">{{vname}}</span>\n<p class="vardescr">{{desAndIsDefined}}</p>');

/**
 * FileSummaryComment
 * Usage: as above
 */
$this->setInMemoryTemplate('FileLinksDefLink','<tr><td class=tdleft>{{Content}}</td></tr>');

/**
 * FileSummaryComment
 * Usage: as above
 */
$this->setInMemoryTemplate('FileLinksObjLink','<tr><td class=tdleft>{{Name}} : {{Link}} </td></tr>');

/**
 * FileSummaryComment
 * Usage: as above
 */
$this->setInMemoryTemplate('CellLink','<a href="{{Link}}">{{Title}}</a>');

/**
 * Serialized Tag
 * Usage: serializeTags (interface-lib.php)
 */
$this->setInMemoryTemplate('SerializedTagLink','<a href="{{BaseUrl}}cft[]={{ID}}" class="{{Class}} title="{{Title}}">{{Tag}}</a> {{Delimiter}}');
$this->setInMemoryTemplate('SerializedTag','<span class="{{Class}} title="{{Title}}">{{Tag}}</span> {{Delimiter}}');

/**
 * FileSummaryComment
 * Usage: as above
 */
$this->setInMemoryTemplate('IPNetBacktraceLink','<a href="{{Link}}" title="View IP tree with this net as root">{{Title}}</a>');

?>
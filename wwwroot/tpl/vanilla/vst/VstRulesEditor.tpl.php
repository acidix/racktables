<?php if (defined("RS_TPL")) {?>

	<?php $this->addJS('js/vst_editor.js'); ?>

<center><h1> <?php $this->Nifty; ?> </h1></center>

	<?php if($this->is('Count', true)){ ?>
	<div class=portlet><h2>clone another template</h2>
	<?php $this->getH('PrintOpFormIntro', 'clone'); ?>
	<input type=hidden name="mutex_rev" value=" <?php $this->Vst_mutex_ref; ?> ">
	<table cellspacing=0 cellpadding=5 align=center class=widetable>
	<tr><td> <?php $this->Getselect; ?> </td>
	<td> <?php $this->getH('PrintImageHref', array('COPY', 'copy from selected', TRUE)); ?> </td></tr></table></form></div>
	<div class=portlet><h2>add rules one by one</h2>
	<?php } 
	
	$this->getH('PrintOpFormintro', 'upd'); ?>
	<table cellspacing=0 cellpadding=5 align=center class="widetable template-rules">
	<tr><th></th><th>sequence</th><th>regexp</th><th>role</th>
	<th>VLAN IDs</th><th>comment</th><th><a href="#" class="vst-add-rule initial"> <?php $this->getH('PrintImageHref', array('add', 'Add rule')); ?> </a></th></tr>
	<?php $row_html  = '<td><a href="#" class="vst-del-rule"> <img width="16" height="16" border="0" title="delete rule" src="?module=chrome&uri=pix/tango-list-remove.png"> </a></td>'; 
	$row_html .= '<td><input type=text name=rule_no value="%s" size=3></td>';
	$row_html .= '<td><input type=text name=port_pcre value="%s"></td>';
	$row_html .= '<td>' . $this->_Getselect . '</td>';
	$row_html .= '<td><input type=text name=wrt_vlans value="%s"></td>';
	$row_html .= '<td><input type=text name=description value="%s"></td>';
	$row_html .= '<td><a href="#" class="vst-add-rule"> <img width="16" height="16" border="0" title="Duplicate rule" src="?module=chrome&uri=pix/tango-list-add.png"> </a></td>'; 
	$this->addJS("var new_vst_row = '" . addslashes($row_html) . "';", TRUE); 
	$this->startLoop('Itemarray');?>
	<tr> <?php echo $row_html ?> </tr> <?php $this->Rule_no; htmlspecialchars($this->_Port_pcre, ENT_QUOTES); $this->Getselect; $this->Wrt_vlans; $this->Description; 
	$this->endLoop(); ?>
	</table>
	<input type=hidden name="template_json">	
	<input type=hidden name="mutex_rev" value=" <?php $this->Mutex_rev; ?> ">
	<center> <?php $this->getH('PrintImageHref', array('SAVE', 'Save template', TRUE)); ?> </center>
	</form>
	<?php if($this->is('Count_source_option', TRUE)) echo '</div'; ?>
	
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
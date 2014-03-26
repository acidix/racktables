<?php if (defined("RS_TPL")) {?>
	<?php if ($this->is("isEnableMultiport",true)) { ?>
		<div class=portlet>
			<h2>Ports and interfaces</h2>
	<?php } else { ?>
		<br>
	<?php } ?> 
	<?php if ($this->is("isAddnewTop",true)) { ?>
		<table cellspacing=0 cellpadding='5' align='center' class='widetable'>
		<tr><th>&nbsp;</th><th class=tdleft>Local name</th><th class=tdleft>Visible label</th><th class=tdleft>Interface</th><th class=tdleft>Start Number</th>
		<th class=tdleft>Count</th><th>&nbsp;</th></tr>
		<?php $this->getH("PrintOpFormIntro", array('addBulkPorts')); ?>
		<tr><td>
		<?php $this->getH("PrintImageHref", array('add', 'add ports', TRUE)); ?>
		</td><td><input type=text size=8 name=port_name tabindex=105></td>
		<td><input type=text name=port_label tabindex=106></td><td>
		<?php $this->niftySelAddNewT ?>
		<td><input type=text name=port_numbering_start tabindex=108 size=3 maxlength=3></td>
		<td><input type=text name=port_numbering_count tabindex=109 size=3 maxlength=3></td>
		<td>&nbsp;</td><td>
		<?php $this->getH("PrintImageHref", array('add', 'add ports', TRUE, 110)); ?>
		</td></tr></form>
		</table><br>
	<?php } ?> 
	<table cellspacing=0 cellpadding='5' align='center' class='widetable'>
	<tr><th>&nbsp;</th><th class=tdleft>Local name</th><th class=tdleft>Visible label</th><th class=tdleft>Interface</th><th class=tdleft>L2 address</th>
	<th class=tdcenter colspan=2>Remote object and port</th><th>Cable ID</th><th class=tdcenter>(Un)link or (un)reserve</th><th>&nbsp;</th></tr>
	<?php $this->AddNewTopMod ?>
	<?php $this->clearPortLink ?>
	<?php $this->switchPortJS ?>
	<?php $this->startLoop("allPorts"); ?>	
		<?php $this->opFormIntro ?>
		<tr <?php $this->tr_class ?>><td><a name='port-<?php $this->port_id ?>' href='<?php $this->href_process ?>'>
		<?php $this->deleteImg ?>
		</a></td>
		<td class='tdleft' NOWRAP><input type=text name=name class='interactive-portname <?php $this->a_class ?>' value='<?php $this->port_name ?>' size=8></td>
		<td><input type=text name=label value='<?php $this->label ?>'></td>
		<td>
		<?php if (!$this->is("iif_name",null)) { ?>
			<label><?php $this->iif_name ?>
		<?php } ?> 
		<?php $this->printSelExType ?>
		<?php if (!$this->is("iif_name",null)) { ?>
			</label>
		<?php } ?>
		</td>
		<td><input type=text name=l2address value='<?php $this->l2address ?>' size=18 maxlength=24></td>
		<?php if ($this->is("isRemoteObj",true)) { ?>
			<td><?php $this->logged_span_rem_obj_id ?></td>
			<td><?php $this->logged_span_rem_name ?><<input type=hidden name=reservation_comment value=''></td>
			<td><input type=text name=cable value='<?php $this->calbeid ?>'></td>
			<td class=tdcenter><?php $this->unlink_op_link ?></td>
		<?php } elseif ($this->is("hasReservation_comment",true)) { ?>
			<td><?php $this->logged_span_rem_reserved ?></td>
			<td><input type=text name=reservation_comment value='<?php $this->reservation_comment ?>'></td>
			<td></td>
			<td class=tdcenter>
			<?php $this->use_up_op_link ?>
			</td>
		<?php } else {?>
			<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td class=tdcenter><span
			ondblclick='window.open("<?php $this->href_helper_portlist ?>", "findlink", 
			"height=700, width=400, location=no, menubar=no,
						resizable=yes, scrollbars=yes, status=no, titlebar=no, toolbar=no");'
			onclick='window.open("<?php $this->href_helper_portlist ?>", "findlink", 
			"height=700, width=400, location=no, menubar=no,
						resizable=yes, scrollbars=yes, status=no, titlebar=no, toolbar=no");'>
			<?php $this->link_img ?>
			</span>
			<input type=text name=reservation_comment></td>
		<?php } ?>
		<td>
		<?php $this->save_img ?>
		</td></form></tr>
	<?php $this->endLoop(); ?> 
	<?php $this->AddNewTopMod2 ?>
	</table><br>
	<?php if ($this->is("isBulkportFrom",true)) { ?>
		<table cellspacing=0 cellpadding='5' align='center' class='widetable'>
		<tr><th>&nbsp;</th><th class=tdleft>Local name</th><th class=tdleft>Visible label</th><th class=tdleft>Interface</th><th class=tdleft>Start Number</th>
		<th class=tdleft>Count</th><th>&nbsp;</th></tr>
		<?php $this->getH("PrintOpFormIntro", array('addBulkPorts')); ?>
		<tr><td>
		<?php $this->getH("PrintImageHref", array('add', 'add ports', TRUE)); ?>
		</td><td><input type=text size=8 name=port_name tabindex=105></td>
		<td><input type=text name=port_label tabindex=106></td><td>
		<?php $this->bulkPortsNiftySel ?>
		<td><input type=text name=port_numbering_start tabindex=108 size=3 maxlength=3></td>
		<td><input type=text name=port_numbering_count tabindex=109 size=3 maxlength=3></td>
		<td>&nbsp;</td><td>
		<?php $this->getH("PrintImageHref", array('add', 'add ports', TRUE, 110)); ?>
		</td></tr></form>
		</table><br>

	<?php } ?> 
	<?php if ($this->is("isEnableMultiport",true)) { ?>
		</div>
		<div class=portlet>
			<h2>Add/update multiple ports</h2>
			<?php $this->getH("PrintOpFormIntro", array('addMultiPorts')); ?>
			Format: <select name=format tabindex=201>
			<option value=c3600asy>Cisco 3600 async: sh line | inc TTY</option>
			<option value=fiwg selected>Foundry ServerIron/FastIron WorkGroup/Edge: sh int br</option>
			<option value=fisxii>Foundry FastIron SuperX/II4000: sh int br</option>
			<option value=ssv1>SSV:&lt;interface name&gt; &lt;MAC address&gt;</option>
			</select>
			Default port type: 
			<?php $this->portTypeNiftySel ?>
			<input type=submit value='Parse output' tabindex=204><br>
			<textarea name=input cols=100 rows=50 tabindex=203></textarea><br>
			</form>
		</div>
	<?php } ?> 
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
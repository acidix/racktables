<?php if (defined("RS_TPL")) {
	$this->addJS('js/jquery.thumbhover.js'); 
	$this->addJS('js/slb_editor.js'); ?>
	<?php $this->getH('PrintOpFormIntro','updVS'); ?>
	<table border=0 align=center>
	<tr><th class=tdright>Name:</th><td class=tdleft><input type=text name=name value="<?php $this->Name; ?>"></td></tr>
	<tr><th class=tdright>VS config:</th><td class=tdleft><textarea name=vsconfig rows=3 cols=80><?php $this->VSConfig; ?></textarea></td></tr>
	<tr><th class=tdright>RS config:</th><td class=tdleft><textarea name=rsconfig rows=3 cols=80><?php $this->RSConfig; ?></textarea></td></tr>
	<tr><th></th><th>
	<?php $this->getH('PrintImageHREF',array('SAVE','Save changes', true)); ?>
	<span style="margin-left: 2em"></span>
	<?php if ($this->is('Deletable')) { ?>
		<?php $this->getH('GetOPLink',array(NULL, '', 'NODESTROY', "Could not delete: there are " . count ($triplets) . " LB links")); ?>
	<?php } else { ?>
		<?php $this->getH('GetOPLink',array(array ('op' => 'del', 'id' => $vsinfo['id']), '', 'DESTROY', 'Delete', 'need-confirmation')); ?>
	<?php } ?>
	</th>
	</tr>
	</table>
	</form>
	<p>
	<table width=50% border=0 align=center>
		<tr><th style="white-space:nowrap">
		<?php $this->getH('PrintOpFormIntro','addPort'); ?>
			Add new port:<br /><?php $this->NewPortSelect; ?> <input name=port size=5><?php $this->getH('PrintImageHREF',array('add', 'Add port', TRUE)); ?>
		</form>
	</th>
	<td width=99%></td>
	
	<th style="white-space:nowrap">
		<?php $this->getH('PrintOpFormIntro','addIP'); ?>
		Add new IP:<br />
		<input name=ip size=14>
		<?php $this->getH('PrintImageHREF',array('add', 'Add IP', TRUE)); ?>
	</form></th></tr>
	
	<tr><td valign=top class=tdleft>
		<ul class="slb-checks editable">
		
		</ul>
	</td>
	
	<td width=99%></td>
	
	<td valign=top class=tdleft>
		<ul class="slb-checks editable">
	
		</ul>
	</td>
	</tr></table>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
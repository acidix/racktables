<?php if (defined("RS_TPL")) {?>

	<div class=portlet><h2>Optional attributes</h2>
	<table cellspacing=0 cellpadding=5 align=center class=widetable>
	<tr><th>&nbsp;</th><th>Name</th><th>Type</th><th>&nbsp;</th></tr>
	<?php $this->Newtop; 
		$this->startLoop('Looparray');
		$this->getH('PrintOpFormIntro', array('upd', array ('attr_id' => $this->_Id))); ?>
		<tr><td>	
		<?php if($this->is('Option', 'one')) $this->getH('PrintImageHref', array('nodestroy', 'system attribute'));
			elseif($this->is('Option', 'two')) $this->getH('PrintImageHref', array('nodestroy', count ($this->_Application) . ' reference(s) in attribute map'));
			elseif($this->is('Option', 'three')) $this->getH('GetOpLink', array(array('op'=>'del', 'attr_id'=> $this->_Id), '', 'destroy', 'Remove attribute')); ?>
		</td><td><input type=text name=attr_name value='<?php $this->Name; ?>'></td>
		<td class=tdleft><?php $this->Type; ?></td><td>
		<?php $this->getH('PrintImageHref', array('save', 'Save changes', TRUE)); ?>
		</td></tr></form>
		<?php $this->endLoop();
			$this->Newbottom; ?>
			</table></div>
		
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
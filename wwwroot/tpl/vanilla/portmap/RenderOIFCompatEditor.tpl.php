<?php if (defined("RS_TPL")) {?>
	
	<div class=portlet><h2>WDM wideband receivers</h2>
		<table border=0 align=center cellspacing=0 cellpadding=5>
			<tr><th>&nbsp;</th><th>enable</th><th>disable</th></tr>

			<?php while($this->refLoop('Looparray')) { ?> 
			<tr class=row_<?php $this->Order; ?>><td class=tdleft><?php $this->Title; ?></td><td>
			<?php $this->getH('GetOpLink', array( array ('op' => 'addPack', 'standard' => $this->_Codename), '', 'add')); ?>
			</td><td>
			<?php $this->getH('GetOpLink', array( array ('op' => 'delPack', 'standard' => $this->_Codename), '', 'delete')); ?>
			</td><tr>
			<?php } ?>
			</table>
			</div>
			<div class=portlet><h2>interface by interface</h2>
				<br>
				<table class=cooltable align=center border=0 cellpadding=5 cellspacing=0>
					<tr><th>&nbsp;</th><th>From Interface</th><th>To Interface</th></tr>
			
			<?php   $this->Newtop; 

			while($this->refLoop('Looparray2')) { ?> 				
				<tr class=row_<?php $this->Order; ?>><td>
				<?php $this->getH('GetOpLink', array(array ('op' => 'del', 'type1' => $this->_Type1, 'type2' => $this->_Type2), '', 'delete', 'remove pair')); ?>
				</td><td class=tdleft><?php $this->Type1name; ?></td><td class=tdleft><?php $this->Type2name; ?></td></tr>
			<?php }

			$this->Newbottom; ?>

			</table>
			</div>

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
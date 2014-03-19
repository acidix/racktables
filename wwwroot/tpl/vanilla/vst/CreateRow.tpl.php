<?php if (defined("RS_TPL")) {?>

	<?php $this->getH('PrintOpFormIntro', array('upd', array ('vst_id' => $vst_id))); ?>
	<tr><td>
	<?php if($this->is('Switchc_set', TRUE)) $this->getH('PrintImageHref', array('nodestroy', 'template used elsewhere')); 
			else $this->getH('GetOpLink', array(array ('op' => 'del', 'vst_id' => $this->_Vst_id), '', 'destroy', 'delete template')); ?>
			</td>
			<td><input name=vst_descr type=text size=48 value=" <?php $this->NiftyString; ?> "></td>
			<td> <?php $this->Imagehref; ?> </td>
			</tr></form>


<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
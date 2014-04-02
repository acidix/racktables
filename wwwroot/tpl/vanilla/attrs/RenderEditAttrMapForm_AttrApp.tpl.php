<?php if (defined("RS_TPL")) {?>
	<?php if ($this->is('sticky', 'yes')) { ?>
		<?php $this->getH("PrintImageHref", array('nodelete', 'system mapping')); ?>	
	<?php } elseif ($this->is('refcnt', true) ){ ?>
		<?php $this->getH("PrintImageHref", array('nodelete', $this->_refcnt . ' value(s) stored for objects')); ?> 
	<?php } else { ?>
		<?php $this->getH("GetOpLink", array(array('op'=>'del', 'attr_id'=>$this->_id, 'objtype_id'=>$this->_obj_id, '', 'delete', 'Remove mapping')); ?>
	<?php } ?>
	<?php $this->dec_obj ?>
	<?php if ($this->is("type",'dict')) { ?>
		(values from '<?php $this->chapter_name ?>')
	<?php } ?><br>
	<?php $this->decodedObj ?>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
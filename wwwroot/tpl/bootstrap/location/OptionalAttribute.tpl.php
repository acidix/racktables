<?php if (defined("RS_TPL")) {?>
	<input type=hidden name=<?php $this->Index; ?>_attr_id value=<?php $this->Record_Id; ?>>
	<div class="form-group has-warning">
		<div class="col-md-2">
			<?php 
				if ($this->is('Deletable', TRUE)){
					$this->getH('GetOpLink', array(array ('op'=>'clearSticker', 'attr_id'=>$this->_Record_Id), '', 'clear', 'Clear value', 'need-confirmation'));	
				}
			?>
		</div>
		<label class="col-md-2 control-label"><?php $this->Record_Name; ?></label>
		<div class="col-md-8">
			<?php
				if($this->is('Switch_Option', 'ONE')){
					?> <input type=text name=<?php $this->Index; ?>_value value='<?php $this->Record_Value; ?>'> <?php
				}
				elseif($this->is('Switch_Option', 'TWO')){
					$this->Nifty_Select;				
				}
			 ?>
		</div>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
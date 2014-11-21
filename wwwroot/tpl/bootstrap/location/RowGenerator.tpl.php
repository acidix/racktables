<?php if (defined("RS_TPL")) {?>
	<tr>
		<td><?php $this->Date; ?><br><?php $this->User; ?></td>
		<td class="logentry">
			<?php $this->Hrefs; ?><div class="pull-right">
			<?php $this->getH('GetOpLink', array(array('op'=>'del', 'log_id'=>$this->_Id, 'class'=>'btn btn-danger'), '<span class="glyphicon glyphicon-remove"></span>', '', 'Delete log entry')); ?>
			</div>
		</td>
	</tr>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
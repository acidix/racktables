<?php if (defined("RS_TPL")) {?>
	<table class="table table-striped table-bordered">
		<thead>
			<tr><th>&nbsp;</th><th><?php $this->LeftHeader ?></th><th><?php $this->RightHeader ?></th></tr>
		</thead>
		<tbody>
		<?php while ($this->loop('AddNewTop')) { ?>
			<?php $this->getH("PrintOpFormIntro", array('add')); ?>
			<tr>
				<th style="text-align: center"><button class="btn btn-sm btn-primary" tabindex=200 title="add pair"><span class="glyphicon glyphicon-plus"></span></button></th>
				<th><?php $this->lOptions ?></th>
				<th><?php $this->rOptions ?></th>
			</tr>
		</form>
		<?php } ?>

		<?php while($this->loop("AllCompats")) { ?>
			<tr><td>
			<?php $this->getH('GetOpLink', array(array ('op' => 'del', $this->_Left_Key => $this->_ItemLeft_Key,
								  $this->_Right_Key => $this->_ItemRight_Key, '', 'delete', 'remove pair'))); ?>
			</td><td class=tdleft><?php $this->LeftValue ?></td><td class=tdleft><?php $this->RightValue ?></td></tr>
		<?php } ?>

		<?php while ($this->loop('AddNewBottom')) { ?>
			<?php $this->getH("PrintOpFormIntro", array('add')); ?>
			<tr>
				<th><button class="btn btn-sm btn-primary" tabindex=200 title="add pair"><span class="glyphicon glyphicon-plus"></span></button></th>
				<th><?php $this->lOptions ?></th>
				<th><?php $this->rOptions ?></th>
			</tr>
		 </form>
		<?php } ?>
	</tbody>
	</table>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>

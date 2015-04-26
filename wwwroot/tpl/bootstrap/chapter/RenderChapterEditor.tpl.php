<?php if (defined("RS_TPL")) {?>
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title">Chapter editor</h3>
	</div>
	<div class="box-body no-padding">
		<table class="table ">
		<tr><th>Origin</th><th>Key</th><th>Word</th><th>&nbsp;</th></tr>
		<?php if ($this->is('NewTop')) { ?>
			<?php $this->getH('PrintOpFormIntro', 'add'); ?>
			<tr>
				<td>&nbsp;</td><td>&nbsp;</td>
				<td><input type=text name=dict_value size=64 tabindex=100 class="form-control"></td>
				<td>
					<button class="btn btn-primary" name="submit"><span class="glyphicon glyphicon-plus"></span></button>
				</td>
			</tr>
			</form>
		<?php } ?>
		<?php while($this->loop('ChapterList')) { ?>
		<tr>
		<?php if($this->is('lowkey', true)) { ?>
			<td>
	    		<i style="color: #3c8dbc" class="fa fa-fw fa-desktop"></i>
			</td>
			<td><?php $this->key ?></td>
			<td><?php $this->value ?></td>
			<td>&nbsp;</td>
		<?php } else { ?>
			<?php $this->getH('PrintOpFormIntro', array('upd', array ('dict_key' => $this->_key))); ?>
			<td>
				<i style="color: #f56954" class="fa fa-fw fa-heart"></i>
			</td>
			<td><?php $this->key ?></td>
			<td class=tdleft><input type=text name=dict_value size=64 value='<?php $this->value ?>' class='form-control'></td>
			<td>
				<div class="btn-group">
					<button class="btn btn-success" name="submit"><span class="glyphicon glyphicon-ok"></span></button>
					<?php if($this->is('refcnt',true)) { ?>
						<a href="#" class="btn btn-danger" title="referenced <?php $this->refcnt ?> time(s)"><span class="glyphicon glyphicon-remove"></span></a>
					<?php } else { ?>
						<?php $this->getH('GetOpLink', array(array('op'=>'del', 'dict_key'=>$this->_key), '<span class="glyphicon glyphicon-remove">', '', 'Delete word', 'btn btn-danger')); ?>
					<?php } ?>
				</div>
			</td>
			</form>
		<?php } ?>
	</tr>
<?php } ?>
<?php if (!$this->is('NewTop')) { ?>
	<?php $this->getH('PrintOpFormIntro', 'add'); ?>
			<tr>
				<td>&nbsp;</td><td>&nbsp;</td>
				<td><input type=text name=dict_value size=64 tabindex=100 class="form-control"></td>
				<td>
					<button class="btn btn-primary" name="submit"><span class="glyphicon glyphicon-plus"></span></button>
				</td>
			</tr>
			</form>
<?php } ?>
	  </table>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>

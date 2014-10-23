<?php if (defined("RS_TPL")) {?>
		<?php $js = 
<<<JS
function tageditor_showselectbox(e) {
	$(this).load('index.php', {module: 'ajax', ac: 'get-tag-select', tagid: this.id});
	$(this).unbind('mousedown', tageditor_showselectbox);
}
$(document).ready(function () {
	$('select.taglist-popup').bind('mousedown', tageditor_showselectbox);
});			
JS;
	$this->addJS($js,true);
?>
<?php if($this->is('OTags')) { ?>
<div class="box box-danger">
	<div class="box-header">
		<h3 class="box-title">Fallen leaves</h3>
	</div>
	<div class="box-content no-padding">
		<table class="table">
			<thead>
				<tr><th>tag name</th><th>parent tag</th><th>&nbsp;</th></tr>
			</thead>
			<tbody>
				<?php while($this->loop('OTags')) { ?>
					<?php $this->getH('PrintOpFormIntro',array('updateTag', array ('tag_id' => $this->_ID, 'tag_name' => $this->_Name))); ?>
					<input type=hidden name=is_assignable value=<?php $this->Assignable ?>>
					<tr>
						<td><?php $this->Name; ?></td>
						<td><?php $this->Select; ?></td>
						<td><button class="btn btn-success"><span class="glyphicon glyphicon-ok"></span></button></td>
					</tr>
					</form>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<?php } ?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Tags</h3>
	</div>
	<div class="box-content no-padding">
		<table class="table">
			<thead>
				<tr><th>&nbsp;</th><th>tag name</th><th>assignable</th><th>parent tag</th><th>&nbsp;</th></tr>
			</thead>
			<tbody>
				<?php if($this->is('NewTop')) { ?>
					<?php $this->getH('PrintOpFormIntro','createTag'); ?>
						<tr>
							<td align=left style="padding-left: 16px;">&nbsp;</td>
							<td><input type=text size=48 name=tag_name tabindex=100></td>
							<td class=tdleft> <?php $this->getH("PrintSelect", array(array ('yes' => 'yes', 'no' => 'no'), array ('name' => 'is_assignable', 'tabindex' => 105), 'yes')); ?></td>
							<td><?php $this->getH("PrintSelect", array($this->_CreateNewOptions, array ('name' => 'parent_id', 'tabindex' => 110))); ?></td>
							<td><button class="btn btn-primary" name="submit" type="submit"><span class="glyphicon glyphicon-plus"></span></button></td>
						</tr>
					</form>
				<?php } ?>
				<?php while($this->loop('Taglist')) { ?>
					<tr <?php if($this->is('Assignable',false)) { ?>
						<?php if (!$this->is('hasChildren',true)) { ?>
							class=danger
						<?php } ?>
					<?php } ?>>
						<td style='padding-left: <?php echo $this->_Level * 16; ?>px;'>
							<?php if ($this->is('hasChildren', true)) { ?>
								<img width="16" border="0" height="16" src="?module=chrome&uri=pix/node-expanded-static.png"></img>
							<?php } ?>
							
						</td>
						<?php $this->getH('PrintOpFormIntro',array('updateTag', array ('tag_id' => $this->_ID))) ; ?>
						<td>
							<input type=text size=48 name=tag_name value="<?php $this->Tag; ?>">
						</td>
						<td class=tdleft>
							<?php if($this->is('References', true)) { ?>
								<?php $this->getH("PrintSelect", array(array ('yes' => 'yes'), array ('name' => 'is_assignable'))); ?>
							<?php } else {?>
								<?php $this->getH("PrintSelect", array(array ('yes' => 'yes', 'no' => 'no'), array ('name' => 'is_assignable'), $this->_AssignableInfo)); ?>
							<?php } ?>
						</td>
							<td class=tdleft>
						<?php $this->ParentSelect; ?>
						</td>
						<td>
							<div class="btn-group">
								<button name="submit" class="btn btn-success" type="submit"><span class="glyphicon glyphicon-ok"></span></button>
								<?php if($this->is('hasReferences',true) || $this->is('hasChildren', true)) { ?>
									<a href="#" class="btn btn-danger disabled"><span class="glyphicon glyphicon-remove"></span></a>
								<?php } else { ?>
									<?php $this->getH('GetOpLink', array(array ('op' => 'destroyTag', 'tag_id' => $this->_ID), '<span class="glyphicon glyphicon-remove"></span>', '', 'Delete tag', 'btn btn-danger')); ?>
								<?php } ?>
							</div>
						</td>
						</form>
					</tr>
				<?php } ?>
				<?php if(!$this->is('NewTop')) { ?>
					<?php $this->getH('PrintOpFormIntro','createTag'); ?>
						<tr>
							<td align=left style="padding-left: 16px;">&nbsp;</td>
							<td><input type=text size=48 name=tag_name tabindex=100></td>
							<td class=tdleft> <?php $this->getH("PrintSelect", array(array ('yes' => 'yes', 'no' => 'no'), array ('name' => 'is_assignable', 'tabindex' => 105), 'yes')); ?></td>
							<td><?php $this->getH("PrintSelect", array($this->_CreateNewOptions, array ('name' => 'parent_id', 'tabindex' => 110))); ?></td>
							<td><button class="btn btn-primary" name="submit" type="submit"><span class="glyphicon glyphicon-plus"></span></button></td>
						</tr>
					</form>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
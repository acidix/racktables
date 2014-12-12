<?php if (defined("RS_TPL")) {?>
	<table cellspacing=0 cellpadding=5 align=center class=widetable>
		<tr><th>&nbsp;</th><th>Chapter name</th><th>Words</th><th>&nbsp;</th></tr>
		<?php if($this->is('NewTop')) { ?>
			<?php $this->getH('PrintOpFormIntro','add'); ?>
			<tr>
				<td>
					<?php $this->getH('PrintImageHREF',array('create', 'Add new', TRUE)); ?>
				</td>
				<td><input type=text name=chapter_name tabindex=100></td><td>&nbsp;</td>
				<td>
					<?php $this->getH('PrintImageHREF',array('create', 'Add new', TRUE)); ?>
				</td>
			</tr>
			</form>
		<?php } ?>
		<?php while($this->loop('DictList')) { ?>
			<?php $this->getH('PrintOpFormIntro',array(array('chapter_no'=>$this->_ChapterId))); ?>
			<tr>
				<td>
					<?php if(!$this->is('NoDestroyMessage','')) { ?>
						<button class="btn btn-danger btn-sm disabled"><span class="glyphicon glyphicon-minus"></span></button>
					<?php } else { ?>
						<?php $this->getH('GetOpLink', array(array ('op' => 'del', 'chapter_no'=>$this->_ChapterId), '<span class="glyphicon glyphicon-minus"></span>', '', 'Remove chapter', 'btn btn-danger btn-sm')); ?>
					<?php } ?>
				</td>
				<td><input type=text name=chapter_name value='<?php $this->Name; ?>' <?php $this->Disabled; ?>></td>
				<td class=tdleft><?php  $this->Wordcount; ?></td>
				<td>
					<?php if ($this->is('Sticky',true)) { ?>
						&nbsp;
					<?php } else { ?>
						<button class="btn btn-success btn-sm" title="Save changes" name="submit"><span class="glyphicon glyphicon-ok"></span></button>
					<?php } ?>
				</td>
			</tr>
			</form>
		<?php } ?>
		<?php if(!$this->is('NewTop')) { ?>
			<?php $this->getH('PrintOpFormIntro','add'); ?>
			<tr>
				<td><button class="btn btn-primary btn-sm" title="Add new" name="submit"><span class="glyphicon glyphicon-plus"></span></button></td>
				<td><input type=text name=chapter_name tabindex=100></td><td>&nbsp;</td>
				<td><button class="btn btn-primary btn-sm" title="Add new" name="submit"><span class="glyphicon glyphicon-plus"></span></button></td>
			</tr>
			</form>
		<?php } ?>
	</table>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
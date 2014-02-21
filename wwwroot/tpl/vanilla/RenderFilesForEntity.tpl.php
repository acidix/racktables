<?php if (defined("RS_TPL")) {?>
	<div class=portlet>
		<h2>Upload and link new</h2>
		<table border=0 cellspacing=0 cellpadding='5' align='center' class='widetable'>
		<tr><th>File</th><th>Comment</th><th></th></tr>\
		<?php $this->getH("PrintOpFormIntro", array('addFile', array (), TRUE)); ?> 
		<tr>
		<td class=tdleft><input type='file' size='10' name='file' tabindex=100></td>
		<td class=tdleft><textarea tabindex=101 name=comment rows=10 cols=80></textarea></td><td>
		<?php $this->getH("PrintImageHREF", array('CREATE', 'Upload file', TRUE, 102)); ?>
		</td></tr></form>
		</table><br>
	</div>

	<?php if ($this->is("showFiles",true)) { ?>
		<div class=portlet>
			<h2>Link existing (<?php $this->countFiles ?>)</h2>
			<?php $this->getH("PrintOpFormIntro", array('linkFile'); ?> 
			<table border=0 cellspacing=0 cellpadding='5' align='center'>
			<tr><td class=tdleft>
			<?php $this->printedSelect ?> 
			</td><td class=tdleft>
			<?php $this->getH("PrintImageHREF", array('ATTACH', 'Link file', TRUE)); ?> 
			</td></tr></table>
			</form>
		</div>
	<?php } ?>

	 <?php if ($this->is("showFilelist",true)) { ?>
		<div class=portlet>
			<h2>Manage linked (<?php $this->countFilelist ?>)</h2>
			<table border=0 cellspacing=0 cellpadding='5' align='center' class='widetable'>
			<tr><th>File</th><th>Comment</th><th>Unlink</th></tr>
			<?php $this->startLoop("filelistsOutput"); ?>	
				<tr valign=top><td class=tdleft>
				<?php $this->fileCell ?> 
				</td><td class=tdleft><?php $this->comment ?> </td><td class=tdcenter>
				<?php $this->getH("GetOpLink", array(array('op'=>'unlinkFile', 'link_id'=>$this->fileLink), '', 'CUT', 'Unlink file')); ?> 
				</td></tr>
			<?php $this->endLoop(); ?> 
			</table>
		</div>
	<?php } ?>

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
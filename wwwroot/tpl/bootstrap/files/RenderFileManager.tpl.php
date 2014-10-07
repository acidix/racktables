<?php if (defined("RS_TPL")) {?>
	<?php if($this->is('NewTop')) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Upload new</h3>
			</div>
			<div class="box-content">
				<?php $this->getH('PrintOpFormIntro',array('addFile', array (), TRUE)); ?>
				<div class="row">
					<div class="col-md-4"><label for="comment">Comment:</label></div>
					<div class="col-md-12"><textarea tabindex=101 name=comment rows=10 cols=80 class="form-control"></textarea></div>
				</div>
				<div class="row">
					<div class="col-md-4"><label>Tags:</label></div>
					<div class="col-md-12"><?php $this->TagsPicker; ?></div>
				</div>
				<div class="row">
					<div class="col-md-4"><label for="file">File:</label></div>
					<div class="col-md-12"><input type='file' size='10' name='file' tabindex=100></textarea></div>
				</div>
				<div class="row">
					<div class="col-md-4"><label>Upload:</label></div>
					<div class="col-md-12">
						<button class="btn btn-success"><span class="glyphicon glyphicon-ok"></span></button>
					</div>
				</div>
				</form>
			</div>
		</div>
	<?php } ?>
	<?php if($this->is('FileList')) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Manage existing</h3>
			</div>
			<div class="box-content no-padding">
				<table class="table table-striped">
					<thead>
						<tr><th>File</th><th>Unlink</th><th>Destroy</th></tr>
					</thead>
					<tbody>
						<?php while($this->loop('FileList')) { ?>
							<tr>
								<td><?php $this->Cell; ?></td>
								<td><?php $this->Links; ?></td>
								<td>
									<?php if($this->is('Deletable')) { ?>
										<?php $this->getH('GetOpLink',array(array('op'=>'deleteFile', 'file_id'=>$this->_Id), '<span class="glyphicon glyphicon-remove"></span>', '', 'Delete file', 'btn btn-danger need-confirmation')); ?>
									<?php } else { ?>
										<a href="#" class="btn btn-danger disabled" title="References (<?php $this->Count; ?>"></a>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	<?php } ?>
	<?php if(!$this->is('NewTop')) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Upload new</h3>
			</div>
			<div class="box-content">
				<?php $this->getH('PrintOpFormIntro',array('addFile', array (), TRUE)); ?>
				<div class="row">
					<div class="col-md-4"><label for="comment">Comment:</label></div>
					<div class="col-md-12"><textarea tabindex=101 name=comment rows=10 cols=80 class="form-control"></textarea></div>
				</div>
				<div class="row">
					<div class="col-md-4"><label>Tags:</label></div>
					<div class="col-md-12"><?php $this->TagsPicker; ?></div>
				</div>
				<div class="row">
					<div class="col-md-4"><label for="file">File:</label></div>
					<div class="col-md-12"><input type='file' size='10' name='file' tabindex=100></textarea></div>
				</div>
				<div class="row">
					<div class="col-md-4"><label>Upload:</label></div>
					<div class="col-md-12">
						<button class="btn btn-success"><span class="glyphicon glyphicon-ok"></span></button>
					</div>
				</div>
				</form>
			</div>
		</div>
	<?php } ?>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
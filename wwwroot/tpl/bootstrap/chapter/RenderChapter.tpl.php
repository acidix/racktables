<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<?php if($this->is('recordCount', 0)) { ?>
			<h3 class="box-title">(no records)</h3>
		<?php } else { ?>
			<h3 class="box-title">Chapter (<?php $this->recordCount; ?> records)</h3>
		<?php } ?>
	</div>
	<div class="box-body no-padding">
		<table class=table >
			<tr><th>Origin</th><th>Key</th><th>Refcnt</th><th>Word</th></tr>
			<?php while($this->loop('ChapterList')) { ?>
				<tr class=row_<?php $this->order; ?>>
					<td>
						<?php if($this->_key < 50000) { ?>
							<i style="color: #3c8dbc" class="fa fa-fw fa-desktop"></i>
						<?php } else { ?>
							<i style="color: #f56954" class="fa fa-fw fa-heart"></i>
						<?php } ?>
					</td>
					<td class=tdright><?php $this->key; ?></td>
					<td>
						<?php if(!$this->is('refcnt', 0)) { ?>
							<?php if($this->is('cfe')) { ?>
								<a href="<?php $this->href; ?>"><?php $this->refcnt; ?></a>
							<?php } ?>
							<?php $this->refcnt ?>
					<?php } ?>
					</td>
					<td><?php $this->value; ?></td>
				</tr>
			<?php } ?>
		</table>
	</div>
</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>

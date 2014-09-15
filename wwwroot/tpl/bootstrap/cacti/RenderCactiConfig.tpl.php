<?php if (defined("RS_TPL")) {?>
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title">Cacti servers (<?php $this->Count; ?>)</h3>
		</div>
		<div class="box-body no-padding">
			<table class=table>
				<tr><th>base URL</th><th>username</th><th>graph(s)</th></tr>
				<?php while($this->loop("ServerAttributes")) { ?>
				<tr align=left valign=top>
					<td><?php $this->BaseUrl; ?></td>
					<td><?php $this->Username; ?></td>
					<td class=tdright><?php $this->NumGraphs; ?></td>
				</tr>
			<?php } ?></table>
		</div>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
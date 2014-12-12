<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Munin servers (<?php $this->ServerCount ?>)</h3>
	</div>
	<div class="box-body">
		<table class="table table-striped">
			<thead>
			<tr><th>base URL</th><th>graph(s)</th></tr>
			</thead>
			<tbody>
			<?php $this->startLoop("allServers"); ?>	
				<tr align=left valign=top><td><?php $this->NiftyStr ?></td>
				<td class=tdright><?php $this->NumGraphs ?></td></tr>
			<?php $this->endLoop(); ?> 
			</tbody>
		</table>
	</div>
</div>

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
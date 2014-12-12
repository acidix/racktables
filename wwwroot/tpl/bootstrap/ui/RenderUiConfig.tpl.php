<?php if (defined("RS_TPL")) {?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Current configuration</h3>
	</div>
	<div class="box-body">
		<table class="table">
			<thead>
				<th>Option</th><th>Value</th>
			</thead>
			<tbody>
				<?php while($this->loop("allLoadConfigCache")){?>	
				<tr>
					<td><?php $this->renderedConfigVarName ?></td>
					<td><?php $this->varvalue ?></td>
				</tr>
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
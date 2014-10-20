<?php if (defined("RS_TPL")) {?>
<div class="box box-solid bg-light-blue">
	<div class="box-header">
		<h3 class="box-title"><?php $this->AttrId ?></h3>
	</div>
</div>
<?php while($this->refLoop('AllSects')) { ?>
	<div class="box">
		<div class="box-header">
			<h3 class="box-title"><?php $this->Title ?></h3>
		</div>
		<div class="box-content no-padding">
			<table class="table">
				<thead>
					<tr><th>Count</th><th>Name</th><th>Asset Tag</th><th>OEM S/N 1</th><th>Date Warranty <br> Expires</th></tr>
				</thead>
				<tbody>
					<?php $this->CountMod ?>
					<?php while($this->refLoop('Expiration_Results')) { ?>
						<tr class=<?php $this->ClassOrder; ?> valign=top>
							<td><?php $this->Count ?> </td>
							<td><?php $this->Mka ?> </td>
							<td><?php $this->AssetNo ?> </td>
							<td><?php $this->OemSn1 ?> </td>
							<td><?php $this->DateValue ?> </td>
						</tr>
					<?php } ?> 
				</tbody>
			</table>
		</div>
	</div>
<?php } ?>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
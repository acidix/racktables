<?php if (defined("RS_TPL")) {?>
	<div class="row">
		<div class="col-md-6"><div class="box box-info" style="position: relative; overflow-x: auto">
			<div class="box-header">
			    <h3 class="box-title">Clusters (<?php $this->countClusters ?>)</h3>
			</div>
			<div class="box-body" style="position: relative">
				<?php if ($this->is("areClusters",true)) { ?>
					<table class="table table-striped" align="center">
					<tr><th>Cluster</th><th>Hypervisors</th><th>Resource Pools</th><th>Cluster VMs</th><th>RP VMs</th><th>Total VMs</th></tr>
					<?php $this->startLoop("clustersArray"); ?>	
						<tr valign=top>
						<td class="tdleft"> <?php $this->mka ?> </td>
						<td class='tdleft'><?php $this->clusterHypervisor ?> </td>
						<td class='tdleft'><?php $this->clusterResPools ?> </td>
						<td class='tdleft'><?php $this->clusterVM ?> </td>
						<td class='tdleft'><?php $this->clusterResPoolVMs ?> </td>
						<td class='tdleft'><?php $this->totatlVMs ?> </td>
						</tr>
					<?php $this->endLoop(); ?> 
					</table>
				<?php } else { ?>
					<b>No clusters exist</b>
				<?php } ?> 
			</div>
		</div></div>

		<div class="col-md-6"><div class="box box-info" style="position: relative; overflow-x: auto">
			<div class="box-header">
			    <h3 class="box-title">Resource Pools (<?php $this->countResPools ?>)</h3>
			</div>
			<div class="box-body" style="position: relative">
				<?php if ($this->is("areResPools",true)) { ?>
					<table class="table table-striped" align="center">
					<tr><th>Pool</th><th>Cluster</th><th>VMs</th></tr>
					<?php $this->startLoop("poolsArray"); ?>	
						<tr valign=top>
						<td class="tdleft"><?php $this->mka ?> </td>
						<td class="tdleft">
						<?php $this->clusterID ?> 
						</td>
						<td class='tdleft'><?php $this->poolVMs ?> </td>
						</tr>
					<?php $this->endLoop(); ?>
					</table> 
				<?php } else { ?>
					<b>No pools exist</b>
				<?php } ?>
			</div>
		</div></div>

	</div> <!-- End row -->
	<div class="row">
		<div class="col-md-6"><div class="box box-info" style="position: relative; overflow-x: auto">
			<div class="box-header">
			    <h3 class="box-title">Hypervisors (<?php $this->hypervisorCount ?>)</h3>
			</div>
			<div class="box-body" style="position: relative">
				<?php if ($this->is("areHypervisors",true)) { ?>
					<table class="table table-striped" align="center">
					<tr><th>Hypervisor</th><th>Cluster</th><th>VMs</th></tr>
					<?php $this->startLoop("hypersArray"); ?>	
						<tr valign=top>
						<td class="tdleft"><?php $this->mka ?> </td>
						<td class="tdleft">
						<?php $this->hyperID ?> 
						</td>
						<td class='tdleft'><?php $this->hyperVMs ?> </td>
						</tr>
					<?php $this->endLoop(); ?>
					</table> 
				<?php } else { ?>
					<b>No hypervisors exist</b>
				<?php } ?>
			</div>
		</div></div>
		<div class="col-md-6"><div class="box box-info" style="position: relative; overflow-x: auto">
			<div class="box-header">
			    <h3 class="box-title">Virtual Switches (<?php $this->countSwitches ?>)</h3>
			</div>
			<div class="box-body" style="position: relative">
				<?php if ($this->is("areSwitches",true)) { ?>
					<table class="table table-striped" align="center">
					<tr><th>Name</th></tr>
					<?php $this->startLoop("switchesArray"); ?>	
						<tr  valign=top>
						<td class="tdleft"><?php $this->mka ?> </td>
						</tr>
					<?php $this->endLoop(); ?>
					</table> 
				<?php } else { ?>
					<b>No virtual switches exist</b>
				<?php } ?>
			</div>
		</div></div>
	</div> <!-- End row -->
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
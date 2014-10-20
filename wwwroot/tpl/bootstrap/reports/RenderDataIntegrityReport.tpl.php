<?php if (defined("RS_TPL")) {?>
	<?php if ($this->is("ChildrenViolation", true)) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">EntityLink: Missing Children (<?php $this->ChildrenCount ?>)</h3>
			</div>
			<div class="box-content no-padding">
				<table class="table">
					<thead>
						<tr><th>Parent</th><th>Child Type</th><th>Child ID</th></tr>
					</thead>
					<tbody>
						<?php while($this->loop("ChildrenOrphans")) { ?>	
							<tr>
								<td><?php $this->RealmName; ?> : <?php $this->ElemName ?></td>
								<td><?php $this->EntityType ?></td>
								<td><?php $this->EntityId ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	<?php } ?> 
	<?php if ($this->is("ParentsViolation", true)) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">EntityLink: Missing Parents (<?php $this->ParentsCount ?>)</h3>
			</div>
			<div class="box-content no-padding">
				<table class="table">
					<thead>
						<tr><th>Child</th><th>Parent Type</th><th>Parent ID</th></tr>
					</thead>
					<tbody>
						<?php while($this->loop("ParentsOrphans")) { ?>	
							<tr>
								<td><?php $this->elemName ?> : <?php $this->parentName ?></td>
								<td><?php $this->entity_type ?></td>
								<td><?php $this->entity_id ?></td>
							</tr>
						<?php } ?> 
					</tbody>
				</table>
			</div>
		</div>
	<?php } ?> 
	<?php if ($this->is("AttrMapViolation", true)) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">AttributeMap: Invalid Mappings (<?php $this->AttrMapCount ?>)</h3>
			</div>
			<div class="box-content no-padding">
				<table class="table">
					<thead>
						<tr><th>Attribute</th><th>Chapter</th><th>Object TypeID</th></tr>
					</thead>
					<tbody>
						<?php while($this->loop("AttrMapOrphans")) { ?>	
							<tr>
								<td><?php $this->AttrName ?></td>
								<td><?php $this->ChapterName ?></td>
								<td><?php $this->ObjtypeId ?></td>
							</tr>
						<?php } ?> 
					</tbody>
				</table>
			</div>
		</div>
	<?php } ?> 	
	<?php if ($this->is("ObjectViolation", true)) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Object Container Compatibility rules: Invalid Parent or Child Type (<?php $this->ObjectCount ?>)</h3>
			</div>
			<div class="box-content no-padding">
				<table class="table">
					<thead>
						<tr><th>ID</th><th>Name</th><th>Type ID</th></tr>
					</thead>
					<tbody>
						<?php while($this->loop("AllObjectsOrphans")) { ?>	
							<tr>
								<td><?php $this->Id ?></td>
								<td><?php $this->Name ?></td>
								<td><?php $this->ObjtypeId ?></td>
							</tr>
						<?php } ?> 
					</tbody>
				</table>
			</div>
		</div>
	<?php } ?> 	
	<?php if ($this->is("ObjectHistViolation", true)) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">ObjectHistory: Invalid Types (<?php $this->ObjectHistCount ?>)</h3>
			</div>
			<div class="box-content no-padding">
				<table class="table">
					<thead>
						<tr><th>ID</th><th>Name</th><th>Type ID</th></tr>
					</thead>
					<tbody>
						<?php while($this->loop("AllObjectHistsOrphans")) { ?>	
							<tr>
								<td><?php $this->Id ?></td>
								<td><?php $this->Name ?></td>
								<td><?php $this->ObjtypeId ?></td>
							</tr>
						<?php } ?> 
					</tbody>
				</table>
			</div>
		</div>
	<?php } ?> 
	<?php if ($this->is("ObjectParViolation", true)) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Port Compatibility rules: Invalid From or To Type (<?php $this->ObjectParCount ?>)</h3>
			</div>
			<div class="box-content no-padding">
				<table class="table">
					<thead>
						<tr><th>From</th><th>From Type ID</th><th>To</th><th>To Type ID</th></tr>
					</thead>
					<tbody>
						<?php while($this->loop("AllObjectParsOrphans")) { ?>	
							<tr>
								<td><?php $this->ParentName ?></td>
								<td><?php $this->ParentObjtypeId ?></td>
								<td><?php $this->ChildName ?></td>
								<td><?php $this->ChildObjtypeId ?></td>
							</tr>
						<?php } ?> 
					</tbody>
				</table>
			</div>
		</div>
	<?php } ?>
	<?php if ($this->is("PortInterViolation", true)) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Enabled Port Types: Invalid Outer Interface (<?php $this->PortInterCount ?>)</h3>
			</div>
			<div class="box-content no-padding">
				<table class="table">
					<thead>
						<tr><th>Inner Interface</th><th>Outer Interface ID</th></tr>
					</thead>
					<tbody>
						<?php while($this->loop("AllPortIntersOrphans")) { ?>	
							<tr>
								<td><?php $this->IifName ?></td>
								<td><?php $this->OifId ?></td>
							</tr>
						<?php } ?> 
					</tbody>
				</table>
			</div>
		</div>
	<?php } ?>
	<?php if ($this->is("ObjectParRuleViolation", true)) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Objects: Violate Object Container Compatibility rules (<?php $this->ObjectParRuleCount ?>)</h3>
			</div>
			<div class="box-content no-padding">
				<table class="table">
					<thead>
						<tr><th>Contained Obj Name</th><th>Contained Obj Type</th><th>Container Obj Name</th><th>Container Obj Type</th></tr>
					</thead>
					<tbody>
						<?php while($this->loop("AllObjectParRulesOrphans")) { ?>	
							<tr>
								<td><?php $this->ChildName ?></td>
								<td><?php $this->ChildType ?></td>
								<td><?php $this->ParentName ?></td>
								<td><?php $this->ParentType ?></td>
							</tr>
						<?php } ?> 
					</tbody>
				</table>
			</div>
		</div>
	<?php } ?>
	<?php if ($this->is("TagStorageViolation", true)) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">TagStorage: Missing Parents (<?php $this->TagStorageCount ?>)</h3>
			</div>
			<div class="box-content no-padding">
				<table class="table">
					<thead>
						<tr><th>Tag</th><th>Parent Type</th><th>Parent ID</th></tr>
					</thead>
					<tbody>
						<?php while($this->loop("AllTagStoragesOrphans")) { ?>	
							<tr>
								<td><?php $this->Tag ?></td>
								<td><?php $this->RealmName ?></td>
								<td><?php $this->EntityId ?></td>
							</tr>
						<?php } ?> 
					</tbody>
				</table>
			</div>
		</div>
	<?php } ?>
	<?php if ($this->is("FileLinkViolation", true)) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">FileLink: Missing Parents (<?php $this->FileLinkCount ?>)</h3>
			</div>
			<div class="box-content no-padding">
				<table class="table">
					<thead>
						<tr><th>File</th><th>Parent Type</th><th>Parent ID</th></tr>
					</thead>
					<tbody>
						<?php while($this->loop("AllFileLinksOrphans")) { ?>	
							<tr>
								<td><?php $this->Name ?></td>
								<td><?php $this->RealmName ?></td>
								<td><?php $this->EntityId ?></td>
							</tr>
						<?php } ?> 
					</tbody>
				</table>
			</div>
		</div>
	<?php } ?>
	<?php if ($this->is("MissingTriggers", true)) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Missing Triggers (<?php $this->MissingTriggers ?>)</h3>
			</div>
			<div class="box-content no-padding">
				<table class="table">
					<thead>
						<tr><th>Table</th><th>Trigger</th></tr>
					</thead>
					<tbody>
						<?php while($this->loop("AllTriggers")) { ?>	
							<tr>
								<td><?php $this->Table ?></td>
								<td><?php $this->Trigger ?></td>
							</tr>
						<?php } ?> 
					</tbody>
				</table>
			</div>
		</div>
	<?php } ?>
	<?php if ($this->is("MissingKeys", true)) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Missing Foreign Keys (<?php $this->MissingKeys ?>)</h3>
			</div>
			<div class="box-content no-padding">
				<table class="table">
					<thead>
						<tr><th>Table</th><th>Key</th></tr>
					</thead>
					<tbody>
						<?php while ($this->loop("AllKeys")) { ?>	
							<tr>
								<td><?php $this->Table ?></td>
								<td><?php $this->FKey ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	<?php } ?>
	<?php if ($this->is("Invalids", true)) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Locations: Tree Contains Circular References (<?php $this->Invalids ?>)</h3>
			</div>
			<div class="box-content no-padding">
				<table class="table">
					<thead>
						<tr><th>Child ID</th><th>Child Location</th><th>Parent ID</th><th>Parent Location</th></tr>
					</thead>
					<tbody>
						<?php while($this->loop("AllInvalids")) { ?>	
							<tr>
								<td><?php $this->Id ?></td>
								<td><?php $this->Name ?></td>
								<td><?php $this->Parent_Id ?></td>
								<td><?php $this->Parent_Name ?></td>
							</tr>
						<?php } ?> 
					</tbody>
				</table>
			</div>
		</div>
	<?php } ?>
	<?php if ($this->is("InvalidObjs", true)) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Locations: Tree Contains Circular References (<?php $this->InvalidObjs ?>)</h3>
			</div>
			<div class="box-content no-padding">
				<table class="table">
					<thead>
						<tr><th>Contained ID</th><th>Contained Object</th><th>Container ID</th><th>Container Object</th></tr>
					</thead>
					<tbody>
						<?php while($this->loop("AllInvalidObjs")) { ?>	
							<tr>
								<td><?php $this->Id ?></td>
								<td><?php $this->Name ?></td>
								<td><?php $this->Parent_Id ?></td>
								<td><?php $this->Parent_Name ?></td>
							</tr>
						<?php } ?> 
					</tbody>
				</table>
			</div>
		</div>
	<?php } ?>
	<?php if ($this->is("InvalidTags", true)) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Locations: Tree Contains Circular References (<?php $this->InvalidTags ?>)</h3>
			</div>
			<div class="box-content no-padding">
				<table class="table">
					<thead>
						<tr><th>Child ID</th><th>Child Tag</th><th>Parent ID</th><th>Parent Tag</th></tr>
					</thead>
					<tbody>
						<?php while($this->loop("AllInvalidTags")) { ?>	
							<tr>
								<td><?php $this->Id ?></td>
								<td><?php $this->Tag ?></td>
								<td><?php $this->Parent_Id ?></td>
								<td><?php $this->Parent_Tag ?></td>
							</tr>
						<?php } ?> 
					</tbody>
				</table>
			</div>
		</div>
	<?php } ?>
	
	<?php if ($this->is("NoViolations",true)) { ?>
		<h2>No integrity violations found</h2>
	<?php } ?> 

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
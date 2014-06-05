<?php if (defined("RS_TPL")) {?>
	<?php if ($this->is("ChildrenViolation", true)) { ?>
		<div class=portlet>
			<h2>EntityLink: Missing Children (<?php $this->ChildrenCount ?>)</h2>
			<table cellpadding=5 cellspacing=0 align=center class=cooltable>
			<tr><th>Parent</th><th>Child Type</th><th>Child ID</th></tr>
			<?php $this->startLoop("ChildrenOrphans"); ?>	
				<tr class=row_<?php $this->Order; ?>>
				<td><?php $this->RealmName; ?> : <?php $this->ElemName ?></td>
				<td><?php $this->EntityType ?> </td>
				<td><?php $this->EntityId ?> </td>
			<?php $this->endLoop(); ?> 
			</table>
		</div>
	<?php } ?> 
	<?php if ($this->is("ParentsViolation", true)) { ?>
		<div class=portlet>
			<h2>EntityLink: Missing Parents (<?php $this->ParentsCount ?>)</h2>
			<table cellpadding=5 cellspacing=0 align=center class=cooltable>
			<tr><th>Child</th><th>Parent Type</th><th>Parent ID</th></tr>
			<?php $this->startLoop("ParentsOrphans"); ?>	
				<tr class=row_<?php $this->order ?>>
				<td><?php $this->elemName ?> : <?php $this->parentName ?></td>
				<td><?php $this->entity_type ?> </td>
				<td><?php $this->entity_id ?> </td>
			<?php $this->endLoop(); ?> 
			</table>
		</div>
	<?php } ?> 
	<?php if ($this->is("AttrMapViolation", true)) { ?>
		<div class=portlet>
			<h2>AttributeMap: Invalid Mappings (<?php $this->AttrMapCount ?>)</h2>
			<table cellpadding=5 cellspacing=0 align=center class=cooltable>
			<tr><th>Attribute</th><th>Chapter</th><th>Object TypeID</th></tr>
			<?php $this->startLoop("AttrMapOrphans"); ?>	
				<tr class=row_<?php $this->Order ?>>
				<td><?php $this->AttrName ?> </td>
				<td><?php $this->ChapterName ?> </td>
				<td><?php $this->ObjtypeId ?> </td>
			<?php $this->endLoop(); ?> 
			</table>
		</div>
	<?php } ?> 	
	<?php if ($this->is("ObjectViolation", true)) { ?>
		<div class=portlet>
			<h2>Object Container Compatibility rules: Invalid Parent or Child Type (<?php $this->ObjectCount ?>)</h2>
			<table cellpadding=5 cellspacing=0 align=center class=cooltable>
			<tr><th>ID</th><th>Name</th><th>Type ID</th></tr>
			<?php $this->startLoop("AllObjectsOrphans"); ?>	
				<tr class=row_<?php $this->Order ?>>
				<td><?php $this->Id ?> </td>
				<td><?php $this->Name ?> </td>
				<td><?php $this->ObjtypeId ?> </td>
			<?php $this->endLoop(); ?> 
			</table>
		</div>
	<?php } ?> 	
	<?php if ($this->is("ObjectHistViolation", true)) { ?>
		<div class=portlet>
			<h2>ObjectHistory: Invalid Types (<?php $this->ObjectHistCount ?>)</h2>
			<table cellpadding=5 cellspacing=0 align=center class=cooltable>
			<tr><th>ID</th><th>Name</th><th>Type ID</th></tr>
			<?php $this->startLoop("AllObjectHistsOrphans"); ?>	
				<tr class=row_<?php $this->Order ?>>
				<td><?php $this->Id ?> </td>
				<td><?php $this->Name ?> </td>
				<td><?php $this->ObjtypeId ?> </td>
			<?php $this->endLoop(); ?> 
			</table>
		</div>
	<?php } ?> 
	<?php if ($this->is("ObjectParViolation", true)) { ?>
		<div class=portlet>
			<h2>Port Compatibility rules: Invalid From or To Type (<?php $this->ObjectParCount ?>)</h2>
			<table cellpadding=5 cellspacing=0 align=center class=cooltable>
			<tr><th>From</th><th>From Type ID</th><th>To</th><th>To Type ID</th></tr>
			<?php $this->startLoop("AllObjectParsOrphans"); ?>	
				<tr class=row_<?php $this->Order ?>>
				<td><?php $this->ParentName ?> </td>
				<td><?php $this->ParentObjtypeId ?> </td>
				<td><?php $this->ChildName ?> </td>
				<td><?php $this->ChildObjtypeId ?> </td>
			<?php $this->endLoop(); ?> 
			</table>
		</div>
	<?php } ?>
	<?php if ($this->is("PortCompatViolation", true)) { ?>
		<div class=portlet>
			<h2>Port Compatibility rules: Invalid From or To Type (<?php $this->PortCompatCount ?>)</h2>
			<table cellpadding=5 cellspacing=0 align=center class=cooltable>
			<tr><th>From</th><th>From Type ID</th><th>To</th><th>To Type ID</th></tr>
			<?php $this->startLoop("AllPortCompsOrphans"); ?>	
				<tr class=row_<?php $this->Order ?>>
				<td><?php $this->Type1Name ?> </td>
				<td><?php $this->Type1 ?> </td>
				<td><?php $this->Type2Name ?> </td>
				<td><?php $this->Type2 ?> </td>
			<?php $this->endLoop(); ?> 
			</table>
		</div>
	<?php } ?>
	<?php if ($this->is("PortInterViolation", true)) { ?>
		<div class=portlet>
			<h2>Enabled Port Types: Invalid Outer Interface (<?php $this->PortInterCount ?>)</h2>
			<table cellpadding=5 cellspacing=0 align=center class=cooltable>
			<tr><th>Inner Interface</th><th>Outer Interface ID</th></tr>
			<?php $this->startLoop("AllPortIntersOrphans"); ?>	
				<tr class=row_<?php $this->Order ?>>
				<td><?php $this->IifName ?> </td>
				<td><?php $this->OifId ?> </td>
			<?php $this->endLoop(); ?> 
			</table>
		</div>
	<?php } ?>
	<?php if ($this->is("ObjectParRuleViolation", true)) { ?>
		<div class=portlet>
			<h2>Objects: Violate Object Container Compatibility rules (<?php $this->ObjectParRuleCount ?>)</h2>
			<table cellpadding=5 cellspacing=0 align=center class=cooltable>
			<tr><th>Contained Obj Name</th><th>Contained Obj Type</th><th>Container Obj Name</th><th>Container Obj Type</th></tr>
			<?php $this->startLoop("AllObjectParRulesOrphans"); ?>	
				<tr class=row_<?php $this->Order ?>>
				<td><?php $this->ChildName ?> </td>
				<td><?php $this->ChildType ?> </td>
				<td><?php $this->ParentName ?> </td>
				<td><?php $this->ParentType ?> </td>
			<?php $this->endLoop(); ?> 
			</table>
		</div>
	<?php } ?>
	<?php if ($this->is("TagStorageViolation", true)) { ?>
		<div class=portlet>
			<h2>TagStorage: Missing Parents (<?php $this->TagStorageCount ?>)</h2>
			<table cellpadding=5 cellspacing=0 align=center class=cooltable>
			<tr><th>Tag</th><th>Parent Type</th><th>Parent ID</th></tr>
			<?php $this->startLoop("AllTagStoragesOrphans"); ?>	
				<tr class=row_<?php $this->Order ?>>
				<td><?php $this->Tag ?> </td>
				<td><?php $this->RealmName ?> </td>
				<td><?php $this->EntityId ?> </td>
			<?php $this->endLoop(); ?> 
			</table>
		</div>
	<?php } ?>
	<?php if ($this->is("FileLinkViolation", true)) { ?>
		<div class=portlet>
			<h2>FileLink: Missing Parents (<?php $this->FileLinkCount ?>)</h2>
			<table cellpadding=5 cellspacing=0 align=center class=cooltable>
			<tr><th>File</th><th>Parent Type</th><th>Parent ID</th></tr>
			<?php $this->startLoop("AllFileLinksOrphans"); ?>	
				<tr class=row_<?php $this->Order ?>>
				<td><?php $this->Name ?> </td>
				<td><?php $this->RealmName ?> </td>
				<td><?php $this->EntityId ?> </td>
			<?php $this->endLoop(); ?> 
			</table>
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
<?php if (defined("RS_TPL")) {?>
		<?php $js = 
<<<JS
function tageditor_showselectbox(e) {
	$(this).load('index.php', {module: 'ajax', ac: 'get-tag-select', tagid: this.id});
	$(this).unbind('mousedown', tageditor_showselectbox);
}
$(document).ready(function () {
	$('select.taglist-popup').bind('mousedown', tageditor_showselectbox);
});			
JS;
?>
		<?php $this->addRequirement("Header","HeaderJsInline",array("code"=>$js));?>
		<?php if($this->is('hasOTags',true)) { ?>
			<div class=portlet>
				<h2>fallen leaves</h2>
				<table cellspacing=0 cellpadding=5 align=center class=widetable>
					<tr class=trerror><th>tag name</th><th>parent tag</th><th>&nbsp;</th></tr>
					<?php $this->Otags; ?>
				</table>
			</div>
		<?php } ?>
			<div class=portlet>
				<h2>tag tree</h2>
				<table cellspacing=0 cellpadding=5 align=center class=widetable>
					<tr><th>&nbsp;</th><th>tag name</th><th>assignable</th><th>parent tag</th><th>&nbsp;</th></tr>
					<?php $this->NewTop; ?>
					<?php $this->Taglist; ?>
					<?php $this->NewBottom; ?>
				</table>
			</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
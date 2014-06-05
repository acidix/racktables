<?php if (defined("RS_TPL")) {?>
	<?php $js = <<<END
	function textifyCellFilter(target, text)
	{
		var portlet = $(target).closest ('.portlet');
		portlet.find ('textarea[name="cfe"]').html (text);
		portlet.find ('input[type="checkbox"]').attr('checked', '');
		portlet.find ('input[type="radio"][value="and"]').attr('checked','true');
	}
END;
	$this->addRequirement("Header","HeaderJsInline",array("code"=>$js));
?>
	<button class="btn btn-default btn-block" onclick="textifyCellFilter(this, '<?php $this->Text; ?>'); return false;">Create text-filter</button><br />
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
<?php if (defined("RS_TPL")) {?>
<?php $js = <<<END
function addToLast ()
{	
	// Copy last line and remove values
	
	// Check for the last line
	if($("tr").length == 2) {
		var first_remv_btn = $("tr").eq(1).find("a").eq(0); 
		first_remv_btn.attr("onclick", "removeLine(0)");
		first_remv_btn.addClass("btn-danger");
		first_remv_btn.removeClass("btn-default");
	}

	var lastLineCont;
	lastLineCont = $(".lastLine").clone().find("input:text").val("").end();
	
	$(".lastLine").removeAttr("onchange");
	var number = parseInt($(".lastLine").attr("count"));
	$(".lastLine").removeClass("lastLine");
	
	$("tr").last().after(lastLineCont);
	updateNumber($("tr").last(), number+1);
	$("tr").last().attr("onchange", "addToLast()");
}

function cloneLine (position) {
	// Clone and update numbers in lines
	
	// Check for the last line
	if($("tr").length == 2) {
		var first_remv_btn = $("tr").eq(1).find("a").eq(0); 
		first_remv_btn.attr("onclick", "removeLine(0)");
		first_remv_btn.addClass("btn-danger");
		first_remv_btn.removeClass("btn-default");
	}

	$("tr[count='" + position + "']").after($("tr[count='" + position + "']").clone());
	var allRows = $("tr");
	
	for(var i = position+1; i < allRows.length; i++) {
		updateNumber(allRows.eq(i), i-1);
	}
}

function removeLine (position) {
	$("tr[count='" + position + "']").remove();
	var allRows = $("tr");
	for(var i = position+1; i < allRows.length; i++) {
		updateNumber(allRows.eq(i), i-1);
	}
	
	// Check for the last line
	if(allRows.length == 2) {
		allRows.eq(1).find("a").eq(0).removeAttr("onclick");
		allRows.eq(1).find("a").eq(0).removeClass("btn-danger");
		allRows.eq(1).find("a").eq(0).addClass("btn-default");
	}
}


function updateNumber (table_row, number) {
	// Find all input fields and update reference
	table_row.attr("count", number);
	table_row.children().first().attr("name", number + "_object_type");

	var inputfields = table_row.find("input");
	inputfields[0].name = number + "_object_name";
	inputfields[1].name = number + "_object_label";
	inputfields[2].name = number + "_object_asset_no";

	var buttonfields = table_row.find("a");
	buttonfields[0].name = number + "_btn_remove";
	buttonfields.eq(0).attr("onclick", "removeLine(" + number + ")");
	buttonfields[1].name = number + "_btn_clone";
	buttonfields.eq(1).attr("onclick", "cloneLine(" + number + ")");
}


	// Init on load 
$(function () {
	$("tr").last().addClass("lastLine");
	$(".lastLine").attr("onchange", "addToLast()");
});
END;
	$this->addRequirement("Header","HeaderJsInline",array("code"=>$js));
?>
<div class="box box-primary">
	<?php $this->getH('PrintOpFormIntro','addMultipleObjectDynamically')?>
	<input type="hidden" name="rowcount" value="<?php $this->rowCountDefault; ?>">
	<div class="box-header">
		<h3 class="box-title">Add objects</h3>
	</div>
	<div class="box-body no-padding">
		<table class="table">
			<thead>
				<tr>
					<th>Type</th>
					<th>Common name</th>
					<th>Visible label</th>
					<th>Asset tag</th>
					<th>Tags</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php while($this->loop('AddTable')) { ?>
				<tr count="<?php $this->i ?>" >
					<td><?php $this->getH('PrintSelect',array($this->_Types,array('name'=>$this->_i . '_object_type','class'=>'form-control'))); ?></td>
					<td><input type=text size=30 name=<?php $this->i ?>_object_name ></td>
					<td><input type=text size=30 name=<?php $this->i ?>_object_label ></td>
					<td><input type=text size=20 name=<?php $this->i ?>_object_asset_no ></td>
					<td><?php $this->TagsPicker; ?></td>
					<td>
						<div class="btn-group">
							<a class="btn btn-danger" name="<?php $this->i ?>_btn_remove" title="Remove this line" onclick="removeLine(<?php $this->i ?>)"><span class="glyphicon glyphicon-remove"></span></a>
							<a class="btn btn-primary" name="<?php $this->i ?>_btn_clone" title="Clone this line" onclick="cloneLine(<?php $this->i ?>)"><span class="glyphicon glyphicon-plus"></span></a>
						</div>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="box-footer">
		<button class="btn btn-success btn-block" submit>Submit</button>
	</div>
	</form>
</div>
<!-- 
<div class=portlet>
	<h2>Distinct types, same tags</h2>
	<?php $this->formIntro ?> 
	<table border=0 align=center>
	<tr><th>Object type</th><th>Common name</th><th>Visible label</th>
	<th>Asset tag</th><th>Tags</th></tr>
	<?php $this->startLoop("objectListData"); ?>	
		<tr><td>
		<?php $this->niftySelect ?>
		</td>
		<td><input type=text size=30 name=<?php $this->i ?>_object_name tabindex=<?php $this->tabindex ?> ></td>
		<td><input type=text size=30 name=<?php $this->i ?>_object_label tabindex=<?php $this->tabindex ?> ></td>
		<td><input type=text size=20 name=<?php $this->i ?>_object_asset_no tabindex=<?php $this->tabindex ?> ></td>
		<td valign=top rowspan=<?php $this->max ?> >
		<?php $this->tagsPicker ?> 
		</td>
	<?php $this->endLoop(); ?> 
	<tr><td class=submit colspan=5><input type=submit name=got_fast_data value='Go!'></td></tr>
	</form></table>
</div>

<div class=portlet>
	<h2>Same type, same tags</h2>
	<?php $this->formIntroLotOfObjects ?>
	<table border=0 align=center><tr><th>names</th><th>type</th></tr>
	<tr><td rowspan=3><textarea name=namelist cols=40 rows=25>
	</textarea></td><td valign=top>
	<?php $this->test ?> 
	<?php $this->get("sameTypeSameTagSelect"); ?> 
	</td></tr>
	<tr><th>Tags</th></tr>
	<tr><td valign=top>
		<?php $this->tagsPicker ?> 
	</td></tr>
	<tr><td colspan=2><input type=submit name=got_very_fast_data value='Go!'></td></tr></table>
	</form>
	</div>	
</div>
 -->
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
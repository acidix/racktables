// Init on load 
$(function () {
	$(".lineeditor-table > tbody > tr").last().addClass("lastLine");
	$(".lastLine").attr("onchange", "addToLast()");
});

function addToLast () {	
	// Copy last line and remove values
	
	// Check for the last line
	if($(".lineeditor-table > tbody > tr").length == 1) {
		var first_remv_btn = $(".lineeditor-table > tbody > tr").eq(0).find("a").eq(0); 
		first_remv_btn.attr("onclick", "removeLine(0)");
		first_remv_btn.addClass("btn-danger");
		first_remv_btn.removeClass("btn-default");
	}

	var lastLineCont;
	lastLineCont = $(".lastLine").clone().find("input:text").val("").end();
	
	$(".lastLine").removeAttr("onchange");
	var number = parseInt($(".lastLine").attr("count"));
	$(".lastLine").removeClass("lastLine");
	
	$(".lineeditor-table > tbody > tr").last().after(lastLineCont);
	updateNumber($(".lineeditor-table > tbody > tr").last(), number+1);
	$(".lineeditor-table > tbody > tr").last().attr("onchange", "addToLast()");
}

function cloneLine (position) {
	// Clone and update numbers in lines
	console.log('pos:',position);	
	// Check for the last line
	if($(".lineeditor-table > tbody > tr").length == 1) {
		var first_remv_btn = $(".lineeditor-table > tbody > tr").eq(0).find("a").eq(0); 
		first_remv_btn.attr("onclick", "removeLine(0)");
		first_remv_btn.addClass("btn-danger");
		first_remv_btn.removeClass("btn-default");
	}

	$(".lineeditor-table > tbody > tr[count='" + position + "']").after($("tr[count='" + position + "']").clone());
	
	var allRows = $(".lineeditor-table > tbody > tr");
	
	for(var i = position; i < allRows.length; i++) {
		updateNumber(allRows.eq(i), i);
	}
	$(".lineeditor-table > tbody > tr[count='" + (position + 1) + "'] > td > .select2-container").remove();
}

function removeLine (position) {
	if(position == 0) {
		var tagsSelector = $(".lineeditor-table > tbody > tr[count='0'] > td").eq(4).clone();
	}

	$(".lineeditor-table > tbody > tr[count='" + position + "']").remove();
	var allRows = $(".lineeditor-table > tbody > tr");
	for(var i = position; i < allRows.length; i++) {
		updateNumber(allRows.eq(i), i);
	}

	if(position == 0) {
		$(".lineeditor-table > tbody > tr[count='0'] > td").eq(4).append("<input class='ui-autocomplete-input tagspicker'/>");
		prepareContent($(".lineeditor-table > tbody > tr[count='0']> td").eq(4));
	//	$(".lineeditor-table > tbody > tr[count='0'] > td").eq(4).html(tagsSelector);
	}
	
	// Check for the last line
	if(allRows.length == 1) {
		allRows.eq(0).find("a").eq(0).removeAttr("onclick");
		allRows.eq(0).find("a").eq(0).removeClass("btn-danger");
		allRows.eq(0).find("a").eq(0).addClass("btn-default");
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

	// Ensure last line
	table_row.removeAttr("onchange");
	table_row.removeClass("lastLine");
	
	if(number == $(".lineeditor-table > tbody > tr").length - 1) {
		table_row.addClass('lastLine');
		table_row.attr("onchange", "addToLast()");
	}
}

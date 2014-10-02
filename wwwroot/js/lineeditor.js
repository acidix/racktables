// Init on load 
$(function () {
	$("tr").last().addClass("lastLine");
	$(".lastLine").attr("onchange", "addToLast()");
});

function addToLast () {	
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

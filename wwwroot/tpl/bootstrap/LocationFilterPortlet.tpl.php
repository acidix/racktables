<?php if (defined("RS_TPL")) {?>
<?php $js = <<<END
function checkAll(bx) {
	for (var tbls=document.getElementsByTagName("table"), i=tbls.length; i--;)
		if (tbls[i].id == "locationFilter") {
			var bxs=tbls[i].getElementsByTagName("input");
			var in_tree = false;
			for (var j=0; j<bxs.length; j++) {
				if(in_tree == false && bxs[j].value == bx.value)
					in_tree = true;
				else if(parseInt(bxs[j].className) <= parseInt(bx.className))
					in_tree = false;
				if (bxs[j].type=="checkbox" && in_tree == true)
					bxs[j].checked = bx.checked;
			}
		}
}

function collapseAll(bx) {
	for (var tbls=document.getElementsByTagName("table"), i=tbls.length; i--;)
		if (tbls[i].id == "locationFilter") {
			var bxs=tbls[i].getElementsByTagName("div");
			//loop through divs to hide unchecked
			for (var j=0; j<bxs.length; j++) {
				var is_checked = -1;
				var in_div=bxs[j].getElementsByTagName("input");
				//loop through input to find if any is checked
				for (var k=0; k<in_div.length; k++) {
					if(in_div[k].type="checkbox") {
						if (in_div[k].checked == true) {
							is_checked = true;
							break;
						}
						else
							is_checked = false;
					}
				}
				// nothing selected and element id is lfd, collapse it
				if (is_checked == false && !bxs[j].id.indexOf("lfd"))
					expand(bxs[j].id.substr(3));
			}
		}
}

function expand(id) {
	var divid = document.getElementById("lfd" + id);
	var iconid = document.getElementById("lfa" + id);
	if (divid.style.display == 'none') {
		divid.style.display = 'block';
		iconid.innerHTML = ' - ';
	} else {
		divid.style.display = 'none';
		iconid.innerHTML = ' + ';
	}
}
END;
	$this->addRequirement("Header","HeaderJsInline",array("code"=>$js));
?>
<form method=post>
	<div class="panel panel-default">
		<div class="panel-heading">Location filter</div>
		
		<div class="panel-content">
		<ul class="list-group" id="locationFilter">
    		<input type=hidden name=page value=rackspace>
    		<input type=hidden name=tab value=default>
    		<input type=hidden name=changeLocationFilter value=true>
    		<?php if($this->is("LocationsExist",true)) { ?>
    			<li class="list-group-item">
    					<label>
						<input type=checkbox name='location'  onClick=checkAll(this)> Toggle all
						<img src=pix/1x1t.gif onLoad=collapseAll(this)>
						</label>
				</li>
				<li class="list-group-item">
						<?php $this->Locations; ?>
				</li>
    		<?php } ?>
    		<?php if ($this->is("LocationsExist",false)) { ?>
 				<li class="list-group-item">(no locations exist)</li>
    		<?php } ?>
		</ul>
		</div>
		<div class="panel-footer">
		<?php if ($this->is("LocationsExist",true)) { ?>
			<button type="submit" class="btn btn-primary" name="submit">Set filter</button>
		<?php } else { ?>
			<button type="submit" class="btn btn-primary" name="submit" disabled="disabled">Set filter</button>
		<?php } ?>
		</div>
	</div>	
</form>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
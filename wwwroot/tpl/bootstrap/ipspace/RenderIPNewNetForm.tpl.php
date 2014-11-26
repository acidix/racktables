<?php if (defined("RS_TPL")) {?>
	<?php $this->addRequirement("Header","HeaderJsInclude",array("path"=>"js/live_validation.js")); ?>
	<?php
		$myregexp = $this->_Regexp ; 
		$this->addRequirement("Header","HeaderJsInline",array("code"=>"$(document).ready(function () {
			$('form#add input[name=\"range\"]').attr('match', '${myregexp}');
			$('form#add input[name=\"range\"]').inputmask();
			Validate.init();
		});"));  ?>
	<div class="add-box box box-success">
	    <div class="box-header">
	    </div>
	    <div class="box-body">
	       	<form method="post" id="add" name="add" action="?module=redirect&amp;page=<?php $this->Page ?>&amp;tab=newrange&amp;op=add">
	       	<table border=0 cellpadding=5 cellspacing=0 align=center>
			<tr><td rowspan=5>
			</td>
			<th class=tdright>Prefix</th><td class=tdleft>
			<!-- <input type=text name='range' size=36 class='live-validate' autofocus tabindex=1 value='<?php $this->Prefix_value ?>'> -->
			<?php if ($this->is('Page', 'ipv6space')) { ?>
				<input data-inputmask-regex='9{1,3}.9{1,3}.9{1,3}.9{1,3}/9{1,3}' title="Please enter valid ipv6 address" data-placement="right" class='live-validate' type=text name='range' size=36 autofocus tabindex=1 value='<?php $this->Prefix_value ?>'>		
			<?php } else { ?>
				<input data-inputmask="'mask': '999.999.999.999/99'" title="Please enter valid ipv4 address" data-placement="right" class='live-validate' type=text name='range' size=36 autofocus tabindex=1 value='<?php $this->Prefix_value ?>'>
			<?php } ?> 
			<i class="fa fa-fw fa-question-circle pull-right"></i><i class="fa fa-fw fa-check-circle pull-right"></i></td>
			<tr><th class=tdright>VLAN</th><td class=tdleft>
			<?php $this->optionTree ?><tr>
			<th class=tdright>Name:</th><td class=tdleft><input type=text name='name' size='20' tabindex=3></td></tr>
			<tr><th class=tdright>Tags:</th><td class="tdleft">
			<?php $this->TagsPicker ?>
			</td></tr>
			<tr><th class=tdright><input type=checkbox name="is_connected" tabindex=4></th><th class=tdleft>reserve subnet-router anycast address</th></tr>
			</table>
			<div style="text-align: center">
				<button class="btn btn-success ajax_form" targetform="#add">Add new</button>
				<button class="btn btn-default" type=button onclick="clearForm( add );"><span class="glyphicon glyphicon-refresh"></span></button>
			</div>
			</form>
        </div><!-- /.box-body -->
	</div>	
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
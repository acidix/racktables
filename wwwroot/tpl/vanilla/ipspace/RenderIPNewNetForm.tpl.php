<?php if (defined("RS_TPL")) {?>
	<?php $this->addRequirement("Header","HeaderJsInclude",array("path"=>"js/live_validation.js")); ?>
	<?php $this->addRequirement("Header","HeaderJsInline",array("code"=>"<<<END
		$(document).ready(function () {
			$('form#add' input[name='range']).attr('match', '$regexp');
			Validate.init();
		});
		END")); ?>
	<div class=portlet>
		<h2>Add new</h2>
		<table border=0 cellpadding=10 align=center>
		<?php $this->getH("PrintOpFormIntro", array('add')); ?>
		<tr><td rowspan=5><h3>assign tags</h3>
		<?php $this->rendNewEntityTags ?>
		</td>
		<th class=tdright>prefix</th><td class=tdleft><input type=text name='range' size=36 class='live-validate' tabindex=1 value='<?php $this->prefix_value ?>'></td>
		<tr><th class=tdright>VLAN</th><td class=tdleft>
		<?php $this->optionTree ?>	
		<tr><th class=tdright>name</th><td class=tdleft><input type=text name='name' size='20' tabindex=3></td></tr>
		<tr><td class=tdright><input type=checkbox name="is_connected" id="is_connected" tabindex=4></td>
		<th class=tdleft><label for="is_connected">reserve subnet-router anycast address</label></th></tr>
		<tr><td colspan=2>
		<?php $this->getH("PrintImageHref", array('CREATE', 'Add a new network', TRUE, 5)); ?>
		</td></tr>
		</form></table><br><br>
	</div>	
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
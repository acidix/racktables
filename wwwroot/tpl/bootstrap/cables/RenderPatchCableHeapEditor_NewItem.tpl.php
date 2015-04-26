<?php if (defined("RS_TPL")) {?>
	<?php $this->getH("PrintOpFormIntro", array('add')); ?>
	<tr>
	<td>&nbsp;</td>
	<td><?php $this->Connector1Opt ?></td>
	<td><?php $this->TypeOpt ?></td>
	<td><?php $this->Connector2Opt ?></td>
	<td><input type=text size=6 name=length value="1.00" tabindex=140></td>
	<td><input type=text size=48 name=description tabindex=150></td>
	<td><button type=submit class="btn btn-primary" tabindex="200" title="create new"><span class="glyphicon glyphicon-plus"></span></button></td>
	</tr></form>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>

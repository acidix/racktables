<?php if (defined("RS_TPL")) {?> 

<div class="box box-primary">
	<div class="box-body">
	<table align=center class="table table-striped">
		<tr valign=top><th class=tdleft>Object</th><th class=tdleft>Date/user</th>
		<th style="text-align: center"><span class='glyphicon glyphicon glyphicon-file'></span></th></tr>	
		<?php while( $this->loop("LogTableData") ) { ?>
		<tr class=row_<?php $this->order ?> valign=top>
			<td class=tdleft><?php $this->get("Object_id"); ?></td>
			<td class=tdleft><?php $this->get("User"); ?><br><?php $this->get("Date"); ?> </td>
			<td class="logentry"> <?php $this->get("Logentry"); ?></td>
		</tr>
		<?php } ?>
	</table>
	</div>
</div>	

<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
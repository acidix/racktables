<?php if (defined("RS_TPL")) {?>
	<?php $this->getH("Form","upd"); ?>
	<input type="hidden" name="id" value="<?php $this->Id; ?>">
	<tr>
		<td>y
			<?php if($this->is("NumGraphs",true)) { ?>
				<img width="16" border="0" height="16" title="cannot delete, graphs exist" src="?module=chrome&uri=pix/tango-user-trash-16x16-gray.png"></img>
			<?php } else { ?>
				<a title="delete this server" href="?module=redirect&op=del&id=3&page=cacti&tab=servers">
    				<img width="16" border="0" height="16" title="delete this server" src="?module=chrome&uri=pix/tango-user-trash-16x16.png"></img>
				</a>
			<?php }?>
			</td>
			<td><input type=text size=48 name=base_url value="<?php $this->BaseUrl; ?>"></td>
			<td><input type=text size=24 name=username value="<?php $this->Username; ?>"></td>
			<td><input type=password size=24 name=password value="<?php $this->Password; ?>"></td>
			<td class=tdright><?php $this->NumGraphs; ?></td>
			<td></td>
		</tr>
	</form>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
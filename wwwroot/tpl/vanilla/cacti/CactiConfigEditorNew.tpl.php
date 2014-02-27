<?php if (defined("RS_TPL")) {?>
		<?php $this->getH("Form","add"); ?>
		<tr>
			<td><input class="icon" type="image" border="0" title="add a new server" tabindex="112" src="?module=chrome&uri=pix/tango-document-new.png" name="submit"></input></td>
			<td><input type=text size=48 name=base_url tabindex=101></td>
			<td><input type=text size=24 name=username tabindex=102></td>
			<td><input type=password size=24 name=password tabindex=103></td>
			<td>&nbsp;</td>
			<td><input class="icon" type="image" border="0" title="add a new server" tabindex="112" src="?module=chrome&uri=pix/tango-document-new.png" name="submit"></input></td>
		</tr>
		</form>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
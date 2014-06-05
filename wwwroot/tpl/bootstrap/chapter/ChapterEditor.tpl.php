<?php if (defined("RS_TPL")) {?>
<br><table class=cooltable border=0 cellpadding=5 cellspacing=0 align=center>

<tr><th>Origin</th><th>Key</th><th>&nbsp;</th><th>Word</th><th>&nbsp;</th></tr>

<?php $this->NewTop;
	  $this->merge;
	  $this->NewBottom; ?>
	  
	  </table>



<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
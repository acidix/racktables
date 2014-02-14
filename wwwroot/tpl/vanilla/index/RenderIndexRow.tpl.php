<?php if (defined("RS_TPL")) {?>

	<?php $this->startLoop("singleRowCont"); ?>	
		<?php if ($this->is("isNull",true)) { ?>
			 <td>&nbsp;</td>
		<?php } else {?>
			<?php if ($this->is("permitted", true)) { ?>
				<td>&nbsp;</td>
			<?php } else { ?>
				<td>
				<h1><a href='<?php $this->href ?>'> <?php $this->pageName ?> <br>
				<?php $this->image ?> </a></h1> 
				</td> 
			<?php } ?>
		<?php } ?> 
	<?php $this->endLoop(); ?> 
	
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
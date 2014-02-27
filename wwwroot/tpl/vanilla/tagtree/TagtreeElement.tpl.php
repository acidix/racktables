<?php if (defined("RS_TPL")) {?>
	<tr <?php if($this->is('assignable',false)) { ?>
			<?php if ($this->is('hasChildren',true)) { ?>
				class=trnull
			<?php } else { ?>
				class=trwarning
			<?php } ?>
		<?php } ?>
	>
	<td align=left style='padding-left: " <?php $this->Level; ?> "px;'>
	<?php if ($this->is('hasChildren')) { ?>
		<img width="16" border="0" height="16" src="?module=chrome&uri=pix/node-expanded-static.png"></img>
	<?php } ?>
	<span title="<?php $this->Stats; ?>" class="<?php $this->Spanclass; ?>">
		<?php $this->Tag; ?>
		<i> <?php $this->Refc; ?></i>
	</span>
	</td>
	</tr>
	<?php $this->Taglist; ?>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
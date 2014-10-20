<?php if (defined("RS_TPL")) {?>
<center>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Tag tree</h3>
	</div>
	<div class="box-content">
		<table class=tagtree>
		<?php while($this->loop('Taglist')) : ?>
			<tr class='<?php $this->Trclass ?>'>
			<td align=left style='padding-left:<?php echo ($this->_Level * 16); ?>px;'>
				<?php if ($this->is('HasChildren',true)) { ?>
					<img width="16" border="0" height="16" src="?module=chrome&uri=pix/node-expanded-static.png"></img>
				<?php } ?>
				<span title="<?php $this->Stats; ?>" class="<?php $this->SpanClass; ?>">
					<?php $this->Tag; ?>
					<?php if (!$this->is('Refc', '')) { ?>
						<i>(<?php $this->Refc; ?>)</i>
					<?php } ?> 
				</span>
			</td>
			</tr>
		<?php endwhile ?>
		</table>
	</div>
</div>
</center>		
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>